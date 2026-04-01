<?php

namespace Database\Seeders;

use App\Models\System\PageRoute;
use Illuminate\Database\Seeder;

class PageRouteSeeder extends Seeder
{
    public function run(): void
    {
        foreach (["cs", "en"] as $locale) {
            // Homepage route zůstává /
            PageRoute::query()->updateOrCreate(
                [
                    'route_name' => 'homepage',
                    'route_lang' => $locale,
                ],
                [
                    'route_path' => '/',
                    'route_method' => 'get',
                    'route_action' => 'index',
                    'route_controller' => 'App\\Http\\Controllers\\PagesController',
                    'route_middleware' => null,
                    'is_active' => 1,
                    'disable_auto_route' => 0,
                    'template' => 'homepage',
                    'generated' => 'manual',
                ]
            );

            // Blog index route: /blog
            PageRoute::query()->updateOrCreate(
                [
                    'route_name' => 'blog.index',
                    'route_lang' => $locale,
                ],
                [
                    'route_path' => '/blog',
                    'route_method' => 'get',
                    'route_action' => 'index',
                    'route_controller' => 'App\\Http\\Controllers\\ArticlesController',
                    'route_middleware' => null,
                    'is_active' => 1,
                    'disable_auto_route' => 0,
                    'template' => 'articles',
                    'generated' => 'manual',
                ]
            );

            // Blog detail route: /{blog_slug}/{slug}
            PageRoute::query()->updateOrCreate(
                [
                    'route_name' => 'blog.detail',
                    'route_lang' => $locale,
                ],
                [
                    'route_path' => '{blog_slug}/{slug}',
                    'route_method' => 'get',
                    'route_action' => 'detail',
                    'route_controller' => 'App\\Http\\Controllers\\ArticlesController',
                    'route_middleware' => null,
                    'is_active' => 1,
                    'disable_auto_route' => 0,
                    'template' => 'article-detail',
                    'generated' => 'manual',
                ]
            );

            // Ostatní routy: pouze /{slug}
            // Pokud budete mít další stránky, přidejte je zde podobně:
            // PageRoute::query()->updateOrCreate([
            //     'route_name' => 'somepage',
            //     'route_lang' => $locale,
            // ], [
            //     'route_path' => '{slug}',
            //     ...
            // ]);
        }
    }
}
