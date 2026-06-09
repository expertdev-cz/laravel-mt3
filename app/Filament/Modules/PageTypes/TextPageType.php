<?php

namespace App\Filament\Modules\PageTypes;

use App\Filament\Modules\ImageModule;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Get;

class TextPageType
{
    public static function getDefinition(string $arrayToSaveName = 'content'): array
    {
        return [
            Fieldset::make('Obsah stránky')->schema([

                TextInput::make($arrayToSaveName . '.subtitle')
                    ->label('Text pod nadpisem (zobrazí se šedě pod hlavním nadpisem stránky)')
                    ->helperText('Nadpis stránky se nastavuje v poli \'Název\' výše.'),

                RichEditor::make($arrayToSaveName . '.pageContent')
                    ->label('Přímý obsah (volitelné — pro jednoduché stránky jako Podmínky použití)')
                    ->helperText('Pokud stránka potřebuje jen formátovaný text bez sekcí, napište ho sem. Sekce níže nechte prázdné.'),

                Repeater::make($arrayToSaveName . '.sections')
                    ->label('Sekce stránky')
                    ->itemLabel(fn(array $state): ?string => match($state['layout'] ?? 'full') {
                        'full'          => '📄 Textový blok',
                        'image_right'   => '🖼 Text + ikona vpravo',
                        'image_left'    => '🖼 Ikona vlevo + text',
                        'contact_right' => '👤 Kontaktní blok',
                        default         => $state['layout'] ?? '',
                    })
                    ->schema([

                        Select::make('layout')
                            ->label('Typ sekce')
                            ->options([
                                'full'          => '📄  Textový blok — nadpis, text, volitelná ikona nahoře a seznam (Záruky, Údržba, CE texty)',
                                'image_right'   => '🖼  Text vlevo + obrázek/ikona vpravo (CE — logo vedle textu)',
                                'contact_right' => '👤  Text + seznam vlevo, kontaktní blok vpravo (Školení, Pracovní příležitosti)',
                            ])
                            ->default('full')
                            ->required()
                            ->live(),


                        // ── Textový blok (full) ─────────────────────────────────
                        ImageModule::getDefinition(
                            'image',
                            '🖼 Ikona / obrázek nahoře (volitelné) — zobrazí se nad textem, jako ikona záruky',
                            ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']
                        )
                            ->hidden(fn(Get $get) => !in_array($get('layout'), ['full', 'image_right', 'image_left'])),

                        TextInput::make('image_alt')
                            ->label('Popisek obrázku (alt)')
                            ->hidden(fn(Get $get) => !in_array($get('layout'), ['full', 'image_right', 'image_left'])),

                        RichEditor::make('text')
                            ->label('Text')
                            ->helperText('Podporuje tučné, kurzíva, seznamy, nadpisy...')
                            ->hidden(fn(Get $get) => $get('layout') === null),

                        TextInput::make('gps_text')
                            ->label('GPS souřadnice (volitelné — zobrazí se pod textem)')
                            ->hidden(fn(Get $get) => $get('layout') !== 'contact_right'),

                        TextInput::make('gps_url')
                            ->label('Odkaz na mapu (Google Maps URL)')
                            ->url()
                            ->hidden(fn(Get $get) => $get('layout') !== 'contact_right'),

                        // ── Kontaktní blok (contact_right) ─────────────────────
                        Fieldset::make('Kontaktní blok (zobrazí se vpravo)')
                            ->schema([
                                TextInput::make('contact_title')
                                    ->label('Nadpis (např. Kontakt)'),
                                TextInput::make('contact_subtitle')
                                    ->label('Podnadpis (např. pracovní příležitosti)'),
                                TextInput::make('contact_name')
                                    ->label('Jméno'),
                                TextInput::make('contact_email')
                                    ->label('E-mail')
                                    ->email(),
                                TextInput::make('contact_phone')
                                    ->label('Telefon'),
                            ])
                            ->columns(1)
                            ->hidden(fn(Get $get) => $get('layout') !== 'contact_right'),

                    ])
                    ->default([])
                    ->collapsed()
                    ->addActionLabel('Přidat sekci')
                    ->columns(1),

            ])->columns(1),
        ];
    }
}

