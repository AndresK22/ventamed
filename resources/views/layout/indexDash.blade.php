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
    <nav>
        <div class="nav-wrapper indigo darken-1">
            <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        </div>
    </nav>

    <ul id="slide-out" class="sidenav sidenav-fixed blue-grey lighten-3">
        <li><div class="user-view">
            <!-- <div class="background">
                <img src="images/office.jpg">
            </div> -->
            <p><span class="name">{{ auth()->user()->name }}</span></p>
            <p><span class="email">{{ auth()->user()->email }}</span></p>
        </div></li>

        @role('administrador')
            <li class="{{ request()->routeIs('user.*') ? 'active': '' }}"><a class="waves-effect" href="{{ route('user.index') }}"><i class="material-icons">group</i>Usuarios</a></li>
        @endrole

        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <li><a href="#" onclick="this.closest('form').submit()">Cerrar sesion</b></li>
        </form>
        <li><div class="divider"></div></li>

        @hasanyrole('administrador|gerente')
            <li class="{{ request()->routeIs('medicamento.*') ? 'active': '' }}"><a class="waves-effect" href="{{ route('medicamento.index') }}"><i class="material-icons">local_hospital</i>Medicamentos</a></li>
        @endhasanyrole

        <li class="{{ request()->routeIs('entrada.*') ? 'active': '' }}"><a class="waves-effect" href="{{ route('entrada.create') }}"><i class="material-icons">local_shipping</i>Entrada de medicamentos</a></li>
        <li class="{{ request()->routeIs('salida.*') ? 'active': '' }}"><a class="waves-effect" href="{{ route('salida.index') }}"><i class="material-icons">attach_money</i>Salida de medicamentos</a></li>
        
        @hasanyrole('administrador')
            <li class="{{ request()->routeIs('control.*') ? 'active': '' }}"><a class="waves-effect" href="#!"><i class="material-icons">assignment</i>Control mensual</a></li>
        @endhasanyrole
    </ul>

    <main>
        <div class="container">
            @yield('content')
        </div>
    </main>
    

    <footer class="page-footer indigo darken-1">
        <div class="container">
            <div class="row">
                <div class="col l6 s12">
                    <h5 class="white-text">Footer Content</h5>
                    <p class="grey-text text-lighten-4">You can use rows and columns here to organize your footer content.</p>
                </div>
                <div class="col l4 offset-l2 s12">
                    <h5 class="white-text">Links</h5>
                    <ul>
                        <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
                        <li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
                        <li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>
                        <li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                © 2014 Copyright Text
                <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
            </div>
        </div>
    </footer>

    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="{{ asset('js/materialize.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    @yield('js_user_page')

</body>

</html>