<?php

namespace App\Filament\Modules\PageTypes;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Fieldset;

class AuthorizedAccessTechnicalSheetsPageType
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
            Fieldset::make('Obsah stránky')
                ->schema([
                    RichEditor::make($arrayToSaveName . '.intro')->label('Úvodní text'),
                    TextInput::make($arrayToSaveName . '.empty_title')->label('Nadpis prázdného stavu'),
                    Textarea::make($arrayToSaveName . '.empty_text')->label('Text prázdného stavu')->rows(3),
                ])
                ->columns(1),
        ];
    }
}