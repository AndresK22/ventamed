<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Listado de medicamentos</title>

    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="{{ asset('css/materialize.min.css') }}"  media="screen"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('css/app.css') }}"  media="screen"/>   

    <script type="text/javascript" src="{{ asset('js/materialize.min.js') }}"></script>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<div class="row">
    <div class="col s12 center-align">
        <h4>Listado de medicamentos a la fecha de {{ date('d/m/Y') }}</h4>
    </div>
</div>

<body class="antialiased">
    <main>
        <div class="row">
            <div class="col s12">
                <table class="centered">
                    <thead class="amber lighten-2">
                        <tr>
                            <th>Corr.</th>
                            <th>Nombre</th>
                            <th>Cantidad disponible</th>
                            <th>Precio</th>
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
                            </tr>

                            @php
                                $i++;
                            @endphp

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>

</html>