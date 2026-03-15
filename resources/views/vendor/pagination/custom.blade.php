@if ($paginator->hasPages())
    <div class="pagination">

        {{-- Anterior --}}
        @if ($paginator->onFirstPage())
            <span class="disabled"><span>← Anterior</span></span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}">← Anterior</a>
        @endif

        {{-- Números de página --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="disabled"><span>{{ $element }}</span></span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="active"><span>{{ $page }}</span></span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Siguiente --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}">Siguiente →</a>
        @else
            <span class="disabled"><span>Siguiente →</span></span>
        @endif

    </div>
@endif