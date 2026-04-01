<?php

namespace App\Filament\Resources\System\RedirectResource\Pages;

use App\Filament\Resources\System\RedirectResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRedirects extends ListRecords
{
    protected static string $resource = RedirectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Vytvořit redirect'),
        ];
    }
}