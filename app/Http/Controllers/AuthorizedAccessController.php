<?php

namespace App\Http\Controllers;

use App\Models\AuthorizedAccess\AuthorizedAccessFolder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthorizedAccessController extends \Illuminate\Routing\Controller
{
    public function folderPage(Request $request, string $folderSlug): View|\Illuminate\Http\Response
    {
        $folder = AuthorizedAccessFolder::where('slug', $folderSlug)
            ->where('is_active', true)
            ->first();

        if (!$folder) {
            abort(404);
        }

        return view('pages.authorized-access-folder', compact('folder'));
    }
}
