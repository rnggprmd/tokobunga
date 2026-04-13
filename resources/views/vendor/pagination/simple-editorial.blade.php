@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center gap-12 select-none">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="text-[10px] font-black uppercase tracking-[0.3em] text-secondary/20 cursor-default">
                PREV —
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="text-[10px] font-black uppercase tracking-[0.3em] text-secondary hover:text-primary transition-colors">
                PREV —
            </a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="text-[10px] font-black uppercase tracking-[0.3em] text-secondary hover:text-primary transition-colors">
                — NEXT
            </a>
        @else
            <span class="text-[10px] font-black uppercase tracking-[0.3em] text-secondary/20 cursor-default">
                — NEXT
            </span>
        @endif
    </nav>
@endif
