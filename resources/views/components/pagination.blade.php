@if ($paginator->hasPages())
    <nav class="flex items-center justify-center gap-2" role="navigation" aria-label="Pagination Navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="w-10 h-10 rounded-full border border-grey text-grey flex items-center justify-center opacity-40" aria-hidden="true">
                <span class="iconify" data-icon="proicons:chevron-left" data-width="20" data-height="20"></span>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="group w-10 h-10 rounded-full border border-grey text-grey flex items-center justify-center transition hover:!border-green-zomp hover:!bg-green-zomp hover:!text-white" aria-label="Previous">
                <span class="iconify group-hover:!text-white" data-icon="proicons:chevron-left" data-width="20" data-height="20"></span>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="text-dark-grey font-bold text-base py-2 w-10 h-10 rounded-full flex items-center justify-center">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="font-bold text-base bg-green-zomp text-white w-10 h-10 rounded-full flex items-center justify-center">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="border border-transparent text-dark-grey font-bold text-base w-10 h-10 rounded-full flex items-center justify-center transition hover:!border-green-zomp hover:!bg-green-zomp hover:!text-white" aria-label="Go to page {{ $page }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="group w-10 h-10 rounded-full border border-grey text-grey flex items-center justify-center transition hover:!border-green-zomp hover:!bg-green-zomp hover:!text-white" aria-label="Next">
                <span class="iconify group-hover:!text-white" data-icon="proicons:chevron-right" data-width="20" data-height="20"></span>
            </a>
        @else
            <span class="w-10 h-10 rounded-full border border-grey text-grey flex items-center justify-center opacity-40" aria-hidden="true">
                <span class="iconify" data-icon="proicons:chevron-right" data-width="20" data-height="20"></span>
            </span>
        @endif
    </nav>
@endif


