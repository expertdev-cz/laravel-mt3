<?php

namespace App\Http\Controllers;

use App\Attributes\PageRouteAction;
use Illuminate\View\View;
use App\Services\Content\MediaService;

class PagesController extends Controller
{
    #[PageRouteAction]
    public function index(): View
    {
        return parent::index();
    }

    public static function getMediaUrl($mediaId)
    {
        return MediaService::getMediaUrl($mediaId);
    }
}
