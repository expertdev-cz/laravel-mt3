@extends('layouts.app')
@section('title', $page->title)
@section('seo')<x-seo-block :seo="$page->seo" :seo-item="$page"/>@endsection

@section('content')
<section class="bg-slate-50 py-16 sm:py-24">
    <div class="mx-auto max-w-5xl px-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm sm:p-12">
            @if(data_get($page->content, 'title'))
                <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-5xl">{{ data_get($page->content, 'title') }}</h1>
            @endif
            @if(data_get($page->content, 'subtitle'))
                <p class="mt-6 max-w-2xl text-base leading-7 text-slate-600">{{ data_get($page->content, 'subtitle') }}</p>
            @endif
            @if(data_get($page->content, 'intro'))
                <div class="prose prose-slate mt-8 max-w-none">{!! data_get($page->content, 'intro') !!}</div>
            @endif
        </div>

        <div class="mt-8">
            <livewire:authorized-access.registration-form />
        </div>

        @if(data_get($page->content, 'support_title') || data_get($page->content, 'support_text'))
            <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                @if(data_get($page->content, 'support_title'))
                    <h2 class="text-xl font-semibold text-slate-900">{{ data_get($page->content, 'support_title') }}</h2>
                @endif
                @if(data_get($page->content, 'support_text'))
                    <p class="mt-3 whitespace-pre-line text-slate-600">{{ data_get($page->content, 'support_text') }}</p>
                @endif
            </div>
        @endif
    </div>
</section>
@endsection