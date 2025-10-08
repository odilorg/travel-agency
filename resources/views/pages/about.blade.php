@extends('layouts.app')

@push('head')
    {{-- JSON-LD BreadcrumbList Schema --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            {
                "@type": "ListItem",
                "position": 1,
                "name": "{{ __('Home') }}",
                "item": "{{ url('/') }}"
            },
            {
                "@type": "ListItem",
                "position": 2,
                "name": "{{ __('About Us') }}",
                "item": "{{ route('about') }}"
            }
        ]
    }
    </script>
@endpush

@section('content')
{{-- Breadcrumb --}}
<section class="py-10 lg:py-12 border border-t-light-grey border-r-0 border-b-0 border-l-0">
    <div class="container">
        <nav class="font-medium text-grey" aria-label="Breadcrumb">
            <ul class="flex flex-wrap items-center gap-1 mb-2">
                <li><a href="{{ route('home') }}" class="transition duration-200 hover:text-green-zomp">{{ __('Home') }}</a></li>
                <span class="mx-1">/</span>
                <li><span class="text-dark-grey">{{ __('About us') }}</span></li>
            </ul>
        </nav>
        <h1 class="text-black text-[40px] font-bold leading-[1.1em] mb-2">{{ $settings->about_hero_title ?? __('About us') }}</h1>
        <p class="text-dark-grey">{{ $settings->about_hero_subtitle ?? __('Let\'s explore what we do!') }}</p>
    </div>
</section>

{{-- Hero Image with Video Button --}}
@if($settings->about_hero_bg_image)
<section class="mb-[60px] md:mb-24">
    <div class="container">
        <div class="relative rounded-2xl overflow-hidden">
            <img 
                src="{{ Storage::disk('public')->url($settings->about_hero_bg_image) }}" 
                alt="{{ $settings->about_hero_title ?? __('About Us') }}"
                class="w-full h-[400px] md:h-[500px] object-cover"
            >
            @if($settings->about_hero_video_url)
            <div class="absolute inset-0 flex items-center justify-center">
                <a 
                    href="{{ $settings->about_hero_video_url }}" 
                    target="_blank"
                    rel="noopener"
                    class="w-20 h-20 bg-white rounded-full flex items-center justify-center hover:scale-110 transition-transform duration-200 shadow-xl"
                    aria-label="{{ __('Play Video') }}"
                >
                    <span class="iconify text-green-zomp" data-icon="solar:play-bold" data-width="32" data-height="32"></span>
                </a>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- Provide Best Travel Experience + Vision/Mission --}}
<section class="mb-[60px] md:mb-24">
    <div class="container">
        @if($settings->about_provide_title || $settings->about_provide_text)
        <div class="text-center max-w-3xl mx-auto mb-12">
            @if($settings->about_provide_title)
            <h2 class="text-black text-3xl md:text-[40px] font-bold leading-[1.1em] mb-5">
                {{ $settings->about_provide_title }}
            </h2>
            @endif
            @if($settings->about_provide_text)
            <p class="text-dark-grey">{{ $settings->about_provide_text }}</p>
            @endif
        </div>
        @endif

        {{-- Vision & Mission Cards --}}
        <div class="grid md:grid-cols-2 gap-8">
            {{-- Vision Card --}}
            @if($settings->about_vision_title || $settings->about_vision_text)
            <div class="bg-white p-8 rounded-2xl border border-light-grey hover:shadow-lg transition-shadow duration-200">
                @if($settings->about_vision_icon)
                <div class="mb-6">
                    <img src="{{ Storage::disk('public')->url($settings->about_vision_icon) }}" alt="{{ $settings->about_vision_title }}" class="w-16 h-16">
                </div>
                @endif
                <h3 class="text-black text-2xl font-bold mb-4">{{ $settings->about_vision_title ?? __('Our Vision') }}</h3>
                @if($settings->about_vision_text)
                <p class="text-dark-grey">{{ $settings->about_vision_text }}</p>
                @endif
            </div>
            @endif

            {{-- Mission Card --}}
            @if($settings->about_mission_title || $settings->about_mission_text)
            <div class="bg-white p-8 rounded-2xl border border-light-grey hover:shadow-lg transition-shadow duration-200">
                @if($settings->about_mission_icon)
                <div class="mb-6">
                    <img src="{{ Storage::disk('public')->url($settings->about_mission_icon) }}" alt="{{ $settings->about_mission_title }}" class="w-16 h-16">
                </div>
                @endif
                <h3 class="text-black text-2xl font-bold mb-4">{{ $settings->about_mission_title ?? __('Our Mission') }}</h3>
                @if($settings->about_mission_text)
                <p class="text-dark-grey">{{ $settings->about_mission_text }}</p>
                @endif
            </div>
            @endif
        </div>
    </div>
</section>

{{-- Dream Destination (Dark Section) --}}
@if($settings->about_dream_title || $settings->about_dream_features)
<section class="mb-[60px] xl:mb-24 bg-green-dark py-[60px] xl:py-[100px]">
    <div class="container">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                @if($settings->about_dream_title)
                <h2 class="text-white text-3xl md:text-[40px] font-bold leading-[1.1em] mb-5">
                    {{ $settings->about_dream_title }}
                </h2>
                @endif
                @if($settings->about_dream_text)
                <p class="text-white-grey">{{ $settings->about_dream_text }}</p>
                @endif
            </div>

            @if($settings->about_dream_features && count($settings->about_dream_features) > 0)
            <div class="grid sm:grid-cols-2 gap-6">
                @foreach($settings->about_dream_features as $feature)
                <div class="bg-white/10 p-6 rounded-xl backdrop-blur-sm">
                    @if(!empty($feature['icon']))
                    <div class="mb-4">
                        <span class="iconify text-green-zomp" data-icon="{{ $feature['icon'] }}" data-width="32" data-height="32"></span>
                    </div>
                    @endif
                    @if(!empty($feature['title']))
                    <h4 class="text-white text-lg font-bold mb-2">{{ $feature['title'] }}</h4>
                    @endif
                    @if(!empty($feature['text']))
                    <p class="text-white-grey text-sm">{{ $feature['text'] }}</p>
                    @endif
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- Enjoy Exclusive Service (Two Column) --}}
@if($settings->about_enjoy_title || $settings->about_enjoy_image)
<section class="mb-[60px] md:mb-24">
    <div class="container">
        <div class="grid md:grid-cols-2 gap-10 md:gap-[60px] items-center">
            <div class="order-2 md:order-1">
                @if($settings->about_enjoy_title)
                <h2 class="text-black text-3xl md:text-[40px] font-bold leading-[1.1em] mb-5">
                    {{ $settings->about_enjoy_title }}
                </h2>
                @endif
                @if($settings->about_enjoy_text)
                <p class="text-dark-grey whitespace-pre-line">{{ $settings->about_enjoy_text }}</p>
                @endif
            </div>

            @if($settings->about_enjoy_image)
            <div class="order-1 md:order-2">
                <img 
                    src="{{ Storage::disk('public')->url($settings->about_enjoy_image) }}" 
                    alt="{{ $settings->about_enjoy_title }}"
                    class="w-full h-auto rounded-2xl"
                >
            </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- Team Gallery --}}
@if($settings->about_team_members && count($settings->about_team_members) > 0)
<section class="py-[60px] xl:py-[120px] bg-green-light">
    <div class="container">
        <h2 class="text-black text-3xl md:text-[40px] font-bold leading-[1.1em] mb-12 text-center">
            {{ __('Meet Our Team') }}
        </h2>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($settings->about_team_members as $member)
            <div class="bg-white rounded-2xl overflow-hidden hover:shadow-xl transition-shadow duration-200">
                @if(!empty($member['photo']))
                <div class="aspect-square overflow-hidden">
                    <img 
                        src="{{ Storage::disk('public')->url($member['photo']) }}" 
                        alt="{{ $member['name'] ?? '' }}"
                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                    >
                </div>
                @endif
                <div class="p-6 text-center">
                    @if(!empty($member['name']))
                    <h3 class="text-black text-xl font-bold mb-2">{{ $member['name'] }}</h3>
                    @endif
                    @if(!empty($member['role']))
                    <p class="text-dark-grey">{{ $member['role'] }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Contact Tiles --}}
@if($settings->about_contact_email || $settings->about_contact_phone || $settings->about_contact_location)
<section class="py-[60px] xl:py-[120px] bg-white">
    <div class="container">
        <div class="grid md:grid-cols-3 gap-8">
            {{-- Email Tile --}}
            @if($settings->about_contact_email)
            <div class="text-center p-8 bg-green-light rounded-2xl">
                <div class="w-16 h-16 bg-green-zomp rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="iconify text-white" data-icon="carbon:email" data-width="28" data-height="28"></span>
                </div>
                <h3 class="text-black text-xl font-bold mb-3">{{ $settings->about_contact_email_label ?? __('Email') }}</h3>
                <a href="mailto:{{ $settings->about_contact_email }}" class="text-dark-grey hover:text-green-zomp transition-colors">
                    {{ $settings->about_contact_email }}
                </a>
            </div>
            @endif

            {{-- Phone Tile --}}
            @if($settings->about_contact_phone)
            <div class="text-center p-8 bg-green-light rounded-2xl">
                <div class="w-16 h-16 bg-green-zomp rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="iconify text-white" data-icon="ph:phone-call" data-width="28" data-height="28"></span>
                </div>
                <h3 class="text-black text-xl font-bold mb-3">{{ $settings->about_contact_phone_label ?? __('Phone') }}</h3>
                <a href="tel:{{ $settings->about_contact_phone }}" class="text-dark-grey hover:text-green-zomp transition-colors">
                    {{ $settings->about_contact_phone }}
                </a>
            </div>
            @endif

            {{-- Location Tile --}}
            @if($settings->about_contact_location)
            <div class="text-center p-8 bg-green-light rounded-2xl">
                <div class="w-16 h-16 bg-green-zomp rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="iconify text-white" data-icon="ep:location" data-width="28" data-height="28"></span>
                </div>
                <h3 class="text-black text-xl font-bold mb-3">{{ $settings->about_contact_location_label ?? __('Location') }}</h3>
                <p class="text-dark-grey mb-3">{{ $settings->about_contact_location }}</p>
                @if($settings->about_contact_location_map_url)
                <a href="{{ $settings->about_contact_location_map_url }}" target="_blank" rel="noopener" class="text-green-zomp hover:underline">
                    {{ __('View on Google Map') }}
                </a>
                @endif
            </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- CTA Form Section --}}
@if($settings->about_cta_enabled)
<section class="relative py-[60px] xl:py-[120px] bg-[#f2f4f4] overflow-hidden">
    <div class="absolute inset-0 z-0" style="background-image: url('{{ asset('assets/images/about-us-bg-form.png') }}'); background-position: center center; background-repeat: repeat; opacity: 0.79;"></div>
    
    <div class="container relative z-10">
        <div class="max-w-3xl mx-auto">
            @if($settings->about_cta_title)
            <h2 class="text-black text-3xl md:text-[40px] font-bold capitalize leading-[1.1em] mb-7 text-center">
                {{ $settings->about_cta_title }}
            </h2>
            @endif
            @if($settings->about_cta_text)
            <p class="text-dark-grey text-center mb-10">{{ $settings->about_cta_text }}</p>
            @endif

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mb-6 px-4 py-3 rounded bg-green-100 text-green-800 border border-green-300">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-6 px-4 py-3 rounded bg-red-100 text-red-800 border border-red-300">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Contact Form (Reuse) --}}
            <form method="POST" action="{{ route('contact.send') }}" class="bg-white p-8 rounded-2xl shadow-lg">
                @csrf
                <input type="hidden" name="source" value="about">
                <input type="text" name="_hp" value="" style="display:none !important" tabindex="-1" autocomplete="off">

                <div class="mb-6">
                    <label for="name" class="block mb-2 text-dark-grey text-sm">{{ __('Name') }}</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}"
                        placeholder="{{ __('Your name') }}" 
                        required 
                        class="w-full border border-light-grey rounded-lg py-2.5 px-4 outline-none focus:border-green-zomp transition-colors @error('name') border-red-500 @enderror"
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="email" class="block mb-2 text-dark-grey text-sm">{{ __('Email') }}</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        placeholder="{{ __('hello@email.com') }}" 
                        required 
                        class="w-full border border-light-grey rounded-lg py-2.5 px-4 outline-none focus:border-green-zomp transition-colors @error('email') border-red-500 @enderror"
                    >
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="message" class="block mb-2 text-dark-grey text-sm">{{ __('How can we help?') }}</label>
                    <textarea
                        id="message"
                        name="message"
                        placeholder="{{ __('Tell us a little bit about your destination dream') }}"
                        required
                        rows="6"
                        class="w-full border border-light-grey rounded-lg py-2.5 px-4 outline-none focus:border-green-zomp transition-colors @error('message') border-red-500 @enderror"
                    >{{ old('message') }}</textarea>
                    @error('message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-green-zomp text-white text-center font-semibold py-4 px-10 rounded-[200px] hover:bg-opacity-90 transition-all duration-200">
                    {{ __('Send') }}
                </button>
            </form>
        </div>
    </div>
</section>
@endif
@endsection
