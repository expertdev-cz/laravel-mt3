<div>
    @if(!$isAuthenticated)
        <p class="fw-light text-dark-grey scroll-in text-page-text">{{ __('Pro zobrazení obsahu se prosím') }} <a href="{{ $loginUrl }}">{{ __('přihlaste') }}</a>. {{ __('Pokud účet nemáte, můžete se') }} <a href="{{ $registerUrl }}">{{ __('zaregistrovat') }}</a>.</p>
    @elseif($folders->isEmpty())
        <p class="fw-light text-dark-grey text-page-text">{{ __('Zatím nejsou k dispozici žádné složky.') }}</p>
    @else
        <div class="ap-ikony-grid">
            @foreach($folders as $folder)
                <a href="{{ \App\Helpers\LocalizedRouteHelper::getPath('ap.folder', ['directorySlug' => $directorySlug, 'folderSlug' => $folder->slug]) }}" class="ap-ikona-item">
                    <img src="{{ asset('assets/icons/obj_47.svg') }}" alt="{{ $folder->title }}" class="ap-ikona-img">
                    <span class="ap-ikona-label">{{ $folder->title }}</span>
                </a>
            @endforeach
        </div>
    @endif
</div>