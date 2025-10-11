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
        Schema::table('users', function (Blueprint $table) {
            $table->string('apellidos')->after('name');
            $table->string('telefono')->nullable()->after('email');
            $table->string('cargo')->nullable()->after('telefono');
            $table->enum('rol', ['admin', 'gestor', 'operador'])->default('operador')->after('cargo');
            $table->boolean('activo')->default(true)->after('rol');
            $table->timestamp('ultimo_acceso')->nullable()->after('activo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['apellidos', 'telefono', 'cargo', 'rol', 'activo', 'ultimo_acceso']);
        });
    }
};
