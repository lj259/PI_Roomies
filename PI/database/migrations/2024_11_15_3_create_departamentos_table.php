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
        Schema::create('departamentos', function (Blueprint $table) {
            $table->id(); // Clave primaria
            $table->foreignId('id_usuario')->constrained('usuarios')->onDelete('cascade'); // Clave foránea
            $table->foreignId('id_categoria')->constrained('categoria')->onDelete('cascade'); // Clave foránea
            $table->string('ubicacion');
            $table->decimal('precio', 10, 2);
            $table->string('habitaciones');
            $table->string('baños');
            $table->string('servicios');
            $table->string('restricciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departamentos');
    }
};
