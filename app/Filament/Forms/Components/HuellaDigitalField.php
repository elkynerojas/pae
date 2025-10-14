<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\Concerns\HasState;

class HuellaDigitalField extends Field
{
    use HasState;

    protected string $view = 'filament.forms.components.huella-digital-field';

    public static function make(string $name): static
    {
        $static = app(static::class, ['name' => $name]);
        $static->configure();

        return $static;
    }

    public function getViewData(): array
    {
        return [
            'state' => $this->getState(),
            'statePath' => $this->getStatePath(),
            'isRequired' => $this->isRequired,
            'isDisabled' => $this->isDisabled,
        ];
    }
}
