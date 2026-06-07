@if ($paginator->hasPages())
    {{-- Previous --}}
    @if ($paginator->onFirstPage())
        <span class="page-link" style="opacity:.4;cursor:not-allowed;">←</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="page-link">←</a>
    @endif

    {{-- Pages --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="page-link" style="opacity:.4;">{{ $element }}</span>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="page-link active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="page-link">→</a>
    @else
        <span class="page-link" style="opacity:.4;cursor:not-allowed;">→</span>
    @endif
@endif