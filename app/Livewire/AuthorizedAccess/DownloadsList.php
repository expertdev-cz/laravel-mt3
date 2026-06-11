<?php

namespace App\Livewire\AuthorizedAccess;

use App\Models\AuthorizedAccess\AuthorizedAccessFolder;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DownloadsList extends Component
{
    public string $pageType = 'authorized-access-technical-sheets';
    public ?string $folderSlug = null;

    public function mount(string $pageType = 'authorized-access-technical-sheets', ?string $folderSlug = null): void
    {
        $this->pageType = $pageType;
        $this->folderSlug = $folderSlug;
    }

    public function render(): View
    {
        $locale = app()->currentLocale();

        $loginSlug = \App\Models\System\Page::query()
            ->where('type', 'authorized-access-login')
            ->where('lang_locale', $locale)
            ->where('active', 1)
            ->value('slug');

        $registerSlug = \App\Models\System\Page::query()
            ->where('type', 'authorized-access-register')
            ->where('lang_locale', $locale)
            ->where('active', 1)
            ->value('slug');

        $query = AuthorizedAccessFolder::query()
            ->with(['downloads' => fn ($query) => $query->where('is_active', true)])
            ->where('is_active', true)
            ->orderBy('sort')
            ->orderBy('title');

        if ($this->folderSlug) {
            $query->where('slug', $this->folderSlug);
        } else {
            $query->where('page_type', $this->pageType);
        }

        return view('livewire.authorized-access.downloads-list', [
            'isAuthenticated' => Auth::guard('authorized_access')->check(),
            'loginUrl' => '/' . ($loginSlug ?? 'autorizovany-pristup/prihlaseni'),
            'registerUrl' => '/' . ($registerSlug ?? 'autorizovany-pristup/registrace'),
            'folders' => $query->get(),
        ]);
    }
}
