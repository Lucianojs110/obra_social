@extends('layouts.app', ['prestador' => $prestador_menu])



@section('content')

<div class="content-wrapper">



  <section class="content-header">

    

    <h1>

      

      Módulo de Obra Social.

    

    </h1>



    <div style="padding-top: 15px">

        @include('includes.message')

     </div>



    <ol class="breadcrumb">

      

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>

      

      <li class="active">Obra Social</li>

    

    </ol>



  </section>



  <section class="content">



    <div class="box">



      <div class="box-header with-border">

  

        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarOS">

          

          Agregar Datos



        </button>



      </div>



      <div class="box-body">

        

       <table class="table table-bordered table-striped dt-responsive tablas">

         

        <thead>

         

         <tr>

           

           <th style="width:10px">#</th>

           <th>Nombre / Razón social</th>

           <th>Tipo</th>

           <th>CUIT</th>

           <th>Telefono</th>

           <th>Ciudad</th>

           <th>Dirección</th>

           <th>E-Mail</th>

           <th>Condición IVA</th>

          <!-- <th>Valor de Sesión</th>

           <th>Valor de KM</th>

           <th>Valor de Módulo</th>-->

           <th>Acciones</th>



         </tr> 



        </thead>



        <tbody>



          @foreach($os as $key=>$obra)

          

          <tr>

            <td>{{ $key+1 }}</td>

            <td>{{ $obra->nombre }}</td>

            <td>{{ $obra->tipo_obra }}</td>

            <td>{{ $obra->cuit }}</td>

            <td>{{ $obra->telefono }}</td>

            <td>{{ $obra->ciudad }}</td>

            <td>{{ $obra->direccion }}</td>

            <td>{{ $obra->email }}</td>

            <td>{{ $obra->condicion_iva }}</td>

          <!--  <td>{{ $obra->valor_sesion }}</td>

            <td>{{ $obra->valor_km }}</td>

            <td>{{ $obra->valor_modulo }}</td>
          -->

            <td>

              <div class="btn-group">

                  

                <button class="btn btn-warning btnEditarOs" data-toggle="modal" data-target="#modalEditarOS" idOs="{{ $obra->id }}"><i class="fa fa-pencil"></i></button>



                <button class="btn btn-danger btnEliminarOs" idOs="{{ $obra->id }}"><i class="fa fa-trash"></i></button>



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

MODAL AGREGAR OBRA SOCIAL

======================================-->



<div id="modalAgregarOS" class="modal fade" role="dialog">

  

  <div class="modal-dialog modal-lg">



    <div class="modal-content">



      <form role="form" method="POST" action="{{ route('os-create') }}">

        @csrf



        <!--=====================================

        CABEZA DEL MODAL

        ======================================-->



        <div class="modal-header" style="background:#3c8dbc; color:white">



          <button type="button" class="close" data-dismiss="modal">&times;</button>



          <h4 class="modal-title">Agregar Obra Social</h4>



        </div>



        <!--=====================================

        CUERPO DEL MODAL

        ======================================-->



        <div class="modal-body">



          <div class="box-body">



            <!-- ENTRADA PARA EL NOMBRE -->

            

            <div class="form-group">



              <label for="nombre">Nombre</label>

              

              <div class="input-group">

              

                <span class="input-group-addon"><i class="fa fa-user"></i></span> 



                <input type="text" class="form-control input-lg" name="nombre" placeholder="Ingresar nombre / Razón Social">



              </div>



            </div>



            <!-- ENTRADA PARA EL TIPO DE OBRA SOCIAL -->

            

            <div class="form-group">



              <label for="tipoObra">Tipo de Obra Social</label>

              

              <div class="input-group">

              

                <span class="input-group-addon"><i class="fa fa-user"></i></span> 



                <select type="text" class="form-control input-lg" name="tipoObra">

                    <option value="">Seleccionar..</option>

                    <option value="Nacional">Nacional</option>

                    <option value="Provincial">Provincial</option>

                </select>



              </div>



            </div>



             <!-- ENTRADA PARA EL DOCUMENTO -->

            

            <div class="form-group">



              <label for="cuit">CUIT</label>

              

              <div class="input-group">

              

                <span class="input-group-addon"><i class="fa fa-key"></i></span> 



                <input type="number" min="0" class="form-control input-lg" name="cuit" placeholder="Ingresar CUIT">



              </div>



            </div>



            <!-- ENTRADA PARA LA CIUDAD -->

            

            <div class="form-group">



              <label for="ciudad">Ciudad</label>

              

              <div class="input-group">

              

                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 



                <input type="text" class="form-control input-lg" name="ciudad" placeholder="Ingresar ciudad">



              </div>



            </div>



             <!-- ENTRADA PARA LA DIRECCION -->

            

            <div class="form-group">



              <label for="direccion">Dirección</label>

              

              <div class="input-group">

              

                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 



                <input type="text" class="form-control input-lg" name="direccion" placeholder="Ingresar dirección">



              </div>



            </div>



             <!-- ENTRADA PARA EL TELEFONO -->

            

            <div class="form-group">



              <label for="telefono">Telefono</label>

              

              <div class="input-group">

              

                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 



                <input type="number" min="0" class="form-control input-lg" name="telefono" placeholder="Ingresar teléfono">



              </div>



            </div>



             <!-- ENTRADA PARA EMAIL -->



              <div class="form-group">



                <label for="email">E-Mail</label>

                

                <div class="input-group">

                

                  <span class="input-group-addon"><i class="fa fa-envelope"></i></span> 



                  <input type="mail" class="form-control input-lg" name="email" placeholder="Ingresar email">



                </div>



              </div>

            

{{--             <div class="form-group">

              

              <div class="input-group">

              

                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 



                <input type="text" class="form-control input-lg" name="nuevaFechaNacimiento" placeholder="Ingresar fecha de nacimiento" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>



              </div>



            </div> --}}



             <!-- ENTRADA PARA CONDICION IVA -->

            

            <div class="form-group">



              <label for="condicionIva">Condición IVA</label>

              

              <div class="input-group">

              

                <span class="input-group-addon"><i class="fa fa-info"></i></span> 



                 <select type="text" class="form-control" name="condicionIva">

                          <option value="">Seleccionar..</option>

                          <option value="Responsable Inscripto">Responsable Inscripto</option>

                          <option value="Responsable NO Inscripto">Responsable NO Inscripto</option>

                          <option value="Exento">Exento</option>

                          <option value="Monotributo">Monotributo</option>

                  </select>



              </div>



            </div>



              <!-- ENTRADA PARA VALOR NOMENCLADOR -->





<div class="form-group">


              <label for="nomenclador">Usar nomenclador nacional</label>

              

              <div class="input-group">


                <select type="text" class="form-control" name="nomenclador">

                    <option value="">Seleccionar..</option>

                    <option value="1">Si</option>

                    <option value="0">No</option>

                </select>

</div>

 



            </div>




        <!--=====================================

        PIE DEL MODAL

        ======================================-->



        <div class="modal-footer">



          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>



          <button type="submit" class="btn btn-primary">Guardar Obra Social</button>



        </div>



      </div>



    </div>



      </form>



    </div>



  </div>



</div>





 <!--=====================================

  MODAL EDITAR OBRA SOCIAL

  ======================================-->



   <div id="modalEditarOS" class="modal fade" role="dialog">

    

    <div class="modal-dialog modal-lg">



      <div class="modal-content">



        <form role="form" method="POST" action="{{ route('os-update') }}">

          @csrf



          <!--=====================================

          CABEZA DEL MODAL

          ======================================-->



          <div class="modal-header" style="background:#3c8dbc; color:white">



            <button type="button" class="close" data-dismiss="modal">&times;</button>



            <h4 class="modal-title">Editar Obra Social</h4>



          </div>



          <!--=====================================

          CUERPO DEL MODAL

          ======================================-->



          <div class="modal-body">



            <div class="box-body">



              <!-- ENTRADA PARA EL NOMBRE -->

              

              <div class="form-group">



                <label for="editarNombre">Nombre</label>

                

                <div class="input-group">

                

                  <span class="input-group-addon"><i class="fa fa-user"></i></span> 



                  <input type="text" class="form-control input-lg" id="editarNombre" name="editarNombre" placeholder="Ingresar nombre / Razón Social">



                </div>



              </div>



             <!-- ENTRADA PARA EL TIPO DE OBRA SOCIAL -->

            

              <div class="form-group">



                <label for="tipoObra">Tipo de Obra Social</label>

                

                <div class="input-group">

                

                  <span class="input-group-addon"><i class="fa fa-user"></i></span> 



                  <select type="text" class="form-control input-lg" id="editarTipoObra" name="editarTipoObra">

                      <option value="">Seleccionar..</option>

                      <option value="Nacional">Nacional</option>

                      <option value="Provincial">Provincial</option>

                  </select>



                </div>



              </div>



               <!-- ENTRADA PARA EL DOCUMENTO -->

              

              <div class="form-group">



                <label for="editarCuit">CUIT</label>

                

                <div class="input-group">

                

                  <span class="input-group-addon"><i class="fa fa-key"></i></span> 



                  <input type="number" min="0" class="form-control input-lg" id="editarCuit" name="editarCuit" placeholder="Ingresar CUIT">



                </div>



              </div>



              <!-- ENTRADA PARA LA CIUDAD -->

              

              <div class="form-group">



                <label for="editarCiudad">Ciudad</label>

                

                <div class="input-group">

                

                  <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 



                  <input type="text" class="form-control input-lg" id="editarCiudad" name="editarCiudad" placeholder="Ingresar ciudad">



                </div>



              </div>



               <!-- ENTRADA PARA LA DIRECCION -->

              

              <div class="form-group">



                <label for="editarDireccion">Dirección</label>

                

                <div class="input-group">

                

                  <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 



                  <input type="text" class="form-control input-lg" id="editarDireccion" name="editarDireccion" placeholder="Ingresar dirección">



                </div>



              </div>



               <!-- ENTRADA PARA EL TELEFONO -->

              

              <div class="form-group">



                <label for="editarTelefono">Telefono</label>

                

                <div class="input-group">

                

                  <span class="input-group-addon"><i class="fa fa-phone"></i></span> 



                  <input type="number" min="0" class="form-control input-lg" id="editarTelefono" name="editarTelefono" placeholder="Ingresar teléfono">



                </div>



              </div>



               <!-- ENTRADA PARA EMAIL -->



                <div class="form-group">



                  <label for="editarEmail">E-Mail</label>

                  

                  <div class="input-group">

                  

                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span> 



                    <input type="mail" class="form-control input-lg" id="editarEmail" name="editarEmail" placeholder="Ingresar email">



                  </div>



                </div>

              

  {{--             <div class="form-group">

                

                <div class="input-group">

                

                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 



                  <input type="text" class="form-control input-lg" name="nuevaFechaNacimiento" placeholder="Ingresar fecha de nacimiento" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>



                </div>



              </div> --}}



               <!-- ENTRADA PARA CONDICION IVA -->

              

              <div class="form-group">



                <label for="editarCondicionIva">Condición IVA</label>

                

                <div class="input-group">

                

                  <span class="input-group-addon"><i class="fa fa-info"></i></span> 



                   <select type="text" class="form-control" id="editarCondicionIva" name="editarCondicionIva">

                            <option value="">Seleccionar..</option>

                            <option value="Responsable Inscripto">Responsable Inscripto</option>

                            <option value="Responsable NO Inscripto">Responsable NO Inscripto</option>

                            <option value="Exento">Exento</option>

                            <option value="Monotributo">Monotributo</option>

                    </select>



                </div>



              </div>






              <!-- ENTRADA PARA VALOR NOMENCLADOR -->





<div class="form-group">


              <label for="nomenclador">Usar nomenclador nacional</label>

              

              <div class="input-group">


                <select type="text" class="form-control" name="editarnomenclador" id="editarnomenclador">

                    <option value="">Seleccionar..</option>

                    <option value="1">Si</option>

                    <option value="0">No</option>

                </select>

</div>

 



            </div>



        







            <!--=====================================

            PIE DEL MODAL

            ======================================-->



            <div class="modal-footer">



              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>



              <button type="submit" class="btn btn-primary">Guardar Obra Social</button>



            </div>



          </div>



        </div>



        <input type="hidden" name="id" id="id">



      </form>



    </div>



  </div>



</div>



@endsection