@if ($paginator->hasPages())
    <ul role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="pagination">
        @if ($paginator->onFirstPage())
            <li class="disabled"><a><i class="mdi mdi-chevron-left"></i></a></li>
        @else
            <li><a data-name="page" data-value="{{ ($paginator->currentPage() - 1) }}" href="{{ $paginator->previousPageUrl() }}" class="pagination-link scrollToContent_js"><i class="mdi mdi-chevron-left"></i></a></li>
        @endif

        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))

                <li class="disabled waves-effect"><a href="#!">{{ $element }}</a></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li aria-current="page" class="active"><a>{{ $page }}</a></li>
                    @else
                        <li class="waves-effect"><a data-name="page" data-value="{{ $page }}" class="pagination-link scrollToContent_js" aria-label="{{ __('Go to page :page', ['page' => $page]) }}" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach


        @if ($paginator->hasMorePages())
            <li class="waves-effect"><a class="pagination-link scrollToContent_js" data-name="page" data-value="{{ ($paginator->currentPage() + 1) }}" href="{{ $paginator->nextPageUrl() }}" aria-label="{{ __('pagination.next') }}" rel="next"><i class="mdi mdi-chevron-right"></i></a></li>
        @else
            <li aria-disabled="true"  class="disabled"><a aria-label="{{ __('pagination.next') }}"><i class="mdi mdi-chevron-right"></i></a></li>
        @endif
    </ul>

@endif
