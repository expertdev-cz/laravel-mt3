<?php

if (!function_exists('localizedRoute')) {
    function localizedRoute(string $name, array $parameters = [], ?string $locale = null): string
    {
        return \App\Helpers\LocalizedRouteHelper::getPath($name, $parameters, $locale);
    }
}

if (!function_exists('formatPageLink')) {
    function formatPageLink(mixed $linkData): string
    {
        static $pageRouteUrlCache = [];
        static $blogSlugCache = [];

        if (empty($linkData)) {
            return '#';
        }

        if (is_string($linkData)) {
            return $linkData;
        }

        if (is_array($linkData) && !empty($linkData['is_external']) && !empty($linkData['slug'])) {
            return $linkData['slug'];
        }

        if (is_array($linkData) && isset($linkData['pageRouteUrl'])) {
            $pageRouteUrlState = $linkData['pageRouteUrl'];
            $pageRouteUrlId = is_array($pageRouteUrlState)
                ? ($pageRouteUrlState['id'] ?? $pageRouteUrlState['value'] ?? null)
                : $pageRouteUrlState;

            $cacheKey = !empty($pageRouteUrlId) ? (string) $pageRouteUrlId : '';
            $pageRouteUrl = null;

            if ($cacheKey !== '') {
                if (array_key_exists($cacheKey, $pageRouteUrlCache)) {
                    $pageRouteUrl = $pageRouteUrlCache[$cacheKey];
                } else {
                    $pageRouteUrl = app('db')->table('page_route_urls')
                        ->leftJoin('page_routes', 'page_routes.id', '=', 'page_route_urls.page_route_id')
                        ->where('page_route_urls.id', $pageRouteUrlId)
                        ->select([
                            'page_route_urls.id',
                            'page_route_urls.slug',
                            'page_route_urls.locale',
                            'page_routes.route_name',
                            'page_routes.route_path',
                        ])
                        ->first();

                    $pageRouteUrlCache[$cacheKey] = $pageRouteUrl;
                }
            }

            if (!$pageRouteUrl && empty($linkData['slug'])) {
                return '#';
            }

            if (!$pageRouteUrl && !empty($linkData['slug'])) {
                $slug = rawurlencode($linkData['slug']);

                return '/' . $slug;
            }

            if ($pageRouteUrl) {
                $slug = !empty($linkData['slug']) ? $linkData['slug'] : $pageRouteUrl->slug;
                $routeName = $pageRouteUrl->route_name ?? null;
                $routePath = $pageRouteUrl->route_path ?? null;

                if (empty($routeName)) {
                    return '#';
                }

                $parameters = ['slug' => $slug];

                if (is_string($routePath) && str_contains($routePath, '{blog_slug}')) {
                    $locale = $pageRouteUrl->locale ?? app()->getLocale();

                    if (!array_key_exists($locale, $blogSlugCache)) {
                        $blogSlugCache[$locale] = app('db')->table('page_route_urls')
                            ->join('page_routes', 'page_routes.id', '=', 'page_route_urls.page_route_id')
                            ->where('page_routes.route_name', 'blog.index')
                            ->where('page_route_urls.locale', $locale)
                            ->value('page_route_urls.slug');
                    }

                    $blogSlug = $blogSlugCache[$locale] ?? null;

                    if (!empty($blogSlug)) {
                        $parameters['blog_slug'] = $blogSlug;
                    }
                }

                return localizedRoute($routeName, $parameters);
            }
        }

        return '#';
    }
}
