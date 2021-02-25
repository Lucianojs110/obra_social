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
                <form action="{{ URL::action('FacturacionController@storeCert') }}" files="true" method="post" enctype="multipart/form-data">
                    {!!csrf_field()!!}
                   
                        {{-- <div class="form-group col-md-2">
                            <label>Nombre del Proveedor</label>
                            <input required type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" >
                        </div> --}}
                        
                        <div class="col-sm-12 col-md-8 col-lg-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                Ingresar CERTIFICADO .key
                                </div>
                                <div class="panel-body">
                                {{--  @if (isset($certs_info->cert_path))
                                        <small class="text-success">Ya se encuentra cargado un certificado</small>
                                    @endif --}}
                                    <div class="form-control px-0" style="border: none;">
                                        <div class="input-group">
                                            <label class="btn btn-default btn-file col-md-12">
                                             Elegir<input type="file" style="display: none;" name="archivokey">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-8 col-lg-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                Ingresar CERTIFICADO .Crt
                                </div>
                                <div class="panel-body">
                                {{--  @if (isset($certs_info->cert_path))
                                        <small class="text-success">Ya se encuentra cargado un certificado</small>
                                    @endif --}}
                                    <div class="form-control px-0" style="border: none;">
                                        <div class="input-group">
                                            <label class="btn btn-default btn-file col-md-12">
                                             Elegir<input type="file" style="display: none;" name="archivocrt">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-8 col-lg-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                Ingresar un Punto de Venta habilitado por AFIP
                                </div>
                                <div class="panel-body">
                                {{--  @if (isset($certs_info->cert_path))
                                        <small class="text-success">Ya se encuentra cargado un certificado</small>
                                    @endif --}}
                                    <div class="form-control px-0" style="border: none;">
                                        <div class="input-group">
                                            <input type="number" name="pto_venta" id="pto_venta" placeholder="">
                                        </div>
                                    </div>

                                </div>
                                
                                        
                                <input type="hidden" name="id_user" id="id_user" class="form-control" value="{{ Auth::user()->id }}">
                                        
                                   
                            </div>
                        </div>
                        
                        
                        <div class="form-group col-md-2">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-success form-control">Guardar</button>
                        </div>
                        <div class="form-group col-md-2">
                            <label>&nbsp;</label>
                            {{-- <a href="{{route('suppliers.index')}}" class="btn btn-primary form-control">Volver</a> --}}
                        </div>
                    
                </form>
            </div>
        
	
			
		


    </section>
</div>
@endsection
