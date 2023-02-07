@extends('layout.indexDash')
@section('title','Salida de medicamentos')

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
        <h3>Salida de medicamentos</h3>
    </div>
</div>

<div class="row">
    <div class="col s12 left-align">
        <a href="{{ route('salida.create') }}" class="waves-effect waves-light btn-large amber darken-3">Ingresar salida de medicamento</a>
    </div>
</div>

<div class="row">
    <form class="col s12" action="{{ route('salida.index') }}" method="GET">
        @csrf
        @method('get')
        <div class="row">
            <div class="input-field col s5">
                <i class="material-icons prefix">date_range</i>
                <input id="busquedaSalida1" name="busquedaSalida1" type="text" class="datepicker" maxlength="255" value="{{ old('busquedaSalida1') }}" class="validate">
                <label for="busquedaSalida1">Desde</label>
                @if ($errors->has('busquedaSalida1'))
                    @error('busquedaSalida1')
                        <span class="helper-text">{{ $message }}</span>
                    @enderror    
                @endif
            </div>

            <div class="input-field col s5">
                <i class="material-icons prefix">date_range</i>
                <input id="busquedaSalida2" name="busquedaSalida2" type="text" class="datepicker" maxlength="255" value="{{ old('busquedaSalida2') }}" class="validate">
                <label for="busquedaSalida2">Hasta</label>
                @if ($errors->has('busquedaSalida2'))
                    @error('busquedaSalida2')
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
    <div class="col s12">
        <table class="striped highlight responsive-table centered">
            <thead class="amber lighten-2">
                <tr>
                    <th>Corr.</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Monto de la salida</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $i = 1;
                @endphp

                @foreach ($salidas as $salida)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ date("d/m/Y", strtotime($salida->fechaSalida)) }}</td>
                        <td>{{ date("H:i", strtotime($salida->horaSalida)) }}</td>
                        <td>${{ $salida->montoSalida }}</td>
                        <td>
                            <a href="{{ route('salida.show', $salida->id) }}" class="waves-effect waves-light btn amber darken-3"><i class="material-icons">remove_red_eye</i></a>
                            <a href="{{ route('salida.imp', $salida->id) }}" class="waves-effect waves-light btn amber darken-3"><i class="material-icons">print</i></a>
                            @role('administrador')
                                <a href="{{ route('salida.edit', $salida->id) }}" class="waves-effect waves-light btn amber darken-3"><i class="material-icons">edit</i></a>
                            @endrole
                            
                            @role('administrador')
                                <button data-target="modalDeleteSalida" class="waves-effect waves-light btn modal-trigger amber darken-3" onclick="borrarSal({{ $salida->id }}, '{{ $salida->fechaSalida }}')"><i class="material-icons">delete</i></button>
                            @endrole
                        </td>
                    </tr>

                    @php
                        $i++;
                    @endphp

                @endforeach
            </tbody>
        </table>
    </div>

</div>

{{ $salidas->links() }}

<!-- Modal Structure -->
<div id="modalDeleteSalida" class="modal">
    <div class="modal-content">
        <h4>Confirme la eliminaci&oacute;n</h4>
        <p>¿Est&aacute; seguro que desea eliminar la salida de medicamentos con fecha "<span id="mosFe"></span>"?</p>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat light-green lighten-1">Cancelar</a>
        <form method="POST" action="" style="display: inline;">
            @csrf
            @method('GET')
            <a class="waves-effect waves-green btn-flat red lighten-1" onclick="$(this).closest('form').submit();">Borrar</a>
        </form>
    </div>
</div>

@routes
@section('js_user_page')
<script type="text/javascript">

    var borrarEnt;

    $(document).ready(function() {
        //Funcion para eliminar una Entrada
        borrarSal = function(idSal, fecha){
            var mosFe = $('#mosFe');
            mosFe.text(fecha);

            var modal = $('#modalDeleteSalida')
            modal.find('form').attr('action', route('salida.destroy', idSal));
        };
    });
</script>
@endsection

@endsection