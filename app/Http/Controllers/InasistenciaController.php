<?php

namespace App\Http\Controllers;

use App\Inasistencia;
use App\Beneficiario;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\OSUtil;

class InasistenciaController extends Controller
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
        try{
			\DB::beginTransaction();
			$beneficiario = Beneficiario::where('id', $request['id_beneficiario'])->with(['inasistencia', 'agregado'])->get();
			$mes = \Auth::user()->mes;
			$anio = \Auth::user()->anio;
			
			foreach ($beneficiario as $key => $benef) {
				// Sesiones
				$inasistencias = $benef->inasistencia;
				$adicionales = $benef->agregado;
				$sesiones = $benef->sesion;
				$cant_solicitada = ($benef->tope != null ? $benef->tope : 999999);
				$totalDias = count($sesiones);
				$totalAgregado = count($benef->agregado);
				$fechas['total'][$benef->id] = OSUtil::cuenta_dias($mes, $anio, $sesiones, $cant_solicitada, $inasistencias);
				$fechas['inasistencias'][$benef->id] = OSUtil::cuenta_inasistencias($mes, $anio, $sesiones, $inasistencias);
				$fechas['agregado'][$benef->id] = OSUtil::cuenta_agregado($mes, $anio, $sesiones, $adicionales);
				$cuenta = array();
				foreach ($fechas['total'] as $key => $fecha) {
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
				if($request['agregarToForm'] == "Sacar" || $request['agregarToForm'] == "Inasistencia"){
					switch ($request['cantidad']) {
						case 'individual':
							foreach ($request['fechas'] as $key => $value) {
								
								$inasistencia = new Inasistencia;
								$inasistencia->beneficiario_id = $request['id_beneficiario'];
		
								if($value < 10 && strlen($value) < 2){
									$inasistencia->rango_fechas = '0'. $value . '/' . date('m/y');
									$filter_inasistencia = Inasistencia::where('rango_fechas', '0'. $value . '/' . date('m/y'))->where('beneficiario_id', $request['id_beneficiario'])->first();
									if($filter_inasistencia){
										throw new \Exception('La fecha a cargar ya existe'); 
									}
								}else{
									$inasistencia->rango_fechas = $value . '/' . date('m/y');
									$filter_inasistencia = Inasistencia::where('rango_fechas', $value . '/' . date('m/y'))->where('beneficiario_id', $request['id_beneficiario'])->first();
									if($filter_inasistencia){
										throw new \Exception('La fecha a cargar ya existe'); 
									}
								}
		
								if($request['agregarToForm'] == "Agregar"){
									$inasistencia->tipo = 'Agregado';
								}else{
									$inasistencia->tipo = 'Inasistencia';
								}
								$inasistencia->mes = date('m');
								$inasistencia->anio = date('Y');
								$inasistencia->save();
								\DB::commit();
								$inasistencias = Inasistencia::where('beneficiario_id', $request['id_beneficiario'])->get();
							}
								return [
									'success' => true,
									'message' => 'Fecha cargada correctamente.',
									'inasistencias' => $inasistencias
								];
							break;
						
						case 'rango':
							$filter_inasistencia = Inasistencia::where('rango_fechas', $request['fechas'])->where('beneficiario_id', $request['id_beneficiario'])->first();
							if($filter_inasistencia){
								throw new \Exception('La fecha a cargar ya existe'); 
							}
							$inasistencia = new Inasistencia;
							$inasistencia->beneficiario_id = $request['id_beneficiario'];
							$inasistencia->rango_fechas = $request['fechas'];
							$inasistencia->tipo = $request['agregarToForm'];
							$inasistencia->mes = $request['mes'];
							$inasistencia->anio = $request['anio'];
							$inasistencia->save();
							\DB::commit();
							$inasistencias = Inasistencia::where('beneficiario_id', $request['id_beneficiario'])->get();
							return [
								'success' => true,
								'message' => 'Rango de fechas cargadas correctamente.',
								'inasistencias' => $inasistencias
							];
							break;        
					}
				}else{
					// if((count($fechas['total'][$benef->id]) - count($fechas['inasistencias'][$benef->id]) + $totalAgregado) < $cant_solicitada){
					if((count($fechas['total'][$benef->id]) + $totalAgregado) < $cant_solicitada){
						switch ($request['cantidad']) {
							case 'individual':
								foreach ($request['fechas'] as $key => $value) {
									
									$inasistencia = new Inasistencia;
									$inasistencia->beneficiario_id = $request['id_beneficiario'];
			
									if($value < 10 && strlen($value) < 2){
										$inasistencia->rango_fechas = '0'. $value . '/' . date('m/y');
										$filter_inasistencia = Inasistencia::where('rango_fechas', '0'. $value . '/' . date('m/y'))->where('beneficiario_id', $request['id_beneficiario'])->first();
										if($filter_inasistencia){
											throw new \Exception('La fecha a cargar ya existe'); 
										}
									}else{
										$inasistencia->rango_fechas = $value . '/' . date('m/y');
										$filter_inasistencia = Inasistencia::where('rango_fechas', $value . '/' . date('m/y'))->where('beneficiario_id', $request['id_beneficiario'])->first();
										if($filter_inasistencia){
											throw new \Exception('La fecha a cargar ya existe'); 
										}
									}
			
									if($request['agregarToForm'] == "Agregar"){
										$inasistencia->tipo = 'Agregado';
									}else{
										$inasistencia->tipo = 'Inasistencia';
									}
									$inasistencia->mes = date('m');
									$inasistencia->anio = date('Y');
									$inasistencia->save();
									\DB::commit();
									$inasistencias = Inasistencia::where('beneficiario_id', $request['id_beneficiario'])->get();
								}
									return [
										'success' => true,
										'message' => 'Fecha cargada correctamente.',
										'inasistencias' => $inasistencias
									];
								break;
							
							case 'rango':
								$filter_inasistencia = Inasistencia::where('rango_fechas', $request['fechas'])->where('beneficiario_id', $request['id_beneficiario'])->first();
								if($filter_inasistencia){
									throw new \Exception('La fecha a cargar ya existe'); 
								}
								$inasistencia = new Inasistencia;
								$inasistencia->beneficiario_id = $request['id_beneficiario'];
								$inasistencia->rango_fechas = $request['fechas'];
								$inasistencia->tipo = $request['agregarToForm'];
								$inasistencia->mes = $request['mes'];
								$inasistencia->anio = $request['anio'];
								$inasistencia->save();
								\DB::commit();
								$inasistencias = Inasistencia::where('beneficiario_id', $request['id_beneficiario'])->get();
								return [
									'success' => true,
									'message' => 'Rango de fechas cargadas correctamente.',
									'inasistencias' => $inasistencias
								];
								break;        
						}							
					}else{
						Throw new \Exception('Limite de fechas alcanzado.');
					}
				}
				
			}
        }catch(Exception $e){
			\DB::rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inasistencia  $inasistencia
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $inasistencias = Inasistencia::where('beneficiario_id', $request['id'])->get();
        return [
            'success' => true,
            'inasistencias' => $inasistencias
        ];

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inasistencia  $inasistencia
     * @return \Illuminate\Http\Response
     */
    public function edit(Inasistencia $inasistencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inasistencia  $inasistencia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inasistencia $inasistencia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inasistencia  $inasistencia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $inasistencia = Inasistencia::find($request['id']);
        if($inasistencia->delete()){
            $inasistencias = Inasistencia::where('beneficiario_id', $request['id_beneficiario'])->get();
            return [
                'success' => true,
                'message' => 'Inasistencia eliminada correctamente.',
                'inasistencias' => $inasistencias
            ];
        }else{
            return [
                'success' => false,
                'message' => 'La inasistencia no pudo ser eliminada. Por favor intente nuevamente.'
            ];
        }
    }
}
