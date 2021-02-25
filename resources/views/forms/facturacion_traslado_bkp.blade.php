<!DOCTYPE html>
<!-- saved from url=(0038)http://localhost/adrian/formulario.php -->
<html lang="es"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>PLANILLA DE FACTURACIÓN</title>
<link rel="stylesheet" href="{{asset('css/estilosi_facturacion_traslado.css')}}" media="print">
<style type="text/css">
	body {
		text-align: center;
		background: #4e5255;
	}
	input{ background: none;border: none;}
	#cabecera {
		position: absolute;
		margin-top: 148px;
		text-align: left;
	}
	#cabecera * {
		position: relative;
	}
	#contenedor {
		width:1131px;
		height:800px;
		margin:auto;
	}
	#transporte {
		left: 123px;
		display: block;
		width:970px;
	}
	#transporte1 {width: 320px; float: left}
	#periodo {
		margin-top: 10px;
	}
	#codigo { margin-left: 155px;
		width: 467px;
	}
	.clear {
		clear: both;
	}
	#periodo{margin-left: 100px;}
	#periodo1{width: 35px;}
	#periodo2{width: 45px;}
	#periodo2{margin-left: 10px;}
	#datos { position: absolute;
		margin-top: 232px;
		margin-left: 21px;
		width:1095px;
		text-align: left;
	}
	.fila {
		width:1195px;
	}

	.fila input { height: 16.3px; margin-top: 2px;
		border-bottom: 1px solid black;
	}
.c3,.c4,.c5,.c6,.c7,.c9{ text-align: center; }
	.c0{width: 245px}
	.c1{width: 146px;margin-left: 7px;}
	.c2{width: 146px;margin-left: 2px;}
	.c3{width: 53px;margin-left: 2px;}
	.c4{width: 53px}
	.c5{width: 52px}
	.c6{width: 78px;margin-left:0px;}
	.c7{width: 78px}
	.c8{width: 79px;margin-left: 1px;text-align: center;}
	.c9{width: 78px}
	#importe1 {margin-left:929px;width: 75px;margin-top: 4px}
	#importe input {text-align: center;}
	#firma {margin-left:768px;margin-top: 62px}
	#firma input {text-align: center}
	#firma1{width: 305px; }
	#boton_im {
	position:absolute;
	margin-top:20px;
	margin-left: 710px;
}
#boton_im input{
	width: 90px;
	height: 25px;
	color:#fff;
	background: #000;
	border:none;
	border-radius: 15px;
}
</style></head>


<body>
<div id="contenedor"><div id="boton_im"><input type="button" name="imprimir" value="IMPRIMIR" onclick="window.print();"></div>
<div id="cabecera">
	<div id="transporte"><input type="text" name="transporte" id="transporte1" value="{{Auth::user()->name . ' ' . Auth::user()->surname}}">
		<input type="text" name="codigo" id="codigo" value="{{$beneficiarios[0]->codigo_prestador}}">
	</div>
	<div class="clear"></div>
	<div id="periodo"><input type="text" name="periodo" id="periodo1" value="{{Auth::user()->mes}}"><input type="text" name="periodo" id="periodo2" value="{{Auth::user()->anio}}"></div>
</div>
<div id="datos">
			@php
				$indice = 0;
				$importe_total = 0;
			@endphp
			@foreach($beneficiarios as $k => $benef)
				<div class="fila f{{$k}}">
					<input type="text" name="text0" class="c0" value="{{$benef->nombre}}">
					<input type="text" name="text1" class="c1" value="{{$benef->direccion}}">
					<input type="text" name="text2" class="c2" value="{{$benef->direccion_prestacion}}">
					<input type="text" name="text3" class="c3" value="{{$benef->km_dia}}">
					<input type="text" name="text4" class="c4" value="{{$benef->km_mes}}">
					<input type="text" name="text5" class="c5" value="{{$benef->total_fechas}}">
					<input type="text" name="text6" class="c6" value="$ {{$benef->importe_unitario}}">
					<input type="text" name="text7" class="c7" value="$ {{$benef->importe_dependencia['valor_modulo']}}">
					<input type="text" name="text8" class="c8" value="$ {{$benef->importe_total}}">
					<input type="text" name="text9" class="c9" value="{{($benef->traditum['codigo'] ?? '')}}">
				</div>
				@php
					$indice++;
					$importe_total += str_replace(',','.', str_replace('.',',',$benef->importe_total));
				@endphp
			@endforeach

			@for ($i = $indice; $i < 19; $i++)
				<div class="fila f{{$i}}">
					<input type="text" name="text0" class="c0">
					<input type="text" name="text1" class="c1">
					<input type="text" name="text2" class="c2">
					<input type="text" name="text3" class="c3">
					<input type="text" name="text4" class="c4">
					<input type="text" name="text5" class="c5">
					<input type="text" name="text6" class="c6">
					<input type="text" name="text7" class="c7">
					<input type="text" name="text8" class="c8">
					<input type="text" name="text9" class="c9">
				</div>
			@endfor
		<div id="importe"><input type="text" name="importe" id="importe1" value="$ {{number_format($importe_total, 2, ',', '.')}}">
		<div id="firma"><input type="text" name="firma" id="firma1">
	</div>
</div>

</div>

<img src="{{asset('img/imagen_traslado.jpg')}}" width="1131" height="800">
</div>

</body></html>