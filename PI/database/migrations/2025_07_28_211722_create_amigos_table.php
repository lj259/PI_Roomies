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
        Schema::create('amigos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idUsuario1')->constrained('usuarios')->onDelete('cascade');
            $table->foreignId('idUsuario2')->constrained('usuarios')->onDelete('cascade');
            $table->enum('estatus', ['pendiente', 'aceptado', 'rechazado', 'bloqueado'])->default('pendiente');
            $table->timestamps();
            $table->unique(['idUsuario1', 'idUsuario2']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amigos');
    }
};
