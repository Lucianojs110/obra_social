<?php

namespace App\Helpers;

class OSUtil{

	static public function cuenta_dias($mes, $anio, $sesiones, $tope_dias = null, $inasistencias = [])
    {
		if($tope_dias == null || $tope_dias == 0){
			$tope_dias = 999999;
		}
		$fechasInasistencia = array();
		foreach($inasistencias as $inasistencia){
			$fechasInasistencia[] = $inasistencia->rango_fechas;
		}
        $count=0;
        $dias_mes=cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
        $coincidencia = array();
		foreach($sesiones as $sesion){
			$tiempo = $sesion->tiempo;
			$numero_dia = $sesion->dia;
			$horario = $sesion->hora; 
			for($i=1;$i<=$dias_mes && $count < $tope_dias;$i++){
                if(date('N',strtotime($anio.'-'.$mes.'-'.$i))==$numero_dia){
                    $hor=new \DateTime($horario);
                    $fin=$hor->add( new \DateInterval( 'PT' . ( (integer) $tiempo ) . 'M' ) );
					$fecha_fin = $fin->format( 'H:i' );
					if($i < 10){
						$i = 0 .$i;
					}
					if(!in_array(date($i.'/'.$mes.'/'.substr($anio, -2)), $fechasInasistencia)){
						$count++;
						$coincidencia[$i] = date($i.'/'.$mes.'/'.substr($anio, -2)). '/' . $horario.'/'.$fecha_fin;
					}
                }
			} 
		}	
		return $coincidencia;
	}

	static public function cuenta_feriados($mes, $anio, $sesiones, $feriados = [])
    {
        $count=0;
        $dias_mes=cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
        $coincidencia = array();
		foreach($feriados as $feriado){
			foreach($sesiones as $sesion){
				$tiempo = $sesion->tiempo;
				$numero_dia = $sesion->dia;
				$horario = $sesion->hora; 
				for($i=1;$i<=$dias_mes;$i++){
					if($i < 10){
						$i = 0 .$i;
					}
					if(date($i.'/'.$mes.'/'.$anio) == $feriado->fecha){
						$dia = ($i+1);
						if($dia < 10){
							$dia = 0 . $dia;
						}
						$hor=new \DateTime($horario);
						$fin=$hor->add( new \DateInterval( 'PT' . ( (integer) $tiempo ) . 'M' ) );
						$fecha_fin = $fin->format( 'H:i' );
						$count++;
						$coincidencia[$i] = date($dia.'/'.$mes.'/'.substr($anio, -2)). '/' . $horario.'/'.$fecha_fin;	
					}
				}
			}	
		}
		return $coincidencia;
	}
	
	static public function cuenta_inasistencias($mes, $anio, $sesiones, $inasistencias = [])
    {
        $count=0;
        $dias_mes=cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
        $coincidencia = array();
		$fechas_inasistencia = array();
		foreach($inasistencias as $inasistencia){
			// Si es de tipo individual
			if(strlen($inasistencia->rango_fechas) < 9){
				foreach($sesiones as $sesion){
					$tiempo = $sesion->tiempo;
					$numero_dia = $sesion->dia;
					for($i=1;$i<=$dias_mes;$i++){
						if($i < 10){
							$i = '0'.$i;
						}
						if(date($i.'/'.$mes.'/'.substr($anio, -2)) == $inasistencia->rango_fechas){
							$count++;
							$coincidencia[$i] = date($i.'/'.$mes.'/'.substr($anio, -2));	
						}
					}
				}	
			}else{
				// Rango de inasistencias
				$rangoFechas = explode('-', str_replace(' ', '', $inasistencia->rango_fechas));
				$fechaInicial = $rangoFechas[0];
				$fechaFinal = $rangoFechas[1];
				foreach($sesiones as $sesion){
					$tiempo = $sesion->tiempo;
					$numero_dia = $sesion->dia;
					for($i=1;$i<=$dias_mes;$i++){
						if($i < 10){
							$i = '0'.$i;
						}
						if(date($i.'/'.$mes.'/'.substr($anio, -2)) >= $fechaInicial && date($i.'/'.$mes.'/'.substr($anio, -2)) <= $fechaFinal){
							$count++;
							$coincidencia[$i] = date($i.'/'.$mes.'/'.substr($anio, -2));	
						}
					}
				}
			}
		}
		return $coincidencia;
	}
	
	static public function cuenta_agregado($mes, $anio, $sesiones, $agregados = [])
    {
		$count=0;
        $dias_mes=cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
        $coincidencia = array();
		$fechas_agregado = array();
		foreach($agregados as $agregado){
			foreach($sesiones as $sesion){
				$tiempo = $sesion->tiempo;
				$numero_dia = $sesion->dia;
				$horario = $sesion->hora; 
				for($i=1;$i<=$dias_mes;$i++){
					if($i < 10){
						$i = '0'.$i;
					}
					if(date($i.'/'.$mes.'/'.substr($anio, -2)) == $agregado->rango_fechas){
						$hor=new \DateTime($horario);
						$fin=$hor->add( new \DateInterval( 'PT' . ( (integer) $tiempo ) . 'M' ) );
						$fecha_fin = $fin->format( 'H:i' );
						$count++;
						$coincidencia[$i] = date($i.'/'.$mes.'/'.substr($anio, -2)). '/' . $horario.'/'.$fecha_fin;
					}
				} 
			}	
		}
		return $coincidencia;
	}

	static public function ordenarBeneficiarios($beneficiarios){
		usort($beneficiarios, function($a, $b){ 
			return $a->nombre < $b->nombre;
		});
	}
}