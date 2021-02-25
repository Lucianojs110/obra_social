<?php

namespace App\Http\Controllers;

use Auth;
use App\Feriado;
use App\Prestador;
use Illuminate\Http\Request;

class FeriadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$user_id = Auth::user()->id;
		$feriados = Feriado::orderByDesc('fecha')->get();
		$prestador_menu = Prestador::where('user_id', '=', $user_id)->with('obrasocial')->get();
		return view('feriados', [
			'feriados' => $feriados,
			'prestador_menu' => $prestador_menu
		]);
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
		// Creo obra social
		$validate = $this->validate($request,[
			'feriado' => ['required']
		]);

		$feriado = new Feriado;
		$feriado->fecha = $request->feriado;
		$feriado->save();
		return redirect()->route('feriados')->with(['message' => 'El feriado ha sido guardado correctamente']);			
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Feriado  $feriado
     * @return \Illuminate\Http\Response
     */
    public function show(Feriado $feriado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Feriado  $feriado
     * @return \Illuminate\Http\Response
     */
    public function edit(Feriado $feriado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Feriado  $feriado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
		// Creo obra social
		$validate = $this->validate($request,[
			'feriado' => ['required']
		]);

		$feriado = Feriado::findOrFail($request->id);
		$feriado->fecha = $request->feriado;
		$feriado->save();
		return redirect()->route('feriados')->with(['message' => 'El feriado ha sido editado correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Feriado  $feriado
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		$feriado = Feriado::findOrFail($id);
		$feriado->delete();
		return redirect()->route('feriados')->with(['message' => 'El feriado ha sido eliminado correctamente']);
    }
}
