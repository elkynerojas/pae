<?php

namespace App\Filament\Resources\EntregaResource\Pages;

use App\Filament\Resources\EntregaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;

class ViewEntrega extends ViewRecord implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = EntregaResource::class;

    protected function getHeaderActions(): array
    {
        return [
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

    public function table(Table $table): Table
    {
        return $table
            ->query($this->record->beneficiariosPorEntrega()->getQuery())
            ->columns([
                Tables\Columns\TextColumn::make('beneficiario.codigo')
                    ->label('Código')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('beneficiario.nombres')
                    ->label('Nombres')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('beneficiario.apellidos')
                    ->label('Apellidos')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('beneficiario.grado')
                    ->label('Grado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'primero', 'segundo', 'tercero' => 'success',
                        'cuarto', 'quinto', 'sexto' => 'warning',
                        'septimo', 'octavo', 'noveno', 'decimo' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'primero' => 'Primero',
                        'segundo' => 'Segundo',
                        'tercero' => 'Tercero',
                        'cuarto' => 'Cuarto',
                        'quinto' => 'Quinto',
                        'sexto' => 'Sexto',
                        'septimo' => 'Séptimo',
                        'octavo' => 'Octavo',
                        'noveno' => 'Noveno',
                        'decimo' => 'Décimo',
                        default => $state,
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('beneficiario.grupo')
                    ->label('Grupo')
                    ->sortable(),
                Tables\Columns\TextColumn::make('cantidad_raciones')
                    ->label('Raciones')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('observaciones')
                    ->label('Observaciones')
                    ->limit(30)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }
                        return $state;
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Agregado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('beneficiario.grado')
                    ->label('Grado')
                    ->options([
                        'primero' => 'Primero',
                        'segundo' => 'Segundo',
                        'tercero' => 'Tercero',
                        'cuarto' => 'Cuarto',
                        'quinto' => 'Quinto',
                        'sexto' => 'Sexto',
                        'septimo' => 'Séptimo',
                        'octavo' => 'Octavo',
                        'noveno' => 'Noveno',
                        'decimo' => 'Décimo',
                    ]),
                Tables\Filters\SelectFilter::make('beneficiario.grupo')
                    ->label('Grupo')
                    ->options(function () {
                        return $this->record->beneficiariosPorEntrega()
                            ->with('beneficiario')
                            ->get()
                            ->pluck('beneficiario.grupo')
                            ->filter()
                            ->unique()
                            ->sort()
                            ->mapWithKeys(fn ($grupo) => [$grupo => "Grupo {$grupo}"]);
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Editar')
                    ->visible(fn (): bool => $this->record->estaAbierta()),
                Tables\Actions\DeleteAction::make()
                    ->label('Eliminar')
                    ->requiresConfirmation()
                    ->visible(fn (): bool => $this->record->estaAbierta()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->visible(fn (): bool => $this->record->estaAbierta()),
                ]),
            ])
            ->defaultSort('beneficiario.codigo')
            ->emptyStateHeading('No hay beneficiarios registrados')
            ->emptyStateDescription('Esta entrega no tiene beneficiarios asignados.')
            ->emptyStateIcon('heroicon-o-users');
    }
}
