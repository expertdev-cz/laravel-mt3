<?php

namespace App\Filament\Resources\System\PageRouteResource\Pages;

use App\Filament\Resources\System\PageRouteResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class CreatePageRoute extends CreateRecord
{
    protected static ?string $title = 'Create Page Route';
    protected static string $resource = PageRouteResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        Cache::forget('localized_routes_definitions');
        Cache::forget('localized_routes');
        Cache::forget('localized_pages_definitions');
        Cache::forget('generated_routes_definitions');
        Artisan::call('route:clear');
        Artisan::call('optimize:clear');
    }
}
