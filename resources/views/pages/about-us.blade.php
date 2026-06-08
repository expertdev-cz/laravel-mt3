@extends('layouts.app')
@section('title', $page->title)
@section('seo')<x-seo-block :seo="$page->seo" :seo-item="$page"/>@endsection

@section('content')
<section class="about-section position-relative pt-5">
    <div class="pt-5">

        {{-- Row 1: Titulek firmy --}}
        <div class="mb-3 mb-lg-5 pb-3 pb-lg-5 px-3 px-lg-5">
            <div class="col-12 col-md-9 ms-md-auto px-3 px-lg-5 pt-3 pt-lg-5">
                @if(!empty($page->content['hero_title']))
                    <h1 class="display-1 fw-bold mb-3 mb-lg-4 text-center text-md-end px-2 scroll-in">{{ $page->content['hero_title'] }}</h1>
                @endif
                @if(!empty($page->content['hero_text']))
                    <p class="lead fs-3 text-center text-md-end px-2 scroll-in">{{ $page->content['hero_text'] }}</p>
                @endif
            </div>
        </div>

        {{-- Row 2: Sekce O nás --}}
        @if(!empty($page->content['about_title']) || !empty($page->content['about_text']))
        <div class="">
            <div class="col-12 p-0">
                <div class="gray-bg-box p-3 p-lg-5">
                    <div class="row">
                        <div class="col-12 px-3 px-lg-5">
                            @if(!empty($page->content['about_title']))
                                <h2 class="mb-3 mb-lg-4 text-white display-4 scroll-in">{{ $page->content['about_title'] }}</h2>
                            @endif
                            @if(!empty($page->content['about_text']))
                                <div class="text-white fs-3 lead scroll-in">{!! $page->content['about_text'] !!}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Row 3: Základní info --}}
        @if(!empty($page->content['info_title']) || !empty($page->content['invoice_text']))
        <div class="px-3 px-lg-5 white-bg-box py-3 py-lg-5">
            <div class="col-12 mx-auto text-center text-white">
                @if(!empty($page->content['info_title']))
                    <h2 class="display-3 mb-3 mb-lg-5 mt-3 mt-lg-5 scroll-in">{{ $page->content['info_title'] }}</h2>
                @endif
                @if(!empty($page->content['invoice_title']))
                    <h5 class="mb-2 mb-lg-3 fs-3 lead scroll-in">{{ $page->content['invoice_title'] }}</h5>
                @endif
                @if(!empty($page->content['invoice_text']))
                    <p class="fs-3 lead scroll-in">{{ $page->content['invoice_text'] }}</p>
                @endif
                @if(!empty($page->content['location_title']))
                    <h5 class="mb-2 mb-lg-3 fs-3 lead scroll-in">{{ $page->content['location_title'] }}</h5>
                @endif
                @if(!empty($page->content['location_text']))
                    @if(!empty($page->content['location_url']))
                        <a href="{{ $page->content['location_url'] }}" target="_blank" rel="noopener noreferrer" class="text-decoration-none text-white">
                            <div class="d-flex flex-column flex-md-row align-items-center justify-content-center">
                                <p class="mb-2 mb-md-0 me-md-3 fs-3 lead scroll-in">{{ $page->content['location_text'] }}</p>
                                <img src="{{ asset('assets/icons/arrow-about-us.svg') }}" alt="" class="arrow-icon d-none d-md-inline">
                            </div>
                        </a>
                    @else
                        <p class="fs-3 lead scroll-in">{{ $page->content['location_text'] }}</p>
                    @endif
                @endif
                @if(!empty($page->content['closing_text']))
                    <div class="mt-3 mt-lg-5 pt-2 pt-lg-4">
                        <p class="display-3 fw-light pb-3 pb-lg-5 scroll-in">{{ $page->content['closing_text'] }}</p>
                    </div>
                @endif
            </div>
        </div>
        @endif

    </div>
</section>
@endsection

@section('footer')
<x-footer />
@endsection