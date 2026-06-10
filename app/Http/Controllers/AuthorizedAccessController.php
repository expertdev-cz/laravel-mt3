<?php

namespace App\Http\Controllers;

use App\Attributes\PageRouteAction;
use App\Models\AuthorizedAccess\AuthorizedAccessFolder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthorizedAccessController extends \Illuminate\Routing\Controller
{
    #[PageRouteAction]
    public function folderPage(Request $request, string $directorySlug, string $folderSlug): View
    {
        $folder = AuthorizedAccessFolder::where('slug', $folderSlug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('pages.authorized-access-folder', compact('folder'));
    }
}
