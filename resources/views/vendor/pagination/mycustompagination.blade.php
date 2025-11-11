@if ($paginator->hasPages())
    <div class="row">
        <div class="col-lg-12 mt--60">
            <nav>
                <ul class="rbt-pagination">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="disabled"><span><i class="feather-chevron-left"></i></span></li>
                    @else
                        <li><a href="{{ $paginator->previousPageUrl() }}" aria-label="Previous"><i class="feather-chevron-left"></i></a></li>
                    @endif

                    {{-- Pagination Links --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <li class="disabled"><span>{{ $element }}</span></li>
                        @elseif (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="active"><a href="#" class="active">{{ $page }}</a></li>
                                @else
                                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li><a href="{{ $paginator->nextPageUrl() }}" aria-label="Next"><i class="feather-chevron-right"></i></a></li>
                    @else
                        <li class="disabled"><span><i class="feather-chevron-right"></i></span></li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
@endif
