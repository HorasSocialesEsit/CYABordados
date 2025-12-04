<?php

namespace App\Http\Controllers;

use App\Models\HistorialOrden;
use App\Models\Maquinas;
use App\Models\Orden;
use App\Models\OrdenCalculoArte;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrdenProduccionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $ordenes = Orden::with('detalles')->where('estado_orden_id', 5)->get();
        $ordenes = Orden::with([
            'detalles',
            'ordenCalculoArte.maquina',
        ])
            ->where('estado_orden_id', 5)
            ->get();

        return view('app.produccion.arte.OrdenesEnProceso', compact('ordenes'));
    }

    public function ArtesAprobados()
    {
        // $ordenes = Orden::where('estado_orden_id', '3')->get();
        $ordenes = OrdenCalculoArte::with(['orden', 'maquina'])
            ->whereHas('orden', function ($query) {
                $query->where('estado_orden_id', 4);
            })
            ->orderBy('maquina_id') // 1️ Primero ordenar por máquina
            ->orderBy(
                Orden::select('fecha_entrega') // 2 Luego por fecha
                    ->whereColumn('ordenes.id', 'ordenes_calculos_por_arte.orden_id_calculo')
            )
            ->get();

        return view('app.produccion.arte.OrdenesArteAprobado', compact('ordenes'));
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

        // obtenemos los rangos de dias de lunes a viernes
        if ($dia >= 1 && $dia <= 5) {
            $horas_laboradas = 8;
            $minutos_calculados = $horas_laboradas * 60;
        }

        // si el dia es sabado
        if ($dia === 6) {
            $horas_laboradas = 4.5;
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
            'detalles.maquinaAsignada',
            'ordenCalculoArte',
        ])->findOrFail($id);

        // obtenemos la maquina asignada al detalle
        $maquina_asignada = $orden_buscada->detalles->first()->maquinaAsignada;
        // obtenemos el detalle de la orden
        $detalle = $orden_buscada->detalles->first();
        // obtener el detalle de calculo del arte
        $detalle_calculo_arte = $orden_buscada->ordenCalculoArte;

        // obtenemos el último restante del historial de la orden
        $restante = HistorialOrden::where('orden_id', $id)
            ->orderByDesc('id')
            ->value('restante');

        // en caso de que exista cambiamos el valor original del pedido
        $cantidad = $restante !== null ? $restante : $detalle->cantidad;

        // en caso que la maquina asignada este dañada en algunos cabezales
        $cabezales_reales = $maquina_asignada ? $maquina_asignada->cabezales - $maquina_asignada->cabezales_danado : 0;

        $data = [
            'id' => $orden_buscada->id,
            'cantidad' => $cantidad,
            'cabezales' => $cabezales_reales,
            'eficiencia' => 0.85,
            'tiempo_de_cambio' => 20,
            'horas_laboradas' => $this->obtenerMinutosTrabajadosDias()['horas'],
            'minutos_laboradas' => $this->obtenerMinutosTrabajadosDias()['minutos'],

            // datos por default pero en la interfaz se puede editar
            'rmp_maquina' => $detalle_calculo_arte->first()->rpm ?? 0,
            'puntadas_maquina' => $detalle_calculo_arte->first()->puntadas ?? 0,
            'secuencia_maquina' => $detalle_calculo_arte->first()->secuencias ?? 0,

        ];

        return view('app.produccion.arte.OrdenesEnProcesoForm', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // claves a almacenar
        // rpm
        // puntadas
        // secuencia
        // cabezales
        // tiempo_cambio
        // eficiencia
        // ciclos
        // horas
        // minutos
        // cantidad
        // realizada
        // restante

        $request->validate([
            'rpm' => 'required|min:1',
            'puntadas' => 'required|min:1',
            'secuencia' => 'required|min:1',
            'cabezales' => 'required|min:1',
            'tiempo_cambio' => 'required|min:1',
            'eficiencia' => 'required|min:1',
            'ciclos_calculo' => 'required|min:1',
            'horas' => 'required|min:1',
            'minutos_calculo' => 'required|min:1',
            'dias_calculo' => 'required|min:1',
            'unidades' => 'required|min:1',
            'producido' => 'required|min:1',
            'pendiente' => 'required|min:1',
        ]);
        try {

            HistorialOrden::create([
                'rpm' => $request->rpm,
                'puntadas' => $request->puntadas,
                'secuencias' => $request->secuencia,
                'cabezales' => $request->cabezales,
                'tiempo_cambio' => $request->tiempo_cambio,
                'eficiencia' => $request->eficiencia,

                'ciclos' => $request->ciclos_calculo,
                'horas' => $request->horas,
                'minutos' => $request->horas * 60,

                'cantidad' => $request->unidades,
                'realizada' => $request->producido,
                'restante' => $request->pendiente,

                'orden_id' => $id,
            ]);

            // aqui cuando el restante sea cero actualizamos la orden a completada el estado
            if ($request->pendiente == 0) {
                Orden::where('id', $id)->update([
                    'estado' => 'completada',
                ]);
            }

            return redirect()->route('ordenProceso.index')
                ->with('success', 'Producción registrada correctamente.');
        } catch (\Throwable $th) {
            return redirect()->route('ordenProceso.index')
                ->with('error', 'Error al registrar.');
        }
    }

    public function iniciarProceso(string $id)
    {
        try {

            // 1. Cargar la orden con sus cálculos y máquina

            $orden = Orden::with('ordenCalculoArte.maquina')->findOrFail($id);

            // 2. Buscar el cálculo de arte (siempre debería existir uno)
            $calculo = $orden->ordenCalculoArte->first();

            if (! $calculo) {
                return redirect()->route('ordenProceso.ArtesAProbados')
                    ->with('error', 'La orden no tiene cálculo de arte asignado.');
            }

            // 3. Obtener la máquina desde el cálculo
            $maquina = $calculo->maquina;

            if (! $maquina) {
                return redirect()->route('ordenProceso.ArtesAProbados')
                    ->with('error', 'La orden no tiene una máquina asignada.');
            }

            // 4. Verificar si la máquina ya está en uso
            if ($maquina->en_uso == 1) {
                return redirect()->route('ordenProceso.ArtesAProbados')
                    ->with('error', "La máquina {$maquina->nombre} ya está en uso.");
            }
            //  dd($orden->estado_orden_id);
            // 4. Verificar el estado de la orden
            if ($orden->estado_orden_id >= 5) {
                return redirect()->route('ordenProceso.ArtesAProbados')
                    ->with('error', "La orden { $orden->codigo_orden  } ya fue iniciada ");
            }

            // 5. Cambiar estado de la orden a "en proceso"
            Orden::where('id', $orden->id)->update(['estado_orden_id' => 5]);
            //    $orden->save();

            // 6. Cambiar estado de la máquina a "en uso"
            Maquinas::where('id', $maquina->id)->update(['en_uso' => 1]);

            return redirect()->route('ordenProceso.index')
                ->with('success', 'Proceso iniciado y máquina marcada como en uso.');

        } catch (\Throwable $th) {
            return redirect()->route('ordenProceso.ArtesAProbados')
                ->with('error', 'Error al iniciar la orden');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function agregarCantidadProduccionOrden(Request $request, string $id, string $cantidad)
    {

        $fecha_inicio = '30-11-2025';
        $hora_inicio = '14:30';

        $fecha_final = '30-11-2025';
        $hora_final = '17:45';

        // fecha y hora actual
        $fecha_actual = Carbon::now()->format('d-m-Y');
        $hora_actual = Carbon::now()->format('H:i');

        $inicio = Carbon::createFromFormat('d-m-Y H:i', "$fecha_inicio $hora_inicio");
        $final = Carbon::createFromFormat('d-m-Y H:i', "$fecha_final $hora_final");
        $actual = Carbon::createFromFormat('d-m-Y H:i', "$fecha_actual $hora_actual");

        //    calculamos el tiempo trabajado
        $minutos_trabajados = $inicio->diffInMinutes($actual, false);

        // calculamos el tiempo restante para la hora final
        $minutos_restantes = $actual->diffInMinutes($final, false);

        // verificamos si se ha pasado del tiempo final
        $pasado = $actual->greaterThan($final);

        // calculamos cuanto tiempo se ha excedido
        $minutos_excedidos = $pasado ? $final->diffInMinutes($actual) : 0;

        try {
            // obtenemos el último restante del historial de la orden, validamos si ya se añadio
            $restante = HistorialOrden::where('orden_id', $id)
                ->orderByDesc('id')
                ->value('restante');

            // en caso de que exista cambiamos el valor original del pedido
            $cantidad = $restante !== null ? $restante : $cantidad;

            $restante_orden = $cantidad - $request->cantidad_produccion;

            if ($request->cantidad_produccion > $restante_orden) {
                return back()->with('error', 'La cantidad producida no puede ser mayor a la pendiente.');
            }

            HistorialOrden::create([
                'rpm' => 10,
                'puntadas' => 10,
                'secuencias' => 10,
                'cabezales' => 10,
                'tiempo_cambio' => 10,
                'eficiencia' => 10,

                'ciclos' => 10,
                'horas' => 10,
                'minutos' => 10,

                'cantidad' => $cantidad,
                'realizada' => $request->cantidad_produccion,
                'restante' => $restante_orden,
                'orden_id' => $id,
            ]);

            // aqui cuando el restante sea cero actualizamos la orden a completada el estado
            if ($request->pendiente == 0) {
                Orden::where('id', $id)->update([
                    'estado_orden_id' => 6,
                ]);
            }
        } catch (\Throwable $th) {
            return back()->with('error', 'Ocurrió un error al registrar la producción, intente nuevamente.');
        }

        if ($minutos_restantes > 0) {

            return back()->with('success', "Tu produccion se ha registrado correctamente, te quedan $minutos_restantes minutos para finalizar, has trabajado $minutos_trabajados minutos.");
        }

        if ($pasado) {
            return back()->with('success', "Tu produccion se ha registrado correctamente, pero has excedido el tiempo estimado por $minutos_excedidos minutos, has trabajado $minutos_trabajados minutos.");
        }

        return back()->with('success', "Tu produccion se ha registrado correctamente, has trabajado $minutos_trabajados minutos.");
    }
}
