@extends('layouts.app', ['prestador' => $prestador_menu])



@section('content')

<div class="content-wrapper">



  <section class="content-header">



    <h1>



      Módulo de Mensajes {{$titulo}}.



    </h1>



     <div style="padding-top: 15px">

        @include('includes.message')

     </div>



    <ol class="breadcrumb">



      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>



      <li class="active">Mensajes {{$titulo}}</li>



    </ol>



  </section>



  <section class="content">



    <div class="box">



     



        <div class="box-header with-border">

        

          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarMensaje">



            Enviar Mensaje



          </button>



        </div>



    



      <div class="box-body">



       <table class="table table-bordered table-striped dt-responsive tablas">



        <thead>



         <tr>

			<th style="width:10px">#</th>
      <th>Fecha</th>
       @if($titulo =="Recibidos")
      <th>De</th>
      @else
      <th>Para Usuario</th>
      @endif 
    
     

			<th>Título</th>
      <th>Mensaje</th>
      <th>Archivo</th>
			<th>Acciones</th>

         </tr>



        </thead>



        <tbody>

			@foreach ($mensajes as $key => $Mensaje)

			@if($titulo =="Recibidos" and $Mensaje->id_envia == $Mensaje->id_recibe and Auth::user()->id==1 )

      @else
				<tr>

					<td>{{ ($key+1) }}</td>
          <td>{{ date("d-m-Y H:i:s", strtotime($Mensaje->fecha)) }}</td>     
          @if($titulo =="Recibidos")
          <td>{{ substr($Mensaje->userenvia->role, 0, 1).$Mensaje->userenvia->id." ".$Mensaje->userenvia->name ." ".$Mensaje->userenvia->surname}}</td>
          @else
            <td>@if($Mensaje->id_envia == $Mensaje->id_recibe)
            Todos
            @else
            {{ substr($Mensaje->userrecibe->role, 0, 1).$Mensaje->userrecibe->id." ".$Mensaje->userrecibe->name ." ".$Mensaje->userrecibe->surname}}
            @endif
          </td>

          @endif 
          <td>{{ $Mensaje->titulo }}</td>
          <td>{{ $Mensaje->mensaje }}</td>
          <td>@if ($Mensaje->archivo)
              <a href="{{ '/public/uploads/mensaje/'.$Mensaje->archivo}}" target="_BLANK"><button class="btn btn-primary"><i class="fa fa-file"></i></button></a>
              @endif</td>



						<td>
              @if($titulo =="Recibidos" and Auth::user()->id!=1 and $Mensaje->id_envia == $Mensaje->id_recibe )

              @else
						<div class="btn-group">

							
							<button class="btn btn-danger btnEliminarMensaje" data-id="{{$Mensaje->id}}" {{$titulo =="Recibidos"?"redir=1":"redir=0"}}><i class="fa fa-times"></i></button>

						</div>
            @endif

						</td>

	

				</tr>
        @endif
			@endforeach

        </tbody>



       </table>



      </div>



    </div>



  </section>



</div>



<!--=====================================

MODAL AGREGAR Mensaje

======================================-->



<div id="modalAgregarMensaje" class="modal fade" role="dialog">



  <div class="modal-dialog">



    <div class="modal-content">



      <form role="form" method="POST" action="{{ route('mensajes-store') }}" enctype="multipart/form-data">

<input type="hidden" name="id_envia" value="{{Auth::user()->id}}">

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

            @if(Auth::user()->role == "Administrador")

            <div class="form-group">



              <label for="obra_social">¿Enviar a todos los usuarios?</label>



              <div class="input-group">
             <select type="text" class="form-control input-lg" placeholder="Seleccionar Usuario" name="enviaratodos" id="enviaratodos">
                  <option value="0">No</option>     
                  <option value="1">Si</option>          
                </select>

              </div>



            </div>
            @else
            <input type="hidden"name="enviaratodos" value="0">
            @endif
             <!-- ENTRADA PARA LOS USUARIOS -->



            <div class="form-group" id="listausuarios">



              <label for="obra_social">Usuarios</label>



              <div class="input-group">



                <span class="input-group-addon"><i class="fa fa-user-o"></i></span>

                <select type="text" class="form-control input-lg" name="id_recibe[]" placeholder="Seleccionar Usuario" multiple="multiple">
                  @foreach($users as $key=>$us)

                  <option value="{{ $us->id }}" {{($us->id ==1)?"selected":""}}>{{ $us->name." ".$us->surname }}</option>

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



<!--=====================================

MODAL EDITAR Mensaje

======================================-->



<div id="modalEditarMensaje" class="modal fade" role="dialog">



  <div class="modal-dialog">



    <div class="modal-content">



      <form role="form" method="POST" action="{{ route('mensajes-update') }}">



        <input type="hidden" name="id" id="Mensaje_id">



        @csrf



        <!--=====================================

        CABEZA DEL MODAL

        ======================================-->



        <div class="modal-header" style="background:#3c8dbc; color:white">



          <button type="button" class="close" data-dismiss="modal">&times;</button>



          <h4 class="modal-title">Editar Mensaje</h4>



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



                <input type="text" class="form-control input-lg MensajeInput" name="Mensaje" placeholder="Ingresar Descripcion" required>



              </div>



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

