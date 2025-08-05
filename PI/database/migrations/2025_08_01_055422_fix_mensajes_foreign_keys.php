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
        Schema::table('mensajes', function (Blueprint $table) {
            // Drop existing foreign key constraints
            $table->dropForeign(['emisor_id']);
            $table->dropForeign(['receptor_id']);
            
            // Add correct foreign key constraints to usuarios table
            $table->foreign('emisor_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('receptor_id')->references('id')->on('usuarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mensajes', function (Blueprint $table) {
            // Drop the new foreign key constraints
            $table->dropForeign(['emisor_id']);
            $table->dropForeign(['receptor_id']);
            
            // Restore original foreign key constraints (if needed)
            $table->foreign('emisor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receptor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
