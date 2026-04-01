<?php

if (!function_exists('localizedRoute')) {
    function localizedRoute(string $name, array $parameters = [], ?string $locale = null): string
    {
        return \App\Helpers\LocalizedRouteHelper::getPath($name, $parameters, $locale);
    }
}
