@extends('layout.indexDash')
@section('title','Control mensual')

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
        <h3>Reportes</h3>
    </div>

    <div class="col s6">
        <div class="card">
            <div class="card-content center-align">
                <span class="card-title">Listado de medicamentos</span>
                <a href="{{ route('medicamento.pdf') }}" class="waves-effect waves-light btn-large amber darken-3" target="_blank" rel="noopener noreferrer"><i class="material-icons right">assignment</i>Imprimir listado</a>
            </div>
        </div>
    </div>

    <div class="col s6">
        <div class="card">
            <div class="card-content center-align">
                <span class="card-title">Listado de medicamentos</span>
                <a href="{{ route('medicamento.pdf') }}" class="waves-effect waves-light btn-large amber darken-3" target="_blank" rel="noopener noreferrer"><i class="material-icons right">assignment</i>Imprimir listado</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col s12 center-align">
        <h3>Movimientos de productos</h3>
    </div>

    <div class="col s6">
        <div class="card">
            <div class="card-content center-align">
                <span class="card-title">Reporte general de movimientos de productos</span>
                <a href="{{ route('controlMensual.movProd') }}" class="waves-effect waves-light btn-large amber darken-3" target="_blank" rel="noopener noreferrer"><i class="material-icons right">assignment</i>Imprimir listado</a>
            </div>
        </div>
    </div>


    <div class="col s6">
        <div class="card">
            <div class="card-content center-align">
                <span class="card-title">Movimientos de productos por fecha</span>

                <form target="_blank" rel="noopener noreferrer" action="{{ route('controlMensual.movProdFech') }}" method="GET">
                    @csrf
                    @method('get')
                    <div class="row">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">date_range</i>
                            <input id="busquedaMov1" name="busquedaMov1" type="text" class="datepicker" value="{{ old('busquedaMov1') }}" class="validate" required>
                            <label for="busquedaMov1">Desde</label>
                            @if ($errors->has('busquedaMov1'))
                                @error('busquedaMov1')
                                    <span class="helper-text">{{ $message }}</span>
                                @enderror    
                            @endif
                        </div>
            
                        <div class="input-field col s6">
                            <i class="material-icons prefix">date_range</i>
                            <input id="busquedaMov2" name="busquedaMov2" type="text" class="datepicker" value="{{ old('busquedaMov2') }}" class="validate">
                            <label for="busquedaMov2">Hasta</label>
                            @if ($errors->has('busquedaMov2'))
                                @error('busquedaMov2')
                                    <span class="helper-text">{{ $message }}</span>
                                @enderror    
                            @endif
                        </div>
            
                        <div class="input-field col s12">
                            <button class="btn-large waves-effect waves-light amber darken-3" type="submit" name="action"><i class="material-icons right">assignment</i>Imprimir listado</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    
</div>


@endsection