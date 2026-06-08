@extends('layouts.app')
@section('title', $page->title)
@section('seo')<x-seo-block :seo="$page->seo" :seo-item="$page"/>@endsection

@section('content')
{{-- Úvod sekce --}}
<section class="d-flex align-items-center pt-5 pb-5">
    <div class="container-fluid container-custom">
        <div class="showcase-spacer"></div>
        @if(!empty($page->content['title']))
            <h1 class="fw-light text-dark-grey mb-3 scroll-in" style="font-size: 6rem; line-height: 1.05;">{{ $page->content['title'] }}</h1>
        @endif
        @if(!empty($page->content['intro_text']))
            <p class="fw-light text-dark-grey mb-0 scroll-in" style="font-size: 2rem; line-height: 1.4;">{{ $page->content['intro_text'] }}</p>
        @endif
    </div>
</section>

{{-- Kontaktní karty --}}
@if(!empty($page->content['items']) && is_array($page->content['items']))
<section class="py-4 mg-bottom-5rm">
    <div class="container-fluid container-custom">
        <div class="kontakt-grid">
            @foreach($page->content['items'] as $item)
            <div class="kontakt-karta scroll-in">
                <div class="karta-top">
                    @if(!empty($item['department']))<p class="karta-tym">{{ $item['department'] }}</p>@endif
                    @if(!empty($item['name']))<p class="karta-jmeno">{{ $item['name'] }}</p>@endif
                </div>
                <hr class="karta-divider">
                @if(!empty($item['email']))
                    <a href="mailto:{{ $item['email'] }}" class="karta-radek">
                        <span>{{ $item['email'] }}</span>
                        <span class="karta-icon"></span>
                    </a>
                @endif
                @if(!empty($item['phone']))
                    <a href="tel:{{ preg_replace('/\s+/', '', $item['phone']) }}" class="karta-radek">
                        <span>{{ $item['phone'] }}</span>
                        <span class="karta-icon"></span>
                    </a>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Firemní blok s mapou --}}
    @if(!empty($page->content['company_name']) || !empty($page->content['map_image']))
<section class="py-5" @if(!empty($page->content['company_background_image'])) style="background: url('{{ \App\Services\Content\MediaService::getMediaUrl($page->content['company_background_image']) }}') center/cover no-repeat;" @endif>
    <div class="container-fluid container-custom">
        <div class="row align-items-start">
            <div class="col-md-6">
                @if(!empty($page->content['company_name']))
                    <h2 class="text-dark-grey fw-light display-4 scroll-in">{{ $page->content['company_name'] }}</h2>
                @endif
                @if(!empty($page->content['address_text']))
                    <p class="text-dark-grey fs-5 fw-light scroll-in" style="white-space: pre-line;">{{ $page->content['address_text'] }}</p>
                @endif
                @if(!empty($page->content['gps_url']) && !empty($page->content['gps_label']))
                    <a href="{{ $page->content['gps_url'] }}" target="_blank" rel="noopener noreferrer" class="text-dark-grey scroll-in d-inline-flex align-items-center gap-2">
                        <img src="{{ asset('assets/icons/mapa.svg') }}" height="24" alt="">
                        {{ $page->content['gps_label'] }}
                    </a>
                @endif
            </div>
            <div class="col-md-6">
                @if(!empty($page->content['map_image']))
                    <x-curator-glider :media="$page->content['map_image']" class="img-fluid google-map scroll-in" />
                @endif
            </div>
        </div>
    </div>
</section>
@endif

{{-- Spodní info --}}
@if(!empty($page->content['footer_title']) || !empty($page->content['footer_text']))
<section class="py-5 bg-banner-grey">
    <div class="container-fluid container-custom text-center">
        @if(!empty($page->content['footer_title']))
            <h2 class="text-dark-grey fw-light display-3 scroll-in">{{ $page->content['footer_title'] }}</h2>
        @endif
        @if(!empty($page->content['footer_text']))
            <p class="text-dark-grey fs-4 fw-light scroll-in">{{ $page->content['footer_text'] }}</p>
        @endif
        @if(!empty($page->content['footer_note']))
            <p class="text-muted fs-6 scroll-in">{{ $page->content['footer_note'] }}</p>
        @endif
    </div>
</section>
@endif
@endsection

@section('footer')
<x-footer />
@endsection