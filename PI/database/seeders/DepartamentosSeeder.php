<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentosSeeder extends Seeder
{
    public function run()
    {
        DB::table('apartamentos')->insert([
            [
                'propietario_id' => 1,
                'titulo' => 'Acogedor apartamento en el centro',
                'descripcion' => 'Este apartamento cuenta con 2 habitaciones, 1 baño, cocina equipada y está cerca de todos los servicios.',
                'direccion' => 'Calle Principal #123, Ciudad A',
                'latitud' => 40.712776,
                'longitud' => -74.005974,
                'precio' => 1200,
                'habitaciones_disponibles' => 2,
                'disponible_para' => 'masculino',  // Asignamos un valor válido
                'servicios' => json_encode(["Wi-Fi", "Aire acondicionado", "Lavadora"]),
                'imagenes' => json_encode(["imagen1.jpg", "imagen2.jpg"]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'propietario_id' => 2,
                'titulo' => 'Acogedor apartamento en el Norte',
                'descripcion' => 'Este apartamento cuenta con 3 habitaciones.',
                'direccion' => 'Calle Principal #524, Ciudad A',
                'latitud' => 40.712776,
                'longitud' => -74.005974,
                'precio' => 1200,
                'habitaciones_disponibles' => 3,
                'disponible_para' => 'femenino',  // Asignamos un valor válido
                'servicios' => json_encode(["Wi-Fi", "Aire acondicionado", "Lavadora"]),
                'imagenes' => json_encode(["imagen1.jpg", "imagen2.jpg"]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'propietario_id' => 3,
                'titulo' => 'Departamentos Chicos',
                'descripcion' => 'Departamentos centrados cerca de las rutas del camion.',
                'direccion' => 'Avenida Costera #456, Ciudad B',
                'latitud' => 34.052235,
                'longitud' => -118.243683,
                'precio' => 1800,
                'habitaciones_disponibles' => 5,
                'disponible_para' => 'otro',  // Asignamos un valor válido
                'servicios' => json_encode(["Gimnasio", "Estacionamiento"]),
                'imagenes' => json_encode(["imagen3.jpg", "imagen4.jpg"]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        
    }
}
