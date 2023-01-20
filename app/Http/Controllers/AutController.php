<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Exception;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $usuarios = User::all()->first();
            if($usuarios == null){
                return redirect()->route('register')->with('status','Debe crear un usuario para utilizar el sistema');
            }else{
                return view('login');
            }
        }catch (Exception $e){
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
        return view('aut.create')->with('status','Debe crear un usuario para utilizar el sistema');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        try{

            $rol1 = Role::create(['name' => 'administrador']);
            $rol2 = Role::create(['name' => 'gerente']);
            $rol3 = Role::create(['name' => 'usuario']);
            //$permission = Permission::create(['name' => 'edit articles']);

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            $user->assignRole($rol1);

            return redirect()->route('login')->with('status','Registro de usuario correcto');
        }catch (Exception $e){
            return $e->getMessage();
        }
    }


    public function login(LoginRequest $request)
    {
        try{
            $credentials = $request->validated();
            if (Auth::attempt($credentials)){
                $request->session()->regenerate();
                return redirect()->intended('dashboard')->with('status','Inicio de sesion correcto');
            }else{
                return redirect()->route('dashboard')->with('status','No se pudo iniciar la sesion');
            }
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function logout(Request $request)
    {
        try{
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('status','Cerro la sesion correctamente');
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
}
