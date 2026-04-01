<?php

namespace Database\Factories\System;

use Illuminate\Database\Eloquent\Factories\Factory;

class PageRouteFactory extends Factory
{

    public function definition(): array
    {
        $routeName = $this->faker->word();
        $routePath = $this->faker->slug(2);

        return [
            'route_name' => $routeName,
            'route_path' => $routePath,
            'route_method' => $this->faker->randomElement(['GET', 'POST', 'PUT', 'DELETE']),
            'route_action' => $this->faker->randomElement(['index', 'show', 'store', 'update', 'destroy']),
            'route_controller' => 'App\Http\Controllers\PagesController',
            'route_middleware' => $this->faker->randomElement(['web', 'api', 'auth', 'guest']),
            'route_lang' => $this->faker->randomElement(['cs', 'en', 'pl', 'sk', 'de', 'fr', 'ru', 'it', 'es']),
            'is_active' => $this->faker->boolean(80),
        ];
    }
}
