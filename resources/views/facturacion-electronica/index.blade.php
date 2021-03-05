@extends('layouts.appfactura')
@section('contenido')


  <section class="content">

  <h3>Listado Facturas Electronicas</h3>
      <div class="box-header with-border">
      
      
        <button class="btn btn-primary" onclick="location.href='{{ URL::action('FacturacionController@create') }}'" type="button">
            Nuevo</button>
      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Nombre Certificado key</th>
           <th>Nombre Certificado Crt</th>
           <th>N° Pto de Venta</th>
           <th>Usuario</th>
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>

    
          
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
           
           
            <td> 
              <div class="btn-group">
                  
                <button class="btn btn-warning btnEditarOs" data-toggle="modal" data-target="#modalEditarOS" idOs="{{-- {{ $obra->id }} --}}"><i class="fa fa-pencil"></i></button>

                <button class="btn btn-danger btnEliminarOs" idOs=""><i class="fa fa-trash"></i></button>

              </div>  

            </td>

          </tr>

       
        </tbody>

       </table>

      </div>

  

  </section>

</div>

@endsection

