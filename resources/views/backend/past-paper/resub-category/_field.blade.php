<div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label for="resubcategory_name"
                           class="form-label">Resub Category Name</label>
                    <input type="text"
                           name="resubcategory_name"
                           id="resubcategory_name"
                           class="form-control"
                           value="{{ old('resubcategory_name', $resub_category->resubcategory_name ?? '') }}"
                           placeholder="Enter Subcategory name" required>
                    @error('resubcategory_name')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label for="unit_code"
                           class="form-label">Unit Code</label>
                    <input type="text"
                           name="unit_code"
                           id="unit_code"
                           value="{{ old('unit_code', $resub_category->unit_code ?? '') }}"
                           class="form-control"
                           placeholder="Enter Unit Code" required>
                    @error('unit_code')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label class="form-label" for="category_id">Category</label>
                    <select name="category_id" class="form-select" required id="category_id"
                            onchange="getSubCategory(this)">
                        <option selected disabled>Select...</option>
                        @foreach ($allCategories as $category)
                            <option
                                 {{ old('category_id', $resub_category->category_id ?? '') == $category->id ? 'selected' : '' }}
                                 value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label class="form-label" for="subcategory_id">SubCategory</label>
                    <select name="subcategory_id"
                            id="subcategory_id"
                            class="form-select" required>
                        <option selected disabled>Select...</option>
                        @if(!empty($resub_category))
                            @foreach($subCategories as $subcategory)
                                <option {{ old('subcategory_id', $resub_category->subcategory_id ?? '') == $subcategory->id ? 'selected' : '' }}
                                    value="{{ $subcategory->id }}">{{ $subcategory->subcategory_name }}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('subcategory_id')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label class="form-label" for="is_active">Status</label>
                    <select name="is_active"
                            id="status"
                            class="form-select">
                        <option {{ old('is_active', $resub_category->is_active ?? '') == 1 ? 'selected' : '' }}
                            value="1">Active</option>
                        <option {{ old('is_active', $resub_category->is_active ?? '') == 0 ? 'selected' : '' }}
                            value="0">Inactive</option>
                    </select>
                    @error('is_active')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label class="form-label" for="past_papers">Past Paper</label>
                    <select name="past_papers"
                            id="past_papers"
                            class="form-select">
                        <option {{ old('past_papers', $resub_category->past_papers ?? '') == 1 ? 'selected' : '' }}
                                value="1" selected>Active</option>
                        <option {{ old('past_papers', $resub_category->past_papers ?? '') == 0 ? 'selected' : '' }}
                            value="0">Inactive</option>
                    </select>
                    @error('past_papers')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label class="form-label" for="revision_notes">Revision Notes</label>
                    <select name="revision_notes"
                            id="revision_notes"
                            class="form-select">
                        <option {{ old('revision_notes', $resub_category->revision_notes ?? '') == 1 ? 'selected' : '' }}
                                value="1">Active</option>
                        <option {{ old('revision_notes', $resub_category->revision_notes ?? '') == 0 ? 'selected' : '' }}
                                value="0" selected>Inactive</option>
                    </select>
                    @error('revision_notes')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label class="form-label" for="exam_questions">Exam Questions</label>
                    <select name="exam_questions"
                            id="exam_questions"
                            class="form-select">

                        <option {{ old('exam_questions', $resub_category->exam_questions ?? '') == 1 ? 'selected' : '' }}
                                value="1">Active</option>
                        <option {{ old('exam_questions', $resub_category->exam_questions ?? '') == 0 ? 'selected' : '' }}
                                value="0" selected>Inactive</option>
                    </select>
                    @error('exam_questions')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label class="form-label" for="flashcards">Flashcards</label>
                    <select name="flashcards"
                            id="flashcards"
                            class="form-select">

                        <option {{ old('flashcards', $resub_category->flashcards ?? '') == 1 ? 'selected' : '' }}
                                value="1">Active</option>
                        <option {{ old('flashcards', $resub_category->flashcards ?? '') == 0 ? 'selected' : '' }}
                                value="0" selected>Inactive</option>
                    </select>
                    @error('flashcards')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-lg-12 col-12">
                <div class="form-group">
                    <label class="form-label" for="description">Description</label>
                    <textarea
                        placeholder="Type the content here!"
                        id="editor1" name="description" rows="10"
                        cols="80">{!! old('description', $resub_category->description ?? '') !!}</textarea>
                    @error('description')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <a href="{{ route('admin.resub-categories.index') }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-success pull-right">Submit</button>
    </div>
</div>


