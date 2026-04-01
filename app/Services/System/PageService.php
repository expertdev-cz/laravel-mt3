<?php

namespace App\Services\System;

use App\Helpers\IdsFromDbConfigHelper;
use App\Helpers\PageTypesHelper;
use App\Models\System\Page;
use App\Models\System\PageRoute;
use App\Models\System\Settings;
use Illuminate\View\View;

class PageService
{
    //private Page|null $selectedPage = null;
    protected static array $prefixedTemplateMapCache = [];

    public static function getPageBySlugAndLocale(string $slug, string $locale, ?string $expectedType = null, array $excludeTypes = []){
        $query = Page::query()
            ->where('slug','=',$slug)
            ->where('lang_locale','=',$locale)
            ->where('active','=',1);
        
        if ($expectedType) {
            $query->where('type', '=', $expectedType);
        }
        
        if (!empty($excludeTypes)) {
            $query->whereNotIn('type', $excludeTypes);
        }
        
        return $query->first();
    }

    public static function getPageByTypeAndLocale(string $type,string $locale){
        return Page::query()
            ->where('type','=',$type)
            ->where('lang_locale','=',$locale)
            ->where('active','=',1)
            ->first();
    }

    public static function getActivePageByUrlAndLocale(string $url,string $locale,bool $canSetLocale=true){
        if ($url=='/'.$locale){
            $url='/';
        }

        $mainSlug = UrlService::getSlugFromUrl($url, true);

        if ($mainSlug){
            // Určení očekávaného typu stránky podle struktury URL
            $pathSegments = array_filter(explode('/', trim(parse_url($url, PHP_URL_PATH), '/')));
            
            // Odstraň locale prefix pokud existuje
            if (count($pathSegments) > 0 && $pathSegments[0] === $locale && $locale !== 'cs') {
                array_shift($pathSegments);
                $pathSegments = array_values($pathSegments); // reindex
            }
            
            $expectedType = null;
            $excludeTypes = [];
            $prefixedTemplateMap = self::getPrefixedTemplateMap($locale);
            
            // Pokud URL začíná známým prefixem z route definic, vyžaduj odpovídající template/type.
            if (count($pathSegments) > 1 && isset($prefixedTemplateMap[$pathSegments[0]])) {
                $expectedType = $prefixedTemplateMap[$pathSegments[0]];
            }
            // Pokud URL NEMÁ prefix (jednoslovný slug), vylučuj typy určené pro prefixed detail URL.
            elseif (count($pathSegments) === 1) {
                $excludeTypes = array_values(array_unique(array_filter(array_values($prefixedTemplateMap))));
            }
            
            $page = self::getPageBySlugAndLocale($mainSlug, $locale, $expectedType, $excludeTypes);
            $firstSlug = UrlService::getSlugFromUrl($url);
            if ($page) {
                return $page;
            } else if ($firstSlug && $firstSlug !== $mainSlug) {
                $page = self::getPageBySlugAndLocale($firstSlug, $locale, $expectedType, $excludeTypes);
                if ($page) {
                    if ($canSetLocale){
                        app()->setLocale($page->lang_locale);
                        session(['setLang' => $page->lang_locale]);
                    }
                    return $page;
                }
            } else {
                $query = Page::query()
                    ->where('slug','=',$mainSlug)
                    ->where('active','=',1);
                
                if ($expectedType) {
                    $query->where('type', '=', $expectedType);
                }
                
                if (!empty($excludeTypes)) {
                    $query->whereNotIn('type', $excludeTypes);
                }
                
                $page = $query->first();

                if ($page) {
                    if ($canSetLocale){
                        app()->setLocale($page->lang_locale);
                        session(['setLang' => $page->lang_locale]);
                    }

                    return $page;
                }
            }
        }

        return false;
    }

    public function getPageView(string $url, string $locale, array $optDataToTemplate = [], bool $loadSettingsData = true): View
    {
        $page = $this->getActivePageByUrlAndLocale($url, $locale);

        if (!$page) {
            abort(404);
        }

        // Validace: Pokud URL obsahuje více než jeden segment, zkontroluj že stránka odpovídá očekávanému template
        $urlSegments = array_filter(explode('/', trim(parse_url($url, PHP_URL_PATH), '/')));
        $locale = app()->currentLocale();
        
        // Odstraň locale prefix pokud existuje
        if (count($urlSegments) > 0 && $urlSegments[0] === $locale && $locale !== 'cs') {
            array_shift($urlSegments);
        }
        
        // Pokud URL má více segmentů (např. /slovnicek-pojmu/ionic)
        if (count($urlSegments) > 1) {
            $firstSegment = $urlSegments[0];
            
            // Mapování URL prefixů na očekávané template z aktivních DB routes.
            $expectedTemplates = self::getPrefixedTemplateMap($locale);
            
            // Pokud první segment vyžaduje specifický template a stránka ho nemá → 404
            if (isset($expectedTemplates[$firstSegment]) && $page->type !== $expectedTemplates[$firstSegment]) {
                abort(404);
            }
        }

        $templateName = $page->type;

        $viewData = [
            'page' => $page,
            'subSlug' => false,
            'globalSettings' => [],
            'seo' => $this->prepareSeoData($page), // <-- PŘIDEJ TOTO
        ];

        if ($loadSettingsData) {
            $settings = Settings::whereId(IdsFromDbConfigHelper::$settingsRecordId)->get()->first();
            if ($settings) {
                $viewData['globalSettings'] = $settings->content;
            }
        }

        if (in_array($page->type, PageTypesHelper::$pageWithAllowedSubpages)) {
            $subSlug = UrlService::getSlugFromUrl($url, true);

            if ($subSlug != $page->slug && !is_numeric($subSlug)) {
                if (isset(PageTypesHelper::$typesToSubpagesTemplatesMap[$page->type])) {
                    $templateName = PageTypesHelper::$typesToSubpagesTemplatesMap[$page->type];
                }
                $viewData['subSlug'] = $subSlug;
            }
        }

        return view('pages.' . $templateName, array_merge($viewData, $optDataToTemplate));
    }

    // PŘIDEJ TUTO NOVOU METODU
    protected function prepareSeoData($page): array
    {
        // Načti SEO data z administrace (předpokládám, že jsou v content nebo seo sloupci)
        $seoFromAdmin = $page->seo ?? $page->content['seo'] ?? []; 
        
        return [
            'title' => $seoFromAdmin['title'] ?? $page->title,
            'description' => $seoFromAdmin['description'] ?? '',
            'keywords' => $seoFromAdmin['keywords'] ?? '',
            'robots' => $seoFromAdmin['robots'] ?? 'index, follow',
            'og_image' => $seoFromAdmin['og_image'] ?? null,
            'og_title' => $seoFromAdmin['og_title'] ?? null,
            'og_description' => $seoFromAdmin['og_description'] ?? null,
        ];
    }

    protected static function getPrefixedTemplateMap(string $locale): array
    {
        if (isset(self::$prefixedTemplateMapCache[$locale])) {
            return self::$prefixedTemplateMapCache[$locale];
        }

        $defaultLocale = UrlService::defaultLang();

        $routes = PageRoute::query()
            ->where('is_active', 1)
            ->whereIn('route_lang', array_values(array_unique([$locale, $defaultLocale])))
            ->get(['route_path', 'template', 'route_lang']);

        $map = [];

        foreach ($routes as $route) {
            $template = (string) ($route->template ?? '');
            if ($template === '') {
                continue;
            }

            $path = trim((string) $route->route_path, '/');
            if ($path === '') {
                continue;
            }

            $segments = array_values(array_filter(explode('/', $path), fn (string $segment) => $segment !== ''));
            if (count($segments) < 2) {
                continue;
            }

            $firstSegment = $segments[0];
            if (preg_match('/^\{[^}]+\}$/', $firstSegment) === 1) {
                continue;
            }

            // Prefer routes matching current locale over default locale.
            if (!isset($map[$firstSegment]) || $route->route_lang === $locale) {
                $map[$firstSegment] = $template;
            }
        }

        self::$prefixedTemplateMapCache[$locale] = $map;

        return $map;
    }
    public static function getMainSubpageSlug(string $type):string{
        $data = Page::query()
            ->where('lang_locale','=',app()->currentLocale())
            ->where('active','=',1)
            ->where('type','=',$type)
            ->limit(1)
            ->get(['slug'])
            ->first();
        if ($data){
            return UrlService::getLocaleSlugPrefix(false,true).$data->slug;
        }
        return '';
    }

    public static function getPageByTypeAndLang(string $type,string $lang){
        return Page::query()
            ->where('type','=',$type)
            ->where('lang_locale','=',$lang)
            ->where('active','=',1)
            ->first();
    }

    public static function getSamePageInDiffLang(string $actualUrl, string $wantedLang){
        $page = self::getPageBySlugAndLocale(
            UrlService::getSlugFromUrl($actualUrl,false,false),
            app()->currentLocale());

        if (!$page){
            $page = self::getPageBySlugAndLocale(
                UrlService::getSlugFromUrl($actualUrl,false,false),
                UrlService::defaultLang());
        }

        if ($page){
            return self::getPageByTypeAndLocale($page->type,$wantedLang);
        }

        return false;
    }

    public static function checkIfIsMobile():bool{
        $useragent = request()->userAgent();

        if ($useragent){
            if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
                return true;
            }
        }

        return false;
    }

    public static function getLandingPageSeoListByCurrentLocale()
    {
        return Page::query()
            ->where('type', 'landingpageseo')
            ->where('active', true)
            ->where('lang_locale', app()->currentLocale())
            ->orderByDesc('created_at')
            ->get();
    }

    public static function getTermsListByCurrentLocale()
    {
        return Page::query()
            ->where('type', 'term')
            ->where('active', true)
            ->where('lang_locale', app()->currentLocale())
            ->orderByDesc('created_at')
            ->get();
    }
}
