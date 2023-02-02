@extends('layout.indexDash')
@section('title','Crear usuario')

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
        <h3>Crear usuario</h3>
    </div>
</div>

<div class="row">
    <form class="col s12" action="{{ route('user.store') }}" method="POST">
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
            <div class="input-field col s12">
                <i class="material-icons prefix">person_pin</i>
                <select name="rol" value="{{ old('rol') }}">
                    <option value="" disabled selected>Elija un rol</option>
                    @foreach ($roles as $rol)
                        <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                    @endforeach
                </select>
                <label>Rol</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 center-align">
                <button class="btn waves-effect waves-light btn-large amber darken-3" type="submit" name="action">Registrar
                </button>
            </div>
        </div>
        
    </form>
</div>

@endsection