@extends('layouts.app')
@section('title', $page->title)
@section('seo')<x-seo-block :seo="$page->seo" :seo-item="$page"/>@endsection

@section('content')
<section class="bg-slate-50 py-16 sm:py-24">
    <div class="mx-auto max-w-5xl px-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm sm:p-12">
            <p class="text-sm font-semibold uppercase tracking-widest text-slate-500">Kontakt</p>
            <h1 class="mt-4 text-3xl font-bold tracking-tight text-slate-900 sm:text-5xl">
                {{ $page->title ?? 'Kontaktujte nás' }}
            </h1>
            <p class="mt-6 max-w-2xl text-base leading-7 text-slate-600">
                Níže můžete odeslat jednoduché kontaktní poptávky.
            </p>
        </div>

        <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <livewire:marketing.contact-form />
        </div>
    </div>
</section>
@endsection

@section('footer')
<x-footer :showText="true" />
@endsection