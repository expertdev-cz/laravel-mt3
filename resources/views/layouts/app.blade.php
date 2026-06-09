<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @php
        $seoTitle = $page->seo['title'] ?? null;
        if (!empty($seoTitle)) {
            $metaTitle = $seoTitle;
        } else {
            $pageTitle = trim($__env->yieldContent('title'));
            $suffix = !empty($globalSettings['webName']) ? ' | ' . $globalSettings['webName'] : '';
            $metaTitle = $pageTitle . $suffix;
        }
    @endphp

    <title>{{ $metaTitle }}</title>
    @yield('seo')
    @stack('head')
    @livewireStyles

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    @yield('styles')
</head>
<body>
    <div class="ultra-wide-container">
        @unless(View::hasSection('header_in_hero'))
            <x-header-menu />
        @endunless
        @yield('content')
        @yield('footer')
    </div>

    <x-footer-scripts />
    @stack('scripts')
    @livewireScripts
</body>
</html>
