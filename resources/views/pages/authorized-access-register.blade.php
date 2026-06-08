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
        @if(data_get($page->content, 'intro'))
            <div class="fw-light text-dark-grey mt-3 scroll-in">{!! data_get($page->content, 'intro') !!}</div>
        @endif
    </div>
</section>

<section class="py-4 mg-bottom-5rm">
    <hr class="ap-divider">
    <div class="container-fluid container-custom">
        <livewire:authorized-access.registration-form />
    </div>
</section>
@endsection

@section('footer')
<x-footer />
@endsection