<?php

namespace App\Services\Content;

use App\Models\Content\Tag;
use App\Services\Content\ArticleService;
use Illuminate\Database\Eloquent\Collection;

class TagService
{
    public static function getAllArticlesTags(): Collection|array
    {
        return self::processTags(ArticleService::getAllActiveAndPublishArticles());
    }

    public static function getByIds(array $ids): Collection|array
    {
        return Tag::query()
            ->whereIn('id', $ids)
            ->where('lang_locale', '=', app()->currentLocale())
            ->where('active', '=', 1)
            ->get();
    }

    public static function getById(int $id): ?Tag
    {
        return Tag::query()
            ->where('id', '=', $id)
            ->where('lang_locale', '=', app()->currentLocale())
            ->where('active', '=', 1)
            ->first();
    }

    private static function processTags($data): Collection|array
    {
        if ($data) {
            $tagsIds = [];

            foreach ($data as $item) {
                if (isset($item['tags']) && is_array($item['tags'])) {
                    $tagsIds = array_merge($tagsIds, $item['tags']);
                }
            }

            return Tag::query()
                ->whereIn('id', array_unique($tagsIds))
                ->where('lang_locale', '=', app()->currentLocale())
                ->where('active', '=', 1)
                ->get();
        }

        return [];
    }
}