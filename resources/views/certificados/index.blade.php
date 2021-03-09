@extends('layouts.appfactura')
@section('contenido')

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <legend>Listado De Certificados</legend>
            <legend>Recorda Activar solo el certificado que vas Usar</legend>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2" align="left">
            <a href="{{ URL::action('CertificadosController@create') }}" class="btn btn-sm btn-success  btn-lg btn-block" title="Nuevo Certificado"><h4>Nuevo</h4></a>
        </div>
    </div>
  </br>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            @include('compartido.mensajes')
            @include('compartido.errores')
            <div class="table-responsive">
                <table id="example" class="display table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
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
                                    <td align="center">
                                        <form method="POST" action="{{ URL::action('CertificadosController@destroy', $c->id_certificado) }}">
                                            @method('DELETE')
                                            @csrf
                                            @if(empty($c->deleted_at))
                                            <a class="btn btn-info glyphicon glyphicon-eye-open" href="{{-- {{URL::action('CertificadosController@show', $c->id_certificado)}} --}}" title="Ver más"></a>
                                            <a class="btn btn-warning glyphicon glyphicon-pencil" href="{{-- {{URL::action('CertificadosController@edit', $c->id_certificado)}} --}}" title="Editar"></a>
                                            <button class="btn btn-danger glyphicon glyphicon-trash" onclick="return confirm('¿Está seguro de eliminar el Certificado?');" title="Eliminar"></button>
                                            @else
                                            <button type="submit" class="btn btn-sm btn-success glyphicon glyphicon-refresh" onclick="return confirm('¿Está seguro de activar Este Certificado?');" title="Activar"></button>
                                            @endif
                                        </form>
                                    </td>
            
                                </tr>
                            @endforeach
                        </tbody>
                </table>
            </div>
        </div>
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

