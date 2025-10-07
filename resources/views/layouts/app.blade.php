<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    
    @stack('head')
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header>
        <nav class="container">
            <a href="{{ url('/') }}">{{ config('app.name') }}</a>
            <a href="{{ route('tours.search') }}">Search Tours</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>

