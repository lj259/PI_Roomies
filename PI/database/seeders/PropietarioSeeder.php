<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropietarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('propietarios')->insert([
            [
                'nombre' => 'María González',
                'correo' => 'maria.gonzalez@example.com',
                'telefono' => '5512345678',
            ],
            [
                'nombre' => 'Carlos Mendoza',
                'correo' => 'carlos.mendoza@example.com',
                'telefono' => '5523456789',
            ],
            [
                'nombre' => 'Ana López',
                'correo' => 'ana.lopez@example.com',
                'telefono' => '5545273901', // Ejemplo con teléfono nulo
            ],
            [
                'nombre' => 'Roberto Sánchez',
                'correo' => 'roberto.sanchez@example.com',
                'telefono' => '5545678901',
            ],
            [
                'nombre' => 'Luisa Ramírez',
                'correo' => 'luisa.ramirez@example.com',
                'telefono' => '5556789012',
            ],
        ]);
    }
}
