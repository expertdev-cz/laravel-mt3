<?php

namespace App\Filament\Modules\PageTypes;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Fieldset;

class AuthorizedAccessRegisterPageType
{
    public static function getDefinition(string $arrayToSaveName = 'content'): array
    {
        return [
            Fieldset::make('Hero sekce')
                ->schema([
                    TextInput::make($arrayToSaveName . '.title')->label('Nadpis'),
                    Textarea::make($arrayToSaveName . '.subtitle')->label('Podnadpis')->rows(2),
                ])
                ->columns(1),
            Fieldset::make('Doplňkový obsah pod formulářem')
                ->schema([
                    TextInput::make($arrayToSaveName . '.support_title')->label('Spodní větší text'),
                    Textarea::make($arrayToSaveName . '.support_text')->label('Spodní menší text')->rows(3),
                ])
                ->columns(1),
        ];
    }
}