<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departamentos;

class DepartamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
Departamentos::insert([
            ['nombre_departamento' => 'Ahuachapán'],
            ['nombre_departamento' => 'Santa Ana'],
            ['nombre_departamento' => 'Sonsonate'],
            ['nombre_departamento' => 'La Libertad'],
            ['nombre_departamento' => 'Chalatenango'],
            ['nombre_departamento' => 'San Salvador'],
            ['nombre_departamento' => 'Cuscatlán'],
            ['nombre_departamento' => 'La Paz'],
            ['nombre_departamento' => 'Cabañas'],
            ['nombre_departamento' => 'San Vicente'],
            ['nombre_departamento' => 'Usulután'],
            ['nombre_departamento' => 'Morazán'],
            ['nombre_departamento' => 'San Miguel'],
            ['nombre_departamento' => 'La Unión'],
        ]);
    }
}
