<?php

namespace Database\Seeders;

use App\Models\Backup;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BackupSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = User::all();

        if ($usuarios->isEmpty()) {
            $this->command->warn('No hay usuarios en la base de datos. Creando backup de ejemplo sin usuario.');
        }

        // Backups de ejemplo
        $backups = [
            [
                'nombre' => 'backup_inicial',
                'archivo' => 'backup_inicial.sql',
                'ruta' => storage_path('app/backups/backup_inicial.sql'),
                'tamaño' => 2048576, // 2MB
                'tamaño_formateado' => '2.00 MB',
                'descripcion' => 'Backup inicial del sistema',
                'estado' => 'completado',
                'tipo' => 'manual',
                'fecha_creacion' => Carbon::now()->subDays(30),
                'usuario_id' => $usuarios->first()?->id,
            ],
            [
                'nombre' => 'backup_diario_2025_01_14',
                'archivo' => 'backup_diario_2025_01_14.sql',
                'ruta' => storage_path('app/backups/backup_diario_2025_01_14.sql'),
                'tamaño' => 3145728, // 3MB
                'tamaño_formateado' => '3.00 MB',
                'descripcion' => 'Backup automático diario',
                'estado' => 'completado',
                'tipo' => 'automatico',
                'fecha_creacion' => Carbon::now()->subDays(1),
                'usuario_id' => null,
            ],
            [
                'nombre' => 'backup_semanal_2025_01_12',
                'archivo' => 'backup_semanal_2025_01_12.sql',
                'ruta' => storage_path('app/backups/backup_semanal_2025_01_12.sql'),
                'tamaño' => 4194304, // 4MB
                'tamaño_formateado' => '4.00 MB',
                'descripcion' => 'Backup automático semanal',
                'estado' => 'completado',
                'tipo' => 'automatico',
                'fecha_creacion' => Carbon::now()->subDays(3),
                'usuario_id' => null,
            ],
            [
                'nombre' => 'backup_fallido_2025_01_10',
                'archivo' => 'backup_fallido_2025_01_10.sql',
                'ruta' => storage_path('app/backups/backup_fallido_2025_01_10.sql'),
                'tamaño' => 0,
                'tamaño_formateado' => '0 B',
                'descripcion' => 'Backup que falló por error de conexión',
                'estado' => 'fallido',
                'tipo' => 'automatico',
                'fecha_creacion' => Carbon::now()->subDays(5),
                'usuario_id' => null,
                'notas' => 'Error: No se pudo conectar a la base de datos',
            ],
            [
                'nombre' => 'backup_pre_migracion',
                'archivo' => 'backup_pre_migracion.sql',
                'ruta' => storage_path('app/backups/backup_pre_migracion.sql'),
                'tamaño' => 1572864, // 1.5MB
                'tamaño_formateado' => '1.50 MB',
                'descripcion' => 'Backup antes de migración importante',
                'estado' => 'completado',
                'tipo' => 'manual',
                'fecha_creacion' => Carbon::now()->subDays(7),
                'usuario_id' => $usuarios->first()?->id,
                'fecha_restauracion' => Carbon::now()->subDays(6),
                'usuario_restauracion_id' => $usuarios->first()?->id,
                'notas' => 'Backup restaurado después de rollback de migración',
            ],
        ];

        foreach ($backups as $backup) {
            Backup::create($backup);
        }

        $this->command->info('✅ Backups de ejemplo creados exitosamente.');
    }
}
