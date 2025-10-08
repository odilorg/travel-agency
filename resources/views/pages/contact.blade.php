@extends('layouts.app')

@php
    $metaData = [
        'title' => __('Contact Us') . ' - ' . ($siteSettings->site_name ?? config('app.name')),
        'description' => __('Get in touch with us. We\'re here to help with any questions or inquiries you may have.'),
        'canonical' => route('contact'),
    ];
@endphp

@push('head')
    {{-- JSON-LD Organization Schema --}}
    @php
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $siteSettings->company_name ?? $siteSettings->site_name ?? config('app.name'),
            'url' => url('/'),
        ];
        
        if ($siteSettings->contact_email) {
            $schema['email'] = $siteSettings->contact_email;
        }
        
        if ($siteSettings->contact_phone) {
            $schema['telephone'] = $siteSettings->contact_phone;
        }
        
        if ($siteSettings->contact_address_line || $siteSettings->contact_address_city || $siteSettings->contact_address_country) {
            $address = ['@type' => 'PostalAddress'];
            if ($siteSettings->contact_address_line) {
                $address['streetAddress'] = $siteSettings->contact_address_line;
            }
            if ($siteSettings->contact_address_city) {
                $address['addressLocality'] = $siteSettings->contact_address_city;
            }
            if ($siteSettings->contact_address_country) {
                $address['addressCountry'] = $siteSettings->contact_address_country;
            }
            $schema['address'] = $address;
        }
        
        $contactPoint = [
            '@type' => 'ContactPoint',
            'contactType' => 'Customer Service',
        ];
        if ($siteSettings->contact_email) {
            $contactPoint['email'] = $siteSettings->contact_email;
        }
        $schema['contactPoint'] = $contactPoint;
    @endphp
    
    <script type="application/ld+json">
        {!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
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
                <li><span class="text-dark-grey">{{ __('Contact us') }}</span></li>
            </ul>
        </nav>
        <h1 class="text-black text-[40px] font-bold leading-[1.1em] mb-2">{{ __('Contact Us') }}</h1>
        <p class="text-dark-grey">{{ __('Reach out to us for any inquiries or support—we\'re here to help!') }}</p>
    </div>
</section>

{{-- Contact Form Section --}}
<section class="mb-[60px]">
    <div class="container p-6 md:p-[60px] xl:p-[120px] relative overflow-hidden bg-[#f2f4f4] rounded-2xl">
        <div class="absolute inset-0 z-0"
            style="background-image: url('{{ asset('assets/images/about-us-bg-form.png') }}');
            background-position: center center;
            background-repeat: repeat;
            opacity: 0.79;">
        </div>
        <div class="grid md:grid-cols-2 gap-10 md:gap-[60px] items-center justify-between relative z-10">
            <div class="wrapper">
                <h2 class="text-black text-3xl md:text-[40px] font-bold capitalize leading-[1.1em] mb-7">
                    {{ __('Let\'s connect and talk about your travel dreams') }}
                </h2>
                <p class="text-dark-grey">
                    {{ __('Talk about and plan what your travel dreams are this year, and we will help you to make your dreams come true') }}
                </p>
            </div>
            
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="md:col-span-2 px-4 py-3 rounded bg-green-100 text-green-800 border border-green-300">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="md:col-span-2 px-4 py-3 rounded bg-red-100 text-red-800 border border-red-300">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Contact Form --}}
            <form method="POST" action="{{ route('contact.send') }}">
                @csrf
                
                {{-- Honeypot Field (hidden spam protection) --}}
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

{{-- Map and Company Info Section --}}
<section class="mb-[60px] md:mb-24">
    <div class="container">
        <div class="grid md:grid-cols-2 gap-10 md:gap-[60px] items-center justify-between">
            
            {{-- Map --}}
            @if($siteSettings->map_iframe_src)
                <iframe 
                    loading="lazy" 
                    src="{{ $siteSettings->map_iframe_src }}" 
                    title="{{ $siteSettings->company_name ?? $siteSettings->site_name ?? __('Our Location') }}" 
                    aria-label="{{ $siteSettings->company_name ?? $siteSettings->site_name ?? __('Our Location') }}" 
                    class="w-full h-[400px] rounded-2xl"
                ></iframe>
            @else
                <div class="w-full h-[400px] rounded-2xl bg-gray-200 flex items-center justify-center">
                    <p class="text-gray-500">{{ __('Map not configured') }}</p>
                </div>
            @endif

            {{-- Company Info --}}
            <div>
                <h2 class="text-black font-bold text-2xl leading-[1.1em] mb-5">
                    {{ $siteSettings->company_name ?? $siteSettings->site_name ?? config('app.name') }}
                </h2>
                
                @if($siteSettings->contact_phone)
                    <p class="text-dark-grey mb-2">
                        {{ __('Phone:') }} {{ $siteSettings->contact_phone }}
                    </p>
                @endif
                
                @if($siteSettings->contact_email)
                    <p class="text-dark-grey mb-4">
                        {{ __('Email:') }} <a href="mailto:{{ $siteSettings->contact_email }}" class="hover:text-green-zomp transition-colors">{{ $siteSettings->contact_email }}</a>
                    </p>
                @endif

                {{-- Social Media Links --}}
                @if($siteSettings->social_facebook_url || $siteSettings->social_instagram_url || $siteSettings->social_x_url || $siteSettings->social_youtube_url)
                    <ul class="space-x-4 flex items-center mb-4">
                        @if($siteSettings->social_facebook_url)
                            <li class="group cursor-pointer w-[50px] h-[50px] rounded-md flex items-center justify-center p-2 bg-[#EBFEF5] transition duration-200 hover:bg-green-zomp">
                                <a href="{{ $siteSettings->social_facebook_url }}" target="_blank" rel="noopener" aria-label="Facebook">
                                    <span class="iconify text-green-zomp group-hover:text-white" data-icon="mdi:facebook" data-width="26" data-height="26"></span>
                                </a>
                            </li>
                        @endif
                        
                        @if($siteSettings->social_instagram_url)
                            <li class="group cursor-pointer w-[50px] h-[50px] rounded-md flex items-center justify-center p-2 bg-[#EBFEF5] transition duration-200 hover:bg-green-zomp">
                                <a href="{{ $siteSettings->social_instagram_url }}" target="_blank" rel="noopener" aria-label="Instagram">
                                    <span class="iconify text-green-zomp group-hover:text-white" data-icon="mdi:instagram" data-width="26" data-height="26"></span>
                                </a>
                            </li>
                        @endif
                        
                        @if($siteSettings->social_x_url)
                            <li class="group cursor-pointer w-[50px] h-[50px] rounded-md flex items-center justify-center p-2 bg-[#EBFEF5] transition duration-200 hover:bg-green-zomp">
                                <a href="{{ $siteSettings->social_x_url }}" target="_blank" rel="noopener" aria-label="X (Twitter)">
                                    <span class="iconify text-green-zomp group-hover:text-white" data-icon="ri:twitter-x-fill" data-width="26" data-height="26"></span>
                                </a>
                            </li>
                        @endif
                        
                        @if($siteSettings->social_youtube_url)
                            <li class="group cursor-pointer w-[50px] h-[50px] rounded-md flex items-center justify-center p-2 bg-[#EBFEF5] transition duration-200 hover:bg-green-zomp">
                                <a href="{{ $siteSettings->social_youtube_url }}" target="_blank" rel="noopener" aria-label="YouTube">
                                    <span class="iconify text-green-zomp group-hover:text-white" data-icon="mdi:youtube" data-width="26" data-height="26"></span>
                                </a>
                            </li>
                        @endif
                    </ul>
                @endif

                {{-- Contact Blurb --}}
                @if($siteSettings->contact_blurb)
                    <p class="text-dark-grey">{{ $siteSettings->contact_blurb }}</p>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection


