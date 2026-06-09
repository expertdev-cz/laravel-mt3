<?php

namespace App\Filament\Modules\PageTypes;

use App\Filament\Modules\ImageModule;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Fieldset;

class NextPageType
{
    public static function getDefinition(string $arrayToSaveName = 'content'): array
    {
        return [
            Fieldset::make('Hero sekce')
                ->schema([
                    TextInput::make($arrayToSaveName . '.hero_eyebrow')
                        ->label('Eyebrow text (malý text nad nadpisem)'),
                    TextInput::make($arrayToSaveName . '.hero_heading')
                        ->label('Nadpis'),
                    Textarea::make($arrayToSaveName . '.hero_text')
                        ->label('Podnadpis')
                        ->rows(2),
                ])
                ->columns(1),

            Fieldset::make('Produktová mřížka')
                ->schema([
                    Repeater::make($arrayToSaveName . '.items')
                        ->label('Položky')
                        ->itemLabel(fn(array $state): ?string => ($state['title'] ?? '') ?: null)
                        ->schema([
                            TextInput::make('title')->label('Název produktu'),
                            ImageModule::getDefinition('image', 'Obrázek pozadí', ['image/jpeg', 'image/png', 'image/webp']),
                            TextInput::make('location')->label('Popis lokace (pravý dolní roh)'),
                        ])
                        ->default([])
                        ->collapsed()
                        ->addActionLabel('Přidat položku')
                        ->columns(1),
                ])
                ->columns(1),
        ];
    }
}
