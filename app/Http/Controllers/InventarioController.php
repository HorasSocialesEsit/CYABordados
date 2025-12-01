<?php

namespace App\Http\Controllers;

use App\Models\DetalleHilo;
use App\Models\Material;
use App\Models\OrdenMaterialHistorial;
use App\Models\Proveedor;
use App\Models\ProveedorMaterial;
use App\Models\TiposHilos;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventario = Material::all();

        return view('app.inventario.listInventario', compact('inventario'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tiposHilo = TiposHilos::all();
        $proveedores = Proveedor::all();
        return view('app.inventario.inventarioCreate', compact('tiposHilo',  'proveedores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:50|unique:materiales,codigo',
            'descripcion' => 'nullable|string',
            'tipo_hilo_id' => 'required',
            'id_proveedor' => 'required',
            'stock' => 'required|integer|min:1',
        ], [
            'nombre.required' => 'El nombre del material es obligatorio.',
            'nombre.string' => 'El nombre debe ser un texto válido.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',

            'codigo.required' => 'El código del material es obligatorio.',
            'codigo.string' => 'El código debe ser un texto válido.',
            'codigo.max' => 'El código no puede tener más de 50 caracteres.',
            'codigo.unique' => 'El código ingresado ya está registrado.',

            'descripcion.string' => 'La descripción debe ser un texto válido.',

            'tipo_hilo_id.required' => 'Debe seleccionar un tipo de hilo.',
            'id_proveedor.required' => 'Debe seleccionar un proveedor.',

            'stock.required' => 'Debe especificar el stock del material.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock debe ser al menos 1 unidad.',
        ]);
        $material = Material::create([
            'nombre' => $request->nombre,
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'stock' => $request->stock,
            'tipo_hilo_id' => $request->tipo_hilo_id,
        ]);

        ProveedorMaterial::create([
            'proveedor_id' => $request->id_proveedor,
            'material_id' => $material->id,
            'cantidad' => $request->stock,
        ]);
        return redirect()->route('inventario.index')->with('success', 'Hilo agregado correctamente.');
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
        $tiposHilo = TiposHilos::all();
        $hilo = Material::findOrFail($id);
        $proveedores = Proveedor::all();

        return view('app.inventario.inventarioEdit', compact('tiposHilo', 'hilo', 'proveedores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $material = Material::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => [
                'required',
                'string',
                'max:50',
                Rule::unique('materiales', 'codigo')->ignore($material->id),
            ],
            'descripcion' => 'nullable|string',
            'tipo_hilo_id' => 'required',
            'stock' => 'required|integer|min:1',
        ], [
            'nombre.required' => 'El nombre del material es obligatorio.',
            'nombre.string' => 'El nombre debe ser un texto válido.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',

            'codigo.required' => 'El código del material es obligatorio.',
            'codigo.string' => 'El código debe ser un texto válido.',
            'codigo.max' => 'El código no puede tener más de 50 caracteres.',
            'codigo.unique' => 'El código ingresado ya está registrado para otro material.',

            'descripcion.string' => 'La descripción debe ser un texto válido.',

            'tipo_hilo_id.required' => 'Debe seleccionar un tipo de hilo.',

            'stock.required' => 'Debe especificar el stock del material.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock debe ser al menos 1 unidad.',
        ]);

        $material->update($validated);

        return redirect()->route('inventario.index')->with('success', 'Hilo actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // antes de hacer esto vamos a validar si ya se utilizo el hilo en algun otro proceso

            $material = Material::findOrFail($id);
            $material->delete();

            return redirect()->route('inventario.index')->with('success', 'Hilo Eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('inventario.index')->with('error', 'Error al eliminar hilo ');
        }
    }

    public function reporte()
    {
        $inventario = Material::orderBy('stock', 'asc')->orderBy('nombre', 'asc')->get();
        $fecha = (new Componentes())->fechaActual();
        $nombre_persona = "Pedro Perez";

        $pdf = PDF::loadView('app.reportes.inventario.inventarioHilos', compact('fecha', 'inventario', 'nombre_persona'));
        $pdf->setPaper('letter');
        return $pdf->stream('Inventario Hilos.pdf');
    }
    /**
     * esta funcion se encarga de descontrar el stock de un hilo cuando una orden se finaliza, asi sabemos que hilos
     * se utilizaron y en que orden
     */

    public function filtradoHilosOrden($id)
    {
        $inventario = Material::whereHas('detallesHilo.ordenDetalle', function ($q) use ($id) {
            $q->where('orden_id', $id);
        })
            ->with(['detallesHilo' => function ($q) use ($id) {
                $q->whereHas('ordenDetalle', fn($qq) => $qq->where('orden_id', $id));
            }])
            ->get();


        return view('app.inventario.pageHilosOrden', compact('inventario', 'id'));
    }

    /**
     * esta funcion se encarga de descontar el stock de los hilos utilizados en una orden de produccion
     */
    public function descontarSalidaStockOrden(Request $request)
    {
        // obtnemos el id de la orden
        $ordenId = $request->input('orden_id');

        // recuperamos los seleccionados y la cantidad
        $seleccionados = $request->input('seleccionados', []);
        $hilosFinalizados = $request->input('hilos_finalizados', []);


        DB::beginTransaction();
        try {
            if (empty($seleccionados)) {
                throw new \Exception("No se seleccionaron hilos para descontar.");
            }
            foreach ($seleccionados as $materialId) {

                $cantidad = isset($hilosFinalizados[$materialId])
                    ? intval($hilosFinalizados[$materialId])
                    : 0;

                // buscamos el hilo
                $material = Material::find($materialId);


                // validamos el material y la cantidad
                if ($material && $cantidad > 0) {
                    // validamos qque lo que quiere descontar no supere el stock
                    if ($material->stock < $cantidad) {
                        // creo una excepcion para que se deshagan todos los cambios
                        throw new \Exception("Stock insuficiente para el material '{$material->nombre}'. " . "Stock actual: {$material->stock}, Cantidad solicitada: {$cantidad}");
                    }
                    // descontamos el stock la cantidad ingresada
                    $material->stock -= $cantidad;
                    $material->save();
                    // si no se encuentra el material lanzamos un error
                } else {
                    throw new \Exception("Material no encontrado o cantidad inválida");
                }

                // guardamos el historial junto a la orden, material y la cantidad
                OrdenMaterialHistorial::create([
                    'orden_id' => $ordenId,
                    'material_id' => $materialId,
                    'cantidad' => $cantidad,
                ]);
            }

            // confirmamos la transaccion
            DB::commit();
            return redirect()->route('ordenProceso.index')->with('success', "Stock descontado correctamente.");
        } catch (\Exception $e) {
            // desasemos todos los cambios que se insertaron
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function reabastecimientoStock(Request $request)
    {
        $inventario = Material::where('stock', '<', 21)->get();
        return view('app.inventario.reabastecimientoStock', compact('inventario'));
    }

    public function reabastecimientoStockUpdate(Request $request)
    {
        // recuperamos los seleccionados y la cantidad
        $seleccionados = $request->input('seleccionados', []);
        $hilosReabastecer = $request->input('hilos_reabastecer', []);

        DB::beginTransaction();
        try {
            foreach ($seleccionados as $materialId) {
                $cantidad = isset($hilosReabastecer[$materialId])
                    ? intval($hilosReabastecer[$materialId])
                    : 0;

                // buscamos el hilo
                $material = Material::find($materialId);


                // validamos el material y la cantidad
                if ($material && $cantidad > 0) {
                    // descontamos el stock la cantidad ingresada
                    $material->stock += $cantidad;
                    $material->save();
                    // si no se encuentra el material lanzamos un error
                } else {
                    throw new \Exception("Material no encontrado o cantidad inválida");
                }

                $proveedorMaterial = ProveedorMaterial::where('material_id', $materialId)->first();

                if (!$proveedorMaterial) {
                    throw new \Exception("Proveedor del material no encontrado o id hilo invalido");
                }

                // creamos un nuevo registro en el historial de compras
                ProveedorMaterial::create([
                    'proveedor_id' => $proveedorMaterial->proveedor_id,
                    'material_id' => $materialId,
                    'cantidad' => $cantidad,
                ]);
            }
            // confirmamos la transaccion
            DB::commit();
            return redirect()->route('inventario.index')->with('success', "Reabastecimiento Completado.");
        } catch (\Exception $e) {
            // desasemos todos los cambios que se insertaron
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
