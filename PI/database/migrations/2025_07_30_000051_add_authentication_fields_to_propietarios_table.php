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
        Schema::table('propietarios', function (Blueprint $table) {
            $table->string('apellido_paterno')->after('nombre');
            $table->string('apellido_materno')->nullable()->after('apellido_paterno');
            $table->string('contraseña')->after('correo');
            $table->enum('genero', ['masculino', 'femenino', 'otro'])->after('telefono');
            $table->string('foto_perfil')->nullable()->after('genero');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('propietarios', function (Blueprint $table) {
            $table->dropColumn(['apellido_paterno', 'apellido_materno', 'contraseña', 'genero', 'foto_perfil']);
        });
    }
};
