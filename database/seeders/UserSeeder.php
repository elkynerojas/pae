<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario administrador
        User::create([
            'name' => 'Administrador',
            'apellidos' => 'Sistema',
            'email' => 'admin@pae.com',
            'telefono' => '1234567890',
            'cargo' => 'Administrador del Sistema',
            'rol' => 'admin',
            'password' => Hash::make('password123'),
            'activo' => true,
        ]);

        // Crear usuario gestor
        User::create([
            'name' => 'María',
            'apellidos' => 'González',
            'email' => 'gestor@pae.com',
            'telefono' => '0987654321',
            'cargo' => 'Gestora de PAE',
            'rol' => 'gestor',
            'password' => Hash::make('password123'),
            'activo' => true,
        ]);

        // Crear usuario operador
        User::create([
            'name' => 'Juan',
            'apellidos' => 'Pérez',
            'email' => 'operador@pae.com',
            'telefono' => '5555555555',
            'cargo' => 'Operador de Campo',
            'rol' => 'operador',
            'password' => Hash::make('password123'),
            'activo' => true,
        ]);

        // Crear usuario inactivo de ejemplo
        User::create([
            'name' => 'Carlos',
            'apellidos' => 'Martínez',
            'email' => 'inactivo@pae.com',
            'telefono' => '1111111111',
            'cargo' => 'Ex Operador',
            'rol' => 'operador',
            'password' => Hash::make('password123'),
            'activo' => false,
        ]);
    }
}
