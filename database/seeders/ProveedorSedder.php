<?php

namespace Database\Seeders;

use App\Models\Proveedor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProveedorSedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Proveedor::insert([
            [
                'nombre' => 'Proveedor A',
                'telefono' => '12345678',
                'email' => 'prov@gmail.com',
            ],
        ]);
    }
}
