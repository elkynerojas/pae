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
        Schema::table('beneficiarios', function (Blueprint $table) {
            // Hacer campos opcionales para facilitar la importación
            $table->string('codigo')->nullable()->change();
            $table->date('fecha_nacimiento')->nullable()->change();
            $table->string('grado')->nullable()->change();
            $table->string('grupo')->nullable()->change();
            
            // Cambiar activo a boolean con valor por defecto
            $table->boolean('activo')->default(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beneficiarios', function (Blueprint $table) {
            // Revertir cambios
            $table->string('codigo')->nullable(false)->change();
            $table->date('fecha_nacimiento')->nullable(false)->change();
            $table->string('grado')->nullable(false)->change();
            $table->string('grupo')->nullable(false)->change();
            $table->string('activo')->nullable(false)->change();
        });
    }
};