<?php

namespace App\Filament\Resources\BackupResource\Pages;

use App\Filament\Resources\BackupResource;
use App\Models\Backup;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;
use Filament\Forms;

class ListBackups extends ListRecords
{
    protected static string $resource = BackupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('crear_backup_rapido')
                ->label('Crear Backup Rápido')
                ->icon('heroicon-o-plus-circle')
                ->color('success')
                ->action(function (): void {
                    try {
                        $nombre = 'backup_rapido_' . now()->format('Y-m-d_H-i-s');
                        
                        $exitCode = Artisan::call('backup:database', [
                            '--name' => $nombre,
                            '--description' => 'Backup rápido creado desde la interfaz',
                        ]);

                        if ($exitCode === 0) {
                            Notification::make()
                                ->title('Backup creado exitosamente')
                                ->body("El backup '{$nombre}' se ha creado correctamente.")
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Error al crear backup')
                                ->body('Ocurrió un error al crear el backup. Verifique los logs.')
                                ->danger()
                                ->send();
                        }
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Error al crear backup')
                            ->body('Error: ' . $e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),

            Actions\Action::make('limpiar_antiguos')
                ->label('Limpiar Antiguos')
                ->icon('heroicon-o-trash')
                ->color('warning')
                ->form([
                    \Filament\Forms\Components\TextInput::make('dias')
                        ->label('Días')
                        ->numeric()
                        ->default(30)
                        ->minValue(1)
                        ->maxValue(365)
                        ->helperText('Eliminar backups más antiguos que X días'),
                ])
                ->action(function (array $data): void {
                    try {
                        $dias = $data['dias'];
                        $fechaLimite = now()->subDays($dias);

                        $backupsAntiguos = Backup::where('fecha_creacion', '<', $fechaLimite)
                            ->where('estado', 'completado')
                            ->get();

                        $eliminados = 0;
                        foreach ($backupsAntiguos as $backup) {
                            if ($backup->eliminarArchivo()) {
                                $backup->delete();
                                $eliminados++;
                            }
                        }

                        Notification::make()
                            ->title('Limpieza completada')
                            ->body("Se eliminaron {$eliminados} backups más antiguos de {$dias} días.")
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Error en la limpieza')
                            ->body('Error: ' . $e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),

            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        try {
            if (!\Schema::hasTable('backups')) {
                return [
                    'todos' => Tab::make('Todos')
                        ->badge(0),
                ];
            }

            return [
                'todos' => Tab::make('Todos')
                    ->badge(Backup::count()),

                'completados' => Tab::make('Completados')
                    ->modifyQueryUsing(fn (Builder $query) => $query->where('estado', 'completado'))
                    ->badge(Backup::where('estado', 'completado')->count()),

                'fallidos' => Tab::make('Fallidos')
                    ->modifyQueryUsing(fn (Builder $query) => $query->where('estado', 'fallido'))
                    ->badge(Backup::where('estado', 'fallido')->count()),

                'manuales' => Tab::make('Manuales')
                    ->modifyQueryUsing(fn (Builder $query) => $query->where('tipo', 'manual'))
                    ->badge(Backup::where('tipo', 'manual')->count()),

                'automaticos' => Tab::make('Automáticos')
                    ->modifyQueryUsing(fn (Builder $query) => $query->where('tipo', 'automatico'))
                    ->badge(Backup::where('tipo', 'automatico')->count()),
            ];
        } catch (\Exception $e) {
            return [
                'todos' => Tab::make('Todos')
                    ->badge(0),
            ];
        }
    }

}
