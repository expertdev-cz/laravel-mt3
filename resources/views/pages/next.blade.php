@extends('layouts.app')
@section('title', $page->title)
@section('seo')<x-seo-block :seo="$page->seo" :seo-item="$page"/>@endsection

@section('content')

{{-- Hero sekce --}}
<div class="d-flex flex-column justify-content-center align-items-center next-background">
    <div class="showcase-spacer"></div>

    <div class="col-10 col-md-6">
        <div>
            @if(!empty($page->content['hero_eyebrow']))
                <p class="text-center text-dark-grey fs-5 fw-light scroll-in">{{ $page->content['hero_eyebrow'] }}</p>
            @endif
            @if(!empty($page->content['hero_heading']))
                <h2 class="text-center text-dark-grey fw-bold display-6 scroll-in">{{ $page->content['hero_heading'] }}</h2>
            @endif
            @if(!empty($page->content['hero_text']))
                <p class="text-center text-dark-grey fs-5 scroll-in">{{ $page->content['hero_text'] }}</p>
            @endif
        </div>
    </div>

    <div class="showcase-spacer"></div>

    @if(!empty($page->content['items']))
    <div class="grid-3x2">
        @foreach($page->content['items'] as $item)
            @php
                $imgId = $item['image'] ?? null;
                $imgId = is_array($imgId) ? ($imgId['id'] ?? $imgId['value'] ?? null) : $imgId;
                $imgUrl = $imgId ? \App\Services\Content\MediaService::getMediaUrl($imgId) : null;
            @endphp
            @if(!empty($item['title']) || $imgUrl)
            <div class="grid-item">
                <a href="#" class="no-decoration">
                    @if(!empty($item['title']))
                        <p class="text-dark-grey ps-4 fw-light fs-4 scroll-in">{{ $item['title'] }}</p>
                    @endif
                    @if($imgUrl)
                    <div class="position-relative scroll-in"
                        style="background-image: url('{{ $imgUrl }}'); width: 450px; height: 662px; border-radius: 8%;">
                        @if(!empty($item['location']))
                        <p class="position-absolute img-desc-bg text-white bottom-0 end-0 px-1 py-3 vertical-text fw-light fs-5">
                            <svg width="20" height="10" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="5" cy="5" r="5" fill="white" />
                            </svg>
                            {{ $item['location'] }}
                        </p>
                        @endif
                    </div>
                    @endif
                </a>
            </div>
            @endif
        @endforeach
    </div>
    @endif

    <div class="showcase-spacer"></div>
</div>
@endsection

@section('footer')
    <x-footer :showText="true" />
@endsection
