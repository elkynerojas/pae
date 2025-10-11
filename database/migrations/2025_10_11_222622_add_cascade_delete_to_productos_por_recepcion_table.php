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
        Schema::table('productos_por_recepcion', function (Blueprint $table) {
            // Eliminar la foreign key existente
            $table->dropForeign(['recepcion_id']);
            
            // Agregar la nueva foreign key con cascade delete
            $table->foreign('recepcion_id')
                  ->references('id')
                  ->on('recepciones')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos_por_recepcion', function (Blueprint $table) {
            // Eliminar la foreign key con cascade
            $table->dropForeign(['recepcion_id']);
            
            // Restaurar la foreign key original sin cascade
            $table->foreign('recepcion_id')
                  ->references('id')
                  ->on('recepciones');
        });
    }
};