<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApartamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('apartamentos')->insert([
            [
                'propietario_id' =>2,
                'titulo' => 'Acogedor apartamento en el centro',
                'descripcion' => 'Este apartamento cuenta con 2 habitaciones, 1 baño, cocina equipada y está cerca de todos los servicios.',
                'direccion' => 'Calle Principal #123, Ciudad A',
                'latitud' => 40.712776,
                'longitud' => -74.005974,
                'precio' => 1200.00,
                'habitaciones_disponibles' => 2,
                'disponible_para' => 'mixto',
                'servicios' => json_encode(['Wi-Fi', 'Aire acondicionado', 'Lavadora']),
                'imagenes' => json_encode(['imagen1.jpg', 'imagen2.jpg']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'propietario_id' => 2,
                'titulo' => 'Amplio apartamento con vista al mar',
                'descripcion' => 'Disfruta de una vista espectacular al mar desde este apartamento de 3 habitaciones y 2 baños.',
                'direccion' => 'Avenida Costera #456, Ciudad B',
                'latitud' => 34.052235,
                'longitud' => -118.243683,
                'precio' => 1800.00,
                'habitaciones_disponibles' => 3,
                'disponible_para' => 'mixto',
                'servicios' => json_encode(['Piscina', 'Gimnasio', 'Estacionamiento']),
                'imagenes' => json_encode(['imagen3.jpg', 'imagen4.jpg']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'propietario_id' => 2,
                'titulo' => 'Apartamento moderno en zona residencial',
                'descripcion' => 'Este apartamento moderno cuenta con 1 habitación, 1 baño y está ubicado en una zona tranquila y segura.',
                'direccion' => 'Calle Residencial #789, Ciudad C',
                'latitud' => 51.507351,
                'longitud' => -0.127758,
                'precio' => 950.00,
                'habitaciones_disponibles' => 1,
                'disponible_para' => 'mujeres',
                'servicios' => json_encode(['Wi-Fi', 'Calefacción', 'Ascensor']),
                'imagenes' => json_encode(['imagen5.jpg', 'imagen6.jpg']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'propietario_id' => 2,
                'titulo' => 'Apartamento céntrico con terraza',
                'descripcion' => 'Apartamento con 2 habitaciones, 1 baño y una terraza con vistas a la ciudad. Ideal para parejas o pequeños grupos.',
                'direccion' => 'Calle Central #101, Ciudad D',
                'latitud' => 48.856613,
                'longitud' => 2.352222,
                'precio' => 1500.00,
                'habitaciones_disponibles' => 2,
                'disponible_para' => 'hombres',
                'servicios' => json_encode(['Terraza', 'Wi-Fi', 'Cocina equipada']),
                'imagenes' => json_encode(['imagen7.jpg', 'imagen8.jpg']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'propietario_id' => 2,
                'titulo' => 'Apartamento económico cerca de transporte público',
                'descripcion' => 'Este apartamento de 1 habitación y 1 baño está cerca de estaciones de metro y autobuses, ideal para estudiantes.',
                'direccion' => 'Calle Secundaria #202, Ciudad E',
                'latitud' => 35.689487,
                'longitud' => 139.691711,
                'precio' => 700.00,
                'habitaciones_disponibles' => 1,
                'disponible_para' => 'mixto',
                'servicios' => json_encode(['Wi-Fi', 'Lavadora', 'Ascensor']),
                'imagenes' => json_encode(['imagen9.jpg', 'imagen10.jpg']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
