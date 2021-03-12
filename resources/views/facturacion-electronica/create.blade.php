@extends('layouts.appfactura')
@section('contenido')
<meta name="csrf-token" content="{{ csrf_token() }}">

<section class="content">

@if(Session::has('message'))
     <p class="alert alert-warning" id="alert">{{ Session::get('message') }}</p>
@endif

    <h3>Nueva Factura Electrónica</h3>
    <h4>Seleccione período a facturar</h4>

    <form action="{{url('facturacion')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="form-group col-md-2">
            <label>Año</label>
            <select name="year" id="year" class="form-control">
            {{-- <option selected value="0">Año</option> --}}
             <?php  
             $year = date("Y");
                echo "<option value='".$year."'>".$year."</option>";
                /*  $year = date("Y");
                 $yeari = $year-2;
                 $yearf = $year+2;
                 for($i=$yeari;$i<=$yearf;$i++) 
                    { echo "<option value='".$i."'>".$i."</option>"; }  */
             ?>
            </select>
        </div>
        <div class="form-group col-md-2">
            <label>Mes</label>
            <select name="mes" id="mes" class="form-control">
                <option value="0">Mes</option>
                <option value="01">Enero</option>
                <option value="02">Febrero</option>
                <option value="03">Marzo</option>
                <option value="04">Abril</option>
                <option value="05">Mayo</option>
                <option value="06">Junio</option>
                <option value="07">Julio</option>
                <option value="08">Agosto</option>
                <option value="09">Septiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12">Diciembre</option>
            </select>
        </div>
        <div class="form-group col-md-3" style="margin-top: 25px">
            <button class="btn btn-primary" id="consultar" type="button"> Consultar</button>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table table-striped table-bordered table-condensed table-hover">
                <thead style="background-color: #A9D0F5">
                    <th>Cant.</th>
                    <th>Prestación</th>
                    <th>Valor Modulo</th>
                    <th>Sub Total</th>
                </thead>
                <tbody id="bodytablafac">
                </tbody>
                <tfoot>
                    <th></th>
                    <th></th>
                    <th style="font-size: 18px; text-align:right">TOTAL:</th>
                    <th style="font-size: 18px; text-align:left">
                        <span id="total" >$ 0.00</span>
                        <input type="hidden" name="total_factura" id="total_factura">
                    </th>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <button  class="btn btn-primary" id="guardar" type="submit"> Facturar</button>
        </div>
    </div>
    </form>



</section>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        $("#guardar").hide();
       
        $('#consultar').click(function () {

            $("#alert").hide();

            $("#bodytablafac").html("");

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('consultafactura') }}",
                dataType: "json",
                data: {
                    mes: $("#mes").val(),
                    year: $("#year").val(),

                },
                success: function (data) {
                    
                    var total = 0;
                
                    if(data.length==0){
                        $("#bodytablafac").html("<h3>No hay items a facturar en este periodo</h3>");
                        $('#total').html('$0.00');
                    }else {
                    
                    for (i = 0; i < data.length; i++) { //cuenta la cantidad de registros
        
                        var nuevafila = '<tr><td><input type="hidden" name="cantidad[]" value="'+data[i].cantidad+'">' +data[i].cantidad+ '</td><td><input type="hidden" name="nombre_pres[]" value="'+data[i].nombre_pres+'">' +data[i].nombre_pres + '</td><td><input type="hidden" name="valor_modulo[]" value="'+data[i].valor_modulo+'">' + data[i].valor_modulo + '</td><td><input type="hidden" name="subtotal[]" value="'+((parseFloat(data[i].cantidad ).toFixed(2)) * (parseFloat(data[i].valor_modulo).toFixed(2)))+'">' +((parseFloat(data[i].cantidad ).toFixed(2)) * (parseFloat(data[i].valor_modulo).toFixed(2) ))+'</td></tr>'
                        $("#bodytablafac").append(nuevafila)
                         
                         total = total + (parseFloat(data[i].cantidad ).toFixed(2)) * (parseFloat(data[i].valor_modulo).toFixed(2) );
                         $('#total_factura').val(total);
                    }

                    $('#total').html('$'+total);
                       }
                       
                       if (data.length > 0) {
                        $("#guardar").show();
                       } else {
                        $("#guardar").hide();
                         }
                },
                error: function () {
                    alert('error');

                }
            });
            return false;


        });
    });

</script>

@endsection
