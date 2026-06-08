<?php

namespace App\View\Components;

use App\Models\System\Page;
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

        $pageUrls = Page::query()
            ->whereIn('type', ['authorized-access-login', 'authorized-access-register', 'inquiry'])
            ->where('lang_locale', $locale)
            ->where('active', 1)
            ->get(['type', 'slug'])
            ->keyBy('type');

        $apLoginUrl    = '/' . ($pageUrls['authorized-access-login']?->slug    ?? 'autorizovany-pristup/prihlaseni');
        $apRegisterUrl = '/' . ($pageUrls['authorized-access-register']?->slug ?? 'autorizovany-pristup/registrace');
        $inquiryUrl    = '/' . ($pageUrls['inquiry']?->slug                    ?? 'napiste-nam');

        return view('components.footer.footer', [
            'footerMenus'   => $footerMenus,
            'apLoginUrl'    => $apLoginUrl,
            'apRegisterUrl' => $apRegisterUrl,
            'inquiryUrl'    => $inquiryUrl,
        ]);
    }
}
