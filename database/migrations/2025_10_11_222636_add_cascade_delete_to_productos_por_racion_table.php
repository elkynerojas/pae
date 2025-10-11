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
        Schema::table('productos_por_racion', function (Blueprint $table) {
            // Eliminar las foreign keys existentes
            $table->dropForeign(['producto_id']);
            $table->dropForeign(['racion_id']);
            
            // Agregar las nuevas foreign keys con cascade delete
            $table->foreign('producto_id')
                  ->references('id')
                  ->on('productos')
                  ->onDelete('cascade');
                  
            $table->foreign('racion_id')
                  ->references('id')
                  ->on('raciones')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos_por_racion', function (Blueprint $table) {
            // Eliminar las foreign keys con cascade
            $table->dropForeign(['producto_id']);
            $table->dropForeign(['racion_id']);
            
            // Restaurar las foreign keys originales sin cascade
            $table->foreign('producto_id')
                  ->references('id')
                  ->on('productos');
                  
            $table->foreign('racion_id')
                  ->references('id')
                  ->on('raciones');
        });
    }
};