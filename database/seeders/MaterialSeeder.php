<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;
use App\Models\ProveedorMaterial;
use Illuminate\Support\Str;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiposHilo = ['Algodon', 'Poliester'];
        $nombres = [
            'Hilo Blanco',
            'Hilo Negro',
            'Hilo Azul Marino',
            'Hilo Rojo Carmesí',
            'Hilo Verde Esmeralda',
            'Hilo Amarillo Sol',
            'Hilo Gris Plata',
            'Hilo Marrón Tierra',
            'Hilo Naranja Cálido',
            'Hilo Rosa Pastel',
        ];

        foreach ($nombres as $nombre) {
            $tipo = $tiposHilo[array_rand($tiposHilo)];
            $stock = rand(13, 21);

            $material = Material::create([
                'nombre' => $nombre,
                'codigo' => 'MAT-' . strtoupper(Str::random(5)),
                'descripcion' => 'Carrete de ' . strtolower($nombre) . ' tipo ' . strtolower($tipo) . '.',
                'tipo_hilo_id' => 1,
                'stock' => $stock,
            ]);

            ProveedorMaterial::create([
                'material_id' => $material->id,
                'proveedor_id' => 1,
                'cantidad' => $stock,
            ]);
        }
    }
}
