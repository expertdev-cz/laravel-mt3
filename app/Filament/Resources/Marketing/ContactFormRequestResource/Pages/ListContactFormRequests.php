<?php

namespace App\Filament\Resources\Marketing\ContactFormRequestResource\Pages;

use App\Filament\Resources\Marketing\ContactFormRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContactFormRequests extends ListRecords
{
    protected static ?string $title = 'Přehled dotazů';
    protected static string $resource = ContactFormRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
