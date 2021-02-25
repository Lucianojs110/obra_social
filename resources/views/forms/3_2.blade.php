<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta http-equiv="X-UA-Compatible" content="ie=edge" />
		<title>3.2 Planilla de Asistencia Mensual</title>
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

		<main class="content-print container osecac" style="padding-top: 1rem;">
			<h1 class="title" style="font-size: 0.8rem">
				3.2 Planilla de Asistencia Mensual – Prestaciones por hora / sesiones
				(Terapias / Estimulación Temprana / Maestro de Apoyo valor hora)
			</h1>

			<div class="form" style="margin-top: 1.5rem;">
				<div class="form-group" style="margin-top: 0.8rem;">
					<span class="form-prepend text">Prestador:</span>
					<input id="lender-number" type="text" class="form-input" value="{{Auth::user()->name . ' ' . Auth::user()->surname}}"/>
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
					<input id="names" type="text" class="form-input" value="{{$beneficiario[0]->nombre}}"/>
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
					<span class="form-prepend text">Prestación:</span>
					<input id="benefit" type="text" class="form-input" value="{{$prestador[0]->prestacion[0]->nombre.' - '. $beneficiario[0]->profesion}}"/>
				</div>
				<div class="form-group" style="margin-top: 0.8rem;">
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

			<div class="table-content container" style="margin-top: 2rem;">
				<table id="3.2-form-table-1" class="table">
					<thead>
						<tr>
							<th style="font-size: 0.7rem">Fecha dd/mm/aa</th>
							<th style="font-size: 0.7rem">Horario</th>
							<th style="font-size: 0.7rem">Cantidad de sesiones</th>
							<th style="font-size: 0.7rem">Firma Profesional</th>
							<th style="font-size: 0.7rem">
								Firma del paciente o responsable
							</th>
						</tr>
					</thead>
					<tbody>
						@php
							$indice = 0;
						@endphp
						@foreach($fechas['total'][$beneficiario[0]->id] as  $k => $sesion)
							@php
								$fechaExploded = explode('/', $sesion);
							@endphp
							<tr>
								<td style="height:17px">
									<input type="text" id="table-input-1" class="table-input" value="{{$fechaExploded[0].'/'.$fechaExploded[1].'/'.$fechaExploded[2]}}">
								</td>
								<td style="height:17px">
									<input type="text" id="table-input-2" class="table-input" value="{{$fechaExploded[3] . ' - ' . $fechaExploded[4]}}">
								</td>
								<td style="height:17px">
									<input type="text" id="table-input-3" class="table-input" value="1">
								</td>
								<td style="height:17px">
									<input type="text" id="table-input-4" class="table-input">
								</td>
								<td style="height:17px">
									<input type="text" id="table-input-5" class="table-input">
								</td>
							</tr>
							@php
								$indice++;
							@endphp
						@endforeach

						@for ($i = $indice; $i < 20; $i++)
							<tr>
								<td style="height:17px">
									<input type="text" id="table-input-1" class="table-input">
								</td>
								<td style="height:17px">
									<input type="text" id="table-input-2" class="table-input">
								</td>
								<td style="height:17px">
									<input type="text" id="table-input-3" class="table-input">
								</td>
								<td style="height:17px">
									<input type="text" id="table-input-4" class="table-input">
								</td>
								<td style="height:17px">
									<input type="text" id="table-input-5" class="table-input">
								</td>
							</tr>
						@endfor
					</tbody>
				</table>
			</div>

			<div class="table-content container" style="margin-top: 2rem;">
				<table id="3.1-form-table-1" class="table">
					<thead>
						<tr>
							<th class="text">Profesional</th>
							<th class="text">Paciente o responsable</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td
								style="width: 50%; height: 90px; font-size: 0.8rem; text-align: center; vertical-align: bottom;"
							>
								Firma
							</td>
							<td
								style="width: 50%; height: 90px; font-size: 0.8rem; text-align: center; vertical-align: bottom;"
							>
								Firma
							</td>
						</tr>
						<tr>
							<td
								style="width: 50%; height: 60px; font-size: 0.8rem; text-align: center; vertical-align: bottom;"
							>
								Sello o Aclaración
							</td>
							<td style="width: 50%;">
								<div
									style="display: flex; align-items: flex-end; height: 30px; padding-left: 0.5rem; font-size: 0.8rem; border-bottom: 1px solid #070707;"
								>
									Aclaración
								</div>
								<div
									style="display: flex; align-items: flex-end; height: 30px; padding-left: 0.5rem; font-size: 0.8rem;"
								>
									DNI
								</div>
							</td>
						</tr>
						<tr>
							<td
								style="width: 50%; height: 30px; font-size: 0.8rem; text-align: center; vertical-align: bottom;"
							>
								Matricula
							</td>
							<td
								style="width: 50%; height: 30px; padding-left: 0.5rem; font-size: 0.8rem; vertical-align: bottom;"
							>
								Vínculo
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<footer style="margin-top: 3rem;">
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
		{{-- <script>
			AppClass.createTableRows(
				'3.2-form-table-1',
				20,
				5,
				[15, 15, 20, 20, 25],
				17
			);
		</script> --}}
	</body>
</html>
