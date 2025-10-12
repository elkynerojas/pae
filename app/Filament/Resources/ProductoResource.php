<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductoResource\Pages;
use App\Filament\Resources\ProductoResource\RelationManagers;
use App\Models\Producto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductoResource extends Resource
{
    protected static ?string $model = Producto::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    
    protected static ?string $navigationLabel = 'Productos';
    
    protected static ?string $modelLabel = 'Producto';
    
    protected static ?string $pluralModelLabel = 'Productos';
    
    protected static ?string $navigationGroup = 'Inventario';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del Producto')
                    ->schema([
                        Forms\Components\TextInput::make('nombre')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('descripcion')
                            ->label('Descripción')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('tipo_producto_id')
                            ->label('Tipo de Producto')
                            ->relationship('tipoProducto', 'nombre')
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('nombre')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        Forms\Components\Select::make('presentacion_producto_id')
                            ->label('Presentación')
                            ->relationship('presentacionProducto', 'nombre')
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('nombre')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        Forms\Components\Toggle::make('activo')
                            ->label('Producto Activo')
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
                Tables\Columns\TextColumn::make('tipoProducto.nombre')
                    ->label('Tipo')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('presentacionProducto.nombre')
                    ->label('Presentación')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('activo')
                    ->label('Estado')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tipo_producto_id')
                    ->label('Tipo de Producto')
                    ->relationship('tipoProducto', 'nombre'),
                Tables\Filters\SelectFilter::make('presentacion_producto_id')
                    ->label('Presentación')
                    ->relationship('presentacionProducto', 'nombre'),
                Tables\Filters\TernaryFilter::make('activo')
                    ->label('Estado')
                    ->placeholder('Todos los productos')
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
                            'productos',
                            $record->id,
                            $record->datos_anteriores ?? $record->toArray(),
                            "Producto eliminado: '{$record->nombre}'"
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
            'index' => Pages\ListProductos::route('/'),
            'create' => Pages\CreateProducto::route('/create'),
            'edit' => Pages\EditProducto::route('/{record}/edit'),
        ];
    }
}
