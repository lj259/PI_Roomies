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
                'email'=>'juan12@gmail.com',
                'password'=>'$2y$12$HAf8zAhCnJwyRXvDq4hiL.cj7FDf/bNNMNN1HdqlPmIZg8P2Yfu8y',
                'id_rol'=>1
            ],

            [
                'nombre'=>'Carmen',
                'apellido_paterno'=>'Carmona',
                'apellido_materno'=>'Gallardo',
                'genero'=>'m',
                'telefono'=>'4273629303',
                'email'=>'carmen12@gmail.com',
                'password'=>'$2y$12$AzG4EHirPqnzejDzj52zXupVRbLsnbEaeKzuWNwdHgPiaS1S8ZCVi',
                'id_rol'=>2
            ],

            [
                'nombre'=>'Miguel',
                'apellido_paterno'=>'Gonzales',
                'apellido_materno'=>'Galves',
                'genero'=>'h',
                'telefono'=>'4427364875',
                'email'=>'122043672@upq.edu.mx',
                'password'=>'$2y$12$AzG4EHirPqnzejDzj52zXupVRbLsnbEaeKzuWNwdHgPiaS1S8ZCVi',
                'id_rol'=>3
            ],
        ]);
    }
}
