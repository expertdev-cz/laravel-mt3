<?php

namespace App\Filament\Resources\System\PageResource\Pages;

use App\Filament\Resources\System\PageResource;
use App\Models\PageRouteUrls;
use App\Models\System\PageRoute;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class CreatePage extends CreateRecord
{
    protected static ?string $title = 'Vytvoření stránky';
    protected static string $resource = PageResource::class;

    protected function afterCreate(): void
    {
        if ($this->record->page_route_id) {
            $pageRoute = PageRoute::find($this->record->page_route_id);

            if ($pageRoute && $pageRoute->disable_auto_route && $this->record->slug) {
                $detail = PageRoute::query()->whereLike('route_path', "$pageRoute->route_path/%")->first();
                if ($detail) {
                    $segment = collect(explode('/', trim($detail->route_path, '/')))->first();
                    $pageRoute = PageRoute::query()->create([
                        'route_name' => "$detail->route_name - {$this->record->slug}",
                        'route_path' => str_replace($segment, $this->record->slug, $detail->route_path),
                        'route_method' => $detail->route_method,
                        'route_controller' => $detail->route_controller,
                        'route_action' => $detail->route_action,
                        'route_lang' => $this->record->lang_locale,
                        'is_active' => true,
                        'template' => $detail->template,
                        'page_id' => $this->record->id,
                        'generated' => 'auto',
                        'disable_auto_route' => $detail->disable_auto_route,
                    ]);
                }
                PageRouteUrls::query()->create([
                    'page_route_id' => $pageRoute->id,
                    'page_id' => $this->record->id,
                    'slug' => $this->record->slug,
                    'locale' => $this->record->lang_locale,
                ]);
            }
        }

        Cache::forget('localized_pages_definitions');
        Cache::forget('generated_routes_definitions');
        Cache::forget('localized_routes_definitions');
        Cache::forget('page_route_urls_definitions');
        if ($this->record->url_type === 'external') {
            Cache::forget('external_routes_definitions');
        }
        Artisan::call('route:clear');
        Artisan::call('optimize:clear');
    }

}
