@extends('layouts.app', ['prestador' => $prestador_menu])
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1> 
      Facturacion - Alta de Certificados
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
        {{-- <button class="btn btn-primary" href="{{ URL::action('FacturacionController@createCert') }}">
          Nuevo
        </button> --}}
        <button class="btn btn-primary" onclick="location.href='{{ URL::action('FacturacionController@createCert') }}'" type="button">
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

          @foreach($certs as $c)
          
          <tr>
            <td>{{ $c->id_certificado }}</td>
            <td>{{ $c->certkey }}</td>
            <td>{{ $c->certcrt }}</td>
            <td>{{ $c->ptovta }}</td>
            <td>{{ $c->users->name }}</td>
           
           
            <td> 
              <div class="btn-group">
                  
                <button class="btn btn-warning btnEditarOs" data-toggle="modal" data-target="#modalEditarOS" idOs="{{-- {{ $obra->id }} --}}"><i class="fa fa-pencil"></i></button>

                <button class="btn btn-danger btnEliminarOs" idOs="{{-- {{ $obra->id }} --}}"><i class="fa fa-trash"></i></button>

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

@endsection

@push('scripts')

	<script>
  		$('#example').DataTable({
        	dom: 'Bfrtip',
        	buttons: [
				'excel'
        	],
     	});
  	</script>

@endpush