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
                            ->relationship('beneficiario', 'codigo')
                            ->getOptionLabelFromRecordUsing(fn (Beneficiario $record): string => 
                                "{$record->codigo} - {$record->nombres} {$record->apellidos}"
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('codigo')
                                    ->label('Código')
                                    ->required()
                                    ->unique()
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
                    ->icon('heroicon-o-plus'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Editar'),
                Tables\Actions\DeleteAction::make()
                    ->label('Eliminar')
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('beneficiario.codigo')
            ->emptyStateHeading('No hay beneficiarios agregados')
            ->emptyStateDescription('Agrega beneficiarios a esta entrega para comenzar.')
            ->emptyStateIcon('heroicon-o-users')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Agregar Beneficiario')
                    ->icon('heroicon-o-plus'),
            ]);
    }
}
