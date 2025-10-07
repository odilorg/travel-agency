<footer class="bg-darker-grey text-white">
    <div class="container">
        <div class="flex flex-wrap md:flex-nowrap justify-between gap-5 md:gap-6 py-6 md:py-12">
            <div class="w-full md:w-[35%] mb-10 md:mb-0">
                <img src="{{ asset('assets/images/logo-footer.png') }}" alt="Logo" class="h-[50px] w-auto mb-7" />
                <p class="text-white-grey font-medium mb-10">Don't just get there, get there in style.</p>
                <ul class="space-y-2 text-grey">
                    <li class="flex items-start gap-2">
                        <span class="iconify" data-icon="ep:location" data-width="20" data-height="20"></span>
                        <p>1901 Thornridge Cir. Shiloh, Hawaii 81063</p>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="iconify" data-icon="ph:phone-call" data-width="20" data-height="20"></span>
                        <p>(308) 555-0121</p>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="iconify" data-icon="carbon:email" data-width="20" data-height="20"></span>
                        <p><a href="mailto:contact@travelsite.com" class="hover:text-green-zomp transition duration-200">contact@travelsite.com</a></p>
                    </li>
                </ul>
            </div>

            <div class="w-1/2 md:w-1/5 min-w-[150px] mb-10 md:mb-0">
                <h6 class="text-white font-bold mb-6">Top Destination</h6>
                <ul class="space-y-4 text-grey">
                    @if(isset($navFeaturedDestinations) && $navFeaturedDestinations->count() > 0)
                        @foreach($navFeaturedDestinations->take(7) as $destination)
                            <li><a href="{{ route('destinations.show', $destination->slug) }}" class="hover:text-green-zomp transition duration-200">{{ $destination->name }}</a></li>
                        @endforeach
                    @else
                        <li><a href="{{ route('destinations.index') }}" class="hover:text-green-zomp transition duration-200">Tokyo</a></li>
                        <li><a href="{{ route('destinations.index') }}" class="hover:text-green-zomp transition duration-200">Los Angeles</a></li>
                        <li><a href="{{ route('destinations.index') }}" class="hover:text-green-zomp transition duration-200">Rome</a></li>
                        <li><a href="{{ route('destinations.index') }}" class="hover:text-green-zomp transition duration-200">Amsterdam</a></li>
                        <li><a href="{{ route('destinations.index') }}" class="hover:text-green-zomp transition duration-200">San Francisco</a></li>
                        <li><a href="{{ route('destinations.index') }}" class="hover:text-green-zomp transition duration-200">London</a></li>
                    @endif
                    <li><a href="{{ route('destinations.index') }}" class="hover:text-green-zomp transition duration-200">More Destinations</a></li>
                </ul>
            </div>

            <div class="w-1/2 md:w-1/5 min-w-[150px] mb-10 md:mb-0">
                <h6 class="text-white font-bold mb-6">Information</h6>
                <ul class="space-y-4 text-grey">
                    <li><a href="{{ route('contact') }}" class="hover:text-green-zomp transition duration-200">Help & FAQs</a></li>
                    <li><a href="{{ route('blog.index') }}" class="hover:text-green-zomp transition duration-200">Press centre</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-green-zomp transition duration-200">About us</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-green-zomp transition duration-200">Contact us</a></li>
                    <li><a href="#" class="hover:text-green-zomp transition duration-200">Privacy policy</a></li>
                    <li><a href="#" class="hover:text-green-zomp transition duration-200">Site map</a></li>
                </ul>
            </div>

            <div class="w-full md:w-fit md:ml-auto">
                <h6 class="text-white font-bold mb-6">Follow Us</h6>
                <ul class="space-x-4 sm:space-x-2 lg:space-x-4 flex items-center mb-8">
                    <li class="w-10 h-10 rounded-full flex items-center justify-center p-2.5 bg-[#1877F2]">
                        <a href="#" aria-label="Facebook">
                            <span class="iconify text-white" data-icon="bxl:facebook" data-width="22" data-height="22"></span>
                        </a>
                    </li>
                    <li class="w-10 h-10 rounded-full flex items-center justify-center p-2.5 bg-[#CF3881]">
                        <a href="#" aria-label="Instagram">
                            <span class="iconify text-white" data-icon="mdi:instagram" data-width="22" data-height="22"></span>
                        </a>
                    </li>
                    <li class="w-10 h-10 rounded-full flex items-center justify-center p-2.5 bg-[#FF0000]">
                        <a href="#" aria-label="YouTube">
                            <span class="iconify text-white" data-icon="ri:youtube-line" data-width="22" data-height="22"></span>
                        </a>
                    </li>
                    <li class="w-10 h-10 rounded-full flex items-center justify-center p-2.5 bg-[#1DA1F2]">
                        <a href="#" aria-label="Twitter">
                            <span class="iconify text-white" data-icon="basil:twitter-solid" data-width="22" data-height="22"></span>
                        </a>
                    </li>
                </ul>

                <h6 class="text-white font-bold mb-6">Payment Methods</h6>
                <img src="{{ asset('assets/images/visa.png') }}" alt="Payment Methods" class="h-[65px] w-auto mb-8" />

                <div class="w-fit border border-dark-grey p-4 rounded-lg flex items-center gap-x-4 gap-y-2">
                    <div class="relative inline-block group">
                        <div class="cursor-pointer text-base text-white font-semibold flex items-center gap-2">
                            <span class="iconify text-green-zomp" data-icon="solar:global-linear" data-width="18" data-height="18"></span>
                            <p>English</p>
                        </div>
                        <div class="absolute shadow-shadow-custom right-0 left-0 md:left-auto bottom-11 py-6 px-4 w-72 bg-white rounded-lg invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-200 z-50">
                            <h4 class="text-darker-grey text-base font-semibold mb-4">Select your language</h4>
                            <div class="border-b border-light-grey mb-4"></div>
                            <div class="grid grid-cols-2 gap-x-4">
                                <ul>
                                    <li class="mb-2.5 last:mb-0 cursor-pointer text-dark-grey hover:text-green-zomp">English</li>
                                    <li class="mb-2.5 last:mb-0 cursor-pointer text-dark-grey hover:text-green-zomp">Français</li>
                                    <li class="mb-2.5 last:mb-0 cursor-pointer text-dark-grey hover:text-green-zomp">Italiano</li>
                                </ul>
                                <ul>
                                    <li class="mb-2.5 last:mb-0 cursor-pointer text-dark-grey hover:text-green-zomp">Español</li>
                                    <li class="mb-2.5 last:mb-0 cursor-pointer text-dark-grey hover:text-green-zomp">Deutsch</li>
                                    <li class="mb-2.5 last:mb-0 cursor-pointer text-dark-grey hover:text-green-zomp">Tiếng Việt</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="h-6 w-px bg-light-grey"></div>
                    <div class="relative flex items-center gap-1">
                        <select class="bg-transparent px-2 appearance-none text-base font-semibold border-none outline-none ring-0 focus:outline-none focus:ring-0 focus:border-transparent cursor-pointer">
                            <option class="px-2 text-black">USD</option>
                            <option class="px-2 text-black">VND</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="h-px w-full bg-stroke"></div>
        <div class="py-[22px] text-center text-grey">
            <p>Copyright © {{ date('Y') }} {{ config('app.name') }}. All Rights Reserved.</p>
        </div>
    </div>
</footer>
