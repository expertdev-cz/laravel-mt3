<?php

namespace App\Filament\Resources\System\PageRouteResource\Pages;

use App\Filament\Resources\System\PageRouteResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class EditPageRoute extends EditRecord
{
    protected static ?string $title = 'Edit Page Route';
    protected static string $resource = PageRouteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->before(function () {
                    // Check if the route is being used by any pages
                    if ($this->record->pages()->count() > 0) {
                        // Prevent deletion and show an error message
                        $this->halt();
                        $this->notify('error', 'This route cannot be deleted because it is being used by one or more pages.');
                        return false;
                    }
                }),
            ForceDeleteAction::make()
                ->before(function () {
                    // Check if the route is being used by any pages
                    if ($this->record->pages()->count() > 0) {
                        // Prevent deletion and show an error message
                        $this->halt();
                        $this->notify('error', 'This route cannot be force deleted because it is being used by one or more pages.');
                        return false;
                    }
                }),
            RestoreAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        Cache::forget('localized_routes_definitions');
        Cache::forget('localized_routes');
        Cache::forget('localized_pages_definitions');
        Cache::forget('generated_routes_definitions');
        Artisan::call('route:clear');
        Artisan::call('optimize:clear');
    }

    protected function afterDelete(): void
    {
        Cache::forget('localized_routes_definitions');
        Cache::forget('localized_routes');
        Cache::forget('localized_pages_definitions');
        Cache::forget('generated_routes_definitions');
        Artisan::call('route:clear');
        Artisan::call('optimize:clear');
    }

    protected function afterForceDelete(): void
    {
        Cache::forget('localized_routes_definitions');
        Cache::forget('localized_routes');
        Cache::forget('localized_pages_definitions');
        Cache::forget('generated_routes_definitions');
        Artisan::call('route:clear');
        Artisan::call('optimize:clear');
    }

    protected function afterRestore(): void
    {
        Cache::forget('localized_routes_definitions');
        Cache::forget('localized_routes');
        Cache::forget('localized_pages_definitions');
        Cache::forget('generated_routes_definitions');
        Artisan::call('route:clear');
        Artisan::call('optimize:clear');
    }

}
