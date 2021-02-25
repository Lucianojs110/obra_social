<?php

namespace App\Http\Controllers;

use App\Sesion;
use App\Beneficiario;
use Illuminate\Http\Request;

class SesionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->id;
        $beneficiario = Beneficiario::where('id', $id)->first();
		$sesiones = Sesion::where('beneficiario_id', $id)->with('beneficiario')->get()->toArray();
		$fin_sesion = array();
		foreach ($sesiones as $k => $sesion) {
			$horario = $sesion['hora'];
			$tiempo = $sesion['tiempo'];
			$hor=new \DateTime($horario);
			$fin=$hor->add( new \DateInterval( 'PT' . ( (integer) $tiempo ) . 'M' ) );
			$fecha_fin = $fin->format( 'H:i' );
			$fin_sesion[$k] = $fecha_fin;
		}
        return [
            'sesiones' => $sesiones,
			'beneficiario' => $beneficiario,
			'fin_sesion' => $fin_sesion,
        ];
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
		$beneficiario_id = $request->beneficiario_id;
		$beneficiario = Beneficiario::where('id', $beneficiario_id)->first();
		$fin_sesion = array();
		foreach($request->dia as $k => $v){	
			$sesiones = Sesion::where('beneficiario_id', $beneficiario_id)->get();
			$sess = $sesiones;
			foreach ($sess as $k => $sesion2) {
				$horario = $sesion2['hora'];
				$tiempo = $sesion2['tiempo'];
				$hor=new \DateTime($horario);
				$fin=$hor->add( new \DateInterval( 'PT' . ( (integer) $tiempo ) . 'M' ) );
				$fecha_fin = $fin->format( 'H:i' );
				$fin_sesion[$k] = $fecha_fin;
			}	
			foreach ($sesiones as $key => $sesion) {
				if($v == $sesion->dia){
					return json_encode([
						'error' => true,
						'message' => 'Una de las fechas seleccionadas ya se encuentra cargada en el sistema. Por favor intente nuevamente.',
						'sesiones' => $sesiones,
						'fin_sesion' => $fin_sesion
					]);					
				}
			}
			// if($beneficiario->cantidad_solicitada == 4 && count($sesiones) < 1 || $beneficiario->cantidad_solicitada == 8 && count($sesiones) < 2 || $beneficiario->cantidad_solicitada == 12 && count($sesiones) < 4){
	
			if(isset($request['tope']) && $request['tope'] > 0){
				$beneficiario->tope = $request['tope'];
				$beneficiario->save();
			}
	
			$validate = \Validator::make($request->all(), [
				'dia' => 'required',
				'hora' => 'required',
				'tiempo' => 'required'
			]);
	
			if($validate->fails()){
				return [
					'error' => 'Los campos día, hora y tiempo son obligatorios. Por favor completelos e intente nuevamente.',
					'sesiones' => $sesiones,
					'fin_sesion' => $fin_sesion
				];
			}
	
			$sesion = new Sesion;
			$obra_social = $request->obrasocial_id;
			$dia = $v;
			$hora = $request->hora;
			$tiempo = $request->tiempo;
			$sesion->beneficiario_id = $beneficiario_id;
			$sesion->dia = $dia;
			$sesion->hora = $hora;
			$sesion->tiempo = $tiempo; 
			if($sesion->save()){
				$sesiones = Sesion::where('beneficiario_id', $beneficiario_id)->get();
				foreach ($sesiones as $k => $sesion) {
					$horario = $sesion['hora'];
					$tiempo = $sesion['tiempo'];
					$hor=new \DateTime($horario);
					$fin=$hor->add( new \DateInterval( 'PT' . ( (integer) $tiempo ) . 'M' ) );
					$fecha_fin = $fin->format( 'H:i' );
					$fin_sesion[$k] = $fecha_fin;
				}	                     
			}
		}
		return json_encode(['error' => false,
							'sesiones' => $sesiones,
							'fin_sesion' => $fin_sesion]);
        // }else{
        //     return json_encode(['error' => 'Hay un error con la cantidad solicitada y los días a cargar. Por favor verifiquelos e intente nuevamente.',
        //                         'sesiones' => $sesiones]);
        // }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sesion  $sesion
     * @return \Illuminate\Http\Response
     */
    public function show(Sesion $sesion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sesion  $sesion
     * @return \Illuminate\Http\Response
     */
    public function edit(Sesion $sesion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sesion  $sesion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sesion $sesion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sesion  $sesion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $sesion = Sesion::find($request->id);
        $sesion->delete();

        $beneficiario_id = $request->beneficiario_id;
        $sesiones = Sesion::where('beneficiario_id', $beneficiario_id)->get();
        return $sesiones;
    }
}
