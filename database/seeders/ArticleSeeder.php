<?php

namespace Database\Seeders;

use App\Models\Content\Article;
use App\Models\System\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $authorId = $this->resolveAuthorId();

        Article::query()->updateOrCreate(
            [
                'lang_locale' => 'cs',
                'slug' => 'testovaci-clanek',
            ],
            [
                'user_id' => $authorId,
                'title' => 'Testovací článek',
                'active' => 1,
                'publish_time' => Carbon::now()->subHour(),
                'show_order' => 1,
                'content' => [
                    'text' => '<p>Toto je výchozí testovací článek v češtině.</p>',
                    'seo' => [
                        'title' => 'Testovací článek',
                        'desc' => 'Výchozí blogový článek pro CS mutaci.',
                    ],
                ],
                'tags' => [],
                'another_articles' => [],
            ]
        );

        Article::query()->updateOrCreate(
            [
                'lang_locale' => 'en',
                'slug' => 'test-article',
            ],
            [
                'user_id' => $authorId,
                'title' => 'Test Article',
                'active' => 1,
                'publish_time' => Carbon::now()->subHour(),
                'show_order' => 1,
                'content' => [
                    'text' => '<p>This is the default English test article.</p>',
                    'seo' => [
                        'title' => 'Test Article',
                        'desc' => 'Default blog article for EN locale.',
                    ],
                ],
                'tags' => [],
                'another_articles' => [],
            ]
        );
    }

    private function resolveAuthorId(): int
    {
        $adminEmail = 'nevaril@expert-dev.cz';

        $adminId = User::query()->where('email', $adminEmail)->value('id');
        if ($adminId) {
            return (int) $adminId;
        }

        $firstUserId = User::query()->value('id');
        if ($firstUserId) {
            return (int) $firstUserId;
        }

        $seedUser = User::query()->create([
            'name' => 'Seed Author',
            'email' => 'seed-author@local.test',
            'password' => Hash::make('seed-author-password-change-me'),
            'email_verified_at' => now(),
            'role_name' => 'admin',
        ]);

        return (int) $seedUser->getKey();
    }
}
