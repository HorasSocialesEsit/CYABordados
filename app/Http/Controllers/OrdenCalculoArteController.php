<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use App\Models\OrdenCalculoArte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdenCalculoArteController extends Controller
{
    /**
     * Guardar cálculo de arte
     */
    public function store(Request $request, $ordenId)
    {
        // 1️⃣ Validación de los datos
        $request->validate([
            'arte_id' => 'required|integer',
            'puntadas' => 'required|integer',
            'secuencias' => 'required|integer',
            'rpm' => 'nullable|integer',
            'tiempo_ciclo' => 'nullable|numeric',
            'notaadicional' => 'nullable|string|max:255',
            'imagen_arte' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'maquina_id' => 'required|integer',
            'ciclos' => 'nullable|integer',
            'tiempoTotal' => 'nullable|numeric|min:0',
            'cabezales' => 'nullable|integer|min:1',

        ],
            [
                'maquina_id.required' => 'Debe seleccionar una máquina.',
                'puntadas.required' => 'Debe ingresar las puntadas.',
                'secuencias.required' => 'Debe ingresar las secuencias.',

            ]);

        // DB::transaction();
        try {
            // 2️⃣ Subida de imagen opcional
            $rutaImagen = null;
            if ($request->hasFile('imagen_arte')) {
                $rutaImagen = $request->file('imagen_arte')->store('arte', 'public');
            } else {
                $rutaImagen = 'img/admin/undraw_profile.svg'; // Ruta de imagen por defecto
            }

            // 3️⃣ Crear registro del cálculo
            $calculo = OrdenCalculoArte::create([
                'orden_id_calculo' => $ordenId,
                'arte_id' => $request->arte_id,
                'puntadas' => $request->puntadas,
                'secuencias' => $request->secuencias,
                'rpm' => $request->rpm,
                'tiempo_ciclo' => 10,
                'nota_adicional' => 'qadicional',
                'ruta_arte' => $rutaImagen,
                'maquina_id' => $request->maquina_id,
                'ciclos' => $request->ciclos,
                'tiempo_total_orden' => $request->tiempoTotal,
                'cabezales' => $request->cabezales,
            ]);

            if (! $calculo) {
                throw new \Exception('No se pudo guardar el cálculo.');
            }

            // 4️⃣ Actualizar estado de la orden de forma segura
            $orden = Orden::find($ordenId);

            if (! $orden) {
                throw new \Exception('Orden no encontrada.');
            }

            // Opcional: si tu columna es ENUM, asegúrate que el valor exista
            $orden->estado_orden_id = 3;
            $orden->save();
            $ordenRef = Orden::find($ordenId);
            // dd($ordenRef->estado_orden_id);
            //    $orden = Orden::find($ordenId);

            //    DB::commit();
            // return response()->json($orden);
            // 5️⃣ Retornar con éxito
            //

            return redirect()->route('ordenProceso.ArtesAProbados', ['ordenId' => $ordenId])
                ->with('success', 'Cálculo guardado correctamente.');

        } catch (\Exception $e) {
            // DB::rollback();
            // 6️⃣ Capturar cualquier error
            return back()->with('error', 'Error al guardar: '.$e->getMessage());
        }
    }

    /**
     * Actualizar cálculo
     */
    public function update(Request $request, $id)
    {
        $calculo = OrdenCalculoArte::findOrFail($id);

        $request->validate([
            'puntadas' => 'nullable|integer',
            'secuencias' => 'nullable|integer',
            'rpm' => 'nullable|integer',
            'tiempo_ciclo' => 'nullable|numeric',
            // 'notaadicional' => 'nullable|string|max:255',
            'imagen_arte' => 'nullable|image|max:4096',
        ],
            [
                'maquina_id.required' => 'Debe seleccionar una máquina.',

                'puntadas.integer' => 'Las puntadas deben ser un número.',
                'secuencias.integer' => 'Las secuencias deben ser un número.',

            ]);

        // Si se sube una nueva imagen la reemplazamos
        if ($request->hasFile('imagen_arte')) {
            $calculo->rutaarte = $request->file('imagen_arte')->store('arte', 'public');
        }

        $calculo->puntadas = $request->puntadas;
        $calculo->secuencias = $request->secuencias;
        $calculo->rpm = $request->rpm;
        $calculo->tiempo_ciclo = $request->tiempo_ciclo;
        // $calculo->nota_adicional = $request->notaadicional;

        $calculo->save();

        return back()->with('success', 'Cálculo actualizado correctamente.');
    }

    /**
     * Eliminar cálculo
     */
    public function destroy($id)
    {
        $calculo = OrdenCalculoArte::findOrFail($id);
        $calculo->delete();

        return back()->with('success', 'Cálculo eliminado correctamente.');
    }
}
