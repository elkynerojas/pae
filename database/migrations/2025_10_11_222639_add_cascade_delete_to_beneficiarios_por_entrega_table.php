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
        Schema::table('beneficiarios_por_entrega', function (Blueprint $table) {
            // Eliminar las foreign keys existentes
            $table->dropForeign(['beneficiario_id']);
            $table->dropForeign(['entrega_id']);
            
            // Agregar las nuevas foreign keys con cascade delete
            $table->foreign('beneficiario_id')
                  ->references('id')
                  ->on('beneficiarios')
                  ->onDelete('cascade');
                  
            $table->foreign('entrega_id')
                  ->references('id')
                  ->on('entregas')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beneficiarios_por_entrega', function (Blueprint $table) {
            // Eliminar las foreign keys con cascade
            $table->dropForeign(['beneficiario_id']);
            $table->dropForeign(['entrega_id']);
            
            // Restaurar las foreign keys originales sin cascade
            $table->foreign('beneficiario_id')
                  ->references('id')
                  ->on('beneficiarios');
                  
            $table->foreign('entrega_id')
                  ->references('id')
                  ->on('entregas');
        });
    }
};