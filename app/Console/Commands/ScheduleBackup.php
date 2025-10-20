<?php

namespace App\Console\Commands;

use App\Models\Backup;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;

class ScheduleBackup extends Command
{
    protected $signature = 'backup:schedule {--type=daily} {--keep=30}';
    protected $description = 'Crear backup programado y limpiar backups antiguos';

    public function handle()
    {
        $type = $this->option('type'); // daily, weekly, monthly
        $keep = (int) $this->option('keep'); // días a mantener

        $this->info("Iniciando backup programado tipo: {$type}");

        try {
            // Generar nombre del backup
            $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $nombre = "backup_{$type}_{$timestamp}";
            $descripcion = "Backup automático {$type} - " . Carbon::now()->format('d/m/Y H:i');

            // Crear registro del backup
            $backup = Backup::crearBackup($nombre, $descripcion, 'automatico');

            // Ejecutar comando de backup
            $exitCode = Artisan::call('backup:database', [
                '--name' => $nombre,
                '--description' => $descripcion,
            ]);

            if ($exitCode === 0) {
                // Actualizar información del backup
                $archivoPath = storage_path('app/backups/' . $nombre . '.sql');
                if (file_exists($archivoPath)) {
                    $tamaño = filesize($archivoPath);
                    $backup->update([
                        'tamaño' => $tamaño,
                        'tamaño_formateado' => $this->formatearBytes($tamaño),
                        'estado' => 'completado',
                    ]);
                }

                $this->info("✅ Backup programado creado exitosamente: {$nombre}");
            } else {
                $backup->update(['estado' => 'fallido']);
                $this->error("❌ Error al crear backup programado");
                return Command::FAILURE;
            }

            // Limpiar backups antiguos
            $this->limpiarBackupsAntiguos($keep);

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('❌ Error en backup programado: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    private function limpiarBackupsAntiguos($dias)
    {
        $this->info("Limpiando backups más antiguos de {$dias} días...");

        $fechaLimite = Carbon::now()->subDays($dias);
        $backupsAntiguos = Backup::where('fecha_creacion', '<', $fechaLimite)
            ->where('estado', 'completado')
            ->where('tipo', 'automatico') // Solo limpiar backups automáticos
            ->get();

        $eliminados = 0;
        foreach ($backupsAntiguos as $backup) {
            if ($backup->eliminarArchivo()) {
                $backup->delete();
                $eliminados++;
            }
        }

        $this->info("✅ Se eliminaron {$eliminados} backups antiguos");
    }

    private function formatearBytes($size, $precision = 2): string
    {
        if ($size == 0) return '0 B';
        
        $base = log($size, 1024);
        $suffixes = ['B', 'KB', 'MB', 'GB', 'TB'];
        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }
}
