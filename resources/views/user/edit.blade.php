@extends('layout.indexDash')
@section('title','Actualizar usuario')

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
        <h3>Actualizar usuario</h3>
    </div>
</div>

<div class="row">
    <form class="col s12" action="{{ route('user.update', $user[0]->id) }}" method="POST">
        @csrf
        @method('put')
        <div class="row">
            <div class="input-field col s12">
                <i class="material-icons prefix">person</i>
                <input id="name" name="name" type="text" value="{{ old('name', $user[0]->name) }}" class="validate" required>
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
                <input id="email" name="email" type="email" value="{{ old('email', $user[0]->email) }}" class="validate" required>
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
                <i class="material-icons prefix">person_pin</i>
                <select name="rol" value="{{ old('rol', $user[0]->rolId) }}">
                    <option value="" disabled selected>Elija un rol</option>
                    @foreach ($roles as $rol)
                        <option value="{{ $rol->id }}" @if($user[0]->rolId == $rol->id) {{ 'selected' }} @endif>{{ $rol->name }}</option>
                    @endforeach
                </select>
                <label>Rol</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 center-align">
                <button class="btn waves-effect waves-light btn-large amber darken-3" type="submit" name="action">Actualizar
                </button>
            </div>
        </div>
        
    </form>
</div>

@endsection
