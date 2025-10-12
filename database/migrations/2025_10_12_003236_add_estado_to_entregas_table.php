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
        Schema::table('entregas', function (Blueprint $table) {
            $table->enum('estado', ['abierta', 'cerrada'])->default('abierta')->after('observaciones');
            $table->timestamp('fecha_cierre')->nullable()->after('estado');
            $table->unsignedBigInteger('usuario_cierre_id')->nullable()->after('fecha_cierre');
            
            $table->foreign('usuario_cierre_id')->references('id')->on('users')->onDelete('set null');
            $table->index('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entregas', function (Blueprint $table) {
            $table->dropForeign(['usuario_cierre_id']);
            $table->dropIndex(['estado']);
            $table->dropColumn(['estado', 'fecha_cierre', 'usuario_cierre_id']);
        });
    }
};