<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AutController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\EntradaMedicamentoController;

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
Route::view('dashboard', 'dashboard')->name('dashboard')->middleware('auth');

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
    //Eliiminar
    Route::get('user/destroy/{user}/{rol}', [UserController::class,'destroy'])->name('user.destroy')->middleware('auth');
});

//------------------------------------Medicamentos-------------------------------
Route::group(['middleware' => ['role:administrador|gerente']], function () {
    //Inicio
    Route::get('medicamento', [MedicamentoController::class, 'index'])->name('medicamento.index')->middleware('auth');
    //Crear
    Route::get('medicamento/create', [MedicamentoController::class, 'create'])->name('medicamento.create')->middleware('auth');
    Route::post('medicamento/store', [MedicamentoController::class,'store'])->name('medicamento.store')->middleware('auth');
    Route::post('medicamento/store2', [MedicamentoController::class,'store2'])->name('medicamento.store2')->middleware('auth');
    //Editar
    Route::get('medicamento/edit/{medicamento}', [MedicamentoController::class, 'edit'])->name('medicamento.edit')->middleware('auth');
    Route::put('medicamento/update/{medicamento}', [MedicamentoController::class,'update'])->name('medicamento.update')->middleware('auth');
    Route::put('medicamento/update2/{medicamento}', [MedicamentoController::class,'update2'])->name('medicamento.update2')->middleware('auth');
    //Eliiminar
    Route::get('medicamento/destroy/{medicamento}/', [MedicamentoController::class,'destroy'])->name('medicamento.destroy')->middleware('auth');
});

//------------------------------------Entrada de medicamentos-------------------------------
//Inicio
Route::get('entrada', [EntradaMedicamentoController::class, 'index'])->name('entrada.index')->middleware('auth');
//Crear
Route::get('entrada/create', [EntradaMedicamentoController::class, 'create'])->name('entrada.create')->middleware('auth');
Route::post('entrada/store', [EntradaMedicamentoController::class,'store'])->name('entrada.store')->middleware('auth');
//Route::post('entrada/store2', [EntradaMedicamentoController::class,'store2'])->name('entrada.store2')->middleware('auth');
//Editar
Route::get('entrada/edit/{medicamento}', [EntradaMedicamentoController::class, 'edit'])->name('entrada.edit')->middleware('auth');
Route::put('entrada/update/{medicamento}', [EntradaMedicamentoController::class,'update'])->name('entrada.update')->middleware('auth');
//Route::put('entrada/update2/{medicamento}', [EntradaMedicamentoController::class,'update2'])->name('entrada.update2')->middleware('auth');
//Eliiminar
Route::get('entrada/destroy/{medicamento}/', [EntradaMedicamentoController::class,'destroy'])->name('entrada.destroy')->middleware('auth');