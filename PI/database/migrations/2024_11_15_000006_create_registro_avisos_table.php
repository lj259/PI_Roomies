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
            $table->id('id_reg_avisos');
            $table->unsignedBigInteger('id_categoria');
            $table->unsignedBigInteger('id_usuario');
            $table->string('titulo');
            $table->string('contenido');
            $table->string('activo');
            $table->timestamps();

            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->foreign('id_categoria')->references('id_categoria')->on('categoria')->onDelete('cascade');
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
