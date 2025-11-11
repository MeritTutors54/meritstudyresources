<!-- Start Right Site -->

@if(!empty($params['category']))
    <div class="resources_page_right_pagination">
        <ul>
            <li><a href="#">{{ $params['category']['category_name'] }}</a></li>
            @if(!empty($params['subcategory']))
                <li><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="#">{{ $params['subcategory']['subcategory_name'] }}</a></li>
            @endif
            @if(!empty($params['resubcategory']))
                <li><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="#">{{ $params['resubcategory']['resubcategory_name'] }}</a></li>
            @endif
        </ul>
    </div>
@endif


@if(!empty($pastPapers))
    <div class="resources_page_right_title">
        <h3 class="{{ !empty($params['category']) ? '' : 'mt-0' }}">Course Details</h3>
        <p>Recognising numerals and important early work to ensure that numbers are written correctly.</p>
    </div>


    <div class="merit-menu-box mt-5" id="past-paper-accordion">
        @php $key=0 @endphp
        @foreach($pastPapers as $title => $papers)
            <div class="merit-menu-item mb-3">
                <h2 class="merit-menu-header">
                    <button
                        class="menu-button" style="font-size: 24px"
                        type="button" data-area-id="merit-menu-id-{{ $key }}">
                        {{ ucfirst($title) }}
                    </button>
                </h2>
                <div id="merit-menu-id-{{ $key }}"
                     class="merit-menu-dropdown-box">
                    <div class="merit-menu-body">
                        @if(count($papers) > 0)
                            <ul class="rplc_dropdown mt-1">
                                <li><h5>Questions</h5></li>
                                @foreach($papers as $paper)
                                    <li>
                                        <div class="paper-zone">
                                            <a href="#">
                                                <i class="feather-file-text" style="font-size: 18px"></i>
                                                &nbsp;
                                                <span style="font-size: 18px"> {{ $paper->title }}</span>
                                            </a>

                                            <a href="#" class="ms-auto">
                                                <span class="">Mark Scheme</span>
                                            </a>
                                            <a href="#">
                                                <span class="">Solutions</span>
                                            </a>
                                        </div>
                                        {{--                                        <strong>{{ ucfirst($paper->title) }}</strong>--}}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
            @php $key++ @endphp
        @endforeach
    </div>
@else
    <div class="resources_page_right_title">
        <h3 class="{{ !empty($params['category']) ? '' : 'mt-0' }}">No Paper Found!</h3>
        <p>Please select or search your paper correctly</p>
    </div>
@endif
