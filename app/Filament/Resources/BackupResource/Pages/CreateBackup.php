<?php

namespace App\Filament\Resources\BackupResource\Pages;

use App\Filament\Resources\BackupResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;

class CreateBackup extends CreateRecord
{
    protected static string $resource = BackupResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['usuario_id'] = auth()->id();
        $data['fecha_creacion'] = now();
        $data['estado'] = 'en_proceso';
        $data['tamaño'] = 0;
        $data['tamaño_formateado'] = '0 B';
        $data['archivo'] = $data['nombre'] . '.sql';
        $data['ruta'] = storage_path('app/backups/' . $data['nombre'] . '.sql');

        return $data;
    }

    protected function afterCreate(): void
    {
        // Ejecutar el comando de backup después de crear el registro
        try {
            $exitCode = Artisan::call('backup:database', [
                '--name' => $this->record->nombre,
                '--description' => $this->record->descripcion ?? '',
            ]);

            if ($exitCode === 0) {
                // Actualizar información del backup
                $archivoPath = storage_path('app/backups/' . $this->record->nombre . '.sql');
                if (file_exists($archivoPath)) {
                    $tamaño = filesize($archivoPath);
                    $this->record->update([
                        'tamaño' => $tamaño,
                        'tamaño_formateado' => $this->formatearBytes($tamaño),
                        'estado' => 'completado',
                    ]);
                }

                Notification::make()
                    ->title('Backup creado exitosamente')
                    ->body("El backup '{$this->record->nombre}' se ha creado correctamente.")
                    ->success()
                    ->send();
            } else {
                $this->record->update(['estado' => 'fallido']);
                
                Notification::make()
                    ->title('Error al crear backup')
                    ->body('Ocurrió un error al crear el backup. Verifique los logs.')
                    ->danger()
                    ->send();
            }
        } catch (\Exception $e) {
            $this->record->update(['estado' => 'fallido']);
            
            Notification::make()
                ->title('Error al crear backup')
                ->body('Error: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }

    private function formatearBytes($size, $precision = 2): string
    {
        if ($size == 0) return '0 B';
        
        $base = log($size, 1024);
        $suffixes = ['B', 'KB', 'MB', 'GB', 'TB'];
        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }
}
