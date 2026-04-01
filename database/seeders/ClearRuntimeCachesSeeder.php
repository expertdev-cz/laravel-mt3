<?php

namespace Database\Seeders;

use App\Helpers\LocalizedRouteHelper;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class ClearRuntimeCachesSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            'default_locale',
            'localized_routes',
            'localized_pages_definitions',
            'external_routes_definitions',
            'localized_routes_definitions',
            'generated_routes_definitions',
        ] as $cacheKey) {
            Cache::forget($cacheKey);
        }

        LocalizedRouteHelper::clearCache();
    }
}
