@extends('layouts.app')
@section('title', $page->title)
@section('seo')<x-seo-block :seo="$page->seo" :seo-item="$page"/>@endsection

@section('content')
<div style="height: 100px;"></div>

<section class="reference-content py-5 mb-5">
    <div class="container-fw" style="padding-left: 6.5rem; padding-right: 6.5rem;">
        <div class="row mb-3">
            <div class="col-12">
                @if(!empty($page->content['title']))
                    <h1 class="fw-bolder display-1 text-dark-grey scroll-in">{{ $page->content['title'] }}</h1>
                @endif
            </div>
        </div>
        @if(!empty($page->content['intro_text']))
        <div class="row mb-4">
            <div class="col-12">
                <p class="fw-light text-dark-grey fs-4 scroll-in">{{ $page->content['intro_text'] }}</p>
            </div>
        </div>
        @endif

        {{-- Hlavní reference --}}
        @php
            $featuredUrl = !empty($page->content['featured']['button']['buttonLink']) ? formatPageLink($page->content['featured']['button']['buttonLink']) : '#';
        @endphp
        @if(!empty($page->content['featured']['image']))
        <div class="row mb-4">
            <div class="col-12">
                <a href="{{ $featuredUrl }}" class="reference-image-link">
                    <div class="position-relative scroll-in featured-image-container" style="border-radius: 30px;">
                        <x-curator-glider :media="$page->content['featured']['image']" :alt="$page->content['featured']['location'] ?? ''" />
                        <div class="position-absolute bottom-0 end-0 p-4 pe-5 text-end">
                            @if(!empty($page->content['featured']['location']))
                                <h2 class="text-white fw-light mb-1 fs-1">{{ $page->content['featured']['location'] }}</h2>
                            @endif
                            @if(!empty($page->content['featured']['description']))
                                <p class="text-white fw-light mb-0 fs-4">{{ $page->content['featured']['description'] }}</p>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
        </div>
        @endif

        {{-- Grid referencí --}}
        @if(!empty($page->content['items']) && is_array($page->content['items']))
        <div class="row g-4">
            @foreach($page->content['items'] as $item)
                @php
                    $itemUrl = !empty($item['button']['buttonLink']) ? formatPageLink($item['button']['buttonLink']) : '#';
                @endphp
                @if(!empty($item['image']))
                <div class="col-md-4">
                    <a href="{{ $itemUrl }}" class="reference-image-link">
                        <div class="position-relative scroll-in grid-image-container" style="border-radius: 25px;">
                            <x-curator-glider :media="$item['image']" :alt="$item['location'] ?? ''" />
                            <div class="position-absolute bottom-0 end-0 p-3 pe-4 pb-4 text-end">
                                @if(!empty($item['location']))
                                    <h4 class="text-white fw-light mb-1 fs-1">{{ $item['location'] }}</h4>
                                @endif
                                @if(!empty($item['description']))
                                    <p class="text-white fw-light mb-0 fs-4">{{ $item['description'] }}</p>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
                @endif
            @endforeach
        </div>
        @endif
    </div>
</section>
@endsection

@section('footer')
<x-footer />
@endsection