@extends('layout.indexDash')
@section('title','Ver entrada')

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
        <a href="{{ route('entrada.index') }}" class="waves-effect waves-light btn-flat"><i class="material-icons left">arrow_back</i>Ver registros de entradas</a>
    </div>
</div>

<div class="row">
    <div class="col s12 center-align">
        <h3>Revisar entrada de medicamento</h3>
    </div>
</div>

<div class="row">
    <div class="col s12">           
        <div class="center-align col s6">
            <p id="proveedorEntrada" class="flow-text">Proveedor: {{ $entrada->proveedorEntrada }}</p>
        </div>
        @if ($detalles)
            @php
                $total = 0;
                foreach ($detalles as $detalle) {
                    $total += $detalle->precioEntrada;
                }
            @endphp

            <div class="center-align col s6">
                <p id="montoEntrad" class="flow-text">Total: ${{ number_format($total, 2) }}</p>
            </div>
            <input id="montoEntrada" name="montoEntrada" type="number" min="0.01" max="999.99" step="0.01" value="{{ $total }}" class="validate" hidden required>
        @endif

        <input id="entrada_id" name="entrada_id" type="text" value="{{ $entrada->id }}" class="validate" hidden required>

    </div>
</div>

<div class="white-text"><p>.</p></div>

<div class="row">
    <div class="col s12">
        <table class="striped highlight responsive-table centered">
            <thead class="amber lighten-2">
                <tr>
                    <th>Corr.</th>
                    <th>Medicamento</th>
                    <th>Cantidad</th>
                    <th>Costo</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $i = 1;
                @endphp

                @if ($detalles)
                    @foreach ($detalles as $detalle)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $detalle->medicamento->nombreMedicamento }}</td>
                            <td>{{ $detalle->cantidadEntrada }}</td>
                            <td>${{ $detalle->precioEntrada }}</td>
                        </tr>

                        @php
                            $i++;
                        @endphp

                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection
