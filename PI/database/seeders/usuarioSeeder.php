<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class usuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("usuarios")->insert([
            [
                'nombre'=>'Juan',
                'apellido_paterno'=>'Perez',
                'apellido_materno'=>'Garcia',
                'genero'=>'h',
                'telefono'=>'4427368293',
                'correo'=>'juan12@gmail.com',
                'password'=>'PASSWORD',
                'id_rol'=>1
            ],

            [
                'nombre'=>'Carmen',
                'apellido_paterno'=>'Carmona',
                'apellido_materno'=>'Gallardo',
                'genero'=>'m',
                'telefono'=>'4273629303',
                'correo'=>'carmen12@gmail.com',
                'password'=>'CARACALLA123',
                'id_rol'=>2
            ],

            [
                'nombre'=>'Miguel',
                'apellido_paterno'=>'Gonzales',
                'apellido_materno'=>'Galves',
                'genero'=>'h',
                'telefono'=>'4427364875',
                'correo'=>'122043672@upq.edu.mx',
                'password'=>'12345678',
                'id_rol'=>3
            ],
        ]);
    }
}
