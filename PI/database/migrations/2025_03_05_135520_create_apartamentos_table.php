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
        Schema::create('apartamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('propietario_id')->constrained('propietarios')->onDelete('cascade');
            $table->string('titulo');
            $table->text('descripcion');
            $table->string('direccion');
            $table->decimal('latitud', 10, 7);
            $table->decimal('longitud', 10, 7);
            $table->decimal('precio', 10, 2);
            $table->integer('habitaciones_disponibles');
            $table->enum('disponible_para',['masculino','femenino','otro']);
            $table->json('servicios')->nullable();
            $table->json('imagenes')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartamentos');
    }
};
