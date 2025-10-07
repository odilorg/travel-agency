@extends('layouts.app')

@section('content')
<section class="pt-10 lg:pt-12 pb-2 border border-b-0 border-l-0 border-r-0 border-t-light-grey">
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
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 lg:col-span-9 order-2 lg:order-1">
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

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
                    @forelse($tours as $tour)
                        @include('components.tour-card', ['tour' => $tour])
                    @empty
                        <p class="col-span-3 text-dark-grey">No tours found.</p>
                    @endforelse
                </div>

                <div class="mt-10 sm:mt-16">
                    {{ $tours->onEachSide(1)->links() }}
                </div>
            </div>
            <aside class="col-span-12 lg:col-span-3 order-1 lg:order-2">
                <form method="GET" class="border border-light-grey rounded-2xl p-4 space-y-6">
                    <div>
                        <h4 class="text-xl font-semibold mb-3">Destination</h4>
                        <select name="city" class="w-full px-3 py-2 border border-light-grey rounded-lg">
                            <option value="">All Destinations</option>
                            @foreach(($cities ?? []) as $city)
                                <option value="{{ $city->slug }}" @selected(request('city') === $city->slug)>{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <h4 class="text-xl font-semibold mb-3">Category</h4>
                        <select name="category" class="w-full px-3 py-2 border border-light-grey rounded-lg">
                            <option value="">All Categories</option>
                            @foreach(($categories ?? []) as $cat)
                                <option value="{{ $cat->slug }}" @selected(request('category') === $cat->slug)>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <h4 class="text-xl font-semibold mb-3">Duration (days)</h4>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" min="0" name="min_days" value="{{ request('min_days') }}" placeholder="Min" class="px-3 py-2 border border-light-grey rounded-lg">
                            <input type="number" min="0" name="max_days" value="{{ request('max_days') }}" placeholder="Max" class="px-3 py-2 border border-light-grey rounded-lg">
                        </div>
                    </div>

                    <div>
                        <h4 class="text-xl font-semibold mb-3">Price ($)</h4>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" min="0" step="0.01" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="px-3 py-2 border border-light-grey rounded-lg">
                            <input type="number" min="0" step="0.01" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="px-3 py-2 border border-light-grey rounded-lg">
                        </div>
                    </div>

                    <div>
                        <h4 class="text-xl font-semibold mb-3">Rating</h4>
                        <select name="rating" class="w-full px-3 py-2 border border-light-grey rounded-lg">
                            <option value="">Any</option>
                            <option value="4.5" @selected(request('rating')==='4.5')>4.5+ stars</option>
                            <option value="4" @selected(request('rating')==='4')>4.0+ stars</option>
                            <option value="3.5" @selected(request('rating')==='3.5')>3.5+ stars</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-2">
                        <button class="bg-green-zomp text-white font-semibold py-2 px-4 rounded-[200px]" type="submit">Apply</button>
                        <a href="{{ route('tours.index') }}" class="text-grey">Clear</a>
                    </div>
                </form>
            </aside>
        </div>
    </div>
</section>
@endsection


