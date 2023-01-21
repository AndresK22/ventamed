@extends('layout.indexDash')
@section('title','Actualizar entrada')

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
        <div class="input-field col s6">
            <i class="material-icons prefix">local_shipping</i>
            <input id="proveedorEntrada" name="proveedorEntrada" type="text" maxlength="255"value="{{ old('proveedorEntrada', $entrada->proveedorEntrada) }}" disabled required>
            <label for="proveedorEntrada">Proveedor</label>
        </div>
        @if ($detalles)
            @php
                $total = 0;
                foreach ($detalles as $detalle) {
                    $total += $detalle->subEntrada;
                }
            @endphp

            <div class="input-field col s6">
                <i class="material-icons prefix">attach_money</i>
                <input id="montoEntrad" name="montoEntrad" type="text" value="${{ $total }}" class="validate" disabled required>
                <label for="montoEntrad">Total</label>
                @if ($errors->has('montoEntrad'))
                    @error('montoEntrad')
                        <span class="helper-text">{{ $message }}</span>
                    @enderror    
                @endif
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
                            <td>{{ $detalle->cantidadEntrada }}</td>
                            <td>{{ $detalle->precioEntrada }}</td>
                            <td>{{ $detalle->subEntrada }}</td>
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
