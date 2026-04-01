<?php

namespace App\Filament\Resources\System\LanguageResource\Pages;

use App\Filament\Resources\System\LanguageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLanguages extends ListRecords
{
    protected static ?string $title = 'Přehled jazyků';
    protected static string $resource = LanguageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
