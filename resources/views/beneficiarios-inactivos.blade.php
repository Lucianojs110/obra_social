@extends('layouts.app', ['prestador' => $prestador_menu])


@section('content')

<div class="content-wrapper">



  <section class="content-header">



    <h1>



      Módulo de Beneficiarios Inactivos



    </h1>



     <div style="padding-top: 15px">

        @include('includes.message')

     </div>



    <ol class="breadcrumb">



      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>



      <li class="active">Video Tutoriales</li>



    </ol>



  </section>



  <section class="content">



    <div class="box">



      <div class="box-body">



       <table class="table table-bordered table-striped dt-responsive tablas">



        <thead>



         <tr>

		   <th>Apellido y Nombre</th>

		   <th>Prestacion</th>

		   <th>Obra Social</th>
       <th>Mes/año Inactivo</th>
<th>Mes/año Activo</th>
           <th>Acctiones</th>

         </tr>



        </thead>

        <tbody>




			

				@foreach($beneficiarios as $benef)
          @php

          $os_id = $benef->os_id;

          $prestacion = $benef->prestacion;

          $os = $benef->obrasocial;

        @endphp

					<tr>

						<td>{{ $benef->nombre }}</td>

						<td>{{ $prestacion }}</td>

						<td>{{ $os }}</td>
            <td>{{ date("m-Y",strtotime($benef->fecha))  }}</td>
            <td>{{ ($benef->fecha_fin)?date("m-Y",strtotime($benef->fecha_fin)):""  }}</td>
						<td>

							<div class="btn-group">

							<!--	<button class="btn btn-danger btnEliminarBeneficiarioInactivo" idOs="{{ $os_id }}" idBenef="{{ $benef->id }}"><i class="fa fa-trash"></i></button>-->
<button class="btn btn-warning btnEditarInactivo" data-toggle="modal" data-target="#modalInactivo" data-id="{{$benef->id}}" data-os_id="{{$benef->os_id}}"  data-fecha="{{ date('Y-m',strtotime($benef->fecha))  }}" data-fechafin="{{ ($benef->fecha_fin)?date('Y-m',strtotime($benef->fecha_fin)):''  }}" ><i class="fa fa-pencil"></i></button>
								<button type="button" class="btn btn-danger btnEliminarInactivo" idOs="{{ $os_id }}" idBenef="{{ $benef->id }}"><i class="fa fa-trash"></i></button>

							</div>

						</td>

					</tr>			


			@endforeach

        



        </tbody>



       </table>



      </div>



    </div>



  </section>



</div>


<!--=====================================

MODAL EDITAR INACTIVO

======================================-->



<div id="modalInactivo" class="modal fade" role="dialog">



  <div class="modal-dialog">



    <div class="modal-content">



      <form role="form" method="post" action="{{ route('beneficiario-inactivo-cambiar') }}" >
        <input type="hidden" name="id" id="id" value="">
        <input type="hidden" name="id_os" id="id_os" value="">


        @csrf



        <!--=====================================

        CABEZA DEL MODAL

        ======================================-->



        <div class="modal-header" style="background:#3c8dbc; color:white">



          <button type="button" class="close" data-dismiss="modal">&times;</button>



          <h4 class="modal-title">Editar</h4>



        </div>



        <!--=====================================

        CUERPO DEL MODAL

        ======================================-->



        <div class="modal-body">



          <div class="box-body">



      
<div class="form-group">



              <label for="obra_social">Fecha inactivo</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-user"></i></span>



                <input type="month" id="fecha" class="form-control input-lg" name="fecha"  readonly="readonly">



              </div>



            </div>


            <div class="form-group">



              <label for="obra_social">Fecha activación</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-user"></i></span>



                <input type="month" id="fecha_fin" class="form-control input-lg" name="fecha_fin"  required>



              </div>



            </div>



         
        <!--=====================================

        PIE DEL MODAL

        ======================================-->



        <div class="modal-footer">



          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>



          <button type="submit" class="btn btn-primary">Guardar</button>



        </div>



      </form>



    </div>



  </div>



</div>






@endsection

