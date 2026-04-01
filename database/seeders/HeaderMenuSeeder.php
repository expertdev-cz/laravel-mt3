<?php

namespace Database\Seeders;

use App\Models\System\Page;
use App\Models\System\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HeaderMenuSeeder extends Seeder
{
    public function run(): void
    {
        $menusTable = (string) config('filament-menu-builder.tables.menus', 'menus');
        $menuItemsTable = (string) config('filament-menu-builder.tables.menu_items', 'menu_items');
        $menuLocationsTable = (string) config('filament-menu-builder.tables.menu_locations', 'menu_locations');

        foreach ($this->getActiveLocales() as $locale) {
            $this->seedLocaleMenu(
                menusTable: $menusTable,
                menuItemsTable: $menuItemsTable,
                menuLocationsTable: $menuLocationsTable,
                menuName: 'Main Header ' . strtoupper($locale),
                menuLocation: 'header-' . $locale,
                locale: $locale,
                items: $this->getDefaultItemsForLocale($locale),
            );
        }
    }

    private function getActiveLocales(): array
    {
        if (!Schema::hasTable('languages')) {
            return ['cs', 'en'];
        }

        $locales = Language::query()
            ->where('active', 1)
            ->orderBy('id')
            ->pluck('locale')
            ->toArray();

        return !empty($locales) ? $locales : ['cs', 'en'];
    }

    private function getDefaultItemsForLocale(string $locale): array
    {
        $homeTitle = $locale === 'cs' ? 'Domu' : 'Home';
        $blogSlug = Page::query()
            ->where('lang_locale', $locale)
            ->where('type', 'articles')
            ->value('slug') ?? 'blog';

        $blogUrl = '/' . ltrim((string) $blogSlug, '/');

        return [
            ['title' => $homeTitle, 'url' => '/', 'order' => 1],
            ['title' => 'Blog', 'url' => $blogUrl, 'order' => 2],
        ];
    }

    private function seedLocaleMenu(
        string $menusTable,
        string $menuItemsTable,
        string $menuLocationsTable,
        string $menuName,
        string $menuLocation,
        string $locale,
        array $items,
    ): void {
        DB::table($menusTable)->updateOrInsert(
            ['name' => $menuName],
            [
                'is_visible' => 1,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        $menu = DB::table($menusTable)->where('name', $menuName)->first();
        if (!$menu) {
            return;
        }

        DB::table($menuLocationsTable)->updateOrInsert(
            ['location' => $menuLocation],
            [
                'menu_id' => $menu->id,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        foreach ($items as $item) {
            DB::table($menuItemsTable)->updateOrInsert(
                [
                    'menu_id' => $menu->id,
                    'parent_id' => null,
                    'title' => $item['title'],
                    'lang_locale' => $locale,
                ],
                [
                    'url' => $item['url'],
                    'linkable_type' => null,
                    'linkable_id' => null,
                    'target' => '_self',
                    'order' => $item['order'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
