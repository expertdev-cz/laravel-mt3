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
                            'page_routes.route_name',
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

                if (empty($routeName)) {
                    return '#';
                }

                return localizedRoute($routeName, [$slug]);
            }
        }

        return '#';
    }
}
