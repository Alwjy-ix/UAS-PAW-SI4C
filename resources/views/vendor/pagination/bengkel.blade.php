@if ($paginator->hasPages())
<nav class="bengkel-pagination" role="navigation" aria-label="Pagination">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <span class="page-btn page-btn--disabled"><i class="bi bi-chevron-left"></i></span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="page-btn" rel="prev" aria-label="Previous">
            <i class="bi bi-chevron-left"></i>
        </a>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="page-btn page-btn--dots">{{ $element }}</span>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="page-btn page-btn--active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="page-btn" rel="next" aria-label="Next">
            <i class="bi bi-chevron-right"></i>
        </a>
    @else
        <span class="page-btn page-btn--disabled"><i class="bi bi-chevron-right"></i></span>
    @endif
</nav>
@endif
