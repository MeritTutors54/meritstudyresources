<div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-8 col-12">
                <div class="form-group">
                    <label for="code"
                           class="form-label">Coupon Code</label>
                    <input type="text"
                           name="code"
                           id="code"
                           value="{{ old('code', $coupon->code ?? "") }}"
                           class="form-control"
                           placeholder="Enter coupon code">
                    @error('code')
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
            <div class="col-lg-4 col-12">
                <div class="form-group">
                    <label class="form-label" for="discount_type">Discount Type</label>
                    <select name="discount_type"
                            id="discount_type"
                            class="form-select">
                        <option value="">Select...</option>
                        @if(!empty($discountTypes))
                            @foreach($discountTypes as $discount)
                                <option
                                    {{ old('discount_type', isset($coupon) ? (string)$coupon->discount_type : "1") === (string)$discount->value ? 'selected' : '' }}
                                    value="{{ $discount->value }}">
                                    {{ ucfirst(strtolower($discount->name))  }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('discount_type')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="form-group">
                    <label for="discount_value"
                           class="form-label">Discount Value</label>
                    <input type="text"
                           name="discount_value"
                           id="discount_value"
                           value="{{ old('discount_value', $coupon->discount_value ?? "") }}"
                           class="form-control"
                           placeholder="Enter discount value">
                    @error('discount_value')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-lg-4 col-12">
                <div class="form-group">
                    <label for="usages_limit"
                           class="form-label">Usage Limit</label>
                    <input type="text"
                           name="usages_limit"
                           id="usages_limit"
                           value="{{ old('usages_limit', $coupon->usages_limit ?? "") }}"
                           class="form-control"
                           placeholder="Enter usage limit">
                    @error('usages_limit')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label for="valid_from"
                           class="form-label">Valid From</label>
                    <input class="form-control dateY" type="date"
                           value="{{ old('valid_from', isset($coupon) && $coupon->valid_from ? $coupon->valid_from->format('Y-m-d') : '') }}"
                           placeholder="Enter date"
                           name="valid_from"
                           id="valid_from">
                    @error('valid_from')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label for="valid_to"
                           class="form-label">Valid To</label>
                    <input class="form-control dateY" type="date"
                           value="{{ old('valid_to', isset($coupon) && $coupon->valid_to ? $coupon->valid_to->format('Y-m-d') : '') }}"
                           placeholder="Enter date"
                           name="valid_to"
                           id="valid_to">
                    @error('valid_to')
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
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-success pull-right">Submit</button>
    </div>
</div>
