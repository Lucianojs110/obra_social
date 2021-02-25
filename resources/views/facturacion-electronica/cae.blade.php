@extends('layouts.app', ['prestador' => $data['prestador_menu']])
@php

	$meses = ['01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'];



	$anios = ['2020', '2021', '2022', '2023'];
	$fecha_user = \Auth::user()->anio.'-'.\Auth::user()->mes;
	$query2 ="SELECT id_ben FROM inactivos WHERE (DATE_FORMAT(CAST(fecha as DATE), \"%Y-%m\") <= \"".$fecha_user."\" AND fecha_fin IS NULL) OR (DATE_FORMAT(CAST(fecha as DATE), \"%Y-%m\") <= \"".$fecha_user."\" AND DATE_FORMAT(CAST(fecha_fin as DATE), \"%Y-%m\") > \"".$fecha_user."\")";
 	$array_inactivos = \DB::select($query2);
	$ids = array();

foreach($array_inactivos as $key){
	$ids[]=$key->id_ben;
}

@endphp

<?php 
if(Auth::user()->mes){
	$date1 = new DateTime(Auth::user()->anio."-".Auth::user()->mes."-".date("d"));
}else{
	$date1 = new DateTime(Auth::user()->anio."-".date("m")."-".date("d"));
}
$date2 = new DateTime(date("Y-m-d"));
 
$provincia = DB::table('provincias')->select('id', 'provincia')->get();
$d1 = new DateTime(Auth::user()->anio."-".Auth::user()->mes."-01");
$d1->modify('+1 month');
$d2 = new DateTime(Auth::user()->anio."-".Auth::user()->mes."-01");
$d2->modify('-1 month');
$mes_anterior = $d2->format('m');
$anio_anterior = $d2->format('Y');
$mes_posterior = $d1->format('m');
$anio_posterior= $d1->format('Y');

?>

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
           {{-- Ingrese el Cuil o Cuit de la obra social --}}
            <h4>
                Prestador: {{ Auth::user()->name . ' ' . Auth::user()->surname }}
            </h4>
        </h1>

        <div style="padding-top: 15px">
            @include('includes.message')
        </div>

        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Factura Previa</li>
        </ol>

    </section>


    <section class="content">
      <form method="post" action="{{-- {{ URL::action('FacturacionController@consultarcuit') }} --}}" enctype=multipart/form-data>
        @csrf
        @method('post')
        <div class="box">
          <div class="box-header with-border">
            {{-- <button class="btn btn-primary" href="{{ URL::action('FacturacionController@createCert') }}">
              Nuevo
            </button> --}}
            <button class="btn btn-primary" onclick="location.href='/* {{ URL::action('FacturacionController@createCert') }} */'" type="button">
                ENVIAR A AFIP</button>
          </div>
    
          
    
            <tbody>
    
              @if($data['obrasocial'][0]->nombre == "APROSS")

              <table class="table table-bordered table-striped dt-responsive tablaBeneficiario text-center" style="width: 100% !important;">
        
                <thead>
        
                  <tr>
        
                    @if(Auth::user()->role == 'Traslado')
        
                      <th>Cons.</th>
        
                    @endif
        
                    <th style="text-align: center">Clonar</th>
                    <th style="text-align: center">Id Benef</th>
                    <th style="text-align: center">Id Prestador</th>
                    <th>Apellido y Nombre</th>
        
                    <th style="text-align: center">N° de Beneficiario</th>
        
                    <th style="text-align: center">Cod. Seguridad</th>
        
                    <th style="text-align: center">Cod. Modulo</th>
        
                    <th style="text-align: center; width: 30px">Cant. Solicitada</th>
                    
                    <th style="text-align: center; width: 30px">Valor</th>
                    <th style="text-align: center; width: 30px">Subtotal</th>
        
                    <th>Observaciones</th>
        
                    {{-- <th style="text-align: center">Cod. Traditum</th> --}}
        
                   {{--  <th>Acciones</th> --}}
        
                  </tr>
        
                </thead>
        
                <tbody>
        
                  @foreach($data['beneficiarios'] as $beneficiario)
        
                    <?php 
        
                      $codigo_prestacion = $beneficiario->prestacion[0]->codigo_modulo;

                      $valor_modulo = $beneficiario->prestacion[0]->valor_modulo;
        
                      $planilla = $beneficiario->prestacion[0]->planilla;
        
                      $os_id = $beneficiario->os_id;
        
                      $prestador_id = $beneficiario->id;
        
                    ?>
        
                    @foreach($beneficiario->beneficiario as $key => $benefval)
                      @if(!in_array($benefval->id,$ids))
                      <tr class="beneficiarioBold" idBenef="{{$benefval->id}}" style="{{ (Session::has('ModificacionBeneficiario') && Session::get('ModificacionBeneficiario') == $benefval->id) ? 'font-weight:bold;' : ''}}">
        
                        @if(Auth::user()->role == 'Traslado')
        
                          <td>											
        
                            <a target="_BLANK" href="{{ route('formulario-beneficiario', ['id' => $benefval->id, 'prestador_id' => $prestador_id ,'planilla' => $planilla, 'mes' => Auth::user()->mes, 'anio' => Auth::user()->anio]) }}" class="btn btn-primary" style="color: white; background-color: #605CA8"><i class="fa fa-address-card"></i></a>
        
                          </td>
        
                        @endif
        
                        <td style="text-align: center"> <button class="btn btn-success btnClonarBeneficiario" data-toggle="modal" data-target="#modalClonarBeneficiario" idBenef="{{ $benefval->id }}"><i class="fa fa-users"></i></button></td>
        
                          @if($data['obrasocial'][0]->nombre == "OSECAC")
        
                            <td style="text-align: center"><a href="{{ route('beneficiario-presupuesto', ['prestador_id' => $benefval->prestador_id, 'beneficiario_id' => $benefval->id]) }}" target="_BLANK"><button class="btn btn-success">8.4</button></a></td>
        
                          @endif
        
        
                        <td style="text-align: center">{{ $benefval->id }}</td>
        
                        <td style="text-align: center">{{ $benefval->prestador_id }}</td>
                      
                        <td>{{ $benefval->nombre . ' ' . $benefval->apellido }}</td>
        
                        <td style="text-align: center">{{ $benefval->numero_afiliado }}</td>
        
                        <td style="text-align: center">{{ $benefval->codigo_seguridad }}</td>
        
                        <td style="text-align: center">{{ $codigo_prestacion }} {!! $benefval->dependencia == 'Si' ? '<br>6501024' : '' !!}</td>
        
                        <td style="text-align: center">{{ $benefval->cantidad_solicitada }}</td>
                        

                        <td style="text-align: center">{{ $valor_modulo }}</td>

                       @php
                           
                           $tot  = $valor_modulo ;
                       @endphp

                        <td style="text-align: center">{{ $tot }}</td>
                          

                        
                        <td>{{ substr($benefval->notas,0,10).'...' }}</td>

        
                        {{-- <td style="text-align: center;">
        
                          <input {{Auth::user()->mes != date('m') || Auth::user()->anio != date('Y') ? 'disabled' : ''}} type="text" name="traditum" class="traditum" beneficiario-id="{{$benefval->id}}" traditum-id="{{ $data['traditums'][$benefval->id][0]['id'] }}" value="{{ $data['traditums'][$benefval->id][0]['codigo']}}" style="border: none; text-align: center; background: transparent;">
        
                        </td> --}}
        
                        <td style="width: 200px">
        
                          <div class="btn-group">		
        
                            {{-- @if(Auth::user()->role != 'Traslado')
        
                              <a target="_BLANK" href="{{ route('formulario-beneficiario', ['id' => $benefval->id, 'prestador_id' => $prestador_id ,'planilla' => $planilla, 'mes' => Auth::user()->mes, 'anio' => Auth::user()->anio]) }}" class="btn btn-primary" style="color: white; background-color: #605CA8"><i class="fa fa-address-card"></i></a>
        
                            @endif
        
        
        
                            <button class="btn btn-primary btnHorarioBeneficiario" data-toggle="modal" data-target="#modalHorarioBeneficiario" idBenef="{{ $benefval->id }}" cuenta-tope="{{ $data['fechas']['tope'][$benefval->id][$benefval->id] }}" cuenta-original="{{ count($data['fechas']['total'][$benefval->id])}}" cuenta-agregados="{{ $data['fechas']['total_agregado'][$benefval->id] }}"><i class="fa fa-clock-o"></i></button>
        
        
                            @if($date1 <= $date2)
                            <button class="btn btn-warning btnEditarBeneficiario" data-toggle="modal" data-target="#modalEditarBeneficiario" style="" idBenef="{{ $benefval->id }}"><i class="fa fa-pencil"></i></button>
                            @endif
        
        
                            <button class="btn btn-danger btnEliminarBeneficiario" idOs="{{ $os_id }}" idBenef="{{ $benefval->id }}"><i class="fa fa-trash"></i></button>
        
        
        
                            <button type="button" class="btn btn-success"><input type="checkbox" class="btnEstadoBeneficiario" name="btnActivarUsuario" value="1" idBenef="{{ $benefval->id }}" idOs={{ $os_id }} style="margin-top: 1px"></button> --}}
        
                          </div>
        
                        </td>
        
                      </tr>
                    @endif
                    @endforeach
        
                  @endforeach
        
                </tbody>
        
                 </table>
        
        
        
             @else
        
             
        
                <table class="table table-bordered table-striped tablaBeneficiario">
        
                  <thead>
        
                   <tr>
        
        
                <th>Nombre y Apellido</th>
        
                <th>N° de Beneficiario</th>
        
                <!--<th>Cod. Seguridad</th>
        
                <th>Cod. Modulo</th>-->
        
                <th>Cant. Solicitada</th>
        
                <th>Observaciones</th>
        
                <!--<th>Cod. Traditum</th>-->
        
                <th>Acciones</th>
        
                   </tr>
        
                  </thead>
        
                  <tbody>
        
              @foreach($data['beneficiarios'] as $beneficiario)
        
                <?php 
        
                  $codigo_prestacion = $beneficiario->prestacion[0]->codigo_modulo;
        
                  $planilla = $beneficiario->prestacion[0]->planilla;
        
                  switch ($planilla) {
        
                    case 4:
        
                      $nombre_planilla = '3.2';
        
                      break;
        
                    
        
                    case 5:
        
                      $nombre_planilla = '3.5';
        
                      break;
        
        
        
                    case 6:
        
                      $nombre_planilla = '3.3';
        
                      break;
        
                    
        
                    case 7:
        
                      $nombre_planilla = '3.6';
        
                      break;
        
                  }
        
                  $os_id = $beneficiario->os_id;
        
                  $prestador_id = $beneficiario->id;
                  
                  
                ?>
        
                @foreach($beneficiario->beneficiario as $key => $benefval)
                @if(!in_array($benefval->id,$ids))
                <?php
                $fecha_inactivo_mes = date("m",strtotime($benefval->fecha_inactivo));
                $fecha_inactivo_anio = date("Y",strtotime($benefval->fecha_inactivo));
                ?>
                @if($benefval->activo==0 and ($fecha_inactivo_mes==Auth::user()->mes) and ($fecha_inactivo_anio==Auth::user()->anio) )
        
                @else
        
                  <tr class="beneficiarioBold" idBenef="{{$benefval->id}}" style="{{ (Session::has('ModificacionBeneficiario') && Session::get('ModificacionBeneficiario') == $benefval->id) ? 'font-weight:bold;' : ''}}">
        
                    <td style="text-align: center"> <button class="btn btn-success btnClonarBeneficiario" data-toggle="modal" data-target="#modalClonarBeneficiario" idBenef="{{ $benefval->id }}"><i class="fa fa-users"></i></button></td>
        
                      @if($data['obrasocial'][0]->nombre == "OSECAC")
        
                        @if(Auth::user()->role == "Traslado")
        
                          <td style="text-align: center"><a href="{{ route('beneficiario-presupuesto-traslado', ['prestador_id' => $benefval->prestador_id, 'beneficiario_id' => $benefval->id]) }}" target="_BLANK"><button class="btn btn-success">8.5</button></a></td>
        
                        @else
        
                          <td style="text-align: center"><a href="{{ route('beneficiario-presupuesto', ['prestador_id' => $benefval->prestador_id, 'beneficiario_id' => $benefval->id]) }}" target="_BLANK"><button class="btn btn-success">8.4</button></a></td>
        
                        @endif
        
                        
        
                      @endif
        
                    <td>{{ $benefval->nombre . ' ' . $benefval->apellido }}</td>
        
                    <td style="text-align: center">{{ $benefval->numero_afiliado }}</td>
        
                    <!-- <td style="text-align: center">{{ $benefval->codigo_seguridad }}</td>
        
                    <td style="text-align: center">{{ $codigo_prestacion }}</td>-->
        
                    <td style="text-align: center">{{ $benefval->cantidad_solicitada }}</td>
        
                    <td>{{ substr($benefval->notas,0,10).'...' }}</td>
        
                    <!--<td style="text-align: center;">
        
                      <input {{Auth::user()->mes != date('m') || Auth::user()->anio != date('Y') ? 'disabled' : ''}} type="text" name="traditum" id="traditum" beneficiario-id="{{$benefval->id}}" traditum-id="{{ $data['traditums'][$benefval->id][0]['id'] }}" value="{{ $data['traditums'][$benefval->id][0]['codigo']}}" style="border: none; text-align: center; background: transparent;">
        
                    </td>-->
        
                    <td style="width: 200px">
        
                      <div class="btn-group">	
        
                        <a target="_BLANK" href="{{ route('formulario-beneficiario', ['id' => $benefval->id, 'prestador_id' => $benefval->prestador_id ,'planilla' => $planilla, 'mes' => Auth::user()->mes, 'anio' => Auth::user()->anio]) }}" class="btn btn-primary" style="color: white; background-color: #605CA8; padding: 3px 12px 3px;"><span>{{ $nombre_planilla }}<span></a>
        
                        @if($codigo_prestacion != '6501024')
        
                          <button class="btn btn-primary btnHorarioBeneficiario" data-toggle="modal" data-target="#modalHorarioBeneficiario" idBenef="{{ $benefval->id }}" cuenta-tope="{{ $data['fechas']['tope'][$benefval->id][$benefval->id] }}" cuenta-original="{{ count($data['fechas']['total'][$benefval->id])}}" cuenta-agregados="{{ $data['fechas']['total_agregado'][$benefval->id] }}"><i class="fa fa-clock-o"></i></button>
        
                        @endif
                        @if($date1 <= $date2)
                        <button class="btn btn-warning btnEditarBeneficiarioOsecac" data-toggle="modal" data-target="#modalEditarBeneficiarioOsecac" style="" idBenef="{{ $benefval->id }}"><i class="fa fa-pencil"></i></button>
                        @endif
                        <button class="btn btn-danger btnEliminarBeneficiario" idOs="{{ $os_id }}" idBenef="{{ $benefval->id }}"><i class="fa fa-trash"></i></button>
        
                        <button type="button" class="btn btn-success"><input type="checkbox" class="btnEstadoBeneficiario" name="btnActivarUsuario" value="1" idBenef="{{ $benefval->id }}" idOs={{ $os_id }} style="margin-top: 1px"></button>
        
                      </div>
        
                    </td>
        
                  </tr>
                  @endif
                  @endif
                  @endforeach
        
                @endforeach
        
                  </tbody>
        
                 </table>
        
               @endif
        
              </div>


            </tbody>
    
           </table>
          
            
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
                    
                      <div class="col-md-2 form-group">
                        <label for="codigo">Total</label>
                        <input type="numeric" name="total" id="total" class="form-control" {{-- required --}}{{-- value="{{ $p->localidad }}" readonly --}}>
                     </div>
    
              
                    <div class="col-md-2 form-group">
                        <button type="button" onclick="calculatorTotal()"> Total</button>
                    </div>
                    </div>
                </div>
            
                
                    {{-- <div class="form-group col-md-2">
                        <button class="btn btn-success btn-block btn-lg" onclick="/* solicitarcae() */">Enviar</button>
                    </div> --}}
                
        </form>
    
          </div>
    
        </div>
    
      </section>

   {{--  <div class="row justify-content-center align-items-center">
        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
            <h3>Ingresar Cuil/Cuit</h3>
            <div class="progress" style="height: 2px;"></div>
        </div>
    </div> --}}
    </br>
   
    
    
    
    {{-- <a href="{{route('print')}}">Generar Factura Electronica</a> --}}
  @endsection

  @push('scripts')
  <script>

    function calculatorTotal(){


      console.log('hola');
      console.log(document.getElementById('total'));
      document.getElementById('total').value = suma;
      precio = 0;
      cantidad = 0;
      mul = 0;
      suma = 0;
    
    
      
    }



    function solicitarcae(){

        var cuit = document.getElementById("cuit").value;
        console.log(cuit);

        $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			            type: "POST",
			            url: "{{route('solicitarcae')}}",
                        dataType: "json",
                        data: {"cuit":cuit},
                           /*  idVenta: $("#idVenta").val(); */
                    
			            success: function( data ){
			            	//Si existe seteamos los datos
							console.log('INTRO')
							console.log(data)


                        },
                        error: function(data){
                            alert("Algo ha salido mal  Respuesta del servidor: "+data.responseJSON.message)
                        },

            }),
           /*  return false; */

    }

    
</script>
@endpush