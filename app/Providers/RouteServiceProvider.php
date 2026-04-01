<?php

namespace App\Providers;

use App\Http\Controllers\PagesController;
use App\Models\System\Page;
use App\Models\System\PageRoute;
use Exception;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\System\Redirect;
use App\Helpers\UrlPath;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            try {
                $this->loadFrontendRoutes();
            } catch (\Throwable $e) {
                \Log::warning('Skipping frontend DB routes: ' . $e->getMessage());
            }

            $this->loadRedirectRoutes();
            $this->loadArticleFallbackRoute();
        });


    }

    protected function loadRedirectRoutes(): void
    {
        if (app()->environment('testing')) {
            return;
        }

        try {
            if (Schema::hasTable('redirects')) {
                $redirects = Redirect::query()
                    ->where('is_active', true)
                    ->get(['source_path', 'target_path', 'status']);

                foreach ($redirects as $redirect) {
                    $source = ltrim(UrlPath::normalize($redirect->source_path), '/');
                    $target = UrlPath::normalize($redirect->target_path);
                    
                    Route::redirect($source, $target, $redirect->status);
                }
            }
        } catch (\Throwable $e) {
            \Log::warning('Could not load redirects: ' . $e->getMessage());
        }
    }

    protected function loadFrontendRoutes(): void
    {
        if (app()->environment('testing')) {
            return;
        }

        if (Schema::hasColumns('page_routes', ['generated', 'page_id'])) {
            // 1. NEJDŘÍV: Load page-specific routes with disable_auto_route=1 (konkrétní cesty typu /o-nas, /ionic)
            // Tyto musí být PRVNÍ, aby měly přednost před parametrickými routes
            $pageRoutes = Cache::rememberForever('localized_pages_definitions', function () {
                return Page::query()
                    ->where('pages.active', 1)
                    ->whereNotNull('pages.page_route_id')
                    ->whereNotNull('pages.slug')
                    ->join('page_routes', 'page_routes.id', '=', 'pages.page_route_id')
                    ->where('page_routes.generated', 'manual')
                    ->get(['pages.*']);
            });

            foreach ($pageRoutes as $page) {
                if ($page->pageRoute?->disable_auto_route == 1) {
                    $route = $page->pageRoute;
                    Route::middleware(['web'])
                        ->prefix($page->lang_locale !== 'cs' ? $page->lang_locale : '')
                        ->{$route->route_method}($page->slug, [
                            $route->route_controller,
                            $route->route_action
                        ])
                        ->name($page->lang_locale . '.' . Str::slug($route->route_name)."-$page->id");
                }
            }

            // 2. Load only external routes ( external - out of page routes system )
            $externalPageRoutes = Cache::rememberForever('external_routes_definitions', function () {
                return Page::query()
                    ->where('active', 1)
                    ->where('url_type', 'external')
                    ->whereNotNull('slug')
                    ->get();
            });
            foreach ($externalPageRoutes as $page) {
                Route::middleware(['web'])
                    ->prefix($page->lang_locale !== 'cs' ? $page->lang_locale : '')
                    ->get($page->slug, [PagesController::class, 'index'])
                    ->name($page->lang_locale . '.' . Str::slug($page->slug));
            }

            // 3. PAK: Load standard routes (parametrické routes typu /slovnicek-pojmu/{pojem})
            // Tyto musí být AŽ PO konkrétních cestách
            $routes = Cache::rememberForever('localized_routes_definitions', function () {
                return PageRoute::query()
                    ->where('is_active', 1)
                    ->where('disable_auto_route', 0)
                    ->where('generated', 'manual')
                    ->get();
            });
            $this->registerFrontendDbRoutes($routes);

            // 4. NAKONEC: Load auto-generated routes
            $generatedRoutes = Cache::rememberForever('generated_routes_definitions', function () {
                return PageRoute::query()
                    ->where('is_active', 1)
                    ->where('generated', 'auto')
                    ->whereNotNull('page_id')
                    ->get();
            });

            $this->registerFrontendDbRoutes($generatedRoutes);
        }
    }

    protected function registerFrontendDbRoutes(Collection $routes): void
    {
        $sortedRoutes = $routes
            ->sortByDesc(fn (PageRoute $route) => $this->routePathPriority((string) $route->route_path))
            ->values();

        foreach ($sortedRoutes as $route) {
            Route::middleware(['web'])
                ->prefix($route->route_lang !== 'cs' ? $route->route_lang : '')
                ->{$route->route_method}($route->route_path, [
                    $route->route_controller,
                    $route->route_action
                ])
                ->name($route->route_lang . '.' . Str::slug($route->route_name));
        }
    }

    protected function routePathPriority(string $routePath): int
    {
        $path = trim($routePath, '/');

        if ($path === '') {
            return 10_000;
        }

        $segments = array_values(array_filter(explode('/', $path), fn (string $segment) => $segment !== ''));
        $segmentCount = count($segments);
        $dynamicCount = 0;

        foreach ($segments as $segment) {
            if (preg_match('/^\{[^}]+\}$/', $segment) === 1) {
                $dynamicCount++;
            }
        }

        $staticCount = $segmentCount - $dynamicCount;
        $allDynamicPenalty = $dynamicCount === $segmentCount ? -1_000 : 0;

        // Prefer static segments and longer routes; demote full wildcard patterns.
        return ($staticCount * 100) + ($segmentCount * 10) - ($dynamicCount * 5) + $allDynamicPenalty;
    }

    /**
     * Registrace fallback route pro přesměrování článků
     * Tato metoda musí být volána AŽ PO loadFrontendRoutes(),
     * aby page routes měly vždy přednost před článkovým redirectem.
     */
    protected function loadArticleFallbackRoute(): void
    {
        Route::fallback(function(Request $request) {
            $path = $request->path();
            $locale = app()->getLocale();
            
            // Ignoruj cesty s více než jedním segmentem nebo speciální prefixery
            if (substr_count($path, '/') > 0 || 
                in_array($request->segment(1), ['admin', 'api', 'livewire', 'assets', 'css', 'js', 'storage', 'vendor'])) {
                abort(404);
            }
            
            // Odstraň lokalizační prefix pokud existuje
            $slug = $path;
            if ($locale !== 'cs' && str_starts_with($path, $locale . '/')) {
                $slug = substr($path, strlen($locale) + 1);
            }
            
            // Zkontroluj existenci článku
            $article = \App\Models\Content\Article::query()
                ->where('lang_locale', '=', $locale)
                ->where('active', '=', 1)
                ->where('publish_time', '<', new \DateTime())
                ->where('slug', '=', $slug)
                ->first();
            
            if ($article) {
                $baseSlug = trim(\App\Services\Content\ArticleService::getMainArticlesSlug() ?? 'blog', '/');
                $targetPath = $locale !== 'cs' 
                    ? "/{$locale}/{$baseSlug}/{$slug}"
                    : "/{$baseSlug}/{$slug}";
                return redirect($targetPath, 301);
            }
            
            abort(404);
        });
    }


}
