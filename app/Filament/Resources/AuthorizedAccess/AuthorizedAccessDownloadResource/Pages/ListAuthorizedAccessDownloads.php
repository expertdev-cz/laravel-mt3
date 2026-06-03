<?php

namespace App\Filament\Resources\AuthorizedAccess\AuthorizedAccessDownloadResource\Pages;

use App\Filament\Resources\AuthorizedAccess\AuthorizedAccessDownloadResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAuthorizedAccessDownloads extends ListRecords
{
    protected static ?string $title = 'Přehled AP souborů';
    protected static string $resource = AuthorizedAccessDownloadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}