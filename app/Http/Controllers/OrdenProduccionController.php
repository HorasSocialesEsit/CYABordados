<?php

namespace App\Http\Controllers;

use App\Exceptions\BusinessException;
use App\Models\HistorialOrden;
use App\Models\Maquinas;
use App\Models\Orden;
use App\Models\OrdenCalculoArte;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdenProduccionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ordenes = Orden::with([
            'detalles',
            'ordenCalculoArte.maquina',
        ])
            ->withSum('historial', 'realizada')
            ->where('estado_orden_id', 5)
            ->get();
        return view('app.produccion.arte.OrdenesEnProceso', compact('ordenes'));
    }

    public function ArtesAprobados()
    {
        $ordenes = OrdenCalculoArte::with(['orden', 'maquina'])
            ->whereHas('orden', function ($query) {
                $query->where('estado_orden_id', 4);
            })
            ->orderBy('maquina_id')
            ->orderBy(
                Orden::select('fecha_entrega')
                    ->whereColumn('ordenes.id', 'ordenes_calculos_por_arte.orden_id_calculo')
            )
            ->get();

            // return response()->json($ordenes);

        

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


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {}

    public function iniciarProceso(string $id)
    {
        // implementamos transacciones, ya que si no se actualiza una tabla, hacemos rollback de todas para que no quede inconsistencia
        DB::beginTransaction();
        try {

            // buscamos que la orden exista
            $orden = Orden::with('ordenCalculoArte.maquina')
                ->whereHas('ordenCalculoArte', function ($q) use ($id) {
                    $q->where('id', $id);
                })
                ->first();


            // Buscar el cálculo de arte (siempre debería existir uno)
            $calculo = $orden->ordenCalculoArte->first();

            // validamos que exista el calculo de la orden
            if (!$calculo) {
                throw new BusinessException('La orden no tiene cálculo de arte asignado.');
            }

            // obtenemos la maquina que esta asignada a esa orden
            $maquina = $calculo->maquina;
            if (!$maquina) {
                throw new BusinessException('La orden no tiene una máquina asignada.');
            }

            // 4. Verificar si la máquina ya está en uso
            if ($maquina->en_uso == 1) {
                throw new BusinessException("La máquina {$maquina->nombre} ya está en uso.");
            }
            //  dd($orden->estado_orden_id);
            // 4. Verificar el estado de la orden
            if ($orden->estado_orden_id >= 5) {
                throw new BusinessException("La orden {$orden->codigo_orden} ya fue iniciada.");
            }

            // obtenemos los minutos que durara la orden
            $minutos_orden = ceil($calculo->tiempo_total_orden);


            // obtenemos la hora actual
            $inicio = Carbon::now(); // definimos la hora de inicio de la orden
            $final  = Carbon::now()->copy()->addMinutes($minutos_orden); // definimos la hora final de la orden

            // cambiamos el estado de la orden a "En proceso de maquina"
            Orden::where('id', $orden->id)->update(['fecha_hora_inicio' => $inicio, 'fecha_hora_fin' => $final, 'estado_orden_id' => 5]);

            // cambiamos el estado de la maquina a ocupada
            Maquinas::where('id', $maquina->id)->update(['en_uso' =>  true]);
            DB::commit();

            return redirect()->route('ordenProceso.index')
                ->with('success', 'Proceso iniciado y máquina marcada como en uso.');
            // validamos si son errores que nosotros personalizamos
        } catch (BusinessException $e) {
            DB::rollBack();
            return redirect()->route('ordenProceso.ArtesAProbados')
                ->with('error', $e->getMessage());
            // capturamos cualquier otro error inesperado
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('ordenProceso.ArtesAProbados')
                ->with('error', "Ocurrió un error interno al iniciar el proceso: ");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function agregarCantidadProduccionOrden(Request $request, string $id, string $cantidad, string $fecha_hora_inicio, string $fecha_hora_fin, string $id_maquina)
    {
        DB::beginTransaction();
        try {
            $fecha_hora_inicio = Carbon::parse($fecha_hora_inicio);
            $fecha_hora_fin = Carbon::parse($fecha_hora_fin);
            $actual = Carbon::now();

            //    calculamos el tiempo trabajado
            $minutos_trabajados = ceil($fecha_hora_inicio->diffInMinutes($actual, false));

            // calculamos el tiempo restante para la hora final
            $minutos_restantes = ceil($actual->diffInMinutes($fecha_hora_fin, false));

            // verificamos si se ha pasado del tiempo final
            $pasado = $actual->greaterThan($fecha_hora_fin);

            // calculamos cuanto tiempo se ha excedido
            $minutos_excedidos = ceil($pasado ? $fecha_hora_fin->diffInMinutes($actual) : 0);
            // obtenemos el último restante del historial de la orden, validamos si ya se añadio
            $restante = HistorialOrden::where('orden_id', $id)
                ->orderByDesc('id')
                ->value('restante');

            // en caso de que exista cambiamos el valor original del pedido
            $cantidad = $restante !== null ? $restante : $cantidad;

            $restante_orden = $cantidad - $request->cantidad_produccion;


            if ($restante_orden < 0) {
                throw new BusinessException('La cantidad producida no puede ser mayor a la pendiente.');
            }


            HistorialOrden::create([
                'cantidad' => $cantidad,
                'realizada' => $request->cantidad_produccion,
                'restante' => $restante_orden,
                'orden_id' => $id,
            ]);


            // aqui cuando el restante sea cero actualizamos la orden a completada el estado
            if ($restante_orden == 0) {
                Orden::where('id', $id)->update([
                    'estado_orden_id' => 6,
                ]);
                // liberamos la maquina al completar la orden
                Maquinas::where('id', $id_maquina)->update(['en_uso' =>  false]);
            }
            DB::commit();
            if ($minutos_restantes > 0) {

                return back()->with('success', "Tu produccion se ha registrado correctamente, te quedan $minutos_restantes minutos para finalizar, has trabajado $minutos_trabajados minutos.");
            }

            if ($pasado) {
                return back()->with('success', "Tu produccion se ha registrado correctamente, pero has excedido el tiempo estimado por $minutos_excedidos minutos, has trabajado $minutos_trabajados minutos.");
            }

            return back()->with('success', "Tu produccion se ha registrado correctamente, has trabajado $minutos_trabajados minutos.");
        } catch (BusinessException $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un error al registrar la producción, intente nuevamente.');
        }
    }
}
