<div class="box-body">
    <div class="row">
        <!-- Product Title & SKU -->
        <div class="col-lg-8 col-12">
            <div class="form-group mb-20">
                <label for="title" class="form-label fw-500">Product Name <span class="text-danger">*</span></label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    value="{{ old('title', $product->title ?? '') }}"
                    class="form-control @error('title') is-invalid @enderror"
                    placeholder="Enter product title">
                @error('title')
                <div class="form-control-feedback text-danger fs-12 mt-1">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>

        <div class="col-lg-4 col-12">
            <div class="form-group mb-20">
                <label for="sku" class="form-label fw-500">Product SKU <span class="text-danger">*</span></label>
                <input
                    type="text"
                    name="sku"
                    id="sku"
                    value="{{ old('sku', $product->sku ?? '') }}"
                    class="form-control @error('sku') is-invalid @enderror"
                    placeholder="e.g. SKU-1002">
                @error('sku')
                <div class="form-control-feedback text-danger fs-12 mt-1">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>

        <!-- Categorization: Book Variant & Year Group -->
        <div class="col-lg-6 col-12">
            <div class="form-group mb-20">
                <label class="form-label fw-500" for="book_variant_id">Book Variant</label>
                <select name="book_variant_id" id="book_variant_id" class="form-select @error('book_variant_id') is-invalid @enderror">
                    <option value="">Select Variant...</option>
                    @if(!empty($bookVariants))
                        @foreach($bookVariants as $variant)
                            <option
                                value="{{ $variant->id }}"
                                {{ old('book_variant_id', isset($product) ? (string)$product->book_variant_id : '') === (string)$variant->id ? 'selected' : '' }}>
                                {{ ucfirst($variant->name) }} &mdash; {{ ucfirst($variant->bookSubject->name ?? '') }} ({{ ucfirst($variant->bookCategory->name ?? '') }})
                            </option>
                        @endforeach
                    @endif
                </select>
                @error('book_variant_id')
                <div class="form-control-feedback text-danger fs-12 mt-1">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>

        <div class="col-lg-6 col-12">
            <div class="form-group mb-20">
                <label class="form-label fw-500" for="year_group_id">Year Group</label>
                <select name="year_group_id" id="year_group_id" class="form-select @error('year_group_id') is-invalid @enderror">
                    <option value="">Select Year Group...</option>
                    @if(!empty($yearGroups))
                        @foreach($yearGroups as $group)
                            <option
                                value="{{ $group->id }}"
                                {{ old('year_group_id', isset($product) ? (string)$product->year_group_id : "") === (string)$group->id ? 'selected' : '' }}>
                                {{ ucfirst($group->year_name) }}
                            </option>
                        @endforeach
                    @endif
                </select>
                @error('year_group_id')
                <div class="form-control-feedback text-danger fs-12 mt-1">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>

        <!-- Pricing Fields with Currency Input Addon -->
        <div class="col-lg-6 col-12">
            <div class="form-group mb-20">
                <label for="regular_price" class="form-label fw-500">Regular Price</label>
                <div class="input-group">
                    <span class="input-group-text">£</span>
                    <input
                        type="text"
                        name="regular_price"
                        id="regular_price"
                        class="form-control @error('regular_price') is-invalid @enderror"
                        value="{{ old('regular_price', $product->mirror_price ?? '') }}"
                        placeholder="0.00">
                </div>
                @error('regular_price')
                <div class="form-control-feedback text-danger fs-12 mt-1">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>

        <div class="col-lg-6 col-12">
            <div class="form-group mb-20">
                <label for="discount_price" class="form-label fw-500">Discount Price</label>
                <div class="input-group">
                    <span class="input-group-text">£</span>
                    <input
                        type="text"
                        name="discount_price"
                        id="discount_price"
                        class="form-control @error('discount_price') is-invalid @enderror"
                        value="{{ old('discount_price', $product->mirror_discount ?? '') }}"
                        placeholder="0.00">
                </div>
                @error('discount_price')
                <div class="form-control-feedback text-danger fs-12 mt-1">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>

        <!-- File Upload & Status -->
        <div class="col-lg-8 col-12">
            <div class="form-group mb-20">
                <label for="file" class="form-label fw-500">Product Image</label>
                <input
                    id="file"
                    name="file"
                    type="file"
                    class="form-control @error('file') is-invalid @enderror"
                    accept="image/*">
                @error('file')
                <div class="form-control-feedback text-danger fs-12 mt-1">
                    {{ $message }}
                </div>
                @enderror

                @if(!empty($product->image))
                    <div class="d-flex align-items-center mt-10 p-10 bg-light rounded10 border">
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->title ?? 'Product Image' }}"
                             class="rounded5 me-15 border"
                             style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <span class="badge badge-success-light mb-5">Uploaded File</span>
                            <p class="text-muted mb-0 fs-12">Current image will remain if no new file is selected.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-4 col-12">
            <div class="form-group mb-20">
                <label class="form-label fw-500" for="status">Status</label>
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                    <option value="">Select Status...</option>
                    @if(!empty($statuses))
                        @foreach($statuses as $status)
                            <option
                                value="{{ $status->value }}"
                                {{ old('status', isset($product) ? (string)$product->status : '1') === (string)$status->value ? 'selected' : '' }}>
                                {{ ucfirst(strtolower($status->name)) }}
                            </option>
                        @endforeach
                    @endif
                </select>
                @error('status')
                <div class="form-control-feedback text-danger fs-12 mt-1">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>

        <!-- Description -->
        <div class="col-12">
            <div class="form-group mb-10">
                <label for="description" class="form-label fw-500">Product Description</label>
                <textarea
                    name="description"
                    id="description"
                    class="form-control @error('description') is-invalid @enderror"
                    placeholder="Enter complete product description..."
                    rows="5">{{ old('description', $product->description ?? '') }}</textarea>
                @error('description')
                <div class="form-control-feedback text-danger fs-12 mt-1">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
    </div>
</div>

<!-- Form Actions -->
<div class="box-footer d-flex justify-content-between align-items-center">
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary waves-effect">
        <i class="fa fa-arrow-left me-1"></i> Back to List
    </a>
    <button type="submit" class="btn btn-success waves-effect waves-light">
        <i class="fa fa-check me-1"></i> Save Product
    </button>
</div>
