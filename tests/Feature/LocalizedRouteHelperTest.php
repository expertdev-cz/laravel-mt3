<?php

namespace Tests\Feature;

use App\Helpers\LocalizedRouteHelper;
use App\Models\System\PageRoute;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocalizedRouteHelperTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a default language
        \App\Models\System\Language::factory()->create([
            'locale' => 'en',
            'default' => 1,
            'active' => 1,
        ]);

        // Clear the cache to ensure we're using the language we just created
        \Illuminate\Support\Facades\Cache::forget('default_locale');
        \Illuminate\Support\Facades\Cache::forget('localized_routes');
    }

    /**
     * Test that getPath returns the correct URL for a given route name and locale.
     */
    public function test_get_path_returns_correct_url(): void
    {
        // Create a route with English locale
        $routeEn = PageRoute::factory()->create([
            'route_name' => 'test.route',
            'route_path' => 'test-route',
            'route_lang' => 'en',
            'is_active' => true,
        ]);

        // Create the same route with Czech locale
        $routeCs = PageRoute::factory()->create([
            'route_name' => 'test.route',
            'route_path' => 'testovaci-cesta',
            'route_lang' => 'cs',
            'is_active' => true,
        ]);

        // Test English route
        app()->setLocale('en');
        $path = LocalizedRouteHelper::getPath('test.route');
        $this->assertEquals(url('test-route'), $path);

        // Test Czech route
        app()->setLocale('cs');
        $path = LocalizedRouteHelper::getPath('test.route');
        $this->assertEquals(url('testovaci-cesta'), $path);

        // Test with explicit locale parameter
        $path = LocalizedRouteHelper::getPath('test.route', [], 'en');
        $this->assertEquals(url('test-route'), $path);
    }

    /**
     * Test that getPath correctly handles route parameters.
     */
    public function test_get_path_handles_parameters(): void
    {
        // Clear the cache before creating the route
        \Illuminate\Support\Facades\Cache::forget('localized_routes');

        // Create a route with parameters
        PageRoute::factory()->create([
            'route_name' => 'test.route.with.params',
            'route_path' => 'test-route/{id}/{slug}',
            'route_lang' => 'en',
            'is_active' => true,
        ]);

        // Test with parameters
        $path = LocalizedRouteHelper::getPath('test.route.with.params', [
            'id' => 123,
            'slug' => 'test-slug'
        ]);

        $this->assertEquals(url('test-route/123/test-slug'), $path);
    }

    /**
     * Test that getPath falls back to default locale if requested locale is not available.
     */
    public function test_get_path_falls_back_to_default_locale(): void
    {
        // Clear the cache before creating the route
        \Illuminate\Support\Facades\Cache::forget('localized_routes');

        // Create a route only in English
        PageRoute::factory()->create([
            'route_name' => 'test.route.fallback',
            'route_path' => 'test-route-fallback',
            'route_lang' => 'en',
            'is_active' => true,
        ]);

        // Set app locale to a language that doesn't have this route
        app()->setLocale('fr');

        // Should fall back to default locale (English is set as default in setUp)
        $path = LocalizedRouteHelper::getPath('test.route.fallback');
        $this->assertEquals(url('test-route-fallback'), $path);
    }

    /**
     * Test that getPath returns # when route doesn't exist.
     */
    public function test_get_path_returns_hash_for_nonexistent_route(): void
    {
        // Try to get a path for a route that doesn't exist
        $path = LocalizedRouteHelper::getPath('nonexistent.route');
        $this->assertEquals('#', $path);
    }

    /**
     * Test that clearCache clears the cache.
     */
    public function test_clear_cache(): void
    {
        // Clear the cache before creating the route
        \Illuminate\Support\Facades\Cache::forget('localized_routes');

        // Create a route
        PageRoute::factory()->create([
            'route_name' => 'test.route.cache',
            'route_path' => 'test-route-cache',
            'route_lang' => 'en',
            'is_active' => true,
        ]);

        // Access the route to ensure it's cached
        $path1 = LocalizedRouteHelper::getPath('test.route.cache');

        // Update the route
        PageRoute::where('route_name', 'test.route.cache')
            ->update(['route_path' => 'updated-test-route-cache']);

        // Without clearing cache, should still get old path
        $path2 = LocalizedRouteHelper::getPath('test.route.cache');
        $this->assertEquals($path1, $path2);

        // Clear cache
        LocalizedRouteHelper::clearCache();

        // Now should get updated path
        $path3 = LocalizedRouteHelper::getPath('test.route.cache');
        $this->assertEquals(url('updated-test-route-cache'), $path3);
    }
}
