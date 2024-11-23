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
        Schema::create('registro_avisos', function (Blueprint $table) {
            $table->id(); // Clave primaria
            $table->foreignId('id_categoria')->constrained('categoria')->onDelete('cascade'); // Clave foránea
            $table->foreignId('id_usuario')->constrained('usuarios')->onDelete('cascade'); // Clave foránea
            $table->string('titulo');
            $table->string('descripcion');
            $table->string('activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_avisos');
    }
};
