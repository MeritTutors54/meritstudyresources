<div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-8 col-12">
                <div class="form-group">
                    <label class="form-label" for="key">Policy</label>
                    <select name="key"
                            id="key"
                            class="form-select">
                        <option value="">Select...</option>
                        @if(!empty($policies))
                            @foreach($policies as $p)
                                <option
                                    {{ old('status', isset($policy) ? (string)$policy->key : "1") === (string)$p->value ? 'selected' : '' }}
                                    value="{{ $p->value }}">
                                    {{ ucfirst(strtolower($p->value))  }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('key')
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
                                    {{ old('status', isset($policy) ? (string)$policy->status : "1") === (string)$status->value ? 'selected' : '' }}
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
                    <label class="form-label" for="editor1">Blog Content</label>
                    <textarea
                        placeholder="Type the content here!"
                        id="editor1" name="value" rows="10"
                        cols="80">{!! old('value', $policy->value ?? '') !!}</textarea>
                    @error('value')
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
        <a href="{{ route('admin.policies.index') }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-success pull-right">Submit</button>
    </div>
</div>
