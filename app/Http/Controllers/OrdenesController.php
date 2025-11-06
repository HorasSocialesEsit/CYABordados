<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Material;
use App\Models\Orden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrdenesController extends Controller
{
    /**
     * Mostrar listado de órdenes.
     */
    public function index()
    {
        $ordenes = Orden::with('cliente', 'usuario')->latest()->get();

        return view('app.recepcion.ListaOrdenes', compact('ordenes'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        $clientes = Cliente::where('estado', 'Activo')->get();
        $hilos = Material::all();

        return view('app.recepcion.CrearOrden', compact('clientes', 'hilos'));
    }

    /**
     * Guardar nueva orden con sus detalles.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha_entrega' => 'required|date',
            'detalles' => 'required|array|min:1',
            'detalles.*.nombre_arte' => 'required|string|max:100',
            'detalles.*.cantidad' => 'required|integer|min:1',
            'detalles.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // Generar código único para la orden
            $codigo = 'ORD-'.strtoupper(Str::random(6));

            // Crear orden principal
            $orden = Orden::create([
                'cliente_id' => $request->cliente_id,
                'fecha_orden' => now(),
                'codigo_orden' => $codigo,
                'fecha_entrega' => $request->fecha_entrega,
                'usuario_id' => Auth::id(),
                'notas' => $request->notas,
            ]);

            // Guardar detalles
            foreach ($request->detalles as $detalle) {
                $orden->detalles()->create([
                    'nombre_arte' => $detalle['nombre_arte'],
                    'tamaño_diseño' => $detalle['tamaño_diseño'] ?? null,
                    'color_hilo' => $detalle['color_hilo'] ?? null,
                    'ubicacion_prenda' => $detalle['ubicacion_prenda'] ?? null,
                    'tamaño_cuello' => $detalle['tamaño_cuello'] ?? null,
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $detalle['precio_unitario'],
                    'total' => $detalle['cantidad'] * $detalle['precio_unitario'],
                    'notas' => $detalle['notas'] ?? null,
                ]);
            }

            // Calcular totales
            $orden->actualizarTotales();

            DB::commit();

            return redirect()
                ->route('ordenes.index')
                ->with('success', 'Orden creada correctamente.');

        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'Error al crear la orden: '.$e->getMessage());
        }
    }

    /**
     * Mostrar una orden específica (detalles).
     */
    public function show($id)
    {
        $orden = Orden::with(['cliente', 'detalles'])->findOrFail($id);

        return view('app.recepcion.VerOrden', compact('orden'));
    }

    /**
     * Editar una orden.
     */
    public function edit($id)
    {
        $orden = Orden::with('detalles')->findOrFail($id);
        $clientes = Cliente::where('estado', 'Activo')->get();

        return view('app.recepcion.EditarOrden', compact('orden', 'clientes'));
    }

    /**
     * Actualizar orden.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha_entrega' => 'required|date',
        ]);

        $orden = Orden::findOrFail($id);

        $orden->update([
            'cliente_id' => $request->cliente_id,
            'fecha_entrega' => $request->fecha_entrega,
            'notas' => $request->notas,
        ]);

        return redirect()
            ->route('ordenes.index')
            ->with('success', 'Orden actualizada correctamente.');
    }

    /**
     * Eliminar una orden.
     */
    public function destroy($id)
    {
        $orden = Orden::findOrFail($id);
        $orden->delete();

        return redirect()
            ->route('ordenes.index')
            ->with('success', 'Orden eliminada correctamente.');
    }
}
