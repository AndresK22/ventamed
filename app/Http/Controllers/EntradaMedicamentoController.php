<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EntradaRequest;
use App\Http\Requests\EntradaUpdateRequest;
use App\Models\EntradaMedicamento;
use App\Models\DetalleEntrada;
use App\Models\Medicamento;
use Exception;

class EntradaMedicamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $fecha1 = $request->busquedaEntrada1;
            $fecha2 = $request->busquedaEntrada2;

            //Borrar los vacios
            $aux = EntradaMedicamento::where('fechaEntrada', null)
            ->where('montoEntrada', 0.00)
            ->get();
            foreach ($aux as $val) {
                $val->forceDelete();
            }

            //Mostrar las entradas
            if($fecha2 != null){
                $entradas = EntradaMedicamento::orderBy('fechaEntrada', 'desc')
                ->fechaEntrada2($fecha1, $fecha2)
                ->paginate(20);
            }else{
                $entradas = EntradaMedicamento::orderBy('fechaEntrada', 'desc')
                ->fechaEntrada1($fecha1)
                ->paginate(20);
            }           

            return view('entrada.index', compact('entradas'));
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
            $entrada = new EntradaMedicamento();
            $entrada->montoEntrada = 0;
            $entrada->save();

            $detalles = null;

            return view('entrada.create', compact('entrada', 'detalles'));
            
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function create2(EntradaMedicamento $entrada)
    {
        try{
            $detalles = DetalleEntrada::where('entrada_medicamento_id', '=', $entrada->id)->get();
            //dd($detalles[0]->medicamento->nombreMedicamento);
            return view('entrada.create', compact('entrada', 'detalles'));
            
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function update2(Request $request, EntradaMedicamento $entrada)
    {
        try{
            $detalles = DetalleEntrada::where('entrada_medicamento_id', '=', $entrada->id)->get();
            //dd($detalles[0]->medicamento->nombreMedicamento);
            return view('entrada.update', compact('entrada', 'detalles'));
            
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
    public function store(EntradaRequest $request)
    {
        try {
            $detalles = $request->detalles;

            //dd($detalles);
            foreach ($detalles as $detalle) {
                $medicamento = Medicamento::find($detalle['idMed']);
                $medicamento->cantidadMedicamento = $medicamento->cantidadMedicamento + $detalle['cantidadEntrada'];
                $medicamento->save();
            }

            $fecha = date("Y-m-d");

            $entrada = EntradaMedicamento::find($request->entrada_id);
            $entrada->proveedorEntrada = $request->proveedorEntrada;
            $entrada->fechaEntrada = $fecha;
            $entrada->montoEntrada = $request->montoEntrada;
            $entrada->save();

            return redirect()->route('entrada.index')->with('status','Entrada creada correctamente');
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
    public function show(EntradaMedicamento $entrada)
    {
        try{
            $detalles = DetalleEntrada::where('entrada_medicamento_id', '=', $entrada->id)->get();
            //dd($detalles[0]->medicamento->nombreMedicamento);
            return view('entrada.show', compact('entrada', 'detalles'));
            
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  EntradaMedicamento $entrada
     * @return \Illuminate\Http\Response
     */
    public function edit(EntradaMedicamento $entrada)
    {
        try{
            $detalles = DetalleEntrada::where('entrada_medicamento_id', '=', $entrada->id)->get();
            $detallesOrig = DetalleEntrada::where('entrada_medicamento_id', '=', $entrada->id)->get();
            session(['detallesOrig' => $detallesOrig]);
            //dd($detalles[0]->medicamento->nombreMedicamento);
            return view('entrada.update', compact('entrada', 'detalles'));
            
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
    public function update(EntradaRequest $request)
    {
        try {
            $detalles = $request->detalles;
            $detallesOrig = session('detallesOrig');

            $cont = count($detallesOrig);
            
            for ($i=0; $i < $cont; $i++) { 

                foreach ($detalles as $detalle) {
                    $medicamento = Medicamento::find($detalle['idMed']);
                    if($detallesOrig[$i]['id'] == $detalle['id']){

                        if($detallesOrig[$i]['cantidadEntrada'] > $detalle['cantidadEntrada']){
                            $diferencia = $detallesOrig[$i]['cantidadEntrada'] - $detalle['cantidadEntrada'];
                            $medicamento->cantidadMedicamento = $medicamento->cantidadMedicamento - $diferencia;

                        }else if($detallesOrig[$i]['cantidadEntrada'] < $detalle['cantidadEntrada']){
                            $diferencia = $detalle['cantidadEntrada'] - $detallesOrig[$i]['cantidadEntrada'];
                            $medicamento->cantidadMedicamento = $medicamento->cantidadMedicamento + $diferencia;
        
                        }
                    }else{
                        $medicamento->cantidadMedicamento = $medicamento->cantidadMedicamento + $detalle['cantidadEntrada'];
                        $medicamento->save();
                    }
                    
                    $medicamento->save();
                }
            }

            $entrada = EntradaMedicamento::find($request->entrada_id);
            $entrada->proveedorEntrada = $request->proveedorEntrada;
            $entrada->montoEntrada = $request->montoEntrada;
            $entrada->save();

            session()->forget('detallesOrig');

            return redirect()->route('entrada.index')->with('status','Entrada actualizada correctamente');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  EntradaMedicamento $entrada
     * @return \Illuminate\Http\Response
     */
    public function destroy(EntradaMedicamento $entrada)
    {
        try{
            $entrada->delete();
            return redirect()->route('entrada.index')->with('status','Entrada eliminada correctamente');
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function destroy2(EntradaMedicamento $entrada)
    {
        try{
            $detalles = DetalleEntrada::where('entrada_medicamento_id', '=', $entrada->id)->get();
            if($detalles != null){
                foreach($detalles as $detalle){
                    $detalle->delete();
                }
            }

            $entrada->delete();
            return redirect()->route('entrada.index')->with('alert','Ha salido de la entrada de medicamentos');
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
}
