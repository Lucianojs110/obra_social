@foreach($informacion as $k => $benefs)
	@include('forms.facturacion_traslado', ['beneficiarios' => $benefs])
@endforeach