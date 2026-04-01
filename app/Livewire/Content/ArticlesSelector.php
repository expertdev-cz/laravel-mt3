<?php

namespace App\Livewire\Content;

use App\Services\Content\TagService;
use Livewire\Component;

class ArticlesSelector extends Component
{
    public function render()
    {
        $tags = TagService::getAllArticlesTags();
        return view('livewire.content.articles-selector',['tags'=>$tags]);
    }

    public function changeTag($tagId){
        $this->dispatch('article-tag-selector-click', value: $tagId);
    }
}
