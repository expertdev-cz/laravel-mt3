<?php

namespace App\Filament\Resources\AuthorizedAccess\AuthorizedAccessDownloadResource\Pages;

use App\Filament\Resources\AuthorizedAccess\AuthorizedAccessDownloadResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAuthorizedAccessDownload extends EditRecord
{
    protected static ?string $title = 'Editace AP souboru';
    protected static string $resource = AuthorizedAccessDownloadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}