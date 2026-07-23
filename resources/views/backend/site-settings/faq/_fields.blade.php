<div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label for="question"
                           class="form-label">FAQ Question</label>
                    <textarea
                        name="question"
                        id="question"
                        class="form-control"
                        placeholder="Enter FAQ Question"
                        rows="4">{{ old('question', $faq->question ?? "") }}</textarea>
                    @error('question')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label for="answer"
                           class="form-label">FAQ Answer</label>
                    <textarea
                        name="answer"
                        id="answer"
                        class="form-control"
                        placeholder="Enter FAQ Answer"
                        rows="4">{{ old('answer', $faq->answer ?? "") }}</textarea>
                    @error('answer')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="form-group">
                    <label class="form-label" for="genre">Genre</label>
                    <select name="genre"
                            id="genre"
                            class="form-select">
                        <option value="">Select...</option>
                        @if(!empty($genres))
                            @foreach($genres as $genre)
                                <option
                                    {{ old('genre', isset($faq) ? (string)$faq->genre : "") === (string)$genre->value ? 'selected' : '' }}
                                    value="{{ $genre->value }}">
                                    {{ ucfirst(strtolower($genre->name))  }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('genre')
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
                                    {{ old('status', isset($faq) ? (string)$faq->status : "1") === (string)$status->value ? 'selected' : '' }}
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
        <a href="{{ route('admin.faqs.index') }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-success pull-right">Submit</button>
    </div>
</div>
