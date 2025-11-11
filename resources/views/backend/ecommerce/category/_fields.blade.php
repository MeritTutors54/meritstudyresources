<div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-8 col-12">
                <div class="form-group">
                    <label for="name"
                           class="form-label">Book Category Name</label>
                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name', $book_category->name ?? "") }}"
                           class="form-control"
                           placeholder="Enter book category name">
                    @error('name')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="form-group">
                    <label class="form-label" for="status">Status</label>
                    <select name="status"
                            id="status"
                            class="form-select">
                        <option value="">Select...</option>
                        @if(!empty($statuses))
                            @foreach($statuses as $status)
                                <option
                                    {{ old('status', isset($book_category) ? (string)$book_category->status : "1") === (string)$status->value ? 'selected' : '' }}
                                    value="{{ $status->value }}">
                                    {{ ucfirst(strtolower($status->name))  }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('status')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-12 col-12">
                <div class="form-group">
                    <label for="description"
                           class="form-label">Book Category Description</label>
                    <textarea
                        name="description"
                        id="description"
                        class="form-control"
                        placeholder="Enter book category description"
                        rows="4">{{ old('description', $book_category->description ?? "") }}</textarea>
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
        <a href="{{ route('admin.book-categories.index') }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-success pull-right">Submit</button>
    </div>
</div>
