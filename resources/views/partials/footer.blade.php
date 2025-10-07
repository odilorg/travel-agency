<footer class="bg-gray-900 text-white py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-2 mb-4">
                    <img src="{{ asset('assets/images/logo-footer.png') }}" alt="Logo" class="w-auto h-10">
                </div>
                <p class="text-gray-300 mb-4">
                    Discover amazing destinations and create unforgettable memories with our carefully curated travel experiences.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition duration-200">
                        <span class="iconify" data-icon="bxl:facebook" data-width="24" data-height="24"></span>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition duration-200">
                        <span class="iconify" data-icon="ri:twitter-x-fill" data-width="24" data-height="24"></span>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition duration-200">
                        <span class="iconify" data-icon="ri:linkedin-fill" data-width="24" data-height="24"></span>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition duration-200">
                        <span class="iconify" data-icon="jam:pinterest" data-width="24" data-height="24"></span>
                    </a>
                </div>
            </div>
            
            <div>
                <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition duration-200">Home</a></li>
                    <li><a href="{{ route('tours.search') }}" class="text-gray-300 hover:text-white transition duration-200">Tours</a></li>
                    <li><a href="{{ route('blog.index') }}" class="text-gray-300 hover:text-white transition duration-200">Blog</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-white transition duration-200">Contact</a></li>
                </ul>
            </div>
            
            <div>
                <h3 class="text-lg font-semibold mb-4">Destinations</h3>
                <ul class="space-y-2">
                    @foreach(\App\Models\City::take(5)->get() as $city)
                        <li>
                            <a href="{{ route('tours.search') }}?city={{ $city->slug }}" class="text-gray-300 hover:text-white transition duration-200">
                                {{ $city->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        
        <div class="border-t border-gray-800 mt-8 pt-8 text-center">
            <p class="text-gray-400">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </p>
        </div>
    </div>
</footer>
