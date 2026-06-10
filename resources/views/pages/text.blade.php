@extends('layouts.app')
@section('title', $page->title)
@section('seo')<x-seo-block :seo="$page->seo" :seo-item="$page"/>@endsection

@section('content')

<section class="d-flex align-items-center pt-5 pb-5">
    <div class="container-fluid container-custom">
        <div class="showcase-spacer"></div>
        @if(!empty($page->title))
            <h1 class="text-dark-grey mb-3 scroll-in text-page-h1">{{ $page->title }}</h1>
        @endif
        @if(!empty($page->content['subtitle']))
            <p class="fw-light text-dark-grey mb-0 scroll-in text-page-subtitle">{{ $page->content['subtitle'] }}</p>
        @endif
    </div>
</section>

<section class="py-4 mg-bottom-5rm">
    <hr class="ap-divider">
    <div class="container-fluid container-custom">

        {{-- Volný RichEditor obsah --}}
        @if(!empty($page->content['pageContent']))
            <div class="rich-editor-highlight scroll-in fw-light text-dark-grey text-page-text">
                {!! $page->content['pageContent'] !!}
            </div>
        @endif

        {{-- Sekce --}}
        @foreach($page->content['sections'] ?? [] as $section)
            @php $layout = $section['layout'] ?? 'full'; @endphp

            @if($layout === 'full' || $layout === 'narrow')
                @php $wrapClass = $layout === 'narrow' ? 'col-lg-8' : ''; @endphp
                <div class="{{ $wrapClass }} mb-5">
                    @if(!empty($section['image']))
                        @php
                            $imgId = $section['image'];
                            $imgId = is_array($imgId) ? ($imgId['id'] ?? $imgId['value'] ?? null) : $imgId;
                            $imgUrl = $imgId ? \App\Services\Content\MediaService::getMediaUrl($imgId) : null;
                        @endphp
                        @if($imgUrl)
                            <img src="{{ $imgUrl }}" alt="{{ $section['image_alt'] ?? '' }}" class="mb-4 d-block" style="max-width:550px; margin-left:-50px; margin-top:-50px">
                        @endif
                    @endif
                    @if(!empty($section['text']))
                        <div class="fw-light text-dark-grey scroll-in text-page-text">{!! $section['text'] !!}</div>
                    @endif
                </div>

            @elseif($layout === 'image_left' || $layout === 'image_right')
                @php
                    $imgId = $section['image'] ?? null;
                    $imgId = is_array($imgId) ? ($imgId['id'] ?? $imgId['value'] ?? null) : $imgId;
                    $imgUrl = $imgId ? \App\Services\Content\MediaService::getMediaUrl($imgId) : null;
                    $textFirst = $layout === 'image_right';
                @endphp
                <div class="row align-items-center mb-5 scroll-in">
                    @if($textFirst)
                        <div class="col-md-6 align-self-start">
                            @if(!empty($section['text']))
                                <div class="fw-light text-dark-grey text-page-text">{!! $section['text'] !!}</div>
                            @endif
                        </div>
                        <div class="col-md-6 text-center">
                            @if($imgUrl)
                                <img src="{{ $imgUrl }}" alt="{{ $section['image_alt'] ?? '' }}" class="img-fluid" style="max-width:300px">
                            @endif
                        </div>
                    @else
                        <div class="col-md-6 text-center">
                            @if($imgUrl)
                                <img src="{{ $imgUrl }}" alt="{{ $section['image_alt'] ?? '' }}" class="img-fluid" style="max-width:300px">
                            @endif
                        </div>
                        <div class="col-md-6 align-self-start">
                            @if(!empty($section['text']))
                                <div class="fw-light text-dark-grey text-page-text">{!! $section['text'] !!}</div>
                            @endif
                        </div>
                    @endif
                </div>

            @elseif($layout === 'contact_right')
                <div class="mb-5">
                    @if(!empty($section['text']))
                        <div class="col-8 fw-light text-dark-grey scroll-in text-page-text mb-4">{!! $section['text'] !!}</div>
                    @endif
                    @if(!empty($section['gps_text']))
                        <p class="fw-light text-dark-grey scroll-in text-page-text mb-4 d-flex align-items-center gap-3">
                            {{ __('GPS:') }} {{ $section['gps_text'] }}
                            @if(!empty($section['gps_url']))
                                <a href="{{ $section['gps_url'] }}" target="_blank" rel="noopener" class="d-inline-flex align-items-center text-dark-grey text-decoration-none">
                                    <img src="{{ asset('assets/icons/obj_54.svg') }}" alt="Zobrazit mapu" style="height: 1.4em;">
                                </a>
                            @endif
                        </p>
                    @endif
                    @if(!empty($section['contact_name']) || !empty($section['contact_email']) || !empty($section['contact_phone']))
                        <div class="row justify-content-end skoleni-contact-row">
                            <div class="col-md-3 offset-md-6 text-end scroll-in">
                                @if(!empty($section['contact_title']))
                                    <p class="fw-bold text-dark-grey mb-0 skoleni-contact-heading">{{ $section['contact_title'] }}</p>
                                @endif
                                @if(!empty($section['contact_subtitle']))
                                    <p class="fw-normal text-dark-grey mb-3 skoleni-contact-subtitle">{{ $section['contact_subtitle'] }}</p>
                                @endif
                                <hr class="skoleni-contact-hr">
                                @if(!empty($section['contact_name']))
                                    <p class="fw-bold text-dark-grey mb-1 skoleni-contact-name">{{ $section['contact_name'] }}</p>
                                @endif
                                @if(!empty($section['contact_email']))
                                    <p class="text-dark-grey mb-1 skoleni-contact-info">{{ $section['contact_email'] }}</p>
                                @endif
                                @if(!empty($section['contact_phone']))
                                    <p class="text-dark-grey mb-0 skoleni-contact-info">{{ $section['contact_phone'] }}</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

            @endif
        @endforeach

    </div>
</section>

@endsection
@section('footer')
    <x-footer :showText="true" />
@endsection

