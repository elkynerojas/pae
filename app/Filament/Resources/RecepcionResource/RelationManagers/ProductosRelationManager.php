<?php

namespace App\Filament\Resources\RecepcionResource\RelationManagers;

use App\Models\Producto;
use App\Models\ProductoPorRecepcion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductosRelationManager extends RelationManager
{
    protected static string $relationship = 'productosPorRecepcion';

    protected static ?string $title = 'Productos Recibidos';

    protected static ?string $modelLabel = 'Producto';

    protected static ?string $pluralModelLabel = 'Productos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('producto_id')
                    ->label('Producto')
                    ->options(Producto::activos()->pluck('nombre', 'id'))
                    ->required()
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $producto = Producto::find($state);
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
                Forms\Components\TextInput::make('cantidad')
                    ->label('Cantidad')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->default(1),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('producto.nombre')
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
                Tables\Columns\TextColumn::make('cantidad')
                    ->label('Cantidad')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Agregado')
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
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        // Limpiar datos no necesarios antes de guardar
                        unset($data['producto_nombre'], $data['producto_tipo'], $data['producto_presentacion']);
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data, $record): array {
                        // Agregar información del producto para mostrar en el formulario
                        $producto = $record->producto;
                        $data['producto_nombre'] = $producto->nombre;
                        $data['producto_tipo'] = $producto->tipoProducto->nombre ?? '';
                        $data['producto_presentacion'] = $producto->presentacionProducto->nombre ?? '';
                        return $data;
                    })
                    ->mutateRecordDataUsing(function (array $data): array {
                        // Limpiar datos no necesarios antes de guardar
                        unset($data['producto_nombre'], $data['producto_tipo'], $data['producto_presentacion']);
                        return $data;
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('producto.nombre');
    }
}
