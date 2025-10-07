@extends('layouts.app')

@section('content')
<section class="py-10 lg:py-12 border border-b-0 border-l-0 border-r-0 border-t-light-grey">
    <div class="container">
        <nav class="font-medium text-grey" aria-label="Breadcrumb">
            <ul class="flex flex-wrap items-center gap-1 mb-2">
                <li><a href="{{ route('home') }}" class="transition duration-200 hover:text-green-zomp">Home</a></li>
                <span class="mx-1">/</span>
                <li><span class="text-dark-grey">Tours</span></li>
            </ul>
        </nav>
        <h1 class="text-black text-[40px] font-bold leading-[1.1em] mb-2">Tours</h1>
        <p class="text-dark-grey">Explore experiences, spas, tours and more</p>
    </div>
    </section>

<section class="mb-[60px] md:mb-24">
    <div class="container">
        {{-- Results Count & Sort --}}
        <div class="bg-white-grey rounded-xl p-4 flex flex-wrap sm:flex-row items-center justify-between gap-5 sm:gap-0 mb-6">
            <p>
                @php($from = ($tours->currentPage()-1)*$tours->perPage()+1)
                @php($to = min($tours->total(), $tours->currentPage()*$tours->perPage()))
                Showing {{ $from }}–{{ $to }} of {{ $tours->total() }} results
            </p>
            <form method="GET" class="w-full sm:w-1/2 flex items-center justify-between sm:justify-end space-x-4">
                <span class="font-semibold text-dark-grey">Sort by</span>
                <div class="relative">
                    <select name="sort" class="px-4 py-3 pr-8 font-semibold text-black bg-white rounded-lg appearance-none cursor-pointer focus-visible:outline-none"
                            onchange="this.form.submit()">
                        <option value="new" @selected(request('sort','new')==='new')>Sort by newness</option>
                        <option value="popularity" @selected(request('sort')==='popularity')>Sort by popularity</option>
                        <option value="rating" @selected(request('sort')==='rating')>Sort by average rating</option>
                        <option value="price_asc" @selected(request('sort')==='price_asc')>Sort by price: low to high</option>
                        <option value="price_desc" @selected(request('sort')==='price_desc')>Sort by price: high to low</option>
                    </select>
                    <div class="absolute inset-y-0 flex items-center pointer-events-none right-3">
                        <span class="text-black iconify" data-icon="meteor-icons:angle-down" data-width="20" data-height="20"></span>
                    </div>
                </div>
            </form>
        </div>

        {{-- Tours Grid --}}
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @forelse($tours as $tour)
                @include('components.tour-card', ['tour' => $tour])
            @empty
                <p class="col-span-4 text-center text-dark-grey py-12">No tours found.</p>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-10 sm:mt-16">
            {{ $tours->onEachSide(1)->links('components.pagination') }}
        </div>
    </div>
</section>
@endsection


