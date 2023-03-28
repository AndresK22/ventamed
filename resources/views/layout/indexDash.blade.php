<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Fonts
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet"> -->

    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="{{ asset('css/materialize.min.css') }}"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('css/app.css') }}"  media="screen,projection"/>   

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

</head>

<body class="antialiased">

    <div class="navbar-fixed">
        <nav>
            <div class="nav-wrapper indigo darken-1">
                <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <ul class="left hide-on-med-and-down">
                    <li class="{{ request()->routeIs('dashboard') ? 'active': '' }}"><a href="{{ route('dashboard') }}">Inicio</a></li>
                    @role('administrador')
                        <li class="{{ request()->routeIs('user.*') ? 'active': '' }}"><a href="{{ route('user.index') }}">Usuarios</a></li>
                    @endrole

                    <li class="{{ request()->routeIs('medicamento.*') ? 'active': '' }}"><a href="{{ route('medicamento.index') }}">Medicamentos</a></li>
                    <li class="{{ request()->routeIs('entrada.*') ? 'active': '' }}"><a href="{{ route('entrada.create') }}">Entrada de medicamentos</a></li>
                    <li class="{{ request()->routeIs('salida.*') ? 'active': '' }}"><a href="{{ route('salida.create') }}">Salida de medicamentos</a></li>
                    <li class="{{ request()->routeIs('ventaDiaria.*') ? 'active': '' }}"><a href="{{ route('ventaDiaria.index') }}">Venta diaria</a></li>
                    
                    @hasanyrole('administrador')
                        <li class="{{ request()->routeIs('controlMensual.*') ? 'active': '' }}"><a href={{ route('controlMensual.index') }}>Reportes</a></li>
                    @endhasanyrole

                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <li><a href="#" onclick="this.closest('form').submit()">Cerrar sesion</a></li>
                    </form>
                </ul>
            </div>
        </nav>
    </div>
    
    <ul class="sidenav" id="mobile-demo">
        <li class="{{ request()->routeIs('dashboard') ? 'active': '' }}"><a href="{{ route('dashboard') }}">Inicio</a></li>
        @role('administrador')
            <li class="{{ request()->routeIs('user.*') ? 'active': '' }}"><a href="{{ route('user.index') }}">Usuarios</a></li>
        @endrole

        @hasanyrole('administrador|gerente')
            <li class="{{ request()->routeIs('medicamento.*') ? 'active': '' }}"><a href="{{ route('medicamento.index') }}">Medicamentos</a></li>
        @endhasanyrole

        <li class="{{ request()->routeIs('entrada.*') ? 'active': '' }}"><a href="{{ route('entrada.create') }}">Entrada de medicamentos</a></li>
        <li class="{{ request()->routeIs('salida.*') ? 'active': '' }}"><a href="{{ route('salida.create') }}">Salida de medicamentos</a></li>
        <li class="{{ request()->routeIs('ventaDiaria.*') ? 'active': '' }}"><a href="{{ route('ventaDiaria.index') }}">Venta diaria</a></li>
        
        @hasanyrole('administrador')
            <li class="{{ request()->routeIs('controlMensual.*') ? 'active': '' }}"><a href={{ route('controlMensual.index') }}>Reportes</a></li>
        @endhasanyrole

        <li><div class="divider"></div></li>

        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <li><a href="#" onclick="this.closest('form').submit()">Cerrar sesion</a></li>
        </form>
    </ul>


    <main>
        <div class="container">
            @yield('content')
        </div>
    </main>
    

    <footer class="page-footer indigo darken-1">
        <div class="footer-copyright">
            <div class="container">
                © 2023 
            </div>
        </div>
    </footer>

    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="{{ asset('js/materialize.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    @yield('js_user_page')

</body>

</html>