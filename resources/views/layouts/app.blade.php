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

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
    <x-header-menu />

    <main>
        @yield('content')
    </main>

    @yield('footer')
    <x-footer-scripts />
    @livewireScripts
    @yield('styles')
</body>
</html>
