<?php

namespace App\Filament\Resources\AuthorizedAccess\AuthorizedAccessUserResource\Pages;

use App\Filament\Resources\AuthorizedAccess\AuthorizedAccessUserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAuthorizedAccessUsers extends ListRecords
{
    protected static ?string $title = 'Přehled AP uživatelů';
    protected static string $resource = AuthorizedAccessUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}