@extends('layouts.app', ['prestador' => $prestador_menu])



@section('content')

<div class="content-wrapper">



  <section class="content-header">



    <h1>



      APROSS.



    </h1>



     <div style="padding-top: 15px">

        @include('includes.message')

     </div>



    <ol class="breadcrumb">



      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>



      <li class="active">Prestaciones</li>



    </ol>



  </section>



  <section class="content">



    <div class="box">



      <div class="box-header with-border">



        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarPrestacion">



          Agregar Prestacion



        </button>



      </div>



      <div class="box-body">



       <table class="table table-bordered table-striped dt-responsive tablas">



        <thead>



         <tr>



           <th style="width:10px">#</th>

           <th>Nombre</th>
           <th>Valor Módulo</th>

           <th>Valor Unitario</th>

           <th>Codigo de Modulo</th>

           <th>Planilla</th>

           <th>Acciones</th>



         </tr>



        </thead>



        <tbody>



          @foreach ($prestaciones as $key => $prestacion)



			@php

				switch ($prestacion->planilla) {

					case 1:

						$planilla = 'REHABILITACION';

						break;



					case 2:

						$planilla = 'INTEGRACION';

						break;



					case 3:

						$planilla = 'TRASLADO';

						break;



					case 4:

						$planilla = '3.2';

						break;



					case 5:

						$planilla = '3.5';

						break;

					

					case 6:

						$planilla = '3.3';

						break;

					

					case 7:

						$planilla = '3.6';

						break;

				}

			@endphp

			

          <tr>

            <td>{{ ($key+1) }}</td>

            <td>@if(is_null($prestacion->categoria))
              {{ $prestacion->nombre}}
              @else
              {{  $prestacion->nombre.' -'.$prestacion->categoria->nombre}}
              @endif
              </td>

           

            <td>{{ number_format($prestacion->valor_modulo, 2, ',', '.') }}</td>
            <?php if($prestacion->dividir!=null and $prestacion->dividir>0){
              $valor_a_utilizar = $prestacion->valor_modulo /$prestacion->dividir;
            } else {
              $valor_a_utilizar = $prestacion->valor_modulo;
            }?>
            <td>{{ number_format($valor_a_utilizar, 2, ',', '.')}}</td>

            <td>{{ $prestacion->codigo_modulo }}</td>

            <td>{{ $planilla ?? '' }}</td>



            <td>

              <div class="btn-group">



                <button class="btn btn-warning" id="btnEditarPrestacion" idPrest="{{ $prestacion->id }}" data-toggle="modal" data-target="#modalEditarPrestacion"><i class="fa fa-pencil"></i></button>



                <button class="btn btn-danger" id="btnEliminarPrestacion" idPrest="{{ $prestacion->id }}"><i class="fa fa-times"></i></button>



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

MODAL AGREGAR PRESTACION

======================================-->



<div id="modalAgregarPrestacion" class="modal fade" role="dialog">



  <div class="modal-dialog">



    <div class="modal-content">



      <form role="form" method="POST" action="{{ route('prestacion-create') }}">

        @csrf



        <!--=====================================

        CABEZA DEL MODAL

        ======================================-->



        <div class="modal-header" style="background:#3c8dbc; color:white">



          <button type="button" class="close" data-dismiss="modal">&times;</button>



          <h4 class="modal-title">Agregar Prestacion</h4>



        </div>



        <!--=====================================

        CUERPO DEL MODAL

        ======================================-->



        <div class="modal-body">



          <div class="box-body">



            <!-- ENTRADA PARA OBRA SOCIAL -->


            <input type="hidden" name="obra_social" value="2">
           <!-- <div class="form-group">



              <label for="obra_social">Obra Social</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-user"></i></span>



                <select type="text" id="obra_social" class="form-control input-lg" name="obra_social" placeholder="Seleccionar Obra Social" required>



                  <option value="">Seleccionar obra social...</option>



                  @foreach ($obras_sociales as $obra_social)

                    <option value="{{ $obra_social->id }}">{{ $obra_social->nombre }}</option>

                  @endforeach



                </select>



              </div>



            </div>-->

 <!-- ENTRADA PARA CATEGORIA -->



            <div class="form-group">



              <label for="obra_social">Categoria</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-user"></i></span>



                <select type="text" id="categoria" class="form-control input-lg" name="categoria" placeholder="Seleccionar Categoria" >



                  <option value="">Seleccionar Categoria...</option>
                     @foreach ($categorias as $categoria)

                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>

                  @endforeach

                </select>



              </div>



            </div>


          <!-- ENTRADA PARA EL CODIGO DE MODULO -->



            <div class="form-group">



              <label for="codigo_modulo">Código de Módulo</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-user"></i></span>



                <input type="text" id="codigo_modulo" class="form-control input-lg" name="codigo_modulo" placeholder="Ingresar Código de Módulo">



              </div>



            </div>



            <!-- ENTRADA PARA EL NOMBRE -->



            <div class="form-group">



              <label for="prestacion">Prestación</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-user"></i></span>



                <input type="text" id="prestacion" class="form-control input-lg" name="prestacion" placeholder="Ingresar Prestación" required>



              </div>



            </div>



            <!-- ENTRADA PARA EL VALOR -->



            <div class="form-group">



            <label for="valor_prestacion">Valor de Prestacion</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-money"></i></span>



                <input type="text" id="valor_prestacion" class="form-control input-lg" name="valor_prestacion" placeholder="Ingresar Valor de Modulo (si corresponde)">



              </div>



            </div>

  <!-- ENTRADA PARA EL DIVIDIR -->



            <div class="form-group">



            <label for="valor_prestacion">Dividir</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-th-large"></i></span>



                <input type="number" id="dividir" class="form-control input-lg" name="dividir" min="1" max="255" >



              </div>



            </div>

              <!-- ENTRADA PARA PLANILLA -->



              <div class="form-group">



                  <label for="planilla">Planilla</label>



                  <div class="input-group">



                      <span class="input-group-addon"><i class="fa fa-money"></i></span>



                      <select type="text" id="planilla" class="form-control input-lg" name="planilla">

                          <option value="0">Seleccionar...</option>

                          <option value="1">REHABILITACION</option>

                          <option value="2">INTEGRACION</option>

						  <option value="3">TRASLADO</option>

						  <option value="4">3.2</option>

						  <option value="6">3.3</option>

						  <option value="5">3.5</option>

						  <option value="7">3.6</option>

                      </select>



                  </div>



              </div>



          </div>



        </div>



        <!--=====================================

        PIE DEL MODAL

        ======================================-->



        <div class="modal-footer">



          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>



          <button type="submit" class="btn btn-primary">Guardar Prestacion</button>



        </div>



      </form>



    </div>



  </div>



</div>



<!--=====================================

MODAL EDITAR PRESTACION

======================================-->



<div id="modalEditarPrestacion" class="modal fade" role="dialog">



  <div class="modal-dialog">



    <div class="modal-content">



      <form role="form" method="POST" action="{{ route('prestacion-edit') }}">

        @csrf



        <!--=====================================

        CABEZA DEL MODAL

        ======================================-->



        <div class="modal-header" style="background:#3c8dbc; color:white">



          <button type="button" class="close" data-dismiss="modal">&times;</button>



          <h4 class="modal-title">Editar Prestacion</h4>



        </div>



        <!--=====================================

        CUERPO DEL MODAL

        ======================================-->



        <div class="modal-body">



          <div class="box-body">



            <!-- ENTRADA PARA OBRA SOCIAL -->
<input type="hidden" name="obra_social" value="2">


          <!--  <div class="form-group">



              <label for="obra_social">Editar Obra Social</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-user"></i></span>



                <select type="text" id="editar_obra_social" class="form-control input-lg" name="obra_social" placeholder="Editar Obra Social" required>



                  <option value="">Seleccionar obra social...</option>



                  @foreach ($obras_sociales as $obra_social)

                    <option value="{{ $obra_social->id }}">{{ $obra_social->nombre }}</option>

                  @endforeach



                </select>



              </div>



            </div>-->

<!-- ENTRADA PARA CATEGORIA -->



            <div class="form-group">



              <label for="obra_social">Categoria</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-user"></i></span>



                <select type="text" id="editar_categoria" class="form-control input-lg" name="categoria" placeholder="Seleccionar Categoria" >



                  <option value="">Seleccionar Categoria...</option>
                     @foreach ($categorias as $categoria)

                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>

                  @endforeach

                </select>



              </div>



            </div>


          <!-- ENTRADA PARA EL CODIGO DE MODULO -->



            <div class="form-group">



              <label for="codigo_modulo">Editar Código de Módulo</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-user"></i></span>



                <input type="text" id="editar_codigo_modulo" class="form-control input-lg" name="codigo_modulo" placeholder="Editar Código de Módulo">



              </div>



            </div>



            <!-- ENTRADA PARA EL NOMBRE -->



            <div class="form-group">



              <label for="prestacion">Editar Prestación</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-user"></i></span>



                <input type="text" id="editar_prestacion" class="form-control input-lg" name="prestacion" placeholder="Editar Prestación" required>



              </div>



            </div>



            <!-- ENTRADA PARA EL VALOR -->



            <div class="form-group">



            <label for="valor_prestacion">Editar Valor de Prestacion</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-money"></i></span>



                <input type="text" id="editar_valor_prestacion" class="form-control input-lg" name="valor_prestacion" placeholder="Editar Valor de Modulo (si corresponde)">



              </div>



            </div>

 <!-- ENTRADA PARA EL DIVIDIR -->



            <div class="form-group">



            <label for="valor_prestacion">Dividir</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-th-large"></i></span>



                <input type="number" id="editar_dividir" class="form-control input-lg" name="dividir" min="1" max="255" >



              </div>



            </div>

              <!-- ENTRADA PARA PLANILLA -->



              <div class="form-group">



                  <label for="planilla">Planilla</label>



                  <div class="input-group">



                      <span class="input-group-addon"><i class="fa fa-money"></i></span>



                      <select type="text" id="editar_planilla" class="form-control input-lg" name="planilla">

						<option value="0">Seleccionar...</option>

						<option value="1">REHABILITACION</option>

						<option value="2">INTEGRACION</option>

						<option value="3">TRASLADO</option>

						<option value="4">3.2</option>

						<option value="6">3.3</option>

						<option value="5">3.5</option>

						<option value="7">3.6</option>

                      </select>



                  </div>



              </div>



          </div>



        </div>



        <input type="hidden" id="id" name="id">



        <!--=====================================

        PIE DEL MODAL

        ======================================-->



        <div class="modal-footer">



          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>



          <button type="submit" class="btn btn-primary">Guardar Prestacion</button>



        </div>



      </form>



    </div>



  </div>



</div>



@endsection

