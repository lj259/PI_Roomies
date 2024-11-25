<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departamentos')->insert([
            [
                'id_usuario' => 1,
                'id_categoria' => 1,
                'ubicacion' => 'Centro de la ciudad',
                'precio' => 15000.50,
                'habitaciones' => '3',
                'baños' => '2',
                'servicios' => 'Agua, Luz, Internet',
                'restricciones' => 'No mascotas',
            ],
            [
                'id_usuario' => 2,
                'id_categoria' => 1,
                'ubicacion' => 'Zona norte',
                'precio' => 12000.00,
                'habitaciones' => '2',
                'baños' => '1',
                'servicios' => 'Agua, Luz',
                'restricciones' => 'No fiestas',
            ],
            [
                'id_usuario' => 3,
                'id_categoria' => 1,
                'ubicacion' => 'Zona sur, cerca de la universidad',
                'precio' => 10000.00,
                'habitaciones' => '1',
                'baños' => '1',
                'servicios' => 'Agua, Luz, Internet',
                'restricciones' => 'No fumadores',
            ],
        ]);
    }
}
