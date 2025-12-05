<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Orden;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportesController extends Controller
{
    public function reporteInventario()
    {
        $inventario = Material::orderBy('stock', 'asc')->orderBy('nombre', 'asc')->get();
        $fecha = (new Componentes())->fechaActual();
        $nombre_persona = "Pedro Perez";

        $pdf = PDF::loadView('app.reportes.inventario.inventarioHilos', compact('fecha', 'inventario', 'nombre_persona'));
        $pdf->setPaper('letter');
        return $pdf->stream('Inventario Hilos.pdf');
    }
   
    public function reporteOrden($id)
    {
        $orden_buscada = Orden::with([
            'cliente',
            'usuario',
            'detalles.detalleHilo.material.tipoHilo',
            'ordenCalculoArte',
            'pagos',
        ])->findOrFail($id);

   

        $hilos_asociados = [];
        // foreach ($orden_buscada->detalles as $detalle) {
            foreach ($orden_buscada->detalles->first()->detalleHilo as $hilo) {
                $hilos_asociados[] = [
                    'cantidad' => $hilo->cantidad,
                    'nombre' => $hilo->material->nombre,
                    'codigo' => $hilo->material->codigo,
                    'stock' => $hilo->material->stock,
                    'tipo' => $hilo->material->tipoHilo->nombre_tipo_hilo,
                ];
            }
        // }
        //      return response()->json([
        //     // 'x' => $orden_buscada,
        //     // 'hilos' => $orden_buscada->detalles->first()->detalleHilo,
        //     // 'ss' => $hilos_asociados,
        //     'safsewr' => $orden_buscada->ordenCalculoArte->first()->ruta_arte,
        // ]);

        $detalle = $orden_buscada->detalles->first();
        $fecha = (new Componentes)->fechaActual();

        $pdf = PDF::loadView('app.reportes.ordenes.reporteOrden', compact('orden_buscada', 'hilos_asociados', 'fecha', 'detalle'));
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
            'precio_total' => $orden_buscada->PrecioTotal,
            'nombre_arte' => $detalle->nombre_arte,
            'tamano_diseno' => $detalle->tamano_diseño,
            'color_hilo' => $detalle->color_hilo,
            'ubicacion_prenda' => $detalle->ubicacion_prenda,
            'tamano_cuello' => $detalle->tamano_cuello,
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
