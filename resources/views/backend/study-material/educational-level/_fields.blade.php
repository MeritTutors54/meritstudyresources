<div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-8 col-12">
                <div class="form-group">
                    <label class="form-label" for="name">Educational Level Name</label>
                    <input type="text" class="form-control"
                           placeholder="Type educational level name"
                           value="{{ old('name', $educational_level->name ?? "") }}"
                           name="name" id="name">
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
                                    {{ old('status', isset($educational_level) ? (string)$educational_level->status : "1") === (string)$status->value ? 'selected' : '' }}
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
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control"
                              name="description"
                              placeholder="Type description"
                              id="description"
                              rows="4">{{ old('description', $educational_level->description ?? '') }}</textarea>
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
        <a href="{{ route('admin.educational-levels.index') }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-success pull-right">Submit</button>
    </div>
</div>
