@extends('layouts.app')
@section('title', $article->title)
@section('seo')
    <x-seo-block :seo="$article->content['seo'] ?? []" :seoItem="$article"  />
@endsection

@section('content')
    @php
        $tags = $article->getTags() ?: [];
        $articleTitle = $article->title ?: __('Článek');
    @endphp

    <section class="mx-auto max-w-4xl px-4 pb-12 pt-28 sm:px-6 sm:pt-32 lg:px-8">
        <article class="space-y-6 rounded-xl border border-slate-200 bg-white p-6 sm:p-8">
            <h1 class="text-3xl font-extrabold leading-tight text-slate-900 sm:text-4xl">
                {{ $articleTitle }}
            </h1>

            @if(count($tags) > 0)
                <div class="flex flex-wrap gap-2">
                    @foreach($tags as $tag)
                        <span class="rounded-full border border-slate-300 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-slate-700">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            @endif

            @if(!empty($article->content['image']))
                <div class="overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
                    <x-curator-glider :media="$article->content['image']" class="h-full w-full object-cover" />
                </div>
            @else
                <div class="overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
                    <img src="/assets/images/blog/picture-default.webp" alt="{{ $articleTitle }}" class="h-full w-full object-cover" loading="lazy">
                </div>
            @endif

            <div class="prose prose-slate max-w-none">
                {!! $article->content['text'] ?? '' !!}
            </div>
        </article>
    </section>
@endsection
@section('footer')
    <x-footer :showText="true" />
@endsection

