<?php

namespace Database\Factories\System;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\System\Settings>
 */
class SettingsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => [
                'site_name' => $this->faker->company(),
                'site_description' => $this->faker->sentence(),
                'contact_email' => $this->faker->safeEmail(),
                'contact_phone' => $this->faker->phoneNumber(),
                'social_media' => [
                    'facebook' => $this->faker->url(),
                    'twitter' => $this->faker->url(),
                    'instagram' => $this->faker->url(),
                    'linkedin' => $this->faker->url(),
                ],
                'analytics_id' => $this->faker->optional()->uuid(),
                'maintenance_mode' => $this->faker->boolean(10),
            ],
        ];
    }
}
