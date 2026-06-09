<?php

namespace App\Filament\Modules\PageTypes;

use App\Filament\Modules\ImageModule;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Fieldset;

class TechnologiesPageType
{
    public static function getDefinition(string $arrayToSaveName = 'content'): array
    {
        return [
            Fieldset::make('Blok 1')
                ->schema([
                    ImageModule::getDefinition($arrayToSaveName . '.block_1.background_image', 'Background obrázek', ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']),
                    TextInput::make($arrayToSaveName . '.block_1.side_label')
                        ->label('Levý spodní text'),
                    TextInput::make($arrayToSaveName . '.block_1.title')
                        ->label('Hlavní nadpis'),
                    Textarea::make($arrayToSaveName . '.block_1.text')
                        ->label('Text bloku')
                        ->rows(3),
                ])
                ->columns(1),

            Fieldset::make('Blok 2')
                ->schema([
                    ImageModule::getDefinition($arrayToSaveName . '.block_2.background_image', 'Background obrázek', ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']),
                    TextInput::make($arrayToSaveName . '.block_2.title')
                        ->label('Nadpis'),
                    Textarea::make($arrayToSaveName . '.block_2.text')
                        ->label('Text bloku')
                        ->rows(4),
                    TextInput::make($arrayToSaveName . '.block_2.side_label')
                        ->label('Pravý spodní text'),
                ])
                ->columns(1),

            Fieldset::make('Servisní sekce')
                ->schema([
                    Textarea::make($arrayToSaveName . '.service_intro')
                        ->label('Úvodní text')
                        ->rows(3),
                    Repeater::make($arrayToSaveName . '.materials')
                        ->label('Tabulka materiálů')
                        ->itemLabel(fn(array $state): ?string => ($state['label'] ?? '') ?: null)
                        ->schema([
                            Select::make('type')
                                ->label('Typ řádku')
                                ->options([
                                    'row' => 'Datový řádek',
                                    'header' => 'Nadpis (záhlaví / sekce)',
                                ])
                                ->default('row')
                                ->required(),
                            TextInput::make('label')
                                ->label('Materiál / parametr'),
                            TextInput::make('value')
                                ->label('Hodnota (prázdné pro nadpis sekce)'),
                        ])
                        ->default([])
                        ->collapsed()
                        ->addActionLabel('Přidat řádek')
                        ->columns(1),
                    TextInput::make($arrayToSaveName . '.service_contact_title')
                        ->label('Titulek kontaktu'),
                    TextInput::make($arrayToSaveName . '.service_contact_subtitle')
                        ->label('Podtitulek kontaktu'),
                    TextInput::make($arrayToSaveName . '.service_contact_name')
                        ->label('Jméno kontaktu'),
                    TextInput::make($arrayToSaveName . '.service_contact_email')
                        ->label('E-mail')
                        ->email(),
                    TextInput::make($arrayToSaveName . '.service_contact_phone')
                        ->label('Telefon'),
                ])
                ->columns(1),

            Fieldset::make('Sekce ohraňování')
                ->schema([
                    ImageModule::getDefinition($arrayToSaveName . '.bending.image', 'Obrázek sekce', ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']),
                    TextInput::make($arrayToSaveName . '.bending.title')
                        ->label('Nadpis'),
                    Textarea::make($arrayToSaveName . '.bending.text')
                        ->label('Text sekce')
                        ->rows(4),
                    TextInput::make($arrayToSaveName . '.bending_contact_title')
                        ->label('Titulek kontaktu'),
                    TextInput::make($arrayToSaveName . '.bending_contact_subtitle')
                        ->label('Podtitulek kontaktu'),
                    TextInput::make($arrayToSaveName . '.bending_contact_name')
                        ->label('Jméno kontaktu'),
                    TextInput::make($arrayToSaveName . '.bending_contact_email')
                        ->label('E-mail')
                        ->email(),
                    TextInput::make($arrayToSaveName . '.bending_contact_phone')
                        ->label('Telefon'),
                ])
                ->columns(1),

            Fieldset::make('Blok 4')
                ->schema([
                    ImageModule::getDefinition($arrayToSaveName . '.block_4.background_image', 'Background obrázek', ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']),
                    TextInput::make($arrayToSaveName . '.block_4.title')
                        ->label('Nadpis'),
                    Textarea::make($arrayToSaveName . '.block_4.text')
                        ->label('Text bloku')
                        ->rows(3),
                    TextInput::make($arrayToSaveName . '.block_4.side_label')
                        ->label('Pravý spodní text'),
                ])
                ->columns(1),
        ];
    }
}