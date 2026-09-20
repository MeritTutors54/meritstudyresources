@extends('layouts.backend')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .select2-container .select2-selection--single {
            height: 35px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 5px;
        }

        .select2-container--default .select2-selection--single {
            padding: 6px 0 0 6px;
        }

        .select2-container--default .select2-selection--single .select2-selection__clear {
            height: 22px;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            color: #ffffff !important;
        }
    </style>

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

            <style>
                .tree-box {
                    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
                    padding: 15px;
                    margin-bottom: 15px;
                    border-radius: 4px;
                    background: #fff;
                }







                /* Card Container */
                .resource-card {
                    background: #ffffff;
                    border: 1px solid #e2e8f0;
                    border-radius: 12px;
                    overflow: hidden;
                    transition: box-shadow 0.2s ease;
                }

                .resource-card:hover {
                    box-shadow: 0 8px 24px rgba(149, 157, 165, 0.12) !important;
                }

                .resource-card-header {
                    background: #f8fafc;
                    padding: 16px 20px;
                    border-bottom: 1px solid #e2e8f0;
                }

                .resource-card-body {
                    padding: 16px 20px;
                }

                /* Tree Structure & Connectors */
                .tree-branch {
                    position: relative;
                    border-left: 2px dashed #e2e8f0;
                    margin-left: 10px;
                    padding-left: 8px;
                }

                .tree-node {
                    position: relative;
                    margin-bottom: 8px;
                }

                .tree-node:last-child {
                    margin-bottom: 0;
                }

                /* Rows */
                .node-row {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    padding: 8px 12px;
                    border-radius: 8px;
                    transition: background 0.15s ease;
                }

                .node-row:hover {
                    background-color: #f8fafc;
                }

                .node-row.group-header {
                    background-color: #f1f5f9;
                    font-size: 0.95rem;
                }

                .resource-title-link {
                    color: #1e293b;
                    text-decoration: none;
                    font-weight: 500;
                    font-size: 0.925rem;
                    transition: color 0.15s ease;
                }

                .resource-title-link:hover {
                    color: #3b82f6;
                    text-decoration: underline;
                }

                /* Icon Box Indicators */
                .icon-avatar {
                    width: 38px;
                    height: 38px;
                    border-radius: 8px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 1.1rem;
                }

                .root-icon {
                    background: #e0e7ff;
                    color: #4f46e5;
                }

                .file-type-icon {
                    width: 28px;
                    height: 28px;
                    border-radius: 6px;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 0.85rem;
                }

                .file-type-icon.pdf {
                    background: #fee2e2;
                    color: #ef4444;
                }

                .file-type-icon.group {
                    background: #e0f2fe;
                    color: #0284c7;
                }

                .file-type-icon.section {
                    background: #f1f5f9;
                    color: #64748b;
                }

                /* Badges */
                .badge-pro {
                    background: linear-gradient(135deg, #f59e0b, #d97706);
                    color: #fff;
                    font-size: 0.65rem;
                    font-weight: 700;
                    padding: 2px 6px;
                    border-radius: 4px;
                    letter-spacing: 0.5px;
                    text-transform: uppercase;
                }

                /* Difficulty Section */
                .node-group-container {
                    background: #ffffff;
                    border: 1px solid #eef2f6;
                    border-radius: 8px;
                    padding: 6px;
                    margin-top: 4px;
                }

                .difficulty-wrapper {
                    padding: 8px 12px 6px 36px;
                    display: flex;
                    flex-direction: column;
                    gap: 8px;
                }

                .difficulty-row {
                    display: flex;
                    align-items: center;
                    gap: 12px;
                }

                .difficulty-pill {
                    min-width: 68px;
                    text-align: center;
                    font-size: 0.72rem;
                    font-weight: 700;
                    padding: 3px 8px;
                    border-radius: 6px;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                }

                .diff-easy {
                    background: #dcfce7;
                    color: #15803d;
                }

                .diff-medium {
                    background: #fef3c7;
                    color: #b45309;
                }

                .diff-hard {
                    background: #fee2e2;
                    color: #b91c1c;
                }

                .diff-default {
                    background: #f1f5f9;
                    color: #475569;
                }

                /* File Chips */
                .badge-file-list {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 6px;
                }

                .file-chip {
                    display: inline-flex;
                    align-items: center;
                    gap: 4px;
                    background: #ffffff;
                    border: 1px solid #cbd5e1;
                    color: #334155;
                    font-size: 0.78rem;
                    font-weight: 500;
                    padding: 2px 10px;
                    border-radius: 16px;
                    text-decoration: none;
                    transition: all 0.15s ease;
                }

                .file-chip:hover {
                    background: #f8fafc;
                    border-color: #94a3b8;
                    color: #0f172a;
                    transform: translateY(-1px);
                }

                .file-chip.is-pro {
                    border-color: #fcd34d;
                    background: #fffbeb;
                }

                .chip-pro-tag {
                    font-size: 0.6rem;
                    font-weight: 800;
                    color: #d97706;
                }

                /* Action Buttons */
                .action-group {
                    display: flex;
                    align-items: center;
                    gap: 4px;
                    opacity: 0.6;
                    transition: opacity 0.15s ease;
                }

                .node-row:hover .action-group,
                .resource-card-header:hover .action-group {
                    opacity: 1;
                }

                .btn-action {
                    background: transparent;
                    border: none;
                    width: 28px;
                    height: 28px;
                    border-radius: 6px;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    cursor: pointer;
                    font-size: 0.825rem;
                    transition: all 0.15s ease;
                    text-decoration: none;
                }

                .btn-edit {
                    color: #f59e0b;
                }

                .btn-edit:hover {
                    background: #fef3c7;
                    color: #d97706;
                }

                .btn-delete {
                    color: #ef4444;
                }

                .btn-delete:hover {
                    background: #fee2e2;
                    color: #dc2626;
                }
            </style>


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

                            {{-- <div class="box-header with-border">
                                @if (!empty($nodes))
                                    @foreach ($nodes as $node)
                                        <div class="card p-3 mb-3">
                                            <div class="d-flex gap-2">
                                                <p class="mb-0">✷ {{ $node['name'] }}</p>
                                                <a href="{{ route('admin.board-resources.edit', $node['id']) }}">
                                                    <i class="fa-solid fa-pen-to-square"
                                                        style="font-size: 16px; color: #ffc107;"></i></a>
                                                <i class="fa-solid fa-trash" style="font-size: 16px; color: #dc3545;"></i>
                                            </div>

                                            @if (!empty($node['children']))
                                                @foreach ($node['children'] as $child)

                                                    @include('backend.resource.partials.node-item', [
                                                        'node' => $node,
                                                        'item' => $child,
                                                        'depth' => 1,
                                                    ])

                                                    @if (!empty($child['children']))
                                                        @foreach ($child['children'] as $preChild)
                                                            @include(
                                                                'backend.resource.partials.node-item',
                                                                ['item' => $preChild, 'depth' => 2]
                                                            )
                                                        @endforeach
                                                    @endIf
                                                @endforeach
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div> --}}


                            <div class="">
                                <form class="d-flex flex-column flex-lg-row align-items-lg-end gap-3 p-4">
                                    <!-- Category -->
                                    <div class="flex-grow-1">
                                        <div class="form-group mb-0">
                                            <label class="form-label" for="category">Category</label>
                                            <select name="category" id="category" class="form-select"
                                                onchange="getSubCategory(this)">
                                                <option selected disabled>Select...</option>
                                                @if (!empty($categories))
                                                    @foreach ($categories as $category)
                                                        <option @selected(old('category', $data['selectedCategory'] ?? '') == $category->id) value="{{ $category->id }}">
                                                            {{ $category->category_name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <div class="form-control-feedback d-none text-danger mt-1" id="error-category">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- SubCategory -->
                                    <div class="flex-grow-1">
                                        <div class="form-group mb-0">
                                            <label class="form-label" for="subcategory">SubCategory</label>
                                            <select name="subcategory" onchange="getReSubCategory(this)" id="subcategory"
                                                class="form-select select2">
                                                @if (!empty($old_cat))
                                                    @foreach ($old_cat as $sub)
                                                        <option {{ old('subcategory') == $sub->id ? 'selected' : '' }}
                                                            value="{{ $sub->id }}">
                                                            {{ $sub->subcategory_name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                                @if (!empty($data['subcategories']))
                                                    @foreach ($data['subcategories'] as $subcategory)
                                                        <option
                                                            {{ old('subcategory', $data['selectedSubCategory'] ?? '') == $subcategory->id ? 'selected' : '' }}
                                                            value="{{ $subcategory->id }}">
                                                            {{ $subcategory->subcategory_name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('subcategory')
                                                <div class="form-control-feedback text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                            <div class="form-control-feedback d-none text-danger mt-1"
                                                id="error-subcategory">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- ReSubCategory -->
                                    <div class="flex-grow-1">
                                        <div class="form-group mb-0">
                                            <label class="form-label" for="resubcategory">ReSubCategory</label>
                                            <select name="resubcategory_id" id="resubcategory" onchange="getParents(this)"
                                                class="form-select">
                                                <option selected disabled>Select...</option>
                                                @if (!empty($old_sub))
                                                    @foreach ($old_sub as $re)
                                                        <option {{ old('resubcategory') == $re->id ? 'selected' : '' }}
                                                            value="{{ $re->id }}">
                                                            {{ $re->resubcategory_name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                                @if (!empty($data['resubcategories']))
                                                    @foreach ($data['resubcategories'] as $resubcategory)
                                                        <option @selected(old('resubcategory_id', $data['selectedResubcategory'] ?? '') == $resubcategory->id)
                                                            value="{{ $resubcategory->id }}">
                                                            {{ $resubcategory->resubcategory_name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <div class="form-control-feedback d-none text-danger mt-1"
                                                id="error-resubcategory">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Filter Button -->
                                    <div class="flex-shrink-0">
                                        <button type="submit" class="btn btn-primary w-100 px-4" id="filterBtn">
                                            Filter
                                        </button>
                                    </div>
                                </form>
                            </div>

                            @if (!empty($data['syllabus']))
                                <div class="px-4">
                                    @php
                                        $hint = 0;
                                    @endphp
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        @foreach ($data['syllabus'] as $groupName => $portion)
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link {{ $hint === 0 ? 'active' : '' }}" id="{{ $groupName }}-tab"
                                                    data-bs-toggle="tab" data-bs-target="#{{ $groupName }}-pane"
                                                    type="button" role="tab" aria-controls="{{ $groupName }}-pane"
                                                    aria-selected="true">
                                                    {{ $groupName }}
                                                </button>
                                            </li>
                                            @php
                                                $hint++;
                                            @endphp
                                        @endforeach
                                    </ul>
                                </div>
                            @endif


                            @if (!empty($data['syllabus']))
                                <div class="tab-content border border-top-0 p-4 bg-white rounded-bottom" id="myTabContent">
                                    @php
                                        $peHint = 0;
                                    @endphp
                                    @foreach ($data['syllabus'] as $resource => $syllabus)
                                        <div class="tab-pane fade {{ $peHint === 0 ? 'active show' : '' }}"
                                        id="{{ $resource }}-pane" role="tabpanel"
                                            aria-labelledby="{{ $resource }}-tab" tabindex="0">
                                            <h4>{{ $resource }} Content</h4>
                                            <div class="resource-tree-container">
                                                @if (!empty($syllabus))
                                                    @foreach ($syllabus as $node)
                                                        <div class="resource-card mb-4 shadow-sm">
                                                            {{-- Root Node Header --}}
                                                            <div
                                                                class="resource-card-header d-flex align-items-center justify-content-between">
                                                                <div class="d-flex align-items-center gap-3">
                                                                    <div class="icon-avatar root-icon">
                                                                        <i class="fa-solid fa-folder-open"></i>
                                                                    </div>
                                                                    <div>
                                                                        <h5 class="mb-0 fw-bold text-dark">
                                                                            {{ $node['name'] }}
                                                                        </h5>
                                                                        <small
                                                                            class="text-muted">{{ count($node['children'] ?? []) }}
                                                                            Sub-items</small>
                                                                    </div>
                                                                </div>

                                                                {{-- Root Actions --}}
                                                                <div class="action-group">
                                                                    <a href="{{ route('admin.board-resources.edit', $node['id']) }}"
                                                                        class="btn-action btn-edit" title="Edit">
                                                                        <i class="fa-solid fa-pen-to-square fa-2x"></i>
                                                                    </a>
                                                                    <button type="button" class="btn-action btn-delete"
                                                                        title="Delete">
                                                                        <i class="fa-solid fa-trash fa-2x"></i>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                            {{-- Children Tree View --}}
                                                            @if (!empty($node['children']))
                                                                <div class="resource-card-body">
                                                                    <div class="tree-branch">
                                                                        @foreach ($node['children'] as $child)
                                                                            @include(
                                                                                'backend.resource.partials.node-item',
                                                                                [
                                                                                    'node' => $node,
                                                                                    'item' => $child,
                                                                                    'depth' => 1,
                                                                                ]
                                                                            )
                                                                            @if (!empty($child['children']))
                                                                                @foreach ($child['children'] as $preChild)
                                                                                    @include(
                                                                                        'backend.resource.partials.node-item',
                                                                                        [
                                                                                            'item' => $preChild,
                                                                                            'depth' => 2,
                                                                                        ]
                                                                                    )
                                                                                @endforeach
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="text-center py-5 text-muted">
                                                        <i
                                                            class="fa-solid fa-folder-open display-4 mb-3 text-secondary opacity-50"></i>
                                                        <p class="mb-0">No resources found.</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        @php
                                            $peHint++;
                                        @endphp
                                    @endforeach
                                    {{-- <div class="tab-pane fade" id="profile-pane" role="tabpanel"
                                        aria-labelledby="profile-tab" tabindex="0">
                                        <h4>Profile Content</h4>
                                        <p>This is the content panel for the Profile tab. User profile information or
                                            settings
                                            can go here.</p>
                                    </div>
                                    <div class="tab-pane fade" id="contact-pane" role="tabpanel"
                                        aria-labelledby="contact-tab" tabindex="0">
                                        <h4>Contact Content</h4>
                                        <p>This is the content panel for the Contact tab. Add contact forms, emails, or
                                            phone
                                            numbers here.</p>
                                    </div> --}}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#subcategory').select2({
                placeholder: "Select...",
                allowClear: true,
                width: '100%'
            });
        });


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
                    success: function(data) {

                        subCategoryTag.empty();
                        subCategoryTag.append('<option selected disabled>Select</option>');
                        $.each(data, function(index, districtObj) {
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
                    success: function(data) {
                        resubcategoryTag.empty();
                        resubcategoryTag.append('<option selected disabled>Select</option>');
                        $.each(data, function(index, districtObj) {
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


    <script></script>
@endsection
