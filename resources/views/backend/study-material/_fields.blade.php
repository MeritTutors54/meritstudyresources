<div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="form-group">
                    <label class="form-label" for="name">Resource Name</label>
                    <input name="name"
                           value="{{ old('name', $resource->name ?? '') }}"
                           placeholder="Type resource name"
                           id="name"
                           class="form-control">
                    @error('name')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-8 col-12">
                <div class="form-group">
                    <label class="form-label" for="topic_id">Topic Title</label>
                    <select name="topic_id"
                            id="topic_id"
                            class="form-select">
                        <option value="">Select...</option>
                        @if(!empty($topics))
                            @foreach($topics as $topic)
                                <option
                                    {{ old('topic_id', isset($resource) ? (string)$resource->topic_id : "") === (string)$topic->id ? 'selected' : '' }}
                                    value="{{ $topic->id }}">
                                    {{ ucfirst(strtolower($topic->title))  }}
                                    @if ($topic->parent?->title)
                                        - {{ ucfirst(strtolower($topic->parent->title)) }}
                                    @endif
                                    - {{ $topic->subject->name }}
                                    - {{ $topic->educationLevel->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('topic_id')
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
                                    {{ old('status', isset($resource) ? (string)$resource->status : "1") === (string)$status->value ? 'selected' : '' }}
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
                    <label class="form-label" for="description">Description</label>
                    <textarea
                        class="form-control"
                        name="description"
                        id="description"
                        placeholder="Type description"
                        rows="4">{{ old('description', $resource->description ?? "") }}</textarea>
                    @error('description')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-12 col-12">
                <div class="form-group">
                    <label for="file" class="form-label">PDF File</label>
                    <input class="form-control"
                           accept="application/pdf"
                           type="file" id="file" name="file">
                    @error('file')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <div class="form-group">
                    <label class="form-label">Is Paid</label>
                    <div class="c-inputs-stacked">
                        @foreach(\App\Enums\Statement::cases() as $k => $data)
                            <input name="is_paid" type="radio"
                                   {{ $data->value === \App\Enums\Statement::YES->value ? "checked" : "" }}
                                   id="radio-{{$k+1}}" value="{{ $data->value }}">
                            <label for="radio-{{$k+1}}" class="me-30">
                                {{ ucfirst(strtolower($data->name)) }}
                            </label>
                        @endforeach
                    </div>
                    @error('is_paid')
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
        <a href="{{ route('admin.resources.index') }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-success pull-right">Submit</button>
    </div>
</div>
