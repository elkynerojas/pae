<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BeneficiarioResource\Pages;
use App\Filament\Resources\BeneficiarioResource\RelationManagers;
use App\Imports\BeneficiariosImportSimple;
use App\Models\Beneficiario;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Maatwebsite\Excel\Facades\Excel;

class BeneficiarioResource extends Resource
{
    protected static ?string $model = Beneficiario::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    
    protected static ?string $navigationLabel = 'Beneficiarios';
    
    protected static ?string $modelLabel = 'Beneficiario';
    
    protected static ?string $pluralModelLabel = 'Beneficiarios';
    
    protected static ?string $navigationGroup = 'Gestión';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información Personal')
                    ->schema([
                        Forms\Components\TextInput::make('codigo')
                            ->label('Código')
                            ->required()
                            ->unique(ignoreRecord: true)
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
                                'M' => 'Masculino',
                                'F' => 'Femenino',
                            ])
                            ->required(),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Información Académica')
                    ->schema([
                        Forms\Components\TextInput::make('grado')
                            ->label('Grado')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('grupo')
                            ->label('Grupo')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Configuración')
                    ->schema([
                        Forms\Components\Textarea::make('observaciones')
                            ->label('Observaciones')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('activo')
                            ->label('Beneficiario Activo')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('codigo')
                    ->label('Código')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nombres')
                    ->label('Nombres')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('apellidos')
                    ->label('Apellidos')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha_nacimiento')
                    ->label('Fecha de Nacimiento')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('genero')
                    ->label('Género')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'masculino' => 'Masculino',
                        'femenino' => 'Femenino',
                        'M' => 'Masculino',
                        'F' => 'Femenino',
                        default => ucfirst($state),
                    }),
                Tables\Columns\TextColumn::make('grado')
                    ->label('Grado')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('grupo')
                    ->label('Grupo')
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
                Tables\Filters\SelectFilter::make('grado')
                    ->label('Grado')
                    ->options(function () {
                        return Beneficiario::distinct()->pluck('grado', 'grado')->toArray();
                    }),
                Tables\Filters\SelectFilter::make('grupo')
                    ->label('Grupo')
                    ->options(function () {
                        return Beneficiario::distinct()->pluck('grupo', 'grupo')->toArray();
                    }),
                Tables\Filters\SelectFilter::make('genero')
                    ->label('Género')
                    ->options([
                        'M' => 'Masculino',
                        'F' => 'Femenino',
                    ]),
                Tables\Filters\TernaryFilter::make('activo')
                    ->label('Estado')
                    ->placeholder('Todos los beneficiarios')
                    ->trueLabel('Solo activos')
                    ->falseLabel('Solo inactivos'),
            ])
            ->headerActions([
                Tables\Actions\Action::make('import')
                    ->label('Importar Excel')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->color('success')
                    ->form([
                        Forms\Components\FileUpload::make('file')
                            ->label('Archivo Excel')
                            ->acceptedFileTypes(['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                            ->required()
                            ->helperText('Formatos soportados: .xls, .xlsx')
                            ->maxSize(10240) // 10MB
                            ->afterStateUpdated(function ($state, $set) {
                                if ($state) {
                                    try {
                                        Excel::import(new BeneficiariosImportSimple, $state);
                                        
                                        \Filament\Notifications\Notification::make()
                                            ->title('Importación exitosa')
                                            ->body('Los beneficiarios se han importado correctamente.')
                                            ->success()
                                            ->send();
                                    } catch (\Exception $e) {
                                        \Filament\Notifications\Notification::make()
                                            ->title('Error en la importación')
                                            ->body('Error: ' . $e->getMessage())
                                            ->danger()
                                            ->send();
                                    }
                                }
                            }),
                        Forms\Components\Section::make('Plantilla de ejemplo')
                            ->schema([
                                Forms\Components\Placeholder::make('template_info')
                                    ->content('Descarga la plantilla de ejemplo para ver el formato correcto del archivo Excel.'),
                                Forms\Components\Actions::make([
                                    Forms\Components\Actions\Action::make('download_template')
                                        ->label('Descargar plantilla Excel')
                                        ->icon('heroicon-o-arrow-down-tray')
                                        ->color('primary')
                                        ->action(function () {
                                            return response()->download(storage_path('app/plantilla_beneficiarios.xlsx'));
                                        }),
                                ]),
                            ])
                            ->collapsible(),
                    ])
                    ->action(function (array $data) {
                        // La importación se realiza automáticamente en afterStateUpdated
                        \Filament\Notifications\Notification::make()
                            ->title('Proceso completado')
                            ->body('La importación se procesó automáticamente al seleccionar el archivo.')
                            ->info()
                            ->send();
                    }),
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
            ->defaultSort('codigo');
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
            'index' => Pages\ListBeneficiarios::route('/'),
            'create' => Pages\CreateBeneficiario::route('/create'),
            'edit' => Pages\EditBeneficiario::route('/{record}/edit'),
        ];
    }
}
