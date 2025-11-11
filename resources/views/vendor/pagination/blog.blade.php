@if ($paginator->hasPages())
    <ul>
        @if ($paginator->onFirstPage())
            <li>
                <a  class="blogs_page_count_prev">
                    <span><i class="fas fa-arrow-left text-white"></i></span>
                </a>
            </li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}" class="blogs_page_count_prev active">
                    <span><i class="fas fa-arrow-left"></i></span>
                </a>
            </li>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <li><a class="active">{{ $element }}</a></li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li><a class="active">{{ $page }}</a></li>
                    @else
                        <li><a href="{{ $url }}" class="">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach


        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}">
                    <span><i class="fas fa-arrow-right"></i></span>
                </a>
            </li>
        @else
            <li><a style="background: #CACACA!important;"><span><i class="fas fa-arrow-right text-white"></i></span></a></li>
        @endif
    </ul>
@endif
