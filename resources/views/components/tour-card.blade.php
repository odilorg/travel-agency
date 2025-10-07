<article class="relative overflow-hidden transition duration-200">
    <div class="bg-white border rounded-2xl border-light-grey">
        <div class="relative overflow-hidden rounded-t-2xl">
            <a href="{{ route('tours.show', $tour->slug) }}">
                @if($tour->getFirstMediaUrl('gallery'))
                    <img src="{{ $tour->getFirstMediaUrl('gallery') }}" alt="{{ $tour->title }}" class="object-cover w-full h-auto transition duration-300 hover:scale-105" loading="lazy">
                @else
                    <img src="{{ asset('assets/images/tours/placeholder.png') }}" alt="{{ $tour->title }}" class="object-cover w-full h-auto transition duration-300 hover:scale-105">
                @endif
                
                @if($tour->is_on_sale)
                    <span class="absolute top-4 right-4 bg-[#F51D35] rounded py-1 px-2 text-white text-sm font-semibold">On Sale</span>
                @endif
            </a>
        </div>
        
        <div class="p-4">
            {{-- Location --}}
            <div class="flex items-center gap-2 mb-2">
                <span class="iconify" data-icon="ep:location" data-width="14" data-height="14"></span>
                <span class="text-sm text-dark-grey">
                    @if($tour->city)
                        {{ $tour->city->name }}@if($tour->destination), {{ $tour->destination->name }}@endif
                    @elseif($tour->destination)
                        {{ $tour->destination->name }}
                    @else
                        Various Locations
                    @endif
                </span>
            </div>

            {{-- Title --}}
            <h4 class="mb-2 text-base font-bold text-black transition duration-200 line-clamp-2 hover:text-green-zomp">
                <a href="{{ route('tours.show', $tour->slug) }}">{{ $tour->title }}</a>
            </h4>

            {{-- Rating --}}
            <div class="flex items-center mb-2 text-orange-yellow">
                @php($rating = $tour->average_rating ?? 5)
                @php($fullStars = floor($rating))
                @php($hasHalfStar = ($rating - $fullStars) >= 0.5)
                
                @for($i = 0; $i < $fullStars; $i++)
                    <span class="iconify" data-icon="mdi:star"></span>
                @endfor
                
                @if($hasHalfStar)
                    <span class="iconify" data-icon="mdi:star-half-full"></span>
                @endif
                
                @for($i = 0; $i < (5 - $fullStars - ($hasHalfStar ? 1 : 0)); $i++)
                    <span class="iconify" data-icon="mdi:star-outline"></span>
                @endfor
                
                <span class="ml-2 text-dark-grey">({{ $tour->reviews_count ?? 0 }} reviews)</span>
            </div>

            {{-- Categories/Tags --}}
            @if($tour->categories && $tour->categories->count() > 0)
                <div class="flex flex-wrap items-center gap-2">
                    @foreach($tour->categories->take(3) as $category)
                        <a href="{{ route('tours.index', ['category' => $category->slug]) }}" 
                           class="inline-block px-2 py-1 text-sm font-semibold rounded text-darker-grey bg-white-grey category-tag transition hover:bg-green-zomp hover:text-white">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            @endif

            <div class="h-px my-4 border-t border-light-grey"></div>

            {{-- Old Price (if on sale) --}}
            @if($tour->is_on_sale && $tour->regular_price)
                <div class="mb-1 text-sm font-bold line-through text-grey">${{ number_format($tour->regular_price, 2) }}</div>
            @endif

            {{-- Price & Duration --}}
            <div class="flex items-center justify-between gap-2">
                <span class="flex items-center gap-1">
                    <span>From</span>
                    <span class="text-base font-bold text-green-zomp">
                        ${{ number_format($tour->price_from ?? $tour->regular_price ?? 0, 2) }}
                    </span>
                </span>
                <span class="flex items-center gap-1">
                    <span class="iconify text-dark-grey" data-icon="fluent:clock-24-regular" data-width="15" data-height="15"></span>
                    <div class="text-sm text-dark-grey">
                        @if($tour->duration_days)
                            @if($tour->duration_days == 1)
                                1 day
                            @elseif($tour->duration_nights)
                                {{ $tour->duration_days }} days {{ $tour->duration_nights }} nights
                            @else
                                {{ $tour->duration_days }} days
                            @endif
                        @else
                            Flexible
                        @endif
                    </div>
                </span>
            </div>
        </div>
    </div>
</article>

