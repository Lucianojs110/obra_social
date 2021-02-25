@foreach($informacion as $k => $benefs)
	@include('forms.facturacion_prof_instit', ['beneficiarios' => $benefs])
@endforeach