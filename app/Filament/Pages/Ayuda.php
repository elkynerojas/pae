<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;

class Ayuda extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    
    protected static string $view = 'filament.pages.ayuda';
    
    protected static ?string $navigationGroup = 'Sistema';
    
    protected static ?int $navigationSort = 100;
    
    protected static ?string $title = 'Centro de Ayuda';
    
    protected static ?string $navigationLabel = 'Ayuda';

    public static function getNavigationBadge(): ?string
    {
        return null;
    }

    public function getActions(): array
    {
        return [
            Action::make('contactar_soporte')
                ->label('Contactar Soporte')
                ->icon('heroicon-o-envelope')
                ->color('success')
                ->form([
                    TextInput::make('asunto')
                        ->label('Asunto')
                        ->required()
                        ->maxLength(255),
                    Textarea::make('mensaje')
                        ->label('Mensaje')
                        ->required()
                        ->rows(4)
                        ->columnSpanFull(),
                ])
                ->action(function (array $data): void {
                    // Aquí se podría implementar el envío de email o ticket
                    Notification::make()
                        ->title('Mensaje enviado')
                        ->body('Tu consulta ha sido enviada al equipo de soporte. Te contactaremos pronto.')
                        ->success()
                        ->send();
                }),
        ];
    }
}
