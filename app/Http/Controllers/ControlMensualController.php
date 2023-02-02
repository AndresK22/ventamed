<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SalidaRequest;
use App\Models\SalidaMedicamento;
use App\Models\DetalleSalida;
use App\Models\Medicamento;
use Exception;
use Illuminate\Database\Eloquent\Collection;

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
    public function index(Request $request)
    {
        try{
            return view('controlMensual.index');
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