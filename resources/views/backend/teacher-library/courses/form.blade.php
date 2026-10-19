@extends('layouts.backend')
@section('content')
    @php
        $editing = isset($item);
        $scope = $editing ? 'Update' : 'Create';
        $actionUrl = $editing
            ? route('admin.teacher-library.courses.update', $item)
            : route('admin.teacher-library.courses.store');
    @endphp
    <div class="content-wrapper">
        <div class="container-full">
            @include('backend.teacher-library.partials.page-header', [
                'title'  => $scope . ' course',
                'crumbs' => array_filter([
                    'Teacher Library' => route('admin.teacher-library.index'),
                    'Courses' => route('admin.teacher-library.courses.index'),
                    ($editing ? $item->title : null) => $editing ? route('admin.teacher-library.courses.show', $item) : null,
                    $scope => null,
                ], fn ($v, $k) => $k !== '', ARRAY_FILTER_USE_BOTH),
            ])

            <section class="content">
                <div class="row">
                    <div class="col-lg-9 col-12">
                        <div class="box">
                            <div class="box-header with-border"><h4 class="box-title">{{ $scope }} course</h4></div>
                            @include('layouts.backend.notification')
                            <form action="{{ $actionUrl }}" method="post">
                                @csrf
                                @if ($editing) @method('PATCH') @endif
                                <div class="box-body">
                                    @if ($editing && $item->lessons()->exists())
                                        <div class="alert alert-warning">
                                            Changing the year or subject does not change existing lesson codes (e.g. <code>Y3-U01-L01</code>).
                                            Use <strong>Renumber codes</strong> on the course page afterwards if you need them updated.
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="year_id" class="form-label">Year</label>
                                                <select name="year_id" id="year_id" class="form-select" required>
                                                    <option value="">Select a year…</option>
                                                    @foreach ($yearsByPhase as $phaseName => $years)
                                                        <optgroup label="{{ $phaseName }}">
                                                            @foreach ($years as $year)
                                                                <option value="{{ $year->id }}" @selected((string) old('year_id', $item->year_id ?? '') === (string) $year->id)>{{ $year->name }}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                                @include('backend.teacher-library.partials.error', ['field' => 'year_id'])
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="subject_id" class="form-label">Subject</label>
                                                <select name="subject_id" id="subject_id" class="form-select" required>
                                                    <option value="">Select a subject…</option>
                                                    @foreach ($subjects as $subject)
                                                        <option value="{{ $subject->id }}" @selected((string) old('subject_id', $item->subject_id ?? '') === (string) $subject->id)>{{ $subject->name }}</option>
                                                    @endforeach
                                                </select>
                                                @include('backend.teacher-library.partials.error', ['field' => 'subject_id'])
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="title" class="form-label">Title <small class="text-fade">(leave empty for "Year 3 Maths")</small></label>
                                                <input type="text" name="title" id="title" maxlength="150" class="form-control"
                                                       value="{{ old('title', $item->title ?? '') }}" placeholder="Made from the year and subject">
                                                @include('backend.teacher-library.partials.error', ['field' => 'title'])
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="curriculum_label" class="form-label">Curriculum label</label>
                                                <input type="text" name="curriculum_label" id="curriculum_label" maxlength="100" class="form-control"
                                                       value="{{ old('curriculum_label', $item->curriculum_label ?? 'England National Curriculum') }}">
                                                @include('backend.teacher-library.partials.error', ['field' => 'curriculum_label'])
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="intro" class="form-label">Intro <small class="text-fade">(shown under the title for teachers)</small></label>
                                                <textarea name="intro" id="intro" rows="3" maxlength="2000" class="form-control"
                                                          placeholder="Find a topic, open a teaching step and choose the resources you need.">{{ old('intro', $item->intro ?? '') }}</textarea>
                                                @include('backend.teacher-library.partials.error', ['field' => 'intro'])
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="form-group">
                                                <label for="planned_weeks" class="form-label">Planned weeks</label>
                                                <input type="number" name="planned_weeks" id="planned_weeks" min="1" max="60" class="form-control"
                                                       value="{{ old('planned_weeks', $item->planned_weeks ?? 36) }}">
                                                @include('backend.teacher-library.partials.error', ['field' => 'planned_weeks'])
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="form-group">
                                                <label class="form-label d-block">Weekly homework</label>
                                                <input type="checkbox" name="has_weekly_homework" id="has_weekly_homework" value="1" class="filled-in chk-col-success"
                                                       @checked(old('has_weekly_homework', $item->has_weekly_homework ?? true))>
                                                <label for="has_weekly_homework">Included</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            @include('backend.teacher-library.partials.status-field', ['value' => $item->status ?? 1])
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <a href="{{ $editing ? route('admin.teacher-library.courses.show', $item) : route('admin.teacher-library.courses.index') }}" class="btn btn-danger">Cancel</a>
                                    <button type="submit" class="btn btn-success pull-right">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
