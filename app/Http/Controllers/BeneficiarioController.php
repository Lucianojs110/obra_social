<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use Illuminate\Http\Response;

use App\Prestador;
use App\Inactivo;

use App\User;

use App\Beneficiario;

use App\ObraSocial;

use App\Sesion;

use App\Traditum;

use App\Feriado;

use App\Prestacion;

use App\Helpers\OSUtil;

use Auth;

use DateTime;


class BeneficiarioController extends Controller

{

	public function __construct()

    {

        $this->middleware('auth');

	}





    public function index($prest_id, $os_id, $mes = null, $anio = null)

    {

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

        $prestacion = Prestador::where('user_id', $user)

        ->where('os_id', $os_id)

        ->with('prestacion')

        ->get();



        //$beneficiario = Beneficiario::where('prestador_id', $prest_id)->with('prestador')->get();



        // Traigo beneficiarios segun prestador y obra social

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



    	return view('beneficiario',[

    		'data' => $data

    	]);

	}

	

	public function beneficiariosInactivos($user_id)

	{

		// Prestador con beneficiarios

		//$beneficiarios = Prestador::with('beneficiarioInactivo', 'obrasocial', 'prestacion')

		//->where('prestador.user_id', $user_id)->get();

        $beneficiarios = \DB::select("SELECT i.id,i.fecha,i.fecha_fin,b.nombre,b.apellido, o.nombre as obrasocial,po.os_id,pn.nombre as prestacion FROM inactivos as i LEFT JOIN beneficiario as b ON i.id_ben=b.id LEFT JOIN prestador as po on po.id=b.prestador_id LEFT JOIN prestacion as pn ON po.prestacion_id=pn.id LEFT JOIN obrasocial AS o on po.os_id = o.id WHERE po.user_id = " . $user_id);


		// Objeto Menu prestador

		$prestador_menu = \DB::select("SELECT obrasocial.nombre, obrasocial.id FROM obrasocial LEFT JOIN prestador on prestador.os_id = obrasocial.id WHERE prestador.user_id = " . $user_id . " GROUP BY obrasocial.id, obrasocial.nombre");



		return view('beneficiarios-inactivos', [

			'beneficiarios' => $beneficiarios,

			'prestador_menu' => $prestador_menu

		]);

	}



	public function inactiveStatus(Request $request)

	{   
		$id = $request->input('id');
		$id_os = $request->input('id_os');
		$fecha_fin = $request->input('fecha_fin');
		$fecha = $request->input('fecha');
		$date1 = new DateTime($fecha."-01");
		$date2 = new DateTime($fecha_fin ."-01");


		$obra_social = ObraSocial::where('id', $id_os)->first();
		if($date2<=$date1){
				return redirect()->route('beneficiarios.inactivos', ['prestador_id' => \Auth::user()->id, 'obrasocial_id' => $obra_social])

				->with(['message' => 'Verifique que la fecha de activación sea mayor a la fecha de inactivo']);

		}
        $Inactivo = Inactivo::find($id);
        $Inactivo->fecha_fin = $fecha_fin."-01";

        if($Inactivo->save()){

            return redirect()->route('beneficiarios.inactivos', ['prestador_id' => \Auth::user()->id, 'obrasocial_id' => $obra_social])

            ->with(['message' => 'El estado del beneficiario ha sido actualizado correctamente']);

        }

	}



    public function create(Request $request)

    { date_default_timezone_set('America/Argentina/Buenos_Aires');

        // Objeto de beneficiario

        $beneficiario = new Beneficiario;



        // Obtengo datos de inputs

        $obra_social = $request->input('obraSocial');

        $prestador = $request->input('prestacion');

        $nombre = $request->input('nombre');

        $correo = $request->input('correo');

        $telefono = $request->input('telefono');

        $direccion = $request->input('direccion');

        $localidad = $request->input('localidad');

        $direccion_prestacion = $request->input('direccionPrestacion');

        $localidad_prestacion = $request->input('localidadPrestacion');

        $dni = $request->input('dni');

        $cuit = $request->input('cuit');

        $discapacidad = $request->input('discapacidad');
        




        if(\Auth::user()->role == 'Traslado'){

            $km_ida = $request->input('kmIda');

            $km_vuelta = $request->input('kmVuelta');

            $viajes_ida = $request->input('viajesIda');

            $viajes_vuelta = $request->input('viajesVuelta');

            $dependencia = $request->input('dependencia');

        }



        $turno = $request->input('turno');

        $notas = $request->input('notas');

        $numero_afiliado = $request->input('numero_afiliado');

        $codigo_seguridad = $request->input('codigo_seguridad');

        $cantidad_solicitada = $request->input('cantidad_solicitada');

        $transporte_a = $request->input('transporte_a');

        $profesion = $request->input('profesion');

        $provincia = $request->input('provincia');
        
        $id_provincia_prestacion = $request->input('id_provincia_prestacion');

        $consentimiento = $request->input('consentimiento');



        // Asigno inputs a objeto beneficiario

        $beneficiario->prestador_id = $prestador;

        $beneficiario->sesion_id = 1;

        $beneficiario->nombre = $nombre;

        $beneficiario->email = $correo;

        $beneficiario->telefono = $telefono;

        $beneficiario->direccion = $direccion;

        $beneficiario->localidad = $localidad;

        $beneficiario->dni = $dni;

        $beneficiario->cuit = $cuit;

        $beneficiario->direccion_prestacion = $direccion_prestacion;

        $beneficiario->localidad_prestacion = $localidad_prestacion;



        if(\Auth::user()->role == 'Traslado'){

            $beneficiario->km_ida = $km_ida;

            $beneficiario->km_vuelta = $km_vuelta;

            $beneficiario->viajes_ida = $viajes_ida;

            $beneficiario->viajes_vuelta = $viajes_vuelta;

            $beneficiario->dependencia = $dependencia;

        }



        $beneficiario->turno = $turno;

        $beneficiario->notas = $notas;

        $beneficiario->numero_afiliado = $numero_afiliado;

        $beneficiario->codigo_seguridad = $codigo_seguridad;

        $beneficiario->cantidad_solicitada = $cantidad_solicitada;

        $beneficiario->transporte_a =  $transporte_a;

        $beneficiario->profesion =  $profesion;

        $beneficiario->discapacidad =  $discapacidad;

        $beneficiario->id_provincia =  $provincia;

        $beneficiario->consentimiento =  $consentimiento;

        $beneficiario->id_provincia_prestacion =  $id_provincia_prestacion;
        $mes = $request->input('mes');
        $anio = $request->input('anio');
        $mes_aux = date("m");
        $anio_aux = date("Y");
        $date1 = new DateTime($anio."-".$mes."-".date("d"));
        $date2 = new DateTime(date("Y-m-d"));
        if($date1 <= $date2){
            $dia = "01";
            $horas = "00:00:00";
            $beneficiario->created_at = $anio."-".$mes."-".$dia." ".$horas;
        }


        
        
        



		// Guardo en DB

		$beneficiario->save();

		\Session::flash('BeneficiarioNombre', $beneficiario->nombre);

		\Session::flash('ModificacionBeneficiario', $beneficiario->id);

        // Traditum

        $traditum = new Traditum;

        $traditum->beneficiario_id = $beneficiario['id'];

        $traditum->codigo = $request->input('codigo_traditum');   

        $traditum->mes = date('m');

        $traditum->anio = date('Y');

        $traditum->save(); 



        return redirect()->route('beneficiarios', ['prestador_id' => \Auth::user()->id, 'obrasocial_id' => $obra_social])

            ->with(['message' => 'Los datos de beneficiario han sido guardados correctamente']);

    }



    public function list(Request $request)

    {

        // Busco objeto segun ID

        $beneficiario = Beneficiario::where('id', '=', $request->id)->with('prestador')->withTrashed()->get();



        // Obtengo prestacion

        $prestacion = Prestador::where('id', $beneficiario[0]->prestador->id)->with(['prestacion', 'obrasocial'])->get();



        // Traditum

        $traditum = Traditum::where('beneficiario_id', '=', $request->id)->get();

        

        return json_encode(['beneficiario' => $beneficiario, 'prestacion' => $prestacion[0]->prestacion[0]->nombre, 'traditum' => $traditum, 'prestacion_completa' => $prestacion]);

    }



    public function delete($os_id, $beneficiario_id)

    {

		// Borro beneficiario

		$beneficiario = Beneficiario::find($beneficiario_id);

        $beneficiario->fecha_inactivo =  \Auth::user()->anio.'-'.\Auth::user()->mes.'-01';
        $beneficiario->activo =0;
        $beneficiario->save(); 

			return redirect()->route('beneficiarios', ['prestador_id' => \Auth::user()->id, 'obrasocial_id' => $os_id])

			->with(['message' => 'El beneficiario ha sido eliminado correctamente']);
 

	}

	public function InactivoDelete($os_id, $id)

    {

        // Borro beneficiario
        $Inactivo = Inactivo::find($id);
 
        if($Inactivo->delete()){
            return redirect()->route('beneficiarios.inactivos', ['prestador_id' => \Auth::user()->id, 'obrasocial_id' => $os_id])

            ->with(['message' => 'Dato eliminado']);
        }


    }

	public function beneficiarioInactivoDelete($os_id, $beneficiario_id)

    {

		// Borro beneficiario

		$beneficiario = Beneficiario::find($beneficiario_id);

        $beneficiario->fecha_inactivo =  \Auth::user()->anio.'-'.\Auth::user()->mes.'-01';
        $beneficiario->activo =0;
        $beneficiario->save(); 

			return redirect()->route('beneficiarios.inactivos', ['prestador_id' => \Auth::user()->id, 'obrasocial_id' => $os_id])

			->with(['message' => 'El beneficiario ha sido eliminado correctamente']);


    }



    public function presupuesto($prestador_id, $beneficiario_id)

    {

        // $prestador = Prestador::where('id', '=', $prestador_id)->with('user')->get();

		// $beneficiario = Beneficiario::find($beneficiario_id);

		$prestador = Prestador::where('id', '=', $prestador_id)->with('user', 'prestacion')->get();

		$beneficiario = Beneficiario::with('sesion')->find($beneficiario_id);

		foreach($beneficiario->sesion as $k => $sesion){

			switch($sesion->dia){

				case 1:

					$dia = 'Lunes';

					break;



				case 2:

					$dia = 'Martes';

					break;



				case 3:

					$dia = 'Miercoles';

					break;



				case 4:

					$dia = 'Jueves';

					break;

					

				case 5:

					$dia = 'Viernes';

					break;



				case 6:

					$dia = 'Sabado';

					break;



				case 7:

					$dia = 'Domingo';

					break;



				default:

					break;

			}

			$horario = $sesion['hora'];

			$tiempo = $sesion['tiempo'];

			$hor=new \DateTime($horario);

			$fin=$hor->add( new \DateInterval( 'PT' . ( (integer) $tiempo ) . 'M' ) );

			$fecha_fin = $fin->format( 'H:i' );

			$sesion->fecha_fin = $fecha_fin;

			$beneficiario->sesion[$dia] = $sesion;

			unset($beneficiario->sesion[$k]);

		}

        return view('forms.8_4', [

            'prestador' => $prestador,

            'beneficiario' => $beneficiario,

        ]);

	}

	

	public function presupuestoTraslado($prestador_id, $beneficiario_id)

    {

        $prestador = Prestador::where('id', '=', $prestador_id)->with('user', 'prestacion')->get();

		$beneficiario = Beneficiario::with('sesion')->find($beneficiario_id);

		foreach($beneficiario->sesion as $k => $sesion){

			switch($sesion->dia){

				case 1:

					$dia = 'Lunes';

					break;



				case 2:

					$dia = 'Martes';

					break;



				case 3:

					$dia = 'Miercoles';

					break;



				case 4:

					$dia = 'Jueves';

					break;

					

				case 5:

					$dia = 'Viernes';

					break;



				case 6:

					$dia = 'Sabado';

					break;



				case 7:

					$dia = 'Domingo';

					break;



				default:

					break;

			}

			$horario = $sesion['hora'];

			$tiempo = $sesion['tiempo'];

			$hor=new \DateTime($horario);

			$fin=$hor->add( new \DateInterval( 'PT' . ( (integer) $tiempo ) . 'M' ) );

			$fecha_fin = $fin->format( 'H:i' );

			$sesion->fecha_fin = $fecha_fin;

			$beneficiario->sesion[$dia] = $sesion;

			unset($beneficiario->sesion[$k]);

		}

        return view('forms.8_5', [

            'prestador' => $prestador,

            'beneficiario' => $beneficiario,

        ]);

    }



    public function update(Request $request)

    {

        // Objeto de beneficiario

        $beneficiario = Beneficiario::find($request->id);
  

        // Obtengo datos de inputs

        $obra_social = $request->input('editarObraSocial');

        $nombre = $request->input('editarNombre');

        $correo = $request->input('editarCorreo');

        $telefono = $request->input('editarTelefono');

        $direccion = $request->input('editarDireccion');

        $localidad = $request->input('editarLocalidad');

        $direccion_prestacion = $request->input('editarDireccionPrestacion');

        $localidad_prestacion = $request->input('editarLocalidadPrestacion');

        $dni = $request->input('editarDni');

		$cuit = $request->input('editarCuit');



        if(\Auth::user()->role == 'Traslado'){

            $km_ida = $request->input('editarKmIda');

            $km_vuelta = $request->input('editarKmVuelta');

            $viajes_ida = $request->input('editarViajesIda');

            $viajes_vuelta = $request->input('editarViajesVuelta');

			$dependencia = $request->input('editarDependencia');

			$dias_mensuales = $request->input('editarDiasMensuales');

        }



        $turno = $request->input('editarTurno');

        $notas = $request->input('editarNotas');

        $numero_afiliado = $request->input('editar_numero_afiliado');

        $codigo_seguridad = $request->input('editar_codigo_seguridad');

        $cantidad_solicitada = $request->input('editar_cantidad_solicitada');

        $transporte_a = $request->input('editarTransporte_a');

        $profesion = $request->input('editarprofesion');

        $discapacidad = $request->input('editardiscapacidad');

        $provincia = $request->input('editarprovincia');

        $id_provincia_prestacion = $request->input('editarid_provincia_prestacion');

        $consentimiento = $request->input('editarconsentimiento');
        
        





        // Asigno inputs a objeto beneficiario

        $beneficiario->nombre = $nombre;

        $beneficiario->email = $correo;

        $beneficiario->telefono = $telefono;

        $beneficiario->direccion = $direccion;

        $beneficiario->localidad = $localidad;

        $beneficiario->dni = $dni;

        $beneficiario->cuit = $cuit;

        $beneficiario->direccion_prestacion = $direccion_prestacion;

        $beneficiario->localidad_prestacion = $localidad_prestacion;



        if(\Auth::user()->role == 'Traslado'){

            $beneficiario->km_ida = $km_ida;

            $beneficiario->km_vuelta = $km_vuelta;

            $beneficiario->viajes_ida = $viajes_ida;

            $beneficiario->viajes_vuelta = $viajes_vuelta;

			$beneficiario->dependencia = $dependencia;

			$beneficiario->dias_mensuales = $dias_mensuales;

        }



        $beneficiario->turno = $turno;

        $beneficiario->notas = $notas;

        $beneficiario->numero_afiliado = $numero_afiliado;

        $beneficiario->codigo_seguridad = $codigo_seguridad;

        $beneficiario->cantidad_solicitada = $cantidad_solicitada;
        
        $beneficiario->transporte_a = $transporte_a;

       // $beneficiario->profesion = $profesion;
        $beneficiario->discapacidad = $discapacidad;

        $beneficiario->id_provincia =  $provincia;
        $beneficiario->id_provincia_prestacion =  $id_provincia_prestacion;
        $beneficiario->consentimiento =  $consentimiento;



        // Guardo en DB

		$beneficiario->save();

		\Session::flash('BeneficiarioNombre', $beneficiario->nombre);

		\Session::flash('ModificacionBeneficiario', $beneficiario->id);

        // Traditum

        $traditum = Traditum::where('beneficiario_id', $request->id)->first();

        if($traditum == null){

            $traditum = new Traditum;

            $traditum->beneficiario_id = $request->id;

            $traditum->codigo = $request->input('editar_codigo_traditum');   

            $traditum->mes = date('m');

            $traditum->anio = date('Y');

			$traditum->save();

		}  

        // }else{

        //     $traditum->codigo = $request->input('editar_codigo_traditum');   

        //     $traditum->mes = date('m');

        //     $traditum->anio = date('Y');

        //     $traditum->save();

        // }

        return redirect()->route('beneficiarios', ['prestador_id' => \Auth::user()->id, 'obrasocial_id' => $obra_social])

            ->with(['message' => 'Los datos de beneficiario han sido actualizados correctamente']);

    }



    public function formulario($bene_id, $prestador_id, $planilla, $mes = null, $anio = null)

    {

		switch ($planilla) {

			case 1:

				$view = 'forms.rehabilitacion';

				break;



			case 2:

				$view = 'forms.integracion';

				break;



			case 3:

				$view = 'forms.traslado';

				break;



			case 4:

				$view = 'forms.3_2';

				break;



			case 5:

				$view = 'forms.3_5';

				break;



			case 6:

				$view = 'forms.3_3';

				break;

			

			case 7:

				$view = 'forms.3_6';

				break;

		}



        $beneficiario_id = $bene_id;

        if($mes == null){

            $mes = date('m');           

        }



        if($anio == null){

            $anio = date('Y');           

        }

		

		// Fechas V2

		$beneficiario = Beneficiario::where('id', $beneficiario_id)->with(['prestador', 'sesion', 'inasistencia'])->get();

		$prestador = Prestador::where('id', $prestador_id)->with('prestacion')->get();

		$fechas = array();

		foreach ($beneficiario as $key => $benef) {

			// Sesiones

			$inasistencias = $benef->inasistencia;

			$adicionales = $benef->agregado;

			$sesiones = $benef->sesion;

			$cant_solicitada = $benef->tope;

			$totalDias = count($sesiones);

			if($prestador[0]->quitar_feriado == 'Si'){

				$feriados = Feriado::get();

				$fechas['feriados'][$benef->id] = OSUtil::cuenta_feriados($mes, $anio, $sesiones, $feriados);

			}

			$fechas['total'][$benef->id] = OSUtil::cuenta_dias($mes, $anio, $sesiones, $cant_solicitada, $inasistencias);

			$fechas['inasistencias'][$benef->id] = OSUtil::cuenta_inasistencias($mes, $anio, $sesiones, $inasistencias);

			$fechas['agregado'][$benef->id] = OSUtil::cuenta_agregado($mes, $anio, $sesiones, $adicionales);

			$fechas['total_agregado'][$benef->id] = count($benef->agregado);
            foreach($benef->sesion as $k => $sesion){

            switch($sesion->dia){

                case 1:

                    $dia = 'Lunes';

                    break;



                case 2:

                    $dia = 'Martes';

                    break;



                case 3:

                    $dia = 'Miercoles';

                    break;



                case 4:

                    $dia = 'Jueves';

                    break;

                    

                case 5:

                    $dia = 'Viernes';

                    break;



                case 6:

                    $dia = 'Sabado';

                    break;



                case 7:

                    $dia = 'Domingo';

                    break;



                default:

                    break;

            }

            $horario = $sesion['hora'];

            $tiempo = $sesion['tiempo'];

            $hor=new \DateTime($horario);

            $fin=$hor->add( new \DateInterval( 'PT' . ( (integer) $tiempo ) . 'M' ) );

            $fecha_fin = $fin->format( 'H:i' );

            $sesion->fecha_fin = $fecha_fin;

            $benef->sesion[$dia] = $sesion;

            unset($benef->sesion[$k]);

        }

		}



		// Sumario de fechas

		if($prestador[0]->quitar_feriado == 'Si'){

			foreach($fechas['feriados'] ?? [] as $k => $fch){

				foreach($fch as $k2 => $fch2){

					foreach($fechas['total'] as $k3 => $fch3){

						foreach($fch3 as $k4 => $fch4){

							if($k4 == $k2){

								unset($fechas['total'][$k3][$k4]);

								if($prestador[0]->mover_dias == "Si"){

									$fechas['total'][$k3][$k4] = $fch2;

								}

							}

						}

					}

				}

			}

		}



		$cuenta = array();

		$fechasParaBorrar = array();

		foreach ($fechas['total'] ?? [] as $key => $fecha) {

            $cuenta[$key] = 0;

			foreach($fecha as $k => $v){

				$cuenta[$key]++;

				$fecha_individual = explode('/', $v);

				foreach($fechas['inasistencias'][$key] as $inasistencia){

					$inasistencia_individual = explode('/', $inasistencia);	

					if($fecha_individual[0].'/'.$fecha_individual[1].'/'.$fecha_individual[2] == $inasistencia_individual[0].'/'.$inasistencia_individual[1].'/'.$inasistencia_individual[2]){

						$cuenta[$key]--;

						$fechasParaBorrar[$k] = $key; 

					}

				}	

				foreach ($fechas['agregado'] as $keyAgregado => $fechaAgregado) {

					foreach($fechaAgregado as $diaAgregado => $fechaAgr){

						$fechas['total'][$keyAgregado][$diaAgregado] = $fechaAgr;

					}

				}		

			}

			$fechas['tope'][$key] = $cuenta;

		}

		foreach ($fechasParaBorrar as $ind => $benefId) {

			unset($fechas['total'][$benefId][$ind]);

			ksort($fechas['total'][$benefId]);

		}

		ksort($fechas['total'][$beneficiario[0]->id]);

        // $merged = array_merge(...$fechas);

		// sort($merged, SORT_NUMERIC);

		// dd($merged);

		// Traigo mes actual

        $mes = date('m');

            switch ($mes){

        case '1':

            $mes = 'Enero';

            break;

        case '2':

            $mes = 'Febrero';

            break;

        case '3':

            $mes = 'Marzo';

            break;

        case '4':

            $mes = 'Abril';

            break;

        case '5':

            $mes = 'Mayo';

            break;

        case '6':

            $mes = 'Junio';

            break;

        case '7':

            $mes = 'Julio';

            break;

        case '8':

            $mes = 'Agosto';

            break;

        case '9':

            $mes = 'Septiembre';

            break;

        case '10':

            $mes = 'Octubre';

            break;

        case '11':

            $mes = 'Noviembre';

            break;

        case '12':

            $mes = 'Diciembre';

            break;

    }



        return view($view, [

            'fechas' => $fechas,

            'prestador' => $prestador,

            'beneficiario' => $beneficiario,

            'mes' => $mes,

        ]);

    }



    public function status($id, $id_os, $status){

        $obra_social = ObraSocial::where('id', $id_os)->first();

        $beneficiario = Beneficiario::where('id', $id)->first();

        $Inactivo = new Inactivo;

        $Inactivo->id_ben = $id;
        if(\Auth::user()->mes){
            $mes = \Auth::user()->mes;
        }else{
            $mes = date("m");
        }
        $Inactivo->fecha =  \Auth::user()->anio.'-'.$mes .'-01';

        if($Inactivo->save()){

            return redirect()->route('beneficiarios', ['prestador_id' => \Auth::user()->id, 'obrasocial_id' => $obra_social])

            ->with(['message' => 'El estado del beneficiario ha sido inactivado correctamente']);

        }

    }



    public function traditum(Request $request)

    {

        $traditum = Traditum::where('id', $request['traditum'])->first();

        if($traditum){

            $traditum->codigo = $request['valor'];

            $traditum->save();

        }else{

            $traditum = new Traditum;

            $traditum->codigo = $request['valor'];

            $traditum->beneficiario_id = $request['beneficiario'];

            $traditum->mes = date('m');

            $traditum->anio = date('Y');

            $traditum->save();

        }

    }



    public function tope(Request $request)

    {

        $beneficiario = Beneficiario::where('id', $request['id'])->first();

        $beneficiario->tope = $request['tope'];

        if($beneficiario->save()){

            return [

                'success' => true,

                'message' => 'Tope cargado correctamente.'

            ];

        }else{

            return [

                'success' => false,

                'message' => 'El tope no ha podido ser cargado. Por favor intente nuevamente.'

            ];

        }

	}



	

	public function planillaFacturacion($prestador_id, $os, $mes, $anio){

		$user = Auth::user();

		$prestador = Prestador::select('id', 'prestacion_id')->with(['prestacion', 'beneficiario'])

		->where('os_id', $os)

		->where('user_id', $user->id)->get();



		// Agrupando beneficiarios

		$beneficiarios = array();

		foreach($prestador as $k => $v){

			$codigo_modulo = $v->prestacion[0]->codigo_modulo;

			foreach($v->beneficiario as $k2 => $v2){

				$v2->codigo_modulo = $codigo_modulo;

				$v2->traditum = Traditum::select('codigo')->where('beneficiario_id', $v2->id)->where('mes', $mes)->where('anio', $anio)->first();		

				$beneficiarios[] = $v2;

			}

		}



		// Paginando de a 17

		$grupo = 0;

		$indice = 0;

		$beneficiariosAgrupados = array();

		$sortBenefs = usort($beneficiarios, function($a, $b){

			return strcmp($a->nombre, $b->nombre);

		});

		foreach($beneficiarios as $benef){	

			if($indice > 16){

				$grupo++;

				$indice = 0;

			}

			$beneficiariosAgrupados[$grupo][] = $benef;

			$indice++;

		}

		return view('beneficiarios-facturacion', ['informacion' => $beneficiariosAgrupados]);

	}



	public function planillaFacturacionTraslado($prestador_id, $os, $mes, $anio){

		$user = Auth::user();

		$prestador = Prestador::select('id', 'prestacion_id', 'valor_default', 'valor_prestacion', 'numero_prestador')->with(['prestacion', 'beneficiario'])

		->where('os_id', $os)

		->where('user_id', $user->id)->get();

		// Agrupando beneficiarios

		$beneficiarios = array();

		foreach($prestador as $k => $v){

			$codigo_modulo = $v->prestacion[0]->codigo_modulo;

			foreach($v->beneficiario as $k2 => $v2){

				$v2->codigo_prestador = $v->numero_prestador;

				$v2->codigo_modulo = $codigo_modulo;

				$v2->traditum = Traditum::select('codigo')->where('beneficiario_id', $v2->id)->where('mes', $mes)->where('anio', $anio)->first();		

				$beneficiarios[] = $v2;

				if($v->valor_default == 'T'){

					$v2->importe_unitario = $v->prestacion[0]->valor_modulo;

				}else{

					$v2->importe_unitario = $v->valor_prestacion;

				}

				if($v2->dependencia == 'Si'){

					$v2->importe_dependencia = Prestacion::select('valor_modulo')->where('codigo_modulo', '6501024')->first();

				}else{

					$v2->importe_dependencia = array('valor_modulo' => 0);

				}

				

			}

		}



		// Paginando de a 17

		$grupo = 0;

		$indice = 0;

		$beneficiariosAgrupados = array();

		$sortBenefs = usort($beneficiarios, function($a, $b){

			return strcmp($a->nombre, $b->nombre);

		});

		foreach($beneficiarios as $benef){	

			if($indice > 21){

				$grupo++;

				$indice = 0;

			}



			// Fechas

			$inasistencias = $benef->inasistencia;

			$adicionales = $benef->agregado;

			$sesiones = $benef->sesion;

			$cant_solicitada = $benef->tope;

			$totalDias = count($sesiones);

			if($prestador[0]->quitar_feriado == 'Si'){

				$feriados = Feriado::get();

				$fechas['feriados'][$benef->id] = OSUtil::cuenta_feriados($mes, $anio, $sesiones, $feriados);

			}

			$fechas['total'][$benef->id] = OSUtil::cuenta_dias($mes, $anio, $sesiones, $cant_solicitada, $inasistencias);

			$fechas['inasistencias'][$benef->id] = OSUtil::cuenta_inasistencias($mes, $anio, $sesiones, $inasistencias);

			$fechas['agregado'][$benef->id] = OSUtil::cuenta_agregado($mes, $anio, $sesiones, $adicionales);

			$fechas['total_agregado'][$benef->id] = count($benef->agregado);

			



			// Sumario de fechas

			if($prestador[0]->quitar_feriado == 'Si'){

				foreach($fechas['feriados'] ?? [] as $k => $fch){

					foreach($fch as $k2 => $fch2){

						foreach($fechas['total'] as $k3 => $fch3){

							foreach($fch3 as $k4 => $fch4){

								if($k4 == $k2){

									unset($fechas['total'][$k3][$k4]);

									if($prestador[0]->mover_dias == "Si"){

										$fechas['total'][$k3][$k4] = $fch2;

									}

								}

							}

						}

					}

				}

			}



			$cuenta = array();

			$fechasParaBorrar = array();

			foreach ($fechas['total'] ?? [] as $key => $fecha) {

				$cuenta[$key] = 0;

				foreach($fecha as $k => $v){

					$cuenta[$key]++;

					$fecha_individual = explode('/', $v);

					foreach($fechas['inasistencias'][$key] as $inasistencia){

						$inasistencia_individual = explode('/', $inasistencia);	

						if($fecha_individual[0].'/'.$fecha_individual[1].'/'.$fecha_individual[2] == $inasistencia_individual[0].'/'.$inasistencia_individual[1].'/'.$inasistencia_individual[2]){

							$cuenta[$key]--;

							$fechasParaBorrar[$k] = $key; 

						}

					}	

					foreach ($fechas['agregado'] as $keyAgregado => $fechaAgregado) {

						foreach($fechaAgregado as $diaAgregado => $fechaAgr){

							$fechas['total'][$keyAgregado][$diaAgregado] = $fechaAgr;

						}

					}		

				}

				$fechas['tope'][$key] = $cuenta;

			}

			foreach ($fechasParaBorrar as $ind => $benefId) {

				unset($fechas['total'][$benefId][$ind]);

				ksort($fechas['total'][$benefId]);

			}

			$benef->total_fechas = count($fechas['total'][$benef->id]);

			$benef->km_dia = (($benef->km_ida ?? 0) + ($benef->km_vuelta ?? 0));

			$benef->km_mes = ($benef->km_dia ?? 0) * ($benef->total_fechas ?? 0);

			$benef->importe_total = str_replace('.',',', str_replace(',','.',(floatval(str_replace(',', '.', str_replace('.', '', ($benef->importe_dependencia['valor_modulo'] ?? 0)))) + floatval(str_replace(',', '.', str_replace('.', '', ($benef->importe_unitario ?? 0))))) * $benef->km_mes));

			$beneficiariosAgrupados[$grupo][] = $benef;

			$indice++;

		}

		return view('beneficiarios-facturacion-traslado', ['informacion' => $beneficiariosAgrupados]);

	}



	public function planillaAsistenciaTraslado($prestador_id, $os, $mes, $anio){

		$user = Auth::user();

		$prestador = Prestador::select('id', 'prestacion_id')->with(['prestacion', 'beneficiario'])

		->where('os_id', $os)

		->where('user_id', $user->id)->get();



		// Agrupando beneficiarios

		$beneficiarios = array();

		foreach($prestador as $k => $v){

			$codigo_modulo = $v->prestacion[0]->codigo_modulo;

			foreach($v->beneficiario as $k2 => $v2){

				$v2->codigo_modulo = $codigo_modulo;

				$v2->traditum = Traditum::select('codigo')->where('beneficiario_id', $v2->id)->where('mes', $mes)->where('anio', $anio)->first();		

				$beneficiarios[] = $v2;

			}

		}



		// Paginando de a 6

		$grupo = 0;

		$indice = 0;

		$beneficiariosAgrupados = array();

		$sortBenefs = usort($beneficiarios, function($a, $b){

			return strcmp($a->nombre, $b->nombre);

		});

		foreach($beneficiarios as $benef){	

			if($indice > 6){

				$grupo++;

				$indice = 0;

			}



			// Fechas

			$inasistencias = $benef->inasistencia;

			$adicionales = $benef->agregado;

			$sesiones = $benef->sesion;

			$cant_solicitada = $benef->tope;

			$totalDias = count($sesiones);

			if($prestador[0]->quitar_feriado == 'Si'){

				$feriados = Feriado::get();

				$fechas['feriados'][$benef->id] = OSUtil::cuenta_feriados($mes, $anio, $sesiones, $feriados);

			}

			$fechas['total'][$benef->id] = OSUtil::cuenta_dias($mes, $anio, $sesiones, $cant_solicitada, $inasistencias);

			$fechas['inasistencias'][$benef->id] = OSUtil::cuenta_inasistencias($mes, $anio, $sesiones, $inasistencias);

			$fechas['agregado'][$benef->id] = OSUtil::cuenta_agregado($mes, $anio, $sesiones, $adicionales);

			$fechas['total_agregado'][$benef->id] = count($benef->agregado);

			



			// Sumario de fechas

			if($prestador[0]->quitar_feriado == 'Si'){

				foreach($fechas['feriados'] ?? [] as $k => $fch){

					foreach($fch as $k2 => $fch2){

						foreach($fechas['total'] as $k3 => $fch3){

							foreach($fch3 as $k4 => $fch4){

								if($k4 == $k2){

									unset($fechas['total'][$k3][$k4]);

									if($prestador[0]->mover_dias == "Si"){

										$fechas['total'][$k3][$k4] = $fch2;

									}

								}

							}

						}

					}

				}

			}



			$cuenta = array();

			$fechasParaBorrar = array();

			foreach ($fechas['total'] ?? [] as $key => $fecha) {

				$cuenta[$key] = 0;

				foreach($fecha as $k => $v){

					$cuenta[$key]++;

					$fecha_individual = explode('/', $v);

					foreach($fechas['inasistencias'][$key] as $inasistencia){

						$inasistencia_individual = explode('/', $inasistencia);	

						if($fecha_individual[0].'/'.$fecha_individual[1].'/'.$fecha_individual[2] == $inasistencia_individual[0].'/'.$inasistencia_individual[1].'/'.$inasistencia_individual[2]){

							$cuenta[$key]--;

							$fechasParaBorrar[$k] = $key; 

						}

					}	

					foreach ($fechas['agregado'] as $keyAgregado => $fechaAgregado) {

						foreach($fechaAgregado as $diaAgregado => $fechaAgr){

							$fechas['total'][$keyAgregado][$diaAgregado] = $fechaAgr;

						}

					}		

				}

				$fechas['tope'][$key] = $cuenta;

			}

			foreach ($fechasParaBorrar as $ind => $benefId) {

				unset($fechas['total'][$benefId][$ind]);

				ksort($fechas['total'][$benefId]);

			}

			$benef->total_fechas = count($fechas['total'][$benef->id]);

			$beneficiariosAgrupados[$grupo][] = $benef;

			$indice++;

		}

		return view('beneficiarios-traslado-asistencia', ['informacion' => $beneficiariosAgrupados]);

		// return view('beneficiarios-facturacion', ['informacion' => $beneficiariosAgrupados]);

	}

}

