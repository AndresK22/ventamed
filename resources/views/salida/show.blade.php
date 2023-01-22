@extends('layout.indexDash')
@section('title','Ver salida')

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

<div class="row white-text">
    <p>.</p>
</div>

<div class="row">
    <div class="col s12 left-align">
        <a href="{{ route('salida.index') }}" class="waves-effect waves-light btn-flat"><i class="material-icons left">arrow_back</i>Ver registros de salidas</a>
    </div>
</div>

<div class="row">
    <div class="col s12 center-align">
        <h3>Revisar salida de medicamento</h3>
    </div>
</div>

<div class="row">
    <div class="col s12">           
        @if ($detalles)
            @php
                $total = 0;
                foreach ($detalles as $detalle) {
                    $total += $detalle->subSalida;
                }
            @endphp

            <div class="input-field col s6">
                <i class="material-icons prefix">attach_money</i>
                <input id="montoSalid" name="montoSalid" type="text" value="${{ number_format($total, 2) }}" class="validate" disabled required>
                <label for="montoSalid">Total</label>
                @if ($errors->has('montoSalid'))
                    @error('montoSalid')
                        <span class="helper-text">{{ $message }}</span>
                    @enderror    
                @endif
            </div>
            <input id="montoSalida" name="montoSalida" type="number" min="0.01" max="999.99" step="0.01" value="{{ $total }}" class="validate" hidden required>
        @endif

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
                    <th>Precio</th>
                    <th>Subtotal</th>
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
                            <td>{{ $detalle->cantidadSalida }}</td>
                            <td>${{ $detalle->precioSalida }}</td>
                            <td>${{ $detalle->subSalida }}</td>
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
