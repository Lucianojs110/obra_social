@foreach($informacion as $k => $benefs)
	@include('forms.asistencia_traslado', ['beneficiarios' => $benefs])
@endforeach