@extends('layouts.app', ['prestador' => $prestador_menu])

@section('content')
<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Módulo de Feriados.

    </h1>

     <div style="padding-top: 15px">
        @include('includes.message')
     </div>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Feriados</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">

      @if(Auth::user()->role == "Administrador")

        <div class="box-header with-border">
        
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarFeriado">

            Agregar Feriado

          </button>

        </div>

      @endif

      <div class="box-body">

       <table class="table table-bordered table-striped dt-responsive tablaFeriados text-center w-100">

        <thead>

         <tr>
			<th style="width:10px">#</th>
			<th>Fecha</th>
			<th>Acciones</th>
         </tr>

        </thead>

        <tbody>
			@foreach ($feriados as $key => $feriado)
				@php
					$filterFeriado = explode('/', $feriado->fecha);
				@endphp
				<tr>
					<td>{{ ($key+1) }}</td>
					<td><span style="display:none;">{{$filterFeriado[2].$filterFeriado[1].$filterFeriado[0]}}</span>{{ $feriado->fecha }}</td>
					@if(Auth::user()->role == "Administrador")
						<td>
						<div class="btn-group">
							<button class="btn btn-warning btnEditarFeriado" data-toggle="modal" data-target="#modalEditarFeriado" data-id="{{$feriado->id}}"><i class="fa fa-pencil"></i></button>
							<button class="btn btn-danger btnEliminarFeriado" data-id="{{$feriado->id}}"><i class="fa fa-times"></i></button>
						</div>
						</td>
					@endif
				</tr>
			@endforeach
        </tbody>

       </table>

      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR FERIADO
======================================-->

<div id="modalAgregarFeriado" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="POST" action="{{ route('feriado-store') }}">

        @csrf

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar Feriado</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA DESCRIPCION -->

            <div class="form-group">

              <label for="obra_social">Fecha</label>

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                <input type="text" class="form-control input-lg feriadoInput" name="feriado" placeholder="Ingresar Feriado">

              </div>

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar Feriado</button>

        </div>

      </form>

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR FERIADO
======================================-->

<div id="modalEditarFeriado" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="POST" action="{{ route('feriado-update') }}">

        <input type="hidden" name="id" id="feriado_id">

        @csrf

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar Feriado</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA DESCRIPCION -->

            <div class="form-group">

              <label for="obra_social">Editar Fecha</label>

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-user"></i></span>

                <input type="text" class="form-control input-lg feriadoInput" name="feriado" placeholder="Ingresar Descripcion" required>

              </div>

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar Feriado</button>

        </div>

      </form>

    </div>

  </div>

</div>

@endsection
