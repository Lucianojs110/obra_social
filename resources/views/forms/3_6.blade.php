<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta http-equiv="X-UA-Compatible" content="ie=edge" />
		<title>
			3.6 PLANILLA DE ASISTENCIA MENSUAL - TRANSPORTE
		</title>
		<link rel="stylesheet" href="{{asset('css/osecac/app.css')}}" />
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

		<main class="content-print container osecac" style="padding-top: 3rem;">
			<h1 class="title" style="font-size: 0.8rem">
				3.6 PLANILLA DE ASISTENCIA MENSUAL - TRANSPORTE
			</h1>

			<div class="form" style="margin-top: 1.5rem;">
				<div class="form-group" style="margin-top: 0.8rem;">
					<span class="form-prepend text">Prestador:</span>
					<input id="lender" type="text" class="form-input" value="{{Auth::user()->name . ' ' . Auth::user()->surname}}"/>
				</div>
				<div class="form-group" style="margin-top: 0.8rem;">
					<span class="form-prepend text">Domicilio:</span>
					<input id="address" type="text" class="form-input" value="{{Auth::user()->direccion . ' - ' . Auth::user()->provincia}}"/>
				</div>
				<div class="row">
					<div class="form-group" style="margin-top: 0.8rem;">
						<span class="form-prepend text">Correo Electrónico</span>
						<input id="email" type="text" class="form-input" value="{{Auth::user()->email}}"/>
					</div>
					<div
						class="form-group"
						style="margin-top: 0.8rem;"
						style="padding-left: 0.5rem; width: 60%;"
					>
						<span class="form-prepend text"
							>Tel</span
						>
						<input id="phone" type="text" class="form-input" value="{{Auth::user()->telefono}}"/>
					</div>
				</div>
				<div class="form-group" style="margin-top: 0.8rem;">
					<span class="form-prepend text"
						>Apellido y Nombre del beneficiario:</span
					>
					<input id="name" type="text" class="form-input" value="{{$beneficiario[0]->nombre}}"/>
				</div>
				<div class="form-group" style="margin-top: 0.8rem;">
					<span class="form-prepend text">DNI:</span>
					<input
						id="dni"
						type="text"
						class="form-input"
						style="flex-basis: 25%; width: 25%;"
						value="{{$beneficiario[0]->dni}}"
					/>
				</div>
				<div class="form-group" style="margin-top: 0.8rem;">
					<span class="form-prepend text">Prestación: Transporte a</span>
					<textarea style="font-family:'Arial';font-size:11px; height: 30px;" id="benefit" type="text" class="form-input" >{{$beneficiario[0]->transporte_a}}</textarea>
					<span
						style="position: absolute; left: 32.5%; bottom: -14px; font-size: 0.7rem;"
						>(Indicar tipo de terapia, nombre del profesional y/o razón social
						de la institución)</span
					>
				</div>
				<div class="form-group" style="margin-top: 1.75rem;">
					<span class="form-prepend text">Periodo (mes y año):</span>
					<input
						id="period"
						type="text"
						class="form-input"
						style="flex-basis: 45%; width: 45%;"
						value="{{Auth::user()->mes . ' / ' . Auth::user()->anio}}"
					/>
				</div>
			</div>
			<div class="form" style="margin-top: 1.5rem;">
				<h2 class="form-title">Ida:</h2>
				<div class="form-group" style="margin-top: 1.5rem;">
					<span class="form-prepend text">Desde</span>
					<input id="from-1" type="text" class="form-input" value="{{$beneficiario[0]->direccion}}"/>
				</div>
				<div class="form-group" style="margin-top: 0.8rem;">
					<span class="form-prepend text">Hasta</span>
					<input id="to-1" type="text" class="form-input" value="{{$beneficiario[0]->direccion_prestacion}}"/>
				</div>
				<div class="row">
					<div class="form-group" style="margin-top: 0.8rem;">
						<span class="form-prepend text">Km por viaje</span>
						<input id="km-per-trip-1" type="text" class="form-input" value="{{($beneficiario[0]->km_ida ?? 0) / 2}}"/>
					</div>
					<div
						class="form-group"
						style="margin-top: 0.8rem; padding-left: 0.5rem; width: 130%;"
					>
						<span class="form-prepend text">Cantidad de viajes mensuales</span>
						<input id="trips-by-month-1" type="text" class="form-input" value="{{count($fechas['total'][$beneficiario[0]->id] ?? 0)}}"/>
					</div>
				</div>
			</div>

			<div class="form" style="margin-top: 1.5rem;">
				<h2 class="form-title">Vuelta:</h2>
				<div class="form-group" style="margin-top: 1.5rem;">
					<span class="form-prepend text">Desde</span>
					<input id="from-2" type="text" class="form-input" value="{{$beneficiario[0]->direccion_prestacion}}"/>
				</div>
				<div class="form-group" style="margin-top: 0.8rem;">
					<span class="form-prepend text">Hasta</span>
					<input id="to-2" type="text" class="form-input" value="{{$beneficiario[0]->direccion}}"/>
				</div>
				<div class="row">
					<div class="form-group" style="margin-top: 0.8rem;">
						<span class="form-prepend text">Km por viaje</span>
						<input id="km-per-trip-2" type="text" class="form-input" value="{{($beneficiario[0]->km_ida ?? 0) / 2}}"/>
					</div>
					<div
						class="form-group"
						style="margin-top: 0.8rem; padding-left: 0.5rem; width: 130%;"
					>
						<span class="form-prepend text">Cantidad de viajes mensuales</span>
						<input id="trips-by-month-2" type="text" class="form-input" value="{{count($fechas['total'][$beneficiario[0]->id] ?? 0)}}"/>
					</div>
				</div>
			</div>

			<div class="form" style="margin-top: 1.2rem;">
				<div class="row" style="display: flex; justify-content: space-between;">
					<div class="form-group" style="width: 30%; margin-top: 0.8rem;">
						<span class="form-prepend text" style="font-weight: bold;"
							>Total Km por día:</span
						>
						<input id="total-km-per-day" type="text" class="form-input" value="{{$beneficiario[0]->km_ida}}"/>
					</div>
					<div class="form-group" style="width: 30%; margin-top: 0.8rem;">
						<span class="form-prepend text" style="font-weight: bold;"
							>Cantidad de días/mes:</span
						>
						<input id="quantity-days" type="text" class="form-input" value="{{count($fechas['total'][$beneficiario[0]->id] ?? 0)}}"/>
					</div>
				</div>
				<div
					class="form-group"
					style="width: 30%; margin-top: 0.8rem; transform: translateX(120%)"
				>
					<span class="form-prepend text" style="font-weight: bold;"
						>Total Km mensuales:</span
					>
					<input id="total-km-by-month" type="text" class="form-input" value="{{(($beneficiario[0]->km_ida ?? 0) * (count($fechas['total'][$beneficiario[0]->id]) ?? 0))}}"/>
				</div>
			</div>

			<div class="table-content container" style="margin-top: 0.8rem;">
				<table id="3.4-form-table-2" class="table">
					<thead>
						<tr>
							<th class="text">Prestador</th>
							<th class="text">Paciente o responsable</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td
								style="width: 33%; height: 90px; font-size: 0.8rem; text-align: center; vertical-align: bottom; padding: 0.1rem 0.8rem;"
							>
								Firma
							</td>
							<td
								style="width: 33%; height: 90px; font-size: 0.8rem; text-align: center; vertical-align: bottom; padding: 0.1rem 0.2rem;"
							>
								Firma
							</td>
						</tr>
						<tr>
							<td
								style="width: 33%; height: 60px; font-size: 0.8rem; text-align: center; vertical-align: bottom; padding: 0.1rem 0.2rem;"
							>
								Sello o Aclaración
							</td>
							<td style="width: 33%;">
								<div
									style="display: flex; align-items: flex-end; height: 30px; padding-left: 0.5rem; font-size: 0.8rem; border-bottom: 1px solid #070707;"
								>
									Aclaración
								</div>
								<div
									style="display: flex; align-items: flex-end; height: 30px; padding-left: 0.5rem; font-size: 0.8rem; border-bottom: 1px solid #070707;"
								>
									DNI
								</div>
								<div
									style="display: flex; align-items: flex-end; height: 30px; padding-left: 0.5rem; font-size: 0.8rem;"
								>
									Vínculo
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<footer style="margin-top: 5rem;">
				<div class="footer-line dark"></div>
				<div
					class="footer-line light"
					style="height: 1px; margin-top: 0.05rem;"
				></div>
				<p class="text" style="margin-top: 0.2rem">
					Subsidios por Discapacidad {{date('Y')}}
				</p>
			</footer>
		</main>

		<script src="{{asset('js/osecac/app.js')}}"></script>
	</body>
</html>
