@extends('layouts.app')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="col-md-8"  style="background-color: #fff; margin-left:30px;  padding:20px">
  <table border="0">
  <tbody>
    <tr>
    <th WIDTH="400" HEIGHT="80" style="text-align: center"> 
       <img src="{{asset('imagenes/config/'.$config->imagen)}}"   height="90%" width="60%">
       <h5>Razon Social: {{{$config->razon_social}}}</h5>
    </th>
    <th WIDTH="100" HEIGHT="70" style="text-align: center">
      <div class="panel panel-default">
          @if($venta->tipo_comprobante=='Factura C')
          <h1 style="font-size: 70px;">C</h1>
          <h5>cod. 11</h5>
          @elseif($venta->tipo_comprobante=='Factura A')
          <h1 style="font-size: 70px;">A</h1>
          <h5>cod. 01</h5>
          @else
          <h1 style="font-size: 70px;">B</h1>
          <h5>cod. 06</h5>
          @endif
      </div>
    </th>
    <th WIDTH="400" HEIGHT="70" style="text-align: center">
        <div id="numero">
          <h3>FACTURA </h3>
          <h4>Nº: {{$venta->num_comprobante}}</h4>
          Fecha: {{$newDate = date("d-m-Y", strtotime($venta->fecha_hora))}} <br>
        </div>  
    </th>
    </tr>    
  </tbody>

</table>
<table border="0">
  <tbody>
    <tr>
    <th WIDTH="500" HEIGHT="50"> 
      <div class="panel panel-default" style="padding:10px; margin-bottom:0px">
        Direccion: {{{$config->direccion}}}<br>
        @if($config->impuesto == 11)
           Iva: Monotributo <br>
        @else
           Iva: Responsable Inscripto <br>
        @endif
        Cuit: {{{$config->dni}}}<br>
      </div>
    </th>
    <th WIDTH="500">  
      <div class="panel panel-default" style="padding:10px; margin-bottom:0px">
        Ingresos Brutos: <br> 
        Telefono: {{{$config->telefono}}}<br>
        Email: {{{$config->correo}}}<br>   
      </div>         
    </th>
  
    <tr>
    <th WIDTH="500"  HEIGHT="50"> 
      <div class="panel panel-default" style="padding:10px; margin-top:1px">
        Cliente:  {{$venta->cliente->nombre}} <br>
        @if($venta->cliente->num_documento=='0')
          Cuit:<br>
        @else
          Cuit: {{$venta->cliente->num_documento}} <br>
        @endif
        Cond. IVA: <br>
        </div>
    </th>
    <th WIDTH="500">  
      <div class="panel panel-default" style="padding:10px; margin-top:1px">
          Domicilio: {{$venta->cliente->direccion}} <br>
          Telefono: {{$venta->cliente->telefono}} <br>
          Cond. Venta: CONTADO
      </div>              
    </th>
    </tr>
  </tbody>
 </table>

 <div class="panel panel-default" style="padding:10px">
    <div class="table-responsive">
      <table class="table" id="detalle">
           <thead >
             <tr>
             <th>Articulo</th>
             <th>Cant.</th>
             <th>P. Unit.</th>
             <th>Desc.</th>
             <th>Subtotal</th>
             </tr>
           </thead>
          <tbody>
          @foreach($venta->detalles as $det)
                <tr>
                  <td style="width: 100%; text-align: left" class="text-right">{{$det->articulo->nombre}}</td>
                  <td style="width: 100%; text-align: center" class="text-right">{{$det->cantidad}}</td>
                  <td style="width: 100%; text-align: center" class="text-right">${{$det->precio_venta}}</td>
                  <td style="width: 100%; text-align: center" class="text-right">${{$det->descuento}}</td>
                  <td style="width: 100%; text-align: center">${{$det->cantidad*$det->precio_venta-$det->descuento}}</td>
                </tr>
           @endforeach
                </tbody>
                <tfoot>
                    <tr>
                      <th colspan="4" class="text-right"><b>sTotal</b></th>
                      <th class="text-right" id="total">${{$venta->total_venta}}</th>
                    </tr>
                </tfoot>
         </table>
      </div>
  </div>
    
  <div class="row">
    <div class="col-sm-8">
      <div id="cae">
        <table border="0">
        <tbody>
           <tr>
           <th WIDTH="400"  HEIGHT="100"> 
              CAE: {{$venta->cae}} <br>
              Vto. CAE: {{$venta->vtocae}} 
          </th>
          <th WIDTH="300"> 
             @if ($venta->cae!=null)
                <img style="width: inherit" src='https://barcode.tec-it.com/barcode.ashx?data={{ $codigo }}&code=Code128&multiplebarcodes=false&translate-esc=false&unit=Fit&dpi=96&imagetype=Svg&rotation=0&color=%23000000&bgcolor=%23ffffff&qunit=Mm&quiet=0'>
              @endif 	      
          </th>
          </tr>
        </tbody>
      </table>
  </div>
    
  <div class="p-lg " id="noimpr" >
      <div id="btncae">
         @if ($venta->cae==null)
            <button  id="btn-sol-cae" class="btn btn-primary">Solicita CAE</button>
         @endif 
          <button type="button" class="btn btn-primary" onclick="javascript:window.print()"><i class="fa fa-print"></i> Imprimir</button>
      </div>
      <input type="hidden" class="form-control" id="idventa" value="{{$venta->idventa}}" >
  </div>
  </div>
</div>
</div>

@section('js')
<script>
     $(document).ready(function(){
          $("#btn-sol-cae").click(function(){
            solicitar_cae()
          });
    });

  function solicitar_cae()
      {
      $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: "POST",
            url: "{{route('solicitarcae')}}",
            dataType: "json",
            data: {
                idventa: $("#idventa").val(),    
            },
            success: function(data) {
              $("#cae").load(" #cae");
              $("#numero").load(" #numero");
              $("#btncae").load(" #btncae");
              $("#btn-cae").load(" #btn-cae");
              toastr.success("Comprobante registrado")
              console.log(data)
            },
            error:  function(data) {
              toastr.warning("Algo ha salido mal al conectarse al webserver")
              alert('No se realizo la operacion. Respuesta del servidor: '+data.responseJSON.message)
            },
           
        });
        return false;
      }
</script>
@endsection
@stop
