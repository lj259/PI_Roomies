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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno');
            $table->string('correo')->unique();
            $table->string('contraseña');
            $table->string('genero');
            $table->string('telefono')->nullable();
            $table->string('foto_perfil')->nullable();
            $table->enum('genero',['masculino','femenino','otro']);
            $table->string('rol')->default('usuario');
            $table->json('preferencias_roomie')->nullable();
            $table->unsignedBigInteger('id_rol')->nullable();

            $table->foreign('id_rol')->references('id')->on('roles')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
{}