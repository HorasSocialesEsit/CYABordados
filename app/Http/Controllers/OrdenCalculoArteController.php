<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use App\Models\OrdenCalculoArte;
use Illuminate\Http\Request;

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
            'puntadas' => 'nullable|integer',
            'secuencias' => 'nullable|integer',
            'rpm' => 'nullable|integer',
            'tiempo_ciclo' => 'nullable|numeric',
            'notaadicional' => 'nullable|string|max:255',
            'imagen_arte' => 'nullable|image|max:4096',
        ]);

        try {
            // 2️⃣ Subida de imagen opcional
            $rutaImagen = null;
            if ($request->hasFile('imagen_arte')) {
                $rutaImagen = $request->file('imagen_arte')->store('arte', 'public');
            }

            // 3️⃣ Crear registro del cálculo
            $calculo = OrdenCalculoArte::create([
                'orden_id_calculo' => $ordenId,
                'arte_id' => $request->arte_id,
                'puntadas' => $request->puntadas,
                'secuencias' => $request->secuencias,
                'rpm' => $request->rpm,
                'tiempo_ciclo' => $request->tiempo_ciclo,
                'notaadicional' => $request->notaadicional,
                'rutaarte' => $rutaImagen,
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
            $orden->estado = 'arte_aprobado';
            $orden->save();

            // 5️⃣ Retornar con éxito
            return back()->with([
                'success' => 'Cálculo guardado y estado actualizado correctamente.',
                'rutaImagenNueva' => $rutaImagen,
            ]);

        } catch (\Exception $e) {
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
            'notaadicional' => 'nullable|string|max:255',
            'imagen_arte' => 'nullable|image|max:4096',
        ]);

        // Si se sube una nueva imagen la reemplazamos
        if ($request->hasFile('imagen_arte')) {
            $calculo->rutaarte = $request->file('imagen_arte')->store('arte', 'public');
        }

        $calculo->puntadas = $request->puntadas;
        $calculo->secuencias = $request->secuencias;
        $calculo->rpm = $request->rpm;
        $calculo->tiempo_ciclo = $request->tiempo_ciclo;
        $calculo->notaadicional = $request->notaadicional;

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
