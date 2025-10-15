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
                                'masculino' => 'Masculino',
                                'femenino' => 'Femenino',
                            ])
                            ->required()
                            ->default('masculino')
                            ->rules(['required', 'in:masculino,femenino']),
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
                
                Forms\Components\Section::make('Huella Digital')
                    ->schema([
                        Forms\Components\Placeholder::make('instrucciones_huella')
                            ->label('Instrucciones')
                            ->content('Haga clic en "Capturar Huella" y coloque el dedo en el lector cuando se le indique.')
                            ->columnSpanFull(),
                        
                        Forms\Components\Textarea::make('huella_template')
                            ->label('Plantilla de Huella')
                            ->rows(4)
                            ->columnSpanFull()
                            ->disabled()
                            ->dehydrated()
                            ->helperText('La plantilla de huella se llenará automáticamente después de la captura'),
                        
                        Forms\Components\Placeholder::make('boton_huella')
                            ->content(new \Illuminate\Support\HtmlString('
                                <div class="flex justify-center">
                                    <button type="button" onclick="capturarHuellaDactilar()" class="px-6 py-3 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 font-medium">
                                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                        Capturar Huella
                                    </button>
                                </div>
                            '))
                            ->columnSpanFull()
                            ->hiddenLabel(),
                        
                        Forms\Components\Placeholder::make('status_huella')
                            ->label('Estado')
                            ->content(new \Illuminate\Support\HtmlString('<div id="statusHuella" class="p-3 rounded-md bg-gray-100 text-gray-600">Listo para capturar huella</div>'))
                            ->columnSpanFull(),
                        
                        Forms\Components\Placeholder::make('script_huella')
                            ->content(view('filament.components.huella-script'))
                            ->columnSpanFull()
                            ->hiddenLabel(),
                    ])
                    ->collapsible(),
                   
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
                        'masculino' => 'Masculino',
                        'femenino' => 'Femenino',
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
                            'beneficiarios',
                            $record->id,
                            $record->datos_anteriores ?? $record->toArray(),
                            "Beneficiario eliminado: '{$record->nombre} {$record->apellido}'"
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
