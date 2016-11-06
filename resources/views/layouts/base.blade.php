<?php
//Obtener el identificador de la vista declarado en routes.php con as en el array
$vista = Route::currentRouteName();
$current = array('access' => '','login' => '','registrar' => '','consultar' => '','visitas' => '','actualizar' => '','reporte' => '');
    if( $vista == 'access') {
         $current['access'] = 'active';
    }
    else if( $vista == 'auth/login') {
         $current['login'] = 'active';
    }
    else if( $vista == 'registrar/visita' or $vista == 'registrar/usuario') {
         $current['registrar'] = 'active';
    }
   else if( $vista == 'consultar/visitantes' or $vista == 'consultar/visitas' or $vista == 'consultar/usuarios') {
         $current['consultar'] = 'active';
    }
    else if( $vista == 'usuarioVisitas') {
         $current['consultar'] = 'active';
    }
     else if( $vista == 'actualizar') {
         $current['consultar'] = 'active';
    }
    else if( $vista == 'reporte') {
         $current['reporte'] = 'active';
    }
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>

    <title>@yield('title', 'Libro de visitas')</title>

    <!-- Bootstrap Core CSS -->
    {!! Html::style('css/bootstrap.css') !!}

    <!-- Custom CSS -->
    {!! Html::style('css/modern-business.css') !!}

    <!-- Custom Fonts -->
    {!! Html::style('font-awesome/css/font-awesome.min.css') !!}

    <!-- Custom DatePicker -->
    {!! Html::style('datepicker/css/bootstrap-datepicker3.css') !!}
    {!! Html::style('datepicker/css/bootstrap-datepicker.standalone.css') !!}

    <!-- CSS extended -->
    {!! Html::style('css/bootstrap-dialog.min.css') !!}
    {!! Html::style('css/main.css') !!}
    <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Playfair+Display' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top"  role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <?php 
                    if (Auth::check()) {
                    ?>
                        <a class="navbar-brand" href="{{URL::to('/home')}}"><i class="fa fa-book book-app"></i> <span class='link-text'>Libro de Visitas</span></a>
                    <?php
                    }else{
                    ?>
                        <a class="navbar-brand" href="{{URL::to('/')}}"><i class="fa fa-book book-app"></i> <span class='link-text'>Libro de Visitas</span></a>
                    <?php
                    }
                ?>

                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                    

                    <?php 
                    if (Auth::check() and Auth::user()->rol == 2) {
                    ?>
                    <li class="{{$current['registrar']}}">
                        <a href="{{URL::to('registrar/visita')}}"><i class="fa fa-pencil-square-o"></i> Registrar</a>
                    </li>
                    <li class="dropdown {{$current['consultar']}}">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-search"></i> Consultar <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{URL::to('consultar/visitas')}}"><i class="fa fa-eye"></i> Visitas</a>
                            </li>
                            <li>
                                <a href="{{URL::to('consultar/visitantes')}}"><i class="fa fa-book" aria-hidden="true"></i> Visitantes</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class='acount-user'><i class="fa fa-user"></i> {!! Auth::user()->email !!}<b class="caret"></b></span></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href=""><i class="fa fa-archive"></i> Mis datos</a>
                            </li>
                            <li>

                                <a href="{{URL::to('auth/logout')}}"><i class="fa fa-sign-out"></i> Salir</a>
                            </li>
                        </ul>
                    </li>
                    <?php
                    } 
                    elseif (Auth::check() and Auth::user()->rol == 1) {
                    ?>
                    <li class="{{$current['registrar']}}">
                        <a href="{{URL::to('registrar/usuario')}}"><i class="fa fa-pencil-square-o"></i> Registrar</a>
                    </li>
                    <li class="dropdown {{$current['consultar']}}">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-search"></i> Consultar <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{URL::to('consultar/visitas')}}"><i class="fa fa-eye"></i> Visitas</a>
                            </li>
                            <li>
                                <a href="{{URL::to('consultar/visitantes')}}"><i class="fa fa-book" aria-hidden="true"></i> Visitantes</a>
                            </li>
                            <li>
                                <a href="{{URL::to('consultar/usuarios')}}"><i class="fa fa-users"></i> Usuarios</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class='acount-user'><i class="fa fa-user"></i> {!! Auth::user()->email !!}<b class="caret"></b></span></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href=""><i class="fa fa-archive"></i> Mis datos</a>
                            </li>
                            <li>

                                <a href="{{URL::to('auth/logout')}}"><i class="fa fa-sign-out"></i> Salir</a>
                            </li>
                        </ul>
                    </li>
                    <?php
                    }
                    else
                    {
                    ?>
                        <li class="{{$current['login']}}">
                            <a href="{{URL::to('auth/login')}}"><i class="fa fa-user"></i> Login</a>
                        </li>
                    <?php
                     }
                    ?>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    @yield('Carousel')

    <!-- Page Content -->
    <div class="container-fluid" id="scrollToHere">
        <div class="oculto" id="base-url" data-url="{{ URL::to('/') }}"></div>

        @yield('content')

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2014</p>
                </div>
            </div>
        </footer>

    </div>

    <!-- Modal Loanding -->
    @include('layouts.Loanding')

    <!-- /.container -->

    <!-- jQuery -->
    {!! Html::script('js/jquery.js') !!}

    <!-- Bootstrap Core JavaScript -->
    {!! Html::script('js/bootstrap.min.js') !!}

    <!-- Script to Activate the Carousel -->
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>

    {!! Html::script('js/jquery.validate.1.14.0.min.js') !!}
    
    {!! Html::script('js/additional-methods.js') !!}
    {!! Html::script('js/ScriptCam/swfobject.js') !!}
    {!! Html::script('js/ScriptCam/scriptcam.js') !!}
    {!! Html::script('js/callScriptCam.js') !!}
    {!! Html::script('datepicker/js/bootstrap-datepicker.js') !!}
    {!! Html::script('js/main.js') !!}
    {!! Html::script('js/functions.js') !!}
    {!! Html::script('js/bootstrap-dialog.min.js') !!}

    <!-- Lenguaje -->
    {!! Html::script('js/messages_es.js') !!}
    {!! Html::script('datepicker/locales/bootstrap-datepicker.es.min.js') !!}

</body>

</html>