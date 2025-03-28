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
                'genero'=>'masculino',
                'telefono'=>'4427368293',
                'correo'=>'juan12@gmail.com',
                'contraseña'=>'$2y$12$HAf8zAhCnJwyRXvDq4hiL.cj7FDf/bNNMNN1HdqlPmIZg8P2Yfu8y',
                'rol'=>'usuario'
            ],

            [
                'nombre'=>'Carmen',
                'apellido_paterno'=>'Carmona',
                'apellido_materno'=>'Gallardo',
                'genero'=>'femenino',
                'telefono'=>'4273629303',
                'correo'=>'carmen12@gmail.com',
                'contraseña'=>'$2y$12$AzG4EHirPqnzejDzj52zXupVRbLsnbEaeKzuWNwdHgPiaS1S8ZCVi',
                'rol'=>'admin'
            ],

            [
                'nombre'=>'Miguel',
                'apellido_paterno'=>'Gonzales',
                'apellido_materno'=>'Galves',
                'genero'=>'masculino',
                'telefono'=>'4427364875',
                'correo'=>'122043672@upq.edu.mx',
                'contraseña'=>'$2y$12$HAf8zAhCnJwyRXvDq4hiL.cj7FDf/bNNMNN1HdqlPmIZg8P2Yfu8y',
                'rol'=>'usuario'
            ],
        ]);
    }
}
