<?php

namespace App\Filament\Modules\PageTypes;

use App\Filament\Modules\ButtonModule;
use App\Filament\Modules\ImageModule;
use App\Filament\Modules\ImagesModule;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;

class HomepagePageType
{
    public static function getDefinition(string $arrayToSaveName = 'content', ?string $locale = null): array
    {
        return [
            Fieldset::make('Obsah homepage')
                ->schema([
                    TextInput::make($arrayToSaveName . '.heading')
                        ->label('Nadpis'),
                    RichEditor::make($arrayToSaveName . '.body')
                        ->label('Text'),
                    ButtonModule::getDefinition($arrayToSaveName . '.button', 'Tlačítko', $locale),
                    ImageModule::getDefinition($arrayToSaveName . '.image', 'Obrazek homepage', ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']),
                    ImagesModule::getDefinition($arrayToSaveName . '.images', 'Galerie obrázků homepage', ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']),
                ])
                ->columns(1),
        ];
    }
}
