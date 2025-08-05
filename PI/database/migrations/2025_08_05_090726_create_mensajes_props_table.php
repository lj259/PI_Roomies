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
        Schema::create('mensajes_props', function (Blueprint $table) {
            $table->id();
            // First create the columns
            $table->unsignedBigInteger('emisor_id');
            $table->unsignedBigInteger('receptor_id');
            $table->text('contenido');
            $table->boolean('es_propietario')->default(false);
            $table->timestamps();
            
            // Then add the foreign key constraints
            $table->foreign('emisor_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('receptor_id')->references('id')->on('propietarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensajes_props');
    }
};
