<div class="pp-sidebar">
    <p class="pp-sidebar-title">Filter by level</p>
    @if(!empty($categories))
        @foreach($categories as $k => $category)
            <div class="pp-level-group">
                <button class="pp-level-toggle" aria-expanded="{{ $k === 0 ? 'true' : 'false' }}"
                        data-target="lvl-{{ $category->id }}">
                    <span class="ltl">
                        <span class="lt-ico">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M12 3l9 5-9 5-9-5z"
                                      stroke="currentColor" stroke-width="1.7"
                                      stroke-linejoin="round"/>
                                <path d="M6 11v5c0 1.4 2.7 2.5 6 2.5s6-1.1 6-2.5v-5"
                                      stroke="currentColor" stroke-width="1.7"/>
                            </svg>
                        </span>
                        {{ $category->category_name }}
                    </span>
                    <svg class="lt-chev" viewBox="0 0 24 24" fill="none">
                        <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2"
                              stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </button>
                <div class="pp-level-body-cs" id="lvl-{{ $category->id }}"
                     style="display: {{ $k === 0 ? 'block' : 'none' }};">
                    @php
                        $popularSubcategories = $category->subcategories->where('most_popular', 1);
                    @endphp
                    @if($popularSubcategories->isNotEmpty())
                        <p class="pp-most-popular">Most Popular</p>
                        @foreach($popularSubcategories as $subcategory)
                            <button class="pp-subject-row" data-target="subBio-mp-{{$subcategory->id}}">
                                <span class="pp-subject-name"
                                      title="{{ $subcategory->subcategory_name }}">
                                    {{ $subcategory->subcategory_name }}
                                </span>
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2"
                                          stroke-linecap="round"
                                          stroke-linejoin="round"/>
                                </svg>
                            </button>
                            @if($subcategory->resubcategories->isNotEmpty())
                                <ul class="pp-board-list" id="subBio-mp-{{$subcategory->id}}" style="display: none;">
                                    @foreach($subcategory->resubcategories as $resubcategory)
                                        <li>
                                            <a href="{{ route('past.papers.details', [$category->slug, $subcategory->slug, $resubcategory->slug]) }}">
                                                {{ $resubcategory->resubcategory_name }}
                                                ({{ $resubcategory->unit_code }})
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        @endforeach
                    @endif

                    @if($category->subcategories->isNotEmpty())
                        <p class="pp-most-popular mt-3">All Subject</p>
                        @foreach($category->subcategories as $subcategory)
                            <button class="pp-subject-row" data-target="subBio-{{$subcategory->id}}">
                                <span class="pp-subject-name" title="{{ $subcategory->subcategory_name }}">
                                    {{ $subcategory->subcategory_name }}
                                </span>
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2"
                                          stroke-linecap="round"
                                          stroke-linejoin="round"/>
                                </svg>
                            </button>
                            @if(count($subcategory->resubcategories) > 0)
                                <ul class="pp-board-list" id="subBio-{{$subcategory->id}}" style="display: none;">
                                    @foreach($subcategory->resubcategories as $resubcategory)
                                        <li>
                                            <a href="{{ route('past.papers.details', [$category->slug, $subcategory->slug, $resubcategory->slug]) }}">
                                                {{ $resubcategory->resubcategory_name }}
                                                ({{ $resubcategory->unit_code }})
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        @endforeach
    @endif
</div>
