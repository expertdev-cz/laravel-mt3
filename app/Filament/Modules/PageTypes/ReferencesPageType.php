<?php

namespace App\Filament\Modules\PageTypes;

use App\Models\PageRouteUrls;
use App\Filament\Modules\ImageModule;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Get;

class ReferencesPageType
{
    protected static function referenceDetailOptions(?string $locale = null): array
    {
        return PageRouteUrls::query()
            ->whereHas('page', fn ($q) => $q->where('type', 'reference-detail'))
            ->when(!blank($locale), fn ($q) => $q->where('locale', $locale))
            ->get(['id', 'slug'])
            ->mapWithKeys(fn ($r) => [(string) $r->id => $r->slug])
            ->all();
    }

    protected static function referenceDetailSelect(string $name, Get $get): Select
    {
        return Select::make($name)
            ->label('Odkaz na detail reference')
            ->options(fn (Get $get) => static::referenceDetailOptions($get('lang_locale')))
            ->searchable()
            ->preload()
            ->default(null)
            ->placeholder('— vyberte stránku detailu —');
    }

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
                    Select::make($arrayToSaveName . '.featured.page_route_url_id')
                        ->label('Odkaz na detail reference')
                        ->options(fn (Get $get) => static::referenceDetailOptions($get('lang_locale')))
                        ->searchable()
                        ->preload()
                        ->default(null)
                        ->placeholder('— vyberte stránku detailu —'),
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
                            Select::make('page_route_url_id')
                                ->label('Odkaz na detail reference')
                                ->options(fn (Get $get) => static::referenceDetailOptions($get('lang_locale')))
                                ->searchable()
                                ->preload()
                                ->default(null)
                                ->placeholder('— vyberte stránku detailu —'),
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