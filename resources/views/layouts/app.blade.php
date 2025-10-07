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
    
    {{-- Scripts --}}
    @stack('scripts')
</body>
</html>