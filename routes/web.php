<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AutController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\EntradaMedicamentoController;
use App\Http\Controllers\DetalleEntradaController;
use App\Http\Controllers\SalidaMedicamentoController;
use App\Http\Controllers\DetalleSalidaController;
use App\Http\Controllers\ControlMensualController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//----------------------------Autenticacion------------------------
//Inicio
Route::get('/', [AutController::class,'index'])->name('login')->middleware('guest');
//Crear primer usuario
Route::view('register', 'aut.create')->name('register')->middleware('guest');
Route::post('register/store', [AutController::class,'store'])->name('register.store')->middleware('guest');
//Iniciar sesion
Route::post('login', [AutController::class,'login'])->name('login.login')->middleware('guest');
//Cerrar sesion
Route::post('logout', [AutController::class,'logout'])->name('logout')->middleware('auth');

//Vista inicial dashboard
Route::get('dashboard', [AutController::class,'dashboard'])->name('dashboard')->middleware('auth');

//------------------------------------Usuarios-------------------------------------
Route::group(['middleware' => ['role:administrador']], function () {
    //Inicio
    Route::get('user', [UserController::class, 'index'])->name('user.index')->middleware('auth');
    //Crear
    Route::get('user/create', [UserController::class, 'create'])->name('user.create')->middleware('auth');
    Route::post('user/store', [UserController::class,'store'])->name('user.store')->middleware('auth');
    //Editar
    Route::get('user/edit/{user}', [UserController::class, 'edit'])->name('user.edit')->middleware('auth');
    Route::put('user/update/{user}', [UserController::class,'update'])->name('user.update')->middleware('auth');
    //Eliminar
    Route::get('user/destroy/{user}/{rol}', [UserController::class,'destroy'])->name('user.destroy')->middleware('auth');
});

//------------------------------------Medicamentos-------------------------------
Route::group(['middleware' => ['role:administrador|gerente|usuario']], function () {
    //Inicio
    Route::get('medicamento', [MedicamentoController::class, 'index'])->name('medicamento.index')->middleware('auth');
    //Crear
    Route::get('medicamento/create', [MedicamentoController::class, 'create'])->name('medicamento.create')->middleware('auth');
    Route::post('medicamento/store', [MedicamentoController::class,'store'])->name('medicamento.store')->middleware('auth');
    Route::post('medicamento/store2', [MedicamentoController::class,'store2'])->name('medicamento.store2')->middleware('auth');
    //Crear pdf
    Route::get('medicamento/pdf', [MedicamentoController::class,'pdf'])->name('medicamento.pdf')->middleware('auth');
    //Editar
    Route::get('medicamento/edit/{medicamento}', [MedicamentoController::class, 'edit'])->name('medicamento.edit')->middleware('auth');
    Route::put('medicamento/update/{medicamento}', [MedicamentoController::class,'update'])->name('medicamento.update')->middleware('auth');
    Route::put('medicamento/update2/{medicamento}', [MedicamentoController::class,'update2'])->name('medicamento.update2')->middleware('auth');
    //Eliminar
    Route::get('medicamento/destroy/{medicamento}/', [MedicamentoController::class,'destroy'])->name('medicamento.destroy')->middleware('auth');
});

//------------------------------------Entrada de medicamentos-------------------------------
//Inicio
Route::get('entrada', [EntradaMedicamentoController::class, 'index'])->name('entrada.index')->middleware('auth');
//Crear
Route::get('entrada/create', [EntradaMedicamentoController::class, 'create'])->name('entrada.create')->middleware('auth');
Route::get('entrada/create/{entrada}', [EntradaMedicamentoController::class, 'create2'])->name('entrada.create2')->middleware('auth');
Route::put('entrada/store', [EntradaMedicamentoController::class,'store'])->name('entrada.store')->middleware('auth');
//Buscar
Route::post('entrada/buscMed', [EntradaMedicamentoController::class,'buscMed'])->name('entrada.buscMed')->middleware('auth');
//Ver
Route::get('entrada/show/{entrada}', [EntradaMedicamentoController::class, 'show'])->name('entrada.show')->middleware('auth');
//Editar
Route::get('entrada/edit/{entrada}', [EntradaMedicamentoController::class, 'edit'])->name('entrada.edit')->middleware('auth');
Route::put('entrada/update/{entrada}', [EntradaMedicamentoController::class,'update'])->name('entrada.update')->middleware('auth');
Route::get('entrada/update2/{entrada}', [EntradaMedicamentoController::class,'update2'])->name('entrada.update2')->middleware('auth');
//Eliminar
Route::get('entrada/destroy/{entrada}', [EntradaMedicamentoController::class,'destroy'])->name('entrada.destroy')->middleware('auth');
Route::get('entrada/destroy2/{entrada}', [EntradaMedicamentoController::class,'destroy2'])->name('entrada.destroy2')->middleware('auth');

//------------------------------------Detalle Entrada de medicamentos-------------------------------
//Crear
Route::post('detaEnt/store', [DetalleEntradaController::class,'store'])->name('detaEnt.store')->middleware('auth');
Route::post('detaEnt/store2', [DetalleEntradaController::class,'store2'])->name('detaEnt.store2')->middleware('auth');
//Editar
Route::put('detaEnt/update/{entrada}/{detalle}', [DetalleEntradaController::class,'update'])->name('detaEnt.update')->middleware('auth');
Route::put('detaEnt/update2/{entrada}/{detalle}', [DetalleEntradaController::class,'update2'])->name('detaEnt.update2')->middleware('auth');
//Eliminar
Route::get('detaEnt/destroy/{entrada}/{detalle}', [DetalleEntradaController::class,'destroy'])->name('detaEnt.destroy')->middleware('auth');
Route::get('detaEnt/destroy2/{entrada}/{detalle}', [DetalleEntradaController::class,'destroy2'])->name('detaEnt.destroy2')->middleware('auth');


//------------------------------------Salida de medicamentos-------------------------------
//Inicio
Route::get('salida', [SalidaMedicamentoController::class, 'index'])->name('salida.index')->middleware('auth');
//Crear
Route::get('salida/create', [SalidaMedicamentoController::class, 'create'])->name('salida.create')->middleware('auth');
Route::get('salida/create/{salida}', [SalidaMedicamentoController::class, 'create2'])->name('salida.create2')->middleware('auth');
Route::put('salida/store', [SalidaMedicamentoController::class,'store'])->name('salida.store')->middleware('auth');
//Buscar
Route::post('salida/buscMed', [SalidaMedicamentoController::class,'buscMed'])->name('salida.buscMed')->middleware('auth');
//Ver
Route::get('salida/show/{salida}', [SalidaMedicamentoController::class, 'show'])->name('salida.show')->middleware('auth');
//Editar
Route::get('salida/edit/{salida}', [SalidaMedicamentoController::class, 'edit'])->name('salida.edit')->middleware('auth');
Route::get('salida/edit2/{salida}', [SalidaMedicamentoController::class,'edit2'])->name('salida.edit2')->middleware('auth');
Route::put('salida/update/{salida}', [SalidaMedicamentoController::class,'update'])->name('salida.update')->middleware('auth');
//Eliminar
Route::get('salida/destroy/{salida}', [SalidaMedicamentoController::class,'destroy'])->name('salida.destroy')->middleware('auth');
Route::get('salida/destroy2/{salida}', [SalidaMedicamentoController::class,'destroy2'])->name('salida.destroy2')->middleware('auth');
//Imprimir
Route::get('salida/imp/{salida}', [SalidaMedicamentoController::class,'imp'])->name('salida.imp')->middleware('auth');

//------------------------------------Detalle Salida de medicamentos-------------------------------
//Crear
Route::post('detaSal/store', [DetalleSalidaController::class,'store'])->name('detaSal.store')->middleware('auth');
Route::post('detaSal/store2', [DetalleSalidaController::class,'store2'])->name('detaSal.store2')->middleware('auth');
//Editar
Route::put('detaSal/update/{salida}/{detalle}', [DetalleSalidaController::class,'update'])->name('detaSal.update')->middleware('auth');
Route::put('detaSal/update2/{salida}/{detalle}', [DetalleSalidaController::class,'update2'])->name('detaSal.update2')->middleware('auth');
//Eliminar
Route::get('detaSal/destroy/{salida}/{detalle}', [DetalleSalidaController::class,'destroy'])->name('detaSal.destroy')->middleware('auth');
Route::get('detaSal/destroy2/{salida}/{detalle}', [DetalleSalidaController::class,'destroy2'])->name('detaSal.destroy2')->middleware('auth');


//------------------------------------VentaDiaria-------------------------------
Route::get('ventaDiaria', [SalidaMedicamentoController::class, 'ventaDiaria'])->name('ventaDiaria.index')->middleware('auth');
Route::get('ventaDiaria/show/{salida}', [SalidaMedicamentoController::class, 'show2'])->name('ventaDiaria.show')->middleware('auth');
Route::get('salida/imp2/{salida}', [SalidaMedicamentoController::class,'imp2'])->name('ventaDiaria.imp')->middleware('auth');

//------------------------------------VentaMensual-------------------------------
Route::group(['middleware' => ['role:administrador|gerente']], function () {
    //Inicio
    Route::get('controlMensual', [ControlMensualController::class, 'index'])->name('controlMensual.index')->middleware('auth');
    //Movimientos de productos
    Route::get('controlMensual/movProd', [ControlMensualController::class,'movProd'])->name('controlMensual.movProd')->middleware('auth');
    //Movimientos de productos por fecha
    Route::get('controlMensual/movProdFech', [ControlMensualController::class,'movProdFech'])->name('controlMensual.movProdFech')->middleware('auth');
});