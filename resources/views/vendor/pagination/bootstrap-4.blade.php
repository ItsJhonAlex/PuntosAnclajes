@if ($paginator->hasPages())
    <nav>
        <ul class="pagination justify-content-center">
            {{-- Primer página --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">«</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url(1) }}" aria-label="@lang('pagination.first')">
                        «
                    </a>
                </li>
            @endif

            {{-- Páginas anteriores --}}
            @foreach ($elements[0] as $page => $url)
                <li class="page-item{{ $page == $paginator->currentPage() ? ' active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach

            {{-- Páginas siguientes --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                        »
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">»</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
