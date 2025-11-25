<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Departamentos;
use App\Models\Material;
use App\Models\Orden;
use App\Models\OrdenDetalle;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $ordenes = Orden::with(['cliente', 'usuario'])
            ->where('estado', 'nueva')
            ->selectRaw('ordenes.*, DATEDIFF(fecha_entrega, CURRENT_DATE()) as dias_atraso')
            ->orderByRaw('DATEDIFF(fecha_entrega, CURRENT_DATE()) ASC')
            ->get();

        // Agregar calculo de días restantes para cada orden
        foreach ($ordenes as $orden) {

            return view('app.recepcion.ListaOrdenes', compact('ordenes'));
        }
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        $clientes = Cliente::where('estado', 'Activo')->get();
        $hilos = Material::all();
        $departamentos = Departamentos::all();

        return view('app.recepcion.CrearOrden', compact('clientes', 'hilos', 'departamentos'));
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
            ]);

            // Guardar detalles
            foreach ($request->detalles as $detalleData) {
                $detalle = $orden->detalles()->create([
                    'nombre_arte' => $detalleData['nombre_arte'],
                    'tamaño_diseño' => $detalleData['tamaño_diseño'] ?? null,
                    'color_hilo' => $detalleData['color_hilo'] ?? null,
                    'ubicacion_prenda' => $detalleData['ubicacion_prenda'] ?? null,
                    'tamaño_cuello' => $detalleData['tamaño_cuello'] ?? null,
                    'cantidad' => $detalleData['cantidad'],
                    'precio_unitario' => $detalleData['precio_unitario'],
                    'total' => $detalleData['cantidad'] * $detalleData['precio_unitario'],
                    'notas' => $detalleData['notas'] ?? null,
                ]);

                // 🔹 Guardar los hilos asociados a este detalle (si vienen en el request)
                if (! empty($request->hilos)) {
                    foreach ($request->hilos as $materialId) {
                        $detalle->hilos()->create([
                            'material_id' => $materialId,
                            'cantidad' => 1,
                        ]);
                    }
                }
            }

            // Calcular totales
            $orden->actualizarTotales();

            // Guardar pago inicial si existe
            if ($request->filled('pago.monto') && $request->pago['monto'] > 0) {
                $montoPagado = $request->pago['monto'];
                $tipoPago = $request->pago['tipo'] ?? 'anticipo';
                $notaPago = $request->pago['nota'] ?? null;

                $totalOrden = $orden->detalles->sum('total');
                $saldoRestante = $totalOrden - $montoPagado;

                $orden->pagos()->create([
                    'monto' => $montoPagado,
                    'tipo' => $tipoPago,
                    'nota' => $notaPago,
                    'saldo_restante' => $saldoRestante,
                    'usuario_id' => Auth::id(),
                ]);
            }

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
            'PrecioTotal' => $request->input('pago.saldo_restante'),

        ]);
        $detalleData = $request->detalles[0];
        $ordenDetalle = OrdenDetalle::where('orden_id', $id)->first();
        $ordenDetalle->update([
            'nombre_arte' => $detalleData['nombre_arte'] ?? null,
            'tamaño_diseño' => $detalleData['tamaño_diseño'] ?? null,
            'ubicacion_prenda' => $detalleData['ubicacion_prenda'] ?? null,
            'tamaño_cuello' => $detalleData['tamaño_cuello'] ?? null,
            'cantidad' => $detalleData['cantidad'] ?? 1,
            'precio_unitario' => $detalleData['precio_unitario'] ?? 0,
            'total' => ($detalleData['cantidad'] ?? 1) * ($detalleData['precio_unitario'] ?? 0),
            'notas' => $detalleData['notas'] ?? null,
        ]);

        $OrdenPago = $orden->pagos()->where('orden_id', $id)->first();
        if ($OrdenPago) {
            $OrdenPago->update([
                'monto' => $request->input('pago.monto'),
                'tipo' => $request->input('pago.tipo'),
                'nota' => $request->input('pago.nota'),
                'saldo_restante' => $request->input('pago.saldo_restante'),
            ]);
        }

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

    public function reporteOrden($id)
    {
        $orden_buscada = Orden::with([
            'cliente',
            'usuario',
            'detalles.hilos.material',
            'pagos',
        ])->findOrFail($id);
        $fecha = (new Componentes)->fechaActual();
        $pdf = PDF::loadView('app.reportes.ordenes.reporteOrden', compact('orden_buscada', 'fecha'));
        $pdf->setPaper('letter');

        return $pdf->stream('Reporte de orden.pdf');
    }

    public function reporteOrdenDisehno($id)
    {
        $orden_buscada = Orden::with([
            'detalles',
        ])->findOrFail($id);

        $detalle = $orden_buscada->detalles->first();
        $data = [
            'id' => $orden_buscada->id,
            'codigo_orden' => $orden_buscada->codigo_orden,
            'estado' => $orden_buscada->estado,
            'tipo' => $orden_buscada->tipo,
            'precioTotal' => $orden_buscada->PrecioTotal,

            'nombre_arte' => $detalle->nombre_arte,
            'tamano_diseno' => $detalle->tamaño_diseño,
            'color_hilo' => $detalle->color_hilo,
            'ubicacion_prenda' => $detalle->ubicacion_prenda,
            'tamano_cuello' => $detalle->tamaño_cuello,
            'cantidad' => $detalle->cantidad,
            'precio_unitario' => $detalle->precio_unitario,
            'total' => $detalle->total,
            'notas' => $detalle->notas,
        ];

        $fecha = (new Componentes)->fechaActual();
        $pdf = PDF::loadView('app.reportes.ordenes.reporteOrdenDisehno', compact('data', 'fecha'));
        $pdf->setPaper('letter');

        return $pdf->stream('Reporte de diseño.pdf');
    }
}
