<div class="resources_page_right">
    <div class="resources_page_right_pagination">
        <ul>
            @if(!empty($levelModel))
                <li>
                    <a href="{{ route('resource.category', [$levelModel->slug]) }}">
                        {{ ucfirst($levelModel->name) }}
                    </a>
                </li>
            @endif

            @if(!empty($subjectModel))
                <li><i class="fa-solid fa-angle-right"></i></li>
                <li>
                    <a href="{{ route('resources.topic', [$levelModel->slug, $subjectModel->slug]) }}">
                        {{ ucfirst($subjectModel->name) }} WorkSheet
                    </a>
                </li>
            @endif

            @if(!empty($groupModel))
                <li><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="#">{{ ucfirst($groupModel->name) }}</a></li>
            @endif
        </ul>
    </div>

    <div class="resources_page_right_items_all mt-5">
        @if(empty($topicModel))
            <div class="rpri_title">
                <h5>Latest 10 Resources</h5>
            </div>
        @else
            <div class="resources_page_right_title mb-4">
                <h3>{{ $topicModel->title }}</h3>
                <p>{{ $topicModel->description }}</p>
            </div>

            @if(!empty($subTopicModel))
                <div class="rpri_title">
                    <h5>{{ ucfirst($subTopicModel->title) }}</h5>
                    <p>{{ $subTopicModel->description }}</p>
                </div>
            @endif
        @endif


        @if(!empty($allResources))
            @if(isset($allResources['misc']) && $allResources['misc'] === 'active')
                <div class="mt-5">
                    @foreach($allResources['topics'] as $k => $resource)
                        <div class="third-child-box" id="{{ $resource['slug'] }}-third-box">
                            <div class="rpri_title">
                                <h5>{{ ucfirst($resource['title']) }}</h5>
                                <p>{{ $resource['des'] }}</p>
                            </div>
                            <div class="resources_page_right_items">
                                @foreach($resource['resource'] as $item)
                                    <div class="rpr_single_item clickable"
                                         data-link="{{ route("resources.topic.details", [$item, $item->slug]) }}">
                                        <img
                                            src="{{ asset(\Illuminate\Support\Facades\Storage::url($item->thumbnail_image)) }}"
                                            alt="">
                                        <a href="#" class="rpri_pages">
                                            <img
                                                src="{{ asset(\Illuminate\Support\Facades\Storage::url($item->thumbnail_image)) }}"
                                                alt="">
                                            {{ $item->allPage->count() }}
                                        </a>

                                        <div class="rpri_writen">
                                            <h6>{{ ucfirst($item->name) }}</h6>
                                            <p>{{ ucfirst($item->description) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="resources_page_right_items">
                    @foreach($allResources as $k => $resource)

                        <div class="rpr_single_item clickable"
                             data-link="{{ route("resources.topic.details", [$resource, $resource->slug]) }}">
                            <img
                                src="{{ asset(\Illuminate\Support\Facades\Storage::url($resource->thumbnail_image)) }}"
                                alt="">
                            <a href="#" class="rpri_pages">
                                <img
                                    src="{{ asset(\Illuminate\Support\Facades\Storage::url($resource->thumbnail_image)) }}"
                                    alt="">
                                {{ $resource->allPage->count() }}
                            </a>

                            <div class="rpri_writen">
                                <h6>{{ ucfirst($resource->name) }}</h6>
                                <p>{{ ucfirst($resource->description) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif
    </div>


    @if(isset($view) && $view === 'topic')
        <div class="resources_page_right_items_all mt-2">
            <div class="resources_page_right_title mb-4">
                @if(!empty($viewTopic))
                    <h3>{{ $viewTopic->title }}</h3>
                    <p>{{ $viewTopic->description }}</p>
                @endif
            </div>
            @php $simKey = 0 @endphp
            @foreach($latestResources as $subTopic => $resources)
                <div class="d-none simDiv" id="def-{{ $simKey }}">
                    <div class="rpri_title">
                        <h5>{{ $subTopic }}</h5>
                    </div>
{{--                    <div class="resources_page_right_items">--}}
{{--                        @foreach($resources as $resource)--}}
{{--                            <div--}}
{{--                                data-dome="{{ $resource->topic?->educationLevel?->slug }}"--}}
{{--                                data-link="{{ route("resources.topic.details", [$resource, $resource->slug]) }}"--}}
{{--                                class="rpr_single_item clickable">--}}
{{--                                <img--}}
{{--                                    src="{{ asset(\Illuminate\Support\Facades\Storage::url($resource->thumbnail_image)) }}"--}}
{{--                                    alt="">--}}
{{--                                <a href="#" class="rpri_pages">--}}
{{--                                    <img--}}
{{--                                        src="{{ asset(\Illuminate\Support\Facades\Storage::url($resource->thumbnail_image)) }}"--}}
{{--                                        alt="">--}}
{{--                                    {{ $resource->allPage->count() }}--}}
{{--                                </a>--}}

{{--                                <div class="rpri_writen">--}}
{{--                                    <h6>{{ ucfirst($resource->name) }}</h6>--}}
{{--                                    <p>{{ ucfirst($resource->description) }}</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
                </div>
                @php $simKey++ @endphp
            @endforeach
        </div>
    @else

    @endif
</div>
