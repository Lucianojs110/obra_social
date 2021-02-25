@extends('layouts.appfactura')
@section ('contenido')
<div class="row justify-content-center align-items-center">
	<div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
		<h3>Listado Facturas Electronicas</h3>
       
            <h1>
               {{-- Ingrese el Cuil o Cuit de la obra social --}}
                <h4>
                    Prestador: {{ Auth::user()->name . ' ' . Auth::user()->surname }}
                </h4>
            </h1>
    
            {{-- <div style="padding-top: 15px">
                @include('includes.message')
            </div>
    
            <ol class="breadcrumb">
                <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
                <li class="active">Factura Previa</li>
            </ol> --}}
    
    
		<div class="progress" style="height: 2px;"></div>
	</div>
</div>
</br>
    <section class="content">
        <div class="row">
            <div class="col-12 col-md-8 col-lg-6">
                <form action="{{ URL::action('CertificadosController@store') }}" files="true" method="post" enctype="multipart/form-data">
                    {!!csrf_field()!!}
                   
                        {{-- <div class="form-group col-md-2">
                            <label>Nombre del Proveedor</label>
                            <input required type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" >
                        </div> --}}
                        
                        <div class="row">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                Ingresar CERTIFICADO .key
                                </div>
                                <div class="panel-body">
                                    <label for=""> .Key </label>
                                    <input type="file" id="archivocrt" name="archivokey" class="form-control" />
                                    <div  id="errorarchivo" style="display:none;color:#CC0000;font-size: 13px">Valor obligatorio.</div>
                                </div>
                            </div>
                        

                       
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                Ingresar CERTIFICADO .Crt
                                </div>
                                <div class="panel-body">
                                    <label for=""> .Crt </label>
                                 <input type="file" id="archivocrt" name="archivocrt" class="form-control" />
                                 <div  id="errorarchivo" style="display:none;color:#CC0000;font-size: 13px">Valor obligatorio.</div>
                                </div>
                            </div>
                        

                       
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
                            
                            {{-- <a href="{{route('suppliers.index')}}" class="btn btn-primary form-control">Volver</a> --}}
                        </div>
                        <div class="form-group col-md-6">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-success form-control">Guardar</button>
                        </div>
                    
                </form>
            </div>
        
	
			
		


    </section>
</div>
@endsection
