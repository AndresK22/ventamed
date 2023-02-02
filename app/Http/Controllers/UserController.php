<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Exception;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            //$usuarios = User::all();
            $usuarios = DB::table('users')
            ->select('users.id', 'users.name', 'users.email', 'roles.id as rolId', 'roles.name as rol')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('users.id', '!=' , auth()->user()->id)
            ->where('roles.name', '!=', 'administrador')
            ->get();

            $usuariosaux = array();
            foreach($usuarios as $usuario){
                $user = User::find($usuario->id);

                if($user->hasRole('administrador')){
                    array_push($usuariosaux, true);
                }else{
                    array_push($usuariosaux, false);
                }
            }

            return view('user.index', compact('usuarios', 'usuariosaux'));
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
            $roles = Role::where('name','!=','administrador')->get();
            return view('user.create', compact('roles'));
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
    public function store(UserRequest $request)
    {
        try{
            $rol = Role::findById($request->rol);

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            $user->assignRole($rol);

            return redirect()->route('user.index')->with('status','Usuario creado correctamente');
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $roles = Role::where('name','!=','administrador')->get();

            $user = DB::table('users')
            ->select('users.id as id', 'users.name', 'users.email', 'roles.id as rolId', 'roles.name as rol')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('users.id', '=' , $id)
            ->get();

            return view('user.edit', compact('user', 'roles'));
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
    public function update(UserUpdateRequest $request, $id)
    {
        try{
            $rol = Role::findById($request->rol);
            
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            $user->syncRoles($rol);

            return redirect()->route('user.index')->with('status', 'Usuario actualizado con exito');
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id, $idRol
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $idRol)
    {
        try{
            $rol = Role::findById($idRol);
            
            $user = User::find($id);
            $user->removeRole($rol);
            $user->delete();

            return redirect()->route('user.index')->with('status', 'Usuario eliminado con exito');
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
}
