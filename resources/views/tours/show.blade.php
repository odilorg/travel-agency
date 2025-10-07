@extends('layouts.app')

@section('content')
<style>
    /* Force desktop layout on large screens */
    @media (min-width: 1024px) {
        .gallery-container { display: grid !important; grid-template-columns: repeat(12, minmax(0, 1fr)) !important; }
        .gallery-main { grid-column: span 8 / span 8 !important; }
        .gallery-side { grid-column: span 4 / span 4 !important; display: flex !important; flex-direction: column !important; }
        .content-container { display: grid !important; grid-template-columns: repeat(12, minmax(0, 1fr)) !important; }
        .content-main { grid-column: span 8 / span 8 !important; }
        .content-sidebar { grid-column: span 4 / span 4 !important; }
    }
</style>
{{-- Sticky Navigation --}}
<section id="scroll-nav" class="[box-shadow:0px_9px_16px_0px_#0000001F] py-6 px-10 bg-white hidden">
    <ul class="flex items-center justify-center gap-14">
        <li><a href="#overview" class="text-dark-grey font-semibold [&.active]:text-green-zomp transition duration-200 before:content-[''] before:absolute before:left-0 before:-bottom-1 before:w-full before:h-[2px] before:scale-x-0 before:bg-green-zomp before:transition before:duration-200 [&.active]:before:scale-x-100 relative">Overview</a></li>
        <li><a href="#what-to-expect" class="text-dark-grey font-semibold [&.active]:text-green-zomp transition duration-200 before:content-[''] before:absolute before:left-0 before:-bottom-1 before:w-full before:h-[2px] before:scale-x-0 before:bg-green-zomp before:transition before:duration-200 [&.active]:before:scale-x-100 relative">What To Expect</a></li>
        <li><a href="#map" class="text-dark-grey font-semibold [&.active]:text-green-zomp transition duration-200 before:content-[''] before:absolute before:left-0 before:-bottom-1 before:w-full before:h-[2px] before:scale-x-0 before:bg-green-zomp before:transition before:duration-200 [&.active]:before:scale-x-100 relative">Map</a></li>
        <li><a href="#faqs" class="text-dark-grey font-semibold [&.active]:text-green-zomp transition duration-200 before:content-[''] before:absolute before:left-0 before:-bottom-1 before:w-full before:h-[2px] before:scale-x-0 before:bg-green-zomp before:transition before:duration-200 [&.active]:before:scale-x-100 relative">FAQs</a></li>
        <li><a href="#reviews" class="text-dark-grey font-semibold [&.active]:text-green-zomp transition duration-200 before:content-[''] before:absolute before:left-0 before:-bottom-1 before:w-full before:h-[2px] before:scale-x-0 before:bg-green-zomp before:transition before:duration-200 [&.active]:before:scale-x-100 relative">Reviews</a></li>
    </ul>
</section>

{{-- Breadcrumb --}}
<section class="pt-10 lg:pt-12 pb-2 border border-b-0 border-l-0 border-r-0 border-t-light-grey">
    <div class="container">
        <nav class="font-medium text-grey" aria-label="Breadcrumb">
            <ul class="flex flex-wrap items-center gap-1 mb-2">
                <li><a href="{{ route('home') }}" class="transition duration-200 hover:text-green-zomp">Home</a></li>
                <span class="mx-1">/</span>
                <li><a href="{{ route('tours.search') }}" class="transition duration-200 hover:text-green-zomp">Tours</a></li>
                <span class="mx-1">/</span>
                <li><span class="text-dark-grey">{{ $tour->title }}</span></li>
            </ul>
        </nav>
    </div>
</section>

{{-- Tour Details --}}
<section class="mb-[60px] md:mb-24">
    <div class="container">
        <div class="tours-details-wrap">
            {{-- Header Section --}}
            <div class="grid grid-cols-12 gap-6 items-end justify-between mb-6">
                <div class="col-span-12 lg:col-span-8">
                    <h1 class="text-black text-2xl lg:text-[32px] font-bold leading-[1.1em] mb-4">{{ $tour->title }}</h1>
                    
                    {{-- Tags --}}
                    @if($tour->is_featured || $tour->categories->isNotEmpty())
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        @if($tour->is_featured)
                            <span class="inline-block px-2 py-1 text-sm font-semibold rounded text-darker-grey bg-white-grey">Featured</span>
                        @endif
                        @foreach($tour->categories as $category)
                            <span class="inline-block px-2 py-1 text-sm font-semibold rounded text-darker-grey bg-white-grey">{{ $category->name }}</span>
                        @endforeach
                    </div>
                    @endif
                    
                    {{-- Rating & Info --}}
                    <div class="flex flex-wrap items-center gap-2">
                        @if($tour->average_rating)
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($tour->average_rating))
                                    <span class="iconify text-orange-yellow" data-icon="mdi:star"></span>
                                @elseif($i - 0.5 <= $tour->average_rating)
                                    <span class="iconify text-orange-yellow" data-icon="mdi:star-half-full"></span>
                                @else
                                    <span class="iconify text-grey" data-icon="mdi:star-outline"></span>
                                @endif
                            @endfor
                            <span class="text-dark-grey ml-2">({{ $tour->reviews_count }} reviews)</span>
                        </div>
                        @endif
                        <ul class="flex items-center gap-7 list-disc marker:text-[#C0C5C9] pl-5">
                            @if($tour->city)
                                <li class="text-dark-grey">{{ $tour->city->name }}</li>
                            @endif
                            @if($tour->booking_count)
                                <li class="text-dark-grey">{{ number_format($tour->booking_count) }} booked</li>
                            @endif
                        </ul>
                    </div>
                </div>
                
                {{-- Share Button --}}
                <div class="col-span-12 lg:col-span-4 flex justify-end items-end">
                    <div class="relative inline-block group">
                        <div class="cursor-pointer flex items-center gap-2 text-black font-semibold transition duration-200 hover:text-green-zomp">
                            <span class="iconify" data-icon="solar:share-outline" data-width="24" data-height="24"></span>
                            Share
                        </div>
                        <div class="absolute shadow-shadow-custom left-auto right-0 py-6 px-4 mt-3 w-[350px] bg-white rounded-lg invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-200 z-50">
                            <h4 class="text-darker-grey text-2xl font-semibold mb-4">Share</h4>
                            <div class="border-b border-light-grey mb-4"></div>
                            <ul class="grid grid-cols-4 gap-x-4">
                                <li class="flex flex-col items-center">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="bg-[#3C58A5] w-9 h-9 rounded-full flex items-center justify-center">
                                        <span class="iconify text-white" data-icon="bxl:facebook" data-width="20" data-height="20"></span>
                                    </a>
                                    <span class="block text-sm text-dark-grey mt-2">Facebook</span>
                                </li>
                                <li class="flex flex-col items-center">
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($tour->title) }}" target="_blank" class="bg-white w-9 h-9 rounded-full flex items-center justify-center">
                                        <span class="iconify text-black" data-icon="ri:twitter-x-fill" data-width="20" data-height="20"></span>
                                    </a>
                                    <span class="block text-sm text-dark-grey mt-2">Twitter</span>
                                </li>
                                <li class="flex flex-col items-center">
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" class="bg-[#0077FF] w-9 h-9 rounded-full flex items-center justify-center">
                                        <span class="iconify text-white" data-icon="ri:linkedin-fill" data-width="20" data-height="20"></span>
                                    </a>
                                    <span class="block text-sm text-dark-grey mt-2">LinkedIn</span>
                                </li>
                                <li class="flex flex-col items-center">
                                    <a href="https://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&description={{ urlencode($tour->title) }}" target="_blank" class="bg-[#F54848] w-9 h-9 rounded-full flex items-center justify-center">
                                        <span class="iconify text-white" data-icon="jam:pinterest" data-width="20" data-height="20"></span>
                                    </a>
                                    <span class="block text-sm text-dark-grey mt-2">Pinterest</span>
                                </li>
                            </ul>
                            <div class="mt-5 bg-white-grey rounded-lg py-2 px-3 flex items-center gap-2">
                                <input type="text" class="copy-input text-grey bg-white-grey px-5 py-2 rounded-lg outline-none w-full" value="{{ url()->current() }}" readonly>
                                <button class="btn-copy-link bg-green-zomp text-white py-1.5 px-2 rounded-lg w-[80px] text-center">Copy</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Gallery --}}
            <div class="gallery-container grid grid-cols-12 gap-6 mb-8">
                @php
                    $images = $tour->getMedia('gallery');
                    $mainImage = $images->first();
                @endphp

                {{-- Main Large Image --}}
                <div class="gallery-main col-span-12 lg:col-span-8">
                    @if($mainImage)
                        <a data-fancybox="gallery" href="{{ $mainImage->getUrl() }}" class="block overflow-hidden rounded-xl aspect-[4/3]">
                            <img src="{{ $mainImage->getUrl('gallery') }}" alt="{{ $tour->title }}" class="w-full h-full object-cover object-center" loading="eager" />
                        </a>
                    @else
                        <div class="overflow-hidden rounded-xl aspect-[4/3]">
                            <img src="{{ asset('assets/images/tours/placeholder.jpg') }}" alt="{{ $tour->title }}" class="w-full h-full object-cover object-center" />
                        </div>
                    @endif
                </div>

                {{-- Side Images --}}
                <div class="gallery-side col-span-12 grid grid-cols-2 lg:col-span-4 lg:flex lg:flex-col gap-4">
                    {{-- First side image --}}
                    @if($images->count() > 1)
                        <a data-fancybox="gallery" href="{{ $images->get(1)->getUrl() }}" class="block overflow-hidden rounded-xl aspect-[4/3]">
                            <img src="{{ $images->get(1)->getUrl('gallery') }}" alt="{{ $tour->title }}" class="w-full h-full object-cover object-center" loading="lazy" />
                        </a>
                    @endif

                    {{-- Second side image with Gallery button --}}
                    @if($images->count() > 2)
                        <div class="relative overflow-hidden rounded-xl aspect-[4/3]">
                            <a data-fancybox="gallery" href="{{ $images->get(2)->getUrl() }}" class="block">
                                <img src="{{ $images->get(2)->getUrl('gallery') }}" alt="{{ $tour->title }}" class="w-full h-full object-cover object-center" loading="lazy" />
                            </a>
                            @if($images->count() > 3)
                                <button type="button" class="absolute bottom-3 right-3 bg-white text-black px-4 py-2.5 rounded-full font-semibold flex items-center gap-2 transition duration-200 hover:bg-green-zomp hover:text-white shadow-lg" onclick="Fancybox.show(document.querySelectorAll('[data-fancybox=gallery]'), { startIndex: 3 })">
                                    <span class="iconify" data-icon="dashicons:grid-view" data-width="18" data-height="18"></span>
                                    Gallery
                                </button>
                            @endif
                        </div>
                    @endif

                    {{-- Hidden gallery images for Fancybox --}}
                    @foreach($images->slice(3) as $image)
                        <a data-fancybox="gallery" href="{{ $image->getUrl() }}" class="hidden"></a>
                    @endforeach
                </div>
            </div>
            
            {{-- Main Content --}}
            <div class="content-container grid grid-cols-12 gap-6">
                <div class="content-main col-span-12 lg:col-span-8">
                    {{-- Quick Info --}}
                    <div class="sm:flex flex-wrap items-center justify-center p-4 bg-white-grey sm:gap-3 md:gap-10 lg:gap-20 rounded-2xl">
                        @if($tour->duration_text)
                        <div class="flex flex-1 items-center gap-2">
                            <span class="iconify text-green-zomp" data-icon="fluent:clock-24-regular" data-width="22" data-height="22"></span>
                            <span class="text-dark-grey">
                                <span>Duration:</span>
                                <span>{{ $tour->duration_text }}</span>
                            </span>
                        </div>
                        @endif
                        <div class="flex flex-1 items-center gap-2">
                            <span class="iconify text-green-zomp" data-icon="solar:global-linear" data-width="22" data-height="22"></span>
                            <span class="text-dark-grey">
                                <span>Language:</span>
                                <span>English</span>
                            </span>
                        </div>
                        @if($tour->categories->isNotEmpty())
                        <div class="flex items-center gap-2">
                            <span class="iconify text-green-zomp" data-icon="solar:dollar-linear" data-width="22" data-height="22"></span>
                            <span class="text-dark-grey">
                                <span>Tour type:</span>
                                <span>{{ $tour->categories->pluck('name')->join(', ') }}</span>
                            </span>
                        </div>
                        @endif
                    </div>
                    
                    <div class="tours-content">
                        {{-- Overview Section --}}
                        <div id="overview" class="border border-white-grey rounded-2xl p-6 mt-6 bg-white mb-6">
                            <h3 class="text-black text-2xl font-semibold leading-[1.1] mb-6">Overview</h3>
                            
                            @if($tour->excerpt)
                                <p class="text-dark-grey mb-6">{{ $tour->excerpt }}</p>
                            @endif
                            
                            @if($tour->description_html)
                                <div class="text-dark-grey prose max-w-none mb-6">
                                    {!! $tour->description_html !!}
                                </div>
                            @endif
                            
                            {{-- Highlights --}}
                            @if($tour->highlights->isNotEmpty())
                                <div class="h-px w-full bg-light-grey my-8"></div>
                                <h3 class="text-black text-2xl font-semibold leading-[1.1] mb-6">Highlights</h3>
                                <ul class="list-disc pl-5 text-dark-grey space-y-2">
                                    @foreach($tour->highlights as $highlight)
                                        <li>{{ $highlight->label }}</li>
                                    @endforeach
                                </ul>
                            @endif
                            
                            {{-- What's Included / Excluded --}}
                            @if($tour->inclusions->isNotEmpty() || $tour->exclusions->isNotEmpty())
                                <div class="h-px w-full bg-light-grey my-8"></div>
                                <h3 class="text-black text-2xl font-semibold leading-[1.1] mb-6">What's Included</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10">
                                    @if($tour->inclusions->isNotEmpty())
                                    <ul class="text-dark-grey space-y-4">
                                        @foreach($tour->inclusions as $inclusion)
                                        <li class="flex gap-2">
                                            <span class="iconify text-green-zomp" data-icon="ic:outline-check" data-width="20" data-height="20"></span>
                                            <p>{{ $inclusion->label }}</p>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                    
                                    @if($tour->exclusions->isNotEmpty())
                                    <ul class="text-dark-grey space-y-4 mt-4 md:mt-0">
                                        @foreach($tour->exclusions as $exclusion)
                                        <li class="flex gap-2">
                                            <span class="iconify text-[#FF0000]" data-icon="ic:sharp-clear" data-width="20" data-height="20"></span>
                                            <p>{{ $exclusion->label }}</p>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </div>
                            @endif
                        </div>
                        
                        {{-- Itinerary Section --}}
                        @if($tour->itineraryItems->isNotEmpty())
                        <div id="what-to-expect" class="border border-white-grey rounded-2xl p-6 mt-6 bg-white mb-6">
                            <h3 class="text-black text-2xl font-semibold leading-[1.1] mb-6">What To Expect</h3>
                            <div class="flex flex-col relative">
                                @foreach($tour->itineraryItems as $item)
                                <div class="relative flex items-start md:before:content-[''] md:before:absolute md:before:top-11 md:before:left-[22px] md:before:w-px md:before:bg-green-zomp md:last:before:hidden md:before:h-full">
                                    <div class="relative z-10">
                                        <div class="h-11 w-11 rounded-full border border-green-zomp bg-white hidden md:flex items-center justify-center text-green-zomp font-bold">{{ $loop->iteration }}</div>
                                    </div>
                                    <div class="md:ml-6 flex-1 {{ !$loop->last ? 'mb-8' : '' }}">
                                        <h6 class="text-black font-bold mb-2">{{ $item->title }}</h6>
                                        @if($item->body_html)
                                            <div class="text-dark-grey prose max-w-none">
                                                {!! $item->body_html !!}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        {{-- Map Section --}}
                        @if($tour->latitude && $tour->longitude)
                        <div id="map" class="border border-white-grey rounded-2xl p-6 mt-6 bg-white mb-6">
                            <h3 class="text-black text-2xl font-semibold leading-[1.1] mb-6">Map</h3>
                            <iframe loading="lazy" src="https://maps.google.com/maps?q={{ $tour->latitude }},{{ $tour->longitude }}&t=m&z=12&output=embed&iwloc=near" title="{{ $tour->title }}" aria-label="{{ $tour->title }}" class="w-full h-[400px] rounded-2xl"></iframe>
                        </div>
                        @endif
                        
                        {{-- FAQs Section --}}
                        @if($tour->faqs->isNotEmpty())
                        <div id="faqs" class="border border-white-grey rounded-2xl p-6 mt-6 bg-white mb-6">
                            <h3 class="text-black text-2xl font-semibold leading-[1.1] mb-6">Frequently Asked Questions</h3>
                            <div class="accordion-style">
                                @foreach($tour->faqs as $faq)
                                <div class="pb-6 border-b accordion-items border-light-grey last:border-none {{ $loop->first ? '' : 'pt-6' }}">
                                    <h4 class="accordion-title text-black text-xl font-bold [&.active]:text-green-zomp [&.active]:mb-3 flex items-center gap-4 justify-between cursor-pointer">
                                        {{ $faq->question }}
                                        <span class="text-black transition-all duration-200 iconify" data-icon="meteor-icons:angle-down" data-width="20" data-height="20"></span>
                                    </h4>
                                    <div class="accordion-brief text-dark-grey prose max-w-none">
                                        {!! $faq->answer_html !!}
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        {{-- Reviews Section --}}
                        <div id="reviews" class="border border-white-grey rounded-2xl p-6 mt-6 bg-white">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-black text-2xl font-semibold leading-[1.1]">Reviews</h3>
                            </div>
                            
                            @if($tour->reviews_count > 0)
                            <div class="grid grid-cols-12 xl:gap-12 mb-8">
                                <div class="col-span-12 xl:col-span-4">
                                    <div class="flex items-center gap-6">
                                        <h4 class="text-[40px] font-bold text-black leading-[1.1]">{{ number_format($tour->average_rating, 1) }}/5</h4>
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span class="iconify text-orange-yellow" data-icon="mdi:star" data-width="32" data-height="32"></span>
                                            @endfor
                                        </div>
                                    </div>
                                    <span class="text-dark-grey">({{ $tour->reviews_count }} reviews)</span>
                                </div>
                                
                                <div class="col-span-12 xl:col-span-8 space-y-3 mt-4 md:mt-0">
                                    @foreach([5,4,3,2,1] as $rating)
                                    @php
                                        $count = $tour->reviews->where('rating', $rating)->count();
                                        $percentage = $tour->reviews_count > 0 ? ($count / $tour->reviews_count * 100) : 0;
                                    @endphp
                                    <div class="flex items-center gap-4">
                                        <p class="w-[60px]">{{ $rating }} stars</p>
                                        <div class="relative h-2 bg-light-grey rounded-full overflow-hidden flex-1">
                                            <div class="absolute inset-0 bg-green-zomp h-full" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <p class="w-[40px] text-right">{{ $count }}</p>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            {{-- Review List --}}
                            @foreach($tour->reviews->where('approved', true)->take(10) as $review)
                            <div class="bg-white-grey rounded-lg p-6 {{ !$loop->first ? 'mt-4' : '' }}">
                                <div class="flex items-center mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="iconify text-orange-yellow" data-icon="mdi:star" data-width="16" data-height="16"></span>
                                    @endfor
                                </div>
                                @if($review->title)
                                    <h5 class="text-black font-bold mb-2">{{ $review->title }}</h5>
                                @endif
                                <p class="text-dark-grey mb-2">{{ $review->body }}</p>
                                <div class="flex items-center gap-2">
                                    <span class="text-dark-grey font-semibold">{{ $review->author_name }}</span>
                                    <span class="text-grey">•</span>
                                    <span class="text-grey">{{ $review->created_at->format('F Y') }}</span>
                                    @if($review->verified_booking)
                                        <span class="text-green-zomp text-sm">✓ Verified Booking</span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                            @else
                            <p class="text-dark-grey">No reviews yet. Be the first to review this tour!</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Sidebar with Booking Widget --}}
                <div class="content-sidebar col-span-12 lg:col-span-4">
                    <div class="border-2 border-green-zomp rounded-2xl p-6 bg-white-grey">
                        @php
                            $lowestPrice = $tour->price_from ?? $tour->priceOptions->where('is_active', true)->min('price');
                        @endphp

                        @if($lowestPrice)
                            <h4 class="text-black text-[32px] font-semibold leading-[1.1] mb-6"><span class="text-dark-grey text-base font-medium mr-2">From</span>${{ number_format($lowestPrice, 2) }}</h4>
                        @endif

                        @if(session('success'))
                            <div class="mb-4 px-4 py-3 rounded bg-green-100 text-green-800 border border-green-300">{{ session('success') }}</div>
                        @endif
                        @if ($errors->any())
                            <div class="mb-4 px-4 py-3 rounded bg-red-100 text-red-800 border border-red-300">
                                <ul class="list-disc pl-5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="tabs-wrapper">
                            {{-- Tab Buttons --}}
                            <div class="border-2 border-green-zomp rounded-lg mb-6 flex">
                                <button type="button" class="flex-1 p-3 text-center font-semibold text-green-zomp [&.active]:bg-green-zomp [&.active]:text-white tabs-btn-panel active" data-tab="booking">Booking</button>
                                <button type="button" class="flex-1 p-3 text-center font-semibold text-green-zomp [&.active]:bg-green-zomp [&.active]:text-white tabs-btn-panel" data-tab="inquiry">Inquiry</button>
                            </div>

                            {{-- Booking Tab --}}
                            <div class="tabs-img-panel active" id="booking-panel">
                                <p class="text-black font-semibold mb-3">Select Date and Travelers</p>
                                <form action="{{ route('contact') }}" method="POST" class="text-dark-grey">
                                    @csrf
                                    <input type="hidden" name="tour_slug" value="{{ $tour->slug }}">
                                    <input type="hidden" name="tour_title" value="{{ $tour->title }}">
                                    <input type="hidden" name="inquiry_type" value="booking">

                                    <div class="mb-5">
                                        <input type="text" id="first_name" name="first_name" placeholder="First name" required class="w-full border border-light-grey rounded-lg py-2.5 px-4 outline-none">
                                    </div>
                                    <div class="mb-5">
                                        <input type="text" id="last_name" name="last_name" placeholder="Last name" required class="w-full border border-light-grey rounded-lg py-2.5 px-4 outline-none">
                                    </div>
                                    <div class="mb-5">
                                        <input type="email" id="email" name="email" placeholder="Email" required class="w-full border border-light-grey rounded-lg py-2.5 px-4 outline-none">
                                    </div>
                                    <div class="mb-5">
                                        <input type="tel" id="phone" name="phone" placeholder="Phone" class="w-full border border-light-grey rounded-lg py-2.5 px-4 outline-none">
                                    </div>
                                    <div class="mb-5">
                                        <input type="date" id="check_in" name="check_in" placeholder="Date check in" required class="w-full border border-light-grey rounded-lg py-2.5 px-4 outline-none cursor-pointer" min="{{ date('Y-m-d') }}">
                                    </div>

                                    @if($tour->extras->isNotEmpty())
                                        <p class="mb-2.5 font-semibold">Extra</p>
                                        @foreach($tour->extras as $extra)
                                            <div class="mb-2.5">
                                                <label class="flex items-center gap-2 text-dark-grey cursor-pointer">
                                                    <input type="checkbox" name="extras[]" value="{{ $extra->id }}" class="w-4 h-4">
                                                    {{ $extra->label }} (${{ number_format($extra->price, 2) }})
                                                </label>
                                            </div>
                                        @endforeach
                                    @endif

                                    <div class="mb-5 space-y-2">
                                        @php
                                            $activeOptions = $tour->priceOptions->where('is_active', true);
                                        @endphp
                                        @foreach($activeOptions as $option)
                                            <label class="flex items-center">
                                                <input type="number" name="pax[{{ $option->id }}]" value="0" min="0" class="w-20 border border-light-grey rounded-lg py-1 px-4 outline-none cursor-pointer" />
                                                <span class="ml-2">{{ $option->name }} x ${{ number_format($option->price, 2) }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                    <button type="submit" class="text-white font-semibold py-4 px-6 w-full bg-green-zomp rounded-[200px] transition duration-200 hover:bg-green-zomp-hover hover:-translate-y-[5px]">Booking Now</button>
                                </form>
                            </div>

                            {{-- Inquiry Tab --}}
                            <div class="tabs-img-panel hidden" id="inquiry-panel">
                                <p class="mb-4">Fill up the form below to tell us what you're looking for</p>
                                <form action="{{ route('contact') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="tour_slug" value="{{ $tour->slug }}">
                                    <input type="hidden" name="tour_title" value="{{ $tour->title }}">
                                    <input type="hidden" name="inquiry_type" value="inquiry">

                                    <div class="mb-5">
                                        <input type="text" name="name" placeholder="Your name*" required class="w-full border border-light-grey rounded-lg py-2.5 px-4 outline-none">
                                    </div>
                                    <div class="mb-5">
                                        <input type="email" name="email" placeholder="Email*" required class="w-full border border-light-grey rounded-lg py-2.5 px-4 outline-none">
                                    </div>
                                    <div class="mb-5">
                                        <textarea name="message" placeholder="Message" rows="6" class="w-full border border-light-grey rounded-lg py-2.5 px-4 outline-none"></textarea>
                                    </div>
                                    <button type="submit" class="w-full bg-green-zomp text-white text-center font-semibold py-4 px-10 rounded-[200px] uppercase">Send enquiry</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching functionality
    const tabButtons = document.querySelectorAll('.tabs-btn-panel');
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');

            // Remove active class from all buttons and panels
            document.querySelectorAll('.tabs-btn-panel').forEach(btn => {
                btn.classList.remove('active', 'bg-green-zomp', 'text-white');
                btn.classList.add('text-green-zomp');
            });
            document.querySelectorAll('.tabs-img-panel').forEach(panel => {
                panel.classList.remove('active');
                panel.classList.add('hidden');
            });

            // Add active class to clicked button and corresponding panel
            this.classList.add('active', 'bg-green-zomp', 'text-white');
            this.classList.remove('text-green-zomp');
            document.getElementById(targetTab + '-panel').classList.add('active');
            document.getElementById(targetTab + '-panel').classList.remove('hidden');
        });
    });

    // Accordion functionality
    const accordionTitles = document.querySelectorAll('.accordion-title');
    accordionTitles.forEach(title => {
        title.addEventListener('click', function() {
            this.classList.toggle('active');
            const brief = this.nextElementSibling;
            if (brief.style.display === 'none' || !brief.style.display) {
                brief.style.display = 'block';
            } else {
                brief.style.display = 'none';
            }
        });
        // Hide all briefs initially except first
        if (!title.classList.contains('active')) {
            title.nextElementSibling.style.display = 'none';
        }
    });

    // Copy link functionality
    const copyBtn = document.querySelector('.btn-copy-link');
    if (copyBtn) {
        copyBtn.addEventListener('click', function() {
            const input = document.querySelector('.copy-input');
            input.select();
            document.execCommand('copy');
            this.textContent = 'Copied!';
            setTimeout(() => {
                this.textContent = 'Copy';
            }, 2000);
        });
    }
    
    // Sticky navigation
    const scrollNav = document.getElementById('scroll-nav');
    const observer = new IntersectionObserver(
        ([entry]) => {
            if (!entry.isIntersecting) {
                scrollNav.classList.remove('hidden');
            } else {
                scrollNav.classList.add('hidden');
            }
        },
        { threshold: 0 }
    );
    
    const firstSection = document.getElementById('overview');
    if (firstSection) {
        observer.observe(firstSection);
    }
});
</script>
@endpush
