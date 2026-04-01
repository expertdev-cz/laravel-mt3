<?php

namespace App\Filament\Resources\Marketing\ContactFormRequestResource\Pages;

use App\Filament\Resources\Marketing\ContactFormRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditContactFormRequest extends EditRecord
{
    protected static ?string $title = 'Editace dotazu';
    protected static string $resource = ContactFormRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
           // DeleteAction::make(),
        ];
    }
}
