<?php

namespace App\Filament\Resources\EntregaResource\Pages;

use App\Filament\Resources\EntregaResource;
use App\Models\Beneficiario;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
class ViewEntrega extends ViewRecord
{

    protected static string $resource = EntregaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('agregar_beneficiario')
                ->label('Agregar con Validación de Huella')
                ->icon('heroicon-o-finger-print')
                ->color('primary')
                ->url(fn (): string => route('entregas.agregar-beneficiario', $this->record))
                ->visible(fn (): bool => $this->record->estaAbierta()),
            Actions\Action::make('agregar_beneficiario_por_huella')
                ->label('Agregar Solo con Huella')
                ->icon('heroicon-o-finger-print')
                ->color('success')
                ->url(fn (): string => route('entregas.agregar-beneficiario-por-huella', $this->record))
                ->visible(fn (): bool => $this->record->estaAbierta()),
            Actions\EditAction::make()
                ->visible(fn (): bool => $this->record->estaAbierta()),
            Actions\Action::make('cerrar')
                ->label('Cerrar Entrega')
                ->icon('heroicon-o-lock-closed')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Cerrar Entrega')
                ->modalDescription('¿Está seguro de que desea cerrar esta entrega? Una vez cerrada, no se podrán realizar modificaciones.')
                ->action(fn () => $this->record->cerrar())
                ->visible(fn (): bool => $this->record->estaAbierta()),
            Actions\Action::make('abrir')
                ->label('Reabrir Entrega')
                ->icon('heroicon-o-lock-open')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Reabrir Entrega')
                ->modalDescription('¿Está seguro de que desea reabrir esta entrega? Solo administradores pueden realizar esta acción.')
                ->action(fn () => $this->record->abrir())
                ->visible(fn (): bool => $this->record->estaCerrada()),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Información de la Entrega')
                    ->schema([
                        Infolists\Components\TextEntry::make('fecha')
                            ->label('Fecha de Entrega')
                            ->date('d/m/Y'),
                        Infolists\Components\TextEntry::make('racion.nombre')
                            ->label('Ración'),
                        Infolists\Components\TextEntry::make('estado')
                            ->label('Estado')
                            ->badge()
                            ->color(fn (?string $state): string => match ($state) {
                                'abierta' => 'success',
                                'cerrada' => 'gray',
                                default => 'success',
                            })
                            ->formatStateUsing(fn (?string $state): string => match ($state) {
                                'abierta' => 'Abierta',
                                'cerrada' => 'Cerrada',
                                default => 'Abierta',
                            }),
                        Infolists\Components\TextEntry::make('fecha_cierre')
                            ->label('Fecha de Cierre')
                            ->dateTime('d/m/Y H:i')
                            ->visible(fn (): bool => $this->record->estaCerrada()),
                        Infolists\Components\TextEntry::make('usuarioCierre.name')
                            ->label('Cerrado por')
                            ->visible(fn (): bool => $this->record->estaCerrada()),
                        Infolists\Components\TextEntry::make('observaciones')
                            ->label('Observaciones')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                
                Infolists\Components\Section::make('Resumen de Beneficiarios')
                    ->schema([
                        Infolists\Components\TextEntry::make('beneficiarios_count')
                            ->label('Total de Beneficiarios')
                            ->numeric()
                            ->state(fn (): int => $this->record->beneficiariosPorEntrega()->count()),
                        Infolists\Components\TextEntry::make('total_raciones')
                            ->label('Total de Raciones')
                            ->numeric()
                            ->state(fn (): int => $this->record->beneficiariosPorEntrega()->sum('cantidad_raciones')),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Fecha de Creación')
                            ->dateTime('d/m/Y H:i'),
                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Última Actualización')
                            ->dateTime('d/m/Y H:i'),
                    ])
                    ->columns(2),
            ]);
    }

    // Removemos el formulario integrado para evitar conflictos
}
