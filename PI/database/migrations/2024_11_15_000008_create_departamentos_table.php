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
            $table->id('id_departamento');
            $table->unsignedBigInteger('id_propietario');
            $table->string('precio');
            $table->string('ubicacion');
            $table->string('habitaciones');
            $table->string('baños');
            $table->string('servicios');
            $table->string('restricciones');
            $table->string('cercanias');
            $table->timestamps();

            $table->foreign('id_propietario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
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
