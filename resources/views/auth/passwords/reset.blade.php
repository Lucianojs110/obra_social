@extends('layouts.app')



@section('content')

<div>



  <div class="login-box" style="width: 600px !important;height: 400px;">
    <div class="login-box-body bg-purple">
 <p class="login-box-msg"><b>{{ __('Resetear Contraseña') }}</b></p>

            <div class="card">

               



                <div class="card-body">

                    <form method="POST" action="{{ route('password.update') }}">

                        @csrf



                        <input type="hidden" name="token" value="{{ $token }}">



                        <div class="form-group row">

                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Dirección de E-Mail') }}</label>



                            <div class="col-md-6">

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>



                                @error('email')

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

                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar contraseña') }}</label>



                            <div class="col-md-6">

                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                            </div>

                        </div>


   <div class="form-group row mb-0">

                            <div class="text-center">

                                <button type="submit" class="btn btn-primary">

                                    {{ __('Resetear contraseña') }}

                                </button>
                                 <a style="color: white" class="btn btn-link" href="{{ route('login') }}">

                                  {{ __('Ingresar') }}

                              </a> 

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

