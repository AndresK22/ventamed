@extends('layout.indexDash')
@section('title','Actualizar salida')

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

<div class="row white-text">
    <p>.</p>
</div>

<div class="row">
    <div class="col s12 center-align">
        <h3>Actualizar salida de medicamento</h3>
    </div>
</div>

<div class="row">
    <div class="col s12">
        <form action="{{ route('salida.update', $salida->id) }}" method="POST">
            @csrf
            @method('put')
            
            @if ($detalles)
                @php
                    $total = 0;
                    foreach ($detalles as $detalle) {
                        $total += $detalle->subSalida;
                    }
                @endphp
                <div class="col s4">
                    <p class="flow-text">Total: <span>${{ number_format($total, 2) }}</span> </p>
                </div>
                <input id="montoSalida" name="montoSalida" type="number" min="0.01" max="999.99" step="0.01" value="{{ $total }}" class="validate" hidden required>
            @endif

            <input id="salida_id" name="salida_id" type="text" value="{{ $salida->id }}" class="validate" hidden required>
            @php
                $j = 0;
            @endphp
            @if ($detalles)
                @foreach ($detalles as $detalle)
                    <input name="detalles[{{ $j }}][id]" value="{{ $detalle->id }}" hidden>
                    <input name="detalles[{{ $j }}][idMed]" value="{{ $detalle->medicamento_id }}" hidden>
                    <input name="detalles[{{ $j }}][cantidadSalida]" value="{{ $detalle->cantidadSalida }}" hidden>
                    @php
                        $j++;
                    @endphp
                @endforeach
            @endif

            <div class="input-field col s4 center-align">
                <button class="btn-large waves-effect waves-light amber darken-3" type="submit" name="action">Actualizar salida</button>
            </div>
            
        </form>
    </div>
</div>

<div class="row white-text">
    <p>.</p>
</div>

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
                    <th>Acciones</th>
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
                            <td>
                                <button data-target="modalEditDetSal" class="waves-effect waves-light btn modal-trigger amber darken-3" onclick="editarDetSal({{ $salida->id }}, {{ $detalle->id }}, '{{ $detalle->medicamento->nombreMedicamento }}', {{ $detalle->cantidadSalida }}, {{ $detalle->precioSalida }}, {{ $detalle->medicamento_id }})"><i class="material-icons">edit</i></button>
                                <button data-target="modalDeleteDetalleSal" class="waves-effect waves-light btn modal-trigger amber darken-3" onclick="borrarDetSal({{ $salida->id }}, {{ $detalle->id }}, '{{ $detalle->medicamento->nombreMedicamento }}')"><i class="material-icons">delete</i></button>
                            </td>
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

<!-- Modal Structure -->
<div id="modalDeleteDetalleSal" class="modal">
    <div class="modal-content">
        <h4>Confirme la eliminaci&oacute;n</h4>
        <p>¿Est&aacute; seguro que desea eliminar el medicamento "<span id="mosNom"></span>"?</p>
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


<div id="modalEditDetSal" class="modal">
    <div class="modal-content">
        <h4>Actualizar medicamento "<span id="mosNomEdit"></span>"</h4>

        <form method="POST" action="" style="display: inline;">
            @csrf
            @method('put')

            <input id='idDet' name="idDet" type="number" min="1" step="1" hidden>

            <input id="precioSalidaEdit" name="precioSalidaEdit" type="number" min="0.01" max="999.99" step="0.01" class="validate" hidden required>
            <input id="medicamentoIdEdit" name="medicamentoIdEdit" type="number" min="1" step="1" class="validate" hidden required>

            <div class="row">
                <div class="input-field col s12">
                    <i class="material-icons prefix">trending_up</i>
                    <input id='cantidadSalidaEdit' name="cantidadSalidaEdit" type="number" min="0" step="1" class="validate" required>
                    @if ($errors->has('cantidadSalidaEdit'))
                        @error('cantidadSalidaEdit')
                            <span class="helper-text">{{ $message }}</span>
                        @enderror    
                    @endif
                </div>
            </div>
    </div>
    <div class="modal-footer">
            <button class="waves-effect waves-green btn-flat light-green lighten-1" onclick="$(this).closest('form').submit();">Confirmar</button>
            <a href="#!" class="modal-close waves-effect waves-green btn-flat red lighten-1">Cancelar</a>
        </form>
    </div>
</div>


@routes()
@section('js_user_page')
<script type="text/javascript">

    var borrarDetSal;
    var editarDetSal;

    $(document).ready(function() {

        //Funcion para eliminar un detalle de Entrada
        borrarDetSal = function(idSal, idDetSal, nomSalDet){
            var mosNom = $('#mosNom');
            mosNom.text(nomSalDet);

            var modal = $('#modalDeleteDetalleSal')
            modal.find('form').attr('action', route('detaSal.destroy2', [idSal, idDetSal]));
        };

        //Funcion para editar un detalle de entrada
        editarDetSal = function(idSal, idDetSal, nomSalDet, cantDet, precSal, idMed){
            var cantidad = $('#cantidadSalidaEdit');
            var precio = $('#precioSalidaEdit');
            var medicamento = $('#medicamentoIdEdit');
            var idDet = $('#idDet');

            cantidad.val(cantDet);
            precio.val(precSal);
            medicamento.val(idMed);
            idDet.val(idDetSal);

            var mosNom = $('#mosNomEdit');
            mosNom.text(nomSalDet);

            var modal = $('#modalEditDetSal')
            modal.find('form').attr('action', route('detaSal.update2', [idSal, idDetSal]));
        };

        //Funcion para buscar el medicamento segun el codigo de barras
        $("#codBarras").blur(function(){
            var codBarra = $('#codBarras').val();
            $.ajax({
                // la URL para la petición
                url : route('salida.buscMed'),
            
                // la información a enviar
                // (también es posible utilizar una cadena de datos)
                data :  {
                    codB : codBarra,
                    _token : $('input[name="_token"]').val()},
            
                // especifica si será una petición POST o GET
                type : 'POST',
            
                // el tipo de información que se espera de respuesta
                dataType : 'json',
            
                // código a ejecutar si la petición es satisfactoria;
                // la respuesta es pasada como argumento a la función
                success : function(res) {
                    //console.log(res);
                    $("#medicamento_id").val(res.id);
                    $("#nombreMedicamento").val(res.nombreMedicamento);
                    $("#precioSal").val(res.precioUnitario);
                    $("#precioSalida").val(res.precioUnitario);
                    //$("#precioUnitario").val(res.precioUnitario);
                },
            
                // código a ejecutar si la petición falla;
                // son pasados como argumentos a la función
                // el objeto jqXHR (extensión de XMLHttpRequest), un texto con el estatus
                // de la petición y un texto con la descripción del error que haya dado el servidor
                error : function(jqXHR, status, error) {
                    /*console.log('Disculpe, existió un problema');
                    console.log('El status dice: ' + status);
                    console.log('El error dice: ' + error);*/
                },
            
                // código a ejecutar sin importar si la petición falló o no
                complete : function(jqXHR, status) {
                    //console.log('Petición realizada');
                }
            });
        });
    
    });
</script>
@endsection

@endsection
