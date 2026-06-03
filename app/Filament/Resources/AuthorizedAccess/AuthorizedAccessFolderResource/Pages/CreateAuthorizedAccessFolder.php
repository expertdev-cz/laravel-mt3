<?php

namespace App\Filament\Resources\AuthorizedAccess\AuthorizedAccessFolderResource\Pages;

use App\Filament\Resources\AuthorizedAccess\AuthorizedAccessFolderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAuthorizedAccessFolder extends CreateRecord
{
    protected static ?string $title = 'Vytvoření AP složky';
    protected static string $resource = AuthorizedAccessFolderResource::class;
}