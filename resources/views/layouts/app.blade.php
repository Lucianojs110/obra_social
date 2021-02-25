<!doctype html>
<html lang="en">
<head>

    <meta name="google" content="notranslate" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>


    <!-- jQuery 3 -->
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>

        <!-- Multiselect -->
    <script src="{{ asset('js/jquery.multi-select.js')}}"></script>

    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <!-- AdminLTE -->
    <script src="{{ asset('js/adminlte.js')}}"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/DataTables-1.10.16/css/dataTables.bootstrap.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap-fileinput-3540936/css/fileinput.min.css') }}">

    <!-- FastClick -->
    <script src="{{ asset('bower_components/fastclick/lib/fastclick.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-bs/js/responsive.bootstrap.min.js') }}"></script>
     <!-- SweetAlert 2 -->
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.all.js') }}"></script>

	<!-- InputMask -->
    <script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script src="{{ asset('plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>

	<!-- jQueryNumber -->
    <script src="{{ asset('plugins/jQueryNumber/jquery-number.js') }}"></script>

	<!-- By default SweetAlert2 doesn't support IE. To enable IE 11 support, include Promise polyfill:-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>

	<!--DatePicker-->
    <script src="{{ asset('bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

	<!--Morris chart-->
    <script src="{{ asset('bower_components/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('bower_components/morris.js/morris.min.js') }}"></script>

	<!--ChartJS-->
    <script src="{{ asset('bower_components/chart.js/Chart.js') }}"></script>

    <script src="{{ asset('bower_components/jquery-mask/jquery.mask.js') }}"></script>
    <!-- OS -->
	<script src="{{ asset('js/os.js') }}"></script>

	<!-- Select2 -->
	<script src="{{ asset('bower_components/select2/dist/js/select2.min.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">

    <!-- AdminLTE -->
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">

    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- AdminLTE Skins -->
    <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/responsive.bootstrap.min.css') }}">

    <!--DatePicker-->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">

    <!--Morris chart-->
	<link rel="stylesheet" href="{{ asset('bower_components/morris.js/morris.css') }}">

	<!-- Select2 -->
	<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.css') }}">

</head>
<body class="hold-transition skin-purple sidebar-collapse sidebar-mini">
    <div id="app">
        @auth
            <div class="wrapper">
            {{-- Header --}}
            <header class="main-header">
               <!--Logo-->
                <a href="{{ route('home') }}" class="logo">
                    <!-- logo normal -->
                    <span class="logo-lg">
                            <p>DORITA365</p>
                    </span>
                </a>

                <!--=====================================
                BARRA DE NAVEGACIÓN
                ======================================-->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Botón de navegación -->
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <!-- perfil de usuario -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <span><b>{{ substr(Auth::user()->role, 0, 1).Auth::user()->id.' '.Auth::user()->name . ' ' . Auth::user()->surname}}</b></span>
                                </a>
                                <!-- Dropdown-toggle -->
                                <ul class="dropdown-menu">
                                    <li class="user-body">
                                        <div class="pull-right">
                                            <a class="dropdown-item btn btn-default" href="{{ route('pass') }}"
                                           >
                                            {{ __('Cambiar contraseña') }}
                                            </a>

                                  
                                        </div>
                                    </li>
                                     <li class="user-body">
                                        <div class="pull-right">
                                            <a class="dropdown-item btn btn-default" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ __('Salir') }}
                                            </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

            {{-- Sidebar --}}
            <aside class="main-sidebar">
                 <section class="sidebar">
                    <ul class="sidebar-menu">
                        <li class="active">
                            <a href="{{ route('home') }}">
                                <i class="fa fa-home"></i>
                                <span>Prestador</span>
                            </a>
                        </li>

						@if(Auth::user()->role != "Administrador")
                            <li>
                                <a href="{{ route('datos-prestador') }}">
                                    <i class="fa fa-user"></i>
                                    <span>Añadir O. Social/Prestación</span>
                                </a>
                            </li>
                        <li class="treeview">
                            <a href="Javascript:void(0)">
                                <i class="fa fa-users"></i>
                                <span>Adm. beneficiarios</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                @foreach($prestador as $key=>$prest)
                                    <li>
                                        <a href="{{ route('beneficiarios', ['prestador_id' => Auth::user()->id, 'obrasocial_id' => $prest->id]) }}">
                                            <i class="fa fa-circle-o"></i>
                                            <span>{{ $prest->nombre }}</span>
                                        </a>
                                    </li>
								@endforeach
								<li>
									<a href="{{ route('beneficiarios.inactivos', ['prestador_id' => Auth::user()->id]) }}">
										<i class="fa fa-circle-o"></i>
										<span>Beneficiarios Inactivos</span>
									</a>
								</li>
                            </ul>
                        </li>
                        @endif

                        @if(Auth::user()->role == "Administrador")
                            <li>
                                <a href="{{ route('obra-social') }}">
                                    <i class="fa fa-wrench"></i>
                                    <span>Obra Social</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('prestaciones') }}">
                                    <i class="fa fa-ambulance"></i>
                                    <span>Prestaciones</span>
                                </a>
							</li>

							<li>
								<a href="{{ route('feriados') }}">
									<i class="fa fa-calendar"></i>
									<span>Feriados</span>
								</a>
							</li>

                            <li>
                                <a href="{{ route('admin-users') }}">
                                    <i class="fa fa-user-circle-o"></i>
                                    <span>Usuarios</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('contrato') }}">
                                    <i class="fa fa-file-pdf-o"></i>
                                    <span>Contrato</span>
                                </a>
                            </li>
                        @endif

                            <li>
                                <a href="{{ route('video-tutorials') }}">
                                    <i class="fa fa-youtube-play"></i>
                                    <span>Video Tutoriales</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ action('CertificadosController@index') }}">
                                    <i class="fa fa-address-card"></i>
                                    <span>Certificados AFIP</span>
                                </a>
                            </li>
                            <li class="treeview"><a href="Javascript:void(0)">
                                <i class="fa fa-envelope-open-o"></i>
                                <span>Adm. mensajes</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                                <ul class="treeview-menu">
                                    <li>
                                        <a href="{{ route('mensajes') }}">
                                            <i class="fa fa-paper-plane"></i>
                                            <span>Mensajes enviados</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('mensajes-recibidos') }}">
                                            <i class="fa fa-reply"></i>
                                            <span>Mensajes recibidos</span>
                                        </a>
                                    </li>
                                    
                                </ul>
                            </li>
                    </ul>
                 </section>
            </aside>
        @endauth

            {{-- Content --}}
            <main>
                @yield('content')
            </main>
    @auth
        {{-- Footer --}}
        <footer class="main-footer">
            <strong>Copyright &copy; {{date('Y')}} Porcal Adrian Martin</strong> .

            Todos los derechos reservados. <a href="public/uploads/contrato/contrato.pdf" target="_blank">Términos y condiciones</a>
        </footer>
    @endauth
    </div>
</div>
<script>
    // Sidebar
    $(document).ready(function(){
        $('.sidebar-menu').tree()
    });
</script>
</body>
</html>
