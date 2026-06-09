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
@php
    $contactBg = !empty($page->content['company_background_image']) ? \App\Services\Content\MediaService::getMediaUrl($page->content['company_background_image']) : null;
@endphp
<section class="kontakt-bg-section scroll-in" @if($contactBg)style="background-image: url('{{ $contactBg }}');"@endif>
    <div class="kontakt-bg-left">
        @if(!empty($page->content['company_name']))
            <h2 class="kontakt-firma-nazev">{{ $page->content['company_name'] }}</h2>
        @endif
        <div class="kontakt-adresa-blok">
            @if(!empty($page->content['address_text']))
                @foreach(array_filter(array_map('trim', explode("\n", $page->content['address_text']))) as $line)
                    <p>{{ $line }}</p>
                @endforeach
            @endif
            @if(!empty($page->content['gps_url']) && !empty($page->content['gps_label']))
                <a href="{{ $page->content['gps_url'] }}" target="_blank" rel="noopener noreferrer" class="kontakt-gps-link">
                    {{ $page->content['gps_label'] }}&nbsp;&nbsp;<img src="{{ asset('assets/icons/obj_55.svg') }}" alt="" style="height: 4.1rem; vertical-align: middle; margin-left: 4rem;">
                </a>
            @endif
            @if(!empty($page->content['company_info_text']))
                @foreach(array_filter(array_map('trim', explode("\n", $page->content['company_info_text']))) as $infoLine)
                    <p>{{ $infoLine }}</p>
                @endforeach
            @endif
        </div>
    </div>
    <div class="kontakt-bg-right">
        @if(!empty($page->content['map_image']))
            <x-curator-glider :media="$page->content['map_image']" class="kontakt-mapa-svg" />
        @endif
    </div>
</section>
@endif

{{-- Spodní info --}}
@if(!empty($page->content['footer_title']) || !empty($page->content['footer_text']))
<section class="kontakt-info-footer">
    <div class="container-fluid container-custom text-center">
        @if(!empty($page->content['footer_title']))
            <h2 class="kontakt-info-nadpis text-dark-grey scroll-in">{{ $page->content['footer_title'] }}</h2>
        @endif
        @if(!empty($page->content['footer_text']))
            <p class="kontakt-info-text text-dark-grey scroll-in">{{ $page->content['footer_text'] }}</p>
        @endif
        @if(!empty($page->content['footer_note']))
            <p class="kontakt-info-small scroll-in">{{ $page->content['footer_note'] }}</p>
        @endif
    </div>
</section>
@endif
@endsection

@section('footer')
<x-footer />
@endsection