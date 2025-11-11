<div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label class="form-label" for="name">Subject Name</label>
                    <input type="text" class="form-control"
                           placeholder="Type educational level name"
                           value="{{ old('name', $subject->name ?? "") }}"
                           name="name" id="name">
                    @error('name')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label class="form-label" for="education_level_id">Education Level</label>
                    <select name="education_level_id"
                            id="education_level_id"
                            class="form-select">
                        <option value="">Select...</option>
                        @if(!empty($educationLevels))
                            @foreach($educationLevels as $level)
                                <option
                                    {{ old('education_level_id', isset($subject) ? (string)$subject->education_level_id : "1") === (string)$level->id ? 'selected' : '' }}
                                    value="{{ $level->id }}">
                                    {{ ucfirst(strtolower($level->name))  }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('education_level_id')
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
                              rows="4">{{ old('description', $subject->description ?? '') }}</textarea>
                    @error('description')
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
                                    {{ old('status', isset($subject) ? (string)$subject->status : "1") === (string)$status->value ? 'selected' : '' }}
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
        <a href="{{ route('admin.subjects.index') }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-success pull-right">Submit</button>
    </div>
</div>
