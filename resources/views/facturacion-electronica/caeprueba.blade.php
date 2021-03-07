@extends('layouts.appfactura')
@section ('contenido')
<div class="row justify-content-center align-items-center">
	<div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
		<h3>Listado Facturas Electronicas</h3>
       
            <h1>
               {{-- Ingrese el Cuil o Cuit de la obra social --}}
                <h4>
                    Prestador: {{ Auth::user()->name . ' ' . Auth::user()->surname }}
                </h4>
            </h1>
    
            {{-- <div style="padding-top: 15px">
                @include('includes.message')
            </div>
    
            <ol class="breadcrumb">
                <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
                <li class="active">Factura Previa</li>
            </ol> --}}
    
    
		<div class="progress" style="height: 2px;"></div>
	</div>
</div>
</br>


                 
              </th>
              @php
                  $tipo_comprobante = 'Factura B';
                  $comprobante = 6;
              @endphp
              <th WIDTH="100" HEIGHT="70" style="text-align: center">
                <div class="panel panel-default">
                    @if(/* $venta->tipo_comprobante */$tipo_comprobante=='Factura C')
                    <h1 style="font-size: 70px;">C</h1>
                    <h5>cod. 11</h5>
                    @elseif(/* $venta->tipo_comprobante */ $tipo_comprobante=='Factura A')
                    <h1 style="font-size: 70px;">A</h1>
                    <h5>cod. 01</h5>
                    @else
                    <h1 style="font-size: 70px;">B</h1>
                    <h5>cod. 06</h5>
                    <input type="hidden" class="form-control" name="tipo_comprobante" value="{{$tipo_comprobante}}" >
                    <input type="hidden" class="form-control" name="comprobante" value="{{$comprobante}}" >
                    @endif
                </div>
              </th>
              <th WIDTH="400" HEIGHT="70" style="text-align: center">
                  <div id="numero">
                    <h3>FACTURA </h3>
                    <h4>Nº: {{-- {{$venta->num_comprobante}} --}}</h4>
                    @foreach ($certs as $c) 
                      Pto de Venta: {{$c->ptovta}}
                    @endforeach
                    <br>
                    Fecha Emision: {{-- {{$newDate = date("d-m-Y", strtotime($venta->fecha_hora))}} --}} <br>

                  </div>  
              </th>
              </tr>    
            </tbody>
          
          </table>
          <table border="0">
            <tbody>
              <tr>
                  @php
                   $impuesto = 11   
                  @endphp
              <th WIDTH="500" HEIGHT="50"> 
                <div class="panel panel-default" style="padding:10px; margin-bottom:0px">
                  Direccion: {{-- {{{$config->direccion}}} --}}<br>
                  @if(/* $config->impuesto */ $impuesto == 11)
                     Iva: {{$user->condicion_iva}} <br>
                  @else
                     Iva: <br>
                  @endif
                  Cuit: {{$user->cuit}}<br>
                </div>
              </th>
              <th WIDTH="500">  
                <div class="panel panel-default" style="padding:10px; margin-bottom:0px">
                  Ingresos Brutos: <br> 
                  Telefono: {{$user->telefono}}<br>
                  Email: {{$user->email}}<br>   
                </div>         
              </th>
            
              <tr>
                @php
                $num_documento = 0;   
               @endphp
              <th WIDTH="500"  HEIGHT="50"> 
                <div class="panel panel-default" style="padding:10px; margin-top:1px">
                  @foreach ($data['obrasocial'] as $ob)
                    Cliente:  {{$ob->nombre}}<br>
                  @if(/* $venta->cliente->num_documento */$num_documento=='0')
                    Cuit: {{$ob->cuit}}<br>
                    <input type="hidden" class="form-control" id="cuit_obrasocial" value="{{$ob->cuit}}" >
                  @else
                    Cuit: {{-- {{$venta->cliente->num_documento}} --}} <br>
                  @endif
                  Cond. IVA: {{$ob->condicion_iva }}<br>
                  </div>
              </th>
              <th WIDTH="500">  
                <div class="panel panel-default" style="padding:10px; margin-top:1px">
                    Domicilio: {{$ob->direccion}} - {{$ob->ciudad}}<br>
                    Telefono: {{$ob->telefono}}{{-- {{$venta->cliente->telefono}} --}} <br>
                    Cond. Venta: CONTADO
                </div>              
              </th>
              @endforeach
              </tr>
            </tbody>
           </table>
          
           <div class="panel panel-default" style="padding:10px">
              <div class="table-responsive">
                <table class="table" id="detalle">
                     <thead >
                       <tr>
                       <th>Codigo</th>
                       <th>Descripcion</th>
                       <th>Cant.</th>
                       <th>V.Modulo</th>
                       <th>Desc.</th>
                       <th>Subtotal</th>
                       </tr>
                     </thead>
                    <tbody>
                      @php
                          $sum=0;
                      @endphp
                    @foreach($qss as $det)
                          <tr>
                            <td style="width: 20%; text-align: left" class="text-right"> {{$det->codigo_modulo}}</td>
                            <td style="width: 100%; text-align: left" class="text-right"> {{$det->nombre_pres}}</td>
                            <td style="width: 100%; text-align: center" class="text-right">{{$det->cantidad}}</td>
                            <td style="width: 100%; text-align: center" class="text-right">$ {{$det->valor_modulo}}</td>
                            <td style="width: 100%; text-align: center" class="text-right">${{-- {{$det->descuento}} --}}</td>
                            <td style="width: 100%; text-align: center">{{$det->valor_modulo * $det->cantidad /* - $det->descuento */}}</td>
                          </tr>
                          @php
                              $sum += $det->valor_modulo * $det->cantidad;
                          @endphp
                     @endforeach
                          </tbody>
                          <tfoot>
                              <tr>
                                <th colspan="4" class="text-right"><b>Total</b></th>
                                <th colspan="4" class="text-right"><b>$ {{$sum}}</b></th>
                                
                               {{--  <th class="text-right" name="total" id="total"><div id="total">$ {{$sum}}</div></th> --}}
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
                        CAE: {{-- {{$venta->cae}} --}} <br>
                        Vto. CAE: {{-- {{$venta->vtocae}} --}} 
                    </th>
                    <th WIDTH="300"> 
                      {{--  @if ($venta->cae!=null) --}}
                          {{-- <img style="width: inherit" src='https://barcode.tec-it.com/barcode.ashx?data={{ $codigo }}&code=Code128&multiplebarcodes=false&translate-esc=false&unit=Fit&dpi=96&imagetype=Svg&rotation=0&color=%23000000&bgcolor=%23ffffff&qunit=Mm&quiet=0'> --}}
                       {{--  @endif 	 --}}      
                    </th>
                    </tr>
                  </tbody>
                </table>
            </div>
              
            <div class="p-lg " id="noimpr" >
                <div id="btncae">
                  {{--  @if ($venta->cae==null) --}}
                      <button  id="btn-sol-cae" class="btn btn-primary">Solicitar CAE</button>
                   {{-- @endif  --}}
                    <button type="button" class="btn btn-primary" onclick="javascript:window.print()"><i class="fa fa-print"></i> Imprimir</button>
                    {{-- <button  id="total"  onclick="calculatorTotal()" class="btn btn-primary">Total</button> --}}
                </div>
                <input type="hidden" class="form-control" id="idventa" value="3{{-- {{$venta->idventa}} --}}" >
            </div>
            </div>
          </div>
          </div>
	</div>
</div>
<!-- medium modal -->
    <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="mediumBody">
                    <div>
                        <!-- the result to be displayed apply here -->
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

$('#enviar').submit(function(event){
	$('input[type=checkbox]', $('#example').DataTable().rows().nodes()).prop('hidden', true).appendTo(this);
});



// display a modal (medium modal)
$(document).on('click', '#mediumButton', function(event) {
            event.preventDefault();
            let href = $(this).attr('data-attr');
            $.ajax({
                url: href,
                beforeSend: function() {
                    $('#loader').show();
                },
                // return the result
                success: function(result) {
                    $('#mediumModal').modal("show");
                    $('#mediumBody').html(result).show();
                },
                complete: function() {
                    $('#loader').hide();
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                    $('#loader').hide();
                },
                timeout: 8000
            })
        });




function calculatorTotal(){
    
    
    //Asumiendo que es la columna 5 de cada fila la que quieres agregar a la sumatoria
    /* console.log('columna cant sol',parseFloat(el[6])) */
   /*  console.log('columna cant Subtotal: ',parseFloat(el[8])) */
    /* console.log('columna cant tot',parseFloat(tot)) */
    /* console.log('total',parseFloat(tot)) */
    var tot = 0;
    $('#example').DataTable().rows().data().each(function(el, index){
    tot += /* (parseFloat(el[6]))*  */(parseFloat(el[8]));
    });
   /*  console.log(tot); */
    
    document.getElementById('total').innerHTML = parseFloat(tot).toFixed(2);
    /* console.log(tot); */

}


$(document).ready(function(){
          $("#btn-sol-cae").click(function(){
            /* calculatorTotal() */
            solicitar_cae()
          });
    });

function solicitar_cae()
      {
          console.log($("#cuit_obrasocial").val());
      $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: "POST",
            url: "{{route('caesolicitud')}}",
            dataType: "json",
            data: {
          
              comprobante: $("#comprobante").val(),   
            },
            success: function(data) {
              alert('comprobante registrado')
              $("#cae").load(" #cae");
              $("#numero").load(" #numero");
              $("#btncae").load(" #btncae");
              $("#btn-cae").load(" #btn-cae");
              console.log(data)
            },
            error:  function(data) {
             
              alert('comprobante NO registrado')
              console.log(data)
              alert('No se realizo la operacion. Respuesta del servidor: '+data.responseJSON.message)
            },
           
        });
        return false;
      }
</script>
@endpush
