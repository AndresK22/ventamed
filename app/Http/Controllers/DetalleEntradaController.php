<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DetalleEntradaRequest;
use App\Http\Requests\DetalleEntradaUpdateRequest;
use App\Models\Medicamento;
use App\Models\EntradaMedicamento;
use App\Models\DetalleEntrada;
use Exception;

class DetalleEntradaController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DetalleEntradaRequest $request)
    {
        try{
            $detalleEntrada = new DetalleEntrada();
            $detalleEntrada->entrada_medicamento_id = $request->entrada_id;
            $detalleEntrada->medicamento_id = $request->medicamento_id;
            $detalleEntrada->cantidadEntrada = $request->cantidadEntrada;
            $detalleEntrada->precioEntrada = $request->precioEntrada;
            $detalleEntrada->save();

            $entrada = EntradaMedicamento::find($request->entrada_id);

            return redirect()->route('entrada.create2', $entrada);
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function store2(DetalleEntradaRequest $request)
    {
        try{
            $detalleEntrada = new DetalleEntrada();
            $detalleEntrada->entrada_medicamento_id = $request->entrada_id;
            $detalleEntrada->medicamento_id = $request->medicamento_id;
            $detalleEntrada->cantidadEntrada = $request->cantidadEntrada;
            $detalleEntrada->precioEntrada = $request->precioEntrada;
            $detalleEntrada->save();

            $entrada = EntradaMedicamento::find($request->entrada_id);

            return redirect()->route('entrada.update2', $entrada);
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  DetalleEntradaUpdateRequest  $request
     * @param  EntradaMedicamento $entrada
     * @param  int  $idDetEnt
     * @return \Illuminate\Http\Response
     */
    public function update(DetalleEntradaUpdateRequest $request, EntradaMedicamento $entrada, $idDetEnt)
    {
        try{
            $detalleEnt = DetalleEntrada::find($idDetEnt);
            $detalleEnt->cantidadEntrada = $request->cantidadEntradaEdit;
            $detalleEnt->precioEntrada = $request->precioEntradaEdit;
            $detalleEnt->save();

            return redirect()->route('entrada.create2', $entrada);
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function update2(DetalleEntradaUpdateRequest $request, EntradaMedicamento $entrada, $idDetEnt)
    {
        try{
            $detalleEnt = DetalleEntrada::find($idDetEnt);
            $detalleEnt->cantidadEntrada = $request->cantidadEntradaEdit;
            $detalleEnt->precioEntrada = $request->precioEntradaEdit;
            $detalleEnt->save();

            return redirect()->route('entrada.update2', $entrada);
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  EntradaMedicamento $entrada
     * @param  int  $detalleEntrada
     * @return \Illuminate\Http\Response
     */
    public function destroy(EntradaMedicamento $entrada, $detalleEntrada)
    {
        try{
            $detalleEnt = DetalleEntrada::find($detalleEntrada);
            $detalleEnt->delete();

            return redirect()->route('entrada.create2', $entrada);
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function destroy2(EntradaMedicamento $entrada, $detalleEntrada)
    {
        try{
            $detallesOrig = session('detallesOrig');
            $detalleEnt = DetalleEntrada::find($detalleEntrada);
            //dd($detallesOrig);
            $i = 0;
            foreach ($detallesOrig as $detalle) {

                if($detalleEnt->id == $detalle->id){
                    $detallesOrig->pull($i);

                    $medicamento = Medicamento::find($detalle->medicamento_id);
                    $medicamento->cantidadMedicamento = $medicamento->cantidadMedicamento - $detalle->cantidadEntrada;
                    $medicamento->save();
                }
                $i++;
            }

            $detalleEnt->delete();
            session()->forget('detallesOrig');
            session(['detallesOrig' => $detallesOrig]);

            return redirect()->route('entrada.update2', $entrada);
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
}
