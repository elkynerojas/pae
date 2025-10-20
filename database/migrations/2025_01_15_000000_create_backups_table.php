<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('backups', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('archivo');
            $table->string('ruta');
            $table->bigInteger('tamaño'); // Tamaño en bytes
            $table->string('tamaño_formateado'); // Tamaño formateado (MB, GB, etc.)
            $table->text('descripcion')->nullable();
            $table->enum('estado', ['completado', 'en_proceso', 'fallido'])->default('completado');
            $table->enum('tipo', ['manual', 'automatico', 'programado'])->default('manual');
            $table->timestamp('fecha_creacion');
            $table->timestamp('fecha_restauracion')->nullable();
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->unsignedBigInteger('usuario_restauracion_id')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('usuario_restauracion_id')->references('id')->on('users')->onDelete('set null');

            // Índices
            $table->index(['estado', 'fecha_creacion']);
            $table->index(['tipo', 'fecha_creacion']);
            $table->index('usuario_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('backups');
    }
};
