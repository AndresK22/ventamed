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

<div class="row">
    <div class="col s12 center-align">
        <h3>Reportes</h3>
    </div>

    <div class="col s6">
        <div class="card">
            <div class="card-content center-align">
                <span class="card-title">Listado de medicamentos</span>
                <a href="{{ route('medicamento.pdf') }}" class="waves-effect waves-light btn-large amber darken-2" target="_blank" rel="noopener noreferrer"><i class="material-icons right">assignment</i>Imprimir listado</a>
            </div>
        </div>
    </div>

    <div class="col s6">
        <div class="card">
            <div class="card-content center-align">
                <span class="card-title">Listado de medicamentos</span>
                <a href="{{ route('medicamento.pdf') }}" class="waves-effect waves-light btn-large amber darken-2" target="_blank" rel="noopener noreferrer"><i class="material-icons right">assignment</i>Imprimir listado</a>
            </div>
        </div>
    </div>
</div>


@endsection