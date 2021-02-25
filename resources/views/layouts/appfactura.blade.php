<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{-- Sistema de Facturacion Electronica --}}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    

  

    
    <!-- Script para el ojito NOTA CREDITO-->
{{--     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' type='text/javascript'></script> --}}
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"> </script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"> </script>



    <!-- Bootstrap 3 -->
    <link rel="stylesheet" media="all" href="{{asset('adminfact/css/bootstrap.min.css')}}">

    <link rel="stylesheet" href="{{asset('adminfact/css/bootstrap-select.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('adminfact/css/font-awesome.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" media="all" href="{{asset('adminfact/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" media="all" href="{{asset('adminfact/css/_all-skins.min.css')}}">
    <link rel="apple-touch-icon" href="{{asset('adminfact/img/apple-touch-icon.png')}}">
    <link rel="shortcut icon" href="{{asset('adminfact/img/favicon.ico')}}">
    <link rel="stylesheet" href="{{asset('adminfact/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('adminfact/plugins/datepicker/css/bootstrap-datepicker3.css')}}">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('adminfact/plugins/DataTables-1.10.16/css/dataTables.bootstrap.css') }}" />
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('adminfact/plugins/DataTables-1.10.16/css/jquery.dataTables.min.css') }}" />
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('adminfact/plugins/bootstrap-fileinput-3540936/css/fileinput.min.css') }}"/>
    @stack('styles')
</head>


<body class="hold-transition skin-purple sidebar-mini">
    <div class="wrapper">

        <header class="main-header">

            <!-- Logo -->
            <a href="{{-- {{URL::action('HomeController@index')}} --}}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">
                    <b></b>
                </span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">
                    <b>DORITA 365
                    </b>
                </span>

            </a>

            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Navegación</span>
                    <b> </b>
                </a>

                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->

                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-circle" style="color:lawngreen"></i>
                                <span class="hidden-xs"></span>{{ substr(Auth::user()->role, 0, 1).Auth::user()->id.' '.Auth::user()->name . ' ' . Auth::user()->surname}}
                              {{--  <span class="hidden-xs"></span> USUARIO: GABRIEL GOMEZ --}}
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    {{-- <p>
                    DEPENDENCIA
                  </p>  --}}
                                </li>

                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        {{-- <a class="btn btn-sm btn-default btn-flat" href="{{ URL::action('UsuariosController@cambiarPass')}}">Cambiar Contraseña</a> --}}
                                    </div>
                                    {{-- <div class="pull-right">
                                        <form method="post" action="{{ URL::action('Auth\LoginController@logout') }}">
                                            @csrf
                                            <button class="btn btn-sm btn-default btn-flat">Cerrar Session</button>
                                        </form>
                                    </div> --}}
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>

            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->

                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">
                    <li class="header"></li>

                   {{--  @can('administrador')  --}}

                    <ul class="treeview-menu">
                        {{-- <li class="{{Request::is('usuarios', 'usuarios/*') ? 'active' : '' }}"><a href="{{URL::action('UsuariosController@index')}}"><i class="fa fa-circle-o"></i>Usuarios</a></li>
                        <li class="{{Request::is('roles','roles/*') ? 'active' : '' }}"><a href="{{URL::action('RolesController@index')}}"><i class="fa fa-circle-o"></i>Roles y Permisos</a></li> --}}
                      </ul>
                    </li>

                    <li class="treeview {{Request::is('dependencias', 'dependencias/*') ? 'active' : '' }}">
                        <a href="{{ route('home') }}">
                            <i class="fa fa-home"></i>
                            <span>Prestador</span>
                        </a>
                        
                    </li>
                    

                     <li class="treeview {{Request::is('dependencias', 'dependencias/*') ? 'active' : '' }}">
                        <li>
                            <a href="{{ route('datos-prestador') }}">
                                <i class="fa fa-user"></i>
                                <span>Añadir O. Social/Prestación</span>
                            </a>
                        </li>
                        
                    </li>
                    <li class="treeview {{Request::is('dependencias', 'dependencias/*') ? 'active' : '' }}">
                        <li>
                            <a href="{{ action('CertificadosController@index') }}">
                                <i class="fa fa-address-card"></i>
                                <span>Certificados</span>
                            </a>
                        </li>
                        
                    </li>

                  {{--   <li class="treeview {{Request::is('showtree') ? 'active' : '' }}">
                        <a href="{{URL::action('DependenciasController@showtree')}}">
                            <i class="fa fa-eye"></i>
                            <span>Organigrama</span>
                        </a>
                    </li> --}}
                   {{--  <li class="treeview {{Request::is('niveles', 'niveles/*') ? 'active' : ''}}"> --}}
                        {{-- <a href="{{URL::action('NivelesController@index')}}">
                            <i class="fa fa-wrench"></i>
                            <span>Niveles</span>
                        </a> --}}
                    {{-- </li> --}}
                   {{--  <li class="treeview {{Request::is('usuarios', 'usuarios/*', 'roles','roles/*') ? 'active' : '' }}"> --}}
                        {{-- <a href="{{URL::action('UsuariosController@index')}}">
                            <i class="fa fa-wrench"></i>
                            <span>Usuarios</span>
                        </a> --}}
                  {{--   </li> --}}
                    {{-- <li class="treeview {{Request::is('feriados', 'feriados/*') ? 'active' : '' }}">
                        <a href="{{URL::action('FeriadosController@index')}}">
                            <i class="fa fa-wrench"></i> Feriados
                        </a>--}}
                    </li>
                    {{--  @endcan  --}}

                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>


        <!--Contenido-->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Main content -->
            <section class="content">

                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <!--  <div class="box-header with-border">

              </div>-->
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <!--Contenido-->
                                        @Yield ('contenido')
                                        <!--Fin Contenido-->
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!--Fin-Contenido-->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <strong>Copyright &copy; {{date('Y')}} Porcal Adrian Martin</strong> .
        </div>
        Todos los derechos reservados. <a href="public/uploads/contrato/contrato.pdf" target="_blank">Términos y condiciones</a>
            
        </strong>
    </footer>

    <script src="{{asset('adminfact/js/jspdf/jspdf.js')}}"></script>
    <script src="{{asset('adminfact/js/jspdf/jquery-2.1.3.js')}}"></script>
    <script src="{{asset('adminfact/js/jspdf/pdfFromHTML.js')}}"></script>

    <!-- jQuery 2.1.4 -->
    <script src="{{asset('adminfact/js/jQuery-2.1.4.min.js')}}"></script>
    <!-- Bootstrap 3 -->
    <script src="{{asset('adminfact/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('adminfact/js/bootstrap-select.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('adminfact/js/app.min.js')}}"></script>
    <script src="{{asset('adminfact/js/select2.full.min.js')}}"></script>
    <script src="{{asset('adminfact/plugins/datepicker/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('adminfact/plugins/datepicker/locales/bootstrap-datepicker.es.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('adminfact/plugins/DataTables-1.10.16/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('adminfact/plugins/DataTables-1.10.16/js/dataTables.bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('adminfact/plugins/DataTables-1.10.16/dataTables.plugins.js') }}"></script>
    <script type="text/javascript" src="{{ asset('adminfact/plugins/Buttons-1.5.1/js/dataTables.buttons.js') }}"></script>
    <script type="text/javascript" src="{{ asset('adminfact/plugins/Buttons-1.5.1/js/jszip.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('adminfact/plugins/Buttons-1.5.1/js/buttons.html5.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('adminfact/plugins/jquery.mask.js') }}"></script>

    @stack('scripts')



</body>

</html>
