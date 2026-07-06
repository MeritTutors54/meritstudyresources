<div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <input type="hidden" name="uploads_type" value="Past Paper">
                    <label for="name" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control"
                        value="{{ old('title', $past_paper->title ?? '') }}" placeholder="Enter title">
                    @error('title')
                        <div class="form-control-feedback text-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label class="form-label" for="exam_series">Series</label>
                    <select name="exam_series" id="exam_series" class="form-select" required>
                        <option selected disabled>Select...</option>
                        @foreach ($examSeries as $series)
                            <option
                                {{ old('exam_series', $past_paper->exam_series ?? '') == $series->id ? 'selected' : '' }}
                                value="{{ $series->id }}">{{ $series->name }}</option>
                        @endforeach
                    </select>
                    @error('exam_series')
                        <div class="form-control-feedback text-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label class="form-label" for="category">Category</label>
                    <select name="category" id="category" class="form-select" onchange="getSubCategory(this)" required>
                        <option selected disabled>Select...</option>
                        @foreach ($categories as $category)
                            <option
                                {{ old('category', $past_paper->category ?? '') == $category->id ? 'selected' : '' }}
                                value="{{ $category->id }}">
                                {{ $category->category_name }}</option>
                        @endforeach

                    </select>
                    @error('category')
                        <div class="form-control-feedback text-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label class="form-label" for="subcategory">SubCategory</label>
                    <select name="subcategory" onchange="getReSubCategory(this)" id="subcategory" class="form-select"
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
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label class="form-label" for="resubcategory">ReSubCategory</label>
                    <select name="resubcategory" id="resubcategory" class="form-select">
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
                    @error('resubcategory')
                        <div class="form-control-feedback text-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label class="form-label" for="is_paid">Payment Status</label>
                    <select name="is_paid" id="is_paid" class="form-select">
                        <option {{ old('is_paid', $past_paper->is_paid ?? 0) == 1 ? 'selected' : '' }} value="1">
                            Paid
                        </option>
                        <option {{ old('is_paid', $past_paper->is_paid ?? 0) == 0 ? 'selected' : '' }} value="0">
                            Free
                        </option>
                    </select>
                    @error('is_paid')
                        <div class="form-control-feedback text-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label class="form-label" for="is_active">Status </label>
                    <select name="is_active" id="is_active" class="form-select">
                        <option {{ old('is_active', $past_paper->is_active ?? 1) == 1 ? 'selected' : '' }}
                            value="1">Active
                        </option>
                        <option {{ old('is_active', $past_paper->is_active ?? 1) == 0 ? 'selected' : '' }}
                            value="0">Inactive
                        </option>
                    </select>
                    @error('is_active')
                        <div class="form-control-feedback text-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-12 col-12">
                <div class="form-group">
                    <label class="form-label" for="ques_paper">Question Paper (PDF
                        File)</label>
                    <input type="file" name="ques_paper" accept=".pdf" class="form-control file-input">

                    <div class="form-control-feedback text-danger mt-1 size-error" style="display: none;"></div>

                    @error('ques_paper')
                        <div class="form-control-feedback text-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="progress mt-2" style="display: none; height: 10px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 0%;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-12">
                <div class="form-group">
                    <label class="form-label" for="ans_paper">Mark Scheme (PDF File)</label>
                    <input type="file" name="ans_paper" accept=".pdf" class="form-control file-input">

                    <div class="form-control-feedback text-danger mt-1 size-error" style="display: none;"></div>

                    @error('ans_paper')
                        <div class="form-control-feedback text-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="progress mt-2" style="display: none; height: 10px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 0%;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-12">
                <div class="form-group">
                    <label class="form-label" for="status">Have Solutions? (PDF File)</label>
                    <div class="demo-radio-button">
                        <input {{ old('have_solution', $past_paper->have_solution ?? 0) == 1 ? 'checked' : '' }}
                            name="have_solution" type="radio" id="radio_7" class="radio-col-success"
                            value="1">
                        <label for="radio_7">Yes</label>
                        <input {{ old('have_solution', $past_paper->have_solution ?? 0) == 0 ? 'checked' : '' }}
                            name="have_solution" type="radio" id="radio_9" class="radio-col-warning"
                            value="0">
                        <label for="radio_9">No</label>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-12 solutions-field" style="display: block;">
                <div class="form-group">
                    <div class="box-body">
                        <div class="demo-checkbox">
                            <input
                                {{ old('have_video_solution', $past_paper->have_video_solution ?? '') == 1 ? 'checked' : '' }}
                                type="checkbox" name="have_video_solution" id="video_solution_id"
                                class="chk-col-primary" value="1">
                            <label for="video_solution_id">Video Solution</label>
                            <input
                                {{ old('have_video_solution', $past_paper->have_pdf_solution ?? '') == 1 ? 'checked' : '' }}
                                type="checkbox" name="have_pdf_solution" id="pdf_solution_id"
                                class="chk-col-success" value="1">
                            <label for="pdf_solution_id">PDF Solutions</label>
                        </div>
                    </div>
                </div>
                @error('ans_paper')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                @enderror
                <div class="form-group"
                    style="display: {{ isset($past_paper) && $past_paper->have_video_solution == 1 ? 'block' : 'none' }}"
                    id="video_section">
                    <div class="box-body">
                        <div class="demo-checkbox">
                            <input
                                {{ old('video_procedure', $past_paper->video_procedure ?? '') == 1 ? 'checked' : '' }}
                                type="radio" name="video_procedure" id="video_link_id" class="chk-col-primary"
                                value="1">
                            <label for="video_link_id">Video Link</label>
                            <input
                                {{ old('video_procedure', $past_paper->video_procedure ?? '') == 0 ? 'checked' : '' }}
                                type="radio" name="video_procedure" id="video_uploads_id" class="chk-col-success"
                                value="0" onchange="videoUploads(this)">
                            <label for="video_uploads_id">Upload Video</label>
                        </div>
                    </div>
                </div>
                <div class="form-group"
                    style="display: {{ isset($past_paper) && $past_paper->video_procedure == 1 ? 'block' : 'none' }}"
                    id="video_link_section">
                    <label class="form-label" for="status">Video Links</label>
                    <input type="text" class="form-control" name="video_links"
                        placeholder="Please enter valid link">
                </div>
                <div class="form-group"
                    style="display: {{ isset($past_paper) && $past_paper->video_procedure == 0 ? 'block' : 'none' }}"
                    id="video_uploads_section">
                    <label class="form-label" for="status">Video Solutions(Video Only)</label>
                    <input type="file" class="form-control" name="video_solution" accept="video/*">
                </div>
                <div class="form-group"
                    style="display: {{ isset($past_paper) && $past_paper->have_pdf_solution == 1 ? 'block' : 'none' }}"
                    id="pdf_solution_section">
                    <label class="form-label" for="status">Solutions(PDF Only)</label>
                    <input type="file" class="form-control" name="pdf_solution" accept=".pdf">
                </div>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <a href="{{ route('admin.past-papers.index') }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-success pull-right">Submit</button>
    </div>
</div>
