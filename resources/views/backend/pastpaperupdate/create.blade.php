@php
    $hasSolution   = old('have_solution', $past_paper->have_solution ?? 0);
    $hasSolution   = in_array($hasSolution, [1, '1', 'yes'], true);
    $hasVideo      = old('have_video_solution', $past_paper->have_video_solution ?? 0) == 1;
    $hasPdf        = old('have_pdf_solution', $past_paper->have_pdf_solution ?? 0) == 1;
    $videoProc     = old('video_procedure', $past_paper->video_procedure ?? 1); // 1 = link, 0 = upload
@endphp

<div class="pp-body">
    <input type="hidden" name="uploads_type" value="Past Paper">

    {{-- ===== Basic Info ===== --}}
    <div class="pp-section">
        <div class="pp-section-title"><i class="mdi mdi-information-outline"></i> Basic Information</div>
        <div class="row g-3">
            <div class="col-lg-6 col-12">
                <label for="title" class="pp-label">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" id="title"
                       class="pp-input @error('title') is-invalid @enderror"
                       value="{{ old('title', $past_paper->title ?? '') }}" placeholder="Enter title">
                @error('title') <div class="pp-error">{{ $message }}</div> @enderror
            </div>

            <div class="col-lg-6 col-12">
                <label for="exam_series" class="pp-label">Series <span class="text-danger">*</span></label>
                <select name="exam_series" id="exam_series" class="pp-input @error('exam_series') is-invalid @enderror" required>
                    <option value="" selected disabled>Select...</option>
                    @foreach ($examSeries as $series)
                        <option value="{{ $series->id }}"
                            {{ old('exam_series', $past_paper->exam_series ?? '') == $series->id ? 'selected' : '' }}>
                            {{ $series->name }}
                        </option>
                    @endforeach
                </select>
                @error('exam_series') <div class="pp-error">{{ $message }}</div> @enderror
            </div>

            <div class="col-lg-4 col-12">
                <label for="category" class="pp-label">Category <span class="text-danger">*</span></label>
                <select name="category" id="category" class="pp-input @error('category') is-invalid @enderror"
                        onchange="getSubCategory(this)" required>
                    <option value="" selected disabled>Select...</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category', $past_paper->category ?? '') == $category->id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
                @error('category') <div class="pp-error">{{ $message }}</div> @enderror
            </div>

            <div class="col-lg-4 col-12">
                <label for="subcategory" class="pp-label">SubCategory <span class="text-danger">*</span></label>
                <select name="subcategory" id="subcategory" class="pp-input @error('subcategory') is-invalid @enderror"
                        onchange="getReSubCategory(this)" required>
                    <option value="" selected disabled>Select...</option>
                    @if (!empty($old_cat))
                        @foreach ($old_cat as $sub)
                            <option value="{{ $sub->id }}" {{ old('subcategory') == $sub->id ? 'selected' : '' }}>
                                {{ $sub->subcategory_name }}
                            </option>
                        @endforeach
                    @elseif (!empty($past_paper))
                        @foreach ($subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}"
                                {{ old('subcategory', $past_paper->subcategory ?? '') == $subcategory->id ? 'selected' : '' }}>
                                {{ $subcategory->subcategory_name }}
                            </option>
                        @endforeach
                    @endif
                </select>
                @error('subcategory') <div class="pp-error">{{ $message }}</div> @enderror
            </div>

            <div class="col-lg-4 col-12">
                <label for="resubcategory" class="pp-label">ReSubCategory</label>
                <select name="resubcategory" id="resubcategory" class="pp-input @error('resubcategory') is-invalid @enderror">
                    <option value="" selected disabled>Select...</option>
                    @if (!empty($old_sub))
                        @foreach ($old_sub as $re)
                            <option value="{{ $re->id }}" {{ old('resubcategory') == $re->id ? 'selected' : '' }}>
                                {{ $re->resubcategory_name }}
                            </option>
                        @endforeach
                    @elseif (!empty($past_paper))
                        @foreach ($resubcategories as $resubcategory)
                            <option value="{{ $resubcategory->id }}"
                                {{ old('resubcategory', $past_paper->resubcategory ?? '') == $resubcategory->id ? 'selected' : '' }}>
                                {{ $resubcategory->resubcategory_name }}
                            </option>
                        @endforeach
                    @endif
                </select>
                @error('resubcategory') <div class="pp-error">{{ $message }}</div> @enderror
            </div>

            <div class="col-lg-6 col-12">
                <label for="is_paid" class="pp-label">Payment Status</label>
                <select name="is_paid" id="is_paid" class="pp-input">
                    <option value="1" {{ old('is_paid', $past_paper->is_paid ?? 0) == 1 ? 'selected' : '' }}>Paid</option>
                    <option value="0" {{ old('is_paid', $past_paper->is_paid ?? 0) == 0 ? 'selected' : '' }}>Free</option>
                </select>
            </div>

            <div class="col-lg-6 col-12">
                <label for="is_active" class="pp-label">Status</label>
                <select name="is_active" id="is_active" class="pp-input">
                    <option value="1" {{ old('is_active', $past_paper->is_active ?? 1) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('is_active', $past_paper->is_active ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>
    </div>

    {{-- ===== Files ===== --}}
    <div class="pp-section">
        <div class="pp-section-title"><i class="mdi mdi-file-pdf-box"></i> Paper Files</div>
        <div class="row g-3">
            <div class="col-lg-6 col-12">
                <label class="pp-label">Question Paper (PDF)</label>
                <label class="pp-file @error('ques_paper') is-invalid @enderror">
                    <input type="file" name="ques_paper" accept=".pdf,application/pdf" class="pp-file-input">
                    <span class="pp-file-icon"><i class="mdi mdi-cloud-upload-outline"></i></span>
                    <span class="pp-file-text">
                        <strong class="pp-file-name">Click to choose a PDF</strong>
                        <small>PDF only</small>
                    </span>
                </label>
                @error('ques_paper') <div class="pp-error">{{ $message }}</div> @enderror
            </div>

            <div class="col-lg-6 col-12">
                <label class="pp-label">Answer Paper / Mark Scheme (PDF)</label>
                <label class="pp-file @error('ans_paper') is-invalid @enderror">
                    <input type="file" name="ans_paper" accept=".pdf,application/pdf" class="pp-file-input">
                    <span class="pp-file-icon"><i class="mdi mdi-cloud-upload-outline"></i></span>
                    <span class="pp-file-text">
                        <strong class="pp-file-name">Click to choose a PDF</strong>
                        <small>PDF only</small>
                    </span>
                </label>
                @error('ans_paper') <div class="pp-error">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>

    {{-- ===== Solutions ===== --}}
    <div class="pp-section">
        <div class="pp-section-title"><i class="mdi mdi-lightbulb-on-outline"></i> Solutions</div>

        <div class="pp-label mb-2">Have Solutions?</div>
        <div class="pp-pills">
            <label class="pp-pill">
                <input type="radio" name="have_solution" id="radio_7" value="yes" {{ $hasSolution ? 'checked' : '' }}>
                <span>Yes</span>
            </label>
            <label class="pp-pill">
                <input type="radio" name="have_solution" id="radio_9" value="no" {{ !$hasSolution ? 'checked' : '' }}>
                <span>No</span>
            </label>
        </div>

        <div class="solutions-field mt-3 {{ $hasSolution ? '' : 'd-none' }}">
            <div class="pp-label mb-2">Preferred Solution Type</div>
            <div class="pp-pills">
                <label class="pp-pill">
                    <input type="checkbox" name="have_video_solution" id="video_solution_id" value="1" {{ $hasVideo ? 'checked' : '' }}>
                    <span><i class="mdi mdi-video-outline"></i> Video Solution</span>
                </label>
                <label class="pp-pill">
                    <input type="checkbox" name="have_pdf_solution" id="pdf_solution_id" value="1" {{ $hasPdf ? 'checked' : '' }}>
                    <span><i class="mdi mdi-file-pdf-box"></i> PDF Solution</span>
                </label>
            </div>

            {{-- Video --}}
            <div id="video_section" class="pp-subcard {{ $hasVideo ? '' : 'd-none' }}">
                <div class="pp-subcard-title">Video Solution</div>
                <div class="pp-pills mb-3">
                    <label class="pp-pill">
                        <input type="radio" name="video_procedure" id="video_link_id" value="1" {{ $videoProc == 1 ? 'checked' : '' }}>
                        <span>Store video link</span>
                    </label>
                    <label class="pp-pill">
                        <input type="radio" name="video_procedure" id="video_uploads_id" value="0" {{ $videoProc == 0 ? 'checked' : '' }}>
                        <span>Upload video file</span>
                    </label>
                </div>
                @error('video_procedure') <div class="pp-error mb-2">{{ $message }}</div> @enderror

                <div id="video_link_section" class="{{ $videoProc == 1 ? '' : 'd-none' }}">
                    <label class="pp-label" for="video_links">Video Link</label>
                    <input type="url" name="video_links" id="video_links"
                           class="pp-input @error('video_links') is-invalid @enderror"
                           value="{{ old('video_links', $past_paper->video_links ?? '') }}"
                           placeholder="https://youtube.com/...">
                    @error('video_links') <div class="pp-error">{{ $message }}</div> @enderror
                </div>

                <div id="video_uploads_section" class="{{ $videoProc == 0 ? '' : 'd-none' }}">
                    <label class="pp-label">Video File</label>
                    <label class="pp-file @error('video_solution') is-invalid @enderror">
                        <input type="file" name="video_solution" accept="video/*" class="pp-file-input">
                        <span class="pp-file-icon"><i class="mdi mdi-video-plus-outline"></i></span>
                        <span class="pp-file-text">
                            <strong class="pp-file-name">Click to choose a video</strong>
                            <small>MP4, MOV, WEBM</small>
                        </span>
                    </label>
                    @error('video_solution') <div class="pp-error">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- PDF --}}
            <div id="pdf-section" class="pp-subcard {{ $hasPdf ? '' : 'd-none' }}">
                <div class="pp-subcard-title">PDF Solution</div>
                <label class="pp-file @error('pdf_solution') is-invalid @enderror">
                    <input type="file" name="pdf_solution" accept=".pdf,application/pdf" class="pp-file-input">
                    <span class="pp-file-icon"><i class="mdi mdi-cloud-upload-outline"></i></span>
                    <span class="pp-file-text">
                        <strong class="pp-file-name">Click to choose a PDF</strong>
                        <small>PDF only</small>
                    </span>
                </label>
                @error('pdf_solution') <div class="pp-error">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>
</div>

<div class="pp-footer">
    <a href="{{ route('admin.past-papers.index') }}" class="btn btn-light pp-btn">Cancel</a>
    <button type="submit" class="btn btn-primary pp-btn"><i class="mdi mdi-content-save-outline"></i> {{ isset($past_paper) ? 'Update' : 'Save' }}</button>
</div>