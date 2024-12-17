@if ($paginator->hasPages())
<div class="col-lg-12">
    <div class="pagination">
        <ul>
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
            <li><span>Prev</span></li>
            @else
            <li><a href="{{ $paginator->previousPageUrl() }}">Prev</a></li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
            @if (is_array($element))
            @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
            <li class="active"><a href="#">{{ $page }}</a></li>
            @else
            <li><a href="{{ $url }}">{{ $page }}</a></li>
            @endif
            @endforeach
            @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}">Next</a></li>
            @else
            <li><span>Next</span></li>
            @endif
        </ul>
    </div>
</div>
@endif