@extends('layout.indexDash')
@section('title','Usuarios')

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
        <h3>Usuarios</h3>
    </div>
</div>

<div class="row">
    <div class="col s12 right-align">
        <a href="{{ route('user.create') }}" class="waves-effect waves-light btn amber darken-3">Crear usuario</a>
    </div>
</div>

<div class="row">
    <div class="col s12">
        <table class="striped highlight responsive-table">
            <thead class="amber lighten-2">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $i = 0;
                @endphp
                @foreach ($usuarios as $usuario)
                    <tr>
                        <input id="idUs" name="idUs" type="hidden" value="{{ $usuario->id }}">
                        <input id="idRo" name="idRo" type="hidden" value="{{ $usuario->rolId }}">
                        <input id="nomUs" name="nomUs" type="hidden" value="{{ $usuario->name }}">
                        <td>{{ $usuario->id }}</td>
                        <td>{{ $usuario->name }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>{{ $usuario->rol }}</td>
                        <td>
                            <a href="{{ route('user.edit', $usuario->id) }}" class="waves-effect waves-light btn amber darken-3"><i class="material-icons">edit</i></a>
                            @if ($usuariosaux[$i] != true)
                                <!-- <a href="{{ route('user.destroy', [$usuario->id, $usuario->rolId]) }}" class="waves-effect waves-light btn modal-trigger amber darken-3"><i class="material-icons">delete</i></a> -->
                                <a id="btnDeleteUser" href="#modalDeleteUser" class="waves-effect waves-light btn modal-trigger amber darken-3"><i class="material-icons">delete</i></a>
                            @endif
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


<!-- Modal Structure -->
<div id="modalDeleteUser" class="modal">
    <div class="modal-content">
        <h4>Confirme la eliminaci&oacute;n</h4>
        <p>¿Est&aacute; seguro que desea eliminar al usuario "<span id="mosUs"></span>"?</p>
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
    $(document).ready(function() {
        $(document).on('click','#btnDeleteUser', function(){
            var use = $('#idUs').val();
            var ro = $('#idRo').val();

            var nom = $('#nomUs').val();
            var mosUs = $('#mosUs');
            mosUs.text(nom);

            var modal = $('#modalDeleteUser')
            modal.find('form').attr('action', route('user.destroy', [use, ro]));
        });
    });
</script>
@endsection

@endsection