<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\EstadoOrden;
use App\Models\Maquinas;
use App\Models\TipoCliente;
use App\Models\TipoPago;
use App\Models\TiposHilos;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        TipoCliente::insert([
            ['nombre_tipo_cliente' => 'Natural'],
            ['nombre_tipo_cliente' => 'Jurídico'],
        ]);

        TipoPago::insert([
            ['nombre_tipo_pago' => 'Anticipo'],
            ['nombre_tipo_pago' => 'Abono'],
            ['nombre_tipo_pago' => 'Saldo Final'],
        ]);

        TiposHilos::insert([
            ['nombre_tipo_hilo' => 'Poliester'],
            ['nombre_tipo_hilo' => 'Algodon'],
        ]);

        EstadoOrden::insert([
            ['nombre_estado_orden' => 'Nueva'],
            ['nombre_estado_orden' => 'En diseño'],
            ['nombre_estado_orden' => 'Arte aprobado'],
            ['nombre_estado_orden' => 'Asignada a maquina'],
            ['nombre_estado_orden' => 'En proceso de maquina'],
            ['nombre_estado_orden' => 'Completada'],
            ['nombre_estado_orden' => 'Entregada al Cliente'],
            ['nombre_estado_orden' => 'Cancelada'],
        ]);

        Maquinas::insert([
            [
                'nombre' => 'M01',
                'cabezales' => 12,
                'cabezales_danado' => 0,
                'rpm' => 500,
            ],
            [
                'nombre' => 'M02',
                'cabezales' => 4,
                'cabezales_danado' => 1,
                'rpm' => 600,
            ],
            [
                'nombre' => 'M03',
                'cabezales' => 12,
                'cabezales_danado' => 1,
                'rpm' => 650,
            ],
        ]);

        $this->call([
            DepartamentosSeeder::class,
            MunicipiosSeeder::class,
            ProveedorSedder::class,
            AdminUserSeeder::class,
            RoleSeeder::class,
            MaterialSeeder::class,
            OrdenSeeder::class,
        ]);
    }
}
