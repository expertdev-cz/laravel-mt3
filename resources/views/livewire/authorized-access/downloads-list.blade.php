<div>
    @if(!$isAuthenticated)
        <section class="d-flex align-items-center pt-5 pb-5">
            <div class="container-fluid container-custom">
                <div class="showcase-spacer"></div>
                <h1 class="text-dark-grey mb-3 scroll-in text-page-h1">{{ __('Nejste přihlášeni') }}</h1>
                <p class="fw-light text-dark-grey mb-0 scroll-in text-page-subtitle">{{ __('Soubory ke stažení jsou dostupné pouze přihlášeným uživatelům.') }}</p>
            </div>
        </section>
        <section class="py-4 mg-bottom-5rm">
            <hr class="ap-divider">
            <div class="container-fluid container-custom">
                <p class="fw-light text-dark-grey scroll-in text-page-text">{{ __('Pro zobrazení obsahu se prosím') }} <a href="{{ $loginUrl }}">{{ __('přihlaste') }}</a>. {{ __('Pokud účet nemáte, můžete se') }} <a href="{{ $registerUrl }}">{{ __('zaregistrovat') }}</a>.</p>
            </div>
        </section>
    @elseif($folders->isEmpty())
        <section class="d-flex align-items-center pt-5 pb-5">
            <div class="container-fluid container-custom">
                <div class="showcase-spacer"></div>
                <p class="fw-light text-dark-grey mb-0 scroll-in text-page-subtitle">{{ __('Zatím zde nejsou žádné složky ani soubory ke stažení.') }}</p>
            </div>
        </section>
    @else
        @foreach($folders as $folder)
            <section class="d-flex align-items-center pt-5 pb-5">
                <div class="container-fluid container-custom">
                    <div class="showcase-spacer"></div>
                    <h1 class="text-dark-grey mb-3 scroll-in text-page-h1">{{ $folder->title }}</h1>
                    @if($folder->subtitle)
                        <p class="fw-light text-dark-grey mb-0 scroll-in text-page-subtitle">{{ $folder->subtitle }}</p>
                    @endif
                </div>
            </section>

            <section class="py-4 mg-bottom-5rm">
                <hr class="ap-divider">
                <div class="container-fluid container-custom">
                    <div class="col-10">
                        @php $lastCategory = null; $downloads = $folder->downloads; @endphp
                        @foreach($downloads as $i => $download)
                            @if($download->category !== $lastCategory)
                                @if($lastCategory !== null)
                                    <div class="mb-5"></div>
                                @endif
                                @if($download->category)
                                    <div class="fw-light text-dark-grey scroll-in text-page-text mb-2">{!! $download->category !!}</div>
                                @endif
                                @php $lastCategory = $download->category; @endphp
                            @endif
                            @php $isLastInCategory = !isset($downloads[$i + 1]) || $downloads[$i + 1]->category !== $lastCategory; @endphp
                            <div class="row align-items-center scroll-in py-3 {{ $isLastInCategory ? 'mb-3' : 'border-bottom-dark-grey' }}">
                                <div class="col-2"><span class="fw-bold text-dark-grey text-page-text">{{ $download->code }}</span></div>
                                <div class="col-7"><span class="fw-light text-dark-grey text-page-text">{{ $download->title }}</span></div>
                                <div class="col-3">
                                    @if($download->file)
                                        <a href="{{ asset('storage/' . $download->file) }}" class="d-flex align-items-center gap-2 text-dark-grey text-decoration-none" target="_blank" rel="noopener">
                                            <img src="{{ asset('assets/icons/obj_001.svg') }}" alt="" style="height: 2.4rem; vertical-align: middle;">
                                            <span class="fw-600 text-page-text">{{ __('stáhnout') }}</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endforeach
    @endif
</div>