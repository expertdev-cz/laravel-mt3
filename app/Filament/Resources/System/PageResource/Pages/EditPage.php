<?php

namespace App\Filament\Resources\System\PageResource\Pages;

use App\Filament\Resources\System\PageResource;
use App\Models\PageRouteUrls;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use App\Models\System\PageRoute;

class EditPage extends EditRecord
{
    protected static ?string $title = 'Editace stránky';
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->requiresConfirmation()
                ->after(function () {
                    $this->clearPageCachesOnRemoval();
                }),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $this->normalizeLegacySingleSelectStates($data);
    }

    protected function afterDelete(): void
    {
        $this->clearPageCachesOnRemoval();
    }

    protected function afterForceDelete(): void
    {
        $this->clearPageCachesOnRemoval();
    }

    private function clearPageCachesOnRemoval(): void
    {
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

    private function normalizeLegacySingleSelectStates(array $data): array
    {
        $singleSelectKeys = [
            'pageRouteUrl',
            'pageRoute',
            'page_route_id',
            'url_type',
            'type',
            'route_method',
            'route_controller',
            'route_action',
            'route_lang',
            'alignment',
            'imagePosition',
            'referenceType',
            'heading',
            'rating',
        ];

        $normalize = function (mixed $value, ?string $key = null) use (&$normalize, $singleSelectKeys): mixed {
            if (! is_array($value)) {
                return $value;
            }

            foreach ($value as $childKey => $childValue) {
                $value[$childKey] = $normalize($childValue, is_string($childKey) ? $childKey : null);
            }

            if (! in_array($key, $singleSelectKeys, true)) {
                return $value;
            }

            if (array_key_exists('id', $value) && (is_scalar($value['id']) || $value['id'] === null)) {
                return $value['id'];
            }

            if (array_key_exists('value', $value) && (is_scalar($value['value']) || $value['value'] === null)) {
                return $value['value'];
            }

            if (array_is_list($value) && count($value) === 1) {
                $first = $value[0] ?? null;

                if (is_scalar($first) || $first === null) {
                    return $first;
                }
            }

            return $value;
        };

        return $normalize($data);
    }

    protected function afterSave(): void
    {
        if ($this->record->wasChanged('slug') && $this->record->slug) {
            $pageRoute = PageRoute::query()->where('page_id', $this->record->id)->first();

            if ($pageRoute) {
                $pageRoute->route_path = '/' . $this->record->slug;
                $pageRoute->save();
            }
        }
        if ($this->record->page_route_id && $this->record->slug) {
            PageRouteUrls::query()->updateOrCreate([
                'page_id' => $this->record->id,
                'locale' => $this->record->lang_locale,
            ], [
                'page_id' => $this->record->id,
                'page_route_id' => $this->record->page_route_id,
                'slug' => $this->record->slug,
                'locale' => $this->record->lang_locale,
            ]);
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
