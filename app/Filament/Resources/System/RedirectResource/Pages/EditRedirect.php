<?php

namespace App\Filament\Resources\System\RedirectResource\Pages;

use App\Filament\Resources\System\RedirectResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Artisan;

class EditRedirect extends EditRecord
{
    protected static string $resource = RedirectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Smazat')
                ->after(function() {
                    Artisan::call('route:clear');
                }),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Redirect byl úspěšně aktualizován';
    }

    protected function afterSave(): void
    {
        Artisan::call('route:clear');
    }

    protected function afterDelete(): void
    {
        Artisan::call('route:clear');
    }
}