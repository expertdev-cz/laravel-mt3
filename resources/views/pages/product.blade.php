@extends('layouts.app')
@section('title', $page->title)
@section('seo')<x-seo-block :seo="$page->seo" :seo-item="$page"/>@endsection

@section('content')
@php
    $content    = $page->content ?? [];
    $heroType   = $content['hero_type'] ?? 'classic';
    $heroClass  = $heroType === 'alternative' ? 'video-hero-alt' : 'video-hero-poster';
    $descClass  = $heroType === 'alternative' ? 'video-description' : 'video-description-right';
    $videoId    = $content['hero_video_file'] ?? null;
    $posterId   = $content['hero_video_poster'] ?? null;
    $videoUrl   = $videoId  ? \App\Services\Content\MediaService::getMediaUrl($videoId)  : null;
    $posterUrl  = $posterId ? \App\Services\Content\MediaService::getMediaUrl($posterId) : null;
    $inquiryUrl = $content['hero_inquiry_url'] ?? '/napiste-nam';
    $barRefText  = $content['bar_reference_text']  ?? 'Podívejte se na realizace.';
    $barRefUrl   = $content['bar_reference_url']   ?? '/reference';
    $barOrdText  = $content['bar_order_text']       ?? 'Objednávku můžete realizovat s naším obchodním oddělením.';
    $barOrdEmail = $content['bar_order_email']      ?? 'obchod.project@mt3.cz';
    $barOrdLabel = $content['bar_order_label']      ?? 'Objednat';
@endphp

{{-- ── Hero video sekce ────────────────────────────────────────── --}}
<section class="hp-video position-relative {{ $heroClass }}">

    <div class="video-overlay">

        {{-- 1. text – nahoře uprostřed --}}
        @if(!empty($content['hero_heading']))
        <div class="video-heading">
            @if(!empty($content['hero_eyebrow']))
                <p class="text-center text-dark-grey fs-5 fw-light">{{ $content['hero_eyebrow'] }}</p>
            @endif
            <h2 class="text-center text-dark-grey fw-bold display-6">{{ $content['hero_heading'] }}</h2>
            @if(!empty($content['hero_text']))
                <p class="text-center text-dark-grey fs-5">{{ $content['hero_text'] }}</p>
            @endif
            @if(!empty($content['hero_price']))
                <p class="text-center fs-5 text-dark-grey fw-light">{{ $content['hero_price'] }}</p>
            @endif
        </div>
        @endif

        {{-- 2. text – popis (pozice závisí na typu) --}}
        @if(!empty($content['hero_heading']))
        <div class="{{ $descClass }}">
            @if(!empty($content['hero_eyebrow']))
                <p class="text-dark-grey fs-4 me-1">{{ $content['hero_eyebrow'] }}</p>
            @endif
            <h3 class="text-dark-grey fw-500 display-5">{{ $content['hero_heading'] }}</h3>
            @if(!empty($content['hero_text']))
                <p class="text-dark-grey fs-4 mb-4">{{ $content['hero_text'] }}</p>
            @endif
            @if(!empty($content['hero_price']))
                <p class="text-dark-grey fs-4 fw-light">{{ $content['hero_price'] }}</p>
            @endif
        </div>
        @endif

        {{-- Šipka dolů --}}
        <a class="video-scroll" href="#prvni-sekce"
            onclick="document.getElementById('prvni-sekce').scrollIntoView({behavior:'smooth'}); return false;">
            <img src="{{ asset('assets/icons/sipka-video.svg') }}" alt="">
        </a>

        @if($heroType === 'classic')
            {{-- Klasický: play vlevo, napište nám vpravo --}}
            <div class="video-icon-left-group">
                <a href="#" onclick="restartAnimace(); return false;">
                    <img src="{{ asset('assets/icons/play-tlacitko.svg') }}" class="video-icon-extra" style="height:116px;" alt="">
                </a>
                <a href="#" onclick="restartAnimace(); return false;">
                    <img src="{{ asset('assets/icons/play-tlacitko-text.svg') }}" class="video-icon-extra" style="height:62px;" alt="">
                </a>
            </div>
            <div class="video-icon-right-group">
                <a href="{{ $inquiryUrl }}">
                    <img src="{{ asset('assets/icons/text-tlacitko.svg') }}" class="video-icon-extra" alt="">
                </a>
            </div>
        @else
            {{-- Alternativní: všechny ikony vpravo --}}
            <div class="video-icon-right-group">
                <a href="#" onclick="restartAnimace(); return false;">
                    <img src="{{ asset('assets/icons/play-tlacitko.svg') }}" class="video-icon-extra" style="height:116px;" alt="">
                </a>
                <a href="#" onclick="restartAnimace(); return false;">
                    <img src="{{ asset('assets/icons/play-tlacitko-text.svg') }}" class="video-icon-extra" style="height:62px;" alt="">
                </a>
                <a href="{{ $inquiryUrl }}">
                    <img src="{{ asset('assets/icons/text-tlacitko.svg') }}" class="video-icon-extra" alt="">
                </a>
            </div>
        @endif

    </div>

    @if($videoUrl)
    <video class="position-absolute top-0 start-0 w-100 h-100 video-bg hero-section"
        autoplay muted playsinline preload="auto"
        @if($posterUrl) poster="{{ $posterUrl }}" @endif>
        <source src="{{ $videoUrl }}" type="video/mp4">
    </video>
    @endif
</section>

{{-- ── Showcase sekce + lišty ─────────────────────────────────── --}}
@foreach($content['sections'] ?? [] as $index => $section)
    @php
        $isReversed = !empty($section['is_reversed']);
        $imgId      = $section['image'] ?? null;
        $imgId      = is_array($imgId) ? ($imgId['id'] ?? $imgId['value'] ?? null) : $imgId;
    @endphp

    <section id="{{ $index === 0 ? 'prvni-sekce' : '' }}" class="d-flex align-items-center poster-background">
        <div class="container-fluid container-custom">
            <div class="row h-100">

                {{-- Textový sloupec --}}
                <div class="col-lg-6 col-md-6 order-2 {{ $isReversed ? 'order-lg-1 text-start' : 'order-lg-2 text-end ps-16' }}">
                    <div class="showcase-spacer"></div>
                    <div class="showcase-spacer"></div>

                    @if(!empty($section['big_heading']))
                        <h2 class="fsz-7rem mb-4 fw-300 text-start text-dark-grey scroll-in">{{ $section['big_heading'] }}</h2>
                    @endif
                    @if(!empty($section['subheading']))
                        <h3 class="fs-4 mb-0 text-start text-dark-grey scroll-in">{{ $section['subheading'] }}</h3>
                    @endif
                    @if(!empty($section['text']))
                        <div class="py-4 pe-4 text-dark-grey text-start scroll-in">
                            <div class="fs-5 fw-300">{!! $section['text'] !!}</div>
                        </div>
                    @endif

                    <div class="showcase-spacer-small"></div>

                    @if(!empty($section['parameters']))
                        <div class="param-row text-dark-grey small text-start">
                            @foreach($section['parameters'] as $pi => $param)
                                @if($pi > 0)
                                    <div class="param-separator-thin text-dark-grey"></div>
                                    <div class="param-separator-mobile text-dark-grey"></div>
                                @endif
                                <div class="param-item">
                                    @if(!empty($param['label']))
                                        <span class="fw-light text-dark-grey fs-5 scroll-in">{{ $param['label'] }}</span><br>
                                    @endif
                                    @if(!empty($param['value']))
                                        <span class="fw-bold fs-5 text-dark-grey scroll-in">{{ $param['value'] }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="showcase-spacer-small"></div>
                </div>

                {{-- Obrázek --}}
                <div class="col-lg-6 col-md-6 order-1 {{ $isReversed ? 'order-lg-2' : 'order-lg-1' }} d-flex align-content-center justify-content-center">
                    @if($imgId)
                        <div class="text-center showcase-image-container scroll-in {{ $isReversed ? 'pt-4' : '' }}">
                            <x-curator-glider :media="$imgId" class="img-fluid showcase-img max-height-680" />
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </section>

    {{-- Lišta reference / objednávka --}}
    <div class="row g-0">
        <div class="col-12 col-md-6 reference-odkaz-background">
            <p class="mb-0 text-dark-grey py-3 fs-4 container-custom scroll-in">
                Reference
                <img src="{{ asset('assets/icons/sipka-konfig.svg') }}" alt="" height="16px" class="mb1px">
                <a href="{{ $barRefUrl }}" class="reference-odkaz">{{ $barRefText }}</a>
            </p>
        </div>
        <div class="col-12 col-md-6 objednat-odkaz-background">
            <div class="d-flex flex-column flex-md-row align-items-center pe-md-4 pe-0 gap-2 gap-md-0">
                <div class="flex-grow-1 d-flex justify-content-center order-0 order-md-0">
                    <span class="text-dark-grey fs-4 fw-300 py-3 text-md-start scroll-in">{{ $barOrdText }}</span>
                </div>
                @if(!empty($barOrdEmail))
                <a href="mailto:{{ $barOrdEmail }}"
                    class="text-dark-grey text-decoration-none fw-500 fs-4 py-2 py-md-3 pe-0 pe-md-4 me-0 scroll-in me-md-4 order-0 order-md-1">
                    {{ $barOrdLabel }}
                    <img src="{{ asset('assets/icons/sipka-konfig.svg') }}" alt="" height="16px" class="mb1px">
                </a>
                @endif
            </div>
        </div>
    </div>
@endforeach

{{-- ── Tabulka rozměrů / parametrů ────────────────────────────── --}}
@if(!empty($content['table_title']) || !empty($content['table_rows']))
<section class="d-flex align-items-center poster-background">
    <div class="container-fluid container-custom">
        <div class="row">
            <div class="showcase-spacer"></div>
            <div class="showcase-spacer-small"></div>
        </div>
        <div class="row">
            <div class="col-10">
                <div class="row">
                    <div class="col-12">
                        <table class="table bg-transparent table-borderless text-start scroll-in">
                            <tbody>
                                {{-- Řádek s obrázky a nadpisem --}}
                                <tr>
                                    <td class="bg-transparent align-bottom">
                                        @if(!empty($content['table_title']))
                                            <h2 class="fsz-7rem mb-4 fw-300 text-start text-dark-grey scroll-in">{{ $content['table_title'] }}</h2>
                                        @endif
                                        @if(!empty($content['table_subtitle']))
                                            <h3 class="fs-4 text-dark-grey scroll-in mb-4">{{ $content['table_subtitle'] }}</h3>
                                        @endif
                                    </td>
                                    @php
                                        $tCol1ImgId = $content['table_col1_image'] ?? null;
                                        $tCol1ImgId = is_array($tCol1ImgId) ? ($tCol1ImgId['id'] ?? $tCol1ImgId['value'] ?? null) : $tCol1ImgId;
                                        $tCol2ImgId = $content['table_col2_image'] ?? null;
                                        $tCol2ImgId = is_array($tCol2ImgId) ? ($tCol2ImgId['id'] ?? $tCol2ImgId['value'] ?? null) : $tCol2ImgId;
                                    @endphp
                                    @if($tCol1ImgId)
                                    <td class="bg-transparent align-left align-bottom">
                                        <div class="mb-2">
                                            <x-curator-glider :media="$tCol1ImgId" class="img-fluid" style="max-height: 120px;" />
                                        </div>
                                    </td>
                                    @endif
                                    @if($tCol2ImgId)
                                    <td class="bg-transparent align-left align-bottom">
                                        <div class="mb-2">
                                            <x-curator-glider :media="$tCol2ImgId" class="img-fluid" style="max-height: 120px;" />
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                {{-- Záhlaví sloupců --}}
                                @if(!empty($content['table_col1_label']) || !empty($content['table_col2_label']))
                                <tr class="brd-bottom-dark-grey">
                                    <td class="text-dark-grey fs-5 bg-transparent fw-400">Parametr</td>
                                    @if(!empty($content['table_col1_label']))
                                        <td class="bg-transparent">
                                            <p class="text-dark-grey fs-5 fw-400 mb-0">{{ $content['table_col1_label'] }}</p>
                                        </td>
                                    @endif
                                    @if(!empty($content['table_col2_label']))
                                        <td class="bg-transparent">
                                            <p class="text-dark-grey fs-5 fw-400 mb-0">{{ $content['table_col2_label'] }}</p>
                                        </td>
                                    @endif
                                </tr>
                                @endif
                                {{-- Datové řádky --}}
                                @foreach($content['table_rows'] ?? [] as $row)
                                    @continue(empty($row['param']) && empty($row['col1_value']) && empty($row['col2_value']))
                                    <tr>
                                        <td class="text-dark-grey fs-5 fw-300 bg-transparent py-0">{{ $row['param'] ?? '' }}</td>
                                        <td class="text-dark-grey fs-5 fw-300 bg-transparent py-0">{{ $row['col1_value'] ?? '' }}</td>
                                        @if(!empty($content['table_col2_label']) || !empty($row['col2_value']))
                                            <td class="text-dark-grey fs-5 fw-300 bg-transparent py-0">{{ $row['col2_value'] ?? '' }}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(!empty($content['table_note']))
                    <p class="text-dark-grey fw-light fs-6 mt-4 text-start scroll-in">{{ $content['table_note'] }}</p>
                @endif
            </div>
        </div>
        <div class="row"><div class="showcase-spacer-small"></div></div>
    </div>
</section>

{{-- Lišta pod tabulkou --}}
<div class="row g-0">
    <div class="col-12 col-md-6 reference-odkaz-background">
        <p class="mb-0 text-dark-grey py-3 fs-4 container-custom scroll-in">
            Reference
            <img src="{{ asset('assets/icons/sipka-konfig.svg') }}" alt="" height="16px" class="mb1px">
            <a href="{{ $barRefUrl }}" class="reference-odkaz">{{ $barRefText }}</a>
        </p>
    </div>
    <div class="col-12 col-md-6 objednat-odkaz-background">
        <div class="d-flex flex-column flex-md-row align-items-center pe-md-4 pe-0 gap-2 gap-md-0">
            <div class="flex-grow-1 d-flex justify-content-center order-0 order-md-0">
                <span class="text-dark-grey fs-4 fw-300 py-3 text-md-start scroll-in">{{ $barOrdText }}</span>
            </div>
            @if(!empty($barOrdEmail))
            <a href="mailto:{{ $barOrdEmail }}"
                class="text-dark-grey text-decoration-none fw-500 fs-4 py-2 py-md-3 pe-0 pe-md-4 me-0 scroll-in me-md-4 order-0 order-md-1">
                {{ $barOrdLabel }}
                <img src="{{ asset('assets/icons/sipka-konfig.svg') }}" alt="" height="16px" class="mb1px">
            </a>
            @endif
        </div>
    </div>
</div>
@endif

@endsection

@section('footer')
    <x-footer :showText="true" />
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/' . ($heroType === 'alternative' ? 'product-video-alternative.js' : 'product-video.js')) }}"></script>
@endpush
