<?php

namespace App\Services\System;

use App\Helpers\LocalizedRouteHelper;
use App\Models\System\Language;
use Illuminate\Support\Facades\Cache;

class UrlService
{
    public static array $skipSlugs = ['admin','livewire'];

    public static function defaultLang(): string
    {
        return Cache::rememberForever('default_locale', function () {
            return Language::query()
                ->where('default', 1)
                ->value('locale') ?? 'cs';
        });
    }

    /**
     * Extract a slug from a URL
     *
     * @param string $url The URL to extract the slug from
     * @param bool $getLastPart Whether to return the last part of the URL path
     * @param bool $canSetLang Whether to set the application locale based on the URL
     * @return bool|string The extracted slug, or false if the URL should be skipped
     */
    public static function getSlugFromUrl(string $url, bool $getLastPart = false, bool $canSetLang = true): bool|string
    {
        $url = self::removeQueryParameters($url);

        if ($url === '/') {
            return $url;
        }

        if ($url === '/' . self::defaultLang()) {
            return '/';
        }

        $pathSegments = explode('/', ltrim($url, '/'));

        $slug = self::extractMainSlug($pathSegments, $canSetLang);

        if (in_array($slug, self::$skipSlugs)) {
            return false;
        }

        if ($getLastPart && !empty($pathSegments)) {
            $slug = collect($pathSegments)->filter()->last();
            $slug = self::removeQueryParameters($slug);
        }

        return $slug;
    }

    /**
     * Remove query parameters from a URL or path segment
     *
     * @param string $url The URL or path segment
     * @return string The URL or path segment without query parameters
     */
    private static function removeQueryParameters(string $url): string
    {
        $parts = explode('?', $url);
        return $parts[0];
    }

    /**
     * Extract the main slug from URL path segments
     *
     * @param array $pathSegments The URL path segments
     * @param bool $canSetLang Whether to set the application locale
     * @return string The extracted main slug
     */
    private static function extractMainSlug(array $pathSegments, bool $canSetLang): string
    {
        if (empty($pathSegments)) {
            return '';
        }

        $slug = $pathSegments[0];

        if (in_array($slug, Language::getAllowedLanguageLocale())) {
            if (isset($pathSegments[1])) {
                $slug = $pathSegments[1];

                if ($canSetLang) {
                    app()->setLocale($pathSegments[0]);
                    session(['setLang' => $pathSegments[0]]);
                }
            }
        }

        return $slug;
    }

    public static function getLocaleSlugPrefix(bool $leftSlash=true, bool $rightSlash=false): string
    {
        if (app()->currentLocale()==self::defaultLang()){
            return '';
        }else{
            $ret = app()->currentLocale();

            if ($leftSlash)
                $ret = '/'. $ret;

            if ($rightSlash)
                $ret .= '/';

            return $ret;
        }
    }

    public static function getSamePageInDiffLangRedirUrl(string $actualUrl, string $selectLocale): string{
        $wantedPage = PageService::getSamePageInDiffLang($actualUrl,$selectLocale);
        $defaultLocale = self::defaultLang();

        if ($wantedPage){
            $slug = trim((string) $wantedPage->slug, '/');

            if ($slug === '') {
                return $wantedPage->lang_locale === $defaultLocale
                    ? '/'
                    : '/'.$wantedPage->lang_locale;
            }

            if ($wantedPage->lang_locale !== $defaultLocale) {
                return '/'.$wantedPage->lang_locale.'/'.$slug;
            }

            return '/'.$slug;
        }else{
            return $selectLocale === $defaultLocale
                ? '/'
                : '/'.$selectLocale;
        }
    }

}
