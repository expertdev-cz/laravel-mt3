<?php

namespace App\Filament\Resources\System\PageRouteResource\Pages;

use App\Filament\Resources\System\PageRouteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPageRoutes extends ListRecords
{
    protected static ?string $title = 'Page Routes';
    protected static string $resource = PageRouteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
