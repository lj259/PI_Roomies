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
                'img_path'=>'',
                'ubicacion' => 'Centro de la ciudad',
                'precio' => 5000.50,
                'habitaciones' => '3',
                'baños' => '2',
                'servicios' => 'Agua, Luz, Internet',
                'restricciones' => 'No mascotas',
                'cercanias' => 'Oxxos, Tiendas departamentales, garnachas',
            ],
            [
                'id_usuario' => 2,
                'id_categoria' => 1,
                'img_path'=>'',
                'ubicacion' => 'Zona norte',
                'precio' => 3000.00,
                'habitaciones' => '2',
                'baños' => '1',
                'servicios' => 'Agua, Luz',
                'restricciones' => 'No fiestas',
                'cercanias' => 'Oxxos, Bodega Aurrera',
            ],
            [
                'id_usuario' => 3,
                'id_categoria' => 1,
                'img_path'=>'',
                'ubicacion' => 'Zona sur, cerca de la universidad',
                'precio' => 10000.00,
                'habitaciones' => '1',
                'baños' => '1',
                'servicios' => 'Agua, Luz, Internet',
                'restricciones' => 'No fumadores',
                'cercanias' => 'Universidad, Parques industriales',
            ],
        ]);
    }
}
