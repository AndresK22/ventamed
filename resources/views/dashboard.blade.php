@extends('layout.indexDash')
@section('title','Venta de medicina')

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
        <div class="card">
            <div class="card-content">
                @if ($salidas)
                    @php
                        $total = 0;
                        foreach ($salidas as $salida) {
                            $total += $salida->montoSalida;
                        }
                    @endphp
                    <p class="flow-text">Venta del dia: ${{ number_format($total, 2) }}</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col s6">
        <div class="card">
            <div class="card-content">
                <p class="flow-text center-align">Productos m&aacute;s vendidos del mes</p>
                @foreach ($masVendidos as $mas)
                    <blockquote>
                        {{ $mas->nombreMedicamento }}: {{ $mas->suma }} vendidos.
                    </blockquote>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col s6">
        <div class="card">
            <div class="card-content">
                <p class="flow-text center-align">Productos menos vendidos del mes</p>
                @foreach ($menosVendidos as $menos)
                    <blockquote>
                        {{ $menos->nombreMedicamento }}: {{ $menos->suma }} vendidos.
                    </blockquote>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <p class="flow-text center-align">Medicamentos faltantes</p>
                @foreach ($medicamentos as $medicamento)
                    <blockquote>
                        {{ $medicamento->nombreMedicamento }}: {{ $medicamento->cantidadMedicamento }} restantes.
                    </blockquote>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection