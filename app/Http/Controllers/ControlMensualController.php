<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SalidaRequest;
use App\Models\SalidaMedicamento;
use App\Models\DetalleSalida;
use App\Models\DetalleEntrada;
use App\Models\Medicamento;
use Exception;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Collection;
use LengthException;

require __DIR__ . '../../../../vendor/autoload.php';
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class ControlMensualController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            return view('controlMensual.index');
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function movProd()
    {
        try{
            $entradas = array();
            $salidas = array();

            $medicamentos = Medicamento::orderBy('nombreMedicamento', 'asc')->get();

            foreach ($medicamentos as $medicamento) {
                array_push($entradas, DB::table('detalle_entradas')
                ->rightJoin('medicamentos', 'detalle_entradas.medicamento_id', '=', 'medicamentos.id')
                ->join('entrada_medicamentos', 'detalle_entradas.entrada_medicamento_id', '=', 'entrada_medicamentos.id')
                ->where('medicamento_id', '=', $medicamento->id)
                ->get());

                array_push($salidas, DB::table('detalle_salidas')
                ->rightJoin('medicamentos', 'detalle_salidas.medicamento_id', '=', 'medicamentos.id')
                ->join('salida_medicamentos', 'detalle_salidas.salida_medicamento_id', '=', 'salida_medicamentos.id')
                ->where('medicamento_id', '=', $medicamento->id)
                ->get());
            }

            $totalCompra = 0;
            $totalSalida = 0;

            for ($i=0; $i < sizeof($medicamentos); $i++) { 
                if ($entradas[$i] != null){
                    foreach($entradas[$i] as $entrada){
                        $totalCompra += $entrada->precioEntrada;
                    }
                }
            }

            for ($i=0; $i < sizeof($medicamentos); $i++) { 
                if ($salidas[$i] != null){
                    foreach($salidas[$i] as $salida){
                        $totalSalida += $salida->subSalida;
                    }
                }
            }

            $pdf = Pdf::setPaper('Letter', 'landscape');
            $pdf->loadView('controlMensual.movProd', compact('medicamentos', 'entradas', 'salidas', 'totalCompra', 'totalSalida'));
            return $pdf->stream('Movimientos_Medicamentos_' . date("d/m/Y") . '.pdf');
        }catch(Exception $e){
            return $e->getMessage();
        }
    }


    /*public function movProdFech(Request $request)
    {
        try{
            $entradas = array();
            $salidas = array();

            $medicamentos = Medicamento::orderBy('nombreMedicamento', 'asc')->get();

            $fecha1 = $request->busquedaMov1;
            $fecha2 = $request->busquedaMov2;

            //Mostrar las salidas
            if($fecha1 == null){
                return redirect()->route('controlMensual.index')->with('alert','Debe seleccionar al menos una fecha');
            }elseif($fecha2 != null){
                foreach ($medicamentos as $medicamento) {
                    array_push($entradas, DB::table('detalle_entradas')
                    ->rightJoin('medicamentos', 'detalle_entradas.medicamento_id', '=', 'medicamentos.id')
                    ->join('entrada_medicamentos', 'detalle_entradas.entrada_medicamento_id', '=', 'entrada_medicamentos.id')
                    ->where('medicamento_id', '=', $medicamento->id)
                    ->whereBetween('fechaEntrada', [$fecha1, $fecha2])
                    ->get());
    
                    array_push($salidas, DB::table('detalle_salidas')
                    ->rightJoin('medicamentos', 'detalle_salidas.medicamento_id', '=', 'medicamentos.id')
                    ->join('salida_medicamentos', 'detalle_salidas.salida_medicamento_id', '=', 'salida_medicamentos.id')
                    ->where('medicamento_id', '=', $medicamento->id)
                    ->whereBetween('fechaSalida', [$fecha1, $fecha2])
                    ->get());
                }
            }else{
                foreach ($medicamentos as $medicamento) {
                    array_push($entradas, DB::table('detalle_entradas')
                    ->rightJoin('medicamentos', 'detalle_entradas.medicamento_id', '=', 'medicamentos.id')
                    ->join('entrada_medicamentos', 'detalle_entradas.entrada_medicamento_id', '=', 'entrada_medicamentos.id')
                    ->where('medicamento_id', '=', $medicamento->id)
                    ->where('fechaEntrada', '=', $fecha1)
                    ->get());
    
                    array_push($salidas, DB::table('detalle_salidas')
                    ->rightJoin('medicamentos', 'detalle_salidas.medicamento_id', '=', 'medicamentos.id')
                    ->join('salida_medicamentos', 'detalle_salidas.salida_medicamento_id', '=', 'salida_medicamentos.id')
                    ->where('medicamento_id', '=', $medicamento->id)
                    ->where('fechaSalida', '=', $fecha1)
                    ->get());
                }
            }

            $totalCompra = 0;
            $totalSalida = 0;

            for ($i=0; $i < sizeof($medicamentos); $i++) { 
                if ($entradas[$i] != null){
                    foreach($entradas[$i] as $entrada){
                        $totalCompra += $entrada->precioEntrada;
                    }
                }
            }

            for ($i=0; $i < sizeof($medicamentos); $i++) { 
                if ($salidas[$i] != null){
                    foreach($salidas[$i] as $salida){
                        $totalSalida += $salida->subSalida;
                    }
                }
            }

            $pdf = Pdf::setPaper('Letter', 'landscape');
            $pdf->loadView('controlMensual.movProdFech', compact('medicamentos', 'entradas', 'salidas', 'totalCompra', 'totalSalida', 'fecha1', 'fecha2'));
            return $pdf->stream('Movimientos_Medicamentos_' . date("d/m/Y", strtotime($fecha1)) . '_a_' . date("d/m/Y", strtotime($fecha2)) . '.pdf');
        }catch(Exception $e){
            return $e->getMessage();
        }
    }*/

    public function movProdFech(Request $request)
    {
        try{
            $salidas = array();

            $medicamentos = Medicamento::orderBy('nombreMedicamento', 'asc')->get();

            $fecha1 = $request->busquedaMov1;
            $fecha2 = $request->busquedaMov2;

            //Mostrar las salidas
            if($fecha1 == null){
                return redirect()->route('controlMensual.index')->with('alert','Debe seleccionar al menos una fecha');
            }elseif($fecha2 != null){
                foreach ($medicamentos as $medicamento) {    
                    array_push($salidas, DB::table('detalle_salidas')
                    ->rightJoin('medicamentos', 'detalle_salidas.medicamento_id', '=', 'medicamentos.id')
                    ->join('salida_medicamentos', 'detalle_salidas.salida_medicamento_id', '=', 'salida_medicamentos.id')
                    ->where('medicamento_id', '=', $medicamento->id)
                    ->whereBetween('fechaSalida', [$fecha1, $fecha2])
                    ->get());
                }
            }else{
                foreach ($medicamentos as $medicamento) {
    
                    array_push($salidas, DB::table('detalle_salidas')
                    ->rightJoin('medicamentos', 'detalle_salidas.medicamento_id', '=', 'medicamentos.id')
                    ->join('salida_medicamentos', 'detalle_salidas.salida_medicamento_id', '=', 'salida_medicamentos.id')
                    ->where('medicamento_id', '=', $medicamento->id)
                    ->where('fechaSalida', '=', $fecha1)
                    ->get());
                }
            }

            $totalSalida = 0;

            for ($i=0; $i < sizeof($medicamentos); $i++) { 
                if ($salidas[$i] != null){
                    foreach($salidas[$i] as $salida){
                        $totalSalida += $salida->subSalida;
                    }
                }
            }

            $pdf = Pdf::setPaper('Letter', 'landscape');
            $pdf->loadView('controlMensual.movProdFech', compact('medicamentos', 'salidas', 'totalSalida', 'fecha1', 'fecha2'));
            return $pdf->stream('Movimientos_Medicamentos_' . date("d/m/Y", strtotime($fecha1)) . '_a_' . date("d/m/Y", strtotime($fecha2)) . '.pdf');
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function ventaMensual(Request $request)
    {
        try{
            /*$fecha1 = $request->busquedaSalida1;

            if($fecha1 != null){
                $salidas = SalidaMedicamento::orderBy('fechaSalida', 'desc')
                ->orderBy('horaSalida', 'desc')
                ->fechaSalida1($fecha1)
                ->get();

                $detalles = array();
                foreach ($salidas as $salida) {
                    array_push($detalles, DetalleSalida::where('salida_medicamento_id', '=', $salida->id)->get());
                }

                $fechaTit = $fecha1;
            }else{
                $salidas = SalidaMedicamento::where('fechaSalida', '=', date("Y-m-d"))
                ->orderBy('fechaSalida', 'desc')
                ->orderBy('horaSalida', 'desc')
                ->get();

                $detalles = array();
                foreach ($salidas as $salida) {
                    array_push($detalles, DetalleSalida::where('salida_medicamento_id', '=', $salida->id)->get());
                }

                $fechaTit = date("m/Y");
            }*/

            $inicioMes = date("Y-m-01");
            $finMes = date("Y-m-t");
            $salidas = SalidaMedicamento::whereBetween('fechaSalida', [$inicioMes, $finMes])
                ->orderBy('fechaSalida', 'desc')
                ->orderBy('horaSalida', 'desc')
                ->get();

            return view('controlMensual.index', compact('salidas'));
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

}