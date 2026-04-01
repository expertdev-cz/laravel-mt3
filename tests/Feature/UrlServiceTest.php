<?php

namespace Tests\Feature;

use App\Models\System\Language;
use App\Services\System\UrlService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UrlServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a default language
        Language::factory()->create([
            'locale' => 'en',
            'default' => 1,
            'active' => 1,
        ]);

        // Create some additional languages
        Language::factory()->create([
            'locale' => 'cs',
            'default' => 0,
            'active' => 1,
        ]);

        Language::factory()->create([
            'locale' => 'de',
            'default' => 0,
            'active' => 1,
        ]);

        // Clear the cache to ensure we're using the languages we just created
        \Illuminate\Support\Facades\Cache::forget('default_locale');
    }

    /**
     * Test that defaultLang returns the correct default language.
     */
    public function test_default_lang_returns_correct_language(): void
    {
        $defaultLang = UrlService::defaultLang();
        $this->assertEquals('en', $defaultLang);
    }

    /**
     * Test that getSlugFromUrl correctly extracts slugs from URLs.
     */
    public function test_get_slug_from_url_extracts_slugs_correctly(): void
    {
        // Test root URL
        $this->assertEquals('/', UrlService::getSlugFromUrl('/'));

        // Test URL with default language
        $this->assertEquals('/', UrlService::getSlugFromUrl('/en'));

        // Test URL with non-default language
        app()->setLocale('en'); // Reset locale
        $this->assertEquals('about', UrlService::getSlugFromUrl('/cs/about'));
        $this->assertEquals('cs', app()->getLocale()); // Should set locale to cs

        // Test URL with non-default language but don't set locale
        app()->setLocale('en'); // Reset locale
        $this->assertEquals('about', UrlService::getSlugFromUrl('/cs/about', false, false));
        $this->assertEquals('en', app()->getLocale()); // Should not change locale

        // Test URL with query parameters
        $this->assertEquals('products', UrlService::getSlugFromUrl('/products?category=electronics'));

        // Test URL with multiple segments, getting the last part
        $this->assertEquals('details', UrlService::getSlugFromUrl('/products/123/details', true));

        // Test URL with a skip slug
        $this->assertFalse(UrlService::getSlugFromUrl('/admin/dashboard'));
    }

    /**
     * Test that getLocaleSlugPrefix returns the correct prefix.
     */
    public function test_get_locale_slug_prefix_returns_correct_prefix(): void
    {
        // Test with default language
        app()->setLocale('en');
        $this->assertEquals('', UrlService::getLocaleSlugPrefix());

        // Test with non-default language
        app()->setLocale('cs');
        $this->assertEquals('/cs', UrlService::getLocaleSlugPrefix());
        $this->assertEquals('/cs/', UrlService::getLocaleSlugPrefix(true, true));
        $this->assertEquals('cs/', UrlService::getLocaleSlugPrefix(false, true));
        $this->assertEquals('cs', UrlService::getLocaleSlugPrefix(false, false));
    }
}
