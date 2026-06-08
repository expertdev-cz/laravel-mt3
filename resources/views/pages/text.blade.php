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
        @if(!empty($page->subtitle))
            <p class="fw-light text-dark-grey mb-0 scroll-in text-page-subtitle">{{ $page->subtitle }}</p>
        @endif
    </div>
</section>

@if(!empty($page->content['pageContent']))
<section class="py-4 mg-bottom-5rm">
    <hr class="ap-divider">
    <div class="container-fluid container-custom">
        <div class="rich-editor-highlight scroll-in">
            {!! $page->content['pageContent'] !!}
        </div>
    </div>
</section>
@endif

@endsection
@section('footer')
    <x-footer :showText="true" />
@endsection

