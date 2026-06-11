<?php

namespace App\Livewire\AuthorizedAccess;

use App\Models\AuthorizedAccess\AuthorizedAccessFolder;
use App\Models\System\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class HubLinks extends Component
{
    public function render(): View
    {
        $locale = app()->currentLocale();

        $loginSlug = Page::query()
            ->where('type', 'authorized-access-login')
            ->where('lang_locale', $locale)
            ->where('active', 1)
            ->value('slug');

        $registerSlug = Page::query()
            ->where('type', 'authorized-access-register')
            ->where('lang_locale', $locale)
            ->where('active', 1)
            ->value('slug');

        $directorySlug = Page::query()
            ->where('type', 'authorized-access-home')
            ->where('lang_locale', $locale)
            ->where('active', 1)
            ->value('slug');

        $folders = AuthorizedAccessFolder::query()
            ->where('page_type', 'authorized-access-technical-sheets')
            ->where('is_active', true)
            ->orderBy('sort')
            ->orderBy('title')
            ->get();

        return view('livewire.authorized-access.hub-links', [
            'isAuthenticated' => Auth::guard('authorized_access')->check(),
            'loginUrl' => '/' . ($loginSlug ?? 'autorizovany-pristup/prihlaseni'),
            'registerUrl' => '/' . ($registerSlug ?? 'autorizovany-pristup/registrace'),
            'directorySlug' => $directorySlug ?? 'autorizovany-pristup',
            'folders' => $folders,
        ]);
    }
}