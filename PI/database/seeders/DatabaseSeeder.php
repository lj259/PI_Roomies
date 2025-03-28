<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(rolSeeder::class);
        $this->call(usuarioSeeder::class);
        $this->call(PropietarioSeeder::class);
        $this->call(ApartamentosSeeder::class);
        //$this->call(categoriaSeeder::class);
        //$this->call(DepartamentosSeeder::class);
    }
}
