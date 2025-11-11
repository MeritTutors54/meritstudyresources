<!-- Start Right Site -->

@if(!empty($params['category']))
    <div class="resources_page_right_pagination">
        <ul>
            <li>
                <a href="{{ route('past.papers', [$params['category']['slug']]) }}">{{ $params['category']['category_name'] }}</a>
            </li>
            @if(!empty($params['subcategory']))
                <li><i class="fa-solid fa-angle-right"></i></li>
                <li>
                    <a href="{{ route('past.papers', [$params['category']['slug'], $params['subcategory']['slug']]) }}">
                        {{ $params['subcategory']['subcategory_name'] }}
                        @if(!empty($params['resubcategory']))
                            ({{ $params['resubcategory']['unit_code'] }})
                        @endif
                    </a>
                </li>
            @endif
            @if(!empty($params['resubcategory']))
                <li><i class="fa-solid fa-angle-right"></i></li>
                <li>
                    <a href="{{ route('past.papers', [$params['category']['slug'], $params['subcategory']['slug'], $params['resubcategory']['slug']]) }}">{{ $params['resubcategory']['resubcategory_name'] }}</a>
                </li>
            @endif
        </ul>
    </div>
@endif

@if(!empty($pastPapers))
    <div class="resources_page_right_title">
        <h3 class="{{ !empty($params['category']) ? '' : 'mt-0' }}">Past Paper Details</h3>
        <p>Recognising numerals and important early work to ensure that numbers are written correctly.</p>
    </div>

    <div class="d-flex justify-content-end">
        <button class="btn btn-secondary-outline btn-expend">
            Expend All
        </button>
    </div>

    <div class="merit-menu-box mt-5" id="past-paper-accordion">
        @php $key=0; $pipe = 0; @endphp
        @foreach($pastPapers as $title => $papers)
            <div class="merit-menu-item mb-3">
                <h2 class="merit-menu-header">
                    <button
                        class="menu-button {{ $pipe == 0 ? 'active' : '' }}" style="font-size: 24px"
                        type="button" data-area-id="merit-menu-id-{{ $key }}">
                        {{ ucfirst($title) }}
                    </button>
                </h2>
                <div id="merit-menu-id-{{ $key }}"
                     class="merit-menu-dropdown-box {{ $pipe == 0 ? 'show' : '' }}">
                    <div class="merit-menu-body">
                        @if(count($papers) > 0)
                            <ul class="rplc_dropdown mt-1">
                                <li><h5>Questions</h5></li>
                                @foreach($papers as $paper)
                                    <li>
                                        <div class="paper-zone">
                                            @if(!empty($paper->ques_paper))
                                                {{--                                                <button class="past-paper-button"--}}
                                                {{--                                                        data-type="ques_paper"--}}
                                                {{--                                                        data-paper-id="{{ $paper->id }}">--}}
                                                {{--                                                    <i class="feather-file-text" style="font-size: 18px"></i>--}}
                                                {{--                                                    {{ $paper->title }}--}}
                                                {{--                                                </button>--}}
{{--                                                <a href="{{ route('pdf.secret.view', [\App\Services\PDFService::makeSecret($paper->id, 'ques_paper')]) }}"--}}
{{--                                                   target="_blank"--}}
{{--                                                   class="pdf-anchor">--}}
{{--                                                    <i class="feather-file-text"--}}
{{--                                                       style="font-size: 18px; margin-right: 3px"></i>--}}
{{--                                                    {{ $paper->title }}--}}
{{--                                                </a>--}}

                                                <a href="{{ asset('uploads/pastpaper/' . $paper->ques_paper) }}"
                                                   target="_blank"
                                                   class="pdf-anchor">
                                                    <i class="feather-file-text"
                                                       style="font-size: 18px; margin-right: 3px"></i>
                                                    {{ $paper->title }}
                                                </a>
                                            @endif

                                            @if(!empty($paper->ans_paper))
                                                {{--                                                <button class="ms-auto past-paper-button"--}}
                                                {{--                                                        data-type="ans_paper"--}}
                                                {{--                                                        data-paper-id="{{ $paper->id }}">--}}
                                                {{--                                                    <i class="feather-file-text" style="font-size: 18px"></i>--}}
                                                {{--                                                    Mark Scheme--}}
                                                {{--                                                </button>--}}
                                                {{--                                                <a href="{{ route('pdf.secret.view', [\App\Services\PDFService::makeSecret($paper->id, 'ans_paper')]) }}"--}}
                                                {{--                                                   target="_blank"--}}
                                                {{--                                                   class="ms-auto pdf-anchor">--}}
                                                {{--                                                    <i class="feather-file-text"--}}
                                                {{--                                                       style="font-size: 18px; margin-right: 3px"></i>--}}
                                                {{--                                                    Mark Scheme--}}
                                                {{--                                                </a>--}}
                                                <a href="{{ asset('uploads/pastpaper/' . $paper->ans_paper) }}"
                                                   target="_blank"
                                                   class="ms-auto pdf-anchor">
                                                    <i class="feather-file-text"
                                                       style="font-size: 18px; margin-right: 3px"></i>
                                                    Mark Scheme
                                                </a>

                                            @endif

                                            @if($paper->have_solution == 1)
                                                <a href="#">
                                                    <span class="">Solutions</span>
                                                </a>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
            @php $key++; $pipe++; @endphp
        @endforeach
    </div>
@else
    @if(!empty($q))
        <h4 class="{{ !empty($params['category']) ? '' : 'mt-0' }}">Search Query For '{{ $q }}'</h4>
        @if(!empty($categories))
            @foreach($categories as $category)
                <div class="mt-3">
                    <div class="mt-3">
                        <h5>{{ $category['category_name'] }}</h5>
                        @if(!empty($category['subcategories']))
                            <div class="mt-5 mb-5">
                                @foreach($category['subcategories'] as $subCategory)
                                    <a href="{{ route('past.papers', [$category['slug'], $subCategory['slug']]) }}"
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
    @else
        @if(!empty($params['category']) && !empty($params['subcategory']))
            @if(!empty($resubcategories))
                <h4 class="mt-3">{{ $params['subcategory']['subcategory_name'] }}</h4>
                <div class="mt-4">
                    @foreach($resubcategories as $resub)
                        <a href="{{ route('past.papers', [$params['category']['slug'], $params['subcategory']['slug'], $resub->slug]) }}"
                           class="anchor-item me-4 py-2 px-4">
                            <strong>{{ $resub->resubcategory_name }} ({{ $resub->unit_code }})</strong>
                        </a>
                    @endforeach
                </div>
            @endif
        @else

            <div class="merit-menu-box" id="past-paper-accordion">
                <div class="resources_page_right_title">
                    <h3 class="{{ !empty($params['category']) ? '' : 'mt-0' }} mb-4">All Past Paper</h3>

                    @if(!empty($categories))
                        @php $countKey = 0; $lead= 0; @endphp
                        @foreach($categories as $category)
                            <div class="merit-menu-item mb-3">
                                <h2 class="merit-menu-header">
                                    <button
                                        class="menu-button {{ $lead == 0 ? 'active' : '' }}" style="font-size: 24px"
                                        type="button" data-area-id="merit-menu-id-{{ $countKey }}">
                                        {{ strtoupper($category['category_name']) }}
                                    </button>
                                </h2>
                                <div id="merit-menu-id-{{ $countKey }}"
                                     class="merit-menu-dropdown-box {{ $lead == 0 ? 'show' : '' }}">
                                    <div class="merit-menu-body">
                                        @if(!empty($category['subcategories']))
                                            <div class="mt-4 d-flex flex-wrap">
                                                @foreach($category['subcategories'] as $subCategory)
                                                    <div class="anchor-item me-4 mb-4 py-2 px-4">
                                                        <a href="{{ route('past.papers', [$category['slug'], $subCategory['slug']]) }}">
                                                            <strong>{{ $subCategory['subcategory_name'] }}</strong>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @php $countKey++; $lead= 1; @endphp
                        @endforeach
                    @endif
                </div>
            </div>
        @endif
    @endif
@endif
