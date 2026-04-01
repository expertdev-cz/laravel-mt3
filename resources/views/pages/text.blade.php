@extends('layouts.app')
@section('title', $page->title)
@section('seo')<x-seo-block :seo="$page->seo" :seo-item="$page"/>@endsection

@section('content')
    <x-header :title="$page->title" :subtitle="$page->subtitle" />

    <section class="privacy-policy-area ptb-100 py-15">
        <div class="container">
            <div class="privacy-policy-wrap rich-editor-highlight">
                {!! $page->content['pageContent'] !!}
            </div>
        </div>
    </section>

@endsection
@section('footer')
    <x-footer :showText="true" />
@endsection

