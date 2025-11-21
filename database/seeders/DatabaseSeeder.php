<?php

namespace Database\Seeders;



// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\EstadoOrden;
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
            ['nombre_tipo_cliente' => 'Jurídico']
        ]);

        TipoPago::insert([
            ['nombre_tipo_pago' => 'Anticipo'],
            ['nombre_tipo_pago' => 'Abono'],
            ['nombre_tipo_pago' => 'Saldo Final']
        ]);

        TiposHilos::insert([
            ['nombre_tipo_hilo' => 'Poliester'],
            ['nombre_tipo_hilo' => 'Algodon']
        ]);

        EstadoOrden::insert([
            ['nombre_estado_orden' => 'Nueva'],
            ['nombre_estado_orden' => 'En diseño'],
            ['nombre_estado_orden' => 'Asignada a maquina'],
            ['nombre_estado_orden' => 'En proceso de maquina'],
            ['nombre_estado_orden' => 'Completada'],
            ['nombre_estado_orden' => 'Entregada al Cliente'],
            ['nombre_estado_orden' => 'Cancelada']
        ]);





        $this->call([
            DepartamentosSeeder::class,
            MunicipiosSeeder::class,
            AdminUserSeeder::class,
            RoleSeeder::class,
            OrdenSeeder::class,
            // MaterialSeeder::class,
        ]);
    }
}
