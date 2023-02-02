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
        <h3>Actualizar entrada de medicamento</h3>
    </div>
</div>

<div class="row">
    <div class="col s12">
        <form action="{{ route('entrada.update', $entrada->id) }}" method="POST">
            @csrf
            @method('put')
            
            <div class="input-field col s4">
                <i class="material-icons prefix">local_shipping</i>
                <input id="proveedorEntrada" name="proveedorEntrada" type="text" maxlength="255"value="{{ old('proveedorEntrada', $entrada->proveedorEntrada) }}" class="validate" required>
                <label for="proveedorEntrada">Proveedor</label>
                @if ($errors->has('proveedorEntrada'))
                    @error('proveedorEntrada')
                        <span class="helper-text">{{ $message }}</span>
                    @enderror    
                @endif
            </div>
            @if ($detalles)
                @php
                    $total = 0;
                    foreach ($detalles as $detalle) {
                        $total += $detalle->subEntrada;
                    }
                @endphp

                <div class="input-field col s4">
                    <i class="material-icons prefix">attach_money</i>
                    <input id="montoEntrad" name="montoEntrad" type="text" value="${{ number_format($total, 2) }}" class="validate" disabled required>
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
            @php
                $j = 0;
            @endphp
            @if ($detalles)
                @foreach ($detalles as $detalle)
                    <input name="detalles[{{ $j }}][id]" value="{{ $detalle->id }}" hidden>
                    <input name="detalles[{{ $j }}][idMed]" value="{{ $detalle->medicamento_id }}" hidden>
                    <input name="detalles[{{ $j }}][cantidadEntrada]" value="{{ $detalle->cantidadEntrada }}" hidden>
                    @php
                        $j++;
                    @endphp
                @endforeach
            @endif

            <div class="input-field col s4 center-align">
                <button class="btn-large waves-effect waves-light amber darken-3" type="submit" name="action">Actualizar entrada</button>
            </div>
            
        </form>
    </div>
</div>

<div class="row white-text">
    <p>.</p>
</div>

<div class="row">
    <div class="col s8">
        <table class="striped highlight responsive-table centered">
            <thead class="amber lighten-2">
                <tr>
                    <th>Corr.</th>
                    <th>Medicamento</th>
                    <th>Cantidad</th>
                    <th>Costo</th>
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
                            <td>{{ $detalle->cantidadEntrada }}</td>
                            <td>${{ $detalle->precioEntrada }}</td>
                            <td>${{ $detalle->subEntrada }}</td>
                            <td>
                                <button data-target="modalEditDetEnt" class="waves-effect waves-light btn modal-trigger amber darken-3" onclick="editarDetEn({{ $entrada->id }}, {{ $detalle->id }}, '{{ $detalle->medicamento->nombreMedicamento }}', {{ $detalle->cantidadEntrada }}, {{ $detalle->precioEntrada }})"><i class="material-icons">edit</i></button>
                                <button data-target="modalDeleteDetalleEn" class="waves-effect waves-light btn modal-trigger amber darken-3" onclick="borrarDetEn({{ $entrada->id }}, {{ $detalle->id }}, '{{ $detalle->medicamento->nombreMedicamento }}')"><i class="material-icons">delete</i></button>
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

    <div class="col s4">
        <div class="card">
            <div class="card-content">
                <form id="formDeta" action="{{ route('detaEnt.store2') }}" method="POST">
                    @csrf
                    <div class="input-field col s12">
                        <input id="medicamento_id" name="medicamento_id" type="text" value="{{ old('medicamento_id') }}" class="validate" hidden required>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">featured_play_list</i>
                            <input id="codBarras" name="codBarras" type="text" maxlength="25" class="validate" autofocus required>
                            <label for="codBarras">C&oacute;digo de barras</label>
                            @if ($errors->has('codBarras'))
                                @error('codBarras')
                                    <span class="helper-text">{{ $message }}</span>
                                @enderror
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">description</i>
                            <input id="nombreMedicamento" name="nombreMedicamento" type="text" maxlength="255" class="validate" disabled required>
                            @if ($errors->has('nombreMedicamento'))
                                @error('nombreMedicamento')
                                    <span class="helper-text">{{ $message }}</span>
                                @enderror    
                            @endif
                        </div>
                    </div>            
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">trending_up</i>
                            <input id="cantidadEntrada" name="cantidadEntrada" type="number" min="0" step="1" class="validate" required>
                            <label for="cantidadEntrada">Cantidad</label>
                            @if ($errors->has('cantidadEntrada'))
                                @error('cantidadEntrada')
                                    <span class="helper-text">{{ $message }}</span>
                                @enderror    
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">monetization_on</i>
                            <input id="precioEntrada" name="precioEntrada" type="number" min="0.01" max="999.99" step="0.01" class="validate" required>
                            <label for="precioEntrada">Costo</label>
                            @if ($errors->has('precioEntrada'))
                                @error('precioEntrada')
                                    <span class="helper-text">{{ $message }}</span>
                                @enderror    
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 center-align">
                            <button class="btn-large waves-effect waves-light amber darken-3" type="submit" name="action">A&ntilde;adir</button>
                        </div>
                    </div>
                    <div class="input-field col s12">
                        <input id="entrada_id" name="entrada_id" type="text" value="{{ $entrada->id }}" class="validate" hidden required>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- Modal Structure -->
<div id="modalDeleteDetalleEn" class="modal">
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


<div id="modalEditDetEnt" class="modal">
    <div class="modal-content">
        <h4>Actualizar medicamento "<span id="mosNomEdit"></span>"</h4>

        <form method="POST" action="" style="display: inline;">
            @csrf
            @method('put')
            <input id='idDet' name="idDet" type="number" min="1" step="1" hidden>
            <div class="row">
                <div class="input-field col s12">
                    <i class="material-icons prefix">trending_up</i>
                    <input id='cantidadEntradaEdit' name="cantidadEntradaEdit" type="number" min="0" step="1" class="validate" required>
                    @if ($errors->has('cantidadEntradaEdit'))
                        @error('cantidadEntradaEdit')
                            <span class="helper-text">{{ $message }}</span>
                        @enderror    
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <i class="material-icons prefix">monetization_on</i>
                    <input id="precioEntradaEdit" name="precioEntradaEdit" type="number" min="0.01" max="999.99" step="0.01" class="validate" required>
                    @if ($errors->has('precioEntradaEdit'))
                        @error('precioEntradaEdit')
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

    var borrarDetEn;
    var editarDetEn;

    $(document).ready(function() {

        //Funcion para eliminar un detalle de Entrada
        borrarDetEn = function(idEn, idDetEn, nomEnDet){
            /*var idDetEn = $('#idDetEn').val();
            var idEn = $('#entrada_id').val();

            var nomEnDet = $('#nomEnDet').val();*/
            var mosNom = $('#mosNom');
            mosNom.text(nomEnDet);

            var modal = $('#modalDeleteDetalleEn')
            modal.find('form').attr('action', route('detaEnt.destroy2', [idEn, idDetEn]));
        };

        //Funcion para editar un detalle de entrada
        editarDetEn = function(idEn, idDetEn, nomEnDet, cantDet, precEnt){
            var cantidad = $('#cantidadEntradaEdit');
            var precio = $('#precioEntradaEdit');
            var idDet = $('#idDet');

            cantidad.val(cantDet);
            precio.val(precEnt);
            idDet.val(idDetEn);

            var mosNom = $('#mosNomEdit');
            mosNom.text(nomEnDet);

            var modal = $('#modalEditDetEnt')
            modal.find('form').attr('action', route('detaEnt.update2', [idEn, idDetEn]));
        };

        //Funcion para buscar el medicamento segun el codigo de barras
        $("#codBarras").blur(function(){
            var codBarra = $('#codBarras').val();
            $.ajax({
                // la URL para la petición
                url : route('entrada.buscMed'),
            
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
