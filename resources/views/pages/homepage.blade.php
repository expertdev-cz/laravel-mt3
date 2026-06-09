@extends('layouts.app')
@section('title', $page->title)
@section('seo')<x-seo-block :seo="$page->seo" :seo-item="$page"/>@endsection

@section('header_in_hero', true)

@section('content')
{{-- Hero sekce s videem --}}
<section class="hp-video position-relative">
    <x-header-menu />
    @if(!empty($page->content['hero_video_file']) || !empty($page->content['hero_video_poster']))
        <video class="position-absolute top-0 start-0 w-100 h-100 video-bg hero-section" autoplay muted loop
            @if(!empty($page->content['hero_video_poster'])) poster="{{ \App\Services\Content\MediaService::getMediaUrl($page->content['hero_video_poster']) }}" @endif>
            @if(!empty($page->content['hero_video_file']))
                <source src="{{ \App\Services\Content\MediaService::getMediaUrl($page->content['hero_video_file']) }}" type="video/mp4">
            @endif
        </video>
    @endif
</section>

{{-- Showcase bloky --}}
@if(!empty($page->content['showcases']) && is_array($page->content['showcases']))
    @foreach($page->content['showcases'] as $index => $showcase)
        @php
            $isReversed = !empty($showcase['is_reversed']);
            $bgImage = !empty($showcase['background_image']) ? \App\Services\Content\MediaService::getMediaUrl($showcase['background_image']) : null;
        @endphp
        <section class="d-flex align-items-center" @if($bgImage) style="background: url('{{ $bgImage }}') center/cover no-repeat;" @endif>
            <div class="container-fluid container-custom">
                <div class="row align-items-center h-100">
                    {{-- Textový sloupec --}}
                    <div class="col-lg-6 col-md-6 order-2 {{ $isReversed ? 'order-lg-1' : 'order-lg-2' }}">
                        <div class="showcase-spacer"></div>
                        @if(!empty($showcase['eyebrow_title']))
                            <h1 class="fn-6rm fw-300 text-dark-grey mb-0 scroll-in">{{ $showcase['eyebrow_title'] }}</h1>
                        @endif
                        @if(!empty($showcase['eyebrow_subtitle']))
                            <p class="text-dark-grey fs-1 mb-0 scroll-in">{{ $showcase['eyebrow_subtitle'] }}</p>
                        @endif
                        <div class="showcase-spacer"></div>
                        @if(!empty($showcase['category']))
                            <p class="text-dark-grey fs-5 fw-light mb-0 scroll-in">{{ $showcase['category'] }}</p>
                        @endif
                        <div class="row">
                            @if(!empty($showcase['product_title']))
                                <div class="col-md-4 product-name">
                                    <h2 class="display-3 fw-regular text-dark-grey mb-0 scroll-in">{{ $showcase['product_title'] }}</h2>
                                </div>
                            @endif
                            @if(!empty($showcase['product_text']))
                                <div class="col-md-8">
                                    <p class="text-dark-grey mt-3 fs-5 fw-light scroll-in">{!! nl2br(e($showcase['product_text'])) !!}</p>
                                </div>
                            @endif
                        </div>
                        @if(!empty($showcase['price']))
                            <p class="fs-4 text-dark-grey fw-light mt-3 mb-0 scroll-in">{{ $showcase['price'] }}</p>
                        @endif
                        @if(!empty($showcase['button']['buttonText']) && !empty($showcase['button']['buttonLink']))
                            <a href="{{ formatPageLink($showcase['button']['buttonLink']) }}">
                                <button class="btn px-4 py-2 fw-light btn-showcase-custom rounded-pill scroll-in">{{ $showcase['button']['buttonText'] }}</button>
                            </a>
                        @endif
                        <div class="showcase-spacer"></div>
                        @if(!empty($showcase['parameters']) && is_array($showcase['parameters']))
                            <div class="param-row text-dark-grey small">
                                @foreach($showcase['parameters'] as $paramIndex => $param)
                                    @if($paramIndex > 0)<div class="param-separator-thin"></div><div class="param-separator-mobile"></div>@endif
                                    <div class="param-item scroll-in">
                                        <span class="fw-light text-dark-grey fs-5">{{ $param['label'] ?? '' }}</span><br>
                                        <span class="fw-bold fs-5 text-dark-grey">{{ $param['value'] ?? '' }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        @if(!empty($showcase['icons']) && is_array($showcase['icons']))
                            <div class="row my-4">
                                <div class="col-auto">
                                    <div class="icon-hover-group d-flex align-items-center scroll-in">
                                        @foreach($showcase['icons'] as $icon)
                                            @php
                                                $defaultIcon = !empty($icon['default_icon']) ? \App\Services\Content\MediaService::getMediaUrl($icon['default_icon']) : null;
                                                $hoverIcon = !empty($icon['hover_icon']) ? \App\Services\Content\MediaService::getMediaUrl($icon['hover_icon']) : null;
                                            @endphp
                                            @if($defaultIcon)
                                                <div class="icon-hover-item" data-default="{{ $defaultIcon }}" @if($hoverIcon) data-hover="{{ $hoverIcon }}" @endif>
                                                    <img src="{{ $defaultIcon }}" alt="">
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="showcase-spacer"></div>
                    </div>
                    {{-- Obrázkový sloupec --}}
                    <div class="col-lg-6 col-md-6 order-1 {{ $isReversed ? 'order-lg-2' : 'order-lg-1' }}">
                        @if(!empty($showcase['product_image']))
                            <div class="text-center showcase-image-container scroll-in">
                                <x-curator-glider :media="$showcase['product_image']" class="img-fluid showcase-img" :alt="$showcase['product_title'] ?? ''" />
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endforeach
@endif

{{-- Infografiky a spodní CTA --}}
@if(!empty($page->content['info_cards']) && is_array($page->content['info_cards']))
<section class="info-cards-section">
    <div class="container-fluid container-custom scroll-in">
        <div class="row justify-content-center cards-container">
            @foreach($page->content['info_cards'] as $mediaId)
                @if(!empty($mediaId))
                <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm info-card">
                        <div class="card-body p-0">
                            <x-curator-glider :media="$mediaId" class="img-fluid w-100 h-100" style="object-fit: cover; border-radius: 25px;" />
                        </div>
                    </div>
                </div>
                @endif
            @endforeach

            <div class="row mt-5 bottom-section">
                <div class="col-12 text-center">
                    @if(!empty($page->content['bottom_title']))
                        <h2 class="display-5 fw-bold text-dark-grey mb-3 scroll-in">{{ $page->content['bottom_title'] }}</h2>
                    @endif
                    @if(!empty($page->content['bottom_text_first']))
                        <p class="text-dark-grey fs-5 mb-4 scroll-in">{{ $page->content['bottom_text_first'] }}</p>
                    @endif
                    @if(!empty($page->content['bottom_text_second']))
                        <p class="text-dark-grey fs-5 mb-4 scroll-in">{{ $page->content['bottom_text_second'] }}</p>
                    @endif
                    @if(!empty($page->content['bottom_button']['buttonText']) && !empty($page->content['bottom_button']['buttonLink']))
                        <a href="{{ formatPageLink($page->content['bottom_button']['buttonLink']) }}">
                            <button class="btn px-4 py-2 fw-light btn-showcase-custom rounded-pill scroll-in">{{ $page->content['bottom_button']['buttonText'] }}</button>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@endsection

@section('footer')
<x-footer />
@endsection
