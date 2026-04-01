@extends('layouts.app')
@section('title', $page->title)
@section('seo')<x-seo-block :seo="$page->seo" :seo-item="$page"/>@endsection

@section('content')
    <section class="mx-auto max-w-7xl px-4 pb-6 pt-28 sm:px-6 sm:pt-32 lg:px-8">
        <div class="rounded-xl border border-slate-200 bg-white p-6 sm:p-8">
            <h1 class="text-3xl font-extrabold text-slate-900 sm:text-4xl">
                {{ $page->title ?: 'Clanky' }}
            </h1>
            @if(!empty($page->subtitle))
                <p class="mt-3 max-w-3xl text-sm text-slate-600 sm:text-base">{{ $page->subtitle }}</p>
            @endif
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
        <livewire:content.articles-list />
    </section>

@endsection
@section('footer')
    <x-footer :showText="true" />
@endsection

