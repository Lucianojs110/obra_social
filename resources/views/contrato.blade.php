@extends('layouts.app', ['prestador' => $prestador_menu])



@section('content')

<div class="content-wrapper">



  <section class="content-header">



    <h1>



      Módulo de contrato



    </h1>



     <div style="padding-top: 15px">

        @include('includes.message')

     </div>



    <ol class="breadcrumb">



      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>



      <li class="active">contrato</li>



    </ol>



  </section>



  <section class="content">



    <div class="box">



      @if(Auth::user()->role == "Administrador")



        <div class="box-header with-border">

        

          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarcontrato">



            Agregar contrato



          </button>



        </div>



      @endif



      <div class="box-body">


@if(count($contrato)>2)
       <table class="table table-bordered table-striped dt-responsive contrato">



        <thead>



         <tr>



           <th style="width:10px">#</th>

           <th>Descripción</th>
           <th>Ver</th>

           @if(Auth::user()->role == "Administrador")

            <th>Acciones</th>

           @endif



         </tr>



        </thead>



        <tbody>



          @foreach ($contrato as $key => $contrato)


          @if(strlen($contrato)>2)
          <tr>

            <td>{{ ($key+1) }}</td>

            <td>Contrato</td>

            <td>@if ($contrato)
              <a href="{{ '/public/uploads/contrato/'.$contrato}}" target="_BLANK"><button class="btn btn-primary"><i class="fa fa-file-pdf-o"></i></button></a>
              @endif
            </td>

            

            @if(Auth::user()->role == "Administrador")

              <td>

                <div class="btn-group">

                  <button class="btn btn-warning btnEditarcontrato" data-toggle="modal" data-target="#modalEditarcontrato" ><i class="fa fa-pencil"></i></button>

                  <button class="btn btn-danger btnEliminarcontrato" ><i class="fa fa-times"></i></button>

                </div>

              </td>

            @endif

          </tr>

          @endif

          @endforeach



        </tbody>



       </table>

@endif

      </div>



    </div>



  </section>



</div>



<!--=====================================

MODAL AGREGAR PRESTACION

======================================-->



<div id="modalAgregarcontrato" class="modal fade" role="dialog">



  <div class="modal-dialog">



    <div class="modal-content">



      <form role="form" method="POST" action="{{ route('contrato-create') }}" enctype="multipart/form-data">



        @csrf



        <!--=====================================

        CABEZA DEL MODAL

        ======================================-->



        <div class="modal-header" style="background:#3c8dbc; color:white">



          <button type="button" class="close" data-dismiss="modal">&times;</button>



          <h4 class="modal-title">Agregar contrato</h4>



        </div>



        <!--=====================================

        CUERPO DEL MODAL

        ======================================-->



        <div class="modal-body">



          <div class="box-body">



            

         

           <div class="form-group">



              <label for="codigo_modulo">Archivo pdf</label>



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



          <button type="submit" class="btn btn-primary">Guardar contrato</button>



        </div>



      </form>



    </div>



  </div>



</div>



<!--=====================================

MODAL EDITAR contrato

======================================-->



<div id="modalEditarcontrato" class="modal fade" role="dialog">



  <div class="modal-dialog">



    <div class="modal-content">



      <form role="form" method="POST" action="{{ route('contrato-create') }}" enctype="multipart/form-data">



        <input type="hidden" name="id" id="contrato_id">



        @csrf



        <!--=====================================

        CABEZA DEL MODAL

        ======================================-->



        <div class="modal-header" style="background:#3c8dbc; color:white">



          <button type="button" class="close" data-dismiss="modal">&times;</button>



          <h4 class="modal-title">Editar contrato</h4>



        </div>



        <!--=====================================

        CUERPO DEL MODAL

        ======================================-->



        <div class="modal-body">



          <div class="box-body">



          

         

           <div class="form-group">



              <label for="codigo_modulo">Archivo pdf</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-play"></i></span>



                <input type="file" name="file" class="form-control">



              </div>



            </div>
            <div id="eliminarcontrato"></div>
 </div>


        </div>



        <!--=====================================

        PIE DEL MODAL

        ======================================-->



        <div class="modal-footer">



          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>



          <button type="submit" class="btn btn-primary">Guardar contrato</button>



        </div>



      </form>



    </div>



  </div>



</div>



@endsection

