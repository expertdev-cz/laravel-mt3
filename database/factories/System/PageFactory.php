<?php

namespace Database\Factories\System;

use App\Models\System\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\System\Page>
 */
class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $allowedLocales = Language::getAllowedLanguageLocale();

        return [
            'slug' => $this->faker->slug(),
            'lang_locale' => $this->faker->randomElement($allowedLocales),
            'parent_id' => null,
            'type' => $this->faker->randomElement(['page', 'article', 'blog']),
            'title' => $this->faker->sentence(),
            'subtitle' => $this->faker->optional()->sentence(),
            'title_media_json' => null,
            'content' => ['content' => $this->faker->paragraphs(3, true)],
            'active' => $this->faker->boolean(80),
            'seo' => [
                'meta_title' => $this->faker->sentence(),
                'meta_description' => $this->faker->paragraph(),
                'meta_keywords' => implode(', ', $this->faker->words(5))
            ],
            'in_menu' => $this->faker->boolean(50),
            'in_footer_menu' => $this->faker->boolean(30),
            'in_menu_only_for_logged' => $this->faker->boolean(20),
            'in_menu_order' => $this->faker->numberBetween(1, 10),
            'in_menu_title' => $this->faker->optional()->words(3, true),
        ];
    }
}
