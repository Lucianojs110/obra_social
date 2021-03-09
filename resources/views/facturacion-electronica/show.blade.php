@extends('layouts.appfactura')
@section('contenidofac')

<h3 id="noimpr">Factura Electronica</h3>

<meta name="csrf-token" content="{{ csrf_token() }}">
<table style="border: 1px solid black" >
    <tbody>
        <tr>
            <th WIDTH="600" style="border: 1px solid; padding: 10px; font-family: sans-serif">
                @foreach($user as $users)
                    Razon Social: {{ $users->name }} {{ $users->surname }}<br>
                    Direccion: {{ $users->direccion }}<br>
                    IVA: {{ $users->condicion_iva }}<br>
                    CUIT: {{ $users->cuit }}<br>
                @endforeach
            </th>
            @foreach($facturas as $factura)
                <th WIDTH="100" style="border: 1px solid; padding: 10px; text-align: center;font-family: sans-serif">
                    @if($factura->tipoCbteNumero==11)
                        <h1 style="font-size: 50px; font-family: sans-serif">C</h1>
                        <h5>cod. 11</h5>
                    @elseif($factura->tipoCbteNumero==1)
                        <h1 style="font-size: 50px; font-family: sans-serif">A</h1>
                        <h5>cod. 01</h5>
                    @else
                        <span style="font-size: 50px; font-family: sans-serif">B</span><br>
                        <span>cod. 06</span>
                    @endif

                </th>
                <th WIDTH="400" style="border: 1px solid; padding: 10px; font-family: sans-serif">
                    <span style="font-size: 20px; "><b>FACTURA</b></span><br>
                    <span id="NumCbte"> Nº: {{ $factura->nroCbte }} </span> <br>
                    <span id="FCbte">    Fecha: {{ $newDate = date("d/m/Y", strtotime($factura->cbteFch)) }}<br>
                </th>
        </tr>
    </tbody>
</table>
<input type="hidden" class="form-control" id="idfactura" value="{{$factura->id_factura }}">
<table style="font-family: sans-serif">
    <tbody>

        <tr style="border: 1px solid">
            <th WIDTH="700" style="padding-left:10px;">
                Período de Facturación Desde:
                {{ $newDate = date("d/m/Y", strtotime($factura->fdesde )) }}
                Hasta:
                {{ $newDate = date("d/m/Y", strtotime($factura->fhasta )) }}
            <th WIDTH="300" style="padding-left:10px;">
                Vencimiento pago:
                {{ $newDate = date("d/m/Y", strtotime($factura->fvtopag)) }}
            </th>

        </tr>
        @endforeach
    </tbody>
</table>

@foreach($obrasocial as $os)
    <table style="font-family: sans-serif">
        <tbody>
            <tr style="border: 1px solid">
                <th WIDTH="400" HEIGHT="70" style="padding:10px;">
                    Nombre/Razon Social: {{ $os->nombre }} <br>
                    CUIT: {{ $os->cuit }} <br>
                    Cond. IVA: {{ $os->condicion_iva }} <br>
                </th>
                <th WIDTH="400" HEIGHT="70">
                    Domicilio: {{ $os->direccion }} {{ $os->ciudad }}<br>
                    Telefono: {{ $os->telefono }} <br>
                    Cond. Venta: CONTADO
                </th>
            </tr>
        </tbody>
    </table>
@endforeach


<table class="table" style="font-family: sans-serif; border: 1px solid; padding: 10px" id="detalle">
    <thead>
        <tr>
            <th style="border: 1px solid; background-color:#CCD1D1">Cant.</th>
            <th style="border: 1px solid; background-color:#CCD1D1">Servicio</th>
            <th style="border: 1px solid; background-color:#CCD1D1">Precio Unit.</th>
            <th style="border: 1px solid; background-color:#CCD1D1">Sub Total</th>
        </tr>
    </thead>
    <tbody>
        @php
            $sum=0;
        @endphp
        @foreach($detalle as $det)
            <tr>
                <td style="width: 10%; text-align: left" class="text-right"> {{ $det->cantidad }}</td>
                <td style="width: 60%; text-align: left" class="text-right"> {{ $det->nombre_prestacion }}</td>
                <td style="width: 15%; text-align: left" class="text-right">${{ $det->valor_modulo }}</td>
                <td style="width: 15%; text-align: left" class="text-right">$ {{ $det->subtotal }}</td>
            </tr>
            @php
                $sum += $det->valor_modulo * $det->cantidad;
            @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th></th>
            <th></th>
            <th class="text-right"><b>Total</b></th>
            <th class="text-left"><b>$ {{ $sum }}</b></th>
        </tr>
    </tfoot>
</table>



<div class="row">
    <div class="col-sm-12">
        <div id="cae">
            <table>
                <tbody>
                @if ($facturas[0]->caeNum!=null) 
                    <tr>
                    <th WIDTH="250" HEIGHT="100">
                            @if ($facturas[0]->caeNum!=null) 
                            <img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl={{$facturas[0]->codigoQr}}">
                            @endif 
                        </th>
                        <th WIDTH="700" HEIGHT="100">
                        <img src="{{asset('img/logo_afip.png')}}"   height="40%" width="40%"><br>
                        <span style="font-size: 15px">Comprobante Autorizado</span><br>
                        <span style="font-size: 10px">Esta administración federal no se responsabiliza por los datos ingresados en el detalle de la operación</span>
                        </th>
                        <th WIDTH="300" HEIGHT="100">
                            CAE:  {{$facturas[0]->caeNum}} <br>
                            Fecha Vto. CAE:{{ $newDate = date("d/m/Y", strtotime($facturas[0]->caeFvto ))}} 
                        </th>
                 @endif   
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="p-lg " id="noimpr">
            <div id="btncae">
                @if ($facturas[0]->caeNum==null) 
                <button id="btn-sol-cae" class="btn btn-primary">Registrar en AFIP</button>
                 @endif
                 @if ($facturas[0]->caeNum!=null) 
                 <button type="button" class="btn btn-primary" onclick="javascript:window.print()"><i
                        class="fa fa-print"></i> Imprimir</button>
                 @endif
               
               
            </div>
        </div>
    </div>
</div>
</div>


@endsection

@push('scripts')
    <script>
        $('#example').DataTable({
            language: {
                "decimal": ",",
                "thousands": "."
            },
            dom: 'Bfrtip',
            buttons: [
                'excel'
            ],
            "pageLength": 12
        });

        $('#enviar').submit(function (event) {
            $('input[type=checkbox]', $('#example').DataTable().rows().nodes()).prop('hidden', true).appendTo(
                this);
        });





        $(document).ready(function () {
            $("#btn-sol-cae").click(function () {
                /* calculatorTotal() */
                solicitar_cae()
            });
            
        });

        function solicitar_cae() {
            console.log($("#cuit_obrasocial").val());
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('caesolicitud') }}",
                dataType: "json",
                data: {
                    comprobante: $("#comprobante").val(),
                    idfactura: $("#idfactura").val(),
                },
                success: function (data) {
                    alert('comprobante registrado')
                   
                    $("#cae").load(" #cae");
                    $("#encabezado").load(" #encabezado");
                    $("#NumCbte").load(" #NumCbte");
                    $("#FCbte").load(" #FCbte");
                    $("#btncae").load(" #btncae");
                    $("#btn-cae").load(" #btn-cae");
                    console.log(data)
                },
                error: function (data) {

                    alert('comprobante NO registrado')
                    console.log(data)
                    alert('No se realizo la operacion. Respuesta del servidor: ' + data.responseJSON
                        .message)
                },

            });
            return false;
        }

    </script>
@endpush
