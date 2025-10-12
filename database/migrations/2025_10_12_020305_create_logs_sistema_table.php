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
        Schema::create('logs_sistema', function (Blueprint $table) {
            $table->id();
            $table->string('accion'); // CREATE, UPDATE, DELETE, LOGIN, LOGOUT, etc.
            $table->string('tabla')->nullable(); // Nombre de la tabla afectada
            $table->unsignedBigInteger('registro_id')->nullable(); // ID del registro afectado
            $table->json('datos_anteriores')->nullable(); // Datos antes del cambio
            $table->json('datos_nuevos')->nullable(); // Datos después del cambio
            $table->string('descripcion'); // Descripción de la acción
            $table->string('ip_address')->nullable(); // IP del usuario
            $table->string('user_agent')->nullable(); // User agent del navegador
            $table->unsignedBigInteger('usuario_id')->nullable(); // ID del usuario que realizó la acción
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
            
            // Índices para mejorar el rendimiento
            $table->index(['accion', 'created_at']);
            $table->index(['tabla', 'registro_id']);
            $table->index(['usuario_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs_sistema');
    }
};
