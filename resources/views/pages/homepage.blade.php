@extends('layouts.app')
@section('title', $page->title)
@section('seo')<x-seo-block :seo="$page->seo" :seo-item="$page"/>@endsection

@section('content')
<section class="py-14 sm:py-20">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
        <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm sm:p-10">
            <p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Homepage</p>
            @if(isset($page->content['heading']))
                <h1 class="mt-3 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                    {{ $page->content['heading'] }}
                </h1>
            @endif

            @if(isset($page->content['body']))
                <div class="prose prose-slate mt-6 max-w-none">
                    {!! $page->content['body'] !!}
                </div>
            @endif

            @if(isset($page->content['button_text']) && isset($page->content['button_url']))
                <div class="mt-8">
                    <a href="{{ $page->content['button_url'] }}" class="inline-flex items-center rounded-lg bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-700">
                        {{ $page->content['button_text'] }}
                    </a>
                </div>
            @endif
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
            @if(!empty($page->content['image']))
                <x-curator-glider :media="$page->content['image']" class="h-full w-full rounded-xl object-cover" />
            @endif
        </div>
    </div>

    @if(!empty($page->content['images']) && is_array($page->content['images']))
        <div class="mx-auto mt-10 max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($page->content['images'] as $mediaId)
                    @if(!empty($mediaId))
                        <figure class="overflow-hidden rounded-xl border border-slate-200 bg-white p-2 shadow-sm">
                            <x-curator-glider :media="$mediaId" class="h-56 w-full rounded-lg object-cover" />
                        </figure>
                    @endif
                @endforeach
            </div>
        </div>
    @endif
</section>
@endsection

@section('footer')
<x-footer :showText="true" />
@endsection
