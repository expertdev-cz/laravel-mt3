@extends('layouts.app')
@section('title', $page->title)
@section('seo')<x-seo-block :seo="$page->seo" :seo-item="$page"/>@endsection

@section('content')
<section class="d-flex align-items-center pt-5 pb-5">
    <div class="container-fluid container-custom">
        <div class="showcase-spacer"></div>
        @if(data_get($page->content, 'title'))
            <h1 class="text-dark-grey mb-3 scroll-in text-page-h1">{{ data_get($page->content, 'title') }}</h1>
        @endif
        @if(data_get($page->content, 'subtitle'))
            <p class="fw-light text-dark-grey mb-0 scroll-in text-page-subtitle">{{ data_get($page->content, 'subtitle') }}</p>
        @endif
    </div>
</section>

<section class="py-4 mg-bottom-5rm">
    <hr class="ap-divider">
    <div class="container-fluid container-custom">
        <livewire:authorized-access.registration-form />
        @if(data_get($page->content, 'support_title') || data_get($page->content, 'support_text'))
            <div class="mt-4">
                @if(data_get($page->content, 'support_title'))
                    <p class="mt-4 text-page-text text-dark-grey">{{ data_get($page->content, 'support_title') }}</p>
                @endif
                @if(data_get($page->content, 'support_text'))
                    <p class="mt-3 text-page-text text-dark-grey fw-light">{{ data_get($page->content, 'support_text') }}</p>
                @endif
            </div>
        @endif
    </div>
</section>
@endsection

@section('footer')
<x-footer />
@endsection