<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Prestacion;
use App\Prestador;
use App\Beneficiario;

class PrestacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $prestacion = Prestacion::where('os_id', $id)->get();
        return $prestacion;
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
    public function destroy($id)
    {
        // Borro prestacion
        $prestacion = Prestacion::find($id);
        $prestacion->delete();

        // Borro prestaciones asociadas en datos de prestador
        $prestador = Prestador::where('prestacion_id', $id);

        // Busco beneficiarios asociados y los elimino tambien
        foreach($prestador as $prest){
            $beneficiarios = Beneficiario::where('prestador_id', $prest->id);
            $beneficiarios->delete();       
        }
         
        // Elimino prestador
        $prestador->delete();

         return redirect()->route('prestaciones')
            ->with(['message' => 'La prestacion con sus datos de prestador y beneficiarios asociados han sido eliminados correctamente']);
    }
}
