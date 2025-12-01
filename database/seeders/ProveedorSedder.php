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
                'telefono' => '71234567',
                'email' => 'proveedor.a@gmail.com',
            ],
            [
                'nombre' => 'Proveedor B',
                'telefono' => '72345678',
                'email' => 'proveedor.b@gmail.com',
            ],
            [
                'nombre' => 'Proveedor C',
                'telefono' => '73456789',
                'email' => 'proveedor.c@gmail.com',
            ],
            [
                'nombre' => 'Proveedor D',
                'telefono' => '74567890',
                'email' => 'proveedor.d@gmail.com',
            ],
            [
                'nombre' => 'Proveedor E',
                'telefono' => '75678901',
                'email' => 'proveedor.e@gmail.com',
            ],
            [
                'nombre' => 'Proveedor F',
                'telefono' => '76789012',
                'email' => 'proveedor.f@gmail.com',
            ],
            [
                'nombre' => 'Proveedor G',
                'telefono' => '77890123',
                'email' => 'proveedor.g@gmail.com',
            ],
            [
                'nombre' => 'Proveedor H',
                'telefono' => '78901234',
                'email' => 'proveedor.h@gmail.com',
            ],
            [
                'nombre' => 'Proveedor I',
                'telefono' => '79012345',
                'email' => 'proveedor.i@gmail.com',
            ],
            [
                'nombre' => 'Proveedor J',
                'telefono' => '70123456',
                'email' => 'proveedor.j@gmail.com',
            ],
            [
                'nombre' => 'Proveedor K',
                'telefono' => '71230123',
                'email' => 'proveedor.k@gmail.com',
            ],
            [
                'nombre' => 'Proveedor L',
                'telefono' => '72301234',
                'email' => 'proveedor.l@gmail.com',
            ],
            [
                'nombre' => 'Proveedor M',
                'telefono' => '73402345',
                'email' => 'proveedor.m@gmail.com',
            ],
            [
                'nombre' => 'Proveedor N',
                'telefono' => '74503456',
                'email' => 'proveedor.n@gmail.com',
            ],
            [
                'nombre' => 'Proveedor O',
                'telefono' => '75604567',
                'email' => 'proveedor.o@gmail.com',
            ],
            [
                'nombre' => 'Proveedor P',
                'telefono' => '76705678',
                'email' => 'proveedor.p@gmail.com',
            ],
            [
                'nombre' => 'Proveedor Q',
                'telefono' => '77806789',
                'email' => 'proveedor.q@gmail.com',
            ],
            [
                'nombre' => 'Proveedor R',
                'telefono' => '78907890',
                'email' => 'proveedor.r@gmail.com',
            ],
            [
                'nombre' => 'Proveedor S',
                'telefono' => '79008901',
                'email' => 'proveedor.s@gmail.com',
            ],
            [
                'nombre' => 'Proveedor T',
                'telefono' => '70109012',
                'email' => 'proveedor.t@gmail.com',
            ],
        ]);
    }
}
