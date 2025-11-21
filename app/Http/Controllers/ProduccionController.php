<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Material;
use App\Models\Orden;
use Illuminate\Http\Request;

class ProduccionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ordenes = Orden::where('estado_orden_id', '2')->get(); // Estado '1' para nuevas ordenes
        return view('app.produccion.arte.OrdenesNuevas', compact('ordenes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        $clientes = Cliente::where('estado', 'Activo')->get();
        $hilos = Material::all();

        return view('app.produccion.arte.ProcesarOrdenArte', compact('clientes', 'hilos'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
        Orden::where('id', $id)->update([
            'estado_orden_id' => '2',
        ]);
        $orden = Orden::with('detalles')->findOrFail($id);

        $clientes = Cliente::where('estado', 'Activo')->get();

        return view('app.produccion.arte.ProcesarOrdenArte', compact('orden', 'clientes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
