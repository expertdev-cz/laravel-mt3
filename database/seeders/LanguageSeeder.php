<?php

namespace Database\Seeders;

use App\Models\System\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        Language::query()->updateOrCreate(
            ['locale' => 'cs'],
            [
                'name' => 'Čeština',
                'active' => 1,
                'default' => 1,
                'icon' => '',
            ]
        );

        Language::query()->updateOrCreate(
            ['locale' => 'en'],
            [
                'name' => 'English',
                'active' => 1,
                'default' => 0,
                'icon' => '',
            ]
        );
    }
}
