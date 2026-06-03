<?php

namespace App\Filament\Resources\AuthorizedAccess\AuthorizedAccessUserResource\Pages;

use App\Filament\Resources\AuthorizedAccess\AuthorizedAccessUserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAuthorizedAccessUser extends CreateRecord
{
    protected static ?string $title = 'Vytvoření AP uživatele';
    protected static string $resource = AuthorizedAccessUserResource::class;
}