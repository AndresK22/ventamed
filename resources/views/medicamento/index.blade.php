@extends('layout.indexDash')
@section('title','Medicamentos')

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
        <h3>Medicamentos</h3>
    </div>
</div>

@hasanyrole('administrador|gerente')
    <div class="row">
        <div class="col s6 left-align">
            <a href="{{ route('medicamento.create') }}" class="waves-effect waves-light btn-large amber darken-3">Crear medicamento</a>
        </div>
        
        <div class="col s6 right-align">
            <a href="{{ route('medicamento.pdf') }}" class="waves-effect waves-light btn-large amber darken-3" target="_blank" rel="noopener noreferrer">Imprimir listado</a>
        </div>
    </div>
@endhasanyrole

<div class="row">
    <form class="col s12" action="{{ route('medicamento.index') }}" method="GET">
        @csrf
        @method('get')
        <div class="row">
            <div class="input-field col s5">
                <i class="material-icons prefix">search</i>
                <input id="busquedaMedicamento" name="busquedaMedicamento" type="text" maxlength="255" value="{{ old('busquedaMedicamento') }}" autofocus class="validate">
                <label for="busquedaMedicamento">Buscar por nombre</label>
                @if ($errors->has('busquedaMedicamento'))
                    @error('busquedaMedicamento')
                        <span class="helper-text">{{ $message }}</span>
                    @enderror    
                @endif
            </div>

            <div class="input-field col s5">
                <i class="material-icons prefix">search</i>
                <input id="busquedaCodBarras" name="busquedaCodBarras" type="text" maxlength="25" value="{{ old('busquedaCodBarras') }}" class="validate">
                <label for="busquedaCodBarras">Buscar por codigo de barras</label>
                @if ($errors->has('busquedaCodBarras'))
                    @error('busquedaCodBarras')
                        <span class="helper-text">{{ $message }}</span>
                    @enderror    
                @endif
            </div>
            
            <div class="input-field col s2 right-align">
                <button id="buscarMed" class="btn waves-effect waves-light amber darken-3" type="submit" name="action">Buscar</button>
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
                    <th>Nombre</th>
                    <th>Cantidad disponible</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $i = 1;
                @endphp

                @foreach ($medicamentos as $medicamento)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $medicamento->nombreMedicamento }}</td>
                        <td>{{ $medicamento->cantidadMedicamento }}</td>
                        <td>${{ $medicamento->precioUnitario }}</td>
                        <td>
                            @hasanyrole('administrador|gerente')
                                <a href="{{ route('medicamento.edit', $medicamento->id) }}" class="waves-effect waves-light btn amber darken-3"><i class="material-icons">edit</i></a>
                            @endhasanyrole
                            
                            @role('administrador')
                                <button data-target="modalDeleteMedicamento" class="btn modal-trigger waves-effect waves-light amber darken-3" onclick="borrarMed({{ $medicamento->id }}, '{{ $medicamento->nombreMedicamento }}')"><i class="material-icons">delete</i></button>
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

{{ $medicamentos->links() }}

<!-- Modal Structure -->
<div id="modalDeleteMedicamento" class="modal">
    <div class="modal-content">
        <h4>Confirme la eliminaci&oacute;n</h4>
        <p>¿Est&aacute; seguro que desea eliminar al medicamento "<span id="mosMed"></span>"?</p>
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

    var borrarMed;

    $(document).ready(function() {
        borrarMed = function(idMed, nomMed) {
            /*var idMed = $('.idMed').val();
            var nomMed = $('.nomMed').val();*/
            var mosMed = $('#mosMed');
            mosMed.text(nomMed);

            var modal = $('#modalDeleteMedicamento')
            modal.find('form').attr('action', route('medicamento.destroy', idMed));
        };

        $("#busquedaCodBarras").blur(function(){
            $("#buscarMed").trigger("click");
        });
    });
</script>
@endsection

@endsection