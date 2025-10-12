<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TipoProductoResource\Pages;
use App\Models\TipoProducto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TipoProductoResource extends Resource
{
    protected static ?string $model = TipoProducto::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    
    protected static ?string $navigationLabel = 'Tipos de Productos';
    
    protected static ?string $modelLabel = 'Tipo de Producto';
    
    protected static ?string $pluralModelLabel = 'Tipos de Productos';
    
    protected static ?string $navigationGroup = 'Inventario';
    
    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del Tipo de Producto')
                    ->schema([
                        Forms\Components\TextInput::make('nombre')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\Textarea::make('descripcion')
                            ->label('Descripción')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('activo')
                            ->label('Tipo Activo')
                            ->default(true),
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
                    ->sortable(),
                Tables\Columns\TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }
                        return $state;
                    }),
                Tables\Columns\IconColumn::make('activo')
                    ->label('Estado')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\TextColumn::make('productos_count')
                    ->label('Productos')
                    ->counts('productos')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('activo')
                    ->label('Estado')
                    ->placeholder('Todos los tipos')
                    ->trueLabel('Solo activos')
                    ->falseLabel('Solo inactivos'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->visible(fn ($record) => !$record->hasDependencies())
                    ->before(function ($record) {
                        // Guardar datos antes de eliminar para el log
                        $datosAnteriores = $record->toArray();
                        $record->datos_anteriores = $datosAnteriores;
                    })
                    ->after(function ($record) {
                        // Registrar en log
                        \App\Services\LogSistemaService::eliminar(
                            'tipos_productos',
                            $record->id,
                            $record->datos_anteriores ?? $record->toArray(),
                            "Tipo de producto eliminado: '{$record->nombre}'"
                        );
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->visible(fn ($records) => $records && $records->filter(fn ($record) => !$record->hasDependencies())->count() > 0),
                ]),
            ])
            ->defaultSort('nombre');
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
            'index' => Pages\ListTipoProductos::route('/'),
            'create' => Pages\CreateTipoProducto::route('/create'),
            'view' => Pages\ViewTipoProducto::route('/{record}'),
            'edit' => Pages\EditTipoProducto::route('/{record}/edit'),
        ];
    }
}
