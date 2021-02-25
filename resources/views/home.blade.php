@extends('layouts.app', ['prestador' => $prestador])



@section('content')


<?php 
$provincia = DB::table('provincias')->select('id', 'provincia')->get();

?>

<div class="content-wrapper">



  <section class="content-header">



    <h1>

      Tablero



      <small>Panel de Control</small>

    </h1>



     <div style="padding-top: 15px">

        @include('includes.message')

     </div>



     @if(Auth::user()->direccion === null)

        <div class="alert alert-danger text-center">

            Hay datos pendientes de carga. Por favor complete los mismos para utilizar el sistema.

        </div>

     @endif



    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Dashboard</li>

    </ol>

  </section>



  <!-- Main content -->

  <section class="content">



    <div class="box">

      <div class="box-header with-border">

        <button class="btn btn-primary" data-toggle="modal" data-target="#modalData">         

            Editar datos

        </button>

      </div>

      <div class="box-body">

         <table class="table table-bordered table-striped dt-responsive tablas">

         

        <thead>

         

         <tr>

           

           <th style="width:10px">#</th>

           <th>Usuario</th>

           <th>Direccion</th>

           <th>Telefono</th>

           <th>Condicion IVA</th>

           <th>Condicion IIBB</th>

           <th>CUIT</th>

           <th>IIBB</th>

           <th>CBU</th>



         </tr> 



        </thead>



        <tbody>

          

          <tr>

            <td>1</td>

            <td>{{ Auth::user()->email }}</td>

            <td>{{ Auth::user()->direccion }}</td>

            <td>{{ Auth::user()->telefono }}</td>

            <td>{{ Auth::user()->condicion_iva }}</td>

            <td>{{ Auth::user()->condicion_iibb }}</td>

            <td>{{ Auth::user()->cuit }}</td>

            <td>{{ Auth::user()->iibb }}</td>

            <td>{{ Auth::user()->cbu }}</td>



          </tr>



        </tbody>



       </table>

      </div>

    </div>







      



  <div id="modalData" class="modal fade" role="dialog">

  

  <div class="modal-dialog modal-lg">



    <div class="modal-content">



      <form role="form" method="POST" action="{{ route('update-usuario') }}">

        @csrf



        <!--=====================================

        CABEZA DEL MODAL

        ======================================-->



        <div class="modal-header" style="background:#3c8dbc; color:white">



          <button type="button" class="close" data-dismiss="modal">&times;</button>



          <h4 class="modal-title">Datos de usuario - {{ Auth::user()->name . ' ' . Auth::user()->surname}}</h4>



        </div>



        <!--=====================================

        CUERPO DEL MODAL

        ======================================-->



        <div class="modal-body">



          <div class="box-body">



            <!-- ENTRADA PARA DIRECCION -->

            

            <div class="form-group col-lg-12">

                

                <div class="input-group col-lg-12">



                  <div class="col-lg-6">



                        <label for="direccion">Dirección</label>



                        <input type="text" value="{{ Auth::user()->direccion }}" class="form-control input-lg" name="direccion" placeholder="Ingresar direccion">



                  </div>



                  <div class="col-lg-6">



                       <label for="provincia">Provincia</label>



                        <select type="text" class="form-control input-lg" name="provincia" id="provincia" placeholder="Ingresar Provincia">

                          <option value="">Seleccionar...</option>
                        @foreach($provincia as $key=>$pr)

              <option value="{{ $pr->id }}"  {{($pr->id==Auth::user()->id_provincia)?'selected="selected"':""}}>{{ $pr->provincia }}</option>

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



                        <input type="email" value="{{ Auth::user()->email }}" class="form-control input-lg" name="correo" readonly placeholder="Ingresar correo">



                  </div>

                

                  <div class="col-lg-6">



                        <label for="telefono">Telefono</label>



                        <input type="text" value="{{ Auth::user()->telefono }}" class="form-control input-lg" name="telefono" placeholder="Ingresar Telefono">



                  </div>



                </div>



              </div>



              <!--Entrada para condicion iva & iibb -->



              <div class="form-group col-lg-12">

                

                <div class="input-group col-lg-12">



                  <div class="col-lg-6">



                        <label for="condicionIva">Condicion IVA</label>



                        <select type="text" class="form-control" name="condicionIva">

                          <option value="{{ Auth::user()->condicion_iva }}">{{ Auth::user()->condicion_iva }}</option>

                          <option value="Responsable Inscripto">Responsable Inscripto</option>

                          <option value="Responsable NO Inscripto">Responsable NO Inscripto</option>

                          <option value="Exento">Exento</option>

                          <option value="Monotributo">Monotributo</option>

                        </select>



                  </div>

                

                  <div class="col-lg-6">



                        <label for="condicionIibb">Condicion IIBB</label>



                        <select type="text" class="form-control" name="condicionIibb">

                          <option value="{{ Auth::user()->condicion_iibb }}">{{ Auth::user()->condicion_iibb }}</option>

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



                        <input type="text" value="{{ Auth::user()->cuit }}" class="form-control input-lg" name="cuit" placeholder="Ingresar CUIT">



                  </div>

                

                  <div class="col-lg-6">



                        <label for="iibb">IIBB</label>



                        <input type="text" value="{{ Auth::user()->iibb }}" class="form-control input-lg" name="iibb" placeholder="Ingresar IIBB">



                  </div>



                </div>



              </div>



              <!--Entrada para CBU y Entidad Bancaria -->



              <div class="form-group col-lg-12">

                

                <div class="input-group col-lg-12">



                  <div class="col-lg-6">



                        <label for="entidadBancaria">Entidad Bancaria</label>



                        <input type="text" value="{{ Auth::user()->entidad_bancaria }}" class="form-control input-lg" name="entidadBancaria" placeholder="Ingresar Entidad">



                  </div>

                

                  <div class="col-lg-6">



                        <label for="cbu">CBU</label>



                        <input type="number" value="{{ Auth::user()->cbu }}" class="form-control input-lg" name="cbu" placeholder="Ingresar CBU">



                  </div>



                </div>



              </div>



              <!--Entrada para Cheque y Lugar de Pago -->



              <div class="form-group col-lg-12">

                

                <div class="input-group col-lg-12">



                  <div class="col-lg-6">



                        <label for="ordenCheque">Orden Cheque</label>



                        <input type="text" value="{{ Auth::user()->orden_cheque }}" class="form-control input-lg" name="ordenCheque" placeholder="Ingresar Orden">



                  </div>

                

                  <div class="col-lg-6">



                        <label for="lugarPago">Lugar de Pago</label>



                        <input type="text" value="{{ Auth::user()->lugar_pago }}" class="form-control input-lg" name="lugarPago" placeholder="Ingresar Lugar de Pago">



                  </div>



                </div>



              </div>



              <!--Entrada para Emp. Seguros y Poliza -->



              <div class="form-group col-lg-12">

                

                <div class="input-group col-lg-12">



                  <div class="col-lg-6">



                        <label for="empSeguros">Emp. Seguros</label>



                        <input type="text" value="{{ Auth::user()->emp_seguros }}" class="form-control input-lg" name="empSeguros" placeholder="Ingresar Emp. Seguros">



                  </div>

                

                  <div class="col-lg-6">



                        <label for="polSeguros">Numero de Poliza</label>



                        <input type="number" value="{{ Auth::user()->poliza }}" class="form-control input-lg" name="polSeguros" placeholder="Ingresar Poliza">



                  </div>



                </div>



              </div>

            

          </div>



        </div>



        <input type="hidden" name="id" value="{{ Auth::user()->id }}">



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



  </section>

  <!-- /.content -->

</div>

<!-- /.content-wrapper -->

@endsection

