<div class="d-flex align-items-center gap-2">
@if($variant === 'footer')
    {{-- Footer: aktuální jazyk + ikonky --}}
    <span class="footer-current-lng" id="footer-current-lng">{{ strtoupper($actual->locale ?? '') }}</span>
    <div class="footer-lang-icons" id="footer-lang-icons">
        @foreach($langs as $item)
            @if($item->locale !== ($actual->locale ?? ''))
                <a href="#" wire:click.prevent="changeLang('{{ $item->locale }}', '{{ request()->getRequestUri() }}')"
                   data-lang="{{ strtoupper($item->locale) }}">
                    @if(!empty($item->icon))
                        <img src="/storage/{{ $item->icon }}" class="footer-lang-icon" height="48">
                    @else
                        <span class="footer-lang-icon">{{ strtoupper($item->locale) }}</span>
                    @endif
                </a>
            @endif
        @endforeach
    </div>
    <p class="footer-lng-switcher mb-0 underlined" id="footer-lng-switcher-btn">{{ __('Přepnout jazyk (switch language)') }}</p>
@else
    {{-- Header: Bootstrap dropdown --}}
    <div class="dropdown d-inline-block">
        <button id="langDropdown" class="btn fs-5 fw-bold" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="transition: opacity 0.18s ease; min-width: 3rem;">
            {{ strtoupper($actual->locale ?? '') }}
            <img src="{{ asset('assets/icons/select_icon.svg') }}" alt="Select" class="ms-1 mb-1" style="height: 8px;">
        </button>
        <ul class="dropdown-menu" aria-labelledby="langDropdown">
            @foreach($langs as $item)
                @if($item->locale !== ($actual->locale ?? ''))
                    <li>
                        <a class="dropdown-item fs-5 text-dark-grey p-0" href="#"
                            wire:click.prevent="changeLang('{{ $item->locale }}', '{{ request()->getRequestUri() }}')">
                            @if(!empty($item->icon))
                                <img src="/storage/{{ $item->icon }}" alt="{{ strtoupper($item->locale) }}" style="height: 45px;">
                            @else
                                {{ strtoupper($item->locale) }}
                            @endif
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
@endif
</div>