@if ($paginator->hasPages())
  <nav class="compact-pagination">
    {{-- Previous --}}
    @if ($paginator->onFirstPage())
      <span class="compact-pagination-btn disabled">{{ __('pagination.previous') }}</span>
    @else
      <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="compact-pagination-btn">{{ __('pagination.previous') }}</a>
    @endif

    {{-- Page numbers --}}
    @foreach ($elements as $element)
      @if (is_string($element))
        <span class="compact-pagination-dots">{{ $element }}</span>
      @endif
      @if (is_array($element))
        @foreach ($element as $page => $url)
          @if ($page == $paginator->currentPage())
            <span class="compact-pagination-btn active">{{ $page }}</span>
          @else
            <a href="{{ $url }}" class="compact-pagination-btn">{{ $page }}</a>
          @endif
        @endforeach
      @endif
    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
      <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="compact-pagination-btn">{{ __('pagination.next') }}</a>
    @else
      <span class="compact-pagination-btn disabled">{{ __('pagination.next') }}</span>
    @endif
  </nav>
@endif
