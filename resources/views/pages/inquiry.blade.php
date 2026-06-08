@extends('layouts.app')
@section('title', $page->title)
@section('seo')<x-seo-block :seo="$page->seo" :seo-item="$page"/>@endsection

@section('content')
<section class="d-flex align-items-center pt-5 pb-5">
    <div class="container-fluid container-custom">
        <div class="showcase-spacer"></div>
        @if(data_get($page->content, 'title'))
            <h1 class="fw-light text-dark-grey mb-3 scroll-in" style="font-size: 6rem; line-height: 1.05;">{{ data_get($page->content, 'title') }}</h1>
        @endif
        @if(data_get($page->content, 'subtitle'))
            <p class="fw-light text-dark-grey mb-0 scroll-in" style="font-size: 2rem; line-height: 1.4;">{{ data_get($page->content, 'subtitle') }}</p>
        @endif
        @if(data_get($page->content, 'intro'))
            <div class="fw-light text-dark-grey mt-4 scroll-in">{!! data_get($page->content, 'intro') !!}</div>
        @endif
    </div>
</section>

<section class="py-4 mg-bottom-5rm">
    <hr class="ap-divider">
    <div class="container-fluid container-custom">
        <livewire:marketing.inquiry-form />
    </div>

    @if(data_get($page->content, 'support_title') || data_get($page->content, 'support_text'))
    <div class="container-fluid container-custom mt-5">
        @if(data_get($page->content, 'support_title'))
            <h2 class="text-dark-grey fw-light fs-2">{{ data_get($page->content, 'support_title') }}</h2>
        @endif
        @if(data_get($page->content, 'support_text'))
            <p class="text-dark-grey fw-light" style="white-space: pre-line;">{{ data_get($page->content, 'support_text') }}</p>
        @endif
    </div>
    @endif
</section>
@endsection

@section('footer')
<x-footer />
@endsection