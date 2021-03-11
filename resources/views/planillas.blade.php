@extends('layouts.app', ['prestador' => $prestador_menu])



@section('content')

<div class="content-wrapper">



  <section class="content-header">



    <h1>



      PLANILLAS



    </h1>



     <div style="padding-top: 15px">

        @include('includes.message')

     </div>



    <ol class="breadcrumb">



      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>



      <li class="active">Planillas</li>



    </ol>



  </section>



  <section class="content">



    <div class="box">



      <div class="box-header with-border">



        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarPlanilla">



          Agregar Planilla



        </button>



      </div>



      <div class="box-body">



       <table class="table table-bordered table-striped dt-responsive tablas">



        <thead>



         <tr>



           <th style="width:10px">#</th>

           <th>Nombre</th>
           <th>Obra social</th>

           <th>Prestacion</th>

           <th>Archivo</th>
           <th>Archivo subido</th>
<th>Acciones</th>
    
         </tr>



        </thead>



        <tbody>



          @foreach ($planillas as $key => $planilla)
			

          <tr>

            <td>{{ ($key+1) }}</td>

            <td>{{ $planilla->nombre}}       
              </td>

           

            <td>{{ $planilla->obrasocial->nombre}}</td>

       <td>{{ (@$planilla->prestacion->categoria->nombre)?$planilla->prestacion->nombre." ".$planilla->prestacion->categoria->nombre:$planilla->prestacion->nombre}}</td>

            <td>{{ $planilla->archivo }}</td>

<td>@if(file_exists('resources/views/forms/nomenclador/'.$planilla->archivo.'.blade.php'))
  si
  @else
  no
@endif</td>

            <td>

              <div class="btn-group">



                <button class="btn btn-warning btnEditarPlanilla" idPrest="{{ $planilla->id }}" data-toggle="modal" data-target="#modalEditarPlanilla"><i class="fa fa-pencil"></i></button>



                <button class="btn btn-danger btnEliminarPlanilla" idPrest="{{ $planilla->id }}"><i class="fa fa-times"></i></button>



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

MODAL AGREGAR Planilla

======================================-->



<div id="modalAgregarPlanilla" class="modal fade" role="dialog">



  <div class="modal-dialog">



    <div class="modal-content">



      <form role="form" method="POST" action="{{ route('planilla-create') }}" enctype="multipart/form-data">

        @csrf



        <!--=====================================

        CABEZA DEL MODAL

        ======================================-->



        <div class="modal-header" style="background:#3c8dbc; color:white">



          <button type="button" class="close" data-dismiss="modal">&times;</button>



          <h4 class="modal-title">Agregar Planilla</h4>



        </div>



        <!--=====================================

        CUERPO DEL MODAL

        ======================================-->



        <div class="modal-body">



          <div class="box-body">



            <!-- ENTRADA PARA OBRA SOCIAL -->


           
            <div class="form-group">



              <label for="obra_social">Obra Social</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-user"></i></span>



                <select type="text"  class="form-control input-lg" name="obra_social" placeholder="Seleccionar Obra Social" required>



                  <option value="">Seleccionar obra social...</option>



                  @foreach ($obras_sociales as $obra_social)

                    <option value="{{ $obra_social->id }}">{{ $obra_social->nombre }}</option>

                  @endforeach



                </select>



              </div>



            </div>

 <!-- ENTRADA PARA Prestacion -->



            <div class="form-group">



              <label for="obra_social">Prestacion</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-user"></i></span>



                <select type="text" class="form-control input-lg" name="prestacion" placeholder="Seleccionar Categoria" required>



                  <option value="">Seleccionar Prestacion...</option>
                     @foreach ($prestaciones as $prestacion)
                    <option value="{{ $prestacion->id }}">{{ (@$prestacion->categoria->nombre)?$prestacion->nombre." ".$prestacion->categoria->nombre:$prestacion->nombre}} 
                      {{$prestacion->descripcion}}</option>

                  @endforeach

                </select>



              </div>



            </div>


          <!-- ENTRADA PARA EL NOMBRE -->



            <div class="form-group">



              <label for="codigo_modulo">Nombre</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-user"></i></span>



                <input type="text" class="form-control input-lg" name="nombre" placeholder="Ingresar el nombre" required>



              </div>



            </div>



            <!-- ENTRADA PARA EL NOMBRE -->



            <div class="form-group">



              <label for="Planilla">Archivo</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-user"></i></span>



                <input type="text"  class="form-control input-lg" name="archivo" placeholder="Ingresar nombre del archivo" required>
<small>El nombre del archivo corresponde al archivo nombre.blade.php que se guardará en la carpeta resources/views/forms, utilice nombres en minusculas y sin caracteres extraños</small>


              </div>



            </div>
 <div class="form-group">



              <label for="codigo_modulo">Archivo (html)</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-play"></i></span>



                <input type="file" name="file" class="form-control">



              </div>



            </div>






          </div>



        </div>



        <!--=====================================

        PIE DEL MODAL

        ======================================-->



        <div class="modal-footer">



          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>



          <button type="submit" class="btn btn-primary">Guardar Planilla</button>



        </div>



      </form>



    </div>



  </div>



</div>



<!--=====================================

MODAL EDITAR Planilla

======================================-->



<div id="modalEditarPlanilla" class="modal fade" role="dialog">



  <div class="modal-dialog">



    <div class="modal-content">



      <form role="form" method="POST" action="{{ route('planilla-edit') }}"  enctype="multipart/form-data">
        <input type="hidden" id="id" name="id" value="">

        @csrf



        <!--=====================================

        CABEZA DEL MODAL

        ======================================-->



        <div class="modal-header" style="background:#3c8dbc; color:white">



          <button type="button" class="close" data-dismiss="modal">&times;</button>



          <h4 class="modal-title">Editar Planilla</h4>



        </div>



        <!--=====================================

        CUERPO DEL MODAL

        ======================================-->



      
        <div class="modal-body">



          <div class="box-body">



            <!-- ENTRADA PARA OBRA SOCIAL -->


           
            <div class="form-group">



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



            </div>

 <!-- ENTRADA PARA prestacion -->



            <div class="form-group">



              <label for="obra_social">Prestacion</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-user"></i></span>



                <select type="text" class="form-control input-lg" name="prestacion" id="prestacion" placeholder="Seleccionar Categoria" required>



                  <option value="">Seleccionar Prestacion...</option>
                     @foreach ($prestaciones as $prestacion)
                    <option value="{{ $prestacion->id }}">{{ (@$prestacion->categoria->nombre)?$prestacion->nombre." ".$prestacion->categoria->nombre:$prestacion->nombre}}</option>

                  @endforeach

                </select>



              </div>



            </div>


          <!-- ENTRADA PARA EL NOMBRE -->



            <div class="form-group">



              <label for="codigo_modulo">Nombre</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-user"></i></span>



                <input type="text" class="form-control input-lg" name="nombre" id="nombre" placeholder="Ingresar el nombre" required>



              </div>



            </div>



            <!-- ENTRADA PARA EL NOMBRE -->



            <div class="form-group">



              <label for="Planilla">Archivo</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-user"></i></span>



                <input type="text"  class="form-control input-lg" name="archivo"  id="archivo" placeholder="Ingresar nombre del archivo" required readonly>
<small>El nombre del archivo corresponde al archivo nombre.blade.php que se guardará en la carpeta resources/views/forms, utilice nombres en minusculas y sin caracteres extraños</small>


              </div>
               <div class="form-group">



              <label for="codigo_modulo">Archivo (html)</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-play"></i></span>



                <input type="file" name="file" class="form-control">



              </div>



            </div>

<div class="modal-footer">



          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>



          <button type="submit" class="btn btn-primary">Guardar Planilla</button>



        </div>



      </form>

            </div>







          </div>



        </div>



@endsection

