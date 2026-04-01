<?php

namespace Database\Factories\System;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\System\Language>
 */
class LanguageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $allowedLocales = ['cs', 'en', 'pl', 'sk', 'de', 'fr', 'ru', 'it', 'es'];
        $locale = $this->faker->randomElement($allowedLocales);

        return [
            'name' => $this->faker->unique()->country(),
            'locale' => $locale,
            'active' => $this->faker->boolean(80),
            'icon' => "flag-icon-{$locale}",
        ];
    }
}
