@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->
            <?php
            if (isset($past_paper)) {
                $actionUrl = route('admin.past-papers.update', ['past_paper' => $past_paper]);
                $method = 'PATCH';
                $scope = 'Update';
            } else {
                $actionUrl = route('admin.board-resources.store');
                $method = 'POST';
                $scope = 'Create';
            }
            ?>

            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">All Board Resource</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#"><i class="mdi mdi-home-outline"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">All Board Resource</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Modal Overlay and Box -->
            <div id="alertOverlay" class="alert-overlay d-none" role="dialog" aria-modal="true"
                 aria-labelledby="alertTitle">
                <div class="alert-box">
                    <h3 id="alertTitle" class="alert-title">Notice</h3>
                    <p class="alert-message" id="alert-overlay-message"></p>
                    <button id="alertCloseBtn" class="alert-btn">Okay</button>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="box-title m-0">List of all board resource</h4>
                                    <a href="{{ route('admin.board-resources.create') }}"
                                       class="ms-auto waves-effect waves-light btn btn-primary">
                                        <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                                        <span class="ms-2">
                                            Create New
                                        </span>
                                    </a>
                                </div>
                            </div>
                            @include('layouts.backend.notification')
                            @php $space = '&nbsp;&nbsp;&nbsp;'; @endphp

                            <div class="box-header with-border">
                                @if($nodes)
                                    @foreach($nodes as $node)
                                        <p class="mb-0">✷ {{ $node['name'] }}</p>
                                        @if(count($node['children']) > 0)
                                            @foreach($node['children'] as $child)

{{--                                                <div style="display: flex; align-items: center; gap: 6px;">--}}
{{--                                                    <div>{!! $space !!}➙</div>--}}
{{--                                                    <p class="mb-0">{{ $child['name'] }}</p>--}}
{{--                                                    @dd($child)--}}
{{--                                                    @if(count($child['files']) > 0)--}}
{{--                                                        @foreach($child['files'] as $file)--}}
{{--                                                            @if($file['type'] === "1")--}}
{{--                                                                --}}
{{--                                                            @endif--}}
{{--                                                        @endforeach--}}
{{--                                                    @endif--}}

{{--                                                    <i class="fa-solid fa-file-pdf" style="font-size: 16px; color: red;"></i>--}}
{{--                                                </div>--}}

                                                @if(isset($child['files']) && count($child['files']) > 0)
                                                    @php
                                                        $fileType = $child['files'][0]['type'] ?? 1;
                                                        $groupLeader = $child['files'][0]['board_resource_id'] === $child['id'] && $child['is_section_title'] ? $child['name'] : '';
                                                    @endphp

{{--                                                    @php--}}
{{--                                                        var_dump($fileType);--}}
{{--                                                        var_dump($child);--}}
{{--                                                    @endphp--}}

                                                    @if($fileType == 1)
                                                        {{-- Type 1: Click the child directly to open the PDF file in a new tab --}}
                                                        <a href="{{ asset('storage/' . $child['files'][0]['file_path']) }}" target="_blank" class="child-link">
                                                            {!! $space !!}➙ {{ $child['name'] }} <i class="fa-solid fa-file-pdf" style="font-size: 16px; color: red;"></i>
                                                        </a>

                                                    @elseif($fileType == 2)
                                                        {{-- Type 2: Group files by difficulty and list them --}}
                                                        <div class="child-group-container">
                                                            @if(!empty($groupLeader))
                                                                <div class="child-header">
                                                                   {!! $space . $space !!} {{ $groupLeader }}
                                                                </div>
                                                            @endif
                                                            <div class="child-header">
                                                                {!! $space !!}✧ {{ $child['name'] }}
                                                            </div>

                                                            @php
                                                                // Group the files collection/array by the 'difficulty' key
                                                                $groupedFiles = collect($child['files'])->groupBy('difficulty');
                                                            @endphp

                                                            @foreach($groupedFiles as $difficulty => $files)
                                                                <div class="difficulty-section d-flex gap-2">
                                                                    {{-- Print the difficulty label (Map numbers/strings to readable labels if needed) --}}
                                                                    <span class="difficulty-label">
                                                                        @switch($difficulty)
                                                                            @case('0') {{ $space }} Beginner @break
                                                                            @case('1') {!! $space . $space . $space !!} Medium @break
                                                                            @case('2') {!! $space . $space . $space !!} Hard @break
                                                                            @default Level {{ $difficulty }}
                                                                        @endswitch
                                                                    </span>

                                                                    <div class="file-badges">
                                                                        @foreach($files as $index => $file)
                                                                            <a href="{{ asset('storage/' . $file['file_path']) }}" target="_blank" class="file-badge @if($file['is_pro']) pro-badge @endif">
                                                                                {{ $index + 1 }}
                                                                                @if($file['is_pro']) <span class="pro-tag">PRO</span> @endif
                                                                            </a>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                @else
                                                    {{-- Fallback when no files exist --}}
                                                    <p class="child-name mb-0">{!! $space !!}✧ {{ $child['name'] }}</p>
                                                    @if(count($child['children']) > 0)
                                                        @foreach($child['children'] as $preChild)
                                                            @if(isset($preChild['files']) && count($preChild['files']) > 0)
                                                                @php
                                                                    $fileType = $preChild['files'][0]['type'] ?? 1;
                                                                    $groupLeader = $preChild['files'][0]['board_resource_id'] === $preChild['id'] && $preChild['is_section_title'] ? $preChild['name'] : '';
                                                                @endphp

                                                                @if($fileType == 1)
                                                                    {{-- Type 1: Click the child directly to open the PDF file in a new tab--}}
                                                                    <a href="{{ asset('storage/' . $preChild['files'][0]['file_path']) }}" target="_blank" class="child-link">
                                                                        {!! $space . $space !!}➙ {{ $preChild['name'] }} <i class="fa-solid fa-file-pdf" style="font-size: 16px; color: red;"></i>
                                                                    </a>

                                                                @elseif($fileType == 2)
                                                                    {{-- Type 2: Group files by difficulty and list them--}}
                                                                    <div class="child-group-container">
                                                                        @if(!empty($groupLeader))
                                                                            <div class="child-header">
                                                                                {!! $space . $space !!} {{ $groupLeader }}
                                                                            </div>
                                                                        @endif
                                                                        <div class="child-header">
                                                                            {!! $space !!}✧ {{ $preChild['name'] }}
                                                                        </div>

                                                                        @php
                                                                            // Group the files collection/array by the 'difficulty' key
                                                                            $groupedFiles = collect($preChild['files'])->groupBy('difficulty');
                                                                        @endphp

                                                                        @foreach($groupedFiles as $difficulty => $files)
                                                                            <div class="difficulty-section d-flex gap-2">
                                                                                {{--  Print the difficulty label (Map numbers/strings to readable labels if needed)--}}
                                                                                <span class="difficulty-label">
                                                                                    @switch($difficulty)
                                                                                        @case('0') {{ $space }} Beginner @break
                                                                                        @case('1') {!! $space . $space . $space !!} Medium @break
                                                                                        @case('2') {!! $space . $space . $space !!} Hard @break
                                                                                        @default Level {{ $difficulty }}
                                                                                    @endswitch
                                                                                </span>

                                                                                <div class="file-badges">
                                                                                    @foreach($files as $index => $file)
                                                                                        <a href="{{ asset('storage/' . $file['file_path']) }}" target="_blank" class="file-badge @if($file['is_pro']) pro-badge @endif">
                                                                                            {{ $index + 1 }}
                                                                                            @if($file['is_pro']) <span class="pro-tag">PRO</span> @endif
                                                                                        </a>
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            @else
                                                                {{-- Fallback when no files exist --}}
                                                                <p class="child-name">{!! $space !!}✧ {{ $preChild['name'] }}</p>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@section('js')

    <script>
        function getSubCategory(el) {
            const category_id = $("#category").val();
            const subCategoryTag = $('#subcategory');

            if (category_id) {
                const route = "{{ route('admin.ajax.getSubCategory', [':category_id']) }}";
                const url = route.replace(':category_id', category_id);

                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {

                        subCategoryTag.empty();
                        subCategoryTag.append('<option selected disabled>Select</option>');
                        $.each(data, function (index, districtObj) {
                            subCategoryTag.append('<option value="' + districtObj.id + '">' +
                                districtObj.subcategory_name + '</option>');
                        });
                    }
                });
            } else {
                alert('sorry data not found');
            }

        }

        function getReSubCategory(el) {
            const subcategory_id = $("#subcategory").val();
            const resubcategoryTag = $("#resubcategory");

            if (subcategory_id) {
                const route = "{{ route('admin.ajax.getReSubCategory', [':subcategory_id']) }}";
                const url = route.replace(':subcategory_id', subcategory_id);
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        resubcategoryTag.empty();
                        resubcategoryTag.append('<option selected disabled>Select</option>');
                        $.each(data, function (index, districtObj) {
                            resubcategoryTag.append('<option value="' + districtObj.id + '">' +
                                districtObj.resubcategory_name + '</option>');
                        });
                    }
                });
            } else {
                alert('sorry data not found');
            }
        }
    </script>


    <script>


    </script>
@endsection
