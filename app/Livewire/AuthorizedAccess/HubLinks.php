<?php

namespace App\Livewire\AuthorizedAccess;

use App\Models\AuthorizedAccess\AuthorizedAccessFolder;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class HubLinks extends Component
{
    public function render(): View
    {
        return view('livewire.authorized-access.hub-links', [
            'isAuthenticated' => Auth::guard('authorized_access')->check(),
            'folders' => AuthorizedAccessFolder::query()
                ->where('page_type', 'authorized-access-home')
                ->where('is_active', true)
                ->orderBy('sort')
                ->orderBy('title')
                ->get(),
        ]);
    }
}