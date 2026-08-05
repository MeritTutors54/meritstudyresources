<div class="custom-body-deep">
    <div class="box-body">
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <input type="hidden" name="uploads_type" value="Past Paper">
                    <label for="name" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="custom-input"
                           value="{{ old('title', $past_paper->title ?? '') }}" placeholder="Enter title">

                    <div class="form-control-feedback d-none text-danger mt-1" id="error-title"></div>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label class="form-label" for="exam_series">Series</label>
                    <select name="exam_series" id="exam_series" class="custom-select" required>
                        <option selected disabled>Select...</option>
                        @foreach ($examSeries as $series)
                            <option
                                {{ old('exam_series', $past_paper->exam_series ?? '') == $series->id ? 'selected' : '' }}
                                value="{{ $series->id }}">{{ $series->name }}</option>
                        @endforeach
                    </select>
                    <div class="form-control-feedback d-none text-danger mt-1" id="error-exam_series"></div>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label class="form-label" for="category">Category</label>
                    <select name="category" id="category" class="custom-select" onchange="getSubCategory(this)"
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
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label class="form-label" for="subcategory">SubCategory</label>
                    <select name="subcategory" onchange="getReSubCategory(this)" id="subcategory"
                            class="custom-select"
                            required>
                        <option selected disabled>Select...</option>
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
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label class="form-label" for="resubcategory">ReSubCategory</label>
                    <select name="resubcategory" id="resubcategory" class="custom-select">
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
                    <label class="form-label" for="is_paid">Payment Status</label>
                    <select name="is_paid" id="is_paid" class="custom-select">
                        <option {{ old('is_paid', $past_paper->is_paid ?? 0) == 1 ? 'selected' : '' }} value="1">
                            Paid
                        </option>
                        <option {{ old('is_paid', $past_paper->is_paid ?? 0) == 0 ? 'selected' : '' }} value="0">
                            Free
                        </option>
                    </select>
                    <div class="form-control-feedback d-none text-danger mt-1" id="error-is_paid"></div>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label class="form-label" for="is_active">Status </label>
                    <select name="is_active" id="is_active" class="custom-select">
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
            <div class="col-lg-12 col-12">
                <div class="upload-group full" data-uploader="">
                    <label>Question Paper (PDF File)</label>
                    <div class="file-line">
                        <label class="file-trigger">
                            <span>Choose File</span>
                            <input class="hidden-input"
                                   name="ques_paper"
                                   type="file" accept=".pdf,application/pdf" data-input="">
                        </label>
                        <div class="file-name" data-name="">No file chosen</div>
                        <button class="action-btn preview-btn" type="button" data-preview="" disabled="">Preview
                        </button>
                        <button class="action-btn delete-btn" type="button" data-delete="" disabled="">Delete</button>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" data-fill="">0%</div>
                    </div>
                    <div class="progress-info">
                        <span>Total: <strong data-total="">0 B</strong></span>
                        <span>Uploaded: <strong data-uploaded="">0 B</strong></span>
                        <span>Remaining: <strong data-remaining="">0 B</strong></span>
                        <span>Progress: <strong data-percent="">0%</strong></span>
                        <span>Time left: <strong data-time="">--</strong></span>
                    </div>
                    <div class="form-control-feedback d-none text-danger mt-1" id="error-ques_paper"></div>
                    <div class="upload-status" data-status=""></div>
                </div>
            </div>
            <div class="col-lg-12 col-12">
                <div class="upload-group full" data-uploader="">
                    <label>Answer Paper (PDF File)</label>
                    <div class="file-line">
                        <label class="file-trigger">
                            <span>Choose File</span>
                            <input class="hidden-input" type="file"
                                   name="ans_paper"
                                   accept=".pdf,application/pdf" data-input="">
                        </label>
                        <div class="file-name" data-name="">No file chosen</div>
                        <button class="action-btn preview-btn" type="button" data-preview="" disabled="">Preview
                        </button>
                        <button class="action-btn delete-btn" type="button" data-delete="" disabled="">Delete</button>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" data-fill="">0%</div>
                    </div>
                    <div class="progress-info">
                        <span>Total: <strong data-total="">0 B</strong></span>
                        <span>Uploaded: <strong data-uploaded="">0 B</strong></span>
                        <span>Remaining: <strong data-remaining="">0 B</strong></span>
                        <span>Progress: <strong data-percent="">0%</strong></span>
                        <span>Time left: <strong data-time="">--</strong></span>
                    </div>
                    <div class="form-control-feedback d-none text-danger mt-1" id="error-ans_paper"></div>
                    <div class="upload-status" data-status=""></div>
                </div>
            </div>
            <div class="col-lg-12 col-12">
                <div class="solution-row full mb-3">
                    <div class="solution-title">Have Solutions? (PDF File)</div>
                    <div class="custom-radio-options">
                        <label class="custom-radio-item">
                            <input type="radio"
                                   {{ old('have_solution', $past_paper->have_solution ?? 0) == 1 ? 'checked' : '' }}
                                   name="have_solution" id="radio_7" value="yes">
                            <span class="radio-btn"></span>
                            <span>Yes</span>
                        </label>
                        <label class="custom-radio-item">
                            <input type="radio"
                                   {{ old('have_solution', $past_paper->have_solution ?? 0) == 0 ? 'checked' : '' }}
                                   name="have_solution" id="radio_9" value="no">
                            <span class="radio-btn"></span>
                            <span>No</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-12 solutions-field" style="display: block;">
                <div class="solution-row full">
                    <div class="solution-title">Preferred Solution Type?</div>
                    <div class="custom-checkbox-options">
                        <label class="custom-checkbox-item">
                            <input
                                {{ old('have_video_solution', $past_paper->have_video_solution ?? '') == 1 ? 'checked' : '' }}
                                type="checkbox" name="have_video_solution" id="video_solution_id" value="1">
                            <span class="checkbox-btn"></span>
                            <span class="checkbox-text">Video Solution</span>
                        </label>
                        <label class="custom-checkbox-item">
                            <input
                                {{ old('have_pdf_solution', $past_paper->have_pdf_solution ?? '') == 1 ? 'checked' : '' }}
                                type="checkbox" name="have_pdf_solution" id="pdf_solution_id" value="1">
                            <span class="checkbox-btn"></span>
                            <span class="checkbox-text">PDF Solutions</span>
                        </label>
                    </div>
                </div>
                <div class="solution-row full {{ old('have_video_solution', $past_paper->have_video_solution ?? '') == 1 ? '' : 'd-none' }}"
                     id="video_section">
                    <div class="custom-divider">
                        <div class="solution-title">Video Solution Section</div>
                        <div class="custom-radio-options">
                            <label class="custom-radio-item">
                                <input type="radio"
                                       {{ old('video_procedure', $past_paper->video_procedure ?? '') == 1 ? 'checked' : '' }}
                                       name="video_procedure" id="video_link_id" value="1">
                                <span class="radio-btn"></span>
                                <span>Store video link</span>
                            </label>
                            <label class="custom-radio-item">
                                <input type="radio"
                                       {{ old('video_procedure', $past_paper->video_procedure ?? '') == 0 ? 'checked' : '' }}
                                       name="video_procedure" id="video_uploads_id" value="1">
                                <span class="radio-btn"></span>
                                <span>Upload direct Video</span>
                            </label>
                            <div class="form-control-feedback d-none text-danger mt-1" id="error-video_procedure"></div>
                        </div>
                        <div class="form-group"
                             style="display: {{ isset($past_paper) && $past_paper->video_procedure == 1 ? 'block' : 'none' }}"
                             id="video_link_section">
                            <label class="form-label" for="status"><strong>Video Links</strong></label>
                            <input type="text" class="custom-input" name="video_links"
                                   placeholder="Please enter valid link">
                            <div class="form-control-feedback d-none text-danger mt-1" id="error-video_links"></div>

                        </div>
                        <div class="form-group"
                             style="display: {{ isset($past_paper) && $past_paper->video_procedure == 0 ? 'block' : 'none' }}"
                             id="video_uploads_section">
                            <div class="upload-group full" data-uploader="">
                                <label>Video Solution File Upload</label>
                                <div class="file-line">
                                    <label class="file-trigger">
                                        <span>Choose File</span>
                                        <input class="hidden-input" type="file" accept=".pdf,application/pdf" data-input="">
                                    </label>
                                    <div class="file-name" data-name="">No file chosen</div>
                                </div>
                            </div>
                            <div class="form-control-feedback d-none text-danger mt-1" id="error-video_procedure"></div>
                        </div>
                    </div>
                </div>
                <div class="solution-row full {{ old('have_pdf_solution', $past_paper->have_pdf_solution ?? '') == 1 ? '' : 'd-none' }}"
                     id="pdf-section">
                    <div class="custom-divider">
                        <div class="solution-title">Upload PDF File</div>
                        <div class="form-group"
                             style="display: {{ isset($past_paper) && $past_paper->have_pdf_solution == 1 ? 'block' : 'none' }}"
                             id="pdf_solution_section">
                            <input type="file" class="form-control" name="pdf_solution" accept=".pdf">
                        </div>
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
