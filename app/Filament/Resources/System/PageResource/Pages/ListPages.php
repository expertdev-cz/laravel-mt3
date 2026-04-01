<?php

namespace App\Filament\Resources\System\PageResource\Pages;

use App\Filament\Resources\System\PageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPages extends ListRecords
{
    protected static ?string $title = 'Přehled stránek';
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
