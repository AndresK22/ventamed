@extends('layout.indexDash')
@section('title','Entrada de medicamentos')

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
        <h3>Entrada de medicamentos</h3>
    </div>
</div>

<div class="row">
    <div class="col s12 left-align">
        <a href="{{ route('entrada.create') }}" class="waves-effect waves-light btn-large amber darken-3">Ingresar entrada de medicamento</a>
    </div>
</div>

<div class="row">
    <form class="col s12" action="{{ route('entrada.index') }}" method="GET">
        @csrf
        @method('get')
        <div class="row">
            <div class="input-field col s5">
                <i class="material-icons prefix">date_range</i>
                <input id="busquedaEntrada1" name="busquedaEntrada1" type="text" class="datepicker" maxlength="255" value="{{ old('busquedaEntrada1') }}" class="validate">
                <label for="busquedaEntrada1">Desde</label>
                @if ($errors->has('busquedaEntrada1'))
                    @error('busquedaEntrada1')
                        <span class="helper-text">{{ $message }}</span>
                    @enderror    
                @endif
            </div>

            <div class="input-field col s5">
                <i class="material-icons prefix">date_range</i>
                <input id="busquedaEntrada2" name="busquedaEntrada2" type="text" class="datepicker" maxlength="255" value="{{ old('busquedaEntrada2') }}" class="validate">
                <label for="busquedaEntrada2">Hasta</label>
                @if ($errors->has('busquedaEntrada2'))
                    @error('busquedaEntrada2')
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
                    <th>Proveedor</th>
                    <th>Monto de la entrada</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $i = 1;
                @endphp

                @foreach ($entradas as $entrada)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ date("d/m/Y", strtotime($entrada->fechaEntrada)) }}</td>
                        <td>{{ $entrada->proveedorEntrada }}</td>
                        <td>${{ $entrada->montoEntrada }}</td>
                        <td>
                            <a href="{{ route('entrada.show', $entrada->id) }}" class="waves-effect waves-light btn amber darken-3"><i class="material-icons">remove_red_eye</i></a>
                            <!-- <a href="{{ route('entrada.edit', $entrada->id) }}" class="waves-effect waves-light btn amber darken-3"><i class="material-icons">edit</i></a> -->
                            @role('administrador')
                                <button data-target="modalDeleteEntrada" class="waves-effect waves-light btn modal-trigger amber darken-3" onclick="borrarEnt({{ $entrada->id }}, '{{ $entrada->fechaEntrada }}')"><i class="material-icons">delete</i></button>
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

{{ $entradas->links() }}

<!-- Modal Structure -->
<div id="modalDeleteEntrada" class="modal">
    <div class="modal-content">
        <h4>Confirme la eliminaci&oacute;n</h4>
        <p>¿Est&aacute; seguro que desea eliminar la entrada de medicamentos con fecha "<span id="mosFe"></span>"?</p>
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
        borrarEnt = function(idEnt, fecha){
            var mosFe = $('#mosFe');
            mosFe.text(fecha);

            var modal = $('#modalDeleteEntrada')
            modal.find('form').attr('action', route('entrada.destroy', idEnt));
        };
    });
</script>
@endsection

@endsection