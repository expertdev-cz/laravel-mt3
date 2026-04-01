<?php

namespace App\View\Components;

use App\Services\System\MenuService;
use App\Services\System\UrlService;
use Closure;
use Datlechin\FilamentMenuBuilder\Models\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HeaderMenu extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string{
        $locale = app()->currentLocale();
        $location = 'header-' . $locale;

        $menu = Menu::location($location);
        if (!$menu) {
            // Fallback na puvodni lokaci, pokud jeste neni vytvorena locale verze menu.
            $menu = Menu::location('header');
        }

        $items = $menu?->menuItems ?? collect();
        $locale = app()->currentLocale();

        if ($items instanceof \Illuminate\Support\Collection) {
            $items = $items
                ->whereIn('lang_locale', [null, '', $locale])
                ->values();
        }

        return view('components.header.header-menu',[
            //'menuItems'=>MenuService::getMenuNested(),
            'menuItems'=> $items,
            'slugLocale'=>UrlService::getLocaleSlugPrefix()
        ]);
    }
}
