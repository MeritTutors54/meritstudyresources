<div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label for="title"
                           class="form-label">Topic Title</label>
                    <input type="text"
                           name="title"
                           id="title"
                           value="{{ old('title', $topic->title ?? "") }}"
                           class="form-control"
                           placeholder="Enter topic title">
                    @error('title')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label class="form-label" for="topic_group">Topic Group</label>
                    <select name="topic_group"
                            id="topic_group"
                            class="form-select js-example-basic-single">
                        <option value="">Select...</option>
                        @if(!empty($topicGroups))
                            @foreach($topicGroups as $topicGroup)
                                <option
                                    {{ old('topic_group', isset($topic) ? (string)$topic->topicGroup?->name : "") === (string)$topicGroup->name ? 'selected' : '' }}
                                    value="{{ $topicGroup->name }}">
                                    {{ ucfirst(strtolower($topicGroup->name))  }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('topic_group')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label class="form-label" for="education_level_id">Educational Level</label>
                    <select name="education_level_id"
                            id="education_level_id"
                            class="form-select">
                        <option value="">Select...</option>
                        @if(!empty($levels))
                            @foreach($levels as $level)
                                <option
                                    {{ old('education_level_id', isset($topic) ? (string)$topic->education_level_id : "") === (string)$level->id ? 'selected' : '' }}
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
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label class="form-label" for="subject_id">Subject</label>
                    <select name="subject_id"
                            id="subject_id"
                            class="form-select">
                        <option value="">Select...</option>
                        @if(isset($topic) && !empty($subjects))
                            @foreach($subjects as $subject)
                                <option
                                    {{ old('subject_id', isset($topic) ? (string)$topic->subject_id : "1") === (string)$subject->id ? 'selected' : '' }}
                                    value="{{ $subject->id }}">
                                    {{ ucfirst(strtolower($subject->name))  }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('subject_id')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-12 col-12">
                <div class="form-group">
                    <label class="form-label" for="parent_id">Parent Topic</label>
                    <select name="parent_id"
                            id="parent_id"
                            class="form-select">
                        <option value="">Select...</option>
                        @if(!empty($parentTopics))
                            @foreach($parentTopics as $parentTopic)
                                <option
                                    {{ old('parent_id', isset($topic) ? (string)$topic->parent_id : "") === (string)$parentTopic->id ? 'selected' : '' }}
                                    value="{{ $parentTopic->id }}">
                                    {{ ucfirst(strtolower($parentTopic->title)) }} -
                                    {{ ucfirst(strtolower($parentTopic->educationLevel->name)) }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('parent_id')
                    <div class="form-control-feedback text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-12 col-12">
                <div class="form-group">
                    <label for="description"
                           class="form-label">Description</label>
                    <textarea type="text"
                              name="description"
                              id="description"
                              rows="4"
                              class="form-control"
                              placeholder="Type description">{{ old('description', $topic->description ?? "") }}</textarea>
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
                                    {{ old('status', isset($topic) ? (string)$topic->status : "1") === (string)$status->value ? 'selected' : '' }}
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
        <a href="{{ route('admin.topics.index') }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-success pull-right">Submit</button>
    </div>
</div>
