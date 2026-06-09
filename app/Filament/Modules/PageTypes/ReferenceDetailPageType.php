<?php

namespace App\Filament\Modules\PageTypes;

use App\Filament\Modules\ImagesModule;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Fieldset;

class ReferenceDetailPageType
{
    public static function getDefinition(string $arrayToSaveName = 'content'): array
    {
        return [
            Fieldset::make('Úvod detailu')
                ->schema([
                    TextInput::make($arrayToSaveName . '.title')
                        ->label('Nadpis'),
                    Textarea::make($arrayToSaveName . '.intro_text')
                        ->label('Perex')
                        ->rows(3),
                ])
                ->columns(1),

            Fieldset::make('Carousel obrázků')
                ->schema([
                    ImagesModule::getDefinition(
                        $arrayToSaveName . '.carousel_images',
                        'Obrázky carouselu',
                        ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']
                    ),
                ])
                ->columns(1),

            Fieldset::make('Detail reference')
                ->schema([
                    TextInput::make($arrayToSaveName . '.detail_title')
                        ->label('Titulek reference'),
                    TextInput::make($arrayToSaveName . '.location')
                        ->label('Lokace'),
                    TextInput::make($arrayToSaveName . '.count')
                        ->label('Počet kusů'),
                    TextInput::make($arrayToSaveName . '.product_code')
                        ->label('Typ / kód produktu'),
                    TextInput::make($arrayToSaveName . '.year')
                        ->label('Rok'),
                ])
                ->columns(1),
        ];
    }
}