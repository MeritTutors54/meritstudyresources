<div class="resources_page_left_main">
    <div class="resources_page_left">
        <div class="resources_page_left_contents">
            {{-- this is first view--}}
            @if(isset($mainView) && $mainView)
                @if(!empty($educationLevels))
                    @php $key = 0 @endphp
                    <div class="merit-menu-box mt-3">
                        @foreach($educationLevels as $level)
                            <div class="merit-menu-item">
                                <h2 class="merit-menu-header">
                                    <button
                                        class="menu-button"
                                        type="button" data-area-id="merit-menu-id-{{$key}}">
                                        {{ ucfirst($level->name) }}
                                    </button>
                                </h2>
                                <div id="merit-menu-id-{{$key}}"
                                     class="merit-menu-dropdown-box">
                                    <div class="merit-menu-body">
                                        @if(count($level->allSubjects) > 0)
                                            <ul class="rplc_dropdown mt-1">
                                                @foreach($level->allSubjects as $subject)
                                                    <li>
                                                        <a class="link"
                                                           href="{{ route('resources.topic', [$level->slug, $subject->slug]) }}">
                                                            {{ ucfirst($subject->name) }}
                                                        </a>
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
                @endif
            @endif

            {{-- this is second view--}}
            {{-- This section is represent the singluer version of selected menu--}}
            @if(!empty($sidebar))
                <div class="rplc_title">
                    @if(!empty($levelModel))
                        <h6><i>{{ ucfirst($levelModel->name) }}</i></h6>
                    @endif
                    @if(!empty($subjectModel))
                        <p>{{ ucfirst($subjectModel->name) }} WorkSheet</p>
                    @endif
                </div>

                <div class="merit-menu-box mt-3">
                    @php $key = 0 @endphp
                    @foreach($sidebar as $topicGroups)
                        <div class="merit-menu-item mb-2">
                            {{-- This represent "topic group" --}}
                            <h2 class="merit-menu-header">
                                <button
                                    class="menu-button {{ !empty($groupModel) && $topicGroups['slug'] == $groupModel->slug ? 'active' : '' }}"
                                    data-area-id="merit-menu-id-{{$key}}"
                                    type="button">
                                    {{ ucfirst($topicGroups['group']) }}
                                </button>
                            </h2>
                            <div id="merit-menu-id-{{$key}}"
                                 class="merit-menu-dropdown-box {{ !empty($groupModel) && $topicGroups['slug'] == $groupModel->slug ? 'show' : '' }}">
                                <div class="merit-menu-body">
                                    <ul class="rplc_dropdown mt-1">
                                        @foreach($topicGroups['topics'] as $topics)
                                            <li>
                                                @if($topics['children_count'] == 0)
                                                    {{-- This represent "topic" - who does not have any child--}}
                                                    <a
                                                        href="{{ route('resources.topic', [$levelModel->slug, $subjectModel->slug, $topicGroups['slug'], $topics['slug']]) }}"
                                                        class="link {{ !empty($topicModel) && $topics['slug'] == $topicModel->slug ? 'active' : '' }}">
                                                        {{ $topics['title'] }}
                                                    </a>
                                                @else
                                                     This represent "topic" - who have child
                                                    <a class="{{ !empty($topicModel) && $topics['slug'] == $topicModel->slug ? 'active' : '' }}"
                                                       href="#">
                                                        {{ $topics['title'] }}
                                                        <i class="fa-solid fa-angle-down"></i>
                                                    </a>
                                                @endif
                                                @if($topics['children_count'] != 0)
                                                    <ul class="rplc_dropdown_items">
                                                        @foreach($topics['children'] as $topic)
                                                            <li>
                                                                 This represent "topic" - who have parent
                                                                <a
                                                                    href="{{ route('resources.topic', [$levelModel->slug, $subjectModel->slug, $topicGroups['slug'], $topics['slug'], $topic['slug']]) }}"
                                                                    class="{{ !empty($subTopicModel) && $topic['slug'] == $subTopicModel->slug ? 'active' : '' }}">
                                                                    {{ $topic['title'] }}
                                                                </a>
                                                                @if($topic['children_count'] != 0)
                                                                    <ul class="{{ !empty($subTopicModel) && $topic['slug'] == $subTopicModel->slug ? '' : 'd-none' }}">
                                                                        @foreach($topic['children'] as $subTopic)
                                                                            <li>
                                                                                 This represent children of "sub topic" - 3rd nested tree
                                                                                <a class="third-child-button {{ !empty($extraModel) && $extraModel->slug == $subTopic['slug'] ? 'active' : '' }}"
                                                                                   href="#{{$subTopic['slug']}}"
                                                                                >
                                                                                    {{ $subTopic['title'] }}
                                                                                </a>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @php $key++ @endphp
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>


