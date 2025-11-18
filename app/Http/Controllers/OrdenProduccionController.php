<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrdenProduccionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ordenes = Orden::whereIn('estado', [
            'asignada_maquina',
            'en_proceso_maquina',
            'completada',
            'entregada_cliente',
        ])
            ->orderByRaw("
        CASE
            WHEN estado = 'asignada_maquina' THEN 1
            WHEN estado = 'en_proceso_maquina' THEN 2
            WHEN estado = 'completada' THEN 3
            WHEN estado = 'entregada_cliente' THEN 4
        END
    ")->get();

        return view('app.produccion.arte.OrdenesEnProceso', compact('ordenes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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

    private function obtenerMinutosTrabajadosDias()
    {
        $dia = Carbon::now()->dayOfWeek;
        $horas_laboradas = 0;
        $minutos_calculados = 0;       // en caso que sea domingo, ya que solo ese dia queda

        // obtenemos los rangos de dias de lunes a jueves
        if ($dia >= 1 && $dia <= 4) {
            $horas_laboradas = 8.5;
            $minutos_calculados = $horas_laboradas * 60;
        }

        // si el dia es viernes
        if ($dia === 5) {
            $horas_laboradas = 7.5;
            $minutos_calculados = $horas_laboradas * 60;
        }

        // si el dia es sabado
        if ($dia === 6) {
            $horas_laboradas = 6;
            $minutos_calculados = $horas_laboradas * 60;
        }

        return [
            'horas' => $horas_laboradas,
            'minutos' => $minutos_calculados,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $orden_buscada = Orden::with([
            'detalles',
        ])->findOrFail($id);

        $detalle = $orden_buscada->detalles->first();

        $data = [
            'id' => $orden_buscada->id,
            'cantidad' => $detalle->cantidad,
            'cabezales' => 8,
            'eficiencia' => 0.85,
            'tiempo_de_cambio' => 20,
            'horas_laboradas' => $this->obtenerMinutosTrabajadosDias()['horas'],
            'minutos_laboradas' => $this->obtenerMinutosTrabajadosDias()['minutos'],

            // datos por default pero en la interfaz se puede editar
            'rmp_maquina' => 500,
            'puntadas_maquina' => 12520,
            'secuencia_maquina' => 12,

        ];

        return view('app.produccion.arte.OrdenesEnProcesoForm', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'producido' => 'required|integer|min:1',
            'cabezales' => 'required|integer|min:1',
            'minutos_ciclo' => 'required|numeric|min:1',
        ]);

        return redirect()->route('ordenProceso.index')
            ->with('success', 'Producción registrada correctamente.');
    }

    public function iniciarProceso(string $id, string $estado)
    {
        try {
            if ($estado != 'asignada_maquina') {
                return redirect()->route('ordenProceso.index')->with('error', 'La orden ya fue iniciada o entregada');
            }
            $orden = Orden::findOrFail($id);

            if ($orden) {
                $orden->estado = 'en_proceso_maquina';
                $orden->save();

                return redirect()->route('ordenProceso.index')->with('success', 'Tu orden se encuentra en estado de procesar');
            }
        } catch (\Throwable $th) {
            return redirect()->route('ordenProceso.index')->with('error', 'Error al iniciar orden');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
