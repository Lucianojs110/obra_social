@extends('layouts.app', ['prestador' => $prestador_menu])
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Carga Inicial de Certificados
            <h4>
                Prestador: {{ Auth::user()->name . ' ' . Auth::user()->surname }}
            </h4>
        </h1>

        <div style="padding-top: 15px">
            @include('includes.message')
        </div>

        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Certificados</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12 col-md-8 col-lg-6">
                <form action="{{-- {{route('facturacion.electronica.cert.generate')}} --}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Generar Archivo de Solicitud para AFIP
                        </div>
                        <div class="panel-body">
                            {{-- @if (isset($certs_info->key_path))
                                <small class="text-success">Ya se encuentra cargado un certificado</small>
                            @endif --}}
                            {{-- <div class="form-control px-0" style="border: none;">
                                <div class="input-group">
                                    <input type="file" name="key" id="file" placeholder="Seleccionar Certificado">
                                </div>
                            </div> --}}
                            <div style="margin-bottom: 14px;">Presione el boton Generar para descargar su archivo de solicitud en AFIP.</div>
                        </div>
                        <div class="panel-footer">
                            <div class="text-right">
                                <button type="submit" class="btn btn-sm btn-primary">Generar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-12 col-md-8 col-lg-6">
                <form action="{{-- {{route('facturacion.electronica.certificado.store')}} --}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Cargar certificado
                        </div>
                        <div class="panel-body">
                            {{-- @if (isset($certs_info->cert_path))
                                <small class="text-success">Ya se encuentra cargado un certificado</small>
                            @endif --}}
                            <div class="form-control px-0" style="border: none;">
                                <div class="input-group">
                                    <input type="file" name="certificado" id="file" placeholder="Seleccionar Certificado">
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="text-right">
                                <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-12 col-md-8 col-lg-6">
                <form action="{{-- {{route('facturacion.electronica.certificado.store')}} --}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Punto de Venta
                        </div>
                        <div class="panel-body">
                            {{-- @if (isset($certs_info->cert_path))
                                <small class="text-success">Ya se encuentra cargado un certificado</small>
                            @endif --}}
                            <div class="form-control px-0" style="border: none;">
                                <div class="input-group">
                                    {{-- <label for="ptoventa" class="form-check-label">Pto de Venta (*)</label> --}}
    		                        <input type="number" name="ptoventa" id="ptoventa" class="form-control" required value="{{old('ptoventa')}}">
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="text-right">
                                <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
       {{--  @if ($certs) --}}
            <div class="row">
                <div class="col-sm-12">
					<form action="{{route('facturacion.electronica.update')}}" method="POST">
						@csrf
						@method('POST')
						<div class="panel panel-default">
							<div class="panel-heading">
								Información de Facturación Electrónica
							</div>
							<div class="panel-body">
                                <div class="col-sm-12">
                                    <span>Los datos marcados con asterisco (*) son necesarios para facturar electronicamente.</span>
                                </div>

								<div class="col-sm-4 py-3">
									Tipos de comprobantes *
									<div class="form-control px-0" style="border: none;">
										<select name="tipo_comprobante" class="form-control">
											<option value="">Seleccionar...</option>
											{{-- @foreach ($fe_info['voucher_types'] as $comprobante)
												<option value="{{$comprobante->Id}}" {{$certs_info['tipo_comprobante'] == $comprobante->Id ? 'selected' : ''}}>{{$comprobante->Desc}}</option>
											@endforeach --}}
										</select>
									</div>
								</div>
								<div class="col-sm-4 py-3">
                                    Tipos de conceptos *
									<div class="form-control px-0" style="border: none;">
										<select name="concepto" class="form-control">
											<option value="">Seleccionar...</option>
											{{-- @foreach ($fe_info['concept_types'] as $concepto)
												<option value="{{$concepto->Id}}" {{$certs_info['concepto'] == $concepto->Id ? 'selected' : ''}}>{{$concepto->Desc}}</option>
											@endforeach --}}
										</select>
									</div>
								</div>
								<div class="col-sm-4 py-3">
									Tipos de documentos *
									<div class="form-control px-0" style="border: none;">
										<select name="tipo_documento" class="form-control">
											<option value="">Seleccionar...</option>
											{{-- @foreach ($fe_info['document_types'] as $documento)
												<option value="{{$documento->Id}}" {{$certs_info['tipo_documento'] == $documento->Id ? 'selected' : ''}}>{{$documento->Desc}}</option>
											@endforeach --}}
										</select>
									</div>
								</div>
								<div class="col-sm-4 py-3">
									Tipos de alicuotas *
									<div class="form-control px-0" style="border: none;">
										<select name="tipo_alicuota" class="form-control">
											<option value="">Seleccionar...</option>
											{{-- @foreach ($fe_info['aliquote_types'] as $alicuota)
												<option value="{{$alicuota->Id}}" {{$certs_info['tipo_alicuota'] == $alicuota->Id ? 'selected' : ''}}>{{$alicuota->Desc}}</option>
											@endforeach --}}
										</select>
									</div>
								</div>
								<div class="col-sm-4 py-3">
									Tipos de monedas *
									<div class="form-control px-0" style="border: none;">
										<select name="moneda_id" class="form-control">
											<option value="">Seleccionar...</option>
											{{-- @foreach ($fe_info['currency_types'] as $moneda)
												<option value="{{$moneda->Id}}" {{$certs_info['moneda_id'] == $moneda->Id ? 'selected' : ''}}>{{$moneda->Desc}}</option>
											@endforeach --}}
										</select>
									</div>
								</div>
								<div class="col-sm-4 py-3">
									Tipos de tributos *
									<div class="form-control px-0" style="border: none;">
										<select name="tipo_tributo" class="form-control">
											<option value="">Seleccionar...</option>
											{{-- @foreach ($fe_info['tax_types'] as $tributo)
												<option value="{{$tributo->Id}}" {{$certs_info['tipo_tributo'] == $tributo->Id ? 'selected' : ''}}>{{$tributo->Desc}}</option>
											@endforeach --}}
										</select>
									</div>
								</div>
								<div class="col-sm-4 py-3">
									Tipos de opciones disponibles para el comprobante
									<div class="form-control px-0" style="border: none;">
										<select name="tipo_opcion" class="form-control">
											<option value="">Seleccionar...</option>
											{{-- @foreach ($fe_info['option_types'] as $opcion)
												<option value="{{$opcion->Id}}" {{$certs_info['tipo_opcion'] == $opcion->Id ? 'selected' : ''}}>{{$opcion->Desc}}</option>
											@endforeach --}}
										</select>
									</div>
								</div>
							</div>
							<div class="panel-footer">
								<div class="text-right">
									<button type="submit" class="btn btn-sm btn-primary">Guardar</button>
								</div>
							</div>
						</div>
					</form>
                </div>
            </div>
        {{-- @endif --}}
    </section>
</div>
@endsection
