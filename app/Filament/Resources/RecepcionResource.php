<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecepcionResource\Pages;
use App\Filament\Resources\RecepcionResource\RelationManagers\ProductosRelationManager;
use App\Models\Recepcion;
use App\Exports\RecepcionPdfExport;
use App\Exports\RecepcionExcelExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RecepcionResource extends Resource
{
    protected static ?string $model = Recepcion::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';
    
    protected static ?string $navigationLabel = 'Recepciones';
    
    protected static ?string $modelLabel = 'Recepción';
    
    protected static ?string $pluralModelLabel = 'Recepciones';
    
    protected static ?string $navigationGroup = 'Inventario';
    
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información de la Recepción')
                    ->schema([
                        Forms\Components\DatePicker::make('fecha')
                            ->label('Fecha')
                            ->required()
                            ->default(now())
                            ->displayFormat('d/m/Y')
                            ->disabled(fn (?Recepcion $record): bool => $record?->estaCerrada() ?? false),
                        Forms\Components\TimePicker::make('hora')
                            ->label('Hora')
                            ->required()
                            ->default(now())
                            ->displayFormat('H:i')
                            ->disabled(fn (?Recepcion $record): bool => $record?->estaCerrada() ?? false),
                        Forms\Components\Select::make('usuario_id')
                            ->label('Usuario Responsable')
                            ->relationship('usuario', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->disabled(fn (?Recepcion $record): bool => $record?->estaCerrada() ?? false),
                        Forms\Components\Textarea::make('observaciones')
                            ->label('Observaciones')
                            ->rows(3)
                            ->columnSpanFull()
                            ->disabled(fn (?Recepcion $record): bool => $record?->estaCerrada() ?? false),
                        Forms\Components\TextInput::make('estado')
                            ->label('Estado')
                            ->disabled()
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'abierta' => 'Abierta',
                                'cerrada' => 'Cerrada',
                            })
                            ->visible(fn (?Recepcion $record): bool => $record !== null),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('fecha')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('hora')
                    ->label('Hora')
                    ->time('H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('usuario.name')
                    ->label('Usuario')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('productos_count')
                    ->label('Productos')
                    ->counts('productos')
                    ->sortable(),
                Tables\Columns\TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'abierta' => 'success',
                        'cerrada' => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'abierta' => 'Abierta',
                        'cerrada' => 'Cerrada',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('observaciones')
                    ->label('Observaciones')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }
                        return $state;
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('fecha')
                    ->form([
                        Forms\Components\DatePicker::make('fecha_desde')
                            ->label('Fecha desde'),
                        Forms\Components\DatePicker::make('fecha_hasta')
                            ->label('Fecha hasta'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['fecha_desde'],
                                fn (Builder $query, $date): Builder => $query->whereDate('fecha', '>=', $date),
                            )
                            ->when(
                                $data['fecha_hasta'],
                                fn (Builder $query, $date): Builder => $query->whereDate('fecha', '<=', $date),
                            );
                    }),
                Tables\Filters\SelectFilter::make('usuario_id')
                    ->label('Usuario')
                    ->relationship('usuario', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('estado')
                    ->label('Estado')
                    ->options([
                        'abierta' => 'Abierta',
                        'cerrada' => 'Cerrada',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn (Recepcion $record): bool => $record->estaAbierta()),
                Tables\Actions\Action::make('exportar_pdf')
                    ->label('PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('danger')
                    ->action(function (Recepcion $record) {
                        $pdf = Pdf::loadView('exports.recepcion-pdf', [
                            'recepcion' => $record,
                            'productosRecepcion' => $record->productosPorRecepcion()->with('producto.presentacionProducto')->get(),
                        ]);
                        
                        $filename = 'recepcion_' . $record->fecha->format('Y-m-d') . '_' . $record->id . '.pdf';
                        
                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, $filename, [
                            'Content-Type' => 'application/pdf',
                        ]);
                    }),
                Tables\Actions\Action::make('exportar_excel')
                    ->label('Excel')
                    ->icon('heroicon-o-table-cells')
                    ->color('success')
                    ->action(function (Recepcion $record) {
                        $filename = 'recepcion_' . $record->fecha->format('Y-m-d') . '_' . $record->id . '.xlsx';
                        return Excel::download(new RecepcionExcelExport($record), $filename);
                    }),
                Tables\Actions\Action::make('cerrar')
                    ->label('Cerrar')
                    ->icon('heroicon-o-lock-closed')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Cerrar Recepción')
                    ->modalDescription('¿Está seguro de que desea cerrar esta recepción? Una vez cerrada, no se podrán realizar modificaciones ni reabrir.')
                    ->action(fn (Recepcion $record) => $record->cerrar())
                    ->visible(fn (Recepcion $record): bool => $record->estaAbierta()),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->visible(fn (Recepcion $record): bool => $record->estaAbierta()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('exportar_pdf_masivo')
                        ->label('Exportar PDF')
                        ->icon('heroicon-o-document-arrow-down')
                        ->color('danger')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $pdf = Pdf::loadView('exports.recepcion-pdf', [
                                    'recepcion' => $record,
                                    'productosRecepcion' => $record->productosPorRecepcion()->with('producto.presentacionProducto')->get(),
                                ]);
                                
                                $filename = 'recepcion_' . $record->fecha->format('Y-m-d') . '_' . $record->id . '.pdf';
                                
                                // Para múltiples archivos, podrías usar un ZIP
                                // Por ahora, descargamos el último
                                return response()->streamDownload(function () use ($pdf) {
                                    echo $pdf->output();
                                }, $filename, [
                                    'Content-Type' => 'application/pdf',
                                ]);
                            }
                        }),
                    Tables\Actions\BulkAction::make('exportar_excel_masivo')
                        ->label('Exportar Excel')
                        ->icon('heroicon-o-table-cells')
                        ->color('success')
                        ->action(function ($records) {
                            $export = new \App\Exports\RecepcionesMasivoExcelExport($records);
                            $filename = 'recepciones_' . now()->format('Y-m-d') . '.xlsx';
                            return Excel::download($export, $filename);
                        }),
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('fecha', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            ProductosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRecepciones::route('/'),
            'create' => Pages\CreateRecepcion::route('/create'),
            'view' => Pages\ViewRecepcion::route('/{record}'),
            'edit' => Pages\EditRecepcion::route('/{record}/edit'),
        ];
    }
}
