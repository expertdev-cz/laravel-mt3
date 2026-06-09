<?php

namespace App\Filament\Modules\PageTypes;

use App\Filament\Modules\ImageModule;
use App\Models\PageRouteUrls;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Get;

class ProductPageType
{
    protected static function pageOptions(?string $locale = null): array
    {
        return PageRouteUrls::query()
            ->when(!blank($locale), fn ($q) => $q->where('locale', $locale))
            ->get(['id', 'slug'])
            ->mapWithKeys(fn ($r) => [(string) $r->id => $r->slug])
            ->all();
    }

    public static function getDefinition(string $arrayToSaveName = 'content'): array
    {
        return [
            Fieldset::make('Hero sekce (video)')
                ->schema([
                    Select::make($arrayToSaveName . '.hero_type')
                        ->label('Typ hero sekce')
                        ->options([
                            'classic'     => 'Klasický (text vpravo dole)',
                            'alternative' => 'Alternativní (text uprostřed)',
                        ])
                        ->default('classic')
                        ->required(),
                    ImageModule::getDefinition($arrayToSaveName . '.hero_video_file', 'Video hero sekce', ['video/mp4', 'video/webm']),
                    TextInput::make($arrayToSaveName . '.hero_eyebrow')
                        ->label('Malý text nad nadpisem (např. "Poster")'),
                    TextInput::make($arrayToSaveName . '.hero_heading')
                        ->label('Hlavní nadpis hero sekce'),
                    Textarea::make($arrayToSaveName . '.hero_text')
                        ->label('Popis v hero sekci')
                        ->rows(2),
                    TextInput::make($arrayToSaveName . '.hero_price')
                        ->label('Cena (např. "Od 65 000 Kč")'),
                    Select::make($arrayToSaveName . '.hero_inquiry_page_route_url_id')
                        ->label('Stránka tlačítka "Napište nám"')
                        ->options(fn (Get $get) => static::pageOptions($get('lang_locale')))
                        ->searchable()
                        ->preload()
                        ->default(null)
                        ->placeholder('— vyberte stránku —'),
                ])
                ->columns(1),

            Fieldset::make('Sekce produktu (showcase bloky)')
                ->schema([
                    Repeater::make($arrayToSaveName . '.sections')
                        ->label('Sekce')
                        ->itemLabel(fn(array $state): ?string =>
                            ($state['big_heading'] ?? '') ?: ($state['subheading'] ?? 'Nová sekce')
                        )
                        ->schema([
                            Checkbox::make('is_reversed')
                                ->label('Obrázek vlevo, obsah vpravo'),
                            TextInput::make('big_heading')
                                ->label('Velký nadpis sekce (např. "Instalace")'),
                            TextInput::make('subheading')
                                ->label('Podnadpis sekce'),
                            RichEditor::make('text')
                                ->label('Text sekce'),
                            Repeater::make('parameters')
                                ->label('Parametry (zpravidla 3 položky)')
                                ->itemLabel(fn(array $state): ?string =>
                                    ($state['label'] ?? '') ?: ($state['value'] ?? null)
                                )
                                ->schema([
                                    TextInput::make('label')->label('Popis (malý text)'),
                                    TextInput::make('value')->label('Hodnota (tučný text)'),
                                ])
                                ->default([])
                                ->collapsed()
                                ->addActionLabel('Přidat parametr')
                                ->columns(1),
                            ImageModule::getDefinition('image', 'Obrázek sekce', ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']),
                        ])
                        ->default([])
                        ->collapsed()
                        ->addActionLabel('Přidat sekci')
                        ->columns(1),
                ])
                ->columns(1),

            Fieldset::make('Lišta reference / objednávka')
                ->schema([
                    TextInput::make($arrayToSaveName . '.bar_reference_text')
                        ->label('Text reference (např. "Podívejte se na realizace.")'),
                    Select::make($arrayToSaveName . '.bar_reference_page_route_url_id')
                        ->label('Stránka reference (odkaz)')
                        ->options(fn (Get $get) => static::pageOptions($get('lang_locale')))
                        ->searchable()
                        ->preload()
                        ->default(null)
                        ->placeholder('— vyberte stránku —'),
                    TextInput::make($arrayToSaveName . '.bar_order_text')
                        ->label('Text objednávky')
                        ->default('Objednávku můžete realizovat s naším obchodním oddělením.'),
                    TextInput::make($arrayToSaveName . '.bar_order_email')
                        ->label('E-mail objednávky')
                        ->email()
                        ->default('obchod.project@mt3.cz'),
                    TextInput::make($arrayToSaveName . '.bar_order_label')
                        ->label('Popisek odkazu objednávky')
                        ->default('Objednat'),
                ])
                ->columns(1),

            Fieldset::make('Tabulka rozměrů / parametrů')
                ->schema([
                    TextInput::make($arrayToSaveName . '.table_title')
                        ->label('Velký nadpis tabulky (např. "Rozměry")'),
                    TextInput::make($arrayToSaveName . '.table_subtitle')
                        ->label('Podnadpis tabulky'),
                    TextInput::make($arrayToSaveName . '.table_param_label')
                        ->label('Záhlaví sloupce parametrů')
                        ->default('Parametr'),
                    TextInput::make($arrayToSaveName . '.table_col1_label')
                        ->label('Záhlaví 1. sloupce'),
                    TextInput::make($arrayToSaveName . '.table_col2_label')
                        ->label('Záhlaví 2. sloupce'),
                    ImageModule::getDefinition($arrayToSaveName . '.table_col1_image', 'Obrázek nad 1. sloupcem', ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']),
                    ImageModule::getDefinition($arrayToSaveName . '.table_col2_image', 'Obrázek nad 2. sloupcem', ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']),
                    Repeater::make($arrayToSaveName . '.table_rows')
                        ->label('Řádky tabulky')
                        ->itemLabel(fn(array $state): ?string => ($state['param'] ?? '') ?: null)
                        ->schema([
                            TextInput::make('param')->label('Parametr'),
                            TextInput::make('col1_value')->label('Hodnota 1. sloupce'),
                            TextInput::make('col2_value')->label('Hodnota 2. sloupce'),
                        ])
                        ->default([])
                        ->collapsed()
                        ->addActionLabel('Přidat řádek')
                        ->columns(1),
                    Textarea::make($arrayToSaveName . '.table_note')
                        ->label('Poznámka pod tabulkou')
                        ->rows(2),
                ])
                ->columns(1),
        ];
    }
}
