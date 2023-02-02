
@extends('layout.indexDash')
@section('title','Actualizar medicamento')

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

<div class="row white-text">
    <p>.</p>
</div>

<div class="row">
    <div class="col s12 left-align">
        <a href="{{ route('medicamento.index') }}" class="waves-effect waves-light btn-flat"><i class="material-icons left">arrow_back</i>Regresar</a>
    </div>
</div>

<div class="row">
    <div class="col s12 center-align">
        <h3>Actualizar medicamento</h3>
    </div>
</div>

<div class="row">
    @role('administrador')
        <form class="col s12" action="{{ route('medicamento.update', $medicamento->id) }}" method="POST">
    @endrole

    @role('gerente')
        <form class="col s12" action="{{ route('medicamento.update2', $medicamento->id) }}" method="POST">
    @endrole
        @csrf
        @method('put')
        <div class="row">
            <div class="input-field col s12">
                <i class="material-icons prefix">featured_play_list</i>
                <input id="codBarras" name="codBarras" type="text" maxlength="25" value="{{ old('codBarras', $medicamento->codBarras) }}" autofocus class="validate" autofocus required>
                <label for="codBarras">C&oacute;digo de barras</label>
                @if ($errors->has('codBarras'))
                    @error('codBarras')
                        <span class="helper-text">{{ $message }}</span>
                    @enderror    
                @endif
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <i class="material-icons prefix">description</i>
                <input id="nombreMedicamento" name="nombreMedicamento" type="text" maxlength="255" value="{{ old('nombreMedicamento', $medicamento->nombreMedicamento) }}" class="validate" required>
                <label for="nombreMedicamento">Nombre del medicamento</label>
                @if ($errors->has('nombreMedicamento'))
                    @error('nombreMedicamento')
                        <span class="helper-text">{{ $message }}</span>
                    @enderror    
                @endif
            </div>
        </div>
        @role('administrador')
            <div class="row">
                <div class="input-field col s12">
                    <i class="material-icons prefix">trending_up</i>
                    <input id="cantidadMedicamento" name="cantidadMedicamento" type="number" min="0" step="1" value="{{ old('cantidadMedicamento', $medicamento->cantidadMedicamento) }}" class="validate" required>
                    <label for="cantidadMedicamento">Cantidad</label>
                    @if ($errors->has('cantidadMedicamento'))
                        @error('cantidadMedicamento')
                            <span class="helper-text">{{ $message }}</span>
                        @enderror    
                    @endif
                </div>
            </div>
        @endrole
        <div class="row">
            <div class="input-field col s12">
                <i class="material-icons prefix">monetization_on</i>
                <input id="precioUnitario" name="precioUnitario" type="number" min="0.01" max="999.99" step="0.01" value="{{ old('precioUnitario', $medicamento->precioUnitario) }}" class="validate" required>
                <label for="precioUnitario">Precio unitario</label>
                @if ($errors->has('precioUnitario'))
                    @error('precioUnitario')
                        <span class="helper-text">{{ $message }}</span>
                    @enderror    
                @endif
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 center-align">
                <button class="btn waves-effect waves-light btn-large amber darken-3" type="submit" name="action">Actualizar medicamento
                </button>
            </div>
        </div>
        
    </form>
</div>

@endsection