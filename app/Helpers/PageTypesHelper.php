<?php

namespace App\Helpers;

use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\PagesController;

class PageTypesHelper
{
    public static array $pageTypesToControllersMap = [
        'homepage' => PagesController::class,
        'articles' => ArticlesController::class,
        'text' => PagesController::class,
        'contact' => PagesController::class,
    ];

    public static array $pageTypesLabels = [
        'homepage' => 'Homepage',
        'text' => 'Textová stránka',
        'articles' => 'Blog',
        'contact' => 'Kontakt',
    ];

    public static array $pageWithAllowedSubpages = [
        'articles',
    ];

    public static array $typesToSubpagesTemplatesMap = [
        'articles'=>'article-detail',
    ];

    public static array $typesToSubpagesActionsMap = [
        'articles'=>'detail',
    ];

    public static array $loadSubDataToMenuForTypes = [

    ];



}
