<?php

namespace App\Filament\Resources\Marketing\ContactFormRequestResource\Pages;

use App\Filament\Resources\Marketing\ContactFormRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateContactFormRequest extends CreateRecord
{
    protected static ?string $title = 'Vytvoření dotazu';
    protected static string $resource = ContactFormRequestResource::class;
}
