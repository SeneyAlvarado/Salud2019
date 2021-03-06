<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Servicio de Salud</title>

    <link rel="stylesheet" type="text/css" href="{{asset('css/paneles.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/menuPrincipal.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="icon" src="{{asset('Imagenes/icono_pestanna.png')}}" type="image/png">
</head>

<body class="a" style="background-color:#F4F4F4;">
    <div id="app" class="contenido">
        <nav class="navbar navbar-default navbar-static-top bg-color-panel">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed color" style="color:#FFFFFF"
                        data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar color"></span>
                        <span class="icon-bar color"></span>
                        <span class="icon-bar color"></span>
                    </button>

                    <!-- Branding Image -->
                    <div class="logo-nombre">
                        <a href="{{ url('/') }}"><img class="img-responsive logo-nombre" style="margin-top: 10px;"
                            src="{{asset('Imagenes/logo_nombre_ucr.png')}}"></a>
                    </div>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->


                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                        <li><a style="color: #FFFFFF; text-align: center" href="{{ route('login') }}">Ingresar
                                <span class="glyphicon glyphicon-log-in" style="margin-left: 2px;"></a></li>
                        <li><a style="color: #FFFFFF; text-align: center" href="{{ route('register') }}">Registrarse<span
                            class="glyphicon glyphicon-user"  style="margin-left: 5px;"></a>
                        </li>
                        @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-expanded="false" aria-haspopup="true" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
<footer class="main-footer">
    <div class="text-center main-footer">
        <img style="margin-top: 4px;" class="margin-logo" src="{{asset('Imagenes/logo-so-blc.png')}}">
        <img style="margin-top: 4px; width:8em; height:4.5em;" class="margin-logo"
            src="{{asset('Imagenes/cve_ss_logo.png')}}"> </div>
</footer>

</html>