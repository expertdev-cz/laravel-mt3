<?php

namespace App\Filament\Modules\PageTypes;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Fieldset;

class AuthorizedAccessLoginPageType
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
            Fieldset::make('Doplňkový obsah')
                ->schema([
                    TextInput::make($arrayToSaveName . '.aside_title')->label('Nadpis vedle formuláře'),
                    RichEditor::make($arrayToSaveName . '.aside_text')->label('Text vedle formuláře'),
                    TextInput::make($arrayToSaveName . '.support_title')->label('Spodní nadpis'),
                    Textarea::make($arrayToSaveName . '.support_text')->label('Spodní text')->rows(3),
                ])
                ->columns(1),
        ];
    }
}