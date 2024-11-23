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
        Schema::create('categoria', function (Blueprint $table) {
            $table->id('id_categoria');
            $table->string('nombre_categoria');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.2024_11_15_151443
     */
    public function down(): void
    {
        Schema::dropIfExists('categoria');
    }
};
