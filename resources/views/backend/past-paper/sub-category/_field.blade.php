<div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label for="subcategory_name"
                           class="form-label">Sub Category Name</label>
                    <input type="text"
                           name="subcategory_name"
                           id="subcategory_name"
                           class="form-control"
                           value="{{ old('subcategory_name', $sub_category->subcategory_name ?? '') }}"
                           placeholder="Enter Subcategory name">
                    @error('subcategory_name')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label class="form-label" for="category_id">Category</label>
                    <select name="category_id"
                            id="category_id"
                            class="form-select" required>
                        <option selected disabled>Select...</option>
                        @foreach ($allCategory as $category)
                            <option {{ old('category_id', $sub_category->category_id ?? '') == $category->id ? 'selected' : '' }}
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
                    <label class="form-label" for="status">Status</label>
                    <select name="is_active"
                            id="status"
                            class="form-select">

                        <option {{ old('is_active', $sub_category->is_active ?? '') == "1" ? 'selected' : '' }}
                            value="1">Active</option>
                        <option {{ old('is_active', $sub_category->is_active ?? '') == "0" ? 'selected' : '' }}
                            value="0">Disabled</option>
                    </select>
                    @error('status')
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
        <a href="{{ route('admin.sub-categories.index') }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-success pull-right">Submit</button>
    </div>
</div>
