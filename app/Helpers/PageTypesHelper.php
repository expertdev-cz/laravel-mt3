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
        'about-us' => PagesController::class,
        'references' => PagesController::class,
        'reference-detail' => PagesController::class,
        'technologies' => PagesController::class,
        'authorized-access-login' => PagesController::class,
        'authorized-access-register' => PagesController::class,
        'inquiry' => PagesController::class,
        'authorized-access-home' => PagesController::class,
        'authorized-access-technical-sheets' => PagesController::class,
        'product' => PagesController::class,
        'next' => PagesController::class,
    ];

    public static array $pageTypesLabels = [
        'homepage' => 'Domovská stránka',
        'text' => 'Textová stránka',
        'contact' => 'Kontakt',
        'about-us' => 'O nás',
        'references' => 'Reference',
        'reference-detail' => 'Detail reference',
        'technologies' => 'Technologie',
        'authorized-access-login' => 'AP - Přihlášení',
        'authorized-access-register' => 'AP - Registrace',
        'inquiry' => 'Napište nám',
        'authorized-access-home' => 'AP - Rozcestník',
        'authorized-access-technical-sheets' => 'AP - Technické listy',
        'product' => 'Produktová stránka',
        'next' => 'Next',
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
