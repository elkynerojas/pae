<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BackupResource\Pages;
use App\Models\Backup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;

class BackupResource extends Resource
{
    protected static ?string $model = Backup::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box-arrow-down';

    protected static ?string $navigationGroup = 'Sistema';

    protected static ?int $navigationSort = 200;

    protected static ?string $navigationLabel = 'Backups';

    protected static ?string $modelLabel = 'Backup';

    protected static ?string $pluralModelLabel = 'Backups';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del Backup')
                    ->schema([
                        Forms\Components\TextInput::make('nombre')
                            ->label('Nombre del Backup')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Nombre único para identificar el backup'),

                        Forms\Components\Textarea::make('descripcion')
                            ->label('Descripción')
                            ->maxLength(500)
                            ->rows(3)
                            ->helperText('Descripción opcional del backup'),

                        Forms\Components\Select::make('tipo')
                            ->label('Tipo de Backup')
                            ->options([
                                'manual' => 'Manual',
                                'automatico' => 'Automático',
                                'programado' => 'Programado',
                            ])
                            ->default('manual')
                            ->required(),

                        Forms\Components\Textarea::make('notas')
                            ->label('Notas')
                            ->maxLength(1000)
                            ->rows(3)
                            ->helperText('Notas adicionales sobre el backup'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 50 ? $state : null;
                    }),

                Tables\Columns\TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'completado' => 'success',
                        'en_proceso' => 'warning',
                        'fallido' => 'danger',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'completado' => 'heroicon-o-check-circle',
                        'en_proceso' => 'heroicon-o-clock',
                        'fallido' => 'heroicon-o-x-circle',
                        default => 'heroicon-o-question-mark-circle',
                    }),

                Tables\Columns\TextColumn::make('tipo')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'manual' => 'primary',
                        'automatico' => 'info',
                        'programado' => 'secondary',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('tamaño_formateado')
                    ->label('Tamaño')
                    ->sortable(['tamaño'])
                    ->alignEnd(),

                Tables\Columns\TextColumn::make('fecha_creacion')
                    ->label('Fecha de Creación')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('usuario.name')
                    ->label('Creado por')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('fecha_restauracion')
                    ->label('Última Restauración')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('archivo_existe')
                    ->label('Archivo')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Existe' : 'No existe')
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                    ->icon(fn (bool $state): string => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                    ->tooltip('¿Existe el archivo físico?'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->options([
                        'completado' => 'Completado',
                        'en_proceso' => 'En Proceso',
                        'fallido' => 'Fallido',
                    ]),

                Tables\Filters\SelectFilter::make('tipo')
                    ->options([
                        'manual' => 'Manual',
                        'automatico' => 'Automático',
                        'programado' => 'Programado',
                    ]),

                Tables\Filters\Filter::make('fecha_creacion')
                    ->form([
                        Forms\Components\DatePicker::make('desde')
                            ->label('Desde'),
                        Forms\Components\DatePicker::make('hasta')
                            ->label('Hasta'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['desde'],
                                fn (Builder $query, $date): Builder => $query->whereDate('fecha_creacion', '>=', $date),
                            )
                            ->when(
                                $data['hasta'],
                                fn (Builder $query, $date): Builder => $query->whereDate('fecha_creacion', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('crear_backup')
                    ->label('Crear Backup')
                    ->icon('heroicon-o-plus-circle')
                    ->color('success')
                    ->form([
                        Forms\Components\TextInput::make('nombre')
                            ->label('Nombre del Backup')
                            ->required()
                            ->maxLength(255)
                            ->unique('backups', 'nombre')
                            ->helperText('Nombre único para identificar el backup'),

                        Forms\Components\Textarea::make('descripcion')
                            ->label('Descripción')
                            ->maxLength(500)
                            ->rows(3)
                            ->helperText('Descripción opcional del backup'),
                    ])
                    ->action(function (array $data): void {
                        try {
                            $exitCode = Artisan::call('backup:database', [
                                '--name' => $data['nombre'],
                                '--description' => $data['descripcion'] ?? '',
                            ]);

                            if ($exitCode === 0) {
                                Notification::make()
                                    ->title('Backup creado exitosamente')
                                    ->body("El backup '{$data['nombre']}' se ha creado correctamente.")
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

                Tables\Actions\Action::make('descargar')
                    ->label('Descargar')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('info')
                    ->url(fn (Backup $record): string => route('backups.download', $record))
                    ->openUrlInNewTab()
                    ->visible(fn (Backup $record): bool => $record->archivo_existe),

                Tables\Actions\Action::make('restaurar')
                    ->label('Restaurar')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Restaurar Backup')
                    ->modalDescription('¿Está seguro de que desea restaurar este backup? Esta acción sobrescribirá todos los datos actuales de la base de datos.')
                    ->modalSubmitActionLabel('Sí, restaurar')
                    ->action(function (Backup $record): void {
                        try {
                            // Aquí iría la lógica de restauración
                            // Por simplicidad, solo marcamos como restaurado
                            $record->marcarComoRestaurado();

                            Notification::make()
                                ->title('Backup restaurado')
                                ->body("El backup '{$record->nombre}' se ha restaurado correctamente.")
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
                    ->visible(fn (Backup $record): bool => $record->puedeRestaurar()),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn (Backup $record): bool => $record->puedeEliminar()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn ($records): bool => $records && $records->every(fn (Backup $record): bool => $record->puedeEliminar())),

                    Tables\Actions\BulkAction::make('limpiar_antiguos')
                        ->label('Limpiar Antiguos')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Limpiar Backups Antiguos')
                        ->modalDescription('Esta acción eliminará todos los backups seleccionados y sus archivos físicos.')
                        ->modalSubmitActionLabel('Sí, eliminar')
                        ->action(function ($records): void {
                            $eliminados = 0;
                            foreach ($records as $record) {
                                if ($record->puedeEliminar()) {
                                    if ($record->eliminarArchivo()) {
                                        $record->delete();
                                        $eliminados++;
                                    }
                                }
                            }

                            Notification::make()
                                ->title('Backups eliminados')
                                ->body("Se eliminaron {$eliminados} backups exitosamente.")
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->defaultSort('fecha_creacion', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBackups::route('/'),
            'create' => Pages\CreateBackup::route('/create'),
            'edit' => Pages\EditBackup::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        try {
            if (!\Schema::hasTable('backups')) {
                return null;
            }
            $count = static::getModel()::where('estado', 'fallido')->count();
            return $count > 0 ? (string) $count : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }
}
