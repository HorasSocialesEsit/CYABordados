<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::with('roles')->get();
        return view('app.administrador.usuarios.listaUsuarios', compact('usuarios'));
    }

    public function create()
    {
        $roles = Role::all(); // Trae todos los roles de la tabla roles
        return view('app.administrador.usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'roles' => 'required|array',
            'estado' => 'required',
            'password' => 'required|min:8',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->estado = $request->estado;
        $user->password = Hash::make($request->password);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('uploads', 'public');
            $user->foto = $path;
        }

        // 1. Guardar el usuario primero
        $user->save();

        // 2. Asignar roles después de que exista
        if ($request->filled('roles')) {
            $user->roles()->sync($request->roles);
        }


        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente');
    }

    public function edit(User $user)
    {
        $roles = Role::all(); // Trae todos los roles de la tabla roles
        return view('app.administrador.usuarios.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => "required|email|unique:users,email,{$user->id}",
            'roles' => 'required|array',
            'estado' => 'required',
        ]);

        $previousEstado = $user->estado; // Guardamos estado anterior

        $user->name = $request->name;
        $user->email = $request->email;
        $user->roles()->sync($request->roles); // reemplaza los roles actuales por los nuevos

        $user->estado = $request->estado;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            // Borrar la foto anterior si existe
            if ($user->foto && \Storage::disk('public')->exists($user->foto)) {
                \Storage::disk('public')->delete($user->foto);
            }

            // Subir nueva
            $path = $request->file('foto')->store('uploads', 'public');
            $user->foto = $path;
        }
        $user->save();

        // Si cambió de activo a inactivo, eliminar todas sus sesiones
        if ($previousEstado === 'activo' && $user->estado === 'inactivo') {
            DB::table('sessions')->where('user_id', $user->id)->delete();
        }


        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente');
    }
}
