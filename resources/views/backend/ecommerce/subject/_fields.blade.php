<div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="form-group">
                    <label for="name"
                           class="form-label">Book Subject Name</label>
                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name', $book_subject->name ?? "") }}"
                           class="form-control"
                           placeholder="Enter book subject name">
                    @error('name')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-8 col-12">
                <div class="form-group">
                    <label class="form-label" for="book_category_id">Book Category</label>
                    <select name="book_category_id"
                            id="book_category_id"
                            class="form-select">
                        <option value="">Select...</option>
                        @if(!empty($bookCategories))
                            @foreach($bookCategories as $bookCategory)
                                <option
                                    {{ old('book_category_id', isset($book_subject) ? (string)$book_subject->book_category_id : "") === (string)$bookCategory->id ? 'selected' : '' }}
                                    value="{{ $bookCategory->id }}">
                                    {{ ucfirst(strtolower($bookCategory->name))  }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('book_category_id')
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
                                    {{ old('status', isset($book_subject) ? (string)$book_subject->status : "1") === (string)$status->value ? 'selected' : '' }}
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
                           class="form-label">Book Subject Description</label>
                    <textarea
                        name="description"
                        id="description"
                        class="form-control"
                        placeholder="Enter book category description"
                        rows="4">{{ old('description', $book_subject->description ?? "") }}</textarea>
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
        <a href="{{ route('admin.book-subjects.index') }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-success pull-right">Submit</button>
    </div>
</div>
