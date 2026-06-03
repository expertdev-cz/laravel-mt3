<?php

namespace App\Filament\Modules\PageTypes;

use App\Filament\Modules\ImageModule;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Fieldset;

class ContactPageType
{
    public static function getDefinition(string $arrayToSaveName = 'content'): array
    {
        return [
            Fieldset::make('Úvod sekce')
                ->schema([
                    TextInput::make($arrayToSaveName . '.title')
                        ->label('Nadpis'),
                    Textarea::make($arrayToSaveName . '.intro_text')
                        ->label('Úvodní text')
                        ->rows(3),
                ])
                ->columns(1),

            Fieldset::make('Kontaktní karty')
                ->schema([
                    Repeater::make($arrayToSaveName . '.items')
                        ->label('Kontaktní bloky')
                        ->schema([
                            TextInput::make('department')
                                ->label('Oddělení / tým'),
                            TextInput::make('name')
                                ->label('Jméno'),
                            TextInput::make('email')
                                ->label('E-mail')
                                ->email(),
                            TextInput::make('phone')
                                ->label('Telefon'),
                        ])
                        ->default([])
                        ->collapsed()
                        ->addActionLabel('Přidat kartu')
                        ->columns(1),
                ])
                ->columns(1),

            Fieldset::make('Firemní blok s mapou')
                ->schema([
                    ImageModule::getDefinition($arrayToSaveName . '.company_background_image', 'Background obrázek sekce', ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']),
                    TextInput::make($arrayToSaveName . '.company_name')
                        ->label('Název firmy'),
                    Textarea::make($arrayToSaveName . '.address_text')
                        ->label('Adresa a firemní údaje')
                        ->rows(6),
                    TextInput::make($arrayToSaveName . '.gps_url')
                        ->label('GPS odkaz')
                        ->url(),
                    TextInput::make($arrayToSaveName . '.gps_label')
                        ->label('GPS text'),
                    ImageModule::getDefinition($arrayToSaveName . '.map_image', 'Mapa / SVG', ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']),
                ])
                ->columns(1),

            Fieldset::make('Spodní firemní info')
                ->schema([
                    TextInput::make($arrayToSaveName . '.footer_title')
                        ->label('Nadpis'),
                    Textarea::make($arrayToSaveName . '.footer_text')
                        ->label('Hlavní text')
                        ->rows(3),
                    Textarea::make($arrayToSaveName . '.footer_note')
                        ->label('Malý text')
                        ->rows(2),
                ])
                ->columns(1),
        ];
    }
}
