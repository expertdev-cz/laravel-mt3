<?php

namespace App\Models\System;

use App\Helpers\LocalizedRouteHelper;
use App\Models\PageRouteUrls;
use App\Models\System\Page;
use Datlechin\FilamentMenuBuilder\Concerns\HasMenuPanel;
use Datlechin\FilamentMenuBuilder\Contracts\MenuPanelable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class PageRoute extends Model implements MenuPanelable
{
    use HasFactory, SoftDeletes, HasMenuPanel;

    protected $fillable = [
        'route_name',
        'route_path',
        'route_method',
        'route_action',
        'route_controller',
        'route_middleware',
        'route_lang',
        'is_active',
        'disable_auto_route',
        'template',
        'page_id',
        'generated',
    ];

    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function pageRouteUrl(): HasMany
    {
        return $this->hasMany(PageRouteUrls::class, 'page_route_id');
    }

    public function getMenuPanelTitleColumn(): string
    {
        return 'route_name';
    }

    public function getMenuPanelName(): string
    {
        return 'Routy stránek';
    }

    public function getMenuPanelUrlUsing(): callable
    {
        return fn (self $model) => LocalizedRouteHelper::getPath($model->route_name);
    }

    public function getMenuPanelModifyQueryUsing(): callable
    {
        return function ($query) {
            $locale = self::resolveMenuLocale();

            if ($locale) {
                $query->where('route_lang', $locale);
            }

            return $query->select('id', 'route_name', 'route_path', 'route_lang');
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
