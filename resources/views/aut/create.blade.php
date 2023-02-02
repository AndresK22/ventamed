@extends('layout.index')
@section('title','Registrar usuario')

@section('navbar')
<nav>
    <div class="nav-wrapper green darken-1">
        <a href="#!" class="brand-logo center">Venta de medicina</a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        @guest
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="{{ route('login') }}">Iniciar sesion</a></li>
        </ul>
        @endguest
    </div>
</nav>

<ul class="sidenav" id="mobile-demo">
    @guest
        <li><a href="{{ route('login') }}">Iniciar sesion</a></li>
    @endguest
</ul>
@endsection

@section('content')

@if (session('status'))
<div class="row">
    <div class="col s12">
        <div class="card light-green darken-1">
        <div class="card-content white-text">
            <p>{{ session('status') }}</p>
        </div>
    </div>
</div>
@endif

@if (session('alert'))
<div class="row">
    <div class="col s12">
        <div class="card red darken-4">
        <div class="card-content white-text">
            <p>{{ session('alert') }}</p>
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col s12 center-align">
        <h3>Registrar usuario</h3>
    </div>
</div>

<div class="row">
    <form class="col s12" action="{{ route('register.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="input-field col s12">
                <i class="material-icons prefix">person</i>
                <input id="name" name="name" type="text" value="{{ old('name') }}" autofocus class="validate" required>
                <label for="name">Nombre</label>
                @if ($errors->has('name'))
                    @error('name')
                        <span class="helper-text">{{ $message }}</span>
                    @enderror    
                @endif
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <i class="material-icons prefix">email</i>
                <input id="email" name="email" type="email" value="{{ old('email') }}" class="validate" required>
                <label for="email">Correo electronico</label>
                @if ($errors->has('email'))
                    @error('email')
                        <span class="helper-text">{{ $message }}</span>
                    @enderror    
                @endif
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <i class="material-icons prefix">https</i>
                <input id="password" name="password" type="password" class="validate" required>
                <label for="password">Contrase&ntilde;a</label>
                @if ($errors->has('password'))
                    @error('password')
                        <span class="helper-text">{{ $message }}</span>
                    @enderror    
                @endif
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 center-align">
                <button class="btn waves-effect waves-light btn-large pink darken-3" type="submit" name="action">Registrar
                </button>
            </div>
        </div>
        
    </form>
</div>

@section('js_user_page')
<script type="text/javascript">
    
</script>
@endsection

@endsection