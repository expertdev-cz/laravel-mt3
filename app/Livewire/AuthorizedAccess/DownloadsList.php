<?php

namespace App\Livewire\AuthorizedAccess;

use App\Models\AuthorizedAccess\AuthorizedAccessFolder;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DownloadsList extends Component
{
    public string $pageType = 'authorized-access-technical-sheets';

    public function mount(string $pageType = 'authorized-access-technical-sheets'): void
    {
        $this->pageType = $pageType;
    }

    public function render(): View
    {
        return view('livewire.authorized-access.downloads-list', [
            'isAuthenticated' => Auth::guard('authorized_access')->check(),
            'folders' => AuthorizedAccessFolder::query()
                ->with(['downloads' => fn ($query) => $query->where('is_active', true)])
                ->where('page_type', $this->pageType)
                ->where('is_active', true)
                ->orderBy('sort')
                ->orderBy('title')
                ->get(),
        ]);
    }
}