<div class="">
    <div class="box-body">
        <div class="row mb-3">
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control"
                           value="{{ old('title', $past_paper->title ?? '') }}" placeholder="Enter title">

                    <div class="form-control-feedback d-none text-danger mt-1" id="error-title"></div>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <div class="form-group">
                    <label class="form-label" for="resource_type">Resource Type</label>
                    <select name="resource_type" id="resource_type" class="form-control">
                        <option selected disabled>Select...</option>
                        @if(!empty($resourceTypes))
                            @foreach($resourceTypes as $index => $type)
                                <option value="{{ $index }}">{{ $type }}</option>
                            @endforeach
                        @endif
                    </select>
                    <div class="form-control-feedback d-none text-danger mt-1" id="error-is_paid"></div>
                </div>
            </div>

            <div class="col-lg-3 col-12">
                <div class="form-group">
                    <label class="form-label" for="is_group">Is this a group?</label>
                    <select name="is_group" id="is_group" class="form-control">
                        <option value="0" selected>No</option>
                        <option value="1">Yes</option>
                    </select>
                    <div class="form-control-feedback d-none text-danger mt-1" id="error-is_paid"></div>
                </div>
            </div>

{{--            <div class="col-lg-3 col-12">--}}
{{--                <div class="form-group">--}}
{{--                    <label class="form-label" for="is_group">Is this a group?</label>--}}
{{--                    <div class="custom-radio-options">--}}
{{--                        <label class="custom-radio-item" style="color: black">--}}
{{--                            <input type="radio"--}}
{{--                                   {{ old('have_solution', $past_paper->have_solution ?? 0) == 1 ? 'checked' : '' }}--}}
{{--                                   name="is_group" id="radio_7" value="yes">--}}
{{--                            <span class="radio-btn"></span>--}}
{{--                            <span>Yes</span>--}}
{{--                        </label>--}}
{{--                        <label class="custom-radio-item" style="color: black">--}}
{{--                            <input type="radio"--}}
{{--                                   {{ old('have_solution', $past_paper->have_solution ?? 0) == 0 ? 'checked' : '' }}--}}
{{--                                   name="have_solution" id="radio_9" value="no">--}}
{{--                            <span class="radio-btn"></span>--}}
{{--                            <span>No</span>--}}
{{--                        </label>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

            <div class="col-lg-4 col-12">
                <div class="form-group">
                    <label class="form-label" for="category">Category</label>
                    <select name="category" id="category" class="form-control" onchange="getSubCategory(this)"
                            required>
                        <option selected disabled>Select...</option>
                        @foreach ($categories as $category)
                            <option
                                {{ old('category', $past_paper->category ?? '') == $category->id ? 'selected' : '' }}
                                value="{{ $category->id }}">
                                {{ $category->category_name }}</option>
                        @endforeach

                    </select>
                    <div class="form-control-feedback d-none text-danger mt-1" id="error-category"></div>
                </div>
            </div>

            <div class="col-lg-4 col-12">
                <div class="form-group">
                    <label class="form-label" for="subcategory">SubCategory</label>
                    <select name="subcategory" onchange="getReSubCategory(this)" id="subcategory"
                            class="form-control select2">
{{--                        <option selected disabled>Select...</option>--}}
                        @if (!empty($old_cat))
                            @foreach ($old_cat as $sub)
                                <option {{ old('subcategory') == $sub->id ? 'selected' : '' }}
                                        value="{{ $sub->id }}">{{ $sub->subcategory_name }}</option>
                            @endforeach
                        @endif
                        @if (!empty($past_paper))
                            @foreach ($subcategories as $subcategory)
                                <option
                                    {{ old('subcategory', $past_paper->subcategory ?? '') == $subcategory->id ? 'selected' : '' }}
                                    value="{{ $subcategory->id }}">{{ $subcategory->subcategory_name }}</option>
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
                    <label class="form-label" for="resubcategory">ReSubCategory</label>
                    <select name="resubcategory_id" id="resubcategory" onchange="getParents(this)" class="form-control">
                        <option selected disabled>Select...</option>
                        @if (!empty($old_sub))
                            @foreach ($old_sub as $re)
                                <option {{ old('resubcategory') == $re->id ? 'selected' : '' }}
                                        value="{{ $re->id }}">{{ $re->resubcategory_name }}</option>
                            @endforeach
                        @endif
                        @if (!empty($past_paper))
                            @foreach ($resubcategories as $resubcategory)
                                <option
                                    {{ old('resubcategory', $past_paper->resubcategory ?? '') == $resubcategory->id ? 'selected' : '' }}
                                    value="{{ $resubcategory->id }}">{{ $resubcategory->resubcategory_name }}</option>
                            @endforeach
                        @else
                        @endif
                    </select>
                    <div class="form-control-feedback d-none text-danger mt-1" id="error-resubcategory"></div>

                </div>
            </div>

            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label class="form-label" for="parent_id">Select Parent (optional)</label>
                    <select name="parent_id" id="parent_id" class="form-control">
                        <option selected disabled>Select...</option>
{{--                        @if(!empty($parents))--}}
{{--                            @foreach($parents as $parent)--}}
{{--                                <option value="{{ $parent->id }}">{{ $parent->name }}</option>--}}
{{--                            @endforeach--}}
{{--                        @endif--}}
                    </select>
                    <div class="form-control-feedback d-none text-danger mt-1" id="error-is_paid"></div>
                </div>
            </div>

            <div class="col-lg-3 col-12">
                <div class="form-group">
                    <label class="form-label" for="is_paid">Is parent is pro?</label>
                    <select name="is_paid" id="is_paid" class="form-control">
                        <option value="0" selected>No</option>
                        <option value="1">Yes</option>
                    </select>
                    <div class="form-control-feedback d-none text-danger mt-1" id="error-is_paid"></div>
                </div>
            </div>

            <div class="col-lg-3 col-12">
                <div class="form-group">
                    <label class="form-label" for="is_section_title">Use as section title? </label>
                    <select name="is_section_title" id="is_section_title" class="form-control">
                        <option value="0" selected>No</option>
                        <option value="1">Yes</option>
                    </select>
                    <div class="form-control-feedback d-none text-danger mt-1" id="error-is_active"></div>
                </div>
            </div>

            <div class="col-lg-3 col-12">
                <div class="form-group">
                    <label class="form-label" for="is_active">Status </label>
                    <select name="is_active" id="is_active" class="form-control">
                        <option {{ old('is_active', $past_paper->is_active ?? 1) == 1 ? 'selected' : '' }}
                                value="1">Active
                        </option>
                        <option {{ old('is_active', $past_paper->is_active ?? 1) == 0 ? 'selected' : '' }}
                                value="0">Inactive
                        </option>
                    </select>
                    <div class="form-control-feedback d-none text-danger mt-1" id="error-is_active"></div>
                </div>
            </div>
        </div>


        <div class="" id="file-upload-section">
            <h4>File Upload Section</h4>

            <div class="row">
{{--                <div class="col-lg-6 col-12">--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="name" class="form-label">Title</label>--}}
{{--                        <input type="text" name="name" id="name" class="form-control"--}}
{{--                               value="{{ old('title', $past_paper->title ?? '') }}" placeholder="Enter title">--}}

{{--                        <div class="form-control-feedback d-none text-danger mt-1" id="error-title"></div>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <div class="col-lg-4 col-12">
                    <div class="form-group">
                        <label class="form-label" for="type">Select Type of presentation</label>
                        <select name="type" id="type" class="form-control">
                            <option value="1" selected>Straight</option>
                            <option value="2">Difficulty</option>
                        </select>
                        <div class="form-control-feedback d-none text-danger mt-1" id="error-category"></div>
                    </div>
                </div>

                <div class="col-lg-4 col-12 d-none" id="difficulty-section">
                    <div class="form-group">
                        <label class="form-label" for="difficulty">Select Difficulty</label>
                        <select name="difficulty" id="difficulty" class="form-control">
                            @if(!empty($difficulties))
                                @foreach($difficulties as $index => $difficulty)
                                    <option value="{{ $index }}">{{ $difficulty }}</option>
                                @endforeach
                            @endif
                        </select>
                        <div class="form-control-feedback d-none text-danger mt-1" id="error-is_paid"></div>
                    </div>
                </div>

                <div class="col-lg-4 col-12">
                    <div class="form-group">
                        <label class="form-label" for="is_pro">Is this paid?</label>
                        <select name="is_pro" id="is_pro" class="form-control">
                            <option value="0" selected>No</option>
                            <option value="1">Yes</option>
                        </select>
                        <div class="form-control-feedback d-none text-danger mt-1" id="error-is_paid"></div>
                    </div>
                </div>

                <div class="col-lg-12 col-12">
                    <div class="upload-group full" data-uploader="">
                        <div class="mb-3">
                            <label for="pdfFile" class="form-label fw-bold">PDF File</label>
                            <input class="form-control" type="file" id="pdfFile" name="pdfFile" accept=".pdf">
                        </div>
                        <div class="form-control-feedback d-none text-danger mt-1" id="error-ques_paper"></div>
                    </div>
                </div>
            </div>
        </div>


        <div id="previewModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-black-50">PDF Preview</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            Are you want to delete <span id="element-name" class="font-weight-bold text-danger"></span>?</p>
                        </div>

                        <iframe id="viewer" class="viewer" title="PDF preview" src=""></iframe>
                    </div>
                    <div class="modal-footer d-flex pt-0">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>



    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <a href="{{ route('admin.past-papers.index') }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-success pull-right">Submit</button>
    </div>
</div>
