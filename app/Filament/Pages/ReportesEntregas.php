<?php

namespace App\Filament\Pages;

use App\Models\Entrega;
use App\Models\Beneficiario;
use App\Models\Racion;
use App\Exports\ReporteEntregasExcelExport;
use App\Exports\ReporteEntregasPdfExport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportesEntregas extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    
    protected static ?string $navigationLabel = 'Reportes de Entregas';
    
    protected static ?string $title = 'Reportes de Entregas';
    
    protected static ?string $navigationGroup = 'Operaciones';
    
    protected static ?int $navigationSort = 2;

    protected static string $view = 'filament.pages.reportes-entregas';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Filtros de Reporte')
                    ->description('Selecciona los criterios para generar el reporte de entregas')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                DatePicker::make('fecha_inicio')
                                    ->label('Fecha Inicio')
                                    ->displayFormat('d/m/Y')
                                    ->native(false)
                                    ->placeholder('Selecciona fecha inicio'),
                                
                                DatePicker::make('fecha_fin')
                                    ->label('Fecha Fin')
                                    ->displayFormat('d/m/Y')
                                    ->native(false)
                                    ->placeholder('Selecciona fecha fin')
                                    ->after('fecha_inicio'),
                                
                                Select::make('estado')
                                    ->label('Estado de Entrega')
                                    ->options([
                                        'abierta' => 'Abierta',
                                        'cerrada' => 'Cerrada',
                                        'todas' => 'Todas'
                                    ])
                                    ->default('todas')
                                    ->placeholder('Selecciona estado'),
                            ]),
                        
                        Grid::make(2)
                            ->schema([
                                Select::make('racion_id')
                                    ->label('Ración')
                                    ->options(Racion::activos()->pluck('nombre', 'id'))
                                    ->searchable()
                                    ->placeholder('Selecciona ración (opcional)'),
                                
                                Select::make('beneficiario_id')
                                    ->label('Beneficiario')
                                    ->options(Beneficiario::activos()->get()->mapWithKeys(function ($beneficiario) {
                                        return [$beneficiario->id => $beneficiario->codigo . ' - ' . $beneficiario->nombre_completo];
                                    }))
                                    ->searchable()
                                    ->placeholder('Selecciona beneficiario (opcional)'),
                            ]),
                        
                        Grid::make(2)
                            ->schema([
                                TextInput::make('grado')
                                    ->label('Grado')
                                    ->placeholder('Ej: 1, 2, 3...')
                                    ->numeric(),
                                
                                TextInput::make('grupo')
                                    ->label('Grupo')
                                    ->placeholder('Ej: A, B, C...')
                                    ->maxLength(1),
                            ]),
                    ])
                    ->columns(1)
                    ->collapsible()
                    ->collapsed(false),
            ])
            ->statePath('data');
    }

    protected function getTableQuery(): Builder
    {
        $query = Entrega::query()
            ->with(['racion', 'beneficiarios', 'usuarioCierre']);

        // Aplicar filtros
        if (!empty($this->data['fecha_inicio'])) {
            $query->where('fecha', '>=', $this->data['fecha_inicio']);
        }

        if (!empty($this->data['fecha_fin'])) {
            $query->where('fecha', '<=', $this->data['fecha_fin']);
        }

        if (!empty($this->data['estado']) && $this->data['estado'] !== 'todas') {
            $query->where('estado', $this->data['estado']);
        }

        if (!empty($this->data['racion_id'])) {
            $query->where('racion_id', $this->data['racion_id']);
        }

        if (!empty($this->data['beneficiario_id'])) {
            $query->whereHas('beneficiarios', function ($q) {
                $q->where('beneficiario_id', $this->data['beneficiario_id']);
            });
        }

        if (!empty($this->data['grado'])) {
            $query->whereHas('beneficiarios', function ($q) {
                $q->where('grado', $this->data['grado']);
            });
        }

        if (!empty($this->data['grupo'])) {
            $query->whereHas('beneficiarios', function ($q) {
                $q->where('grupo', $this->data['grupo']);
            });
        }

        return $query->orderBy('fecha', 'desc');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns([
                Tables\Columns\TextColumn::make('fecha')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('racion.nombre')
                    ->label('Ración')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'abierta' => 'warning',
                        'cerrada' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'abierta' => 'Abierta',
                        'cerrada' => 'Cerrada',
                        default => $state,
                    }),
                
                Tables\Columns\TextColumn::make('beneficiarios_count')
                    ->label('Beneficiarios')
                    ->counts('beneficiarios')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('total_raciones')
                    ->label('Total Raciones')
                    ->getStateUsing(function (Entrega $record): int {
                        return $record->beneficiarios()->sum('beneficiarios_por_entrega.cantidad_raciones');
                    })
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('fecha_cierre')
                    ->label('Fecha Cierre')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('usuarioCierre.name')
                    ->label('Usuario Cierre')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('observaciones')
                    ->label('Observaciones')
                    ->limit(50)
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
                Tables\Filters\SelectFilter::make('estado')
                    ->options([
                        'abierta' => 'Abierta',
                        'cerrada' => 'Cerrada',
                    ]),
                
                Tables\Filters\SelectFilter::make('racion_id')
                    ->label('Ración')
                    ->relationship('racion', 'nombre'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn (Entrega $record): string => route('filament.admin.resources.entregas.view', $record)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('fecha', 'desc')
            ->paginated([10, 25, 50, 100]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('aplicar_filtros')
                ->label('Aplicar Filtros')
                ->icon('heroicon-o-funnel')
                ->color('primary')
                ->action('aplicarFiltros'),
            
            Action::make('exportar_excel')
                ->label('Exportar Excel')
                ->icon('heroicon-o-table-cells')
                ->color('success')
                ->action('exportarExcel')
                ->requiresConfirmation()
                ->modalHeading('Exportar a Excel')
                ->modalDescription('¿Estás seguro de que quieres exportar el reporte actual a Excel?')
                ->modalSubmitActionLabel('Exportar'),
            
            Action::make('exportar_pdf')
                ->label('Exportar PDF')
                ->icon('heroicon-o-document-text')
                ->color('danger')
                ->action('exportarPdf')
                ->requiresConfirmation()
                ->modalHeading('Exportar a PDF')
                ->modalDescription('¿Estás seguro de que quieres exportar el reporte actual a PDF?')
                ->modalSubmitActionLabel('Exportar'),
        ];
    }

    public function aplicarFiltros(): void
    {
        $this->resetTable();
    }

    public function exportarExcel()
    {
        $entregas = $this->getTableQuery()->get();
        
        $export = new ReporteEntregasExcelExport($entregas, $this->data);
        $filename = 'reporte_entregas_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        
        return Excel::download($export, $filename);
    }

    public function exportarPdf()
    {
        $entregas = $this->getTableQuery()->get();
        
        $pdf = Pdf::loadView('exports.reporte-entregas-pdf', [
            'entregas' => $entregas,
            'filtros' => $this->data,
            'fecha_generacion' => now(),
        ]);
        
        $filename = 'reporte_entregas_' . now()->format('Y-m-d_H-i-s') . '.pdf';
        
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $filename);
    }
}
