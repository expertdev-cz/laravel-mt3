<?php

namespace App\Filament\Resources\AuthorizedAccess\AuthorizedAccessUserResource\Pages;

use App\Filament\Resources\AuthorizedAccess\AuthorizedAccessUserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAuthorizedAccessUser extends EditRecord
{
    protected static ?string $title = 'Editace AP uživatele';
    protected static string $resource = AuthorizedAccessUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}