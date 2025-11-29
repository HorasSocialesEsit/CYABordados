<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Material;
use App\Models\Orden;
use App\Models\OrdenDetalle;
use Illuminate\Http\Request;
use Nette\Utils\Json;

class ProduccionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $ordenes = Orden::where('estado_orden_id', '2')->orderBy('fecha_entrega', 'asc')->get(); // Estado '1' para nuevas ordenes

        $ordenes = Orden::with(['estado', 'cliente']) // agrega aquí las relaciones que usas en la vista
            ->where('estado_orden_id', 2)
            ->orderBy('fecha_entrega', 'asc')
            ->get();

        return view('app.produccion.arte.OrdenesPendienteArte', compact('ordenes'));
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

        // $orden = Orden::with('detalles')->findOrFail($id);
        $orden = Orden::with('detalles.hilos.material')->findOrFail($id);

        // return Json::encode($orden);
        //  $id_detalles = OrdenDetalle::where('orden_id', $id)->get();

        $clientes = Cliente::where('estado', 'Activo')->get();

        //  $detallehilo = OrdenDetalle::with('hilos.material')->findOrFail($id_detalles);

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
