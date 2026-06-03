<?php

namespace App\Filament\Resources\AuthorizedAccess\AuthorizedAccessDownloadResource\Pages;

use App\Filament\Resources\AuthorizedAccess\AuthorizedAccessDownloadResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAuthorizedAccessDownload extends CreateRecord
{
    protected static ?string $title = 'Vytvoření AP souboru';
    protected static string $resource = AuthorizedAccessDownloadResource::class;
}