<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registro_actividad', function (Blueprint $table) {
            $table->id(); // Clave primaria
            $table->foreignId('id_usuario')->constrained('usuarios')->onDelete('cascade'); // Clave foránea
            $table->string('descripcion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_actividad');
    }
};
