<header class="w-full bg-white">
    <div class="container flex items-center justify-between py-4 mx-auto">
        <div class="menu-toggle cursor-pointer block lg:hidden">
            <span class="iconify" data-icon="fe:bar" data-width="24" data-height="24"></span>
        </div>
        <div class="header-logo flex items-center gap-2">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="w-auto h-10">
            </a>
        </div>
        <nav class="header-menu mx-8 relative">
            <div class="close-menu-toggle lg:hidden absolute top-2.5 right-2.5">
                <span class="iconify" data-icon="ic:sharp-clear" data-width="22" data-height="22"></span>
            </div>
            <ul class="flex justify-center lg:gap-4 xl:gap-10 text-base font-semibold text-black">
                <li class="relative inline-block group w-full nav-father">
                    <div class="flex items-center justify-between lg:justify-normal gap-1 cursor-pointer">
                        <a href="{{ route('home') }}" class="transition-all duration-200 hover:text-green-zomp">Home</a>
                        <span class="iconify text-dark-grey" data-icon="meteor-icons:angle-down" data-width="20" data-height="20"></span>
                    </div>
                    <div class="nav-wrapper lg:absolute lg:p-5 lg:w-60 lg:left-0 lg:top-7.5 bg-white lg:shadow-custom lg:rounded-custom lg:opacity-0 lg:invisible lg:transition-all lg:group-hover:opacity-100 lg:group-hover:visible z-[999]">
                        <ul class="nav-menu">
                            <li class="nav-items mb-2.5 last:mb-0 cursor-pointer hover:text-green-zomp transition-all duration-200">
                                <a href="{{ route('home') }}">Home</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="relative inline-block group w-full nav-father">
                    <div class="flex items-center justify-between lg:justify-normal gap-1 cursor-pointer">
                        <a href="#" class="transition-all duration-200 hover:text-green-zomp">Tours</a>
                        <span class="iconify text-dark-grey" data-icon="meteor-icons:angle-down" data-width="20" data-height="20"></span>
                    </div>
                    <div class="nav-wrapper lg:absolute lg:p-5 lg:w-60 lg:left-0 lg:top-7.5 bg-white lg:shadow-custom lg:rounded-custom lg:opacity-0 lg:invisible lg:transition-all lg:group-hover:opacity-100 lg:group-hover:visible z-[999]">
                        <ul class="nav-menu">
                            <li class="nav-items mb-2.5 last:mb-0 cursor-pointer hover:text-green-zomp transition-all duration-200">
                                <a href="{{ route('tours.index') }}">All Tours</a>
                            </li>
                            <li class="nav-items mb-2.5 last:mb-0 cursor-pointer hover:text-green-zomp transition-all duration-200">
                                <a href="{{ route('tours.search') }}?featured=1">Featured Tours</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="relative inline-block group w-full nav-father">
                    <div class="flex items-center justify-between lg:justify-normal gap-1 cursor-pointer">
                        <a href="#" class="transition-all duration-200 hover:text-green-zomp">Destination</a>
                        <span class="iconify text-dark-grey" data-icon="meteor-icons:angle-down" data-width="20" data-height="20"></span>
                    </div>
                    <div class="nav-wrapper lg:absolute lg:p-5 lg:w-60 lg:left-0 lg:top-7.5 bg-white lg:shadow-custom lg:rounded-custom lg:opacity-0 lg:invisible lg:transition-all lg:group-hover:opacity-100 lg:group-hover:visible z-[999]">
                        <ul class="nav-menu">
                            @foreach(\App\Models\City::take(5)->get() as $city)
                                <li class="nav-items mb-2.5 last:mb-0 cursor-pointer hover:text-green-zomp transition-all duration-200">
                                    <a href="{{ route('tours.index') }}?city={{ $city->slug }}">{{ $city->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="{{ route('tours.index') }}?deals=1" class="transition-all duration-200 hover:text-green-zomp">Deals</a>
                </li>

                <li class="relative inline-block group w-full nav-father">
                    <div class="flex items-center justify-between lg:justify-normal gap-1 cursor-pointer">
                        <a href="#" class="transition-all duration-200 hover:text-green-zomp">Pages</a>
                        <span class="iconify text-dark-grey" data-icon="meteor-icons:angle-down" data-width="20" data-height="20"></span>
                    </div>
                    <div class="nav-wrapper lg:absolute lg:p-5 lg:w-60 lg:left-0 lg:top-7.5 bg-white lg:shadow-custom lg:rounded-custom lg:opacity-0 lg:invisible lg:transition-all lg:group-hover:opacity-100 lg:group-hover:visible z-[999]">
                        <ul class="nav-menu">
                            <li class="nav-items mb-2.5 last:mb-0 cursor-pointer hover:text-green-zomp transition-all duration-200">
                                <a href="{{ route('blog.index') }}">Blog</a>
                            </li>
                            <li class="nav-items mb-2.5 last:mb-0 cursor-pointer hover:text-green-zomp transition-all duration-200">
                                <a href="{{ route('about') }}">About Us</a>
                            </li>
                            <li class="nav-items mb-2.5 last:mb-0 cursor-pointer hover:text-green-zomp transition-all duration-200">
                                <a href="{{ route('contact') }}">Contact Us</a>
                            </li>
                            <li class="nav-items mb-2.5 last:mb-0 cursor-pointer hover:text-green-zomp transition-all duration-200">
                                <a href="#">FAQs</a>
                            </li>
                            <li class="nav-items mb-2.5 last:mb-0 cursor-pointer hover:text-green-zomp transition-all duration-200">
                                <a href="{{ route('gallery') }}">Gallery</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>

        <div class="flex items-center gap-6">
            <div class="hidden sm:flex items-center gap-4">
                <div class="relative inline-block group">
                    <div class="flex items-center gap-2 p-2 text-base font-semibold text-black rounded-lg cursor-pointer group-hover:bg-green-light">
                        <span class="iconify text-green-zomp" data-icon="solar:global-linear" data-width="20" data-height="20"></span>
                        <p>English</p>
                        <span class="iconify text-dark-grey" data-icon="meteor-icons:angle-down" data-width="20" data-height="20"></span>
                    </div>
                    <div class="absolute right-0 z-50 invisible px-4 py-6 mt-3 transition-all duration-200 bg-white rounded-lg opacity-0 shadow-shadow-custom w-72 group-hover:visible group-hover:opacity-100">
                        <h4 class="mb-4 text-base font-semibold text-darker-grey">Select your language</h4>
                        <div class="mb-4 border-b border-light-grey"></div>
                        <ul class="grid grid-cols-2 gap-x-4">
                            <li class="mb-2.5 last:mb-0 cursor-pointer hover:text-green-zomp transition-all duration-200">English</li>
                            <li class="mb-2.5 last:mb-0 cursor-pointer hover:text-green-zomp transition-all duration-200">Français</li>
                            <li class="mb-2.5 last:mb-0 cursor-pointer hover:text-green-zomp transition-all duration-200">Italiano</li>
                            <li class="mb-2.5 last:mb-0 cursor-pointer hover:text-green-zomp transition-all duration-200">Español</li>
                            <li class="mb-2.5 last:mb-0 cursor-pointer hover:text-green-zomp transition-all duration-200">Deutsch</li>
                            <li class="mb-2.5 last:mb-0 cursor-pointer hover:text-green-zomp transition-all duration-200">Tiếng Việt</li>
                        </ul>
                    </div>
                </div>

                <div class="relative flex items-center gap-1">
                    <select class="w-full px-2 pr-5 text-base font-semibold text-black border-none outline-none appearance-none cursor-pointer ring-0 focus:outline-none focus:ring-0 focus:border-transparent">
                        <option class="px-2">USD</option>
                    </select>
                    <span class="absolute right-0 text-gray-500 -translate-y-1/2 pointer-events-none top-1/2">
                        <span class="iconify text-dark-grey" data-icon="meteor-icons:angle-down" data-width="20" data-height="20"></span>
                    </span>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('contact') }}" class="text-white text-base font-semibold py-2.5 px-4 bg-green-zomp rounded-[200px] transition duration-200 hover:bg-green-zomp-hover">Contact Us</a>
            </div>
        </div>
    </div>
</header>
