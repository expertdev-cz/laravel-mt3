<?php

namespace App\Filament\Modules\PageTypes;

use Filament\Schemas\Components\Group;

class ArticlesPageType
{
    public static function getDefinition(string $arrayToSaveName = 'content'): array
    {
        return [
            Group::make([
            ])->columns(1)->columnSpanFull(),
        ];
    }

}
