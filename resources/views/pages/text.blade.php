@extends('layouts.app')
@section('title', $page->title)
@section('seo')<x-seo-block :seo="$page->seo" :seo-item="$page"/>@endsection

@section('content')
    <x-header :title="$page->title" :subtitle="$page->subtitle" />

    <section class="privacy-policy-area ptb-100 py-15">
        <div class="container">
            @if(!empty($page->content['pageContent']))
            <div class="privacy-policy-wrap rich-editor-highlight mb-5">
                {!! $page->content['pageContent'] !!}
            </div>
            @endif

            @foreach($page->content['sections'] ?? [] as $section)
                @php
                    $layout = $section['layout'] ?? 'full';
                    $image = $section['image'] ?? null;
                    $imageId = is_array($image) ? ($image['id'] ?? $image['value'] ?? null) : $image;
                    $imageUrl = $imageId ? \App\Services\Content\MediaService::getMediaUrl($imageId) : null;
                    $hasContact = filled($section['contact_title'] ?? null) || filled($section['contact_subtitle'] ?? null) || filled($section['contact_name'] ?? null) || filled($section['contact_email'] ?? null) || filled($section['contact_phone'] ?? null);
                @endphp

                @continue(blank($section['title'] ?? null) && blank($section['text'] ?? null) && !$imageUrl && empty($section['items'] ?? []) && !$hasContact)

                <div class="mb-5 scroll-in">
                    @if(in_array($layout, ['image_left', 'image_right'], true))
                        <div class="row align-items-center g-5 {{ $layout === 'image_left' ? 'flex-md-row-reverse' : '' }}">
                            <div class="col-md-6">
                                @if(!empty($section['title']))
                                    <p class="fw-semibold text-dark-grey mb-3 text-page-subtitle">{{ $section['title'] }}</p>
                                @endif

                                @if(!empty($section['text']))
                                    <div class="fw-light text-dark-grey text-page-text rich-editor-highlight">{!! $section['text'] !!}</div>
                                @endif
                            </div>

                            @if($imageUrl)
                                <div class="col-md-6 text-center">
                                    <img src="{{ $imageUrl }}" alt="{{ $section['image_alt'] ?? $section['title'] ?? '' }}" class="img-fluid">
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="{{ $layout === 'narrow' ? 'col-lg-8' : '' }}">
                            @if($imageUrl)
                                <img src="{{ $imageUrl }}" alt="{{ $section['image_alt'] ?? $section['title'] ?? '' }}" class="img-fluid mb-4">
                            @endif

                            @if(!empty($section['title']))
                                <p class="fw-semibold text-dark-grey mb-3 text-page-subtitle">{{ $section['title'] }}</p>
                            @endif

                            @if(!empty($section['text']))
                                <div class="fw-light text-dark-grey text-page-text rich-editor-highlight">{!! $section['text'] !!}</div>
                            @endif
                        </div>
                    @endif

                    @if(!empty($section['items']))
                        <ul class="list-unstyled text-dark-grey mb-5 text-page-text">
                            @foreach($section['items'] as $item)
                                @continue(blank($item['title'] ?? null) && blank($item['text'] ?? null))
                                <li class="mb-3 fw-light">
                                    @if(!empty($item['title']))
                                        <span>- {{ $item['title'] }}</span>
                                    @endif
                                    @if(!empty($item['text']))
                                        <br><span class="ms-3">{{ $item['text'] }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    @if($hasContact)
                        <div class="row justify-content-end">
                            <div class="col-md-3 offset-md-6 text-end">
                                @if(!empty($section['contact_title']))
                                    <p class="fw-bold text-dark-grey mb-0">{{ $section['contact_title'] }}</p>
                                @endif
                                @if(!empty($section['contact_subtitle']))
                                    <p class="fw-normal text-dark-grey mb-3">{{ $section['contact_subtitle'] }}</p>
                                @endif
                                <hr>
                                @if(!empty($section['contact_name']))
                                    <p class="fw-bold text-dark-grey mb-1">{{ $section['contact_name'] }}</p>
                                @endif
                                @if(!empty($section['contact_email']))
                                    <p class="text-dark-grey mb-1">{{ $section['contact_email'] }}</p>
                                @endif
                                @if(!empty($section['contact_phone']))
                                    <p class="text-dark-grey mb-0">{{ $section['contact_phone'] }}</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </section>

@endsection
@section('footer')
    <x-footer :showText="true" />
@endsection

