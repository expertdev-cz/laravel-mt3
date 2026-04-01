<?php

namespace App\Http\Controllers;

use App\Models\Content\Article;
use App\Models\System\Page;
use App\Services\System\SeoService;

class ServicesController extends Controller
{
    public static array $modelsForSitemaps = [Page::class,Article::class];

    public function sitemapGenerator(){
        if(SeoService::generateSitemapsFile(self::$modelsForSitemaps,app()->getLocale())){
            echo '<br> sitemap created';
        }else{
            echo '<br> sitemap creation failed';
        }
    }
}
