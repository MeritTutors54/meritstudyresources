<!-- Start Right Site -->
@if (!empty($params['category']))
    <div class="resources_page_right_pagination">
        <ul>
            <li>
                <a
                    href="{{ route('past.papers', [$params['category']['slug']]) }}">{{ $params['category']['category_name'] }}</a>
            </li>
            @if (!empty($params['subcategory']))
                <li><i class="fa-solid fa-angle-right"></i></li>
                <li>
                    <a href="{{ route('past.papers', [$params['category']['slug'], $params['subcategory']['slug']]) }}">
                        {{ $params['subcategory']['subcategory_name'] }}
                        @if (!empty($params['resubcategory']))
                            ({{ $params['resubcategory']['unit_code'] }})
                        @endif
                    </a>
                </li>
            @endif
            @if (!empty($params['resubcategory']))
                <li><i class="fa-solid fa-angle-right"></i></li>
                <li>
                    <a
                        href="{{ route('past.papers', [$params['category']['slug'], $params['subcategory']['slug'], $params['resubcategory']['slug']]) }}">{{ $params['resubcategory']['resubcategory_name'] }}</a>
                </li>
            @endif
        </ul>
    </div>
@endif

@if (!empty($pastPapers))
    {{-- this section is responsible for showing title value --}}
    <div class="resources_page_right_title">
        <h3 class="">{{ $params['resubcategory']['resubcategory_name'] }}</h3>
        <p>Recognising numerals and important early work to ensure that numbers are written correctly.</p>
    </div>


    <div class="mt-5" id="paper-box">
        @foreach ($pastPapers as $paper)
            {{--            <a href="{{ route('past.papers', [$params['category']['slug'], $params['subcategory']['slug'], $params['resubcategory']['slug'], $paper]) }}" --}}
            {{--               class=" mt-3 anchor-item me-3"> --}}
            {{--                <strong>{{ $paper }}</strong> --}}
            {{--            </a> --}}
            {{-- @dd($params) --}}
            <button class="anchor-item me-3 clickForPastPaper" data-title="{{ $paper }}"
                data-category="{{ $params['category']['id'] }}" data-subcategory="{{ $params['subcategory']['id'] }}"
                data-resubcategory="{{ $params['resubcategory']['id'] }}">
                <strong>{{ $paper }}</strong>
            </button>
        @endforeach
    </div>

    <div id="waiting-logo" class="d-none d-flex flex-column justify-content-center align-items-center"
        style="height: 20vh;">
        <div class="spinner-border text-primary" style="width: 45px;height: 45px;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <span class="mt-3"><strong>Loading...</strong></span>
    </div>

    <div class="merit-menu-box mt-2" id="past-paper-accordion"></div>
@else
    {{-- this section is responsible for showing search value --}}
    @if (!empty($q))
        <h4 class="mt-3 mb-3">Search Query For '{{ $q }}'</h4>
        @if (!empty($params['category']) && !empty($params['subcategory']))
            @foreach ($resubcategories as $category)
                <div class="mb-5">
                    <h5>{{ $category['category_name'] }}</h5>
                    <div class="">
                        @foreach ($category['subcategories'] as $subCategory)
                            <div class="semi-box">
                                <p>{{ $subCategory['subcategory_name'] }}</p>
                                @if (!empty($subCategory['resubcategories']))
                                    <div class="d-flex flex-wrap">
                                        @foreach ($subCategory['resubcategories'] as $resub)
                                            <a href="{{ route('past.papers', [$category['slug'], $subCategory['slug'], $resub['slug']]) }}{{ !empty($q) ? '&q=' . $q : '' }}"
                                                class="anchor-item me-3 py-2 px-4">
                                                <strong>{{ $resub['resubcategory_name'] }}
                                                    ({{ $resub['unit_code'] }})
                                                </strong>
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            @if (!empty($categories))
                @foreach ($categories as $category)
                    <div class="mt-3">
                        <div class="mt-3">
                            <h5>{{ $category['category_name'] }}</h5>
                            @if (!empty($category['subcategories']))
                                <div class="mt-5 mb-5">
                                    @foreach ($category['subcategories'] as $subCategory)
                                        <a href="{{ route('past.papers', [$category['slug'], $subCategory['slug']]) . '?q=' . $q }}"
                                            class="anchor-item me-3">
                                            <strong>{{ $subCategory['subcategory_name'] }}</strong>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        @endif
    @else
        {{-- this section is responsible for showing all subcategory value --}}
        @if (!empty($params['category']) && !empty($params['subcategory']))
            @if (!empty($resubcategories))
                <h4 class="mt-3">{{ $params['subcategory']['subcategory_name'] }}</h4>
                <div class="mt-4">
                    @foreach ($resubcategories as $resub)
                        <a href="{{ route('past.papers', [$params['category']['slug'], $params['subcategory']['slug'], $resub->slug]) }}"
                            class="anchor-item me-4 py-2 px-4">
                            <strong>{{ $resub->resubcategory_name }} ({{ $resub->unit_code }})</strong>
                        </a>
                    @endforeach
                </div>
            @endif
        @else
            {{-- this section is responsible for showing All Category in a acordion view --}}
            <div class="merit-menu-box" id="past-paper-accordion">
                <div class="resources_page_right_title">
                    <h3 class="{{ !empty($params['category']) ? '' : 'mt-0' }} mb-4">All Past Paper</h3>

                    @if (!empty($categories))
                        @php
                            $countKey = 0;
                            $lead = 0;
                        @endphp
                        @foreach ($categories as $category)
                            <div class="merit-menu-item mb-3">
                                <h2 class="merit-menu-header">
                                    <button class="menu-button {{ $lead == 0 ? 'active' : '' }}"
                                        style="font-size: 24px" type="button"
                                        data-area-id="merit-menu-id-{{ $countKey }}">
                                        {{ strtoupper($category['category_name']) }}
                                    </button>
                                </h2>
                                <div id="merit-menu-id-{{ $countKey }}"
                                    class="merit-menu-dropdown-box {{ $lead == 0 ? 'show' : '' }}">
                                    <div class="merit-menu-body">
                                        @if (!empty($category['subcategories']))
                                            <div class="mt-4 d-flex flex-wrap">
                                                @foreach ($category['subcategories'] as $subCategory)
                                                    <div class="anchor-item me-4 mb-4 py-2 px-4">
                                                        <a
                                                            href="{{ route('past.papers', [$category['slug'], $subCategory['slug']]) }}">
                                                            <strong>{{ $subCategory['subcategory_name'] }}</strong>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @php
                                $countKey++;
                                $lead = 1;
                            @endphp
                        @endforeach
                    @endif
                </div>
            </div>
        @endif
    @endif
@endif
