@extends('layouts.app')

@section('content')
{{-- Breadcrumb, Title & Excerpt Section --}}
<section class="pt-10 lg:pt-12 pb-4">
    <div class="container">
        <nav class="font-medium text-grey mb-4" aria-label="Breadcrumb">
            <ul class="flex flex-wrap items-center gap-1">
                <li><a href="{{ url('/') }}" class="transition duration-200 hover:text-green-zomp">Home</a></li>
                <span class="mx-1">/</span>
                <li><a href="{{ route('destinations.index') }}" class="transition duration-200 hover:text-green-zomp">Tours</a></li>
                <span class="mx-1">/</span>
                <li><span class="text-green-zomp">{{ $destination->name }}</span></li>
            </ul>
        </nav>
        <h1 class="text-black text-[40px] font-bold leading-[1.1em] mb-3">{{ $destination->name }}</h1>
        @if($destination->excerpt)
            <p class="text-green-zomp mb-4">{{ $destination->excerpt }}</p>
        @endif
    </div>
</section>

{{-- Banner with Quick Facts --}}
<section class="py-8 mb-[60px] md:mb-24">
  <div class="container">
    <div class="relative overflow-hidden bg-center bg-cover rounded-2xl"
         style="background-image:url('{{ $destination->getFirstMediaUrl('banner') ?: asset('assets/images/destination-banner.png') }}'); min-height:420px;"
         role="img" aria-label="{{ $destination->name }} banner">

      <div class="absolute left-6 right-6 bottom-6">
        <div class="bg-white-grey rounded-2xl p-4 flex flex-wrap items-center justify-center gap-4 md:gap-6 lg:gap-8 xl:gap-10"
             role="complementary" aria-label="Quick facts about {{ $destination->name }}">
          @php $facts = [
            ['icon'=>'solar:global-linear','label'=>'Language','value'=>data_get($destination->facts,'language','English')],
            ['icon'=>'solar:dollar-linear','label'=>'Currency','value'=>data_get($destination->facts,'currency','USD')],
            ['icon'=>'famicons:accessibility-outline','label'=>'Religion','value'=>data_get($destination->facts,'religion','—')],
            ['icon'=>'lucide:layers','label'=>'Timezone','value'=>data_get($destination->facts,'timezone','UTC')],
          ]; @endphp

          @foreach($facts as $fact)
            <div class="flex items-center gap-2 basis-1/2 md:basis-auto">
              <span class="iconify text-green-zomp" data-icon="{{ $fact['icon'] }}" data-width="22" data-height="22"></span>
              <span class="text-dark-grey">
                <span>{{ $fact['label'] }}:</span>
                <strong class="text-darker-grey">{{ $fact['value'] }}</strong>
              </span>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>

{{-- History/Intro Section --}}
@if($destination->description_html)
<section class="mb-[60px] md:mb-24">
    <div class="container">
        <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-5 md:gap-12">
            <div class="wrapper order-2 md:order-1">
                @if($destination->excerpt)
                    <p class="mb-2 font-semibold text-green-zomp">{{ $destination->excerpt }}</p>
                @endif
                <h2 class="text-black font-bold text-[32px] mb-8 leading-[1.1em]">Discover {{ $destination->name }}</h2>
                <div class="text-dark-grey prose prose-p:text-dark-grey max-w-none">
                    {!! $destination->description_html !!}
                </div>
            </div>
            <img src="{{ $destination->getFirstMedia('gallery') ? $destination->getFirstMedia('gallery')->getUrl() : asset('assets/images/destination-01.png') }}"
                 alt="{{ $destination->name }}"
                 class="object-cover w-full h-auto rounded-2xl order-1 md:order-2"
                 loading="lazy"
                 decoding="async" />
        </div>
    </div>
</section>
@endif

{{-- Seasonal Activities Accordion --}}
@if($destination->activities->count() > 0)
<section class="mb-[60px] md:mb-24">
    <div class="container">
        <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-5 md:gap-12">
            <img src="{{ $destination->getMedia('gallery')->skip(1)->first()?->getUrl() ?? asset('assets/images/destination-02.png') }}"
                 alt="{{ $destination->name }} activities"
                 class="object-cover w-full h-auto rounded-2xl"
                 loading="lazy"
                 decoding="async" />
            <div class="wrapper">
                <h2 class="text-black font-bold text-[32px] mb-8 leading-[1.1em]">Seasonal Activities</h2>
                <div class="accordion-style">
                    @foreach($destination->activities as $activity)
                    <div class="py-6 border-b accordion-items border-light-grey last:border-none first:pt-0">
                        <h4 class="accordion-title text-black text-xl font-bold [&.active]:text-green-zomp [&.active]:mb-3 flex items-center gap-4 justify-between cursor-pointer"
                            role="button"
                            aria-expanded="false"
                            aria-controls="activity-{{ $activity->id }}">
                            {{ $activity->title }}
                            <span class="text-black transition-all duration-200 iconify" data-icon="meteor-icons:angle-down" data-width="20" data-height="20"></span>
                        </h4>
                        <div id="activity-{{ $activity->id }}" class="accordion-brief text-dark-grey" style="display: none;">
                            {!! $activity->brief_html !!}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- Must Know & Facts Slider --}}
@if($destination->items->count() > 0)
<section class="mb-[60px] md:mb-28">
    <div class="container">
        <h2 class="text-black text-center font-bold text-[32px] leading-[1.1em] mb-10">{{ $destination->name }} - Must Know & Facts</h2>
        <div class="relative">
            <div class="swiper must-know-swiper">
                <div class="swiper-wrapper">
                    @foreach($destination->items as $item)
                    <div class="swiper-slide">
                        <img src="{{ $item->getFirstMediaUrl('image') ?: asset('assets/images/destination-03.png') }}"
                             alt="{{ $item->title }}"
                             class="object-cover w-full h-auto"
                             loading="lazy"
                             decoding="async" />
                        <div class="p-4">
                            @if($item->url)
                                <a href="{{ $item->url }}">
                                    <h4 class="mb-2 text-xl font-bold text-black transition duration-200 hover:text-green-zomp">{{ $item->title }}</h4>
                                </a>
                            @else
                                <h4 class="mb-2 text-xl font-bold text-black">{{ $item->title }}</h4>
                            @endif
                            <div class="mb-2 text-dark-grey prose prose-p:text-dark-grey max-w-none">
                                {!! $item->body_html !!}
                            </div>
                            @if($item->url)
                                <a href="{{ $item->url }}" class="text-sm font-semibold text-green-zomp hover:underline">More info</a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="swiper-button-next must-know-next"></div>
            <div class="swiper-button-prev must-know-prev"></div>
            <div class="swiper-pagination must-know-pagination swiper-pagination-custom !-bottom-10"></div>
        </div>
    </div>
</section>
@endif

{{-- Tours & Experiences Section --}}
<section class="mb-[60px] md:mb-24">
    <div class="container">
        <h2 class="text-black font-bold text-[32px] leading-[1.1em] mb-10">Tours & Experiences</h2>

        @if($tours->count() > 0)
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach($tours as $tour)
                    <article class="relative overflow-hidden transition duration-200">
                        <div class="bg-white border rounded-2xl border-light-grey">
                            <div class="relative overflow-hidden rounded-t-2xl">
                                <a href="{{ route('tours.show', $tour->slug) }}">
                                    <img src="{{ $tour->getFirstMediaUrl('gallery', 'card') ?: asset('assets/images/tours/01.png') }}"
                                         alt="{{ $tour->title }}"
                                         class="object-cover w-full h-auto transition duration-300 hover:scale-105"
                                         loading="lazy"
                                         decoding="async">
                                    @if($tour->is_featured)
                                        <span class="absolute top-4 right-4 bg-[#F51D35] rounded py-1 px-2 text-white text-sm font-semibold">Featured</span>
                                    @endif
                                </a>
                            </div>
                            <div class="p-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="iconify" data-icon="ep:location" data-width="14" data-height="14"></span>
                                    <span class="text-sm text-dark-grey">{{ $tour->city?->name ?? $destination->name }}</span>
                                </div>

                                <h4 class="mb-2 text-base font-bold text-black transition duration-200 line-clamp-2 hover:text-green-zomp">
                                    <a href="{{ route('tours.show', $tour->slug) }}">{{ $tour->title }}</a>
                                </h4>

                                @if($tour->avg_rating > 0)
                                <div class="flex items-center mb-2 text-orange-yellow">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($tour->avg_rating))
                                            <span class="iconify" data-icon="mdi:star"></span>
                                        @elseif($i - 0.5 <= $tour->avg_rating)
                                            <span class="iconify" data-icon="mdi:star-half-full"></span>
                                        @else
                                            <span class="iconify" data-icon="mdi:star-outline"></span>
                                        @endif
                                    @endfor
                                    <span class="ml-2 text-dark-grey">({{ $tour->reviews_count ?? 0 }} reviews)</span>
                                </div>
                                @endif

                                @if($tour->categories->count() > 0 || $tour->tags->count() > 0)
                                <div class="flex flex-wrap items-center gap-2">
                                    @foreach($tour->categories->take(2) as $category)
                                        <a href="{{ route('tours.category', $category->slug) }}" class="inline-block px-2 py-1 text-sm font-semibold rounded text-darker-grey bg-white-grey category-tag transition hover:bg-green-zomp hover:text-white">{{ $category->name }}</a>
                                    @endforeach
                                </div>
                                @endif

                                <div class="h-px my-4 border-t border-light-grey"></div>

                                <div class="flex items-center justify-between gap-2">
                                    <span class="flex items-center gap-1">
                                        <span>From</span>
                                        <span class="text-base font-bold text-green-zomp">{{ $tour->currency }} {{ number_format($tour->price_from, 2) }}</span>
                                    </span>
                                    @if($tour->duration_days || $tour->duration_nights)
                                    <span class="flex items-center gap-1">
                                        <span class="iconify text-dark-grey" data-icon="fluent:clock-24-regular" data-width="15" data-height="15"></span>
                                        <div class="text-sm text-dark-grey">{{ $tour->duration_text }}</div>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($tours->hasPages())
            <div class="mt-10">
                {{ $tours->links() }}
            </div>
            @endif
        @else
            <div class="py-12 text-center">
                <p class="text-dark-grey text-lg">No tours available for this destination yet. Check back soon!</p>
            </div>
        @endif
    </div>
</section>

{{-- Top Destinations Carousel --}}
@if($topDestinations->count() > 0)
<section class="mb-[60px] md:mb-24">
    <div class="container">
        <h2 class="text-black font-bold text-[32px] leading-[1.1em] mb-10">Top Destination For Your Next Vacation</h2>
        <div class="relative">
            <div class="swiper destination-tours-swiper">
                <div class="swiper-wrapper">
                    @foreach($topDestinations as $topDestination)
                    <div class="swiper-slide">
                        <div class="relative overflow-hidden rounded-2xl">
                            <img src="{{ $topDestination->getFirstMediaUrl('banner') ?: asset('assets/images/destination-banner.png') }}"
                                 alt="{{ $topDestination->name }}"
                                 class="object-cover w-full h-80"
                                 loading="lazy"
                                 decoding="async" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                                <h3 class="text-2xl font-bold mb-2">{{ $topDestination->name }}</h3>
                                @if($topDestination->excerpt)
                                    <p class="mb-4 text-white/90">{{ Str::limit($topDestination->excerpt, 100) }}</p>
                                @endif
                                <a href="{{ route('destinations.show', $topDestination->slug) }}" class="inline-block text-white text-sm font-semibold py-2.5 px-6 bg-green-zomp rounded-[200px] transition duration-200 hover:bg-green-zomp-hover">
                                    See all tours
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="swiper-button-next destination-tours-next"></div>
            <div class="swiper-button-prev destination-tours-prev"></div>
            <div class="swiper-pagination destination-tours-pagination !-bottom-10"></div>
        </div>
    </div>
</section>
@endif

@endsection

@push('scripts')
{{-- JSON-LD Structured Data --}}
<script type="application/ld+json">
{!! $breadcrumbJson !!}
</script>

<script type="application/ld+json">
{!! $destinationJson !!}
</script>

{{-- Initialize Swiper for Must-Know section --}}
@if($destination->items->count() > 0)
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector('.must-know-swiper')) {
        new Swiper('.must-know-swiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: false,
            navigation: {
                nextEl: '.must-know-next',
                prevEl: '.must-know-prev',
            },
            pagination: {
                el: '.must-know-pagination',
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 24,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 24,
                },
            },
        });
    }
});
</script>
@endif

{{-- Initialize Swiper for Top Destinations --}}
@if($topDestinations->count() > 0)
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector('.destination-tours-swiper')) {
        new Swiper('.destination-tours-swiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            navigation: {
                nextEl: '.destination-tours-next',
                prevEl: '.destination-tours-prev',
            },
            pagination: {
                el: '.destination-tours-pagination',
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 24,
                },
            },
        });
    }
});
</script>
@endif

{{-- Accordion functionality --}}
@if($destination->activities->count() > 0)
<script>
document.addEventListener('DOMContentLoaded', function() {
    const accordionTitles = document.querySelectorAll('.accordion-title');

    accordionTitles.forEach(title => {
        title.addEventListener('click', function() {
            const parent = this.closest('.accordion-items');
            const brief = parent.querySelector('.accordion-brief');
            const isActive = this.classList.contains('active');

            // Close all accordions
            document.querySelectorAll('.accordion-title').forEach(t => {
                t.classList.remove('active');
                t.setAttribute('aria-expanded', 'false');
            });
            document.querySelectorAll('.accordion-brief').forEach(b => {
                b.style.display = 'none';
            });

            // Open clicked accordion if it wasn't active
            if (!isActive) {
                this.classList.add('active');
                this.setAttribute('aria-expanded', 'true');
                brief.style.display = 'block';
            }
        });

        // Make accordion keyboard accessible
        title.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    });
});
</script>
@endif
@endpush
