<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class categoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categoria')->insert([
            ['nombre_categoria' => 'Departamento'],
            ['nombre_categoria' => 'Casa'],
            ['nombre_categoria' => 'Cuarto'],
        ]);
    }
}
