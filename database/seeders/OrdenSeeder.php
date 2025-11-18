<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Municipios;
use App\Models\Orden;
use App\Models\OrdenDetalle;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrdenSeeder extends Seeder
{
    public function run(): void
    {
        // 🔹 Verificar si hay municipios
        $municipioId = Municipios::value('id');
        if (! $municipioId) {
            $this->command->warn('⚠️ No hay municipios. Creando uno de ejemplo...');
            $municipio = Municipios::create([
                'nombre' => 'San Salvador',
                'id_departamento' => 1, // ajusta según tu estructura
            ]);
            $municipioId = $municipio->id;
        }

        // 🔹 Crear clientes de ejemplo si no existen
        if (Cliente::count() === 0) {
            $this->command->warn('⚠️ No hay clientes. Generando 10 clientes de ejemplo...');

            for ($i = 1; $i <= 10; $i++) {
                Cliente::create([
                    'codigo' => 'CLI-'.strtoupper(Str::random(5)),
                    'nombre' => 'Cliente '.$i,
                    'correo' => 'cliente'.$i.'@correo.com',
                    'telefono' => rand(60000000, 79999999),
                    'telefono_alt' => rand(70000000, 79999999),
                    'direccion' => 'Colonia Ejemplo #'.$i,
                    'id_municipio' => $municipioId,
                    'pais' => 'El Salvador',
                    'estado' => 'Activo',
                    'tipo_cliente' => ['Natural', 'Jurídico'][array_rand(['Natural', 'Jurídico'])],
                    'nit' => str_pad(rand(10000000000000, 99999999999999), 14, '0', STR_PAD_LEFT),
                    'dui' => str_pad(rand(100000000, 999999999), 9, '0', STR_PAD_LEFT),
                    'nrc' => str_pad(rand(10000000000000, 99999999999999), 14, '0', STR_PAD_LEFT),
                ]);
            }

            $this->command->info('✅ Se crearon 10 clientes de ejemplo.');
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
                    'usuario_id' => 1,
                ]);

                $numDetalles = rand(1, 5);

                for ($j = 0; $j < $numDetalles; $j++) {
                    $cantidad = rand(1, 20);
                    $precio = rand(5, 50);
                    $total = $cantidad * $precio;

                    OrdenDetalle::create([
                        'orden_id' => $orden->id,
                        'nombre_arte' => 'Diseño #'.rand(1, 1000),
                        'tamaño_diseño' => rand(5, 20).'x'.rand(5, 20).' cm',
                        'color_hilo' => ['Rojo', 'Azul', 'Verde', 'Negro', 'Blanco'][array_rand(['Rojo', 'Azul', 'Verde', 'Negro', 'Blanco'])],
                        'ubicacion_prenda' => ['Pecho', 'Espalda', 'Manga'][array_rand(['Pecho', 'Espalda', 'Manga'])],
                        'cantidad' => $cantidad,
                        'precio_unitario' => $precio,
                        'total' => $total,
                        'notas' => fake()->sentence(),
                    ]);
                }

                $orden->actualizarTotales();
            }
        });

        $this->command->info('✅ Se generaron 100 órdenes aleatorias con detalles.');
    }
}
