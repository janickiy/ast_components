@if ($paginator->hasPages())

    <ul class="news__pagination pagination temp-class">

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())

        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="pagination__arrow-btn btn btn--secondary btn--icon">
                    <span class="sr-only">Предыдущая страница</span>
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#chevron-left') }}"></use>
                    </svg>
                </a>
            </li>
        @endif

        @if($paginator->currentPage() > 4)
            <li>
                <a class="pagination__btn btn btn--secondary" href="{{ $paginator->url(1) }}">...</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach(range(1, $paginator->lastPage()) as $i)
            @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                @if ($i == $paginator->currentPage())
                    <li>
                        <a class="pagination__btn active btn btn--secondary"
                           href="{{ $paginator->url($i) }}"><span>{{ $i }}</span></a>
                    </li>
                @else
                    <li>
                        <a class="pagination__btn btn btn--secondary"
                           href="{{ $paginator->url($i) }}"><span>{{ $i }}</span></a>
                    </li>
                @endif
            @endif
        @endforeach

        @if($paginator->currentPage() < $paginator->lastPage() - 3)
            <li>
                <a class="pagination__btn btn btn--secondary"
                   href="{{ $paginator->url($paginator->lastPage()) }}">...</a>
            </li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}" class="pagination__arrow-btn btn btn--secondary btn--icon">
                    <span class="sr-only">Следующая страница</span>
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#chevron-right') }}"></use>
                    </svg>
                </a>
            </li>
        @endif

    </ul>

@endif
