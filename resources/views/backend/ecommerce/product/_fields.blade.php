<div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-7 col-12">
                <div class="form-group">
                    <label for="name"
                           class="form-label">Product Name</label>
                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name', $product->name ?? "") }}"
                           class="form-control"
                           placeholder="Enter product name">
                    @error('name')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-lg-5 col-12">
                <div class="form-group">
                    <label class="form-label" for="book_variant_id">Book Variant</label>
                    <select name="book_variant_id"
                            id="book_variant_id"
                            class="form-select">
                        <option value="">Select...</option>
                        @if(!empty($bookVariants))
                            @foreach($bookVariants as $variant)
                                <option
                                    {{ old('book_variant_id', isset($product) ? (string)$product->book_variant_id : "1") === (string)$variant->id ? 'selected' : '' }}
                                    value="{{ $variant->id }}">
                                    {{ ucfirst($variant->name)  }} -
                                    {{ ucfirst($variant->bookSubject->name) }} -
                                    {{ ucfirst($variant->bookCategory->name) }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('book_variant_id')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-lg-12 col-12">
                <div class="form-group">
                    <label for="description"
                           class="form-label">Product Description</label>
                    <textarea
                        name="description"
                        id="description"
                        class="form-control"
                        placeholder="Enter product description"
                        rows="4">{{ old('description', $product->description ?? "") }}</textarea>
                    @error('description')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label for="regular_price"
                           class="form-label">(£) Regular Price</label>
                    <input
                        type="text"
                        name="regular_price"
                        id="regular_price"
                        class="form-control"
                        value="{{ old('regular_price', $product->mirror_price ?? "") }}"
                        placeholder="Enter regular price">
                    @error('regular_price')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label for="discount_price"
                           class="form-label">(£) Discount Price</label>
                    <input
                        type="text"
                        name="discount_price"
                        id="discount_price"
                        class="form-control"
                        value="{{ old('discount_price', $product->mirror_discount ?? "") }}"
                        placeholder="Enter discount price">
                    @error('discount_price')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-lg-8 col-12">
                <div class="form-group">
                    <label for="file" class="form-label">Product Image</label>
                    <input id="file"
                           name="file"
                           type="file"
                           class="form-control"
                           accept="image/*"
                    >
                    @error('file')
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
        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <a href="{{ route('admin.products.index') }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-success pull-right">Submit</button>
    </div>
</div>
