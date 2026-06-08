<?php

namespace App\View\Components;

use Closure;
use Datlechin\FilamentMenuBuilder\Models\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Footer extends Component
{
    public function __construct(public $showText = true)
    {
        //
    }

    public function render(): View|Closure|string
    {
        $locale = app()->currentLocale();

        $footerMenus = [];
        foreach (['footer-1', 'footer-2', 'footer-3'] as $location) {
            $menu = Menu::location($location . '-' . $locale) ?? Menu::location($location);
            $footerMenus[$location] = $menu;
        }

        return view('components.footer.footer', [
            'footerMenus' => $footerMenus,
        ]);
    }
}
