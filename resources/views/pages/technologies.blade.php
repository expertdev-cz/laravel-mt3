@extends('layouts.app')
@section('title', $page->title)
@section('seo')<x-seo-block :seo="$page->seo" :seo-item="$page"/>@endsection

@section('content')
{{-- Blok 1 --}}
@php
    $bg1 = !empty($page->content['block_1']['background_image']) ? \App\Services\Content\MediaService::getMediaUrl($page->content['block_1']['background_image']) : null;
@endphp
@if($bg1 || !empty($page->content['block_1']['title']))
<section class="position-relative overflow-hidden" style="@if($bg1)background: url('{{ $bg1 }}') center/cover no-repeat;@endif min-height: 945px;">
    <div class="container-fluid" style="padding-left: 5rem; padding-right: 5rem; min-height: 945px;">
        <div class="row" style="min-height: 945px;">
            <div class="col-md-6 d-flex align-items-end" style="min-height: 945px;">
                @if(!empty($page->content['block_1']['side_label']))
                    <div class="text-white p-4 mb-5 pb-5 scroll-in" style="margin-bottom: 2rem !important;">
                        <p class="display-1 mb-0" style="font-size: 4rem;">{{ $page->content['block_1']['side_label'] }}</p>
                    </div>
                @endif
            </div>
            <div class="col-md-6 d-flex align-items-start" style="min-height: 945px;">
                <div class="text-white text-end ms-auto p-4 pt-5 scroll-in" style="margin-top: 8rem;">
                    @if(!empty($page->content['block_1']['title']))
                        <h1 class="mb-4" style="font-size: 5rem;">{{ $page->content['block_1']['title'] }}</h1>
                    @endif
                    @if(!empty($page->content['block_1']['text']))
                        <p class="fw-light" style="font-size: 1.6rem;">{{ $page->content['block_1']['text'] }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- Blok 2 --}}
@php
    $bg2 = !empty($page->content['block_2']['background_image']) ? \App\Services\Content\MediaService::getMediaUrl($page->content['block_2']['background_image']) : null;
@endphp
@if($bg2 || !empty($page->content['block_2']['title']))
<section class="position-relative overflow-hidden" style="@if($bg2)background: url('{{ $bg2 }}') center/cover no-repeat;@endif min-height: 1080px;">
    <div class="container-fluid" style="padding-left: 5rem; padding-right: 5rem; min-height: 1080px;">
        <div class="row" style="min-height: 1080px;">
            <div class="col-md-6 d-flex align-items-start" style="min-height: 1080px;">
                <div class="text-white p-4 pt-5 scroll-in" style="margin-top: 8rem;">
                    @if(!empty($page->content['block_2']['title']))
                        <h1 class="mb-4" style="font-size: 5rem;">{{ $page->content['block_2']['title'] }}</h1>
                    @endif
                    @if(!empty($page->content['block_2']['text']))
                        <p class="fw-light" style="font-size: 1.6rem;">{!! nl2br(e($page->content['block_2']['text'])) !!}</p>
                    @endif
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-end" style="min-height: 1080px;">
                @if(!empty($page->content['block_2']['side_label']))
                    <div class="text-white text-end ms-auto p-4 mb-5 pb-5 scroll-in" style="margin-bottom: 2rem !important;">
                        <p class="display-1 mb-0" style="font-size: 4rem;">{{ $page->content['block_2']['side_label'] }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

{{-- Servisní sekce s tabulkou + Ohraňování --}}
@if(!empty($page->content['service_intro']) || !empty($page->content['materials']) || !empty($page->content['bending']['title']) || !empty($page->content['bending']['image']))
<section class="py-5 bg-light">
    <div style="padding-left: 5rem; padding-right: 5rem;">

        {{-- Laser sekce --}}
        <div class="row mb-5">
            @if(!empty($page->content['service_intro']))
            <div class="col-12 mb-5">
                <p class="mb-5 fs-4 fw-light scroll-in text-dark-grey ps-4">{{ $page->content['service_intro'] }}</p>
            </div>
            @endif

            <div class="col-md-7 mb-4">
                @if(!empty($page->content['materials']) && is_array($page->content['materials']))
                <div class="ps-4">
                    <table class="fs-4 scroll-in text-dark-grey" style="width: 70%; border-collapse: collapse; background: transparent;">
                        @foreach($page->content['materials'] as $row)
                            @if(($row['type'] ?? 'row') === 'header' && $loop->first)
                                <thead>
                                    <tr style="border-bottom: 2px solid #999;">
                                        <th style="padding: 4px 0; text-align: left; background: transparent; font-weight: 500;">{{ $row['label'] ?? '' }}</th>
                                        <th style="padding: 4px 0; text-align: right; background: transparent; font-weight: 500;">{{ $row['value'] ?? '' }}</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-light">
                            @elseif(($row['type'] ?? 'row') === 'header')
                                <tr style="border-bottom: 2px solid #999;">
                                    <td colspan="2" style="padding: 50px 0 4px 0; background: transparent; font-weight: 500;">{{ $row['label'] ?? '' }}</td>
                                </tr>
                            @else
                                @if($loop->first)<tbody class="fw-light">@endif
                                <tr>
                                    <td style="padding: 4px 0; border: none; background: transparent;">{{ $row['label'] ?? '' }}</td>
                                    <td style="padding: 4px 0; border: none; background: transparent; text-align: right;">{{ $row['value'] ?? '' }}</td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>

            <div class="col-md-5 d-flex align-items-end justify-content-end">
                <div class="text-end scroll-in text-dark-grey pe-4">
                    @if(!empty($page->content['service_contact_title']))
                        <h3 class="display-3 mb-1" style="font-weight: 500;">{{ $page->content['service_contact_title'] }}</h3>
                    @endif
                    @if(!empty($page->content['service_contact_subtitle']))
                        <p class="fs-4 mb-4 fw-semibold">{{ $page->content['service_contact_subtitle'] }}</p>
                    @endif
                    @if(!empty($page->content['service_contact_name']))
                        <p class="fs-4 fw-bold mb-0">{{ $page->content['service_contact_name'] }}</p>
                        <div style="border-bottom: 1px solid #999; width: 150%; margin-left: -50%;"></div>
                    @endif
                    @if(!empty($page->content['service_contact_email']))
                        <p class="fs-4 mb-1"><a href="mailto:{{ $page->content['service_contact_email'] }}" class="text-dark-grey">{{ $page->content['service_contact_email'] }}</a></p>
                    @endif
                    @if(!empty($page->content['service_contact_phone']))
                        <p class="fs-4"><a href="tel:{{ preg_replace('/\s+/', '', $page->content['service_contact_phone']) }}" class="text-dark-grey">{{ $page->content['service_contact_phone'] }}</a></p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Sekce ohraňování --}}
        @if(!empty($page->content['bending']['title']) || !empty($page->content['bending']['image']))
        <div style="margin: 8rem 0;"></div>
        <div class="row align-items-start">
            <div class="col-md-5 mb-4">
                <div class="ps-4">
                    @if(!empty($page->content['bending']['image']))
                        <x-curator-glider :media="$page->content['bending']['image']" class="img-fluid shadow scroll-in" style="width: 90%; height: auto; aspect-ratio: 3/4; object-fit: cover; border-radius: 15px;" />
                    @endif
                </div>
            </div>
            <div class="col-md-7">
                @if(!empty($page->content['bending']['title']))
                    <h2 class="display-1 text-end mb-4 scroll-in text-dark-grey pe-4" style="font-weight: 500;">{{ $page->content['bending']['title'] }}</h2>
                @endif
                @if(!empty($page->content['bending']['text']))
                    <p class="mb-4 fs-4 fw-light text-end mb-5 scroll-in text-dark-grey pe-4">{!! nl2br(e($page->content['bending']['text'])) !!}</p>
                @endif

                <div style="margin: 18rem 0;"></div>

                <div class="col-md-4 text-end ms-auto scroll-in text-dark-grey pe-4">
                    @if(!empty($page->content['bending_contact_title']))
                        <h4 class="display-3 mb-1" style="font-weight: 500;">{{ $page->content['bending_contact_title'] }}</h4>
                    @endif
                    @if(!empty($page->content['bending_contact_subtitle']))
                        <p class="fs-4 mb-4 fw-semibold">{{ $page->content['bending_contact_subtitle'] }}</p>
                    @endif
                    @if(!empty($page->content['bending_contact_name']))
                        <p class="fs-4 fw-bold mb-0">{{ $page->content['bending_contact_name'] }}</p>
                        <div style="border-bottom: 1px solid #999; width: 120%; margin-left: -20%;"></div>
                    @endif
                    @if(!empty($page->content['bending_contact_email']))
                        <p class="fs-4 mb-1"><a href="mailto:{{ $page->content['bending_contact_email'] }}" class="text-dark-grey">{{ $page->content['bending_contact_email'] }}</a></p>
                    @endif
                    @if(!empty($page->content['bending_contact_phone']))
                        <p class="fs-4"><a href="tel:{{ preg_replace('/\s+/', '', $page->content['bending_contact_phone']) }}" class="text-dark-grey">{{ $page->content['bending_contact_phone'] }}</a></p>
                    @endif
                </div>
            </div>
        </div>
        <div style="margin: 5rem 0;"></div>
        @endif

    </div>
</section>
@endif

{{-- Blok 4 --}}
@php
    $bg4 = !empty($page->content['block_4']['background_image']) ? \App\Services\Content\MediaService::getMediaUrl($page->content['block_4']['background_image']) : null;
@endphp
@if($bg4 || !empty($page->content['block_4']['title']))
<section class="position-relative overflow-hidden" style="@if($bg4)background: url('{{ $bg4 }}') center/cover no-repeat;@endif min-height: 945px;">
    <div class="container-fluid" style="padding-left: 5rem; padding-right: 5rem; min-height: 945px;">
        <div class="row" style="min-height: 945px;">
            <div class="col-md-6 d-flex align-items-start" style="min-height: 945px;">
                <div class="text-white p-4 pt-5 scroll-in" style="margin-top: 8rem;">
                    @if(!empty($page->content['block_4']['title']))
                        <h1 class="mb-4" style="font-size: 5rem;">{{ $page->content['block_4']['title'] }}</h1>
                    @endif
                    @if(!empty($page->content['block_4']['text']))
                        <p class="fw-light" style="font-size: 1.6rem;">{!! nl2br(e($page->content['block_4']['text'])) !!}</p>
                    @endif
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-end" style="min-height: 945px;">
                @if(!empty($page->content['block_4']['side_label']))
                    <div class="text-white text-end ms-auto p-4 mb-5 pb-5 scroll-in" style="margin-bottom: 2rem !important;">
                        <p class="display-1 mb-0" style="font-size: 4rem;">{{ $page->content['block_4']['side_label'] }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endif
@endsection

@section('footer')
<x-footer />
@endsection