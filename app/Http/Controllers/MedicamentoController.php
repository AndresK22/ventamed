<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MedicamentoRequest;
use App\Http\Requests\MedicamentoUpdateRequest;
use App\Models\Medicamento;
use Exception;
use Barryvdh\DomPDF\Facade\Pdf;

class MedicamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $nombreMedicamento = $request->busquedaMedicamento;
            $codBarras = $request->busquedaCodBarras;

            $medicamentos = Medicamento::orderBy('nombreMedicamento', 'asc')
            ->nombreMedicamento($nombreMedicamento)
            ->codBarras($codBarras)
            ->paginate(20);

            return view('medicamento.index', compact('medicamentos'));
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
            return view('medicamento.create');
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
    public function store(MedicamentoRequest $request)
    {
        try{
            $medicamento = new Medicamento();
            $medicamento->codBarras = $request->codBarras;
            $medicamento->nombreMedicamento = $request->nombreMedicamento;
            $medicamento->cantidadMedicamento = $request->cantidadMedicamento;
            $medicamento->precioUnitario = $request->precioUnitario;
            $medicamento->save();

            return redirect()->route('medicamento.index')->with('status','Medicamento creado correctamente');
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store2(MedicamentoRequest $request)
    {
        try{
            $medicamento = new Medicamento();
            $medicamento->codBarras = $request->codBarras;
            $medicamento->nombreMedicamento = $request->nombreMedicamento;
            $medicamento->cantidadMedicamento = 0;
            $medicamento->precioUnitario = $request->precioUnitario;
            $medicamento->save();

            return redirect()->route('medicamento.index')->with('status','Medicamento creado correctamente');
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Medicamento  $medicamento
     * @return \Illuminate\Http\Response
     */
    public function edit(Medicamento $medicamento)
    {
        try{
            return view('medicamento.update', compact('medicamento'));
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\MedicamentoUpdateRequest  $request
     * @param  Medicamento  $medicamento
     * @return \Illuminate\Http\Response
     */
    public function update(MedicamentoUpdateRequest $request, Medicamento $medicamento)
    {
        try{
            $medicamento->codBarras = $request->codBarras;
            $medicamento->nombreMedicamento = $request->nombreMedicamento;
            $medicamento->cantidadMedicamento = $request->cantidadMedicamento;
            $medicamento->precioUnitario = $request->precioUnitario;
            $medicamento->save();
            return redirect()->route('medicamento.index')->with('status','Medicamento actualizado correctamente');
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\MedicamentoUpdateRequest  $request
     * @param  Medicamento  $medicamento
     * @return \Illuminate\Http\Response
     */
    public function update2(MedicamentoUpdateRequest $request, Medicamento $medicamento)
    {
        try{
            $medicamento->codBarras = $request->codBarras;
            $medicamento->nombreMedicamento = $request->nombreMedicamento;
            $medicamento->precioUnitario = $request->precioUnitario;
            $medicamento->save();
            return redirect()->route('medicamento.index')->with('status','Medicamento actualizado correctamente');
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Medicamento  $medicamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Medicamento $medicamento)
    {
        try{
            $medicamento->delete();
            return redirect()->route('medicamento.index')->with('status', 'Medicamento eliminado con exito');
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function pdf()
    {
        try{
            $medicamentos = Medicamento::orderBy('nombreMedicamento', 'asc')->get();

            $pdf = Pdf::loadView('medicamento.pdf', compact('medicamentos'));
            return $pdf->stream('Listado_Medicamentos_' . date("d/m/Y") . '.pdf');
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
}
