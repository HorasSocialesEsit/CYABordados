<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario si no existe
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('123456789'),
                'estado' => 'activo',
            ]
        );

        // Crear rol admin si no existe
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Asignar rol al usuario
        $user->roles()->syncWithoutDetaching([$adminRole->id]);

    }
}
