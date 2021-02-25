<!DOCTYPE html>
<!-- saved from url=(0038)http://localhost/adrian/formulario.php -->
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>PLANILLA DE FACTURACIÓN</title>
<link rel="stylesheet" href="{{asset('css/estilosi_corregida.css')}}" media="print">

<style type="text/css">
	:root {
	--main-bg-color: #ffffff;
	--main-font-color: #424242;
	--main-primary: #2196f3;
	--main-white: #ffffff;
	--main-secondary: #424242;
	--main-dark: #070707;
	--main-footer-line-light: #631e1e;
	--main-footer-line-dark: #460404;
	--table-grey: #cfd1d4;
	--table-light-grey: #e4e4e7;
	--apross-light-blue: #009c95;
	--apross-extra-light-blue: #5bb4aa;
	--apross-dark-blue: #134144;
	--apross-font-color: #646668;
	--appross-top-line-grey: #d8d8d8;
	--appross-title-blue: #6cb0ae;
}
	body {
		
		background: #e3e6db;
		margin: 0px;
		padding: 0px;
	}
	input{ background: none;border: none;}
	#cabecera {
		position: absolute;
		margin-top: 123px;
		text-align: left;
	}
	#cabecera * {
		position: relative;
	}
	#contenedor {text-align: center;
		width:1350px;
		height:928px;
		margin:auto;
		background: url('{{asset("img/imagen_corregida.jpg")}}') #e3e6db no-repeat;


	}
	#transporte {
		left: 143px;
		margin-top:30px;
		display: block;
		width:1200px;
	}
	#transporte1 {width: 393px; float: left}
	#periodo {
		margin-top: 16px;
	}
	#codigo { margin-left: 178px;
		width: 550px;
	}
	.clear {
		clear: both;
	}
	#periodo{margin-left: 127px;}
	#periodo1{width: 35px;}
	#periodo2{width: 45px;}
	#periodo2{margin-left: 10px;}
	#datos { position: absolute;
		margin-top: 252px;
		margin-left: 18px;
		width:1095px;
		text-align: left;
	}
	.fila {
		width:1340px;
	}

	.fila input { height: 17.19px; margin-top: 2px;
		border-bottom: 1px solid black;
	}
	.f19 {border-bottom:none !important;}
.c3,.c4,.c5,.c6,.c7,.c9{ text-align: center; }
	.c0{width: 296px}
	.c1{width: 177px;margin-left: 10px;}
	.c2{width: 179px;margin-left: 1px;}
	.c3{width: 65px;margin-left: 2px;}
	.c4{width: 65px}
	.c5{width: 65px}
	.c6{width: 95px;margin-left:0px;}
	.c7{width: 96px}
	.c8{width: 96px;margin-left: 1px;text-align: center;}
	.c9{width: 96px}
	#importe1 {margin-left:1120px;width: 87px;margin-top: 8px}
	#importe input {text-align: center;}
	#firma {margin-left:925px;margin-top: 77px}
	#firma input {text-align: center}
	#firma1{width: 375px; }
	#boton_im {
	position:absolute;
	margin-top:20px;
	margin-left: 890px;
}
#boton_im input{
	width: 90px;
	height: 25px;
	color:#fff;
	background: #000;
	border:none;
	border-radius: 15px;
}
.btn.secondary {
	background-color: var(--main-secondary);
	color: var(--main-white);
}
.btn.secondary:hover {
	background-color: var(--main-white);
	color: var(--main-secondary);
	border-color: var(--main-secondary);
}
.btn.secondary-outline {
	background-color: var(--main-white);
	color: var(--main-secondary);
	border-color: var(--main-secondary);
}
.btn.secondary-outline:hover {
	background-color: var(--main-secondary);
	color: var(--main-white);
	border-color: transparent;
}
.navbar .nav-content .nav-logo,
.nav-menu .nav-item {
	position: relative;
	text-transform: uppercase;
	font-size: 0.9rem;
	font-weight: bold;
	color: var(--main-font-color);
}
.nav-menu .nav-item {
	margin: 0 0.5rem;
}
.btn {
	position: relative;
	padding: 0.75rem 1.75rem;
	border: 1px solid transparent;
	border-radius: 1.5rem;
	transition: background-color 300ms ease-in-out, border-color 300ms ease-in-out;
}
a {
    text-decoration: none;
    color: var(--main-font-color);
    font-family: Arial, Helvetica, sans-serif;
}
ul, li {
    list-style: none;
}
li {
    text-align: -webkit-match-parent;
}
</style>
</head>


<body>
<div id="contenedor">
	<div id="boton_im"><ul class="nav-menu">
						<li class="nav-item">
							<a id="btn-print-content" class="btn secondary" href="javascript:window.print();"
								>Imprimir</a
							>
						</li></ul>
						</div>
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

	@for ($i = $indice; $i < 22; $i++)
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

		<div id="importe">
			<input type="text" name="importe" id="importe1" value="$ {{number_format($importe_total, 2, ',', '.')}}">
			<div id="firma">
				<input type="text" name="firma" id="firma1">
			</div>
		</div>
</div>

</div>

</body>
</html>