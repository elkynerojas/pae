<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EntregaResource\Pages;
use App\Filament\Resources\EntregaResource\RelationManagers;
use App\Models\Entrega;
use App\Exports\EntregaPdfExport;
use App\Exports\EntregaExcelExport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class EntregaResource extends Resource
{
    protected static ?string $model = Entrega::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    
    protected static ?string $navigationLabel = 'Entregas';
    
    protected static ?string $modelLabel = 'Entrega';
    
    protected static ?string $pluralModelLabel = 'Entregas';
    
    protected static ?string $navigationGroup = 'Operaciones';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información de la Entrega')
                    ->schema([
                        Forms\Components\DatePicker::make('fecha')
                            ->label('Fecha de Entrega')
                            ->required()
                            ->default(now())
                            ->displayFormat('d/m/Y'),
                        Forms\Components\Select::make('racion_id')
                            ->label('Ración')
                            ->relationship('racion', 'nombre')
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('nombre')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('descripcion')
                                    ->rows(3),
                            ]),
                        Forms\Components\Textarea::make('observaciones')
                            ->label('Observaciones')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('estado')
                            ->label('Estado')
                            ->disabled()
                            ->formatStateUsing(fn (?string $state): string => match ($state) {
                                'abierta' => 'Abierta',
                                'cerrada' => 'Cerrada',
                                default => 'Abierta',
                            })
                            ->visible(fn (?Entrega $record): bool => $record !== null),
                        Forms\Components\DateTimePicker::make('fecha_cierre')
                            ->label('Fecha de Cierre')
                            ->disabled()
                            ->visible(fn (?Entrega $record): bool => $record?->estaCerrada() ?? false),
                        Forms\Components\TextInput::make('usuarioCierre.name')
                            ->label('Cerrado por')
                            ->disabled()
                            ->visible(fn (?Entrega $record): bool => $record?->estaCerrada() ?? false),
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
                Tables\Columns\TextColumn::make('racion.nombre')
                    ->label('Ración')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('beneficiarios_count')
                    ->label('Beneficiarios')
                    ->counts('beneficiarios')
                    ->sortable(),
                Tables\Columns\TextColumn::make('estado')
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
                            ->label('Fecha Desde'),
                        Forms\Components\DatePicker::make('fecha_hasta')
                            ->label('Fecha Hasta'),
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
                Tables\Filters\SelectFilter::make('racion_id')
                    ->label('Ración')
                    ->relationship('racion', 'nombre'),
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
                    ->visible(fn (Entrega $record): bool => $record->estaAbierta()),
                Tables\Actions\Action::make('exportar_pdf')
                    ->label('PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('danger')
                    ->action(function (Entrega $record) {
                        $pdf = Pdf::loadView('exports.entrega-pdf', [
                            'entrega' => $record,
                            'beneficiarios' => $record->beneficiariosPorEntrega()->with('beneficiario')->get(),
                            'productosRacion' => $record->racion->productosPorRacion()->with('producto.presentacionProducto')->get(),
                        ]);
                        
                        $filename = 'entrega_' . $record->fecha->format('Y-m-d') . '_' . $record->id . '.pdf';
                        
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
                    ->action(function (Entrega $record) {
                        $filename = 'entrega_' . $record->fecha->format('Y-m-d') . '_' . $record->id . '.xlsx';
                        
                        return Excel::download(new EntregaExcelExport($record), $filename);
                    }),
                Tables\Actions\Action::make('cerrar')
                    ->label('Cerrar')
                    ->icon('heroicon-o-lock-closed')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Cerrar Entrega')
                    ->modalDescription('¿Está seguro de que desea cerrar esta entrega? Una vez cerrada, no se podrán realizar modificaciones ni reabrir.')
                    ->action(fn (Entrega $record) => $record->cerrar())
                    ->visible(fn (Entrega $record): bool => $record->estaAbierta()),
                Tables\Actions\Action::make('abrir')
                    ->label('Reabrir')
                    ->icon('heroicon-o-lock-open')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Reabrir Entrega')
                    ->modalDescription('¿Está seguro de que desea reabrir esta entrega? Solo administradores pueden realizar esta acción.')
                    ->action(fn (Entrega $record) => $record->abrir())
                    ->visible(fn (Entrega $record): bool => $record->estaCerrada()),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->visible(fn (Entrega $record): bool => $record->estaAbierta()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('exportar_pdf_masivo')
                        ->label('Exportar PDF')
                        ->icon('heroicon-o-document-arrow-down')
                        ->color('danger')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $pdf = Pdf::loadView('exports.entrega-pdf', [
                                    'entrega' => $record,
                                    'beneficiarios' => $record->beneficiariosPorEntrega()->with('beneficiario')->get(),
                                    'productosRacion' => $record->racion->productosPorRacion()->with('producto.presentacionProducto')->get(),
                                ]);
                                
                                $filename = 'entrega_' . $record->fecha->format('Y-m-d') . '_' . $record->id . '.pdf';
                                
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
                            // Crear un archivo Excel con múltiples hojas
                            $export = new \App\Exports\EntregasMasivoExcelExport($records);
                            $filename = 'entregas_' . now()->format('Y-m-d') . '.xlsx';
                            
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
            RelationManagers\BeneficiariosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEntregas::route('/'),
            'create' => Pages\CreateEntrega::route('/create'),
            'view' => Pages\ViewEntrega::route('/{record}'),
            'edit' => Pages\EditEntrega::route('/{record}/edit'),
        ];
    }
}
