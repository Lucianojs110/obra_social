@extends('layouts.app', ['prestador' => $prestador_menu])



@section('content')

<div class="content-wrapper">



  <section class="content-header">



    <h1>



      Módulo de Video Tutoriales.



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



      @if(Auth::user()->role == "Administrador")



        <div class="box-header with-border">

        

          <button class="btn btn-primary" data-toggle="modal" data-target="#modalEditarVideo">



            Agregar Video



          </button>



        </div>



      @endif



      <div class="box-body">



       <table class="table table-bordered table-striped dt-responsive tablas">



        <thead>



         <tr>



           <th style="width:10px">#</th>

           <th>Descripción</th>

           <th>Documento</th>

           <th>Video</th>

           @if(Auth::user()->role == "Administrador")

            <th>Acciones</th>

           @endif



         </tr>



        </thead>



        <tbody>



          @foreach ($videos as $key => $video)



          <tr>

            <td>{{ ($key+1) }}</td>

            <td>{{ $video->description}}</td>

            <td><a href="/public/uploads/{{ $video->url_document }}" target="_BLANK"><button class="btn btn-primary"><i class="fa fa-arrow-right"></i></button></a></td>

            <td><a href="{{ $video->url_video }}" target="_BLANK"><button class="btn btn-primary"><i class="fa fa-arrow-right"></i></button></a></td>

            

            @if(Auth::user()->role == "Administrador")

              <td>

                <div class="btn-group">

                  <button class="btn btn-warning btnEditarVideo" data-toggle="modal"  data-target="#modalEditarVideo2" data-id="{{$video->id}}"><i class="fa fa-pencil"></i></button>

                  <button class="btn btn-danger btnEliminarVideo" data-id="{{$video->id}}"><i class="fa fa-times"></i></button>

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

MODAL AGREGAR PRESTACION

======================================-->



<div id="modalAgregarVideo" class="modal fade" role="dialog">



  <div class="modal-dialog">



    <div class="modal-content">



      <form role="form" method="POST" action="{{ route('video-create') }}"  enctype="multipart/form-data">



        @csrf



        <!--=====================================

        CABEZA DEL MODAL

        ======================================-->



        <div class="modal-header" style="background:#3c8dbc; color:white">



          <button type="button" class="close" data-dismiss="modal">&times;</button>



          <h4 class="modal-title">Agregar Video</h4>



        </div>



        <!--=====================================

        CUERPO DEL MODAL

        ======================================-->



        <div class="modal-body">



          <div class="box-body">



            <!-- ENTRADA PARA DESCRIPCION -->



            <div class="form-group">



              <label for="obra_social">Descripcion</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-user"></i></span>



                <input type="text" id="description" class="form-control input-lg" name="description" placeholder="Ingresar Descripcion" required>



              </div>



            </div>



          <!-- ENTRADA PARA URL VIDEO -->



            <div class="form-group">



              <label for="codigo_modulo">URL del Video</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-play"></i></span>



                <input type="text" id="url_video" class="form-control input-lg" name="url_video" placeholder="Ingresar URL del Video. Ej: https://www.youtube.com/watch?v=NuPbsD48sns">



              </div>

                  <!-- ENTRADA PARA EL ARCHIVO -->



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



          <button type="submit" class="btn btn-primary">Guardar Video</button>



        </div>



      </form>



    </div>



  </div>



</div>



<!--=====================================

MODAL EDITAR VIDEO

======================================-->




<div id="modalEditarVideo" class="modal fade" role="dialog">



  <div class="modal-dialog">



    <div class="modal-content">



      <form role="form" method="POST" action="{{ route('video-create') }}"  enctype="multipart/form-data">



        @csrf



        <!--=====================================

        CABEZA DEL MODAL

        ======================================-->



        <div class="modal-header" style="background:#3c8dbc; color:white">



          <button type="button" class="close" data-dismiss="modal">&times;</button>



          <h4 class="modal-title">Agregar Video</h4>



        </div>



        <!--=====================================

        CUERPO DEL MODAL

        ======================================-->



        <div class="modal-body">



          <div class="box-body">



            <!-- ENTRADA PARA DESCRIPCION -->



            <div class="form-group">



              <label for="obra_social">Descripcion</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-user"></i></span>



                <input type="text" id="description" class="form-control input-lg" name="description" placeholder="Ingresar Descripcion" required>



              </div>



            </div>



          <!-- ENTRADA PARA URL VIDEO -->



            <div class="form-group">



              <label for="codigo_modulo">URL del Video</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-play"></i></span>



                <input type="text" id="url_video" class="form-control input-lg" name="url_video" placeholder="Ingresar URL del Video. Ej: https://www.youtube.com/watch?v=NuPbsD48sns">



              </div>

                  <!-- ENTRADA PARA EL ARCHIVO -->



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



          <button type="submit" class="btn btn-primary">Guardar Video</button>



        </div>



      </form>



    </div>



  </div>



</div>


@endsection

