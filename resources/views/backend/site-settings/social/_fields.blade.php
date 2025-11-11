<div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-4 col-12">
                <div class="form-group">
                    <label class="form-label" for="type">Link Type</label>
                    <select name="type"
                            id="type"
                            class="form-select">
                        <option value="">Select...</option>
                        @if(!empty($socials))
                            @foreach($socials as $item)
                                <option
                                    {{ old('type', isset($social) ? $social->type : "") == $item->name ? 'selected' : '' }}
                                    value="{{ $item->value }}">
                                    {{ $item->name }}
                                </option>
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
                    <label for="url"
                           class="form-label">URL</label>
                    <input name="url"
                           id="url"
                           value="{{ old('url', $social->url ?? "") }}"
                           class="form-control"
                           placeholder="Enter links Url"
                    >
                    @error('url')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-lg-8 col-12">
                <div class="form-group">
                    <label for="icon"
                           class="form-label">Icon</label>
                    <input name="icon"
                           id="icon"
                           value="{{ old('icon', $social->icon ?? "") }}"
                           class="form-control"
                           placeholder="Enter icon of your choice"
                    >
                    @error('icon')
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
                                    {{ old('status', isset($social) ? (string)$social->status : "1") === (string)$status->value ? 'selected' : '' }}
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
        <a href="{{ route('admin.socials.index') }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-success pull-right">Submit</button>
    </div>
</div>
