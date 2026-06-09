<?php

namespace App\Filament\Modules\PageTypes;

use App\Filament\Modules\ButtonModule;
use App\Filament\Modules\ImageModule;
use App\Filament\Modules\ImagesModule;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Fieldset;

class HomepagePageType
{
    public static function getDefinition(string $arrayToSaveName = 'content'): array
    {
        return [
            Fieldset::make('Hero sekce')
                ->schema([
                    ImageModule::getDefinition($arrayToSaveName . '.hero_video_poster', 'Poster videa', ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']),
                    ImageModule::getDefinition($arrayToSaveName . '.hero_video_file', 'Video hero sekce', ['video/mp4', 'video/webm']),
                ])
                ->columns(1),

            Fieldset::make('Produktové showcase bloky')
                ->schema([
                    Repeater::make($arrayToSaveName . '.showcases')
                        ->label('Showcase sekce')
                        ->itemLabel(fn ($state) => $state['product_title'] ?? 'Showcase blok')
                        ->schema([
                            Checkbox::make('is_reversed')
                                ->label('Obrázek vpravo'),
                            ImageModule::getDefinition('background_image', 'Background obrázek sekce', ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']),
                            TextInput::make('eyebrow_title')
                                ->label('Hlavní claim'),
                            TextInput::make('eyebrow_subtitle')
                                ->label('Druhý řádek claimu'),
                            TextInput::make('category')
                                ->label('Kategorie'),
                            TextInput::make('product_title')
                                ->label('Název produktu'),
                            Textarea::make('product_text')
                                ->label('Popis produktu')
                                ->rows(3),
                            TextInput::make('price')
                                ->label('Cena / cenovka'),
                            ButtonModule::getDefinition('button', 'Tlačítko produktu'),
                            Repeater::make('parameters')
                                ->label('Horní řádek parametrů')
                                ->itemLabel(fn ($state) => $state['label'] ?? 'Parametr')
                                ->schema([
                                    TextInput::make('label')
                                        ->label('Název parametru'),
                                    TextInput::make('value')
                                        ->label('Hodnota parametru'),
                                ])
                                ->default([])
                                ->collapsed()
                                ->addActionLabel('Přidat parametr')
                                ->columns(1),
                            Repeater::make('icons')
                                ->label('Ikony spodního řádku')
                                ->itemLabel(fn ($state) => 'Ikona')
                                ->schema([
                                    ImageModule::getDefinition('default_icon', 'Výchozí ikona', ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']),
                                    ImageModule::getDefinition('hover_icon', 'Hover ikona', ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']),
                                ])
                                ->default([])
                                ->collapsed()
                                ->addActionLabel('Přidat ikonu')
                                ->columns(1),
                            ImageModule::getDefinition('product_image', 'Produktový obrázek', ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']),
                        ])
                        ->default([])
                        ->collapsed()
                        ->addActionLabel('Přidat showcase blok')
                        ->columns(1),
                ])
                ->columns(1),

            Fieldset::make('Infografiky a spodní CTA')
                ->schema([
                    ImagesModule::getDefinition(
                        $arrayToSaveName . '.info_cards',
                        'Infografiky (max. 5)',
                        ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']
                    )->maxItems(5),
                    TextInput::make($arrayToSaveName . '.bottom_title')
                        ->label('Spodní nadpis'),
                    Textarea::make($arrayToSaveName . '.bottom_text_first')
                        ->label('První odstavec')
                        ->rows(2),
                    Textarea::make($arrayToSaveName . '.bottom_text_second')
                        ->label('Druhý odstavec')
                        ->rows(2),
                    ButtonModule::getDefinition($arrayToSaveName . '.bottom_button', 'Spodní tlačítko'),
                ])
                ->columns(1),
        ];
    }
}
