@if(!empty($categories))
    @foreach($categories as $k => $category)
        <div class="pp-level-block"
             data-level-block="{{ $category->category_name }}">
            <div class="pp-level-title"
                 aria-expanded="{{ $k === 0 ? 'true' : 'false' }}"
                 data-toggle-body="grid-{{ $category->id }}">
                <span class="lvl-ico">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M12 3l9 5-9 5-9-5z"
                              stroke="currentColor"
                              stroke-width="1.7"
                              stroke-linejoin="round"/>
                        <path d="M6 11v5c0 1.4 2.7 2.5 6 2.5s6-1.1 6-2.5v-5"
                              stroke="currentColor" stroke-width="1.7"/>
                    </svg>
                </span>
                <span class="lvl-txt">
                    {{ $category->category_name }}
                    <small>{{ $category->subcategories->count() }} subjects available</small>
                </span>
                <svg class="lvl-chev" viewBox="0 0 24 24" fill="none">
                    <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="pp-pill-grid" id="grid-{{ $category->id }}"
                 style="display: {{ $k === 0 ? 'flex' : 'none' }}">
                @foreach($category->subcategories as $subcategory)
                    <div class="subject-pill">
                        <div class="pill-header">
                            <span class="icon-toggle">
                                <span class="dot"></span>
                                <span class="back-arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M18 6L6 18"/>
                                        <path d="M6 6l12 12"/>
                                    </svg>
                                </span>
                            </span>
                            <span class="pill-title">{{ $subcategory->subcategory_name }}</span>
                        </div>
                        <div class="pill-content">
                            <p class="description">Select a subtopic to explore:</p>
                            <div class="sub-elements">
                                @foreach($subcategory->resubcategories as $resubcategory)
                                    <a href="{{ route('past.papers.details', [$category->slug, $subcategory->slug, $resubcategory->slug]) }}"
                                        class="chip">{{ $resubcategory->resubcategory_name }} - {{ $resubcategory->unit_code }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
@endif
