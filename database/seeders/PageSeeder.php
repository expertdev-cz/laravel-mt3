<?php

namespace Database\Seeders;

use App\Models\PageRouteUrls;
use App\Models\System\Page;
use App\Models\System\PageRoute;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['cs', 'en'] as $locale) {
            $homeRoute = PageRoute::query()
                ->where('route_name', 'homepage')
                ->where('route_lang', $locale)
                ->first();

            $blogIndexRoute = PageRoute::query()
                ->where('route_name', 'blog.index')
                ->where('route_lang', $locale)
                ->first();

            $blogDetailRoute = PageRoute::query()
                ->where('route_name', 'blog.detail')
                ->where('route_lang', $locale)
                ->first();

            if (!$homeRoute || !$blogIndexRoute || !$blogDetailRoute) {
                continue;
            }

            $blogIndexPageRouteUrlId = PageRouteUrls::query()
                ->where('page_route_id', $blogIndexRoute->getKey())
                ->where('locale', $locale)
                ->value('id');

            $homePage = Page::query()->updateOrCreate(
                [
                    'lang_locale' => $locale,
                    'slug' => '/',
                ],
                [
                    'type' => 'homepage',
                    'title' => $locale === 'cs' ? 'Domovská stránka' : 'Homepage',
                    'active' => 1,
                    'content' => [
                        'heading' => $locale === 'cs' ? 'Vítej na webu' : 'Welcome to the site',
                        'body' => $locale === 'cs'
                            ? '<p>Toto je výchozí obsah domovské stránky pro testování po instalaci.</p>'
                            : '<p>This is default homepage content for post-install testing.</p>',
                        'button' => [
                            'buttonText' => $locale === 'cs' ? 'Přejít na blog' : 'Go to blog',
                            'buttonLink' => [
                                'pageRouteUrl' => $blogIndexPageRouteUrlId,
                                'slug' => null,
                                'is_external' => false,
                            ],
                        ],
                    ],
                    'seo' => [
                        'title' => $locale === 'cs' ? 'Domovská stránka' : 'Homepage',
                        'description' => $locale === 'cs' ? 'Výchozí domovská stránka.' : 'Default homepage.',
                    ],
                    'page_route_id' => $homeRoute->getKey(),
                    'url_type' => 'internal',
                ]
            );

            $homeRoute->update(['page_id' => $homePage->getKey()]);

            $blogPage = Page::query()->updateOrCreate(
                [
                    'lang_locale' => $locale,
                    'slug' => 'blog',
                ],
                [
                    'type' => 'articles',
                    'title' => 'Blog',
                    'active' => 1,
                    'content' => [
                        'heading' => $locale === 'cs' ? 'Naše články' : 'Our articles',
                    ],
                    'seo' => [
                        'title' => 'Blog',
                        'description' => $locale === 'cs' ? 'Výchozí stránka blogu.' : 'Default blog page.',
                    ],
                    'page_route_id' => $blogIndexRoute->getKey(),
                    'url_type' => 'internal',
                ]
            );

            $blogIndexRoute->update(['page_id' => $blogPage->getKey()]);
            $blogDetailRoute->update(['page_id' => $blogPage->getKey()]);
        }
    }
}
