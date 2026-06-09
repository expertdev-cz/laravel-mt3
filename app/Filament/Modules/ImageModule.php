<?php

namespace App\Filament\Modules;

use Awcodes\Curator\Components\Forms\CuratorPicker;

class ImageModule
{
    public static function getDefinition(string $name='image', string $label = 'Obrázek/Video', array $allowedFormats=['video/mp4','image/jpeg','image/apng','image/gif','image/png','image/svg+xml','image/webp']): CuratorPicker{
        $curator = CuratorPicker::make($name)->label($label)->maxSize(20480);

        if ($allowedFormats){
            $curator->acceptedFileTypes($allowedFormats);
        }

        return $curator;
    }

}
