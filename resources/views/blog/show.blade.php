@extends('layouts.app')

@section('content')
{{-- Breadcrumb --}}
<section class="pt-10 lg:pt-12 pb-2 border border-b-0 border-l-0 border-r-0 border-t-light-grey">
    <div class="container">
        <nav class="font-medium text-grey" aria-label="Breadcrumb">
            <ul class="flex flex-wrap items-center gap-1 mb-2">
                <li><a href="{{ route('home') }}" class="transition duration-200 hover:text-green-zomp">Home</a></li>
                <span class="mx-1">/</span>
                <li><a href="{{ route('blog.index') }}" class="transition duration-200 hover:text-green-zomp">Blog</a></li>
                <span class="mx-1">/</span>
                <li><span class="text-dark-grey">{{ $post->title }}</span></li>
            </ul>
        </nav>
    </div>
</section>

{{-- Blog Post Content --}}
<section class="mb-[60px] md:mb-24">
    <div class="container">
        <div class="max-w-[840px] mx-auto">
            {{-- Post Title --}}
            <h1 class="text-black text-3xl md:text-[56px] font-bold leading-[1.1em] mb-4">{{ $post->title }}</h1>
            
            {{-- Post Meta & Share --}}
            <div class="flex flex-wrap items-center gap-4 justify-between mb-10">
                <div class="flex flex-wrap items-center gap-4 sm:gap-2">
                    @if($post->author)
                        <span class="text-sm text-dark-grey font-medium">By {{ $post->author->name }}</span>
                    @endif
                    <ul class="list-disc pl-5 flex items-center gap-7">
                        @if($post->published_at)
                            <li>{{ $post->published_at->format('F d, Y') }}</li>
                        @endif
                        @if($post->read_time)
                            <li>{{ $post->read_time }} minutes read</li>
                        @endif
                    </ul>
                </div>
                
                {{-- Share Button --}}
                <div class="relative inline-block group">
                    <div class="cursor-pointer flex items-center gap-2 text-black font-semibold py-3 px-4 border border-[#C0C5C9] rounded-[200px] bg-white transition duration-200 hover:bg-green-zomp hover:border-green-zomp hover:text-white">
                        <span class="iconify" data-icon="solar:share-outline" data-width="24" data-height="24"></span>
                        Share
                    </div>
                    <div class="absolute shadow-shadow-custom left-0 sm:left-auto right-0 py-6 px-4 mt-3 w-[350px] bg-white rounded-lg invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-200 z-50">
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
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank" class="bg-white w-9 h-9 rounded-full flex items-center justify-center">
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
                                <a href="https://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&description={{ urlencode($post->title) }}" target="_blank" class="bg-[#F54848] w-9 h-9 rounded-full flex items-center justify-center">
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
        
        {{-- Featured Image --}}
        @php
            $featured = method_exists($post, 'getFirstMedia') ? $post->getFirstMedia('featured') : null;
            $alt = $post->featured_alt ?: $post->title;
            $caption = $post->featured_caption;
            $credit = $post->featured_credit;
        @endphp
        @if($post->featured_image)
        <figure class="mb-3">
            <img src="{{ $post->featured_image }}" alt="{{ $alt }}" class="w-full h-full object-cover rounded-2xl" />
            @php
                $captionText = '';
                if (!empty($caption)) {
                    $captionText .= $caption;
                }
                if (!empty($caption) && !empty($credit)) {
                    $captionText .= ' — ';
                }
                if (!empty($credit)) {
                    $captionText .= 'Image: ' . $credit;
                }
            @endphp
            @if(!empty($captionText))
                <figcaption class="text-sm text-dark-grey mt-2">{{ $captionText }}</figcaption>
            @endif
        </figure>
        @endif
        
        {{-- Post Content --}}
        <div class="max-w-[840px] mx-auto">
            @if($post->excerpt)
                <p class="mb-10 text-lg font-medium">{{ $post->excerpt }}</p>
            @endif
            
            @if($post->body_html)
                <div class="prose max-w-none mb-10">
                    {!! $post->body_html !!}
                </div>
            @endif
            
            {{-- Tags --}}
            @if($post->tags->isNotEmpty())
            <div class="flex flex-wrap items-center gap-4 mb-10">
                <span class="iconify text-green-zomp" data-icon="lucide:tag" data-width="24" data-height="24"></span>
                <ul class="flex flex-wrap items-center gap-3">
                    @foreach($post->tags as $tag)
                    <li>
                        <a href="{{ route('blog.index') }}?tag={{ $tag->slug }}" class="block text-dark-grey font-semibold py-1 px-4 border border-light-grey rounded-[4px] bg-white transition duration-200 hover:bg-green-zomp hover:border-green-zomp hover:text-white">
                            {{ $tag->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
        
        <div class="h-px w-full bg-[#E0E0E0] my-10"></div>
        
        {{-- Comments Section --}}
        <div class="max-w-[840px] mx-auto">
            <p class="text-black text-2xl font-semibold mb-8">
                {{ $post->comments->where('approved', true)->count() }} 
                {{ Str::plural('comment', $post->comments->where('approved', true)->count()) }}
            </p>
            
            {{-- Display Comments --}}
            @if($post->comments->where('approved', true)->isNotEmpty())
            <div class="mb-8">
                @foreach($post->comments->where('approved', true)->whereNull('parent_id') as $comment)
                <div class="flex gap-4 border-b border-[#E0E0E0] pb-6 mb-6 last:pb-0 last:mb-0 last:border-0">
                    <div class="w-[60px] h-[60px] bg-grey rounded-full flex items-center justify-center text-white font-bold text-xl">
                        {{ strtoupper(substr($comment->author_name, 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <p class="text-black font-bold mb-2">{{ $comment->author_name }}</p>
                        <p class="text-dark-grey">{{ $comment->body }}</p>
                        @if($comment->created_at)
                            <p class="text-sm text-grey mt-2">{{ $comment->created_at->diffForHumans() }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif
            
            {{-- Comment Form --}}
            <p class="text-black text-2xl font-semibold mb-8">Leave a comment</p>
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif
            
            <form action="{{ route('comments.store', $post) }}" method="POST" class="w-full">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <input type="text" name="author_name" placeholder="Your Name" required class="w-full border border-light-grey rounded-lg py-3 px-4 outline-none @error('author_name') border-red-500 @enderror" value="{{ old('author_name') }}">
                        @error('author_name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <input type="email" name="author_email" placeholder="Your Email" required class="w-full border border-light-grey rounded-lg py-3 px-4 outline-none @error('author_email') border-red-500 @enderror" value="{{ old('author_email') }}">
                        @error('author_email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <textarea name="body" rows="6" placeholder="Your comment" required class="w-full border border-light-grey rounded-lg py-3 px-4 mb-4 outline-none @error('body') border-red-500 @enderror">{{ old('body') }}</textarea>
                @error('body')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
                
                {{-- Honeypot --}}
                <input type="text" name="honeypot" value="" style="display:none;">
                
                <div class="flex justify-end">
                    <button type="submit" class="font-semibold text-white py-4 px-14 bg-green-zomp rounded-[200px] transition duration-200 hover:bg-green-zomp-hover">
                        Submit Comment
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

{{-- Related Posts --}}
@if($relatedPosts->isNotEmpty())
<section class="mb-[60px] md:mb-24">
    <div class="container">
        <div class="flex items-center justify-between mb-10">
            <h2 class="text-black font-bold text-[32px] leading-[1.1em] capitalize">Related stories</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($relatedPosts as $relatedPost)
            <article class="bg-white overflow-hidden rounded-2xl shadow-sm">
                <div class="overflow-hidden rounded-t-2xl">
                    @if($relatedPost->featured_image)
                        <a href="{{ route('blog.show', $relatedPost->slug) }}">
                            <img src="{{ $relatedPost->featured_image }}" alt="{{ $relatedPost->title }}" class="w-full h-auto rounded-t-2xl object-cover hover:scale-105 transition duration-200">
                        </a>
                    @endif
                </div>
                <div class="p-6">
                    @if($relatedPost->categories->isNotEmpty())
                    <div class="flex flex-wrap items-center gap-2 mb-3">
                        @foreach($relatedPost->categories->take(2) as $category)
                        <a href="{{ route('blog.index') }}?category={{ $category->slug }}" class="text-sm text-green-zomp font-semibold">
                            {{ $category->name }}
                        </a>
                        @endforeach
                    </div>
                    @endif
                    
                    <h4 class="text-black font-bold text-xl mb-3 line-clamp-2">
                        <a href="{{ route('blog.show', $relatedPost->slug) }}" class="transition duration-200 hover:text-green-zomp">
                            {{ $relatedPost->title }}
                        </a>
                    </h4>
                    
                    @if($relatedPost->excerpt)
                        <p class="text-dark-grey mb-4 line-clamp-3">{{ $relatedPost->excerpt }}</p>
                    @endif
                    
                    <div class="flex items-center gap-2 text-sm text-grey">
                        @if($relatedPost->published_at)
                            <span>{{ $relatedPost->published_at->format('M d, Y') }}</span>
                        @endif
                        @if($relatedPost->read_time)
                            <span>•</span>
                            <span>{{ $relatedPost->read_time }} min read</span>
                        @endif
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
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
});
</script>
@endpush

