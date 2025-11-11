<div class="merit-menu-box mt-3">
        <div class="merit-menu-item mb-3">
            <h2 class="merit-menu-header">
                <button
                    class="menu-button active"
                    type="button" data-area-id="merit-menu-id-{{ $filteredCategory->id }}">
                    {{ ucfirst($filteredCategory->category_name) }}
                </button>
            </h2>
            <div id="merit-menu-id-{{ $filteredCategory->id }}"
                 class="merit-menu-dropdown-box show">
                <div class="merit-menu-body">
                    @if(count($filteredCategory->subCategories) > 0)
                        <div class="rplc_dropdown_main fixed-scrolling mt-1">
                            <ul class="rplc_dropdown mt-1">
                                @foreach($filteredCategory->subCategories as $subject)
                                    @if($filteredCategory->subCategories()->count() > 0)
                                        <li>
                                            <a class="{{ $subject->slug == $value['subcategory'] ? 'active' : '' }}"
                                               href="#">
                                                {{ ucfirst($subject->subcategory_name) }}
                                                <i class="fa-solid fa-angle-down"></i>
                                            </a>

                                            <ul class="rplc_dropdown_items {{ isset($params['subcategory']) && $params['subcategory']['slug'] == $subject->slug ? 'show' : '' }}">
                                                @foreach($subject->resubcategories as $resubcategory)
                                                    <li>
                                                        <a href="{{ route('past.papers', [$category->slug, $subject->slug, $resubcategory->slug]) }}"
                                                           class="{{ isset($params['resubcategory']) && $params['resubcategory']['slug'] == $resubcategory->slug ? 'active' : '' }}">
                                                            {{ ucfirst($resubcategory->resubcategory_name) }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @else
                                        <li>
                                            <a class="link {{ isset($params['subcategory']) && $params['subcategory']['slug'] == $subject->slug ? 'active' : '' }}"
                                               href="{{ route('past.papers', [$category->slug, $subject->slug]) }}">
                                                {{ ucfirst($subject->subcategory_name) }}
                                            </a>

                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
</div>

