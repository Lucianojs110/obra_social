@extends('layouts.app')



@section('content')

<div>

    <div class="login-box" style="width: 600px !important">

        <div class="login-box-body bg-purple">

                <p class="login-box-msg"><b>Registrarse en el Sistema - Diseño pendiente</b></p>

                    <form method="POST" action="{{ route('register') }}">

                        @csrf



                        <div class="form-group row">

                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>



                            <div class="col-md-6">

                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>



                                @error('name')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                            </div>

                        </div>



                        <div class="form-group row">

                            <label for="surname" class="col-md-4 col-form-label text-md-right">{{ __('Apellido') }}</label>



                            <div class="col-md-6">

                                <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname') }}" required autocomplete="surname" autofocus>



                                @error('surname')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                            </div>

                        </div>



                        <div class="form-group row">

                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Direccion E-Mail') }}</label>



                            <div class="col-md-6">

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">



                                @error('email')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                            </div>

                        </div>



                        <div class="form-group row">

                            <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Rol') }}</label>



                            <div class="col-md-6">

                                <select id="role" type="text" class="form-control @error('role') is-invalid @enderror" name="role" value="{{ old('role') }}" required autocomplete="role" autofocus>

                                    <option value="">Seleccionar Rol</option>

                                    <option value="Traslado">Traslado</option>

                                    <option value="Institucion">Institucion</option>

                                    <option value="Prestador">Prestador - Profesional Individual</option>

                                </select>



                                @error('role')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                            </div>

                        </div>



                        <div class="form-group row">

                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>



                            <div class="col-md-6">

                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">



                                @error('password')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                            </div>

                        </div>



                        <div class="form-group row">

                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar Contraseña') }}</label>



                            <div class="col-md-6">

                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                            </div>

                        </div>
                        <?php if(file_exists('public/uploads/contrato/contrato.pdf')){ ?>
  <div class="form-group row mb-0">

                            <div class="col-md-12 offset-md-4">
                        <input type="checkbox" id="contrato" name="contrato" value="1" required> Aceptar Términos y Condiciones (<a href="public/uploads/contrato/contrato.pdf" target="_blank" style="color:white;">LEER TERMINOS Y CONDICIONES</a>)
                        </div>

                        </div>
                          <?php } ?>

                        <div class="form-group row mb-0">

                            <div class="col-md-6 offset-md-4">

                                <button type="submit" class="btn btn-primary">

                                    {{ __('Register') }}

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

@endsection

