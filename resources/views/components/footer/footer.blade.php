<footer class="footer-bg">
    <div class="container-fluid container-custom">
        <div class="d-flex justify-content-between flex-wrap" style="margin-bottom:5rem;">

            {{-- Wrapper pro první tři CMS sloupce --}}
            <div class="d-flex justify-content-between footer-width">
                @foreach(['footer-1', 'footer-2', 'footer-3'] as $location)
                    @php $menu = $footerMenus[$location] ?? null; @endphp
                    @if($menu)
                    <div class="col-lg-3 col-md-6 mb-4">
                        <h6 class="footer-header fs-4 mb-4">{{ $menu->name }}</h6>
                        <ul class="list-unstyled">
                            @foreach($menu->menuItems ?? [] as $item)
                                @php
                                    $menuItem = $item?->linkable;
                                    if ($menuItem instanceof \App\Models\PageRouteUrls) {
                                        $itemRoute = localizedRoute($menuItem->pageRoute->route_name, [data_get($menuItem, 'slug')]);
                                    } elseif ($menuItem instanceof \App\Models\System\PageRoute) {
                                        $itemRoute = localizedRoute($menuItem->route_name);
                                    } else {
                                        $itemRoute = $item->url ?: '#';
                                    }
                                @endphp
                                <li><a href="{{ $itemRoute }}" class="footer-link">{{ $item->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                @endforeach
            </div>

            {{-- Autorizovaný přístup --}}
            <div class="mb-4 newsletter">
                <h6 class="footer-header fs-4">{{ __('Autorizovaný přístup') }}</h6>
                <livewire:footer.ap-email-check :loginUrl="$apLoginUrl" :registerUrl="$apRegisterUrl" wire:key="footer-ap-email-check" />
            </div>

        </div>

        <div class="d-flex justify-content-between mt-4">
            <div class="d-flex justify-content-center align-items-center">
                <img src="{{ asset('assets/icons/obj_003.svg') }}" height="45px" alt="MT3">
            </div>
            <a href="{{ $inquiryUrl }}">
                <div class="footer-chat-icon mb-1">
                    <img src="{{ asset('assets/images/icon_bublina.png') }}" alt="{{ __('Napište nám') }}" height="35">
                </div>
            </a>
        </div>

        {{-- Footer bottom bar --}}
        <div class="footer-divider">
            <div class="d-flex justify-content-between align-items-center mt-2 footer-info">
                {{-- Language switcher --}}
                <div class="d-flex align-items-center mb-2">
                    <img src="{{ asset('assets/icons/sipka-footer.svg') }}" class="me-2" height="20px" alt="">
                    <livewire:system.language-select variant="footer" wire:key="footer-lang" />
                </div>
                {{-- Legal links --}}
                <div class="d-flex gap-2 footer-info">
                    <div><a href="/podminky-pouzivani" class="footer-link fw-light mx-4 fs-6">{{ __('Podmínky použití') }}</a></div>
                    <div><a href="/zasady-ochrany-osobnich-udaju" class="footer-link fw-light mx-4 fs-6">{{ __('Zásady ochrany dat') }}</a></div>
                    <div><span class="footer-link fw-light ms-4 fs-6">&copy; {{ now()->year }} MT3 project a.s.</span></div>
                </div>
            </div>
        </div>

    </div>
</footer>
