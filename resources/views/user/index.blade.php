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

<div class="row">
    <div class="col s12 center-align">
        <h3>Usuarios</h3>
    </div>
</div>

<div class="row">
    <div class="col s12 right-align">
        <a href="{{ route('user.create') }}" class="waves-effect waves-light btn amber darken-2">Crear usuario</a>
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
                        <td>{{ $usuario->id }}</td>
                        <td>{{ $usuario->name }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>{{ $usuario->rol }}</td>
                        <td>
                            <a href="{{ route('user.edit', $usuario->id) }}" class="waves-effect waves-light btn amber darken-2"><i class="material-icons">edit</i></a>
                            @if ($usuariosaux[$i] != true)
                                <a href="{{ route('user.destroy', $usuario->id) }}" class="waves-effect waves-light btn amber darken-2"><i class="material-icons">delete</i></a>
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

@section('js_user_page')
<script type="text/javascript">
</script>
@endsection

@endsection