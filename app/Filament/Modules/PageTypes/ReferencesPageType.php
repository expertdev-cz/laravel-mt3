<?php

namespace App\Filament\Modules\PageTypes;

use App\Filament\Modules\ButtonModule;
use App\Filament\Modules\ImageModule;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Fieldset;

class ReferencesPageType
{
    public static function getDefinition(string $arrayToSaveName = 'content'): array
    {
        return [
            Fieldset::make('Úvod reference')
                ->schema([
                    TextInput::make($arrayToSaveName . '.title')
                        ->label('Nadpis'),
                    Textarea::make($arrayToSaveName . '.intro_text')
                        ->label('Podnadpis')
                        ->rows(3),
                ])
                ->columns(1),

            Fieldset::make('Hlavní reference')
                ->schema([
                    ImageModule::getDefinition($arrayToSaveName . '.featured.image', 'Hlavní obrázek', ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']),
                    TextInput::make($arrayToSaveName . '.featured.location')
                        ->label('Lokace'),
                    TextInput::make($arrayToSaveName . '.featured.description')
                        ->label('Popis'),
                    ButtonModule::getDefinition($arrayToSaveName . '.featured.button', 'Odkaz na detail'),
                ])
                ->columns(1),

            Fieldset::make('Grid referencí')
                ->schema([
                    Repeater::make($arrayToSaveName . '.items')
                        ->label('Položky gridu')
                        ->itemLabel(fn(array $state): ?string => ($state['location'] ?? '') ?: ($state['description'] ?? null))
                        ->schema([
                            ImageModule::getDefinition('image', 'Obrázek reference', ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']),
                            TextInput::make('location')
                                ->label('Lokace'),
                            TextInput::make('description')
                                ->label('Popis'),
                            ButtonModule::getDefinition('button', 'Odkaz na detail'),
                        ])
                        ->default([])
                        ->collapsed()
                        ->addActionLabel('Přidat referenci')
                        ->columns(1),
                ])
                ->columns(1),
        ];
    }
}