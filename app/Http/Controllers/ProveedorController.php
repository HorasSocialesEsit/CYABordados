<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use App\Models\ProveedorMaterial;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedores = Proveedor::all();
        return view('app.proveedor.proveedores', compact('proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.proveedor.proveedorCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validamos que los campos no vengan vacios
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);
        // creamos el nuevo proveedor
        Proveedor::create([
            'nombre' => $request->input('nombre'),
            'telefono' => $request->input('telefono'),
            'email' => $request->input('email'),
        ]);
        return redirect()->route('proveedor.index')->with('success', 'Proveedor creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('app.proveedor.proveedorEdit', ['proveedor' => Proveedor::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validamos que los campos no vengan vacios
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

 
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->nombre = $request->input('nombre');
        $proveedor->telefono = $request->input('telefono');
        $proveedor->email = $request->input('email');
        $proveedor->save();
        return redirect()->route('proveedor.index')->with('success', 'Proveedor actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // validamos si tiene hilos asociados antes de eliminar
        $validacion = ProveedorMaterial::where('proveedor_id', $id)->first();
        if ($validacion) {
            return redirect()->route('proveedor.index')->with('error', 'No se puede eliminar el proveedor porque tiene materiales asociados.');
        }

        // en caso de no tener asociados, procedemos a eliminar
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->delete();
        return redirect()->route('proveedor.index')->with('success', 'Proveedor eliminado correctamente.');
    }
}
