<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\DetalleHilo;
use App\Models\Orden;
use App\Models\OrdenCalculoArte;
use App\Models\OrdenDetalle;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrdenSeeder extends Seeder
{
    public function run(): void
    {

        // 🔹 Crear clientes de ejemplo si no existen
        if (Cliente::count() === 0) {

            for ($i = 1; $i <= 10; $i++) {
                Cliente::create([
                    'nombre' => 'Cliente '.$i,
                    'correo' => 'cliente'.$i.'@correo.com',
                    'telefono' => rand(60000000, 79999999),
                    'telefono_alt' => rand(70000000, 79999999),
                    'direccion' => 'Colonia Ejemplo #'.$i,
                    'pais' => 'El Salvador',
                    'codigo' => 'CLI-'.strtoupper(Str::random(5)),
                    'nit' => str_pad(rand(10000000000000, 99999999999999), 14, '0', STR_PAD_LEFT),
                    'dui' => str_pad(rand(100000000, 999999999), 9, '0', STR_PAD_LEFT),
                    'nrc' => str_pad(rand(10000000000000, 99999999999999), 14, '0', STR_PAD_LEFT),
                    'estado' => 'Activo',
                    'id_municipio' => 1,
                    'tipo_cliente_id' => rand(1, 2),
                ]);
            }
        }

        // 🔹 Resto del código (órdenes y detalles)
        $clientes = Cliente::pluck('id')->toArray();

        DB::transaction(function () use ($clientes) {
            for ($i = 1; $i <= 10; $i++) {
                $fechaOrden = Carbon::now()->subDays(rand(1, 180));
                $fechaEntrega = (clone $fechaOrden)->addDays(rand(3, 15));

                $orden = Orden::create([
                    'cliente_id' => $clientes[array_rand($clientes)],
                    'fecha_orden' => $fechaOrden,
                    'codigo_orden' => 'ORD-'.strtoupper(Str::random(6)),
                    'fecha_entrega' => $fechaEntrega,
                    'estado_orden_id' => 1,
                    'usuario_id' => 1,
                ]);

                $numDetalles = rand(1, 5);

                $cantidad = rand(1, 20);
                $precio = rand(5, 50);
                $total = $cantidad * $precio;

                $orden_detall = OrdenDetalle::create([
                    'orden_id' => $orden->id,
                    'nombre_arte' => 'Diseño #'.rand(1, 1000),
                    'tamano_diseno' => rand(5, 20).'x'.rand(5, 20).' cm',

                    'ubicacion_prenda' => ['Pecho', 'Espalda', 'Manga'][array_rand(['Pecho', 'Espalda', 'Manga'])],
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precio,
                    'total' => $total,
                    'notas' => fake()->sentence(),
                    'maquina_id' => 1,
                ]);

                // OrdenCalculoArte::create([
                //     'puntadas' => 2500,
                //     'secuencias' => 33,
                //     'rpm' => 5000,
                //     'tiempo_ciclo' => 53,
                //     'nota_adicional' => 'content',
                //     'ruta_arte' => 'content',
                //     'orden_id_calculo' => $orden->id,
                //     'arte_id' => $orden_detall->id,
                //     'maquina_id' => 1,
                //     'ciclos' => 1,
                //     'tiempo_total_orden' => 53,

                // ]);

                DetalleHilo::create([
                    'cantidad' => rand(3, 10),
                    'orden_detalle_id' => $orden_detall->id,
                    'material_id' => rand(3, 10),
                ]);
                DetalleHilo::create([
                    'cantidad' => rand(3, 10),
                    'orden_detalle_id' => $orden_detall->id,
                    'material_id' => rand(3, 10),
                ]);
                DetalleHilo::create([
                    'cantidad' => rand(3, 10),
                    'orden_detalle_id' => $orden_detall->id,
                    'material_id' => rand(3, 10),
                ]);
                DetalleHilo::create([
                    'cantidad' => rand(3, 10),
                    'orden_detalle_id' => $orden_detall->id,
                    'material_id' => rand(3, 10),
                ]);

                $orden->actualizarTotales();
            }
        });
    }
}
