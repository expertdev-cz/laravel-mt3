<?php

namespace App\Filament\Modules\PageTypes;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;

class ContactPageType
{
    public static function getDefinition(string $arrayToSaveName = 'content'): array
    {
        return [
            Fieldset::make('Placeholder')
                ->schema([
                    TextInput::make($arrayToSaveName . '.placeholder')
                        ->label('Nepoužitý text pro kontakt')
                        ->default('Kontaktujte nás'),
                ])
                ->columns(1),
        ];
    }
}
