<?php

namespace App\Providers;

use Datlechin\FilamentMenuBuilder\Models\MenuItem;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        View::addNamespace('errors', resource_path('views/errors'));

        MenuItem::creating(function (MenuItem $menuItem): void {
            if (blank($menuItem->lang_locale)) {
                $menuItem->lang_locale = app()->getLocale();
            }
        });
    }
}
