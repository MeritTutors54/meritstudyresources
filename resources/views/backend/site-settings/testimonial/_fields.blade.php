<div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-8 col-12">
                <div class="form-group">
                    <label for="name"
                           class="form-label">Name of user</label>
                    <input
                        value="{{ old('name', $testimonial->name ?? "") }}"
                        name="name"
                        id="name"
                        class="form-control"
                        placeholder="Enter name of user">
                    @error('name')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="form-group">
                    <label class="form-label" for="type">Type</label>
                    <select name="type"
                            id="type"
                            class="form-select">
                        <option value="">Select...</option>
                        @if(!empty($types))
                            @foreach($types as $type)
                                @if($type->value != 0)
                                    <option
                                        {{ old('status', isset($testimonial) ? (string)$testimonial->type : "") === (string)$type->value ? 'selected' : '' }}
                                        value="{{ $type->value }}">
                                        {{ ucfirst(strtolower($type->name))  }}
                                    </option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                    @error('type')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-8 col-12">
                <div class="form-group">
                    <label for="description"
                           class="form-label">Description</label>
                    <textarea
                        name="description"
                        id="description"
                        class="form-control"
                        placeholder="Enter description"
                        rows="4">{{ old('description', $testimonial->description ?? "") }}</textarea>
                    @error('description')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="form-group">
                    <label class="form-label" for="rating">Rating</label>
                    <select name="rating"
                            id="rating"
                            class="form-select">
                        <option value="">Select...</option>
                        @if(!empty($ratings))
                            @foreach($ratings as $rate)
                                <option
                                    {{ old('rating', isset($testimonial) ? (string)$testimonial->rating : "0") === (string)$rate->value ? 'selected' : '' }}
                                    value="{{ $rate->value }}">
                                    {{ ucfirst(strtolower($rate->name)) . ' Star'  }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('rating')
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
        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-success pull-right">Submit</button>
    </div>
</div>
