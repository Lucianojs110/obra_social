<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vendor\afipsdk\src\Afip;
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
use App\Facturas;
use App\DetalleFactura;
use Auth;
use Illuminate\Support\Facades\Storage;
use DB;
use SimpleXMLElement;
use DateTime;  
use Illuminate\Support\Facades\Session;


class FacturacionController extends Controller
{
    public function index(){

        $user = \Auth::user()->id;
            	
        $factura = DB::table('facturas as f')
        ->join('obrasocial as os','os.id', '=','f.os_id')
        ->join('users as u','u.id', '=','f.user_id')
        ->where('f.user_id','=',  \Auth::user()->id)
        ->get();

        return view('facturacion-electronica.index', [ 'factura' => $factura]);
    }

    public function createCert(){


        $user = \Auth::user()->id;
        $prestador_menu = \DB::select("SELECT obrasocial.nombre, obrasocial.id FROM obrasocial LEFT JOIN prestador on prestador.os_id = obrasocial.id WHERE prestador.user_id = " . $user . " GROUP BY obrasocial.id, obrasocial.nombre");
        $cadena_cuit = \Auth::user()->cuit;
        $cuit = str_replace("-","",$cadena_cuit);

        return view('facturacion-electronica.create',['prestador_menu' => $prestador_menu]);
    }

    public function create(){

        return view('facturacion-electronica.create');
    }

    public function show($id)
    {
        
        $iduser = \Auth::user()->id;
        
        $user = DB::table('users as u')
        ->where('id','=', $iduser)
        ->get();

        $facturas = DB::table('facturas as d')
        ->where('id_factura','=', $id)
        ->get();


        $obrasocial = DB::table('obrasocial as o')
        ->where('id','=',$facturas[0]->os_id)
        ->get();

        $detalle = DB::table('detalle_factura as d')
        ->where('id_factura','=', $id)
        ->get();

        return view ('facturacion-electronica.show', ['obrasocial'=>$obrasocial, 'user'=>$user, 'detalle'=>$detalle, 'facturas'=>$facturas]);
    }


    public function store(Request $request){

        $date = Carbon::now('America/Argentina/Buenos_Aires');
        $date2 = $date->format('Ymd');
        $ImpTotal = $request->get('total_factura');
        $ImpNeto = $ImpTotal/1.21;
        $ImpNeto = number_format((float)$ImpNeto, 2, '.', '');
        $ImpIVA = $ImpTotal - $ImpNeto;
        $ImpIVA = number_format((float)$ImpIVA, 2, '.', '');
        
        $year =  $request->get('year');
        $mes =  $request->get('mes');
        $fdesde = $year.'-'.$mes.'-01';
        $fhasta = $year.'-'.$mes.'-01';
        $fhasta = new DateTime($fhasta);
        $fdesde = new DateTime($fdesde);
        $fhasta->modify('last day of this month');
        $fhasta->format('Y/m/d');

        $user = \Auth::user()->id;
            	
        $factura = DB::table('facturas as f')
        ->where('f.user_id','=',  \Auth::user()->id)
        ->where('f.fdesde','=', $fdesde  )
        ->get();

        if (count($factura) == 0) {
        
        $fvtopago = $year.'-'.$mes.'-15';
        $fvtopago1 = date_create($fvtopago);
        date_add($fvtopago1, date_interval_create_from_date_string("1 months"));
        $fvtopago2 =  date_format($fvtopago1,"Y-m-d");


        $iduser = \Auth::user()->id;
        
        $user = DB::table('users as u')
        ->where('id','=', $iduser)
        ->get();

        if($user[0]->condicion_iva=='Responsable Inscripto')
        {
            $tipoCbteNumero = 6;
        }else if ($user[0]->condicion_iva=='Monotributo')
        {
            $tipoCbteNumero = 11;
        }

        
        $to = $request->get('total_factura');
        $factura = new Facturas;
        $factura->cbteFch= $date2;
        $factura->tipoCbteNumero = $tipoCbteNumero;
        $factura->docTipo= 80;
        $factura->docNro= '0';
        $factura->impTotal = $request->get('total_factura');
        $factura->impNeto= $ImpNeto;
        $factura->impIVA= $ImpIVA;
        $factura->fdesde = $fdesde;
        $factura->fhasta = $fhasta;
        $factura->fvtopag= $fvtopago2;
        $factura->user_id = $iduser;
        $factura->os_id = 2;
        $factura->save();

        $cantidad = request('cantidad');
        $nombre_pres = request('nombre_pres');
        $valor_modulo= request('valor_modulo');
        $subtotal = request('subtotal');

        $cont = 0;
        
        while($cont < count($nombre_pres)){
           $detalle = new DetalleFactura();
           $detalle->id_factura = $factura->id_factura;
           $detalle->cantidad = $cantidad[$cont];
           $detalle->nombre_prestacion= $nombre_pres[$cont];
           $detalle->valor_modulo = $valor_modulo[$cont];
           $detalle->subtotal = $subtotal[$cont];
           $detalle->save();
           $cont=$cont+1;

        }
  
        return redirect('/facturacion');

    }else{
       
        Session::flash('message', 'El periodo de facturación ya ha sido creado.');
       
        return redirect('facturacion/create');
        
    }
       

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


    


    public function consultafactura(Request $request){

      

        $year = $request->get('year');    
        $mes = $request->get('mes');  
      

        $userid = \Auth::user()->id;


        $user = \Auth::user();          
        $qss = DB::table('prestacion')->where('activo', 1)
                    ->join('prestador','prestador.prestacion_id','=','prestacion.id')
                    ->join('users','users.id','=','prestador.user_id')
                    ->join('beneficiario', 'beneficiario.prestador_id','=' , 'prestador.id')
                    ->whereMonth('prestador.created_at', $mes)
                    ->whereYear('prestador.created_at', $year)
                    ->where('prestador.user_id', $userid)
                    ->groupBy('prestacion.id')
                    ->select(DB::raw('SUM(beneficiario.cantidad_solicitada) as cantidad, SUM(prestacion.valor_modulo) as valortotal'),'prestacion.*','prestador.*','beneficiario.*')
                    ->get();
         
        return $qss;  
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

        $cuit_usuario = User::where('id',\Auth::user()->id)->first();
        $cuit_emisor = str_replace("-","",$cuit_usuario->cuit);

        $cuit_obrsocial =  ObraSocial::where('id', 2)->first(); //id 2 Apross
        $cuit_os = $cuit_obrsocial->cuit;
        
        

         $punto_v = $obj->ptovta;
         $filekey = $obj->certkey;
         $filecrt = $obj->certcrt;
       
         

        $user_id=\Auth::user()->id;
       
    

        $tipo_comprob = 'Factura B';

            
            $options = [                    //options es un array con el CUIT (de la empresa que esta vendiendo)
                'CUIT' => $cuit_emisor,
                'production' => True,
                'cert' => '/'.\Auth::user()->id. '/'.$punto_v .'_'.$filecrt,
                'key' => '/'.\Auth::user()->id. '/'.$punto_v .'_'.$filekey,
                ];
        

        if($tipo_comprob == 'Factura B'){
            //ctes para probar
            $cbtetipo = 6;
            $ImpTotal = 1;
            $afip = new Afip($options);
            $last_voucher = $afip->ElectronicBilling->GetLastVoucher($punto_v, $cbtetipo);
            $info = $afip->ElectronicBilling->GetVoucherInfo(1 ,$punto_v , $cbtetipo);
            dd($info);
            $numComp = $last_voucher + 1;
            
            
            $ImpNeto = $ImpTotal/1.21;
            $ImpNeto = number_format((float)$ImpNeto, 2, '.', '');
            $ImpIVA = $ImpTotal - $ImpNeto;
            $ImpIVA = number_format((float)$ImpIVA, 2, '.', '');

            $ImpTot = $ImpNeto + $ImpIVA;
            
            /* dd($ImpTot,$ImpNeto,$ImpIVA); */
            
           


            $date = Carbon::now('America/Argentina/Buenos_Aires');
            $date2 = $date->format('Ymd');

            $id_factura = $request->get('idfactura');
            /* $id_factura = 1; *///esto borrar despues es solo para probar
            $facturas = DB::table('facturas as d')
                ->where('id_factura','=', $id_factura)
                ->get();

            foreach($facturas as $f){
                $fechaD = $f->fdesde;
                $fechaH = $f->fhasta;
                $fechaVtoPag = $f->fvtopag;
            }

            
            $fechaDesde = date('Ymd', strtotime($fechaD));
            $fechaHasta = date('Ymd', strtotime($fechaH));
            $fechaVtoPago = date('Ymd', strtotime($fechaVtoPag));

            /* dd($fechaDesde,$fechaHasta,$fechaVtoPago); */
            

            $data = array(
                'CantReg' 	=> 1,  // Cantidad de comprobantes a registrar
                'PtoVta' 	=> $punto_v,  // Punto de venta
                'CbteTipo' 	=> $cbtetipo,  // Tipo de comprobante (ver tipos disponibles) 
                'Concepto' 	=> 2,  // Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
                "FchServDesde" => $fechaDesde,
                "FchServHasta" => $fechaHasta,
                "FchVtoPago" => $fechaVtoPago,
                'DocTipo' 	=> 80, // Tipo de documento del comprador (99 consumidor final, ver tipos disponibles)
                'DocNro' 	=> $cuit_os,  // Número de documento del comprador (0 consumidor final)
                'CbteDesde' 	=> $numComp,  // Número de comprobante o numero del primer comprobante en caso de ser mas de uno
                'CbteHasta' 	=> $numComp,  // Número de comprobante o numero del último comprobante en caso de ser mas de uno
                'CbteFch' 		=> intval($date2), // (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
                'ImpTotal' 	=> $ImpTot, // Importe total del comprobante
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
            return (["res"=>$res]);

            
            
                    

                    $cbteFch = date("Y-m-d H:i:s");
                    $tipoCbteNum = $cbtetipo;
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
                
        if($tipo_comprob == 'Factura C'){
            //ctes para probar
            $ImpTotal = 1;
            $afip = new Afip($options);
            $last_voucher = $afip->ElectronicBilling->GetLastVoucher($punto_v, 11);
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
