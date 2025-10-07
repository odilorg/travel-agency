<!DOCTYPE html>
<html class="scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- Meta Tags --}}
    <title>{{ $metaData['title'] ?? config('app.name') }}</title>
    @if(!empty($metaData['description']))
        <meta name="description" content="{{ $metaData['description'] }}">
    @endif
    @if(!empty($metaData['canonical']))
        <link rel="canonical" href="{{ $metaData['canonical'] }}">
    @endif
    @if(!empty($metaData['noindex']) && $metaData['noindex'])
        <meta name="robots" content="noindex,follow">
    @endif
    
    {{-- Open Graph / Twitter Cards --}}
    @if(!empty($metaData['og']))
        @foreach($metaData['og'] as $property => $content)
            <meta property="{{ $property }}" content="{{ $content }}">
        @endforeach
    @endif
    
    {{-- Template CSS First --}}
    <link rel="stylesheet" href="{{ asset('assets/css/tailwind83a7.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style83a7.css') }}">
    
    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Iconify for icons --}}
    <script src="https://code.iconify.design/3/3.1.1/iconify.min.js"></script>
    
    {{-- Additional head content --}}
    @stack('head')
</head>
<body class="antialiased font-urbanist">
    {{-- Header --}}
    @include('partials.header')
    
    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>
    
    {{-- Footer --}}
    @include('partials.footer')

    {{-- WhatsApp Floating Button --}}
    <a href="https://wa.me/998915550808" target="_blank" rel="noopener" aria-label="WhatsApp"
       class="flex items-center justify-center transition"
       style="position:fixed; bottom:2rem; right:2rem; z-index:10000; width:64px; height:64px; border-radius:9999px; background-color:#25D366; box-shadow:0 10px 24px rgba(0,0,0,0.25);">
        <span class="iconify" style="color:#fff;" data-icon="ic:baseline-whatsapp" data-width="34" data-height="34"></span>
    </a>

    {{-- Scripts --}}
    @stack('scripts')
</body>
</html>