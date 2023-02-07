<?php

namespace App\Http\Controllers;

use App\Models\SalidaMedicamento;
use App\Models\DetalleSalida;
use App\Models\Medicamento;
use Illuminate\Http\Request;
use App\Http\Requests\DetalleSalidaRequest;
use App\Http\Requests\DetalleSalidaUpdateRequest;
use Exception;

class DetalleSalidaController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $medicamento = Medicamento::find($request->medicamento_id);

            if($medicamento->cantidadMedicamento < $request->cantidadSalida){
                $salida = SalidaMedicamento::find($request->salida_id);
                return redirect()->route('salida.create2', $salida)->with('alert','La cantidad a vender excede la cantidad disponible');
                
            }else{
                $detalleSalida = new DetalleSalida();
                $detalleSalida->salida_medicamento_id = $request->salida_id;
                $detalleSalida->medicamento_id = $request->medicamento_id;
                $detalleSalida->cantidadSalida = $request->cantidadSalida;
                $detalleSalida->precioSalida = $request->precioSalida;
                $detalleSalida->subSalida = $request->precioSalida * $request->cantidadSalida;
                $detalleSalida->save();

                $salida = SalidaMedicamento::find($request->salida_id);

                return redirect()->route('salida.create2', $salida);
            }
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function store2(DetalleSalidaRequest $request)
    {
        try{
            $medicamento = Medicamento::find($request->medicamento_id);

            if($medicamento->cantidadMedicamento < $request->cantidadSalida){
                $salida = SalidaMedicamento::find($request->salida_id);
                return redirect()->route('salida.edit2', $salida)->with('alert','La cantidad a vender excede la cantidad disponible');
                
            }else{
                $detalleSalida = new DetalleSalida();
                $detalleSalida->salida_medicamento_id = $request->salida_id;
                $detalleSalida->medicamento_id = $request->medicamento_id;
                $detalleSalida->cantidadSalida = $request->cantidadSalida;
                $detalleSalida->precioSalida = $request->precioSalida;
                $detalleSalida->subSalida = $request->precioSalida * $request->cantidadSalida;
                $detalleSalida->save();

                $salida = SalidaMedicamento::find($request->salida_id);

                return redirect()->route('salida.edit2', $salida);
            }
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DetalleSalidaUpdateRequest $request, SalidaMedicamento $salida, $idDetSal)
    {
        try{
            $medicamento = Medicamento::find($request->medicamentoIdEdit);

            if($medicamento->cantidadMedicamento < $request->cantidadSalidaEdit){
                return redirect()->route('salida.create2', $salida)->with('alert','La cantidad a vender excede la cantidad disponible');
                
            }else{
                $detalleSal = DetalleSalida::find($idDetSal);
                $detalleSal->cantidadSalida = $request->cantidadSalidaEdit;
                $detalleSal->subSalida = $request->precioSalidaEdit * $request->cantidadSalidaEdit;
                $detalleSal->save();

                return redirect()->route('salida.create2', $salida);
            }
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function update2(DetalleSalidaUpdateRequest $request, SalidaMedicamento $salida, $idDetSal)
    {
        try{
            $medicamento = Medicamento::find($request->medicamentoIdEdit);

            if($medicamento->cantidadMedicamento < $request->cantidadSalidaEdit){
                return redirect()->route('salida.edit2', $salida)->with('alert','La cantidad a vender excede la cantidad disponible');
                
            }else{
                $detalleSal = DetalleSalida::find($idDetSal);
                $detalleSal->cantidadSalida = $request->cantidadSalidaEdit;
                $detalleSal->precioSalida = $request->precioSalidaEdit;
                $detalleSal->subSalida = $request->precioSalidaEdit * $request->cantidadSalidaEdit;
                $detalleSal->save();

                return redirect()->route('salida.edit2', $salida);
            }
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalidaMedicamento $salida, $detalleSalida)
    {
        try{
            $detalleSal = DetalleSalida::find($detalleSalida);
            $detalleSal->delete();

            return redirect()->route('salida.create2', $salida);
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function destroy2(SalidaMedicamento $salida, $detalleSalida)
    {
        try{
            $detallesOrig = session('detallesOrig');
            $detalleSal = DetalleSalida::find($detalleSalida);
            //dd($detallesOrig);
            $i = 0;
            foreach ($detallesOrig as $detalle) {

                if($detalleSal->id == $detalle->id){
                    //$detallesOrig->pull($i);

                    $medicamento = Medicamento::find($detalle->medicamento_id);
                    $medicamento->cantidadMedicamento = $medicamento->cantidadMedicamento + $detalle->cantidadSalida;
                    $medicamento->save();
                }
                $i++;
            }

            $detalleSal->delete();
            session()->forget('detallesOrig');
            session(['detallesOrig' => $detallesOrig]);

            return redirect()->route('salida.edit2', $salida);
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
}
