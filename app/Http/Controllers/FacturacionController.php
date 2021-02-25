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
        /* dd($filekey,$filecrt); */
        /* \Auth::user()->id */
        /* dd(asset('storage/'.\Auth::user()->id. '/'.$punto_v .'_'.$filekey)); */
        $options = [                    //options es un array con el CUIT (de la empresa que esta vendiendo)
            'CUIT' => 20355003192,
            'production' => True,
            /* 'cert' => asset('storage/'.\Auth::user()->id. '/'.$punto_v .'_'.$filecrt),
            'key' => asset('storage/'.\Auth::user()->id. '/'.$punto_v .'_'.$filekey), */
            'cert' => '/'.\Auth::user()->id. '/'.$punto_v .'_'.$filecrt,
            'key' => '/'.\Auth::user()->id. '/'.$punto_v .'_'.$filekey,
            /* 'cert' => 'homo/certificado.crt',
            'key' => 'homo/MiClavePrivada.key', */
            
            /* 'cert' => 'prueba_ws_47c10aeaf1fd8909.crt',
            'key' => 'homo/MiClavePrivada.key', */
            ];

            $afip = new Afip($options);
            $voucher_types = $afip->ElectronicBilling->GetVoucherTypes();
            dd($voucher_types);

            $inscription = $afip->RegisterInscriptionProof->GetTaxpayerDetails('30519536435');
            dd($uss);

            dd($inscription);
    }


    public function indexfactura( $prest_id, $os_id, $mes = null, $anio = null){

        $user = \Auth::user()->id;
        $prestador_menu = \DB::select("SELECT obrasocial.nombre, obrasocial.id FROM obrasocial LEFT JOIN prestador on prestador.os_id = obrasocial.id WHERE prestador.user_id = " . $user . " GROUP BY obrasocial.id, obrasocial.nombre");

        /* $beneficiario = Beneficiario::with('prestador')->with('prestacion')->get(); */
        $prestador = Prestador::with('prestacion')->get();
        /* dd($prestador); */

        $beneficiario = Beneficiario::where('id_provincia', '=', '2')
                                    ->with('prestador')/* ->with('prestacion') */
                                    ->whereHas('prestador', function($q){        
                                        /* $q->where('id', '=', '78'); */
                                        $q->where('user_id', '=', \Auth::user()->id);
                                    })->get();
                                    

                       
                            
        /* $prestador = Prestacion::with('prestador')->get(); 

        $pres = Prestacion::join("prestador", "prestador.id", "=", "prestacion.id")
                ->select("*")
                ->get(); */
 /* ->where('beneficiario.updated_at', '=', \DB::raw('DATE_FORMAT(CAST(created_at as DATE), "%Y-%m")'), '<=', \Auth::user()->anio.'-'.\Auth::user()->mes) */
        
        /* $qeryset = DB::table('prestacion')
                ->join("prestador", "prestador.prestacion_id", "=", "prestacion.id")
                ->join("beneficiario", "beneficiario.prestador_id","=","prestador.id")
                ->where('prestador.user_id', '=', \Auth::user()->id)
               

                ->select('prestacion.*','beneficiario.cantidad_solicitada','beneficiario.prestador_id','prestador.*')
                ->get(); */
  // Muestro beneficiarios

            if($mes == null){

                $mes = date('m');           

            }



            if($anio == null){

                $anio = date('Y');           

            }



        // Declaro objeto de usuario

        $user = \Auth::user()->id;



        // Objeto Menu prestador

        $prestador_menu = \DB::select("SELECT obrasocial.nombre, obrasocial.id FROM obrasocial LEFT JOIN prestador on prestador.os_id = obrasocial.id WHERE prestador.user_id = " . $user . " GROUP BY obrasocial.id, obrasocial.nombre");



// Objeto prestaciones

$os_id = '2'; //Apross
$prestacion = Prestador::where('user_id', $user)
                ->where('os_id', $os_id)
                ->with('prestacion')
                ->get();



//$beneficiario = Beneficiario::where('prestador_id', $prest_id)->with('prestador')->get();



// Traigo beneficiarios segun prestador y obra social

$os_id = '2'; //Apross
$beneficiarios = Prestador::where('user_id', $user)
                    ->where('os_id', $os_id)
                    ->with('prestacion', 'beneficiario.inasistencia', 'beneficiario.agregado', 'beneficiario.sesion')
                    ->orderBy('id', 'desc')

                    ->get();
/* dd($beneficiarios); */

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

// Sumario de fechas

    $cuenta = array();

    foreach ($fechas['total'] ?? [] as $key => $fecha) {

        $cuenta[$key] = 0;

        foreach($fecha as $k => $v){

            $cuenta[$key]++;

            $fecha_individual = explode('/', $v);

            foreach($fechas['inasistencias'][$key] as $inasistencia){

                $inasistencia_individual = explode('/', $inasistencia);	

                if($fecha_individual[0].'/'.$fecha_individual[1].'/'.$fecha_individual[2] == $inasistencia_individual[0].'/'.$inasistencia_individual[1].'/'.$inasistencia_individual[2]){

                    $cuenta[$key]--;

                }

            }			

        }

        $fechas['tope'][$key] = $cuenta;

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
        /* dd($certs); */
        $user = \Auth::user();

        
        $tot = DB::table('prestacion')->where('activo', 1)
        ->join('prestador','prestador.prestacion_id','=','prestacion.id')
        ->join('users','users.id','=','prestador.user_id')
        ->join('beneficiario', 'beneficiario.prestador_id','=' , 'prestador.id')
         ->select('prestacion.*', 
                                DB::raw('COUNT(distinct prestacion.id) as id_prestacion'), 
                                DB::raw('SUM(prestacion.valor_modulo) as total'))
                               /*  ->groupBy(\DB::raw('id_prestacion'))) */
                                ->get();
                
        

        dd($tot);

        $qs = DB::table('prestacion')->where('activo', 1)
       /*  ->select('prestacion.id','prestacion.*','prestador.*','beneficiario.cantidad_solicitada') */
        ->join('prestador','prestador.prestacion_id','=','prestacion.id')
        ->join('users','users.id','=','prestador.user_id')
        ->join('beneficiario', 'beneficiario.prestador_id','=' , 'prestador.id')
       /*  ->distinct() */
        ->get();

       /*  $result2 = DB::select(DB::raw("SELECT id,valor_modulo FROM prestacion")); */

       /*  dd($qs); */
        return view('facturacion-electronica.caeprueba',[/* 'prestador_menu' => $prestador_menu, *//* 'qeryset' => $qeryset, */ 
            'data' => $data , 'qs' => $qs ,'user'=> $user, 'certs' => $certs , 'tot'=>$tot]);
    }

    public function consultarcuit(Request $request){

        

        $obj = Certificados::with('users')->where('id_user', \Auth::user()->id)->first();
        $punto_v = $obj->ptovta;
        $filekey = $obj->certkey;
        $filecrt = $obj->certcrt;
        /* dd($filekey,$filecrt); */
        /* \Auth::user()->id */
        /* dd(asset('storage/'.\Auth::user()->id. '/'.$punto_v .'_'.$filekey)); */
        $options = [                    //options es un array con el CUIT (de la empresa que esta vendiendo)
            'CUIT' => 20355003192,
            'production' => True,
            /* 'cert' => asset('storage/'.\Auth::user()->id. '/'.$punto_v .'_'.$filecrt),
            'key' => asset('storage/'.\Auth::user()->id. '/'.$punto_v .'_'.$filekey), */
            'cert' => '/'.\Auth::user()->id. '/'.$punto_v .'_'.$filecrt,
            'key' => '/'.\Auth::user()->id. '/'.$punto_v .'_'.$filekey,
            /* 'cert' => 'homo/certificado.crt',
            'key' => 'homo/MiClavePrivada.key', */
            
            /* 'cert' => 'prueba_ws_47c10aeaf1fd8909.crt',
            'key' => 'homo/MiClavePrivada.key', */
            ];

            $afip = new Afip($options);
            $voucher_types = $afip->ElectronicBilling->GetVoucherTypes();

            $cuit_cliente_osecac = $request->input('cuit');


            /* $aspross_cuit = 30999253675; */

            $inscription = $afip->RegisterInscriptionProof->GetTaxpayerDetails($cuit_cliente_osecac);
            

            dd($inscription);
            
        
    }


    public function solicitarcae(Request $request)
    {

       
        /* $idventa = request('idventa'); 
        $venta=DB::table('venta')->where('idventa','=', $idventa)
        ->join('persona','venta.idcliente', '=','persona.idpersona')
        ->get(); */
        
    
        
        
        
        $qs = DB::table('prestacion')->where('activo', 1)
            ->join('prestador','prestador.prestacion_id','=','prestacion.id')
            /* ->join('obrasocial','obrasocial.id','=', 'prestador.os_id') */
            ->join('users','users.id','=','prestador.user_id')
            ->join('beneficiario', 'beneficiario.prestador_id','=' , 'prestador.id')
            ->get();
        
        $user_id=\Auth::user()->id;


        $cuit_cliente = request('cuit_obrasocial');
        
       
        
        /* foreach ($qs as $q)
        {
         $idcliente = $q->idpersona; 
         $doc_cliente = $venta1->num_documento; 
         $ImpTotal = $venta1->total_venta;
         $tipo_comprobante = $venta1->tipo_comprobante;
        } */
        

        /* foreach ($venta as $venta1)
        {
         $idcliente = $venta1->idpersona; 
         $doc_cliente = $venta1->num_documento; 
         $ImpTotal = $venta1->total_venta;
         $tipo_comprobante = $venta1->tipo_comprobante;
        } */

        /* $config=DB::table('config')->where('idconfig','=','1')->get();

        foreach ($config as $config1)
        {
         $cuit = $config1->dni;
         $punto_venta = $config1->punto_venta; 
        } */

        if ($idcliente==1){
            $doctipo=99;
        }else{
            $doctipo=80;
        }

        if ($request->ajax()) {

            if($tipo_comprobante=='Factura C'){

            $afip = new Afip(array('CUIT' => $cuit));
            $last_voucher = $afip->ElectronicBilling->GetLastVoucher($punto_venta ,11);
            $numComp = $last_voucher + 1;

            
            $ImpNeto = $ImpTotal/1.21;
            $ImpNeto = number_format((float)$ImpNeto, 2, '.', '');
            $ImpIVA = $ImpTotal - $ImpNeto;
            $ImpIVA = number_format((float)$ImpIVA, 2, '.', '');
            
            $date = Carbon::now('America/Argentina/Buenos_Aires');
            $date2 = $date->format('Ymd');

            $data = array(
                'CantReg' 	=> 1,  // Cantidad de comprobantes a registrar
                'PtoVta' 	=> $punto_venta,  // Punto de venta
                'CbteTipo' 	=> 11,  // Tipo de comprobante (ver tipos disponibles) 
                'Concepto' 	=> 1,  // Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
                'DocTipo' 	=> $doctipo, // Tipo de documento del comprador (99 consumidor final, ver tipos disponibles)
                'DocNro' 	=> intval($doc_cliente),  // Número de documento del comprador (0 consumidor final)
                'CbteDesde' 	=> $numComp,  // Número de comprobante o numero del primer comprobante en caso de ser mas de uno
                'CbteHasta' 	=> $numComp,  // Número de comprobante o numero del último comprobante en caso de ser mas de uno
                'CbteFch' 		=> intval($date2), // (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
                'ImpTotal' 	=> $ImpTotal, // Importe total del comprobante
                'ImpTotConc' 	=> 0,   // Importe neto no gravado
                'ImpNeto' 	=> $ImpTotal, // Importe neto gravado
                'ImpOpEx' 	=> 0,   // Importe exento de IVA
                'ImpIVA' 	=> 0,  //Importe total de IVA
                'ImpTrib' 	=> 0,   //Importe total de tributos
                'MonId' 	=> 'PES', //Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos) 
                'MonCotiz' 	=> 1,     // Cotización de la moneda usada (1 para pesos argentinos)  
                
            );
            
            $res = $afip->ElectronicBilling->CreateVoucher($data);
            
            $cae=$res['CAE']; //CAE asignado el comprobante
            $vtocae = $res['CAEFchVto']; //Fecha de vencimiento del CAE (yyyy-mm-dd)

            $venta= venta::find($idventa);
            $venta->cae = $cae;
            $venta->vtocae = $vtocae;
            $num_fac = $last_voucher + 1;
            $venta->num_comprobante = str_pad($punto_venta, 4, "0", STR_PAD_LEFT).'-'.str_pad($num_fac, 8, "0", STR_PAD_LEFT);
            $venta->save();
            return (["res"=>$res]);
            }
        
        } else if ($tipo_comprobante == "Factura B"){

        $afip = new Afip(array('CUIT' => $cuit));
        $last_voucher = $afip->ElectronicBilling->GetLastVoucher($punto_venta,6);
        $numComp = $last_voucher + 1;

        $ImpTotal = request('total_venta');
        $ImpNeto = $ImpTotal/1.21;
        $ImpNeto = number_format((float)$ImpNeto, 2, '.', '');
        $ImpIVA = $ImpTotal - $ImpNeto;
        $ImpIVA = number_format((float)$ImpIVA, 2, '.', '');
        
        $date = Carbon::now('America/Argentina/Buenos_Aires');
        $date2 = $date->format('Ymd');
        

        $data = array(
            'CantReg' 	=> 1,  // Cantidad de comprobantes a registrar
            'PtoVta' 	=> $punto,  // Punto de venta
            'CbteTipo' 	=> 6,  // Tipo de comprobante (ver tipos disponibles) 
            'Concepto' 	=> 1,  // Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
            'DocTipo' 	=> $doctipo, // Tipo de documento del comprador (99 consumidor final, ver tipos disponibles)
            'DocNro' 	=> intval($clientCuit),  // Número de documento del comprador (0 consumidor final)
            'CbteDesde' 	=> $numComp,  // Número de comprobante o numero del primer comprobante en caso de ser mas de uno
            'CbteHasta' 	=> $numComp,  // Número de comprobante o numero del último comprobante en caso de ser mas de uno
            'CbteFch' 		=> intval($date2), // (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
            'ImpTotal' 	=> $ImpTotal, // Importe total del comprobante
            'ImpTotConc' 	=> 0,   // Importe neto no gravado
            'ImpNeto' 	=> $ImpNeto, // Importe neto gravado
            'ImpOpEx' 	=> 0,   // Importe exento de IVA
            'ImpIVA' 	=> $ImpIVA,  //Importe total de IVA
            'ImpTrib' 	=> 0,   //Importe total de tributos
            'MonId' 	=> 'PES', //Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos) 
            'MonCotiz' 	=> 1,     // Cotización de la moneda usada (1 para pesos argentinos)  
            'Iva' 		=> array( // (Opcional) Alícuotas asociadas al comprobante
                array(
                    'Id' 		=> 5, // Id del tipo de IVA (5 para 21%)(ver tipos disponibles) 
                    'BaseImp' 	=> $ImpNeto, // Base imponible
                    'Importe' 	=> $ImpIVA // Importe 
                )
            ), 
        );
        
        $res = $afip->ElectronicBilling->CreateVoucher($data);
        
        $cae=$res['CAE']; //CAE asignado el comprobante
        $vtocae = $res['CAEFchVto']; //Fecha de vencimiento del CAE (yyyy-mm-dd)

        $venta= venta::find($idventa);
        $venta->cae = $cae;
        $venta->vtocae = $vtocae;
        $num_fac = $last_voucher + 1;
        $venta->num_comprobante = str_pad($punto_venta, 4, "0", STR_PAD_LEFT).'-'.str_pad($num_fac, 8, "0", STR_PAD_LEFT);
        $venta->save();
        return (["res"=>$res]);


       }else if ($tipo_comprobante == "Factura A"){
       
    
        $afip = new Afip(array('CUIT' => $cuit));
        $last_voucher = $afip->ElectronicBilling->GetLastVoucher($punto_venta,1);
        $numComp = $last_voucher + 1;

        $ImpTotal = request('total_venta');
        $ImpNeto = $ImpTotal/1.21;
        $ImpNeto = number_format((float)$ImpNeto, 2, '.', '');
        $ImpIVA = $ImpTotal - $ImpNeto;
        $ImpIVA = number_format((float)$ImpIVA, 2, '.', '');
        
        $date = Carbon::now('America/Argentina/Buenos_Aires');
        $date2 = $date->format('Ymd');
        $clientCuit = request('cuit');
        
        $data = array(
            'CantReg' 	=> 1,  // Cantidad de comprobantes a registrar
            'PtoVta' 	=> intval($punto),  // Punto de venta
            'CbteTipo' 	=> 1,  // Tipo de comprobante (ver tipos disponibles) 
            'Concepto' 	=> 1,  // Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
            'DocTipo' 	=> 80, // Tipo de documento del comprador (99 consumidor final, ver tipos disponibles)
            'DocNro' 	=> intval($clientCuit),  // Número de documento del comprador (0 consumidor final)
            'CbteDesde' 	=> $numComp,  // Número de comprobante o numero del primer comprobante en caso de ser mas de uno
            'CbteHasta' 	=> $numComp,  // Número de comprobante o numero del último comprobante en caso de ser mas de uno
            'CbteFch' 		=> intval($date2), // (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
            'ImpTotal' 	=> $ImpTotal, // Importe total del comprobante
            'ImpTotConc' 	=> 0,   // Importe neto no gravado
            'ImpNeto' 	=> $ImpNeto, // Importe neto gravado
            'ImpOpEx' 	=> 0,   // Importe exento de IVA
            'ImpIVA' 	=> $ImpIVA,  //Importe total de IVA
            'ImpTrib' 	=> 0,   //Importe total de tributos
            'MonId' 	=> 'PES', //Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos) 
            'MonCotiz' 	=> 1,     // Cotización de la moneda usada (1 para pesos argentinos)  
            'Iva' 		=> array( // (Opcional) Alícuotas asociadas al comprobante
                array(
                    'Id' 		=> 5, // Id del tipo de IVA (5 para 21%)(ver tipos disponibles) 
                    'BaseImp' 	=> $ImpNeto, // Base imponible
                    'Importe' 	=> $ImpIVA // Importe 
                )
            ), 
        );
        
        $res = $afip->ElectronicBilling->CreateVoucher($data);
        
        $cae=$res['CAE']; //CAE asignado el comprobante
        $vtocae = $res['CAEFchVto']; //Fecha de vencimiento del CAE (yyyy-mm-dd) 

        $venta= venta::find($idventa);
        $venta->cae = $cae;
        $venta->vtocae = $vtocae;
        $num_fac = $last_voucher + 1;
        $venta->num_comprobante = str_pad($punto_venta, 4, "0", STR_PAD_LEFT).'-'.str_pad($num_fac, 8, "0", STR_PAD_LEFT);
        $venta->save();
        return (["res"=>$res]);

      }

    }

   public function caesolicitud(Request $request){

    $tc = 0; 
    $data = [];

    $obj = Certificados::with('users')->where('id_user', \Auth::user()->id)->first();
    
    $punto_v = $obj->ptovta;
    $filekey = $obj->certkey;
    $filecrt = $obj->certcrt;
    
    /* CbteTipo :         1 -> A  ,           6 ->B ,      11 ->C */

    $options = [                    //options es un array con el CUIT (de la empresa que esta vendiendo)
        'CUIT' => 20355003192,
        'production' => false,
        'cert' => '/'.\Auth::user()->id. '/'.$punto_v .'_'.$filecrt,
        'key' => '/'.\Auth::user()->id. '/'.$punto_v .'_'.$filekey,
        ];
    
        $afip = new Afip($options);
        


        /* $ptos = $afip->ElectronicBilling->GetSalesPoints(); */
        /* dd($ptos); */
       
       /*  $taxpayer_det = $afip->RegisterScopeFour->GetTaxpayerDetails(20355003192);
        dd($taxpayer_det); */
        $getvoucher = $afip->ElectronicBilling->GetVoucherInfo(1 ,4 , 11);//($CbteNro, $sales_point, $CbteTipo)   //CbteNro     //sales_point     //CbteTipo    ----->//número de comprobante (del comprobante autorizado)   //ptos_venta      //6->factura B
                                                            //este metodo No esta andando devuelve null
        


        
        $last_voucher = $afip->ElectronicBilling->GetLastVoucher(4,11);
        
       
        $taxpayer = $afip->RegisterInscriptionProof->GetTaxpayerDetails(30519536435);
        
        
        /* dd($punto_v,$filekey,$filecrt); */
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
    
        
    /* if ($request->ajax()) { */

        if($request->input('tipo_comprobante')=='Factura BB'){        //emite B si es CF O Sujeto exento o Monotrib

            $afip = new Afip($options);
        
            $voucher_types = $afip->ElectronicBilling->GetVoucherTypes();
            $last_voucher = $afip->ElectronicBilling->GetLastVoucher(4,$tc); //Devuelve el número del último comprobante creado para el punto de venta 1 y el tipo de comprobante 6 (Factura B)
            dd($last_voucher);
            $valfac = $last_voucher + 1;  //este campo guarda el ultimo comprobante + 1


            
            $variable_impositiva = 10000;  //averiguar si es 15.380
            $total = 2;
            if($total >= $variable_impositiva ){
                if($request->input('comprador') == 'CUIT' ){
                    $doc_t = 80; // CUIT
                    $valor_cuit_cuil_dni = $request->input('cuit');
                }

                if($request->input('comprador') == 'CUIL' ){ //este seria para contemplar el ejemplo de CreateVoucher
                    $doc_t = 80; // CUIT
                    $valor_cuit_cuil_dni = $request->input('cuit');
                }

                if($request->input('comprador') == 'DNI' ){
                    $doc_t = 96; // DNI
                    $valor_cuit_cuil_dni = $request->input('nro_documento');
                } 
            }
            else{
                $doc_t = 99; // CF 
                $valor_cuit_cuil_dni = 0;
            }

          

           
            
            
            if($request->input('prod_servicios')=='Productos'){ 

                $prod_ser = 1;
            }
            if($request->input('prod_servicios')=='Servicios'){ 
        
                $prod_ser = 2;
            }
            if($request->input('prod_servicios')=='Productos_Servicios'){ 
        
                $prod_ser = 3;
            }

            if($prod_ser == 2 or $prod_ser == 3){
                $fechaDesde = date('Ymd', strtotime($request->input('FchServDesde')));
                $fechaHasta = date('Ymd', strtotime($request->input('FchServHasta')));
                $fechaVtoPago = date('Ymd', strtotime($request->input('FchVtoPago')));
            }
            else{
                $fechaDesde = 'NULL';
                $fechaHasta = 'NULL';
                $fechaVtoPago = 'NULL';
            }
            
           

            /* $total = $request->input('total');
            $neto_gravado = $request->input('neto_gravado');
            $iva_21 = $request->input('iva_21');
            $iva_10_5 = $request->input('iva_10_5'); */

            $pto_venta = 4; //en este caso el pto de venta es 1 

            $data = array(
                'CantReg' 	=> 1,  // Cantidad de comprobantes a registrar
                'PtoVta' 	=> $pto_venta,  // Punto de venta
                'CbteTipo' 	=> $tc,  // Tipo de comprobante (Factura B)(ver tipos disponibles) // <CbteTipo>1</CbteTipo> --> FACTURA A
                'Concepto' 	=> $prod_ser,  // Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios


                "FchServDesde" => $fechaDesde,
                "FchServHasta" => $fechaHasta,
                "FchVtoPago" => $fechaVtoPago,

                'DocTipo' 	=> $doc_t, // Tipo de documento del comprador (99 consumidor final, ver tipos disponibles) //<DocTipo>80</DocTipo> --> CUIT
                'DocNro' 	=> $valor_cuit_cuil_dni,  // Número de documento del comprador (0 consumidor final)


                'CbteDesde' 	=> $valfac,  // Número de comprobante o numero del primer comprobante en caso de ser mas de uno
                'CbteHasta' 	=> $valfac,  // Número de comprobante o numero del último comprobante en caso de ser mas de uno
                'CbteFch' 	=> intval(date('Ymd')), // (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
                'ImpTotal' 	=> 2, // Importe total del comprobante
                'ImpTotConc' 	=> 0,   // Importe neto no gravado
                'ImpNeto' 	=> $neto_gravado, // Importe neto gravado
                'ImpOpEx' 	=> 0,   // Importe exento de IVA
                'ImpIVA' 	=> $iva_21,  //Importe total de IVA
                'ImpTrib' 	=> 0,   //Importe total de tributos
                'MonId' 	=> 'PES', //Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos) 
                'MonCotiz' 	=> 1,     // Cotización de la moneda usada (1 para pesos argentinos)  
                'Iva' 		=> array( // (Opcional) Alícuotas asociadas al comprobante
                    array(
                        'Id' 		=> 5, // Id del tipo de IVA (5 para 21%)(ver tipos disponibles) 
                        'BaseImp' 	=> $neto_gravado, // Base imponible
                        'Importe' 	=> $iva_21 // Importe 
                    )
                ), 
            );

                    $res = $afip->ElectronicBilling->CreateVoucher($data);
                    $cae=$res['CAE']; //CAE asignado el comprobante
                    $vtocae = $res['CAEFchVto']; //Fecha de vencimiento del CAE (yyyy-mm-dd)
                    $cadena_cae = $res['CAEFchVto'];


                    $caefech = str_replace("-","",$cadena_cae);
                    $codigobarras = $cuit_vendedor . $comprob . $punto . $res['CAE'] . $caefech;

                    $barras = new BarcodeI25();
                    $codigo_barra_final = $barras->compute($codigobarras, '1', 'int25');
                    
                    //Variables para insertar en la bd AFIP antes de pasar a la vista Preliminar
                    $cbteFch = date("Y-m-d H:i:s");
                    $tipoCbteNum = $tc;
                    $nroCbte = $punto . "-" . str_pad($valfac, 8, "0", STR_PAD_LEFT);
                    $caeNum = $res['CAE']; 
                    $caeFvtoo = $res['CAEFchVto'];

                    $domicilio = $request->input('domicilio');
                    $cod_postal = $request->input('cod_postal');
                    $provincia = $request->input('provincia');
                    $direccion = $request->input('direccion');
                    $localidad = $request->input('localidad');
                    $cuit = $request->input('cuit');
                    $rsocial = $request->input('rsocial');
                    $cond_iva = $request->input('cond_iva');
                    $cond_venta = $request->input('cond_venta');
                    $tipo_factura = $request->input('tipo_factura');
                    /* $prod_servicios = $request->input('prod_servicios'); */

                    /* $FchServDesde = $request->input('FchServDesde');
                    $FchServHasta = $request->input('FchServHasta');
                    $FchVtoPago = $request->input('FchVtoPago'); */
                    $codigoTabla = $request->input('codigoTabla');
                    $detalleTabla = $request->input('detalleTabla');
                    $cantidadTabla = $request->input('cantidadTabla');
                    $precioTabla = $request->input('precioTabla');
                    //////////////////////////////////////////////
                    $neto_gravado = $request->input('neto_gravado');
                    $iva_21 = $request->input('iva_21');
                    $iva_10_5 = $request->input('iva_10_5');
                    $total = $request->input('total');


                    
                    //otras variables 
                    $pto_venta = 4; //en este caso el pto de venta es 1 
                    $cuit_vendedor = '20355003192'; //cuit del dueño del local
                    $comprob = str_pad($tc, 3, "0", STR_PAD_LEFT); //para el codigo de barras
                    $punto =  str_pad($pto_venta, 5, "0", STR_PAD_LEFT); //para el codigo de barras

                    
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
                    
                    $caeFvt = date("Y-m-d", strtotime($caeFvtoo));
                    return (["res"=>$res]);

        }

        if($tipo_comprob == 'Factura C'){
            //ctes para probar
            $ImpTotal = 1;
            $afip = new Afip($options);
            $last_voucher = $afip->ElectronicBilling->GetLastVoucher($punto_v, 11);
            $numComp = $last_voucher + 1;
            dd($afip);
            
            
            $ImpNeto = $ImpTotal/1.21;
            $ImpNeto = number_format((float)$ImpNeto, 2, '.', '');
            $ImpIVA = $ImpTotal - $ImpNeto;
            $ImpIVA = number_format((float)$ImpIVA, 2, '.', '');
            
            dd($ImpTotal,$ImpNeto,$ImpIVA);


            $date = Carbon::now('America/Argentina/Buenos_Aires');
            $date2 = $date->format('Ymd');

            $data = array(
                'CantReg' 	=> 1,  // Cantidad de comprobantes a registrar
                'PtoVta' 	=> $punto_v,  // Punto de venta
                'CbteTipo' 	=> 11,  // Tipo de comprobante (ver tipos disponibles) 
                'Concepto' 	=> 1,  // Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
                'DocTipo' 	=> $doctipo, // Tipo de documento del comprador (99 consumidor final, ver tipos disponibles)
                'DocNro' 	=> intval($doc_cliente),  // Número de documento del comprador (0 consumidor final)
                'CbteDesde' 	=> $numComp,  // Número de comprobante o numero del primer comprobante en caso de ser mas de uno
                'CbteHasta' 	=> $numComp,  // Número de comprobante o numero del último comprobante en caso de ser mas de uno
                'CbteFch' 		=> intval($date2), // (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
                'ImpTotal' 	=> $ImpTotal, // Importe total del comprobante
                'ImpTotConc' 	=> 0,   // Importe neto no gravado
                'ImpNeto' 	=> $ImpTotal, // Importe neto gravado
                'ImpOpEx' 	=> 0,   // Importe exento de IVA
                'ImpIVA' 	=> 0,  //Importe total de IVA
                'ImpTrib' 	=> 0,   //Importe total de tributos
                'MonId' 	=> 'PES', //Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos) 
                'MonCotiz' 	=> 1,     // Cotización de la moneda usada (1 para pesos argentinos)  
                
            );
            
            $res = $afip->ElectronicBilling->CreateVoucher($data);
            
            $cae=$res['CAE']; //CAE asignado el comprobante
            $vtocae = $res['CAEFchVto']; //Fecha de vencimiento del CAE (yyyy-mm-dd)

            /* $venta= venta::find($idventa);
            $venta->cae = $cae;
            $venta->vtocae = $vtocae; */
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

            /* $num_fac = $last_voucher + 1;
            $venta->num_comprobante = str_pad($punto_venta, 4, "0", STR_PAD_LEFT).'-'.str_pad($num_fac, 8, "0", STR_PAD_LEFT);
            $venta->save(); */

            return (["res"=>$res]);

        }
            




   /*  } */

           
                                


}






   
}
