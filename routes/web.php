<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AutController;

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

Route::view('dashboard', 'dashboard')->name('dashboard')->middleware('auth');

Route::group(['middleware' => ['role:administrador']], function () {
    //----------------------------Usuarios------------------------
    //Inicio
    Route::get('user', [UserController::class, 'index'])->name('user.index')->middleware('auth');
    //Crear
    Route::get('user/create', [UserController::class, 'create'])->name('user.create')->middleware('auth');
    Route::post('user/store', [UserController::class,'store'])->name('user.store')->middleware('auth');
    //Editar
    Route::get('user/edit/{user}', [UserController::class, 'edit'])->name('user.edit')->middleware('auth');
    Route::put('user/update/{user}', [UserController::class,'update'])->name('user.update')->middleware('auth');
    //Eliiminar
    Route::put('user/destroy/{user}', [UserController::class,'destroy'])->name('user.destroy')->middleware('auth');
});


//----------------------------Medicamentos------------------------
//Inicio
Route::view('medicamento', 'medicamento.index')->name('medicamento.index')->middleware('auth');

//----------------------------EntradaMedicamento------------------------
//Inicio
Route::view('entrada', 'entrada.index')->name('entrada.index')->middleware('auth');