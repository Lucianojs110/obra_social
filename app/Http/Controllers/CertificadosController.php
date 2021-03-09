<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Certificados;
use App\User;
use Auth;
use Illuminate\Support\Facades\Storage;
use DB;

class CertificadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user()->id;
        $uss = \Auth::user();

    	
        $certs = Certificados::with('users')->where('id_user', \Auth::user()->id)->withTrashed()->get();

        return view('certificados.index',[ 'certs' => $certs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = \Auth::user()->id;
        $prestador_menu = \DB::select("SELECT obrasocial.nombre, obrasocial.id FROM obrasocial LEFT JOIN prestador on prestador.os_id = obrasocial.id WHERE prestador.user_id = " . $user . " GROUP BY obrasocial.id, obrasocial.nombre");
        $cadena_cuit = \Auth::user()->cuit;
        $cuit = str_replace("-","",$cadena_cuit);

        return view('certificados.create',['prestador_menu' => $prestador_menu]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = \Auth::user()->id;
        $prestador_menu = \DB::select("SELECT obrasocial.nombre, obrasocial.id FROM obrasocial LEFT JOIN prestador on prestador.os_id = obrasocial.id WHERE prestador.user_id = " . $user . " GROUP BY obrasocial.id, obrasocial.nombre");


        $file1 = $request->file('archivokey');
        $file2 = $request->file('archivocrt');


          if($file1->getClientOriginalExtension() != 'key') {
            $request->session()->flash('mensaje-warning', 'El Primer Certificado subido no es extension .key , Por favor revisar de que su extension sea .key !!!');
            return redirect('/certs');
          }
        
          if($file2->getClientOriginalExtension() != 'crt'){
            $request->session()->flash('mensaje-warning', 'El Segundo Certificado subido no es extension .crt , Por favor revisar de que su extension sea .crt !!!');
            return redirect('/certs');
          }
       
        
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
            

            $request->session()->flash('mensaje-warning', 'Uno de los certificados, No fue subido correctamente, Por favor revisar de subir ambos archivos correspondientemente !!!');
            return redirect('/certs');
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
        $request->session()->flash('mensaje-success', 'Los Certificados y el Punto de venta se cargaron Correctamente !!!');
        return redirect('/certs');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $certs = Certificados::withTrashed()->find($id);
        if($certs->trashed()){
            
            $certs->restore();
           /*  $request->session()->flash('mensaje-success', 'La Agencia fue activada con exito'); */
        }
        else{
            
            $certs->delete();
            /* $certs->session()->flash('mensaje-success', 'La Agencia fue eliminada correctamente'); */
        }


        return redirect('/certs');
    }
}
