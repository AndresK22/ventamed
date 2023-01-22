<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SalidaRequest;
use App\Models\SalidaMedicamento;
use App\Models\DetalleSalida;
use App\Models\Medicamento;
use Exception;

class SalidaMedicamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $fecha1 = $request->busquedaSalida1;
            $fecha2 = $request->busquedaSalida2;

            if($fecha2 != null){
                $salidas = SalidaMedicamento::orderBy('fechaSalida', 'desc')
                ->orderBy('horaSalida', 'desc')
                ->fechaSalida2($fecha1, $fecha2)
                ->paginate(20);
            }else{
                $salidas = SalidaMedicamento::orderBy('fechaSalida', 'desc')
                ->orderBy('horaSalida', 'desc')
                ->fechaSalida1($fecha1)
                ->paginate(20);
            }           

            return view('salida.index', compact('salidas'));
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            $salida = new SalidaMedicamento();
            $salida->montoSalida = 0;
            $salida->save();

            $detalles = null;

            return view('salida.create', compact('salida', 'detalles'));
            
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function create2(SalidaMedicamento $salida)
    {
        try{
            $detalles = DetalleSalida::where('salida_medicamento_id', '=', $salida->id)->get();
            //dd($detalles[0]->medicamento->nombreMedicamento);
            return view('salida.create', compact('salida', 'detalles'));
            
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function buscMed(Request $request)
    {
        try{
            $medicamento = Medicamento::where('codBarras', '=', $request->codB)->get()->toArray();
            return response()->json($medicamento[0]);
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalidaRequest $request)
    {
        try {
            $detalles = $request->detalles;

            //dd($detalles);
            foreach ($detalles as $detalle) {
                $medicamento = Medicamento::find($detalle['idMed']);
                $medicamento->cantidadMedicamento = $medicamento->cantidadMedicamento - $detalle['cantidadSalida'];
                $medicamento->save();
            }

            $fecha = date("Y-m-d");
            $hora = date("H:i:s");

            $salida = SalidaMedicamento::find($request->salida_id);
            $salida->fechaSalida = $fecha;
            $salida->horaSalida = $hora;
            $salida->montoSalida = $request->montoSalida;
            $salida->save();

            return redirect()->route('salida.index')->with('status','Salida ingresada correctamente');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SalidaMedicamento $salida)
    {
        try{
            $detalles = DetalleSalida::where('salida_medicamento_id', '=', $salida->id)->get();
            //dd($detalles[0]->medicamento->nombreMedicamento);
            return view('salida.show', compact('salida', 'detalles'));
            
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SalidaMedicamento $salida)
    {
        try{
            $detalles = DetalleSalida::where('salida_medicamento_id', '=', $salida->id)->get();
            $detallesOrig = DetalleSalida::where('salida_medicamento_id', '=', $salida->id)->get();
            session(['detallesOrig' => $detallesOrig]);
            //dd($detalles[0]->medicamento->nombreMedicamento);
            return view('salida.update', compact('salida', 'detalles'));
            
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function edit2(Request $request, SalidaMedicamento $salida)
    {
        try{
            $detalles = DetalleSalida::where('salida_medicamento_id', '=', $salida->id)->get();
            //dd($detalles[0]->medicamento->nombreMedicamento);
            return view('salida.update', compact('salida', 'detalles'));
            
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
    public function update(SalidaRequest $request)
    {
        try {
            $detalles = $request->detalles;
            $detallesOrig = session('detallesOrig');

            $cont = count($detallesOrig);
            
            for ($i=0; $i < $cont; $i++) { 

                foreach ($detalles as $detalle) {
                    $medicamento = Medicamento::find($detalle['idMed']);

                    if($detallesOrig[$i]['id'] == $detalle['id']){

                        if($detallesOrig[$i]['cantidadSalida'] > $detalle['cantidadSalida']){
                            $diferencia = $detallesOrig[$i]['cantidadSalida'] - $detalle['cantidadSalida'];
                            $medicamento->cantidadMedicamento = $medicamento->cantidadMedicamento + $diferencia;

                        }else if($detallesOrig[$i]['cantidadSalida'] < $detalle['cantidadSalida']){
                            $diferencia = $detalle['cantidadSalida'] - $detallesOrig[$i]['cantidadSalida'];
                            $medicamento->cantidadMedicamento = $medicamento->cantidadMedicamento - $diferencia;
        
                        }
                    }else{
                        $medicamento->cantidadMedicamento = $medicamento->cantidadMedicamento - $detalle['cantidadSalida'];
                        $medicamento->save();
                    }
                    
                    $medicamento->save();
                }
            }

            $salida = SalidaMedicamento::find($request->salida_id);
            $salida->montoSalida = $request->montoSalida;
            $salida->save();

            session()->forget('detallesOrig');

            return redirect()->route('salida.index')->with('status','Salida actualizada correctamente');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalidaMedicamento $salida)
    {
        try{
            $salida->delete();
            return redirect()->route('salida.index')->with('status','Salida eliminada correctamente');
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function destroy2(SalidaMedicamento $salida)
    {
        try{
            $detalles = DetalleSalida::where('salida_medicamento_id', '=', $salida->id)->get();
            if($detalles != null){
                foreach($detalles as $detalle){
                    $detalle->delete();
                }
            }

            $salida->delete();
            return redirect()->route('salida.index')->with('status','Ha salido de la venta de medicamentos');
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
}
