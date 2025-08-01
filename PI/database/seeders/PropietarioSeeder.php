<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Propietario;
use Illuminate\Support\Facades\Hash;

class PropietarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Propietario::create([
            'nombre' => 'María',
            'apellido_paterno' => 'González',
            'apellido_materno' => 'Hernández',
            'correo' => 'maria.gonzalez@example.com',
            'contraseña' => Hash::make('password123'),
            'telefono' => '5512345678',
            'genero' => 'femenino',
        ]);

        Propietario::create([
            'nombre' => 'Carlos',
            'apellido_paterno' => 'Mendoza',
            'apellido_materno' => 'Silva',
            'correo' => 'carlos.mendoza@example.com',
            'contraseña' => Hash::make('password123'),
            'telefono' => '5523456789',
            'genero' => 'masculino',
        ]);

        Propietario::create([
            'nombre' => 'Ana',
            'apellido_paterno' => 'López',
            'apellido_materno' => 'Torres',
            'correo' => 'ana.lopez@example.com',
            'contraseña' => Hash::make('password123'),
            'telefono' => '5534567890',
            'genero' => 'femenino',
        ]);
    }
