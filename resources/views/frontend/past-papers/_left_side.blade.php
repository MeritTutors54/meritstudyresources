<div class="merit-menu-box mt-3">
    @php $key = 0; @endphp

    @if(!empty($categories))
        @foreach($categories as $item)
            @php
                $isFirst = $loop->first;
                $isMatch = isset($params['category']) && $params['category']['id'] == $item['id'];
                $shouldBeActive = $isMatch || (!isset($params['category']) && $isFirst);
            @endphp

            <div class="merit-menu-item mb-3" data-search="merit-search-id-{{ $key }}">
                <h2 class="merit-menu-header">
                    <button
                        class="menu-button {{ $shouldBeActive ? 'active' : '' }}"
                        type="button" data-area-id="merit-menu-id-{{ $key }}">
                        {{ ucfirst($item['category_name']) }}
                    </button>
                </h2>
                <div id="merit-menu-id-{{ $key }}"
                     class="merit-menu-dropdown-box {{ $shouldBeActive ? 'show' : '' }}">
                    <div class="merit-menu-body">
                        @if(!empty($item['subcategories']))
                            <div class="rplc_dropdown_main fixed-scrolling mt-1">
                                <ul class="rplc_dropdown mt-1 first-ul">
                                    <li style="color: #394381"><strong>Most Popular</strong></li>
                                    @foreach($item['subcategories'] as $subject)
                                        @if($subject['most_popular'] == \App\Enums\MostPopular::YES->value)
                                            <li class="child">
                                                <a class="{{ isset($params['subcategory']) && $params['subcategory']['id'] == $subject['id'] ? 'active' : '' }}"
                                                   href="#">
                                                <span
                                                    class="child-name">{{ ucfirst($subject['subcategory_name']) }}</span>
                                                    <i class="fa-solid fa-angle-down"></i>
                                                </a>
                                                <ul class="rplc_dropdown_items second-ul {{ isset($params['subcategory']) && $params['subcategory']['id'] == $subject['id'] ? 'show' : '' }}">
                                                    @if(!empty($subject['resubcategories']))
                                                        @foreach($subject['resubcategories'] as $resubcategory)
                                                            @if($resubcategory['is_active'] == 1)
                                                                <li>
                                                                    <a href="{{ route('past.papers', [$item['slug'], $subject['slug'], $resubcategory['slug']]) }}"
                                                                       class="child-name {{ isset($params['resubcategory']) && $params['resubcategory']['id'] == $resubcategory['id'] ? 'active' : '' }}">
                                                                        {{ ucfirst($resubcategory['resubcategory_name']) }}
                                                                        ({{ $resubcategory['unit_code'] }})
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </li>
                                        @endif
                                    @endforeach
                                    <li style="color: #394381"><strong>All Subject</strong></li>
                                    @foreach($item['subcategories'] as $subject)
                                        <li class="child">
                                            <a class="{{ isset($params['subcategory']) && $params['subcategory']['id'] == $subject['id'] ? 'active' : '' }}"
                                               href="#">
                                                <span
                                                    class="child-name">{{ ucfirst($subject['subcategory_name']) }}</span>
                                                <i class="fa-solid fa-angle-down"></i>
                                            </a>
                                            <ul class="rplc_dropdown_items second-ul {{ isset($params['subcategory']) && $params['subcategory']['id'] == $subject['id'] ? 'show' : '' }}">
                                                @if(!empty($subject['resubcategories']))
                                                    @foreach($subject['resubcategories'] as $resubcategory)
                                                        @if($resubcategory['is_active'] == 1)
                                                            <li>
                                                                <a href="{{ route('past.papers', [$item['slug'], $subject['slug'], $resubcategory['slug']]) }}"
                                                                   class="child-name {{ isset($params['resubcategory']) && $params['resubcategory']['id'] == $resubcategory['id'] ? 'active' : '' }}">
                                                                    {{ ucfirst($resubcategory['resubcategory_name']) }}
                                                                    ({{ $resubcategory['unit_code'] }})
                                                                </a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @php $key++ @endphp
        @endforeach
    @else
        <div class="resources_page_right_title">
            <h3 class="{{ !empty($params['category']) ? '' : 'mt-0' }}">No Paper Found!</h3>
            <p>Please select or search your paper correctly</p>
        </div>
    @endif
</div>




