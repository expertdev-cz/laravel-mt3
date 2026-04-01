<?php

namespace App\Livewire\Content;

use App\Services\Content\ArticleService;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ArticlesList extends Component
{    
    use WithPagination;

    protected string $paginationTheme = 'tailwind';
    
    public $isHp = false;
    private $tag = false;
    
    public function render()
    {
        if ($this->isHp) {
            $articles = ArticleService::getLatestForHomepage(7);
        } elseif ($this->tag) {
            $articles = ArticleService::getByTagId($this->tag, 12);
        } else {
            $articles = ArticleService::getAllActiveAndPublishArticlesPagination(9);
        }
        
        return view('livewire.content.articles-list', [
            'news' => $articles,
            'mainSlug' => ArticleService::getMainArticlesSlug()
        ]);
    }
    
    #[On('article-tag-selector-click')]
    public function onTagChange($value)
    {
        $this->tag = $value;
        $this->resetPage();
    }
    
    public function clearTag()
    {
        $this->tag = false;
        $this->resetPage();
    }
}