<?php

namespace App\Helpers;

use App\Models\System\PageRoute;
use App\Services\System\UrlService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;

class LocalizedRouteHelper
{
    public static function getPath(string $name, array $parameters = [], ?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();

        $routes = self::getCachedRoutes();

        $route = $routes[$name][$locale] ?? null;

        if (!$route) {
            $defaultLocale = UrlService::defaultLang();
            $route = $routes[$name][$defaultLocale] ?? null;

            if (!$route) {
                return '#';
            }
        }

        $path = $route['route_path'];

        if (str_contains($path, '{')) {
            preg_match_all('/\{([^}]+)}/', $path, $matches);
            $placeholders = $matches[1] ?? [];

            foreach ($placeholders as $index => $placeholder) {
                if (array_key_exists($placeholder, $parameters)) {
                    $value = $parameters[$placeholder];
                } elseif (array_key_exists($index, $parameters)) {
                    $value = $parameters[$index];
                } else {
                    continue;
                }

                $path = str_replace('{' . $placeholder . '}', (string) $value, $path);
            }
        }

        return URL::to($path);
    }

    protected static function getCachedRoutes()
    {
        return Cache::rememberForever('localized_routes', function () {
            return PageRoute::all()
                ->groupBy('route_name')
                ->map(function ($routes) {
                    return $routes->keyBy('route_lang');
                })->toArray();
        });
    }

    public static function clearCache(): void
    {
        Cache::forget('localized_routes');
    }
}
