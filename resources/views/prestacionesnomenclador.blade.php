@extends('layouts.app', ['prestador' => $prestador_menu])



@section('content')

<div class="content-wrapper">



  <section class="content-header">



    <h1>



      Prestación Nomenclador Nacional.



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


<form method="POST" role="form" action="{{ route('ordenarprestacionesnomenclador') }}">
   @csrf
  <button type="submit">Ordenar</button>
       <table class="table table-bordered table-striped dt-responsive tablas">



        <thead>



         <tr>



           <th style="width:10px">#</th>
  <th>Orden</th>
           <th>Nombre</th>
           

         <th>Descripción</th>

           <th>Acciones</th>



         </tr>



        </thead>



        <tbody>



          @foreach ($prestaciones as $key => $prestacion)



			

			

          <tr>

            <td>{{ ($prestacion->orden) }}</td>
            <td><input type="text" name="orden[{{ $prestacion->id }}]" value="{{ ($prestacion->orden) }}" style="width: 50px;"></td>

            <td>@if(is_null($prestacion->categoria))
              {{ $prestacion->nombre}}
              @else
              {{  $prestacion->nombre.' -'.$prestacion->categoria->nombre}}
              @endif
              </td>
              <td>{{$prestacion->descripcion}}</td>
            <td>

              <div class="btn-group">



                <a class="btn btn-warning btnEditarPrestacionNomenclador" idPrest="{{ $prestacion->id }}" data-toggle="modal" data-target="#modalEditarPrestacion"><i class="fa fa-pencil"></i></a>



                <a class="btn btn-danger" id="btnEliminarPrestacionNomenclador" idPrest="{{ $prestacion->id }}"><i class="fa fa-times"></i></a>



              </div>



            </td>



          </tr>



          @endforeach



        </tbody>



       </table>
</form>


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



      <form role="form" method="POST" action="{{ route('prestacionnoomenclador-create') }}">

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


            <input type="hidden" name="obra_social" value="">
           

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


        


            <!-- ENTRADA PARA EL NOMBRE -->



            <div class="form-group">



              <label for="prestacion">Prestación</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-user"></i></span>



                <input type="text" id="prestacion" class="form-control input-lg" name="prestacion" placeholder="Ingresar Prestación" required>



              </div>



            </div>

            <!-- ENTRADA PARA DESCRIPCION -->



            <div class="form-group">



              <label for="prestacion">Descripción</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-user"></i></span>


                <textarea  class="form-control input-lg" name="descripcion" placeholder="Ingresar Descripción" rows="5" ></textarea>



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



      <form role="form" method="POST" action="{{ route('prestacionnomenclador-edit') }}">

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



            <!-- ENTRADA PARA EL NOMBRE -->



            <div class="form-group">



              <label for="prestacion">Editar Prestación</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-user"></i></span>



                <input type="text" id="editar_prestacion" class="form-control input-lg" name="prestacion" placeholder="Editar Prestación" required>



              </div>



            </div>


<!-- ENTRADA PARA DESCRIPCION -->



            <div class="form-group">



              <label for="prestacion">Descripción</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-user"></i></span>


                <textarea id="descripcion" class="form-control input-lg" name="descripcion" placeholder="Ingresar Descripción" rows="5" ></textarea>



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

