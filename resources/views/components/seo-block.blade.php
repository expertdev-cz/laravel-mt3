@if(isset($seo))
    {{-- Základní meta --}}
    @if(!empty($seo['keywords']))
        <meta name="keywords" content="{{ $seo['keywords'] }}">
    @endif

    @if(!empty($seo['desc']))
        <meta name="description" content="{{ $seo['desc'] }}">
    @endif

    {{-- Zakomentované do spuštění --}}
    @if(!empty($seo['robots']))
        <meta name="robots" content="{{ $seo['robots'] }}, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    @endif

    {{-- Kanonická URL + og:url --}}
    @if(!empty($seo['canonical_URL']))
        <link rel="canonical" href="{{ $seo['canonical_URL'] }}">
        <meta property="og:url" content="{{ $seo['canonical_URL'] }}">
    @endif

    {{-- Open Graph --}}
    @if(!empty($seo['og_type']))
        <meta property="og:type" content="{{ $seo['og_type'] }}">
    @endif

    @if(!empty($seo['og_title']))
        <meta property="og:title" content="{{ $seo['og_title'] }}">
    @endif

    @if(!empty($seo['og_desc']))
        <meta property="og:description" content="{{ $seo['og_desc'] }}">
    @endif

    @if(!empty($seo['og_image']))
        <meta property="og:image" content="{{ url('storage/' . $seo['og_image']) }}">
    @endif

    {{-- Twitter --}}
    @if(!empty($seo['twitter_title']))
        <meta name="twitter:title" content="{{ $seo['twitter_title'] }}">
    @endif

    @if(!empty($seo['twitter_desc']))
        <meta name="twitter:description" content="{{ $seo['twitter_desc'] }}">
    @endif

    @if(!empty($seo['twitter_image']))
        <meta name="twitter:image" content="{{ url('storage/' . $seo['twitter_image']) }}">
    @endif

    {{-- Hreflang --}}
    @if(!empty($seo['hreflang']) && is_array($seo['hreflang']))
        @foreach($seo['hreflang'] as $alt)
            @if(!empty($alt['locale']) && !empty($alt['url']))
                <link rel="alternate" hreflang="{{ $alt['locale'] }}" href="{{ $alt['url'] }}">
            @endif
        @endforeach
    @endif

    @if(!empty($updatedAtIso))
        <meta property="article:modified_time" content="{{ $updatedAtIso }}">
    @endif

    {{-- Externí vlastní meta/snippety --}}
    @if(!empty($seo['external']))
        {!! $seo['external'] !!}
    @endif
@endif
