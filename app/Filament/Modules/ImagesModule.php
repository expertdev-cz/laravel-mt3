<?php

namespace App\Filament\Modules;

use Awcodes\Curator\Components\Forms\CuratorPicker;

class ImagesModule
{
    public static function getDefinition(
        string $name = 'images',
        string $label = 'Obrázky',
        array $allowedFormats = ['image/jpeg', 'image/apng', 'image/gif', 'image/png', 'image/svg+xml', 'image/webp']
    ): CuratorPicker {
        $curator = CuratorPicker::make($name)
            ->label($label)
            ->default([])
            ->multiple();

        if ($allowedFormats) {
            $curator->acceptedFileTypes($allowedFormats);
        }

        return $curator;
    }
}
