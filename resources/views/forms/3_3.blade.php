<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta http-equiv="X-UA-Compatible" content="ie=edge" />
		<title>3.3 Planilla de Asistencia Mensual – Instituciones</title>
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
				3.3 Planilla de Asistencia Mensual – Instituciones
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
					<input id="names" type="text" class="form-input" value="{{$beneficiario[0]->nombre}}" />
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
					<input id="benefit" type="text" class="form-input" value="{{$prestador[0]->prestacion[0]->nombre}}"/>
				</div>
				<div class="form-group" style="margin-top: 0.8rem;">
					<span class="form-prepend text">Turno (mañana/tarde/doble):</span>
					<input
						id="appointment"
						type="text"
						class="form-input"
						style="flex-basis: 42.5%; width: 42.5%;"
						value="{{$beneficiario[0]->turno}}"
					/>
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
			<div class="table-content container" style="margin-top: 1.5rem;">
				<table id="3.3-form-table-1" class="table">
					<thead>
						<tr>
							<th style="font-size: 1rem; font-weight: 400;">1</th>
							<th style="font-size: 1rem; font-weight: 400;">2</th>
							<th style="font-size: 1rem; font-weight: 400;">3</th>
							<th style="font-size: 1rem; font-weight: 400;">4</th>
							<th style="font-size: 1rem; font-weight: 400;">5</th>
							<th style="font-size: 1rem; font-weight: 400;">6</th>
							<th style="font-size: 1rem; font-weight: 400;">7</th>
							<th style="font-size: 1rem; font-weight: 400;">8</th>
							<th style="font-size: 1rem; font-weight: 400;">9</th>
							<th style="font-size: 1rem; font-weight: 400;">10</th>
							<th style="font-size: 1rem; font-weight: 400;">11</th>
							<th style="font-size: 1rem; font-weight: 400;">12</th>
							<th style="font-size: 1rem; font-weight: 400;">13</th>
							<th style="font-size: 1rem; font-weight: 400;">14</th>
							<th style="font-size: 1rem; font-weight: 400;">15</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							@for ($i = 1; $i < 16; $i++)
								<td style="height:37.5px">
									@php
										if($i < 10){
											$index = 0 . $i;
										}else{
											$index = $i;
										}
										$date = date('Y-m-'.$index);
										$dt1 = strtotime($date);
										$dt2 = date('l', $dt1);
										$dt3 = strtolower($dt2);
										if(isset($fechas['total'][$beneficiario[0]->id][$index])){
											$marca = 'P';
										}else if($dt3 == 'saturday'){
											$marca = 'S';
										}else if($dt3 == 'sunday'){
											$marca = 'D';
										}else if(isset($fechas['feriados'][$beneficiario[0]->id][$index])){
											$marca = 'F';
										}else if(isset($fechas['inasistencias'][$beneficiario[0]->id][$index])){
											$marca = 'A';
										}else{
											$marca = '';
										}
									@endphp
									<input type="text" id="table-input-{{$i}}" class="table-input" value="{{$marca}}">
								</td>
							@endfor
						</tr>	
					</tbody>
				</table>
			</div>

			<div class="table-content container" style="margin-top: 2rem;">
				<table id="3.3-form-table-2" class="table">
					<thead>
						<tr>
							<th style="font-size: 1rem; font-weight: 400; padding: 0;">16</th>
							<th style="font-size: 1rem; font-weight: 400; padding: 0;">17</th>
							<th style="font-size: 1rem; font-weight: 400; padding: 0;">18</th>
							<th style="font-size: 1rem; font-weight: 400; padding: 0;">19</th>
							<th style="font-size: 1rem; font-weight: 400; padding: 0;">20</th>
							<th style="font-size: 1rem; font-weight: 400; padding: 0;">21</th>
							<th style="font-size: 1rem; font-weight: 400; padding: 0;">22</th>
							<th style="font-size: 1rem; font-weight: 400; padding: 0;">23</th>
							<th style="font-size: 1rem; font-weight: 400; padding: 0;">24</th>
							<th style="font-size: 1rem; font-weight: 400; padding: 0;">25</th>
							<th style="font-size: 1rem; font-weight: 400; padding: 0;">26</th>
							<th style="font-size: 1rem; font-weight: 400; padding: 0;">27</th>
							<th style="font-size: 1rem; font-weight: 400; padding: 0;">28</th>
							<th style="font-size: 1rem; font-weight: 400; padding: 0;">29</th>
							<th style="font-size: 1rem; font-weight: 400; padding: 0;">30</th>
							<th style="font-size: 1rem; font-weight: 400; padding: 0;">31</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							@for ($i = 16; $i < 32; $i++)
								<td style="height:37.5px">
									@php
										$index = $i;

										$date = date('Y-m-'.$index);
										$dt1 = strtotime($date);
										$dt2 = date('l', $dt1);
										$dt3 = strtolower($dt2);
										if(isset($fechas['total'][$beneficiario[0]->id][$index])){
											$marca = 'P';
										}else if($dt3 == 'saturday'){
											$marca = 'S';
										}else if($dt3 == 'sunday'){
											$marca = 'D';
										}else if(isset($fechas['feriados'][$beneficiario[0]->id][$index])){
											$marca = 'F';
										}else if(isset($fechas['inasistencias'][$beneficiario[0]->id][$index])){
											$marca = 'A';
										}else{
											$marca = '';
										}
									@endphp
									<input type="text" id="table-input-{{$i}}" class="table-input" value="{{$marca}}">
								</td>
							@endfor
						</tr>	
					</tbody>
				</table>
			</div>

			<div class="form" style="margin-top: 1.5rem;">
				<div class="form-group" style="margin-top: 0.2rem;">
					<span class="form-prepend text"
						>* Se marcará con una P (Presente) las asistencias
					</span>
				</div>
				<div class="form-group" style="margin-top: 0.2rem;">
					<span class="form-prepend text"
						>* Se marcará con una A (Ausente) las inasistencias
					</span>
				</div>
				<div
					class="form-group"
					style="margin-top: 0.2rem; margin-bottom: 1.25rem;"
				>
					<span class="form-prepend text"
						>* S (Sábados) / D (Domingos) / F (Feriado) / J (Jornada)
					</span>
				</div>
				<div class="form-group" style="margin-top: 0.8rem;">
					<span class="form-prepend text"
						>Y toda aclaración que considere pertinente
					</span>
					<input id="clarify-text-1" type="text" class="form-input" />
				</div>
				<div class="form-group" style="margin: 0.2rem 0;">
					<input id="clarify-text-2" type="text" class="form-input" />
				</div>
				<div class="form-group" style="margin: 0.2rem 0;">
					<input id="clarify-text-3" type="text" class="form-input" />
				</div>
				<div class="form-group" style="margin: 0.2rem 0;">
					<input id="clarify-text-4" type="text" class="form-input" />
				</div>
			</div>

			<div class="table-content container" style="margin-top: 2rem;">
				<table id="3.3-form-table-2" class="table">
					<thead>
						<tr>
							<th class="text">Prestador</th>
							<th class="text">Paciente o responsable</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td
								style="width: 50%; height: 90px; font-size: 0.8rem; text-align: center; vertical-align: bottom;"
							>
								Firma del responsable de la institución
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
								style="width: 50%; height: 60px; font-size: 0.8rem; text-align: center; vertical-align: bottom;"
							>
								Sello de la institución
							</td>
							<td
								style="width: 50%; height: 60px; padding-left: 0.5rem; font-size: 0.8rem; vertical-align: bottom;"
							>
								Vínculo
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
		<script>
			// AppClass.createNumberThRows(
			// 	'3.3-form-table-1',
			// 	'font-size: 1rem; font-weight: 400;',
			// 	15
			// );
			// AppClass.createTableRows('3.3-form-table-1', 1, 15, [], 37.5);

			// AppClass.createNumberThRows(
			// 	'3.3-form-table-2',
			// 	'font-size: 1rem; font-weight: 400; padding: 0;',
			// 	16,
			// 	15
			// );
			// AppClass.createTableRows('3.3-form-table-2', 1, 16, [], 37.5);
		</script>
	</body>
</html>
