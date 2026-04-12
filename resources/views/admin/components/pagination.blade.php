@if ($paginator->hasPages())
<nav class="flex items-center justify-between">
    <p class="text-sm text-text-muted">
        Menampilkan {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }} dari {{ $paginator->total() }}
    </p>
    <div class="flex gap-1">
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1.5 text-sm text-text-muted bg-admin-bg rounded-lg opacity-50">←</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1.5 text-sm text-text-secondary bg-admin-bg hover:bg-admin-card-hover rounded-lg transition-colors">←</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-3 py-1.5 text-sm text-text-muted">{{ $element }}</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1.5 text-sm bg-accent-emerald text-admin-bg rounded-lg font-medium">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1.5 text-sm text-text-secondary bg-admin-bg hover:bg-admin-card-hover rounded-lg transition-colors">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1.5 text-sm text-text-secondary bg-admin-bg hover:bg-admin-card-hover rounded-lg transition-colors">→</a>
        @else
            <span class="px-3 py-1.5 text-sm text-text-muted bg-admin-bg rounded-lg opacity-50">→</span>
        @endif
    </div>
</nav>
@endif
