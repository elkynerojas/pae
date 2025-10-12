<?php

namespace App\Filament\Resources\EntregaResource\RelationManagers;

use App\Models\Beneficiario;
use App\Models\BeneficiarioPorEntrega;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BeneficiariosRelationManager extends RelationManager
{
    protected static string $relationship = 'beneficiariosPorEntrega';

    protected static ?string $title = 'Beneficiarios';

    protected static ?string $modelLabel = 'Beneficiario';

    protected static ?string $pluralModelLabel = 'Beneficiarios';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del Beneficiario')
                    ->schema([
                        Forms\Components\Select::make('beneficiario_id')
                            ->label('Beneficiario')
                            ->relationship(
                                name: 'beneficiario',
                                titleAttribute: 'codigo',
                                modifyQueryUsing: function (Builder $query) {
                                    // Obtener IDs de beneficiarios ya registrados en esta entrega
                                    $beneficiariosRegistrados = $this->getOwnerRecord()
                                        ->beneficiariosPorEntrega()
                                        ->pluck('beneficiario_id')
                                        ->toArray();
                                    
                                    // Excluir beneficiarios ya registrados
                                    if (!empty($beneficiariosRegistrados)) {
                                        $query->whereNotIn('id', $beneficiariosRegistrados);
                                    }
                                    
                                    // Solo mostrar beneficiarios activos
                                    $query->where('activo', true);
                                }
                            )
                            ->getOptionLabelFromRecordUsing(fn (Beneficiario $record): string => 
                                "{$record->codigo} - {$record->nombres} {$record->apellidos}"
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->validationMessages([
                                'required' => 'Debe seleccionar un beneficiario.',
                            ])
                            ->rules([
                                'required',
                                'exists:beneficiarios,id',
                            ])
                            ->live()
                            ->afterStateUpdated(function ($state, $set, $get) {
                                if ($state) {
                                    $entrega = $this->getOwnerRecord();
                                    $yaRegistrado = $entrega->beneficiariosPorEntrega()
                                        ->where('beneficiario_id', $state)
                                        ->exists();
                                    
                                    if ($yaRegistrado) {
                                        $set('beneficiario_id', null);
                                        \Filament\Notifications\Notification::make()
                                            ->title('Beneficiario ya registrado')
                                            ->body('Este beneficiario ya está registrado en esta entrega.')
                                            ->danger()
                                            ->send();
                                    }
                                }
                            })
                            ->createOptionForm([
                                Forms\Components\TextInput::make('codigo')
                                    ->label('Código')
                                    ->required()
                                    ->unique('beneficiarios', 'codigo')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('nombres')
                                    ->label('Nombres')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('apellidos')
                                    ->label('Apellidos')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\DatePicker::make('fecha_nacimiento')
                                    ->label('Fecha de Nacimiento')
                                    ->required()
                                    ->displayFormat('d/m/Y'),
                                Forms\Components\Select::make('genero')
                                    ->label('Género')
                                    ->options([
                                        'masculino' => 'Masculino',
                                        'femenino' => 'Femenino',
                                    ])
                                    ->required(),
                                Forms\Components\Select::make('grado')
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
                                    ])
                                    ->required(),
                                Forms\Components\TextInput::make('grupo')
                                    ->label('Grupo')
                                    ->numeric()
                                    ->minValue(1)
                                    ->maxValue(20),
                                Forms\Components\Textarea::make('observaciones')
                                    ->label('Observaciones')
                                    ->rows(3),
                            ]),
                        Forms\Components\TextInput::make('cantidad_raciones')
                            ->label('Cantidad de Raciones')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->maxValue(10)
                            ->required(),
                        Forms\Components\Textarea::make('observaciones')
                            ->label('Observaciones')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('beneficiario.codigo')
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
                        return Beneficiario::distinct()
                            ->pluck('grupo')
                            ->filter()
                            ->sort()
                            ->mapWithKeys(fn ($grupo) => [$grupo => "Grupo {$grupo}"]);
                    }),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Agregar Beneficiario')
                    ->icon('heroicon-o-plus')
                    ->visible(fn (): bool => $this->getOwnerRecord()->estaAbierta())
                    ->before(function () {
                        // Verificar que la entrega esté abierta antes de crear
                        $entrega = $this->getOwnerRecord();
                        if ($entrega->estaCerrada()) {
                            \Filament\Notifications\Notification::make()
                                ->title('Error')
                                ->body('No se pueden agregar beneficiarios a una entrega cerrada.')
                                ->danger()
                                ->send();
                            
                            throw new \Filament\Notifications\NotificationException('Entrega cerrada');
                        }
                    })
                    ->mutateFormDataUsing(function (array $data): array {
                        // Verificar duplicados antes de crear
                        $entrega = $this->getOwnerRecord();
                        $yaRegistrado = $entrega->beneficiariosPorEntrega()
                            ->where('beneficiario_id', $data['beneficiario_id'])
                            ->exists();
                        
                        if ($yaRegistrado) {
                            \Filament\Notifications\Notification::make()
                                ->title('Error')
                                ->body('Este beneficiario ya está registrado en esta entrega.')
                                ->danger()
                                ->send();
                            
                            throw new \Filament\Notifications\NotificationException('Beneficiario duplicado');
                        }
                        
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Editar')
                    ->visible(fn (): bool => $this->getOwnerRecord()->estaAbierta()),
                Tables\Actions\DeleteAction::make()
                    ->label('Eliminar')
                    ->requiresConfirmation()
                    ->visible(fn (): bool => $this->getOwnerRecord()->estaAbierta()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->visible(fn (): bool => $this->getOwnerRecord()->estaAbierta()),
                ]),
            ])
            ->defaultSort('beneficiario.codigo')
            ->emptyStateHeading('No hay beneficiarios agregados')
            ->emptyStateDescription(function () {
                $entrega = $this->getOwnerRecord();
                $beneficiariosDisponibles = Beneficiario::activos()
                    ->whereNotIn('id', $entrega->beneficiariosPorEntrega()->pluck('beneficiario_id'))
                    ->count();
                
                if ($beneficiariosDisponibles === 0) {
                    return 'Todos los beneficiarios activos ya están registrados en esta entrega.';
                }
                
                return "Agrega beneficiarios a esta entrega para comenzar. Hay {$beneficiariosDisponibles} beneficiarios disponibles.";
            })
            ->emptyStateIcon('heroicon-o-users')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Agregar Beneficiario')
                    ->icon('heroicon-o-plus')
                    ->visible(fn (): bool => $this->getOwnerRecord()->estaAbierta())
                    ->before(function () {
                        // Verificar que la entrega esté abierta antes de crear
                        $entrega = $this->getOwnerRecord();
                        if ($entrega->estaCerrada()) {
                            \Filament\Notifications\Notification::make()
                                ->title('Error')
                                ->body('No se pueden agregar beneficiarios a una entrega cerrada.')
                                ->danger()
                                ->send();
                            
                            throw new \Filament\Notifications\NotificationException('Entrega cerrada');
                        }
                    }),
            ]);
    }
}
