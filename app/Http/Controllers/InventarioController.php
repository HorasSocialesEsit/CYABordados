<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventario = Material::all();
        return view('app.administrador.inventario.listInventario', compact('inventario'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tiposHilo = ['Algodon', 'Poliester'];
        return view('app.administrador.inventario.inventarioCreate', compact('tiposHilo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:50|unique:materiales,codigo',
            'descripcion' => 'nullable|string',
            'tipoHilo' => 'required|in:Algodon,Poliester',
            'stock' => 'required|integer|min:1',
        ], [
            'nombre.required' => 'El nombre del material es obligatorio.',
            'nombre.string' => 'El nombre debe ser un texto válido.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',

            'codigo.required' => 'El código del material es obligatorio.',
            'codigo.string' => 'El código debe ser un texto válido.',
            'codigo.max' => 'El código no puede tener más de 50 caracteres.',
            'codigo.unique' => 'El código ingresado ya está registrado.',

            'descripcion.string' => 'La descripción debe ser un texto válido.',

            'tipoHilo.required' => 'Debe seleccionar un tipo de hilo.',
            'tipoHilo.in' => 'El tipo de hilo seleccionado no es válido.',

            'stock.required' => 'Debe especificar el stock del material.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock debe ser al menos 1 unidad.',
        ]);
        Material::create($validated);
        return redirect()->route('inventario.index')->with('success', 'Hilo agregado correctamente.');
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
        $tiposHilo = ['Algodon', 'Poliester'];
        $hilo = Material::findOrFail($id);
        return view('app.administrador.inventario.inventarioEdit', compact('tiposHilo', 'hilo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $material = Material::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => [
                'required',
                'string',
                'max:50',
                Rule::unique('materiales', 'codigo')->ignore($material->id),
            ],
            'descripcion' => 'nullable|string',
            'tipoHilo' => 'required|in:Algodon,Poliester',
            'stock' => 'required|integer|min:1',
        ], [
            'nombre.required' => 'El nombre del material es obligatorio.',
            'nombre.string' => 'El nombre debe ser un texto válido.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',

            'codigo.required' => 'El código del material es obligatorio.',
            'codigo.string' => 'El código debe ser un texto válido.',
            'codigo.max' => 'El código no puede tener más de 50 caracteres.',
            'codigo.unique' => 'El código ingresado ya está registrado para otro material.',

            'descripcion.string' => 'La descripción debe ser un texto válido.',

            'tipoHilo.required' => 'Debe seleccionar un tipo de hilo.',
            'tipoHilo.in' => 'El tipo de hilo seleccionado no es válido.',

            'stock.required' => 'Debe especificar el stock del material.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' =>  'El stock debe ser al menos 1 unidad.',
        ]);

        $material->update($validated);

        return redirect()->route('inventario.index')->with('success', 'Hilo actualizado correctamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // antes de hacer esto vamos a validar si ya se utilizo el hilo en algun otro proceso

            $material = Material::findOrFail($id);
            $material->delete();
            return redirect()->route('inventario.index')->with('success', 'Hilo Eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('inventario.index')->with('error', 'Error al eliminar hilo ');
        }
    }

    public function reporte()
    {
        $inventario = Material::orderBy('stock', 'asc')->orderBy('nombre', 'asc')->get();
        $fecha = (new Componentes())->fechaActual();
        $nombre_persona = "Pedro Perez";

        $pdf = PDF::loadView('app.reportes.inventario.inventarioHilos', compact('fecha', 'inventario', 'nombre_persona'));
        $pdf->setPaper('letter');
        return $pdf->stream('Inventario Hilos.pdf');
    }
}
