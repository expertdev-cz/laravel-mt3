<?php

namespace App\Filament\Modules\PageTypes;

use App\Filament\Modules\ImageModule;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Fieldset;

class AboutUsPageType
{
    public static function getDefinition(string $arrayToSaveName = 'content'): array
    {
        return [
            Fieldset::make('Hero sekce')
                ->schema([
                    ImageModule::getDefinition($arrayToSaveName . '.background_image', 'Background obrázek', ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']),
                    TextInput::make($arrayToSaveName . '.hero_title')
                        ->label('Titulek firmy'),
                    Textarea::make($arrayToSaveName . '.hero_text')
                        ->label('Úvodní text')
                        ->rows(3),
                ])
                ->columns(1),

            Fieldset::make('Sekce O nás')
                ->schema([
                    TextInput::make($arrayToSaveName . '.about_title')
                        ->label('Nadpis sekce'),
                    RichEditor::make($arrayToSaveName . '.about_text')
                        ->label('Text sekce'),
                ])
                ->columns(1),

            Fieldset::make('Sekce Základní info')
                ->schema([
                    TextInput::make($arrayToSaveName . '.info_title')
                        ->label('Nadpis sekce'),
                    TextInput::make($arrayToSaveName . '.invoice_title')
                        ->label('Titulek fakturačních údajů'),
                    Textarea::make($arrayToSaveName . '.invoice_text')
                        ->label('Fakturační údaje')
                        ->rows(4),
                    TextInput::make($arrayToSaveName . '.location_title')
                        ->label('Titulek lokace'),
                    Textarea::make($arrayToSaveName . '.location_text')
                        ->label('Text lokace')
                        ->rows(3),
                    TextInput::make($arrayToSaveName . '.location_url')
                        ->label('Odkaz na mapu')
                        ->url(),
                    Textarea::make($arrayToSaveName . '.closing_text')
                        ->label('Závěrečný zvýrazněný text')
                        ->rows(4),
                ])
                ->columns(1),
        ];
    }
}