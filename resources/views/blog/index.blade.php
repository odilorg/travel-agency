@extends('layouts.app')

@section('content')
<section class="pt-10 lg:pt-12 pb-2 border border-b-0 border-l-0 border-r-0 border-t-light-grey">
    <div class="container">
        <nav class="font-medium text-grey" aria-label="Breadcrumb">
            <ul class="flex flex-wrap items-center gap-1 mb-2">
                <li><a href="{{ route('home') }}" class="transition duration-200 hover:text-green-zomp">Home</a></li>
                <span class="mx-1">/</span>
                <li><span class="text-dark-grey">Blog</span></li>
            </ul>
        </nav>
        <h1 class="text-black text-[40px] font-bold leading-[1.1em] mb-2">Blog</h1>
        <p class="text-dark-grey">News, tips and travel stories</p>
    </div>
</section>

<section class="mb-[60px] md:mb-24">
    <div class="container">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <form method="GET" class="flex items-center gap-2 w-full md:w-auto">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search posts" class="w-full md:w-80 border border-light-grey rounded-lg py-2.5 px-4 outline-none">
                <button class="bg-green-zomp text-white font-semibold py-2 px-4 rounded-[200px]" type="submit">Search</button>
            </form>
            <form method="GET" class="ml-auto">
                <input type="hidden" name="q" value="{{ request('q') }}">
                <select name="sort" class="px-3 py-2 border border-light-grey rounded-lg" onchange="this.form.submit()">
                    <option value="new" @selected(request('sort','new')==='new')>Newest</option>
                    <option value="popular" @selected(request('sort')==='popular')>Popular</option>
                </select>
            </form>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
            @forelse($posts as $post)
            <article class="bg-white border rounded-2xl border-light-grey overflow-hidden">
                <a href="{{ route('blog.show', $post->slug) }}" class="block relative">
                    <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="object-cover w-full h-52">
                </a>
                <div class="p-4">
                    <div class="flex items-center gap-2 mb-2 text-sm text-dark-grey">
                        @if($post->published_at)
                            <span>{{ $post->published_at->format('M d, Y') }}</span>
                        @endif
                        @if($post->read_time)
                            <span>• {{ $post->read_time }} min read</span>
                        @endif
                    </div>
                    <h3 class="mb-2 text-base font-bold text-black line-clamp-2">
                        <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-green-zomp">{{ $post->title }}</a>
                    </h3>
                    @if($post->excerpt)
                        <p class="text-dark-grey line-clamp-3">{{ $post->excerpt }}</p>
                    @endif
                </div>
            </article>
            @empty
                <p class="col-span-3 text-dark-grey">No posts found.</p>
            @endforelse
        </div>

        <div class="mt-10 sm:mt-16">
            {{ $posts->onEachSide(1)->links('components.pagination') }}
        </div>
    </div>
</section>
@endsection


