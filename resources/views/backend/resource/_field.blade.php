<div class="">
    <div class="box-body">
        <div class="row mb-3">
            <div class="col-md-8 col-12 pe-4">
                <div class="row mb-3">
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('title', $resource->name ?? '') }}"
                                placeholder="E.G. Year 1 Pure Mathematics">

                            <div class="form-control-feedback d-none text-danger mt-1" id="error-title"></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-12">
                        <div class="form-group">
                            <label class="form-label" for="resource_type">Resource Type</label>
                            <select name="resource_type" id="resource_type" class="form-select">
                                <option selected disabled>Select...</option>
                                @if (!empty($resourceTypes))
                                    @foreach ($resourceTypes as $index => $type)
                                        <option @selected(old('resource_type', $resource->resource_type ?? '') == $index) value="{{ $index }}">
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="form-control-feedback d-none text-danger mt-1" id="error-is_paid"></div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-12">
                        <div class="form-group">
                            <label class="form-label" for="is_group">Is this a group?</label>
                            <select name="is_group" id="is_group" class="form-select">
                                <option @selected(old('is_group', $resource->is_group ?? '') == '0') value="0" selected>No</option>
                                <option @selected(old('is_group', $resource->is_group ?? '') == '1') value="1">Yes</option>
                            </select>
                            <div class="form-control-feedback d-none text-danger mt-1" id="error-is_paid"></div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-12">
                        <div class="form-group">
                            <label class="form-label" for="category">Category</label>
                            <select name="category" id="category" class="form-select" onchange="getSubCategory(this)">
                                <option selected disabled>Select...</option>
                                @if (!empty($categories))
                                    @foreach ($categories as $category)
                                        <option @selected(old('category', $examBoard->category_id ?? '') == $category->id) value="{{ $category->id }}">
                                            {{ $category->category_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="form-control-feedback d-none text-danger mt-1" id="error-category"></div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-12">
                        <div class="form-group">
                            <label class="form-label" for="subcategory">Subcategory</label>
                            <select name="subcategory" onchange="getReSubCategory(this)" id="subcategory"
                                class="form-select select2">
                                @if (!empty($old_cat))
                                    @foreach ($old_cat as $sub)
                                        <option {{ old('subcategory') == $sub->id ? 'selected' : '' }}
                                            value="{{ $sub->id }}">{{ $sub->subcategory_name }}</option>
                                    @endforeach
                                @endif
                                @if (!empty($resource) && !empty($subCategories))
                                    @foreach ($subCategories as $subcategory)
                                        <option
                                            {{ old('subcategory', $examBoard->subcategory_id ?? '') == $subcategory->id ? 'selected' : '' }}
                                            value="{{ $subcategory->id }}">{{ $subcategory->subcategory_name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('subcategory')
                                <div class="form-control-feedback text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="form-control-feedback d-none text-danger mt-1" id="error-subcategory"></div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-12">
                        <div class="form-group">
                            <label class="form-label" for="resubcategory">Exam Board</label>
                            <select name="resubcategory_id" id="resubcategory" onchange="getParents(this)"
                                class="form-select">
                                <option selected disabled>Select...</option>
                                @if (!empty($old_sub))
                                    @foreach ($old_sub as $re)
                                        <option {{ old('resubcategory') == $re->id ? 'selected' : '' }}
                                            value="{{ $re->id }}">{{ $re->resubcategory_name }}</option>
                                    @endforeach
                                @endif
                                @if (!empty($resource) && !empty($boards))
                                    @foreach ($boards as $resubcategory)
                                        <option @selected(old('resubcategory_id', $examBoard->id ?? '') == $resubcategory->id) value="{{ $resubcategory->id }}">
                                            {{ $resubcategory->resubcategory_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="form-control-feedback d-none text-danger mt-1" id="error-resubcategory"></div>

                        </div>
                    </div>

                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <label class="form-label" for="parent_id">Select Parent (optional)</label>
                            <select name="parent_id" id="parent_id" class="form-select">
                                <option selected disabled>Select...</option>

                                @if (!empty($resource) && !empty($parents))
                                    @foreach ($parents as $node)
                                        <option @selected(old('parent_id', $resource->parent_id ?? '') == $node->id) value="{{ $node->id }}">
                                            {{ $node->name }}
                                        </option>
                                    @endforeach
                                @endif
                                {{--                        @if (!empty($parents)) --}}
                                {{--                            @foreach ($parents as $parent) --}}
                                {{--                                <option value="{{ $parent->id }}">{{ $parent->name }}</option> --}}
                                {{--                            @endforeach --}}
                                {{--                        @endif --}}
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-12">
                        <div class="form-group">
                            <label class="form-label" for="is_paid">Is this paid?</label>
                            <select name="is_paid" id="is_paid" class="form-select">
                                <option @selected(old('is_paid', $resource->is_paid ?? '') == '0') value="0">No</option>
                                <option @selected(old('is_paid', $resource->is_paid ?? '') == '1') value="1">Yes</option>
                            </select>
                        </div>
                    </div>

                    {{-- <div class="col-lg-3 col-12">
                        <div class="form-group">
                            <label class="form-label" for="is_section_title">Use as section title? </label>
                            <select name="is_section_title" id="is_section_title" class="form-select">
                                <option @selected(old('is_section_title', $resource->is_section_title ?? '') == '0') value="0">No</option>
                                <option @selected(old('is_section_title', $resource->is_section_title ?? '') == '1') value="1">Yes</option>
                            </select>
                        </div>
                    </div> --}}

                    <div class="col-lg-3 col-12" id="allow_files_section">
                        <div class="form-group">
                            <label class="form-label" for="allow_files">Allow Files</label>
                            <select name="allow_files" id="allow_files" class="form-select">
                                <option @selected(old('allow_files', $resource->allow_files ?? '') == '0') value="0">No</option>
                                <option @selected(old('allow_files', $resource->allow_files ?? '') == '1') value="1">Yes</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-12 {{ isset($resource) && $resource->allow_files ? '' : 'd-none' }}"
                        id="file_orientation_section">
                        <div class="form-group">
                            <label class="form-label" for="file_orientation">Files Orientation</label>
                            <select name="file_orientation" id="file_orientation" class="form-select">
                                <option @selected(old('file_orientation', $resource->file_orientation ?? '') == '1') value="1">Show Straight</option>
                                <option @selected(old('file_orientation', $resource->file_orientation ?? '') == '2') value="2">Show Difficulty</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-12">
                        <div class="form-group">
                            <label class="form-label" for="is_active">Status </label>
                            <select name="is_active" id="is_active" class="form-select">
                                <option @selected(old('is_active', $resource->is_active ?? '') == '1') value="1">Active
                                </option>
                                <option @selected(old('is_active', $resource->is_active ?? '') == '0') value="0">Inactive
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-12 border-start">
                @php
                    $files = $resource->files ?? [];
                @endphp

                <div class="{{ isset($resource) && $resource->allow_files ? '' : 'd-none' }}"
                    id="file-upload-section">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4>File Upload Section</h4>
                        <button class="btn btn-primary btn-sm" type="button" id="addFileBtn">
                            <i class="fa-solid fa-plus"></i> Add File
                        </button>
                    </div>

                    <!-- Container where all upload groups will live -->
                    <div id="upload-groups-container">
                        <!-- ==== First (default) Upload Group ==== -->
                        @if (count($files) > 0)
                            @foreach ($files as $index => $file)
                                <div class="upload-group-wrapper card shadow-sm mb-4 position-relative"
                                    data-index="{{ $index }}">
                                    <!-- Card Header with Item Number & Remove Button -->
                                    <div
                                        class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                                        <span class="fw-bold text-secondary item-title">Upload Item
                                            #{{ $file['id'] ?? '' }}</span>
                                        <button type="button" class="btn-close remove-upload-group"
                                            aria-label="Remove"></button>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">
                                            <!-- g-3 adds consistent gutter spacing between fields -->


                                            <input type="text" value="{{ $file['id'] ?? '' }}"
                                                name="uploads[{{ $index }}][file_id]">

                                            <div class="col-lg-8 col-8">
                                                <!-- Is this paid? -->
                                                <div
                                                    class="col-12 is-pro-wrapper {{ $resource['is_group'] == 1 ? '' : 'd-none' }}">
                                                    <div class="form-group">
                                                        <label class="form-label">Is this pro?</label>
                                                        <select name="uploads[{{ $index }}][is_pro]"
                                                            {{ $resource['is_group'] == 1 ? '' : 'disabled' }}
                                                            class="form-select is_pro_select">
                                                            <option value="0" @selected(($file['is_pro'] ?? 0) == 0)>
                                                                No
                                                            </option>
                                                            <option value="1" @selected(($file['is_pro'] ?? 0) == 1)>
                                                                Yes
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Difficulty Section -->
                                                <div class="col-12 {{ $resource->file_orientation == 2 ? '' : 'd-none' }}"
                                                    difficulty-section">
                                                    <div class="form-group">
                                                        <label class="form-label">Select Difficulty</label>
                                                        <select name="uploads[{{ $index }}][difficulty]"
                                                            class="form-select difficulty-select"
                                                            {{ $resource->file_orientation == 2 ? '' : 'disabled' }}>
                                                            @if (!empty($difficulties))
                                                                @foreach ($difficulties as $indexKey => $difficulty)
                                                                    <option @selected(($file['difficulty'] ?? null) == $indexKey)
                                                                        value="{{ $indexKey }}">
                                                                        {{ $difficulty }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- PDF File Input -->
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-label">PDF File</label>
                                                        <input class="form-control" type="file"
                                                            name="uploads[{{ $index }}][pdfFile]"
                                                            accept=".pdf">
                                                        <div class="form-control-feedback d-none text-danger mt-1">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-lg-4 col-4 text-center">
                                                <p class="fw-bold">File Showcase</p>
                                                <div
                                                    class="d-flex flex-column align-items-center justify-content-center">
                                                    <a href="{{ asset('storage/' . $file['file_path']) }}"
                                                        target="_blank"
                                                        class="child-link text-decoration-none d-flex align-items-center mb-2">
                                                        <i class="fa-solid fa-file-pdf fa-4x text-danger"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            @if (count($files) > 1)
                                                <div class="col-12">
                                                    <p class="fileDeleteButton"
                                                        style="cursor: pointer; color: red; text-decoration: underline;"
                                                        data-url="{{ route('admin.board-resource-file.delete', $file['id'] ?? '') }}"
                                                        data-name="Upload Item #{{ $file['id'] ?? '' }}">
                                                        Want to delete this file segment?
                                                    </p>
                                                </div>
                                            @endif
                                            <!-- Existing Files Preview -->
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <!-- ==== End First Upload Group ==== -->
                    </div>
                </div>
            </div>
        </div>

        <template id="upload-group-template">
            <div class="upload-group-wrapper card shadow-sm mb-4 position-relative" data-index="__INDEX__">

                <!-- Card Header with Item Number & Remove Button -->
                <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                    <span class="fw-bold text-secondary item-title">Upload Item</span>
                    <button type="button"
                        class="btn btn-outline-danger btn-sm border-0 py-0 px-1 remove-upload-group" title="Remove">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div class="card-body">
                    <div class="row g-3">

                        <!-- Is this paid? -->
                        <div class="col-lg-4 col-12 is-pro-wrapper">
                            <div class="form-group">
                                <label class="form-label">Is this paid?</label>
                                <select name="uploads[__INDEX__][is_pro]" class="form-select is_pro_select">
                                    <option value="0" selected>No</option>
                                    <option value="1">Yes</option>
                                </select>
                                <div class="form-control-feedback d-none text-danger mt-1"></div>
                            </div>
                        </div>

                        <!-- Difficulty Section -->
                        <div class="col-lg-4 col-12 d-none difficulty-section">
                            <div class="form-group">
                                <label class="form-label">Select Difficulty</label>
                                <select name="uploads[__INDEX__][difficulty]" class="form-select">
                                    @if (!empty($difficulties))
                                        @foreach ($difficulties as $index => $difficulty)
                                            <option value="{{ $index }}">{{ $difficulty }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="form-control-feedback d-none text-danger mt-1"></div>
                            </div>
                        </div>

                        <!-- PDF File Input -->
                        <div class="col-lg-8 col-8">
                            <div class="form-group">
                                <label class="form-label">PDF File</label>
                                <input class="form-control" type="file" name="uploads[__INDEX__][pdfFile]"
                                    accept=".pdf">
                                <div class="form-control-feedback d-none text-danger mt-1"></div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </template>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <a href="{{ route('admin.past-papers.index') }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-success pull-right">Submit</button>
    </div>
</div>
