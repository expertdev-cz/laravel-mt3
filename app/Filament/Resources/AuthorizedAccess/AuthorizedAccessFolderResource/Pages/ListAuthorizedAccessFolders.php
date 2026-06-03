<?php

namespace App\Filament\Resources\AuthorizedAccess\AuthorizedAccessFolderResource\Pages;

use App\Filament\Resources\AuthorizedAccess\AuthorizedAccessFolderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAuthorizedAccessFolders extends ListRecords
{
    protected static ?string $title = 'Přehled AP složek';
    protected static string $resource = AuthorizedAccessFolderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}