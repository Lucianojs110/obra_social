<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta http-equiv="X-UA-Compatible" content="ie=edge" />
		<title>Planilla de integración escolar</title>
		<link rel="stylesheet" href="{{ asset('css/app_2.css') }}" />
		<link rel="stylesheet" href="{{ asset('css/apross/integration.css') }}" />
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
					</ul>
				</div>
			</nav>
		</header>

		<main class="content-print appross bg-light">
			<div class="appross logo">
				<img src="{{ asset('img/appross_logo.png') }}" alt="logo appross" />
			</div>
			<div class="appross panel-container">
				<div class="panel">
					<div class="title">
						<span class="arrow-right"></span>
						<span>PLANILLA DE ASISTENCIA DE INTEGRACIÓN ESCOLAR</span>
					</div>
					<div class="content">
						<div class="form">
							<div class="row">
								<div class="form-group">
									<span class="form-prepend" 
										>profesional:</span
									>
									<input id="professional" type="text" class="form-input" value="{{ Auth::user()->name . ' ' . Auth::user()->surname }}" />
								</div>
								<div class="form-group">
									<span class="form-prepend" style="padding-left: 25px;"
										>especialidad:</span
									>
									<input id="specialty" type="text" class="form-input"  value="{{ $prestador[0]->prestacion[0]->nombre }}" />
								</div>
							</div>
							<div class="row" style="padding-top: 0.5rem;">
								<div class="form-group" style="width: 15%;">
									<span class="form-prepend" 
										>mes:</span
									>
									<input id="month" type="text" class="form-input" value="{{ $mes }}" />
								</div>
								<div class="form-group" style="width: 50%;">
									<span class="form-prepend" style="padding-left: 20px"
										>direccion del establecimiento educativo:</span
									>
									<input id="address" type="text" class="form-input" value="{{ Auth::user()->direccion }}" />
								</div>
								<div class="form-group" style="width: 30%;">
									<span class="form-prepend" style="padding-left: 10px"
										>Teléfono:</span
									>
									<input id="phone" type="text" class="form-input" value="{{ Auth::user()->telefono }}" />
								</div>
							</div>
							<div class="row" style="padding-top: 0.5rem;">
								<div class="form-group">
									<span class="form-prepend" style="padding-right: 10px;"
										>nombre y apellido:</span
									>
									<input id="names" type="text" class="form-input"  value="{{ $beneficiario[0]->nombre }}" />
								</div>
								<div class="form-group" style="width: 60%">
									<span class="form-prepend" style="padding-left: 10px;"
										>n&uacute;mero de afiliado:</span
									>
									<input id="filial-number" type="text" class="form-input"  value="{{ $beneficiario[0]->numero_afiliado }}" />
								</div>
							</div>
						</div>

						<div class="table-container">
							<table
								id="table-1-aprross"
								class="table table-color table-head-clean"
							>
								<thead>
									<tr role="row">
										<th>fecha</th>
										<th class="text-start">hora ingreso</th>
										<th class="text-start">hora egreso</th>
										<th>firma y sello de profesional</th>
										<th>observaciones</th>
									</tr>
								</thead>
								<tbody>
									<?php $indices = array(); ?>
									@foreach($fechas['total'] as $key => $fecha)
										@foreach($fecha as $dia => $fechaFinal)
											<?php $fechas = explode('/', $fechaFinal); ?>
												<tr>
													<td>
														<div>
															<input style="font-size: 12px" type="text" value="{{ $fechas[0] }}">
															/
															<input style="font-size: 12px" type="text" value="{{ $fechas[1] }}">
															/
															<input style="font-size: 12px" type="text" value="{{ $fechas[2] }}">
														</div>
													</td>

													<td>
														<input style="text-align: center" type="text" value="{{ $fechas[3] }}">
													</td>

													<td>
														<input style="text-align: center" type="text" value="{{ $fechas[4] }}">
													</td>

													<td>
														<input type="text">
													</td>

													<td>
														<input type="text">
													</td>
												</tr>	
											<?php $indices[]++ ?>	
										@endforeach
									@endforeach

									@for ($i = count($indices); $i < 17; $i++)
										<tr>
											<td>
												<div>
													<input type="text">
													/
													<input type="text">
													/
													<input type="text">
												</div>
											</td>

											<td>
												<input type="text">
											</td>

											<td>
												<input type="text">
											</td>

											<td>
												<input type="text">
											</td>

											<td>
												<input type="text">
											</td>
										</tr>
									@endfor
								</tbody>
							</table>
						</div>

						<div class="panel-footer">
							<div class="info">
								<p>
									En caso de tachaduras y/o enmiendas, las mismas deberan ser
									salvadas por el director del establecimiento.
								</p>
								<p>
									Los debitos realizados en relación a la falta de datos en la
									planilla de asistencia no seran acreditados. Sin excepción.
								</p>
							</div>
							<div class="signature">
								<span class="line"></span>
								<p>Firma y Sello Directora (1vez al mes)</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="appross footer bg-dark">
				<div class="address">
					<p>Sede Central</p>
					<p>Marcelo T. de Alvear 758.</p>
					<p>Bº Güemes - Córdoba</p>
				</div>
				<div class="schedule">
					<p>Horario de atenci&oacute;n</p>
					<p>de 8:00 a 20:00 hs.</p>
				</div>
				<div class="contact">
					<p>Centro de atención al afiliado: 0800 888 2776</p>
					<p>E-mail: comunicaciones.apross@cba.gov.ar</p>
					<p>www.apross.gov.ar</p>
				</div>
			</div>
		</main>

		<script src="{{ asset('js/apross/app.js') }}"></script>
		{{-- <script>
			function createRows(rowsQty, tdQuantity) {
				var table = document.getElementById('table-1-aprross');
				var tBodyElem = table.getElementsByTagName('tbody')[0];

				for (var i = 0; i < rowsQty; i++) {
					var trElem = document.createElement('tr');
					for (var j = 0; j < tdQuantity; j++) {
						var tdElem = document.createElement('td');
						var inputElem = document.createElement('input');
						inputElem.setAttribute('type', 'text');

						if (j === 0) {
							var tdContentElem = document.createElement('div');
							var textElem = document.createTextNode('/');
							for (var k = 0; k < 2; k++) {
								var divTextElem = document.createTextNode('/');
								var divInputElem = document.createElement('input');
								divInputElem.setAttribute('type', 'text');
								tdContentElem.appendChild(divInputElem);
								tdContentElem.appendChild(divTextElem);
							}
							tdContentElem.appendChild(inputElem);
							tdElem.appendChild(tdContentElem);
							trElem.appendChild(tdElem);
							continue;
						}

						tdElem.appendChild(inputElem);
						trElem.appendChild(tdElem);
					}
					tBodyElem.appendChild(trElem);
				}
			}

			createRows(17, 5);
		</script> --}}
	</body>
</html>
