<?php

namespace App\Http\Controllers;

use App\Attributes\PageRouteAction;
use App\Services\Content\ArticleService;
use App\Services\Content\TagService;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArticlesController extends Controller
{
    /**
     * /blog – výpis článků (CollectionPage + ItemList)
     */
    #[PageRouteAction]
    public function index(): View
    {
        return $this->pageService->getPageView(
            $this->request->getRequestUri(),
            app()->currentLocale(),
            []
        );
    }

    /**
     * /blog/{slug} – detail článku (BlogPosting)
     */
    #[PageRouteAction]
    public function detail(): View
    {
        $article = ArticleService::getActiveAndPublishArticle();
        if (!$article) {
            abort(404);
        }

        $baseSlug = trim(ArticleService::getMainArticlesSlug() ?? 'blog', '/');
        $mainSlug = '/' . $baseSlug;

        $content = is_array($article->content ?? null) ? $article->content : [];

        $desc = $content['seo']['desc'] ?? null;
        if (!$desc && !empty($content['text'])) {
            $desc = Str::limit(strip_tags($content['text']), 300);
        }

        // Keywords z tagů (DB pole `tags` = [id,id,...])
        $tags = collect();
        if (is_array($article->tags) && count($article->tags) > 0) {
            $tags = TagService::getByIds($article->tags);
        }
        $keywords = $tags->pluck('name')->all();

        // Připrav SEO data z článku pro title tag
        $articleSeo = $content['seo'] ?? [];
        $seoData = [
            'title' => $articleSeo['title'] ?? $article->title,
            'desc' => $articleSeo['desc'] ?? $desc,
            'keywords' => $articleSeo['keywords'] ?? implode(', ', $keywords),
        ];

        return $this->pageService->getPageView(
            $this->request->getRequestUri(),
            app()->currentLocale(),
            [
                'article'       => $article,
                'mainSlug'      => $mainSlug,
                'tags'          => $tags,
                'seo'           => $seoData,
            ]
        );
    }
}
