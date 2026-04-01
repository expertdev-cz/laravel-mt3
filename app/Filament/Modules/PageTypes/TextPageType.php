<?php

namespace App\Filament\Modules\PageTypes;

use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Fieldset;

class TextPageType
{
    public static function getDefinition(string $arrayToSaveName = 'content'): array
    {
        return [
            Fieldset::make('Obsah stránky')->schema([
                RichEditor::make($arrayToSaveName . '.pageContent')->label('Obsah stránky'),
            ])->columns(1),
        ];
    }

}
