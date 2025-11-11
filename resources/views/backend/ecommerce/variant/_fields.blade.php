<div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="form-group">
                    <label for="name"
                           class="form-label">Book Variant Name</label>
                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name', $book_variant->name ?? "") }}"
                           class="form-control"
                           placeholder="Enter book variant name">
                    @error('name')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-5 col-12">
                <div class="form-group">
                    <label class="form-label" for="book_category_id">Book Category</label>
                    <select name="book_category_id"
                            id="book_category_id"
                            class="form-select">
                        <option value="">Select...</option>
                        @if(!empty($bookCategories))
                            @foreach($bookCategories as $bookCategory)
                                <option
                                    {{ old('book_category_id', isset($book_variant) ? (string)$book_variant->book_category_id : "") === (string)$bookCategory->id ? 'selected' : '' }}
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
            <div class="col-lg-5 col-12">
                <div class="form-group">
                    <label class="form-label" for="book_subject_id">Book Subject</label>
                    <select name="book_subject_id"
                            id="book_subject_id"
                            class="form-select">
                        <option value="">Select...</option>
                        @if(!empty($bookSubjects))
                            @foreach($bookSubjects as $subject)
                                <option
                                    {{ old('book_subject', isset($book_variant) ? (string)$book_variant->book_subject_id : "") === (string)$subject->id ? 'selected' : '' }}
                                    value="{{ $subject->id }}">
                                    {{ ucfirst(strtolower($subject->name))  }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('book_subject')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-2 col-12">
                <div class="form-group">
                    <label class="form-label" for="status">Status</label>
                    <select name="status"
                            id="status"
                            class="form-select">
                        <option value="">Select...</option>
                        @if(!empty($statuses))
                            @foreach($statuses as $status)
                                <option
                                    {{ old('status', isset($book_variant) ? (string)$book_variant->status : "1") === (string)$status->value ? 'selected' : '' }}
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
                           class="form-label">Book Variant Description</label>
                    <textarea
                        name="description"
                        id="description"
                        class="form-control"
                        placeholder="Enter book variant description"
                        rows="4">{{ old('description', $book_variant->description ?? "") }}</textarea>
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
        <a href="{{ route('admin.book-variants.index') }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-success pull-right">Submit</button>
    </div>
</div>
