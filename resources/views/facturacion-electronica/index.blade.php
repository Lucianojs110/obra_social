@extends('layouts.appfactura')
@section('contenido')


<section class="content">

    <h3>Listado Facturas Electrónicas</h3>
    


    <div class="row">

  
    
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <button class="btn btn-primary" onclick="location.href='{{ URL::action('FacturacionController@create') }}'"
        type="button"> Nuev Factura</button>
        
            <div class="table-responsive">
                <table id="factura" class="display table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Num. Factura</th>
                            <th>Fecha</th>
                            <th>Obra Social</th>
                            <th>Periodo Facturado</th>
                            <th>Total</th>
                            <th>acciones</th>

                        </tr>
                    </thead>
                    <tbody>

                        @foreach($factura as $facturas)
                            <tr>
                                <td>{{ $facturas->id_factura }}</td>
                                @if($facturas->nroCbte==null)
                                  <td>No Registrado en afip</td> 
                                @else
                                <td>{{ $facturas->nroCbte }}</td>
                                @endif
                                <td>{{ $facturas->cbteFch }}</td>
                                <td>{{ $facturas->nombre }}</td>
                                <td>Desde:  {{ $newDate = date("d/m/Y", strtotime($facturas->fdesde )) }} Hasta: {{ $newDate = date("d/m/Y", strtotime($facturas->fhasta )) }}</td>
                                <td>${{ $facturas->impTotal }}</td>

                                <td align="center">
                                    <a class="btn btn-info glyphicon glyphicon-eye-open"
                                        href=" {{ URL::action('FacturacionController@show', $facturas->id_factura) }} "
                                        title="Ver más"></a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



</section>

</div>

@endsection

@push('scripts')
    <script>
        $('#factura').DataTable({
            dom: 'Bfrtip',
            buttons: [
                
            ],
        });

    </script>
@endpush
