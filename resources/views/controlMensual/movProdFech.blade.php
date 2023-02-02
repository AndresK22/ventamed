<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Movimientos de productos</title>

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
        @if ($fecha2 != null)
            <h4>Listado de movimientos desde {{ date("d/m/Y", strtotime($fecha1)) }} al {{ date("d/m/Y", strtotime($fecha2)) }}</h4>
        @else
            <h4>Listado de movimientos en la fecha {{ date("d/m/Y", strtotime($fecha1)) }}</h4>
        @endif
        
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
                            <th>Producto</th>
                            <th>Fecha compra</th>
                            <th>Cantidad comprada</th>
                            <th>Total compra</th>
                            <th>Fecha venta</th>
                            <th>Cantidad vendida</th>
                            <th>Total venta</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $i = 1;
                            $j = 0;
                        @endphp

                        @foreach ($medicamentos as $medicamento)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $medicamento->nombreMedicamento }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            @foreach ($entradas[$j] as $entrada)
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>{{ date("d/m/Y", strtotime($entrada->fechaEntrada)) }}</td>
                                    <td>{{ $entrada->cantidadEntrada }}</td>
                                    <td>${{ $entrada->precioEntrada }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endforeach


                            @foreach ($salidas[$j] as $salida)
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ date("d/m/Y", strtotime($salida->fechaSalida)) }}</td>
                                    <td>{{ $salida->cantidadSalida }}</td>
                                    <td>${{ $salida->subSalida }}</td>
                                </tr>
                            @endforeach


                            @php
                                $i++;
                                $j++;
                            @endphp

                        @endforeach

                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><p class="flow-text">Total comprado: </p></td>
                            <td><p class="flow-text">${{ number_format($totalCompra, 2) }}</p></td>
                            <td></td>
                            <td><p class="flow-text">Total vendido: </p></td>
                            <td><p class="flow-text">${{ number_format($totalSalida, 2) }}</p></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>

</html>