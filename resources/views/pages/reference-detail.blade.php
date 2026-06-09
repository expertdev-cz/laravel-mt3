@extends('layouts.app')
@section('title', $page->title)
@section('seo')<x-seo-block :seo="$page->seo" :seo-item="$page"/>@endsection

@section('content')
<div style="height: 100px;"></div>

<section class="reference-content py-5">
    <div class="container-fw" style="padding-left: 6.5rem; padding-right: 6.5rem;">
        @if(!empty($page->content['title']))
        <div class="row mb-3">
            <div class="col-12">
                <h1 class="fw-bolder display-1 text-dark-grey scroll-in">{{ $page->content['title'] }}</h1>
            </div>
        </div>
        @endif
        @if(!empty($page->content['intro_text']))
        <div class="row mb-4">
            <div class="col-12">
                <p class="fw-light text-dark-grey fs-4 scroll-in">{{ $page->content['intro_text'] }}</p>
            </div>
        </div>
        @endif
    </div>

    {{-- Carousel obrázků --}}
    @if(!empty($page->content['carousel_images']) && is_array($page->content['carousel_images']))
    <div class="reference-carousel-container mb-0">
        <div class="reference-carousel position-relative">
            <div class="carousel-track-container">
                <div class="carousel-track d-flex align-items-center" id="referenceCarouselTrack">
                    @foreach($page->content['carousel_images'] as $mediaId)
                        @if(!empty($mediaId))
                        <div class="carousel-item-custom">
                            <x-curator-glider :media="$mediaId" class="carousel-image" />
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <button class="carousel-arrow carousel-arrow-left" onclick="moveCarousel(-1)">
                <img src="{{ asset('assets/icons/caousel-arrow.svg') }}" alt="Previous">
            </button>
            <button class="carousel-arrow carousel-arrow-right" onclick="moveCarousel(1)">
                <img src="{{ asset('assets/icons/caousel-arrow.svg') }}" alt="Next">
            </button>
        </div>
    </div>
    @endif

    {{-- Detail informace --}}
    <div class="container-fw" style="padding-left: 6.5rem; padding-right: 6.5rem;">
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6">
                @if(!empty($page->content['detail_title']))
                <div class="mb-4 d-flex align-items-center">
                    <h3 class="text-dark-grey mb-0 me-3">{{ $page->content['detail_title'] }}</h3>
                    <img src="{{ asset('assets/icons/select_icon.svg') }}" alt="" style="height: 12px;">
                </div>
                @endif
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        @foreach(['location' => null, 'count' => null, 'product_code' => null, 'year' => null] as $field => $label)
                            @if(!empty($page->content[$field]))
                                <p class="text-dark-grey fs-4 mb-0">{{ $page->content[$field] }}</p>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="text-end mt-4">
                    <a href="{{ url()->previous() }}" class="btn btn-link text-dark-grey p-0">
                        <img src="{{ asset('assets/icons/reference-back.svg') }}" alt="Zpět" style="width: 200px; height: 200px;">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('footer')
<x-footer />
@endsection

@push('scripts')
<script src="{{ asset('assets/js/carousel-reference.js') }}"></script>
@endpush