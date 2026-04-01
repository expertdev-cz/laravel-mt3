<?php

namespace App\Filament\Resources\System\RedirectResource\Pages;

use App\Filament\Resources\System\RedirectResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Artisan;

class CreateRedirect extends CreateRecord
{
    protected static string $resource = RedirectResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Redirect byl úspěšně vytvořen';
    }

    protected function afterCreate(): void
    {
        Artisan::call('route:clear');
    }
}