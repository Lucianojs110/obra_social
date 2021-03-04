<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vendor\afipsdk\src\Afip;
/* use App\Lib\BarcodeI25; */
use App\Certificados;
use App\User;
use App\Beneficiario;
use App\Prestador;
use App\Prestacion;
use App\ObraSocial;
use App\Traditum;
use App\Sesion;
use App\Feriado;
use App\Helpers\OSUtil;
use Carbon\Carbon;


use Auth;

/* use App\OSUtil; */

use Illuminate\Support\Facades\Storage;
use DB;
/* use Illuminate\Support\Facades\DB; */

use SimpleXMLElement;
use DateTime;  

class FacturacionController extends Controller
{
    public function index(){

        // Declaro objeto de usuario
    	/* $user = \Auth::user()->id;
        $uss = \Auth::user();

    	// Objeto Menu prestador
        $prestador_menu = \DB::select("SELECT obrasocial.nombre, obrasocial.id FROM obrasocial LEFT JOIN prestador on prestador.os_id = obrasocial.id WHERE prestador.user_id = " . $user . " GROUP BY obrasocial.id, obrasocial.nombre");
        
        $certs = Certificados::with('users')->where('id_user', \Auth::user()->id)->get();


        /* dd($certs); */
        /* return view('facturacion-electronica.index',['prestador_menu' => $prestador_menu , 'certs' => $certs]);  */
    }

    public function createCert(){


        $user = \Auth::user()->id;
        $prestador_menu = \DB::select("SELECT obrasocial.nombre, obrasocial.id FROM obrasocial LEFT JOIN prestador on prestador.os_id = obrasocial.id WHERE prestador.user_id = " . $user . " GROUP BY obrasocial.id, obrasocial.nombre");
        $cadena_cuit = \Auth::user()->cuit;
        $cuit = str_replace("-","",$cadena_cuit);

        return view('facturacion-electronica.create',['prestador_menu' => $prestador_menu]);
    }

    public function storeCert(Request $request){

        
        $user = \Auth::user()->id;
        $prestador_menu = \DB::select("SELECT obrasocial.nombre, obrasocial.id FROM obrasocial LEFT JOIN prestador on prestador.os_id = obrasocial.id WHERE prestador.user_id = " . $user . " GROUP BY obrasocial.id, obrasocial.nombre");


        $file1 = $request->file('archivokey');
        $file2 = $request->file('archivocrt');

       /*  dd($file1,$file2); */
        /* dd($request->all()); */

        
        if($file1 != null && $file2 != null)
        {
            
            $filename1 = $file1->getClientOriginalName();
            $filename2 = $file2->getClientOriginalName();

            //guardamos
            Storage::disk('public')->put(\Auth::user()->id . '/' ./*  \Auth::user()->id . '_' . */ $request['pto_venta']. '_' . $filename1,  \File::get($file1));
            Storage::disk('public')->put(\Auth::user()->id . '/' . /* \Auth::user()->id . '_' .  */ $request['pto_venta']. '_' . $filename2,  \File::get($file2));
        }
        else
        {
            dd('uno de los arhivos esta vacio , revise de subir ambos correspondientemente');
        }
        
        $cert = new Certificados();

        $cert->fill([
            
            
            'certkey' => $filename1,
            'certcrt' => $filename2,
            'ptovta' => $request['pto_venta'],
            'id_user' => $request['id_user'],

        ]);
        $cert->save();


        $certs = Certificados::with('users')->where('id_user', \Auth::user()->id)->get();

        return view('facturacion-electronica.index',['prestador_menu' => $prestador_menu, 'certs' => $certs]);
    }


    public function facturaelectronica(){

        $obj = Certificados::with('users')->where('id_user', \Auth::user()->id)->first();
        $punto_v = $obj->ptovta;
        $filekey = $obj->certkey;
        $filecrt = $obj->certcrt;
       
        $options = [ //options es un array con el CUIT (de la empresa que esta vendiendo)
            'CUIT' => 20355003192,
            'production' => True,
           
            'cert' => '/'.\Auth::user()->id. '/'.$punto_v .'_'.$filecrt,
            'key' => '/'.\Auth::user()->id. '/'.$punto_v .'_'.$filekey,
           
            ];

            $afip = new Afip($options);
            $voucher_types = $afip->ElectronicBilling->GetVoucherTypes();
            dd($voucher_types);

            $inscription = $afip->RegisterInscriptionProof->GetTaxpayerDetails('30519536435');
         
    }


    public function indexfactura( $prest_id, $os_id, $mes = null, $anio = null){

        $user = \Auth::user()->id;
    
            if($mes == null){

                $mes = date('m');           
            }

            if($anio == null){

                $anio = date('Y');           
            }

        // Objeto Menu prestador

        $prestador_menu = \DB::select("SELECT obrasocial.nombre, obrasocial.id FROM obrasocial LEFT JOIN prestador on prestador.os_id = obrasocial.id WHERE prestador.user_id = " . $user . " GROUP BY obrasocial.id, obrasocial.nombre");



        // Objeto prestaciones

        $os_id = '2'; //Apross
        $prestacion = Prestador::where('user_id', $user)
            ->where('os_id', $os_id)
            ->with('prestacion')
            ->get();


         // Traigo beneficiarios segun prestador y obra social

        $os_id = '2'; //Apross
        $beneficiarios = Prestador::where('user_id', $user)
            ->where('os_id', $os_id)
            ->with('prestacion', 'beneficiario.inasistencia', 'beneficiario.agregado', 'beneficiario.sesion')
            ->orderBy('id', 'desc')
            ->get();


       $fechas = array();
       $traditums = array();

      foreach($beneficiarios as $beneficiario){

          foreach($beneficiario->beneficiario as $k => $benef){

             $traditums[$benef->id] = Traditum::where('beneficiario_id', $benef->id)->where('mes', \Auth::user()->mes)->get()->toArray();

                 if(empty($traditums[$benef->id])){

                $traditums[$benef->id][0]['codigo'] = null;

                $traditums[$benef->id][0]['id'] = null;

                    }

        // Sesiones

        $inasistencias = $benef->inasistencia;

        $adicionales = $benef->agregado;

        $sesiones = $benef->sesion;

        $cant_solicitada = $benef->tope;

        $totalDias = count($sesiones);

        $fechas['total'][$benef->id] = OSUtil::cuenta_dias($mes, $anio, $sesiones, $cant_solicitada);

        $fechas['inasistencias'][$benef->id] = OSUtil::cuenta_inasistencias($mes, $anio, $sesiones, $inasistencias);

        $fechas['agregado'][$benef->id] = OSUtil::cuenta_agregado($mes, $anio, $sesiones, $adicionales);

        $fechas['total_agregado'][$benef->id] = count($benef->agregado);

      }

     }

        // Objeto Obra Social

        $obraSocial = ObraSocial::where('id', $os_id)->get();
        $data['beneficiarios'] = $beneficiarios;
        $data['obrasocial'] = $obraSocial;
        $data['prestador_menu'] = $prestador_menu;
        $data['prestacion'] = $prestacion;
        $data['traditums'] = $traditums;
        $data['fechas'] = $fechas;
        $certs = Certificados::with('users')->where('id_user', \Auth::user()->id)->get();
 
       // Obtenemos la fecha del usuario ¿que onda esto?
        $user = \Auth::user();

        $d2 = new DateTime();
        $d2->modify('-1 month');
        $mes_anterior = $d2->format('m');
        $anio_anterior = $d2->format('Y');
     
    
        $qss = DB::table('prestacion')->where('activo', 1)
                    ->join('prestador','prestador.prestacion_id','=','prestacion.id')
                    ->join('users','users.id','=','prestador.user_id')
                    ->join('beneficiario', 'beneficiario.prestador_id','=' , 'prestador.id')
                    ->whereMonth('prestador.created_at', '=', $mes_anterior)
                    ->whereYear('prestador.created_at', '=', $anio_anterior)
                    ->groupBy('prestacion.id')
                    ->select(DB::raw('SUM(beneficiario.cantidad_solicitada) as cantidad, SUM(prestacion.valor_modulo) as valortotal'),'prestacion.*','prestador.*','beneficiario.*')
                    ->get();
        /* dd($qss); */

        //$fecha = new DateTime();
        //$fecha->modify('first day of this month');
        //$fechainicio =  $fecha->format('d/m/Y'); // imprime por ejemplo: 01/12/2012
    
      
        return view('facturacion-electronica.caeprueba',['data' => $data , 'qss' => $qss ,'user'=> $user, 'certs' => $certs ]);
    }

    public function consultarcuit(Request $request){

        

        $obj = Certificados::with('users')->where('id_user', \Auth::user()->id)->first();
        $punto_v = $obj->ptovta;
        $filekey = $obj->certkey;
        $filecrt = $obj->certcrt;
        
        $options = [                    //options es un array con el CUIT (de la empresa que esta vendiendo)
            'CUIT' => 20355003192,
            'production' => True,
            'cert' => '/'.\Auth::user()->id. '/'.$punto_v .'_'.$filecrt,
            'key' => '/'.\Auth::user()->id. '/'.$punto_v .'_'.$filekey,
           
            ];

            $afip = new Afip($options);
            $voucher_types = $afip->ElectronicBilling->GetVoucherTypes();

            $cuit_cliente_osecac = $request->input('cuit');


            /* $aspross_cuit = 30999253675; */

            $inscription = $afip->RegisterInscriptionProof->GetTaxpayerDetails($cuit_cliente_osecac);
            

           // dd($inscription);
            
        
    }


   public function caesolicitud(Request $request){

         $tc = 0; 
        $data = [];

        $obj = Certificados::with('users')->where('id_user', \Auth::user()->id)->first();
    
         $punto_v = $obj->ptovta;
         $filekey = $obj->certkey;
         $filecrt = $obj->certcrt;
       
         //esta consulta me devuelve los 14 registros de las prestaciones
         $qs = DB::table('prestacion')->where('activo', 1)
        ->join('prestador','prestador.prestacion_id','=','prestacion.id')
        /* ->join('obrasocial','obrasocial.id','=', 'prestador.os_id') */
        ->join('users','users.id','=','prestador.user_id')
        ->join('beneficiario', 'beneficiario.prestador_id','=' , 'prestador.id')
        ->get();

        $user_id=\Auth::user()->id;
        /* $cuit_cliente_osecac = $request->input('cuit'); */
        $cuit_cliente = request('cuit_obrasocial');

        $tipo_comprob = 'Factura C';

            
            $options = [                    //options es un array con el CUIT (de la empresa que esta vendiendo)
                'CUIT' => 20298464072,
                'production' => True,
                'cert' => '/'.\Auth::user()->id. '/'.$punto_v .'_'.$filecrt,
                'key' => '/'.\Auth::user()->id. '/'.$punto_v .'_'.$filekey,
                ];
            
                
        if($tipo_comprob == 'Factura C'){
            //ctes para probar
            $ImpTotal = 1;
            $afip = new Afip($options);
            $last_voucher = $afip->ElectronicBilling->GetLastVoucher($punto_v, 6);
            dd($last_voucher);
            $numComp = $last_voucher + 1;
            
            
            $ImpNeto = $ImpTotal/1.21;
            $ImpNeto = number_format((float)$ImpNeto, 2, '.', '');
            $ImpIVA = $ImpTotal - $ImpNeto;
            $ImpIVA = number_format((float)$ImpIVA, 2, '.', '');
            
       


            $date = Carbon::now('America/Argentina/Buenos_Aires');
            $date2 = $date->format('Ymd');

            $data = array(
                'CantReg' 	=> 1,  // Cantidad de comprobantes a registrar
                'PtoVta' 	=> 2,  // Punto de venta
                'CbteTipo' 	=> 11,  // Tipo de comprobante (ver tipos disponibles) 
                'Concepto' 	=> 1,  // Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
                'DocTipo' 	=> 99, // Tipo de documento del comprador (99 consumidor final, ver tipos disponibles)
                'DocNro' 	=> 0,  // Número de documento del comprador (0 consumidor final)
                'CbteDesde' 	=> $numComp,  // Número de comprobante o numero del primer comprobante en caso de ser mas de uno
                'CbteHasta' 	=> $numComp,  // Número de comprobante o numero del último comprobante en caso de ser mas de uno
                'CbteFch' 		=> intval($date2), // (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
                'ImpTotal' 	=> $ImpNeto, // Importe total del comprobante
                'ImpTotConc' 	=> 0,   // Importe neto no gravado
                'ImpNeto' 	=> $ImpNeto, // Importe neto gravado
                'ImpOpEx' 	=> 0,   // Importe exento de IVA
                'ImpIVA' 	=> 0,  //Importe total de IVA
                'ImpTrib' 	=> 0,   //Importe total de tributos
                'MonId' 	=> 'PES', //Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos) 
                'MonCotiz' 	=> 1,     // Cotización de la moneda usada (1 para pesos argentinos)  
                
            );
            
            $res = $afip->ElectronicBilling->CreateVoucher($data);
            
            $cae=$res['CAE']; //CAE asignado el comprobante
            $vtocae = $res['CAEFchVto']; //Fecha de vencimiento del CAE (yyyy-mm-dd)
            return (["res"=>$res]);

            
            
                    $tc = 11 ; //factura C

                    $cbteFch = date("Y-m-d H:i:s");
                    $tipoCbteNum = $tc;
                    $nroCbte = $punto_v . "-" . str_pad($valfac, 8, "0", STR_PAD_LEFT);
                    $caeNum = $result['CAE']; 
                    $caeFvtoo = $result['CAEFchVto'];
                    $docTipo = $doc_t;// CUIT 80 o 99 cf
                    $docNro = $valor_cuit_cuil_dni;
                    $nombreRS = $cond_iva; //CF RI
                    $tipoPago = $cond_venta;
                    $impNeto = $neto_gravado;
                    $impIVA = $iva_21;
                    $impTotal = $total ;
                    $cbteAsoc = '0';
                    $codigoBarra = $codigo_barra_final;
                    $servicios = $request->input('prod_servicios');
                    $concepto = 'NULL';
                    $FchServDesde = $request->input('FchServDesde');
                    $FchServHasta = $request->input('FchServHasta');
                    $FchVtoPago = $request->input('FchVtoPago');
                     DB::insert('insert into afip (cbteFch, tipoCbteNumero, nroCbte, caeNum, caeFvto, docTipo, docNro, nombreRS, tipoPago, impNeto, impIVA, impTotal, cbteAsoc, codigoBarra, servicios ,concepto, fdesde, fhasta, fvtopag) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? , ?, ?, ?, ?, ?, ?, ?, ?)', 
                                        [$cbteFch ,$tipoCbteNum, $nroCbte, $cae, $vtocae, $docTipo, $docNro, $nombreRS, $tipoPago, $impNeto, $impIVA, $impTotal, $cbteAsoc, $codigoBarra, $servicios ,$concepto , $FchServDesde , $FchServHasta, $FchVtoPago ]);
        }
         


}

   
}
