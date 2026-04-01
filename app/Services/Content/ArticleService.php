<?php

namespace App\Services\Content;

use App\Models\Content\Article;
use App\Services\System\PageService;
use App\Services\Content\TagService;
use App\Services\System\UrlService;
use DateTime;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ArticleService
{
    public static function getAllActiveAndPublishArticles(): Collection|array
    {
        $articles = Article::query()
            ->where('lang_locale', '=', app()->currentLocale())
            ->where('active', '=', 1)
            ->where('publish_time', '<', new DateTime())
            ->orderBy('publish_time', 'desc')
            ->get();

        self::preloadTagsForArticles($articles);
        return $articles;
    }

    public static function getAllActiveAndPublishArticlesPagination(int $perPage = 10): LengthAwarePaginator
    {
        $articles = Article::where('lang_locale', '=', app()->currentLocale())
            ->where('active', '=', 1)
            ->where('publish_time', '<', new DateTime())
            ->orderBy('publish_time', 'desc')
            ->paginate($perPage);

        self::preloadTagsForArticles($articles);
        
        return $articles;
    }

    public static function getActiveAndPublishArticle(): ?Article
    {
        return Article::query()
            ->where('lang_locale', '=', app()->currentLocale())
            ->where('active', '=', 1)
            ->where('publish_time', '<', new DateTime())
            ->where('slug', '=', UrlService::getSlugFromUrl(request()->getRequestUri(), true))
            ->limit(1)
            ->get()->first();
    }

    public static function getMainArticlesSlug(): string
    {
        return PageService::getMainSubpageSlug('articles');
    }

    public static function getByTagId(int $tagId, int $perPage = 10): LengthAwarePaginator
    {
        $articles = Article::query()
            ->whereJsonContains('tags', (string)$tagId)
            ->where('lang_locale', '=', app()->currentLocale())
            ->where('active', '=', 1)
            ->where('publish_time', '<', new DateTime())
            ->orderBy('publish_time', 'desc')
            ->paginate($perPage);

        self::preloadTagsForArticles($articles);
        
        return $articles;
    }

    public static function getLatestForHomepage(int $limit = 7): Collection
    {
        $articles = Article::query()
            ->where('lang_locale', '=', app()->currentLocale())
            ->where('active', '=', 1)
            ->where('publish_time', '<', new DateTime())
            ->orderBy('publish_time', 'desc')
            ->limit($limit)
            ->get();

        self::preloadTagsForArticles($articles);
        
        return $articles;
    }

    public static function getLatest(int $limit = 3): Collection
    {
        $articles = Article::query()
            ->where('lang_locale', '=', app()->currentLocale())
            ->where('active', '=', 1)
            ->where('publish_time', '<', new DateTime())
            ->orderBy('publish_time', 'desc')
            ->limit($limit)
            ->get();

        self::preloadTagsForArticles($articles);

        return $articles;
    }

    private static function preloadTagsForArticles($articles): void
    {
        if (!$articles || (is_object($articles) && method_exists($articles, 'count') && $articles->count() == 0)) {
            return;
        }

        $allTagIds = [];
        
        foreach ($articles as $article) {
            if ($article->tags && is_array($article->tags)) {
                $allTagIds = array_merge($allTagIds, $article->tags);
            }
        }
        
        if (!empty($allTagIds)) {
            $allTagIds = array_unique($allTagIds);
            $tags = TagService::getByIds($allTagIds);
            
            $tagsMap = $tags->keyBy('id');
            
            foreach ($articles as $article) {
                $article->article_tags = collect();
                
                if ($article->tags && is_array($article->tags)) {
                    foreach ($article->tags as $tagId) {
                        if ($tagsMap->has((int)$tagId)) {
                            $article->article_tags->push($tagsMap->get((int)$tagId));
                        }
                    }
                }
            }
        } else {
            foreach ($articles as $article) {
                $article->article_tags = collect();
            }
        }
    }
}