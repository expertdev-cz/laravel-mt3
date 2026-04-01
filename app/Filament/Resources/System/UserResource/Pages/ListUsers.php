<?php

namespace App\Filament\Resources\System\UserResource\Pages;

use App\Filament\Resources\System\UserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static ?string $title = 'Přehled sys. uživatelů';
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
