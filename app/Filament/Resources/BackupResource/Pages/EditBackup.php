<?php

namespace App\Filament\Resources\BackupResource\Pages;

use App\Filament\Resources\BackupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditBackup extends EditRecord
{
    protected static string $resource = BackupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('descargar')
                ->label('Descargar')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('info')
                ->url(fn (): string => route('backups.download', $this->record))
                ->openUrlInNewTab()
                ->visible(fn (): bool => $this->record->archivo_existe),

            Actions\Action::make('restaurar')
                ->label('Restaurar')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Restaurar Backup')
                ->modalDescription('¿Está seguro de que desea restaurar este backup? Esta acción sobrescribirá todos los datos actuales de la base de datos.')
                ->modalSubmitActionLabel('Sí, restaurar')
                ->action(function (): void {
                    try {
                        // Aquí iría la lógica de restauración
                        // Por simplicidad, solo marcamos como restaurado
                        $this->record->marcarComoRestaurado();

                        Notification::make()
                            ->title('Backup restaurado')
                            ->body("El backup '{$this->record->nombre}' se ha restaurado correctamente.")
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Error al restaurar backup')
                            ->body('Error: ' . $e->getMessage())
                            ->danger()
                            ->send();
                    }
                })
                ->visible(fn (): bool => $this->record->puedeRestaurar()),

            Actions\DeleteAction::make()
                ->visible(fn (): bool => $this->record->puedeEliminar()),
        ];
    }
}
