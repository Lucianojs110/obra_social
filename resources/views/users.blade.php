@extends('layouts.app', ['prestador' => $prestador_menu])



@section('content')

<?php 
$provincia = DB::table('provincias')->select('id', 'provincia')->get();

?>
<div class="content-wrapper">



  <section class="content-header">



    <h1>



      Módulo de Usuarios.



    </h1>



     <div style="padding-top: 15px">

        @include('includes.message')

     </div>



    <ol class="breadcrumb">



      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>



      <li class="active">Usuarios</li>



    </ol>



  </section>



  <section class="content">



    <div class="box">



      <div class="box-body">



       <table class="table table-bordered table-striped dt-responsive tablas">



        <thead>



         <tr>



           <th style="width:10px">#</th>

           <th>Nombre</th>

           <th>Usuario</th>

           <th>Rol</th>

           <th>Acciones</th>



         </tr>



        </thead>



        <tbody>



          @foreach ($users as $key => $user)



          <tr>

            <td>{{ ($user->id) }}</td>

            <td>{{ $user->name . " " . $user->surname }}</td>

            <td>{{ $user->role }}</td>

            <td>{{ $user->email }}</td>



            <td>

              <div class="btn-group">
                @if($user->id !=1)
                       <button class="btn btn-success btnEnviarMensajeAdmin" data-toggle="modal" data-target="#modalAgregarMensaje" iduser="{{ $user->id}}"><i class="fa fa-paper-plane"></i></button>
                @endif
                <button class="btn btn-warning btnEditarUsuario" data-toggle="modal" data-target="#modalEditarUsuario" iduser="{{ $user->id}}"><i class="fa fa-pencil"></i></button>
                @if($user->id !=1)
                 <button type="button" class="btn {{ $user->banned_until == null ? 'btn-success' : 'btn-danger' }} btnBloquearUsuario" iduser="{{ $user->id}}" banned="{{ $user->banned_until?'1':'0'}}"><i class="fa fa-user-circle"></i></button>
                <button class="btn btn-danger btnEliminarUsuario" iduser="{{ $user->id}}"><i class="fa fa-times"></i></button>
                
               
                @endif

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

MODAL EDITAR USUARIO

======================================-->



<div id="modalEditarUsuario" class="modal fade" role="dialog">



  <div class="modal-dialog">



    <div class="modal-content">



      <form role="form" method="POST" action="{{ route('update-usuario') }}">

        @csrf



        <!--=====================================

        CABEZA DEL MODAL

        ======================================-->



        <div class="modal-header" style="background:#3c8dbc; color:white">



          <button type="button" class="close" data-dismiss="modal">&times;</button>



          <h4 class="modal-title">Datos de usuario <span id="name"></span></h4>



        </div>



        <!--=====================================

        CUERPO DEL MODAL

        ======================================-->



        <div class="modal-body">



          <div class="box-body">



            <!-- ENTRADA PARA DIRECCION -->

            

            <div class="form-group col-lg-12">

                

                <div class="input-group col-lg-12">



                  <div class="col-lg-4">



                        <label for="direccion">Dirección</label>

 <input type="hidden" value="" class="form-control input-lg" name="iduser" id="iduser" >

                        <input type="text" value="" class="form-control input-lg" name="direccion" id="direccion" placeholder="Ingresar direccion">



                  </div>



                  <div class="col-lg-4">



                        <label for="localidad">Localidad</label>



                        <input type="text" class="form-control input-lg" name="localidad" id="localidad" placeholder="Ingresar Localidad">

                        



                  </div>
                   <div class="col-lg-4">



                        <label for="provincia">Provincia</label>



                        <select type="text" class="form-control input-lg" name="provincia" id="provincia" placeholder="Ingresar Provincia">

                          <option value="">Seleccionar...</option>
                        @foreach($provincia as $key=>$pr)

              <option value="{{ $pr->id }}">{{ $pr->provincia }}</option>

            @endforeach
                          
                        </select>



                  </div>




                </div>



              </div>



              <!--Entrada para correo y telefono -->



                <div class="form-group col-lg-12">

                

                <div class="input-group col-lg-12">



                  <div class="col-lg-6">



                        <label for="correo">Correo</label>



                        <input type="email" value="" class="form-control input-lg" name="correo" id="correo" readonly placeholder="Ingresar correo">



                  </div>

                

                  <div class="col-lg-6">



                        <label for="telefono">Telefono</label>



                        <input type="text" value="" class="form-control input-lg" name="telefono" id="telefono" placeholder="Ingresar Telefono">



                  </div>



                </div>



              </div>



              <!--Entrada para condicion iva & iibb -->



              <div class="form-group col-lg-12">

                

                <div class="input-group col-lg-12">



                  <div class="col-lg-6">



                        <label for="condicionIva">Condicion IVA</label>



                        <select type="text" class="form-control" name="condicionIva" id="condicionIva">


                          <option value="Responsable Inscripto">Responsable Inscripto</option>

                          <option value="Responsable NO Inscripto">Responsable NO Inscripto</option>

                          <option value="Exento">Exento</option>

                          <option value="Monotributo">Monotributo</option>

                        </select>



                  </div>

                

                  <div class="col-lg-6">



                        <label for="condicionIibb">Condicion IIBB</label>



                        <select type="text" class="form-control" name="condicionIibb" id="condicionIibb">


                          <option value="Inscripto">Inscripto</option>

                          <option value="Convenio Multilateral">Convenio Multilateral</option>

                          <option value="Exento">Exento</option>

                        </select>



                  </div>



                </div>



              </div>



               <!--Entrada para CUIT y IIBB -->



              <div class="form-group col-lg-12">

                

                <div class="input-group col-lg-12">



                  <div class="col-lg-6">



                        <label for="cuit">CUIT</label>



                        <input type="text" value="" class="form-control input-lg" name="cuit" id="cuit" placeholder="Ingresar CUIT">



                  </div>

                

                  <div class="col-lg-6">



                        <label for="iibb">IIBB</label>



                        <input type="text" value="" class="form-control input-lg" name="iibb" id="iibb" placeholder="Ingresar IIBB">



                  </div>



                </div>



              </div>



              <!--Entrada para CBU y Entidad Bancaria -->



              <div class="form-group col-lg-12">

                

                <div class="input-group col-lg-12">



                  <div class="col-lg-6">



                        <label for="entidadBancaria">Entidad Bancaria</label>



                        <input type="text" value="" class="form-control input-lg" name="entidadBancaria" id="entidadBancaria" placeholder="Ingresar Entidad">



                  </div>

                

                  <div class="col-lg-6">



                        <label for="cbu">CBU</label>



                        <input type="number" value="" class="form-control input-lg" name="cbu" id="cbu" placeholder="Ingresar CBU">



                  </div>



                </div>



              </div>



              <!--Entrada para Cheque y Lugar de Pago -->



              <div class="form-group col-lg-12">

                

                <div class="input-group col-lg-12">



                  <div class="col-lg-6">



                        <label for="ordenCheque">Orden Cheque</label>



                        <input type="text" value="" class="form-control input-lg" name="ordenCheque" id="ordenCheque" placeholder="Ingresar Orden">



                  </div>

                

                  <div class="col-lg-6">



                        <label for="lugarPago">Lugar de Pago</label>



                        <input type="text" value="" class="form-control input-lg" name="lugarPago"  id="lugarPago" placeholder="Ingresar Lugar de Pago">



                  </div>



                </div>



              </div>



              <!--Entrada para Emp. Seguros y Poliza -->



              <div class="form-group col-lg-12">

                

                <div class="input-group col-lg-12">



                  <div class="col-lg-6">



                        <label for="empSeguros">Emp. Seguros</label>



                        <input type="text" value="" class="form-control input-lg" name="empSeguros" id="empSeguros" placeholder="Ingresar Emp. Seguros">



                  </div>

                

                  <div class="col-lg-6">



                        <label for="polSeguros">Numero de Poliza</label>



                        <input type="number" value="" class="form-control input-lg" name="polSeguros" id="polSeguros" placeholder="Ingresar Poliza">



                  </div>



                </div>



              </div>

            

          </div>



        </div>



        <input type="hidden" name="id" value="">



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

<!--=====================================

MODAL AGREGAR Mensaje

======================================-->



<div id="modalAgregarMensaje" class="modal fade" role="dialog">



  <div class="modal-dialog">



    <div class="modal-content">



      <form role="form" method="POST" action="{{ route('mensajes-store') }}" enctype="multipart/form-data">

<input type="hidden" name="id_envia" value="1">
<input type="hidden" name="redir" value="1">

        @csrf



        <!--=====================================

        CABEZA DEL MODAL

        ======================================-->



        <div class="modal-header" style="background:#3c8dbc; color:white">



          <button type="button" class="close" data-dismiss="modal">&times;</button>



          <h4 class="modal-title">Enviar Mensaje</h4>



        </div>



        <!--=====================================

        CUERPO DEL MODAL

        ======================================-->



        <div class="modal-body">



          <div class="box-body">

   <!-- ENTRADA PARA OPCION DE TODOS LOS USUARIOS -->

             <!-- ENTRADA PARA LOS USUARIOS -->



            <div class="form-group" id="listausuarios">



              <label for="obra_social">Usuarios</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-user-o"></i></span>

                <select type="text" class="form-control input-lg" name="id_recibe[]" id="id_recibe" placeholder="Seleccionar Usuario" multiple="multiple">
                  @foreach($users as $key=>$us)
                  @if($us->id!=1)  
                  <option value="{{ $us->id }}" {{($us->id ==1)?"selected":""}}>{{ $us->name." ".$us->surname }}</option>
                  @endif
                  @endforeach
                          
                </select>

              </div>



            </div>

            <!-- ENTRADA PARA EL TITULO -->



            <div class="form-group">



              <label for="obra_social">Titulo</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-minus"></i></span>



                <input type="text" class="form-control input-lg MensajeInput" name="titulo" placeholder="Ingresar Título" required>



              </div>



            </div>

              <!-- ENTRADA PARA EL MENSAJE -->


             <div class="form-group">



              <label for="obra_social">Mensaje</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-newspaper-o"></i></span>



                 <textarea type="text" class="form-control input-lg MensajeInput" name="mensaje" placeholder="Ingresar Mensaje" rows="10" required></textarea>


              </div>



            </div>



          </div>
           <div class="form-group">



              <label for="codigo_modulo">Archivo (pdf,jpeg,gif,png,doc,docx), Tamaño máximo: 2048</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-play"></i></span>



                <input type="file" name="file" class="form-control">



              </div>



            </div>



        </div>



        <!--=====================================

        PIE DEL MODAL

        ======================================-->



        <div class="modal-footer">



          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>



          <button type="submit" class="btn btn-primary">Guardar Mensaje</button>



        </div>



      </form>



    </div>



  </div>



</div>





@endsection

