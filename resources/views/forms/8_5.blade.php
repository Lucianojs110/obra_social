@php
	$meses = ['01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'];
@endphp

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta http-equiv="X-UA-Compatible" content="ie=edge" />
		<title>
			Anexo 8.5 - Presupuesto Transporte
		</title>
		<link rel="stylesheet" href="{{asset('css/form.css')}}" />
	</head>
	<body>
		<header>
			<nav class="navbar">
				<div class="container nav-content">
					<li class="nav-logo"><p>Formularios Web</p></li>
					<ul class="nav-menu">
						<li class="nav-item">
							<a id="btn-print-content" class="btn secondary" href="#"
								>Imprimir</a
							>
						</li>
						<!--<li class="nav-item">
							<a class="btn primary dropdown" href="#">Menu</a>
							<div class="dropdown-items">
								<a
									class="dropdown-item"
									href="#osecac"
									onclick="AppClass.bindContentLinkClick(event)"
									>osecac</a
								>
								<a
									class="dropdown-item"
									href="#apross"
									onclick="AppClass.bindContentLinkClick(event)"
									>apross</a
								>
							</div>
						</li>-->
					</ul>
				</div>
			</nav>
		</header>

		<main class="content-print container osecac" style="padding-top: 1.5rem;">
			<h1 class="title" style="font-size: 0.8rem">
				Anexo 8.5 - Presupuesto Transporte
			</h1>

			<div class="form" style="margin-top: 0.5rem; padding: 0 0.5rem">
				<div class="form-group" style="width: 30%; margin-top: 0.4rem;">
					<span class="form-prepend text" style="font-size: 0.8rem;"
						>Fecha de emisión:</span
					>
					<input id="emition-date-day" type="text" style="width: 50px;"  class="form-input" value="{{date('d')}}"/>
					<span class="form-prepend text" style="font-size: 0.8rem;">/</span>
					<input id="emition-date-month" style="width: 50px;"  type="text" class="form-input" value="{{date('m')}}"/>
					<span class="form-prepend text" style="font-size: 0.8rem;">/</span>
					<input id="emition-date-year" style="width: 50px;" type="text" class="form-input" value="{{date('Y')}}"/>
				</div>
				<div class="row">
					<div class="form-group" style="margin-top: 0.1rem;">
						<span class="form-prepend text" style="font-size: 0.8rem;"
							>Prestador:</span
						>
						<input id="lender" type="text" class="form-input" value="{{ $prestador[0]->user->name . ' ' . $prestador[0]->user->surname }}"/>
					</div>
					<div
						class="form-group"
						style="margin-top: 0.1rem; padding-left: 0.5rem; width: 75%;"
					>
						<span class="form-prepend text" style="font-size: 0.8rem;"
							>CUIT:</span
						>
						<input id="cuit" type="text" class="form-input" value="{{ $prestador[0]->user->cuit }}"/>
					</div>
				</div>
				<div class="form-group" style="margin-top: 0.1rem;">
					<span class="form-prepend text" style="font-size: 0.8rem;"
						>Domicilio:</span
					>
					<input id="address" type="text" class="form-input" value="{{ $prestador[0]->user->direccion." ,".$prestador[0]->user->localidad." ,".$prestador[0]->user->provincia->provincia }}"/>
				</div>
				<div class="row">
					<div class="form-group" style="margin-top: 0.1rem;">
						<span class="form-prepend text" style="font-size: 0.8rem;"
							>Teléfono:</span
						>
						<input id="phone" type="text" class="form-input" value="{{ $prestador[0]->user->telefono }}"/>
					</div>
					<div
						class="form-group"
						style="margin-top: 0.1rem; padding-left: 0.3rem; width: 150%;"
					>
						<span class="form-prepend text" style="font-size: 0.8rem;"
							>Mail de contacto:</span
						>
						<input id="email" type="text" class="form-input" value="{{ $prestador[0]->user->email }}"/>
					</div>
				</div>
				<div class="row">
					<div class="form-group" style="margin-top: 0.1rem;">
						<span class="form-prepend text" style="font-size: 0.8rem;"
							>Compañía de Seguros:</span
						>
						<input id="company" type="text" class="form-input" value="{{ $prestador[0]->user->emp_seguros }}"/>
					</div>
					<div
						class="form-group"
						style="margin-top: 0.1rem; padding-left: 1.5rem; width: 97.5%;"
					>
						<span class="form-prepend text" style="font-size: 0.8rem;"
							>Póliza Nº:</span
						>
						<input id="policy" type="text" class="form-input" value="{{ $prestador[0]->user->poliza }}"/>
					</div>
				</div>
				<div class="form-group" style="margin-top: 0.1rem;">
					<span class="form-prepend text" style="font-size: 0.8rem;"
						>Orden de emisión de cheque:</span
					>
					<input id="emition-order" type="text" class="form-input" value="{{ $prestador[0]->user->orden_cheque }}"/>
				</div>
				<div class="row">
					<div class="form-group" style="margin-top: 0.1rem;">
						<span class="form-prepend text" style="font-size: 0.8rem;"
							>Entidad Bancaria:</span
						>
						<input id="bank" type="text" class="form-input" value="{{ $prestador[0]->user->entidad_bancaria }}"/>
					</div>
					<div
						class="form-group"
						style="margin-top: 0.1rem; padding-left: 0.3rem; width: 130%;"
					>
						<span class="form-prepend text" style="font-size: 0.8rem;"
							>(CBU):</span
						>
						<input id="cbu" type="text" class="form-input" value="{{ $prestador[0]->user->cbu }}"/>
					</div>
				</div>
				<div class="form-group" style="width: 55%; margin-top: 0.1rem;">
					<span class="form-prepend text" style="font-size: 0.8rem;"
						>Lugar de Pago (Delegación):</span
					>
					<input id="payment-place" type="text" class="form-input" value="{{ $prestador[0]->user->lugar_pago }}"/>
				</div>
			</div>

			<div class="form" style="margin-top: 1rem; padding: 0 0.5rem">
				<div
					class="row"
					style="justify-content: space-between; align-items: center;"
				>
					<span class="text">Condición frente a</span>
					<span class="text">IVA:</span>
					<div
						class="form-group"
						style="width: 60%; align-items: center; justify-content: space-between; margin-top: 0;"
					>
						<div class="form-group" style="width: 70%; margin-top: 0;">
							<span class="text">Inscripto</span>
							<div
								style="width: 20px; height: 20px; margin-left: 0.4rem; border: 1px solid #212121; text-align: center; font-size: 1.1rem; cursor: pointer;"
								onclick="AppClass.bindInputCheck(event)"
								data-checked="{{ $prestador[0]->user->condicion_iva == 'Responsable Inscripto' ? '1' : '0' }}"
							>{{ $prestador[0]->user->condicion_iva == 'Responsable Inscripto' ? 'X' : '' }}</div>
						</div>
						<div class="form-group" style="margin-top: 0;">
							<span class="text">Monotributo</span>
							<div
								style="width: 20px; height: 20px; margin-left: 1.5rem; border: 1px solid #212121; text-align: center; font-size: 1.1rem; cursor: pointer;"
								onclick="AppClass.bindInputCheck(event)"
								data-checked="{{ $prestador[0]->user->condicion_iva == 'Monotributo' ? '1' : '0' }}"
							>{{ $prestador[0]->user->condicion_iva == 'Monotributo' ? 'X' : '' }}</div>
						</div>
						<div class="form-group" style="margin-top: 0;">
							<span class="text">Exento</span>
							<div
								style="width: 20px; height: 20px; margin-left: 0.6rem; border: 1px solid #212121; text-align: center; font-size: 1.1rem; cursor: pointer;"
								onclick="AppClass.bindInputCheck(event)"
								data-checked="{{ $prestador[0]->user->condicion_iva == 'Exento' ? '1' : '0' }}"
							>{{ $prestador[0]->user->condicion_iva == 'Exento' ? 'X' : '' }}</div>
						</div>
					</div>
				</div>
				<div
					class="row"
					style="justify-content: space-between; align-items: center; margin-top: 0.5rem;"
				>
					<span class="text">Condición frente a</span>
					<span class="text">Ing. Brutos:</span>
					<div
						class="form-group"
						style="width: 60%; align-items: center; justify-content: space-between; margin-top: 0;"
					>
						<div class="form-group" style="width: 70%; margin-top: 0;">
							<span class="text">Inscripto</span>
							<div
								style="width: 20px; height: 20px; margin-left: 0.4rem; border: 1px solid #212121; text-align: center; font-size: 1.1rem; cursor: pointer;"
								onclick="AppClass.bindInputCheck(event)"
								data-checked="{{ $prestador[0]->user->condicion_iibb == 'Inscripto' ? '1' : '0' }}"
							>{{ $prestador[0]->user->condicion_iibb == 'Inscripto' ? 'X' : '' }}</div>
						</div>
						<div class="form-group" style="margin-top: 0;">
							<span class="text">Conv. Multilat</span>
							<div
								style="width: 20px; height: 20px; margin-left: 1rem; border: 1px solid #212121; text-align: center; font-size: 1.1rem; cursor: pointer;"
								onclick="AppClass.bindInputCheck(event)"
								data-checked="{{ $prestador[0]->user->condicion_iibb == 'Convenio Multilateral' ? '1' : '0' }}"
							>{{ $prestador[0]->user->condicion_iibb == 'Convenio Multilateral' ? 'X' : '' }}</div>
						</div>
						<div class="form-group" style="margin-top: 0;">
							<span class="text">Exento</span>
							<div
								style="width: 20px; height: 20px; margin-left: 0.6rem; border: 1px solid #212121; text-align: center; font-size: 1.1rem; cursor: pointer;"
								onclick="AppClass.bindInputCheck(event)"
								data-checked="{{ $prestador[0]->user->condicion_iibb == 'Exento' ? '1' : '0' }}"
							>{{ $prestador[0]->user->condicion_iibb == 'Exento' ? 'X' : '' }}</div>
						</div>
					</div>
				</div>
				<div
					class="form-group"
					style="width: 79%; margin-top: 0rem; justify-content: flex-end;"
				>
					<span class="form-prepend text" style="font-size: 0.8rem;"
						>Nº IIBB:</span
					>
					<input
						id="iibb"
						type="text"
						class="form-input"
						style="flex-basis: 40%; width: 40%; background-color: transparent;"
						value="{{ $prestador[0]->user->iibb }}"
					/>
				</div>
				<div class="form-group" style="margin-top: 0.5rem;">
					<span class="text small" style="width: 100%; font-size: 0.6rem;"
						>Tomo conocimiento que la falta de alguno de los datos aquí
						requeridos imposibilitan mi alta como prestador y la emisión de la
						correspondiente autorización</span
					>
				</div>
			</div>

			<div class="form" style="margin-top: 0.8rem; padding: 0 0.5rem">
				<div class="row">
					<div class="form-group" style="margin-top: 0">
						<span class="form-prepend text" style="font-size: 0.8rem;"
							>Beneficiario Causante:</span
						>
						<input id="beneficiary" type="text" class="form-input" style="width: 300px;" value="{{ $beneficiario->nombre }}"/>
					</div>
					<div
						class="form-group"
						style="margin-top: 0.5rem; padding-left: 0.5rem; width: 55%;"
					>
						<span class="form-prepend text" style="font-size: 0.8rem;"
							>DNI:</span
						>
						<input
							id="dni"
							type="text"
							class="form-input"
							style="margin-left: 0.5rem;"
							value="{{$beneficiario->dni}}"
						/>
					</div>
				</div>
				<div class="form-group" style="margin-top: 0.3rem;">
					<span class="form-prepend text" style="font-size: 0.8rem;"
						>Prestación a brindar Transporte Especial a:</span
					>
					<input id="transport-benefit" type="text" class="form-input" value="{{$prestador[0]->prestacion[0]->nombre}}"/>
				</div>
				<div class="row" style="margin-top: 0.4rem;">
					<div class="form-group" style="margin-top: 0.4rem;">
						<span class="form-prepend text" style="font-size: 0.8rem;"
							>Período:</span
						>
						<input id="period" type="text" class="form-input" value="{{$meses[Auth::user()->mes] . ' a Diciembre'}}"/>
					</div>
					<div
						class="form-group"
						style="margin-top: 0.3rem; padding-left: 1.5rem; width: 50%;"
					>
						<span
							class="form-prepend text"
							style="transform: translateY(-70%); font-size: 0.8rem;"
							>(Tipo de prestación o institución)
						</span>
					</div>
					<div
						class="form-group"
						style="margin-top: 0.5rem; padding-left: 1.5rem; width: 50%;"
					>
						<span class="form-prepend text" style="font-size: 0.8rem;"
							>Año:</span
						>
						<input id="year" type="text" class="form-input" value="{{Auth::user()->anio}}"/>
					</div>
				</div>
			</div>
			<div class="table-content" style="margin-top: 1.5rem;">
				<table class="table">
					<tbody>
						<tr>
							<td style="position: relative; padding: 0 0.5rem;">
								<span
									class="text bolder"
									style="position: absolute; top: 0.15rem; left: 0.5rem; line-height: 12px; font-size: 0.95rem; border-bottom: 2px solid #212121;"
									>IDA:</span
								>
								<div
									class="form"
									style="position: relative; top: -15%; left: 15%; width: 85%; margin-top: 0.8rem;"
								>
									<div
										class="form-group"
										style="width: 100%; margin-top: 0.3rem;"
									>
										<span class="form-prepend text" style="font-size: 0.8rem;"
											>Desde:</span
										>
										<input id="from-going" type="text" class="form-input" value="{{$beneficiario->direccion . ', ' . $beneficiario->localidad.', '. $beneficiario->provincia->provincia}}" style="width:100%;" />
									</div>
									<div
										class="form-group"
										style="width: 100%; margin-top: 0.3rem;"
									>
										<span class="form-prepend text" style="font-size: 0.8rem;"
											>Hasta:</span
										>
										<input id="to-going" type="text" class="form-input" value="{{$beneficiario->direccion_prestacion . ', ' . $beneficiario->localidad_prestacion.', ' . $beneficiario->provinciaprestacion->provincia}}"/>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="table-content" style="margin-top: 0rem;">
				<table class="table">
					<thead>
						<tr>
							<th
								class="text"
								style="border-top: none; vertical-align: top; padding-bottom: 0.1rem;"
							>
								Días
							</th>
							<th
								class="text"
								style="border-top: none; vertical-align: top; padding-bottom: 0.1rem;"
							>
								Lunes
							</th>
							<th
								class="text"
								style="border-top: none; vertical-align: top; padding-bottom: 0.1rem;"
							>
								Martes
							</th>
							<th
								class="text"
								style="border-top: none; vertical-align: top; padding-bottom: 0.1rem;"
							>
								Miércoles
							</th>
							<th
								class="text"
								style="border-top: none; vertical-align: top; padding-bottom: 0.1rem;"
							>
								Jueves
							</th>
							<th
								class="text"
								style="border-top: none; vertical-align: top; padding-bottom: 0.1rem;"
							>
								Viernes
							</th>
							<th
								class="text"
								style="border-top: none; vertical-align: top; padding-bottom: 0.1rem;"
							>
								Sábado
							</th>
						</tr>
					</thead>
					<tbody>
						<tr style="height: 27.5px;">
							<td
								class="text bolder"
								style="width: 115px; text-align: center; vertical-align: bottom;"
							>
								Horario
							</td>
							<td>
								@php
									if(isset($beneficiario->sesion['Lunes'])){
										$horario = $beneficiario->sesion['Lunes']->hora;
									}else{
										$horario = '';
									}
								@endphp
								<input id="schedule-going-1" type="text" class="table-input" value="{{$horario ?? ''}}"/>
							</td>
							<td>
								@php
									if(isset($beneficiario->sesion['Martes'])){
										$horario = $beneficiario->sesion['Martes']->hora;
									}else{
										$horario = '';
									}
								@endphp
								<input id="schedule-going-2" type="text" class="table-input" value="{{$horario ?? ''}}"/>
							</td>
							<td>
								@php
									if(isset($beneficiario->sesion['Miercoles'])){
										$horario = $beneficiario->sesion['Miercoles']->hora;
									}else{
										$horario = '';
									}
								@endphp
								<input id="schedule-going-3" type="text" class="table-input" value="{{$horario ?? ''}}"/>
							</td>
							<td>
								@php
									if(isset($beneficiario->sesion['Jueves'])){
										$horario = $beneficiario->sesion['Jueves']->hora;
									}else{
										$horario = '';
									}
								@endphp
								<input id="schedule-going-4" type="text" class="table-input" value="{{$horario ?? ''}}"/>
							</td>
							<td>
								@php
									if(isset($beneficiario->sesion['Viernes'])){
										$horario = $beneficiario->sesion['Viernes']->hora;
									}else{
										$horario = '';
									}
								@endphp
								<input id="schedule-going-5" type="text" class="table-input" value="{{$horario ?? ''}}"/>
							</td>
							<td>
								@php
									if(isset($beneficiario->sesion['Sabado'])){
										$horario = $beneficiario->sesion['Sabado']->hora;
									}else{
										$horario = '';
									}
								@endphp
								<input id="schedule-going-6" type="text" class="table-input" value="{{$horario ?? ''}}"/>
							</td>
						</tr>
						<tr style="height: 27.5px;">
							<td
								class="text bolder"
								style="width: 115px; text-align: center; vertical-align: top;"
							>
								Km ida
							</td>
							<td>
								@php
									if(isset($beneficiario->sesion['Lunes'])){
										$km_ida = (($beneficiario->km_ida / 2) ?? 0);
									}else{
										$km_ida = '';
									}
								@endphp
								<input id="km-going-1" type="text" class="table-input"  value="{{$km_ida}}"/>
							</td>
							<td>
								@php
									if(isset($beneficiario->sesion['Martes'])){
										$km_ida = (($beneficiario->km_ida / 2) ?? 0);
									}else{
										$km_ida = '';
									}
								@endphp
								<input id="km-going-2" type="text" class="table-input"  value="{{$km_ida}}"/>
							</td>
							<td>
								@php
									if(isset($beneficiario->sesion['Miercoles'])){
										$km_ida = (($beneficiario->km_ida / 2) ?? 0);
									}else{
										$km_ida = '';
									}
								@endphp
								<input id="km-going-3" type="text" class="table-input"  value="{{$km_ida}}"/>
							</td>
							<td>
								@php
									if(isset($beneficiario->sesion['Jueves'])){
										$km_ida = (($beneficiario->km_ida / 2) ?? 0);
									}else{
										$km_ida = '';
									}
								@endphp
								<input id="km-going-4" type="text" class="table-input"  value="{{$km_ida}}"/>
							</td>
							<td>
								@php
									if(isset($beneficiario->sesion['Viernes'])){
										$km_ida = (($beneficiario->km_ida / 2) ?? 0);
									}else{
										$km_ida = '';
									}
								@endphp
								<input id="km-going-5" type="text" class="table-input"  value="{{$km_ida}}"/>
							</td>
							<td>
								@php
									if(isset($beneficiario->sesion['Sabado'])){
										$km_ida = (($beneficiario->km_ida / 2) ?? 0);
									}else{
										$km_ida = '';
									}
								@endphp
								<input id="km-going-6" type="text" class="table-input"  value="{{$km_ida}}"/>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="table-content" style="margin-top: 0rem;">
				<table class="table">
					<tbody>
						<tr>
							<td style="position: relative; padding: 0 0.5rem;">
								<span
									class="text bolder"
									style="position: absolute; top: 0.15rem; left: 0.5rem; line-height: 12px; font-size: 0.95rem; border-bottom: 2px solid #212121;"
									>VUELTA:</span
								>
								<div
									class="form"
									style="position: relative; top: -15%; left: 15%; width: 85%; margin-top: 0.8rem;"
								>
									<div
										class="form-group"
										style="width: 100%; margin-top: 0.4rem;"
									>
										<span class="form-prepend text" style="font-size: 0.8rem;"
											>Desde:</span
										>
										<input id="from-back" type="text" class="form-input" value="{{$beneficiario->direccion_prestacion . ', ' . $beneficiario->localidad_prestacion.', ' . $beneficiario->provinciaprestacion->provincia}}"/>
									</div>
									<div
										class="form-group"
										style="width: 100%; margin-top: 0.4rem;"
									>

										<span class="form-prepend text" style="font-size: 0.8rem;"
											>Hasta:</span
										>
										<input id="to-back" type="text" class="form-input" value="{{$beneficiario->direccion . ', ' . $beneficiario->localidad.', ' . $beneficiario->provincia->provincia}}"/>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="table-content" style="margin-top: 0rem;">
				<table class="table">
					<thead>
						<tr>
							<th
								class="text"
								style="border-top: none; vertical-align: top; padding-bottom: 0.1rem;"
							>
								Días
							</th>
							<th
								class="text"
								style="border-top: none; vertical-align: top; padding-bottom: 0.1rem;"
							>
								Lunes
							</th>
							<th
								class="text"
								style="border-top: none; vertical-align: top; padding-bottom: 0.1rem;"
							>
								Martes
							</th>
							<th
								class="text"
								style="border-top: none; vertical-align: top; padding-bottom: 0.1rem;"
							>
								Miércoles
							</th>
							<th
								class="text"
								style="border-top: none; vertical-align: top; padding-bottom: 0.1rem;"
							>
								Jueves
							</th>
							<th
								class="text"
								style="border-top: none; vertical-align: top; padding-bottom: 0.1rem;"
							>
								Viernes
							</th>
							<th
								class="text"
								style="border-top: none; vertical-align: top; padding-bottom: 0.1rem;"
							>
								Sábado
							</th>
						</tr>
					</thead>
					<tbody>
						<tr style="height: 27.5px;">
							<td
								class="text bolder"
								style="width: 115px; text-align: center; vertical-align: bottom;"
							>
								Horario
							</td>
							<td>
								@php
									if(isset($beneficiario->sesion['Lunes'])){
										$horario = $beneficiario->sesion['Lunes']->fecha_fin;
									}else{
										$horario = '';
									}
								@endphp
								<input id="schedule-going-1" type="text" class="table-input" value="{{$horario ?? ''}}"/>
							</td>
							<td>
								@php
									if(isset($beneficiario->sesion['Martes'])){
										$horario = $beneficiario->sesion['Martes']->fecha_fin;
									}else{
										$horario = '';
									}
								@endphp
								<input id="schedule-going-2" type="text" class="table-input" value="{{$horario ?? ''}}"/>
							</td>
							<td>
								@php
									if(isset($beneficiario->sesion['Miercoles'])){
										$horario = $beneficiario->sesion['Miercoles']->fecha_fin;
									}else{
										$horario = '';
									}
								@endphp
								<input id="schedule-going-3" type="text" class="table-input" value="{{$horario ?? ''}}"/>
							</td>
							<td>
								@php
									if(isset($beneficiario->sesion['Jueves'])){
										$horario = $beneficiario->sesion['Jueves']->fecha_fin;
									}else{
										$horario = '';
									}
								@endphp
								<input id="schedule-going-4" type="text" class="table-input" value="{{$horario ?? ''}}"/>
							</td>
							<td>
								@php
									if(isset($beneficiario->sesion['Viernes'])){
										$horario = $beneficiario->sesion['Viernes']->fecha_fin;
									}else{
										$horario = '';
									}
								@endphp
								<input id="schedule-going-5" type="text" class="table-input" value="{{$horario ?? ''}}"/>
							</td>
							<td>
								@php
									if(isset($beneficiario->sesion['Sabado'])){
										$horario = $beneficiario->sesion['Sabado']->fecha_fin;
									}else{
										$horario = '';
									}
								@endphp
								<input id="schedule-going-6" type="text" class="table-input" value="{{$horario ?? ''}}"/>
							</td>
						</tr>
						<tr style="height: 27.5px;">
							<td
								class="text bolder"
								style="width: 115px; text-align: center; vertical-align: top;"
							>
								Km Vuelta
							</td>
							<td>
								@php
									if(isset($beneficiario->sesion['Lunes'])){
										$km_ida = (($beneficiario->km_ida / 2) ?? 0);
									}else{
										$km_ida = '';
									}
								@endphp
								<input id="km-going-1" type="text" class="table-input"  value="{{$km_ida}}"/>
							</td>
							<td>
								@php
									if(isset($beneficiario->sesion['Martes'])){
										$km_ida = (($beneficiario->km_ida / 2) ?? 0);
									}else{
										$km_ida = '';
									}
								@endphp
								<input id="km-going-2" type="text" class="table-input"  value="{{$km_ida}}"/>
							</td>
							<td>
								@php
									if(isset($beneficiario->sesion['Miercoles'])){
										$km_ida = (($beneficiario->km_ida / 2) ?? 0);
									}else{
										$km_ida = '';
									}
								@endphp
								<input id="km-going-3" type="text" class="table-input"  value="{{$km_ida}}"/>
							</td>
							<td>
								@php
									if(isset($beneficiario->sesion['Jueves'])){
										$km_ida = (($beneficiario->km_ida / 2) ?? 0);
									}else{
										$km_ida = '';
									}
								@endphp
								<input id="km-going-4" type="text" class="table-input"  value="{{$km_ida}}"/>
							</td>
							<td>
								@php
									if(isset($beneficiario->sesion['Viernes'])){
										$km_ida = (($beneficiario->km_ida / 2) ?? 0);
									}else{
										$km_ida = '';
									}
								@endphp
								<input id="km-going-5" type="text" class="table-input"  value="{{$km_ida}}"/>
							</td>
							<td>
								@php
									if(isset($beneficiario->sesion['Sabado'])){
										$km_ida = (($beneficiario->km_ida / 2) ?? 0);
									}else{
										$km_ida = '';
									}
								@endphp
								<input id="km-going-6" type="text" class="table-input"  value="{{$km_ida}}"/>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="table-content" style="margin-top: 0rem;">
				<table class="table">
					<tbody>
						<tr>
							<td
								style="display:flex; justify-content: center; height: 22px; padding: 0 0.2rem;"
							>
								<span
									class="text bolder"
									style="margin-bottom: 3px; font-size: 0.95rem; border-bottom: 2px solid #212121;"
									>TOTALES KM DIARIOS</span
								>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="table-content" style="margin-top: 0rem;">
				<table class="table">
					<thead>
						<tr>
							<th
								class="text"
								style="border-top: none; vertical-align: top; padding-bottom: 0.1rem;"
							>
								Días
							</th>
							<th
								class="text"
								style="border-top: none; vertical-align: top; padding-bottom: 0.1rem;"
							>
								Lunes
							</th>
							<th
								class="text"
								style="border-top: none; vertical-align: top; padding-bottom: 0.1rem;"
							>
								Martes
							</th>
							<th
								class="text"
								style="border-top: none; vertical-align: top; padding-bottom: 0.1rem;"
							>
								Miércoles
							</th>
							<th
								class="text"
								style="border-top: none; vertical-align: top; padding-bottom: 0.1rem;"
							>
								Jueves
							</th>
							<th
								class="text"
								style="border-top: none; vertical-align: top; padding-bottom: 0.1rem;"
							>
								Viernes
							</th>
							<th
								class="text"
								style="border-top: none; vertical-align: top; padding-bottom: 0.1rem;"
							>
								Sábado
							</th>
						</tr>
					</thead>
					<tbody>
						<tr style="height: 27.5px;">
							<td
								class="text bolder"
								style="width: 115px; text-align: center; vertical-align: bottom;"
							>
								<p class="text bolder">Km Ida+ Km</p>
								<p class="text bolder">Vuelta</p>
							</td>
							<td>
								@php
									if(isset($beneficiario->sesion['Lunes'])){
										$km_ida = (($beneficiario->km_ida ?? 0));
									}else{
										$km_ida = '';
									}
								@endphp
								<input id="km-going-1" type="text" class="table-input"  value="{{$km_ida}}"/>
							</td>
							<td>
								@php
									if(isset($beneficiario->sesion['Martes'])){
										$km_ida = (($beneficiario->km_ida ?? 0));
									}else{
										$km_ida = '';
									}
								@endphp
								<input id="km-going-2" type="text" class="table-input"  value="{{$km_ida}}"/>
							</td>
							<td>
								@php
									if(isset($beneficiario->sesion['Miercoles'])){
										$km_ida = (($beneficiario->km_ida ?? 0));
									}else{
										$km_ida = '';
									}
								@endphp
								<input id="km-going-3" type="text" class="table-input"  value="{{$km_ida}}"/>
							</td>
							<td>
								@php
									if(isset($beneficiario->sesion['Jueves'])){
										$km_ida = (($beneficiario->km_ida ?? 0));
									}else{
										$km_ida = '';
									}
								@endphp
								<input id="km-going-4" type="text" class="table-input"  value="{{$km_ida}}"/>
							</td>
							<td>
								@php
									if(isset($beneficiario->sesion['Viernes'])){
										$km_ida = (($beneficiario->km_ida ?? 0));
									}else{
										$km_ida = '';
									}
								@endphp
								<input id="km-going-5" type="text" class="table-input"  value="{{$km_ida}}"/>
							</td>
							<td>
								@php
									if(isset($beneficiario->sesion['Sabado'])){
										$km_ida = (($beneficiario->km_ida ?? 0));
									}else{
										$km_ida = '';
									}
								@endphp
								<input id="km-going-6" type="text" class="table-input"  value="{{$km_ida}}"/>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="table-content" style="margin-top: 0rem;">
				<table class="table">
					<tbody>
						<tr>
							<td
								style="display:flex; justify-content: center; height: 24px; padding: 0.2rem;"
							>
								<span
									class="text bolder"
									style="margin-bottom: 3px; font-size: 0.9rem;"
									>Total Km. Mensuales:</span
								>
								<input
									id="total-km-by-month"
									style="display: inline-block; width: 50px; text-align: left;"
									type="text"
									class="table-input"
									value="{{(($beneficiario->km_ida ?? 0) * ($beneficiario->dias_mensuales ?? 0))}}"
								/>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="form" style="margin-top: 0.2rem; padding: 0 0.5rem">
				<div class="row" style="width: 95%;">
					<div class="form-group" style="width: 50%; margin-top: 0;">
						<span class="form-prepend text" style="font-size: 0.8rem;"
							>Días mensuales (hasta)</span
						>
						<input
							id="monthly-day"
							type="text"
							class="form-input"
							style="flex-basis: 30%; width: 30%;"
							value="{{($beneficiario->dias_mensuales ?? 0)}}"
						/>
					</div>
					<div
						class="form-group"
						style="margin-top: 0.4rem; padding-left: 0.5rem; width: 50%;"
					>
						<span class="form-prepend text" style="font-size: 0.8rem;"
							>Viajes mensuales (hasta)</span
						>
						<input
							id="montly-trips"
							type="text"
							class="form-input"
							style="flex-basis: 30%; width: 30%;"
							value="{{($beneficiario->dias_mensuales ?? 0) * 2}}"
						/>
					</div>
					<div
						class="form-group"
						style="margin-top: 0.4rem; padding-left: 0.5rem; width: 50%; justify-content: flex-end;"
					>
						<span class="form-prepend text" style="font-size: 0.8rem;"
							>Monto por Km.:</span
						>
						@php
							if($prestador[0]->valor_default == 'T'){
								$valor_prestacion = $prestador[0]->prestacion[0]->valor_modulo;
							}else{
								$valor_prestacion = $prestador[0]->valor_prestacion;
							}
						@endphp
						<input
							id="cost-per-km"
							type="text"
							class="form-input"
							style="flex-basis: 30%; width: 30%;"
							value="{{number_format(str_replace(',', '.', $valor_prestacion),2,',','.')}}"
						/>
					</div>
				</div>
				<div
					class="row"
					style="width: 95%; justify-content: space-between; align-items: center;"
				>
					<div
						class="form-group"
						style="width: 50%; margin-top: 0.6rem; align-items: center;"
					>
						<span class="form-prepend text" style="font-size: 0.8rem;"
							>Adicional dependencia 35% (Sujeto a evaluación):</span
						>
						<div class="form-group" style="margin-top: 0;">
							<span class="text" style="font-size: 0.8rem;">Si</span>
							<div
								style="width: 20px; height: 20px; margin: 0 0.4rem; border: 1px solid #212121; text-align: center; font-size: 1.1rem; cursor: pointer;"
								onclick="AppClass.bindInputCheck(event)"
								data-checked="{{$beneficiario->dependencia == 'Si' ? '1' : '0'}}"
							>{{$beneficiario->dependencia == 'Si' ? 'X' : ''}}</div>
						</div>
						<div class="form-group" style="margin-top: 0;">
							<span class="text" style="font-size: 0.8rem;">No</span>
							<div
								style="width: 20px; height: 20px; margin: 0 0.4rem; border: 1px solid #212121; text-align: center; font-size: 1.1rem; cursor: pointer;"
								onclick="AppClass.bindInputCheck(event)"
								data-checked="{{$beneficiario->dependencia != 'Si' ? '1' : '0'}}"
							>{{$beneficiario->dependencia != 'Si' ? 'X' : ''}}</div>
						</div>
					</div>
					<div
						class="form-group"
						style="margin-top: 0.2rem; padding-left: 0.5rem; width: 50%; justify-content: flex-end;"
					>
						@php
							$km_mensual = ($beneficiario->km_ida ?? 0) * ($beneficiario->dias_mensuales ?? 0);
							if($beneficiario->dependencia == 'Si'){
								$montoMensual = (($km_mensual ?? 0) * (str_replace(',','.',$valor_prestacion) ?? 0)) * 135 / 100;
							}else{
								$montoMensual = (($km_mensual ?? 0) * (str_replace(',','.',$valor_prestacion) ?? 0));
							}
						@endphp
						<span class="form-prepend text" style="font-size: 0.8rem;"
							>Monto mensual:</span
						>
						<input
							id="monthly-cost"
							type="text"
							class="form-input"
							style="flex-basis: 30%; width: 30%;"
							value="{{number_format(str_replace(',', '.', $montoMensual), 2, ',', '.')}}"
						/>
					</div>
				</div>
				<div
					class="form-group"
					style="width: 95%; justify-content: space-between; margin-top: 0.8rem;"
				>
					<span
						class="form-prepend text bolder"
						style="width: 35%; padding: 0.25rem 0.8rem; border: 2px solid #212121;"
						>Consentimiento</span
					>
				</div>
				<div class="form-group" style="margin-top: 0.8rem;">
					<p
						class="text"
						style="width: 100%; text-align: justify; text-align-last: justify; font-size: 0.8rem;"
					>
						Por la presente dejo constancia de mi consentimiento al esquema de
						transporte descripto precedentemente al
					</p>
				</div>
				<div class="row" style="width: 65%;">
					<div class="form-group" style="margin-top: 0">
						<span class="form-prepend text" style="font-size: 0.8rem;"
							>beneficiario:</span
						>
						<input id="beneficiary" type="text" class="form-input" style="width: 750px;" value="{{$beneficiario->nombre}}"/>
					</div>
					<div
						class="form-group"
						style="margin-top: 0rem; padding-left: 0.5rem; width: 50%;"
					>
						<span class="form-prepend text" style="font-size: 0.8rem;"
							>DNI:</span
						>
						<input id="dni" type="text" class="form-input" style="width: 250px;" value="{{$beneficiario->dni}}"/>
					</div>
				</div>
				<div
					class="form-group"
					style="width: 95%; justify-content: space-between; margin-top: 3rem;"
				>
					<span
						class="form-prepend text center"
						style="width: 35%; font-size:0.8rem; border-top: 1px solid #212121;"
						>Firma y Aclaración Beneficiario o representante</span
					>
					<span
						class="form-prepend text center"
						style="width: 35%; font-size:0.8rem; border-top: 1px solid #212121;"
						>Firma y Aclaración del Transportista</span
					>
				</div>
			</div>

			<footer style="margin-top: 0.8rem;">
				<div class="footer-line light" style="height: 1px;"></div>
				<p class="text" style="margin-top: 0.2rem">
					Subsidios por Discapacidad {{date('Y')}}
				</p>
			</footer>
		</main>

		<script src="{{asset('js/osecac/app.js')}}"></script>
	</body>
</html>
