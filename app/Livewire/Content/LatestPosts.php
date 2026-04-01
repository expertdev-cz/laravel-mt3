<?php

namespace App\Livewire\Content;

use App\Services\Content\ArticleService;
use Livewire\Component;

class LatestPosts extends Component
{
    public int $limit = 3;

    public function render()
    {
        $articles = ArticleService::getLatest($this->limit);

        return view('livewire.content.latest-posts', [
            'news' => $articles,
            'mainSlug' => ArticleService::getMainArticlesSlug(),
        ]);
    }
}
