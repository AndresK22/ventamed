@extends('layout.indexDash')
@section('title','Venta mensual')

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
        <h3>Venta del mes {{ date("m/Y") }}</h3>
    </div>
</div>

<div class="row">
    <form class="col s12" action="{{ route('ventaDiaria.index') }}" method="GET">
        @csrf
        @method('get')
        <div class="row">
            <div class="input-field col s6">
                <i class="material-icons prefix">date_range</i>
                <input id="busquedaSalida1" name="busquedaSalida1" type="text" class="datepicker" maxlength="255" value="{{ old('busquedaSalida1') }}" class="validate">
                <label for="busquedaSalida1">Buscar por fecha</label>
                @if ($errors->has('busquedaSalida1'))
                    @error('busquedaSalida1')
                        <span class="helper-text">{{ $message }}</span>
                    @enderror    
                @endif
            </div>
            <div class="input-field col s2 right-align">
                <button class="btn waves-effect waves-light amber darken-3" type="submit" name="action">Buscar</button>
            </div>
        </div>
    </form>
</div>

<div class="row">
    @if ($salidas)
        @php
            $total = 0;
            foreach ($salidas as $salida) {
                $total += $salida->montoSalida;
            }
        @endphp

        <p class="flow-text">Venta del mes: ${{ number_format($total, 2) }} </p>
    @endif
</div>

<div class="row">
    <div class="col s12">
        <table class="striped highlight responsive-table centered">
            @php
                $i = 1;
                $j = 0;
            @endphp
            
            @foreach ($salidas as $salida)
                <thead class="amber lighten-2">
                    <tr>
                        <th>Corr.</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Monto de la salida</th>
                        <th>Accion</th>
                    </tr>
                </thead>
    
                <tbody>
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ date("d/m/Y", strtotime($salida->fechaSalida)) }}</td>
                        <td>{{ date("H:i", strtotime($salida->horaSalida)) }}</td>
                        <td>${{ $salida->montoSalida }}</td>
                        <td>
                            <!-- <a href="{{ route('ventaDiaria.show', $salida->id) }}" class="waves-effect waves-light btn amber darken-3"><i class="material-icons">remove_red_eye</i></a> -->
                            <a href="{{ route('ventaDiaria.imp', $salida->id) }}" class="waves-effect waves-light btn amber darken-3"><i class="material-icons">print</i></a>
                        </td>
                    </tr>
                </tbody>


                @php
                    $i++;
                    $j++;
                @endphp

            @endforeach

        </table>
    </div>
</div>

@endsection