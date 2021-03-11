@extends('layouts.app', ['prestador' => $prestador_menu])



@section('content')

<div class="content-wrapper">



  <section class="content-header">



    <h1>



     Datos de prestador - <span><small>{{ Auth::user()->name . ' ' . Auth::user()->surname}}</small></span>



    </h1>



      <div style="padding-top: 15px">

        @include('includes.message')

     </div>



    <ol class="breadcrumb">



      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>



      <li class="active">Datos de Prestador</li>



    </ol>



  </section>



  <section class="content">



    <div class="box">



      <div class="box-header with-border">



        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarPrestacion">



          Agregar Obra Social / Prestación



        </button>



      </div>



      <div class="box-body">

<style type="text/css">
  .sorting_asc {display: none !important}
</style>

       <table class="table table-bordered table-striped dt-responsive tablas">



        <thead>



         <tr>



           <th style="width:1px;display: none;"></th>
<th >#</th>
           <th style="display: none;">Obra Social</th>

           <th>Numero de Prestador</th>

           <th>Prestacion</th>

           <th>Valor de Módulo</th>
           <th>Valor Unitario</th>

           <th>Acciones</th>



         </tr>



        </thead>



        <tbody>



          @if($prestador != null)
<?php $f=0;
$cantidad=count($prestador);

            for($i=0;$i<$cantidad;$i++) { 
              $array_num[$i]=$i;
              $prestacion = $prestador[$i];

         
 ?>


            <tr>

              <td style="width: 1px;"></td>
               <td><?php echo $i+1; ?></td>

              <td>{{ $prestacion->obrasocial }}</td>

              <td>{{ $prestacion->numero_prestador }}</td>
              <td>{{ ($prestacion->categoria!= null)?$prestacion->prestacion.' - '.$prestacion->categoria:$prestacion->prestacion  }}</td>
              @if($prestacion->id_nomenclador==null)
                  @if($prestacion->valor_default == 'T')
                    <td>{{ number_format($prestacion->valor_modulo , 2, ',', '.') }}</td>

                  @else

                     <td>{{ number_format($prestacion->valor_prestacion , 2, ',', '.') }}</td>

                  @endif

                  @if($prestacion->dividir != null )

                      <td>{{  number_format(($prestacion->valor_modulo/$prestacion->dividir), 2, ',', '.')}}</td>

                  @else

                      <td>{{ number_format($prestacion->valor_modulo , 2, ',', '.')}}</td>

                  @endif
              @else
              <?php //RECUPERO EL VALOR DEL NOMENCLADOR
              $query= "SELECT valor, dividir FROM prestacion_nomenclador WHERE id_nomenclador='$prestacion->id_nomenclador' AND id_prestacion='$prestacion->prestacion_id'";   
     
              $prestacion_nom = \DB::select($query);
              ?> @if($prestacion->valor_default == 'T')
                    <td>{{ number_format($prestacion->valor_modulo , 2, ',', '.') }}</td>

                  @else

                     <td>{{ number_format($prestacion_nom[0]->valor , 2, ',', '.') }}</td>

                  @endif
                  @if($prestacion_nom[0]->dividir != null )

                      <td>{{  number_format(($prestacion_nom[0]->valor/$prestacion_nom[0]->dividir), 2, ',', '.')}}</td>

                  @else

                      <td>{{ number_format($prestacion_nom[0]->valor , 2, ',', '.')}}</td>

                  @endif
             @endif


              <td>

                <div class="btn-group">



				  <button class="btn btn-warning btnEditarPrestacion" data-toggle="modal" data-target="#modalEditarPrestacion" idPrest="{{ $prestacion->id }}"><i class="fa fa-pencil"></i></button>

				  

				  <button class="btn btn-danger btnEliminarDatosPrestador" idPrest="{{ $prestacion->id }}"><i class="fa fa-trash"></i></button>

                </div>



              </td>



            </tr>


<?php } ?>
           

          @endif



        </tbody>



       </table>



      </div>



    </div>



  </section>



</div>



<!--=====================================

MODAL AGREGAR PRESTACION

======================================-->



<div id="modalAgregarPrestacion" tabindex="-1" aria-hidden="true" class="modal fade" role="dialog">



  <div class="modal-dialog modal-lg">



    <div class="modal-content">



      <form role="form" method="POST" action="{{ route('prestador-create') }}">
 <input type="hidden" name="nomenclador" id="nomenclador" value="">
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



            <!-- ENTRADA PARA EL NOMBRE -->



            <div class="form-group col-lg-12">



              <div class="input-group col-lg-12">



                <div class="col-lg-6">



                    <label for="obraSocial">Obra Social</label>



                    <select type="text" class="form-control input-lg" id="obraSocial" name="obraSocial" required>



                      <option value="">Seleccionar...</option>



                      @foreach($obrasocial as $obra)



                        <option value="{{ $obra->id }}">{{ $obra->nombre }}</option>



                      @endforeach



                    </select>



                </div>



                <div class="col-lg-6">



                      <label for="numeroPrestador">Número de Prestador</label>



                      <input type="text" class="form-control input-lg" name="numeroPrestador" placeholder="Ingresar numero" required>



                </div>



                   @if(Auth::user()->role == "Prestador")

                      <div class="col-lg-6" style="margin-top: 10px;">

                          <label for="role_profesion">{{ __('Profesion/Prestacion') }}</label>



                              <select id="role_profesion" type="text" class="form-control @error('role_profesion') is-invalid @enderror" name="profesion" value="{{ old('role_profesion') }}" autocomplete="profesion" autofocus>

                                    <option value="">Seleccionar...</option>

    {{--                                  @foreach($prestaciones as $prestacion)

                                        <option value="{{ $prestacion->nombre }}">{{ $prestacion->nombre }}</option>

                                     @endforeach --}}

                              </select>



                              @error('role_profesion')

                                  <span class="invalid-feedback" role="alert">

                                      <strong>{{ $message }}</strong>

                                  </span>

                              @enderror

                      </div>



                      <div class="col-lg-6" style="margin-top: 10px;">

                          <label for="utiliza_valor_profesion">{{ __('Utiliza Valor Nomenclador') }}</label>



                              <select id="utiliza_valor_profesion" type="text" class="form-control @error('role_profesion') is-invalid @enderror" name="utiliza_valor_profesion" value="{{ old('utiliza_valor_profesion') }}" autocomplete="utiliza_valor_profesion" autofocus>

                                <option value="">Seleccionar...</option>

                                <option value="T">Si</option>

                                <option value="F">No</option>

                              </select>



                              @error('role_profesion')

                                  <span class="invalid-feedback" role="alert">

                                      <strong>{{ $message }}</strong>

                                  </span>

                              @enderror

                      </div>



                       <div class="col-lg-12" style="margin-top: 15px" id="valor_profesion_personalizado">



                       </div>



                @elseif(Auth::user()->role == "Institucion")

                  <div class="col-lg-6" style="margin-top: 10px">

                    <label for="role_instit">{{ __('Institucion') }}</label>



                        <select id="role_profesion" type="text" class="form-control @error('role_instit') is-invalid @enderror" name="profesion" value="{{ old('role_institucion') }}" autocomplete="profesion" autofocus>

                            <option value="">Seleccionar...</option>

                        </select>



                        @error('role_institucion')

                            <span class="invalid-feedback" role="alert">

                                <strong>{{ $message }}</strong>

                            </span>

                        @enderror

                  </div>



                  <div class="col-lg-6" style="margin-top: 10px;">

                      <label for="utiliza_valor_profesion">{{ __('Utiliza Valor Nomenclador') }}</label>



                      <select id="utiliza_valor_profesion" type="text" class="form-control @error('role_profesion') is-invalid @enderror" name="utiliza_valor_profesion" value="{{ old('utiliza_valor_profesion') }}" autocomplete="utiliza_valor_profesion" autofocus>

                          <option value="">Seleccionar...</option>

                          <option value="T">Si</option>

                          <option value="F">No</option>

                      </select>



                      @error('role_profesion')

                      <span class="invalid-feedback" role="alert">

                                  <strong>{{ $message }}</strong>

                              </span>

                      @enderror

                  </div>



                  <div class="col-lg-12" style="margin-top: 15px" id="valor_profesion_personalizado">



                  </div>



                @elseif(Auth::user()->role == "Traslado")

                  <div class="col-lg-12 mt-2">

                    <label for="role_traslado">{{ __('Traslado') }}</label>



                        <select id="role_profesion" type="text" class="form-control @error('role_traslado') is-invalid @enderror" name="profesion" value="{{ old('role_traslado') }}" autofocus>

                            <option value="">Seleccionar Tipo de Traslado</option>

                        </select>



                        @error('role_institucion')

                            <span class="invalid-feedback" role="alert">

                                <strong>{{ $message }}</strong>

                            </span>

                        @enderror

                  </div>



                  <div class="col-lg-6" style="margin-top: 10px;">

                          <label for="utiliza_valor_profesion">{{ __('Utiliza Valor Nomenclador') }}</label>



                              <select id="utiliza_valor_profesion" type="text" class="form-control @error('role_profesion') is-invalid @enderror" name="utiliza_valor_profesion" value="{{ old('utiliza_valor_profesion') }}" autocomplete="utiliza_valor_profesion" autofocus>

                                <option value="">Seleccionar...</option>

                                <option value="T">Si</option>

                                <option value="F">No</option>

                              </select>



                              @error('role_profesion')

                                  <span class="invalid-feedback" role="alert">

                                      <strong>{{ $message }}</strong>

                                  </span>

                              @enderror

                      </div>



                       <div class="col-lg-12" style="margin-top: 15px" id="valor_profesion_personalizado">



                       </div>



                @endif





				<div class="col-lg-6" style="margin-top: 15px">			

					<label for="quitar_feriado">Quitar feriados por defecto?</label>

					<select type="text" class="form-control" id="quitar_feriado" name="quitar_feriado">

						<option value="">Seleccionar...</option>

						<option value="Si">Si</option>

						<option value="No">No</option>

					</select>

				</div>

                    

				<div class="col-lg-6" style="margin-top: 15px">

					<label for="mover_dias">Mover Dias?</label>

					<select type="text" class="form-control" id="mover_dias" name="mover_dias">

						<option value="">Seleccionar...</option>

						<option value="Si">Si</option>

						<option value="No">No</option>

					</select>

				</div>



              </div>



            </div>



          </div>



        </div>



        <!--=====================================

        PIE DEL MODAL

        ======================================-->



        <div class="modal-footer">



          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>



          <button type="submit" class="btn btn-primary">Guardar datos</button>



        </div>



      </form>



    </div>



  </div>



</div>



{{-- Editar prestacion --}}

<div id="modalEditarPrestacion" tabindex="-1" aria-hidden="true" class="modal fade" role="dialog">



  <div class="modal-dialog modal-lg">



    <div class="modal-content">



      <form role="form" method="POST" action="{{ route('prestador-update') }}">

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



            <!-- ENTRADA PARA EL NUMERO DE PRESTADOR -->



            <div class="form-group col-lg-12">



              <div class="input-group col-lg-12">



                <div class="col-lg-6" style="margin-top: 10px;">



                      <label for="editarNumeroPrestador">Editar número de Prestador</label>



                      <input type="text" class="form-control" name="editarNumeroPrestador" id="editarNumeroPrestador" placeholder="Ingresar numero" required>



                </div>



              <!-- ENTRADA PARA EL VALOR POR DEFECTO DE PRESTACION -->



              <div class="col-lg-6" style="margin-top: 10px;">

                  <label for="editar_utiliza_valor_profesion">{{ __('Utiliza Valor Nomenclador') }}</label>



                      <select id="editar_utiliza_valor_profesion" type="text" class="form-control" name="editar_utiliza_valor_profesion" value="{{ old('editar_utiliza_valor_profesion') }}" autocomplete="editar_utiliza_valor_profesion" autofocus>

                        <option value="">Seleccionar...</option>

                        <option value="T">Si</option>

                        <option value="F">No</option>

                      </select>



              </div>



                <div class="col-lg-12" style="margin-top: 15px" id="editar_valor_profesion_personalizado">



				 </div>

				 

				<div class="col-lg-6" style="margin-top: 15px">    

					<label for="editar_quitar_feriado">Quitar feriados por defecto?</label>

					<select type="text" class="form-control" id="editar_quitar_feriado" name="editar_quitar_feriado">

						<option value="">Seleccionar...</option>

						<option value="Si">Si</option>

						<option value="No">No</option>

					</select>

				</div>



				<div class="col-lg-6" style="margin-top: 15px">

					<label for="editar_mover_dias">Mover Dias?</label>

					<select type="text" class="form-control" id="editar_mover_dias" name="editar_mover_dias">

						<option value="">Seleccionar...</option>

						<option value="Si">Si</option>

						<option value="No">No</option>

					</select>

				</div>



              </div>



            </div>



          </div>



        </div>



        <!--=====================================

        PIE DEL MODAL

        ======================================-->



        <div class="modal-footer">



          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>



          <button type="submit" class="btn btn-primary">Guardar datos</button>



        </div>



        <input type="hidden" name="id" id="id">



      </form>



    </div>



  </div>



</div>







@endsection

