@extends('layouts.app')

@section('content')
{{-- Breadcrumb & Heading Section --}}
<section class="py-10 lg:py-12 border border-b-0 border-l-0 border-r-0 border-t-light-grey">
    <div class="container">
        <nav class="font-medium text-grey" aria-label="Breadcrumb">
            <ul class="flex flex-wrap items-center gap-1 mb-2">
                <li><a href="{{ url('/') }}" class="transition duration-200 hover:text-green-zomp">Home</a></li>
                <span class="mx-1">/</span>
                <li><span class="text-dark-grey">Destinations</span></li>
            </ul>
        </nav>
        <h1 class="text-black text-[40px] font-bold leading-[1.1em] mb-2">Explore Destinations</h1>
        <p class="text-dark-grey">Discover amazing places for your next adventure</p>
    </div>
</section>

{{-- Search Section --}}
<section class="py-10">
    <div class="container">
        <form method="GET" action="{{ route('destinations.index') }}" class="max-w-2xl mx-auto">
            <div class="flex gap-2">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search destinations..."
                       class="flex-1 px-4 py-3 border border-light-grey rounded-lg focus:outline-none focus:ring-2 focus:ring-green-zomp">
                <button type="submit" class="px-6 py-3 bg-green-zomp text-white font-semibold rounded-lg transition duration-200 hover:bg-green-zomp-hover">
                    Search
                </button>
                @if(request('search'))
                <a href="{{ route('destinations.index') }}" class="px-6 py-3 border border-light-grey text-dark-grey font-semibold rounded-lg transition duration-200 hover:bg-white-grey">
                    Clear
                </a>
                @endif
            </div>
        </form>
    </div>
</section>

{{-- Destinations Grid --}}
<section class="pb-[60px] md:pb-24">
    <div class="container">
        @if($destinations->count() > 0)
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($destinations as $destination)
                <article class="relative overflow-hidden bg-white border rounded-2xl border-light-grey transition duration-200 hover:shadow-lg">
                    <div class="relative overflow-hidden">
                        <a href="{{ route('destinations.show', $destination->slug) }}">
                            <img src="{{ $destination->getFirstMediaUrl('banner') ?: asset('assets/images/destination-banner.png') }}"
                                 alt="{{ $destination->name }}"
                                 class="object-cover w-full h-64 transition duration-300 hover:scale-105"
                                 loading="lazy"
                                 decoding="async">
                            @if($destination->is_featured)
                                <span class="absolute top-4 right-4 bg-green-zomp rounded py-1 px-3 text-white text-sm font-semibold">Featured</span>
                            @endif
                        </a>
                    </div>
                    <div class="p-6">
                        @if($destination->country)
                        <div class="flex items-center gap-2 mb-2">
                            <span class="iconify" data-icon="ep:location" data-width="14" data-height="14"></span>
                            <span class="text-sm text-dark-grey">{{ $destination->country->name }}</span>
                        </div>
                        @endif

                        <h2 class="mb-3 text-2xl font-bold text-black transition duration-200 hover:text-green-zomp">
                            <a href="{{ route('destinations.show', $destination->slug) }}">{{ $destination->name }}</a>
                        </h2>

                        @if($destination->excerpt)
                        <p class="mb-4 text-dark-grey line-clamp-3">{{ $destination->excerpt }}</p>
                        @endif

                        <div class="flex items-center justify-between pt-4 border-t border-light-grey">
                            <span class="text-sm text-dark-grey">
                                {{ $destination->tours()->where('status', 'published')->count() }} tours available
                            </span>
                            <a href="{{ route('destinations.show', $destination->slug) }}"
                               class="text-sm font-semibold text-green-zomp hover:underline">
                                Explore →
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($destinations->hasPages())
            <div class="mt-10">
                {{ $destinations->links() }}
            </div>
            @endif
        @else
            <div class="py-12 text-center">
                <div class="max-w-md mx-auto">
                    <span class="iconify text-dark-grey mb-4" data-icon="mdi:map-marker-off" data-width="64" data-height="64"></span>
                    <h3 class="text-2xl font-bold text-black mb-2">No destinations found</h3>
                    <p class="text-dark-grey mb-6">
                        @if(request('search'))
                            Try adjusting your search terms.
                        @else
                            Check back soon for new destinations!
                        @endif
                    </p>
                    @if(request('search'))
                    <a href="{{ route('destinations.index') }}" class="inline-block text-white text-sm font-semibold py-2.5 px-6 bg-green-zomp rounded-[200px] transition duration-200 hover:bg-green-zomp-hover">
                        View all destinations
                    </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
