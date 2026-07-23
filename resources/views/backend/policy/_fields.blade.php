<div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="form-group">
                    <label class="form-label" for="title">Title</label>
                    <input name="title"
                           type="text"
                           placeholder="Place you title"
                           id="title"
                           value="{{ old('title', $policy->title ?? '') }}"
                           class="form-control"/>
                    @error('title')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-12 col-12">
                <div class="form-group">
                    <label class="form-label" for="editor1">Content</label>
                    <textarea
                        placeholder="Type the content here!"
                        class="form-control" name="description" rows="5"
                        cols="80">{!! old('value', $policy->description ?? '') !!}</textarea>
                    @error('description')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-8 col-12">
                <div class="form-group">
                    <label class="form-label" for="policy">Policy</label>
                    <select name="policy"
                            id="policy"
                            class="form-select">
                        <option value="">Select...</option>
                        @if(!empty($policies))
                            @foreach($policies as $p)
                                <option
                                    {{ old('policy', $policy->policy->value ?? "") === $p->value ? 'selected' : '' }}
                                    value="{{ $p->value }}">
                                    {{ $p->label()  }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('policy')
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
                                    {{ old('status', $policy->status->value ?? "1") === $status->value ? 'selected' : '' }}
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
        <a href="{{ route('admin.policies.index') }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-success pull-right">Submit</button>
    </div>
</div>
