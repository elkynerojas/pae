<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventarioResource\Pages;
use App\Filament\Resources\InventarioResource\RelationManagers;
use App\Models\Inventario;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InventarioResource extends Resource
{
    protected static ?string $model = Inventario::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    
    protected static ?string $navigationLabel = 'Inventario';
    
    protected static ?string $modelLabel = 'Inventario';
    
    protected static ?string $pluralModelLabel = 'Inventario';
    
    protected static ?string $navigationGroup = 'Inventario';
    
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del Inventario')
                    ->schema([
                        Forms\Components\Select::make('producto_id')
                            ->label('Producto')
                            ->relationship('producto', 'nombre')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $producto = \App\Models\Producto::find($state);
                                    if ($producto) {
                                        $set('producto_nombre', $producto->nombre);
                                        $set('producto_tipo', $producto->tipoProducto->nombre ?? '');
                                        $set('producto_presentacion', $producto->presentacionProducto->nombre ?? '');
                                    }
                                }
                            }),
                        Forms\Components\TextInput::make('producto_nombre')
                            ->label('Nombre del Producto')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('producto_tipo')
                            ->label('Tipo')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('producto_presentacion')
                            ->label('Presentación')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('cantidad_stock')
                            ->label('Cantidad en Stock')
                            ->numeric()
                            ->required()
                            ->minValue(0),
                        Forms\Components\TextInput::make('cantidad_minima')
                            ->label('Cantidad Mínima')
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                        Forms\Components\TextInput::make('precio_unitario')
                            ->label('Precio Unitario')
                            ->numeric()
                            ->step(0.01)
                            ->minValue(0),
                        Forms\Components\Textarea::make('observaciones')
                            ->label('Observaciones')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('activo')
                            ->label('Activo')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('producto.nombre')
                    ->label('Producto')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('producto.tipoProducto.nombre')
                    ->label('Tipo')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('producto.presentacionProducto.nombre')
                    ->label('Presentación')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cantidad_stock')
                    ->label('Cantidad en Stock')
                    ->numeric()
                    ->sortable()
                    ->alignCenter()
                    ->color(function ($record) {
                        if ($record->cantidad_stock <= $record->cantidad_minima) {
                            return 'danger';
                        }
                        return 'success';
                    })
                    ->badge(function ($record) {
                        if ($record->cantidad_stock <= $record->cantidad_minima) {
                            return 'Stock Bajo';
                        }
                        return null;
                    }),
                Tables\Columns\TextColumn::make('cantidad_minima')
                    ->label('Cantidad Mínima')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('precio_unitario')
                    ->label('Precio Unitario')
                    ->money('USD')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Filters\SelectFilter::make('producto.tipo_producto_id')
                    ->label('Tipo de Producto')
                    ->relationship('producto.tipoProducto', 'nombre')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('producto.presentacion_producto_id')
                    ->label('Presentación')
                    ->relationship('producto.presentacionProducto', 'nombre')
                    ->searchable()
                    ->preload(),
                Tables\Filters\TernaryFilter::make('activo')
                    ->label('Estado')
                    ->placeholder('Todos los registros')
                    ->trueLabel('Solo activos')
                    ->falseLabel('Solo inactivos'),
                Tables\Filters\Filter::make('stock_bajo')
                    ->label('Stock Bajo')
                    ->query(fn (Builder $query): Builder => $query->whereColumn('cantidad_stock', '<=', 'cantidad_minima')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('producto.nombre');
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
            'index' => Pages\ListInventarios::route('/'),
            'create' => Pages\CreateInventario::route('/create'),
            'view' => Pages\ViewInventario::route('/{record}'),
            'edit' => Pages\EditInventario::route('/{record}/edit'),
        ];
    }
}
