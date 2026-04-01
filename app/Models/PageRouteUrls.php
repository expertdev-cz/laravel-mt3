<?php

namespace App\Models;

use App\Helpers\LocalizedRouteHelper;
use App\Models\System\Page;
use App\Models\System\PageRoute;
use Datlechin\FilamentMenuBuilder\Concerns\HasMenuPanel;
use Datlechin\FilamentMenuBuilder\Contracts\MenuPanelable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class PageRouteUrls extends Model implements MenuPanelable
{
    use HasMenuPanel;

    protected  $fillable = ['page_route_id', 'page_id', 'slug', 'locale'];

    public function pageRoute(): BelongsTo
    {
        return $this->belongsTo(PageRoute::class);
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function getMenuPanelTitleColumn(): string
    {
        return 'slug';
    }

    public function getMenuPanelName(): string
    {
        return 'URL rout stránek';
    }

    public function getMenuPanelUrlUsing(): callable
    {
        return function (self $model): string {
            $model->loadMissing('pageRoute');
            $pageRoute = $model->pageRoute;
            if (!$pageRoute) {
                return '#';
            }

            return $pageRoute->disable_auto_route
                ? LocalizedRouteHelper::getPath($pageRoute->route_name)
                : LocalizedRouteHelper::getPath($pageRoute->route_name, [$model->slug]);
        };
    }

    public function getMenuPanelModifyQueryUsing(): callable
    {
        return function (Builder $query): Builder {
            $locale = self::resolveMenuLocale();

            if ($locale) {
                $query->where('locale', $locale);
            }

            return $query
                ->select('id', 'slug', 'page_route_id', 'locale')
                ->with('pageRoute');
        };
    }

    private static function resolveMenuLocale(): ?string
    {
        $menuId = request()->route('record');

        if (is_object($menuId) && method_exists($menuId, 'getKey')) {
            $menuId = $menuId->getKey();
        }

        if (blank($menuId)) {
            return app()->getLocale();
        }

        $location = DB::table(config('filament-menu-builder.tables.menu_locations', 'menu_locations'))
            ->where('menu_id', $menuId)
            ->value('location');

        if (is_string($location) && str_starts_with($location, 'header-')) {
            return substr($location, strlen('header-'));
        }

        return app()->getLocale();
    }
}
