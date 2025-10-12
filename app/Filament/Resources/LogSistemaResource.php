<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LogSistemaResource\Pages;
use App\Models\LogSistema;
use App\Services\LogSistemaService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LogSistemaResource extends Resource
{
    protected static ?string $model = LogSistema::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'Logs del Sistema';

    protected static ?string $modelLabel = 'Log del Sistema';

    protected static ?string $pluralModelLabel = 'Logs del Sistema';

    protected static ?string $navigationGroup = 'Sistema';

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del Log')
                    ->schema([
                        Forms\Components\TextInput::make('accion')
                            ->label('Acción')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('tabla')
                            ->label('Tabla')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('registro_id')
                            ->label('ID del Registro')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\Textarea::make('descripcion')
                            ->label('Descripción')
                            ->disabled()
                            ->dehydrated(false)
                            ->rows(3),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Datos del Cambio')
                    ->schema([
                        Forms\Components\KeyValue::make('datos_anteriores')
                            ->label('Datos Anteriores')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\KeyValue::make('datos_nuevos')
                            ->label('Datos Nuevos')
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Información del Usuario')
                    ->schema([
                        Forms\Components\TextInput::make('usuario.name')
                            ->label('Usuario')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('ip_address')
                            ->label('Dirección IP')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\Textarea::make('user_agent')
                            ->label('User Agent')
                            ->disabled()
                            ->dehydrated(false)
                            ->rows(2),
                        Forms\Components\DateTimePicker::make('created_at')
                            ->label('Fecha y Hora')
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha/Hora')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('accion')
                    ->label('Acción')
                    ->formatStateUsing(fn (string $state): string => LogSistema::make(['accion' => $state])->accion_formateada)
                    ->color(fn (string $state): string => LogSistema::make(['accion' => $state])->color_accion)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }
                        return $state;
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('tabla')
                    ->label('Tabla')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('registro_id')
                    ->label('ID Registro')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('usuario.name')
                    ->label('Usuario')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('user_agent')
                    ->label('User Agent')
                    ->limit(30)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }
                        return $state;
                    })
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('accion')
                    ->label('Acción')
                    ->options([
                        'CREATE' => 'Crear',
                        'UPDATE' => 'Actualizar',
                        'DELETE' => 'Eliminar',
                        'LOGIN' => 'Iniciar Sesión',
                        'LOGOUT' => 'Cerrar Sesión',
                        'EXPORT' => 'Exportar',
                        'IMPORT' => 'Importar',
                        'CLOSE_DELIVERY' => 'Cerrar Entrega',
                        'OPEN_DELIVERY' => 'Abrir Entrega',
                        'CLOSE_RECEPTION' => 'Cerrar Recepción',
                        'OPEN_RECEPTION' => 'Abrir Recepción',
                    ])
                    ->multiple(),
                Tables\Filters\SelectFilter::make('tabla')
                    ->label('Tabla')
                    ->options(function () {
                        return LogSistema::distinct()
                            ->whereNotNull('tabla')
                            ->pluck('tabla', 'tabla')
                            ->toArray();
                    })
                    ->multiple(),
                Tables\Filters\SelectFilter::make('usuario_id')
                    ->label('Usuario')
                    ->relationship('usuario', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\Filter::make('fecha')
                    ->form([
                        Forms\Components\DatePicker::make('fecha_desde')
                            ->label('Fecha Desde'),
                        Forms\Components\DatePicker::make('fecha_hasta')
                            ->label('Fecha Hasta'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['fecha_desde'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['fecha_hasta'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('limpiar_logs_antiguos')
                        ->label('Limpiar Logs Antiguos')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->form([
                            Forms\Components\Select::make('dias')
                                ->label('Eliminar logs anteriores a (días)')
                                ->options([
                                    30 => '30 días',
                                    60 => '60 días',
                                    90 => '90 días',
                                    180 => '180 días',
                                    365 => '1 año',
                                ])
                                ->default(90)
                                ->required(),
                        ])
                        ->action(function (array $data) {
                            $fechaLimite = now()->subDays($data['dias']);
                            $eliminados = LogSistema::where('created_at', '<', $fechaLimite)->count();
                            
                            LogSistema::where('created_at', '<', $fechaLimite)->delete();
                            
                            \Filament\Notifications\Notification::make()
                                ->title('Logs eliminados')
                                ->body("Se eliminaron {$eliminados} logs anteriores a {$data['dias']} días.")
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('30s'); // Actualizar cada 30 segundos
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
            'index' => Pages\ListLogsSistema::route('/'),
            'view' => Pages\ViewLogSistema::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false; // Los logs solo se crean automáticamente
    }

    public static function canEdit($record): bool
    {
        return false; // Los logs no se pueden editar
    }

    public static function canDelete($record): bool
    {
        return false; // Los logs no se pueden eliminar individualmente
    }
}
