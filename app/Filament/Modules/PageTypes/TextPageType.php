<?php

namespace App\Filament\Modules\PageTypes;

use App\Filament\Modules\ImageModule;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Fieldset;

class TextPageType
{
    public static function getDefinition(string $arrayToSaveName = 'content'): array
    {
        return [
            Fieldset::make('Obsah stránky')->schema([
                RichEditor::make($arrayToSaveName . '.pageContent')->label('Obsah stránky'),
                Repeater::make($arrayToSaveName . '.sections')
                    ->label('Sekce stránky')
                    ->schema([
                        Select::make('layout')
                            ->label('Rozložení')
                            ->options([
                                'full' => 'Text přes celou šířku',
                                'narrow' => 'Užší textový blok',
                                'image_left' => 'Obrázek vlevo, text vpravo',
                                'image_right' => 'Text vlevo, obrázek vpravo',
                                'contact_right' => 'Kontakt napravo',
                            ])
                            ->default('full')
                            ->required(),
                        TextInput::make('title')
                            ->label('Nadpis sekce'),
                        RichEditor::make('text')
                            ->label('Text sekce'),
                        ImageModule::getDefinition('image', 'Obrázek / ikona sekce', ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']),
                        TextInput::make('image_alt')
                            ->label('Alt obrázku'),
                        Repeater::make('items')
                            ->label('Položky seznamu')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Položka'),
                                Textarea::make('text')
                                    ->label('Popis')
                                    ->rows(2),
                            ])
                            ->default([])
                            ->collapsed()
                            ->addActionLabel('Přidat položku')
                            ->columns(1),
                        TextInput::make('contact_title')
                            ->label('Nadpis kontaktu'),
                        TextInput::make('contact_subtitle')
                            ->label('Podnadpis kontaktu'),
                        TextInput::make('contact_name')
                            ->label('Jméno kontaktu'),
                        TextInput::make('contact_email')
                            ->label('E-mail kontaktu')
                            ->email(),
                        TextInput::make('contact_phone')
                            ->label('Telefon kontaktu'),
                    ])
                    ->default([])
                    ->collapsed()
                    ->addActionLabel('Přidat sekci')
                    ->columns(1),
            ])->columns(1),
        ];
    }

}
