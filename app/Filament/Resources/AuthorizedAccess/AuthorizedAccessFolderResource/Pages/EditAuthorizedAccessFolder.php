<?php

namespace App\Filament\Resources\AuthorizedAccess\AuthorizedAccessFolderResource\Pages;

use App\Filament\Resources\AuthorizedAccess\AuthorizedAccessFolderResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAuthorizedAccessFolder extends EditRecord
{
    protected static ?string $title = 'Editace AP složky';
    protected static string $resource = AuthorizedAccessFolderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}