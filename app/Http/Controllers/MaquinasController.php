<?php

namespace App\Http\Controllers;

use App\Models\Maquinas;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\UniqueConstraintViolationException;

class MaquinasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maquinas = Maquinas::all();
        return view('app.configuraciones.maquinas.listMaquinas', compact('maquinas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.configuraciones.maquinas.maquinaCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'           => 'required|string|max:100|unique:maquinas,nombre',
            'cabezales'        => 'required|integer|min:1',
            'cabezales_danado' => 'nullable|integer|min:0|lte:cabezales',
            'rpm'              => 'nullable|integer'
        ], [
            'rpm.integer' => 'Los rmp deben ser un número entero.',


            'nombre.unique' => 'El nombre de la máquina ya está registrado.',

            'cabezales.required' => 'Debe ingresar la cantidad total de cabezales.',
            'cabezales.integer'  => 'Los cabezales deben ser un número entero.',
            'cabezales.min'      => 'Debe haber al menos un cabezal.',

            'cabezales_danado.integer' => 'Los cabezales dañados deben ser un número entero.',
            'cabezales_danado.min'     => 'Los cabezales dañados no pueden ser negativos.',
            'cabezales_danado.lte'     => 'Los cabezales dañados no pueden ser mayores que los cabezales totales.'
        ]);


        try {
            Maquinas::create([
                'nombre'    => $request->nombre,
                'cabezales' => $request->cabezales,
                'cabezales_danado' => $request->cabezales_danado ?? 0,
                'rpm' => $request->rpm
            ]);

            return redirect()
                ->route('maquinas.index')
                ->with('success', 'Máquina creada correctamente');
        } catch (UniqueConstraintViolationException $e) {

            return redirect()
                ->route('maquinas.index')
                ->with('error', 'Ya existe una máquina con ese nombre y cabezales.');
        } catch (Exception $e) {
            return redirect()
                ->route('maquinas.index')
                ->with('error', 'Error Inesperado al crear maquina');
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $maquina = Maquinas::findOrFail($id);
        return view('app.maquinas.show', compact('maquina'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $maquina = Maquinas::findOrFail($id);
        return view('app.configuraciones.maquinas.maquinaEdit', compact('maquina'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre'    => 'required|string|max:100',
            'cabezales' => 'required|integer|min:1',
            'cabezales_danado' => 'nullable|integer|min:0|lte:cabezales',
            'rpm'       => 'integer'
        ], [
            'rpm.integer' => 'Los rmp deben ser un número entero.',

            'cabezales.required' => 'Debe ingresar la cantidad total de cabezales.',
            'cabezales.integer'  => 'Los cabezales deben ser un número entero.',
            'cabezales.min'      => 'Debe haber al menos un cabezal.',

            'cabezales_danado.integer' => 'Los cabezales dañados deben ser un número entero.',
            'cabezales_danado.min'     => 'Los cabezales dañados no pueden ser negativos.',
            'cabezales_danado.lte'     => 'Los cabezales dañados no pueden ser mayores que los cabezales totales.'
        ]);

        $maquina = Maquinas::findOrFail($id);

        $maquina->update([
            'nombre'    => $request->nombre,
            'cabezales' => $request->cabezales,
            'cabezales_danado' => $request->cabezales_danado,
            'rpm'       => $request->rpm
        ]);

        return redirect()->route('maquinas.index')
            ->with('success', 'Máquina actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $maquina = Maquinas::findOrFail($id);
        $maquina->delete();

        return redirect()->route('maquinas.index')
            ->with('success', 'Máquina eliminada correctamente');
    }
}
