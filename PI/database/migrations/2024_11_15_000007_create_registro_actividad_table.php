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
            $table->id('id_reg_actividad');
            $table->unsignedBigInteger('id_usuario');
            $table->string('tipo_actividad');
            $table->string('descripcion');
            $table->timestamps();

            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
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
