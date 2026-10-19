@extends('layouts.backend')
@section('content')
    @php
        $editing = isset($item);
        $scope = $editing ? 'Update' : 'Add';
        $actionUrl = $editing
            ? route('admin.teacher-library.lessons.update', $item)
            : route('admin.teacher-library.units.lessons.store', $unit);
    @endphp
    <div class="content-wrapper">
        <div class="container-full">
            @include('backend.teacher-library.partials.page-header', [
                'title'  => $scope . ' lesson',
                'crumbs' => [
                    'Teacher Library' => route('admin.teacher-library.index'),
                    $course->title => route('admin.teacher-library.courses.show', $course) . '#units',
                    'Unit ' . $unit->unit_number => route('admin.teacher-library.units.show', $unit),
                    $scope . ' lesson' => null,
                ],
            ])
            <section class="content">
                <div class="row">
                    <div class="col-lg-8 col-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h4 class="box-title">
                                    {{ $scope }} lesson — Unit {{ $unit->unit_number }}: {{ $unit->title }}
                                    <code class="ms-2">{{ $editing ? $item->code : $nextCode }}</code>
                                </h4>
                            </div>
                            @include('layouts.backend.notification')
                            <form action="{{ $actionUrl }}" method="post">
                                @csrf
                                @if ($editing) @method('PATCH') @endif
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label for="title" class="form-label">Title</label>
                                                <input type="text" name="title" id="title" maxlength="200" required class="form-control"
                                                       value="{{ old('title', $item->title ?? '') }}" placeholder="e.g. Hundreds Tens and Ones">
                                                @include('backend.teacher-library.partials.error', ['field' => 'title'])
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="week_number" class="form-label">Week</label>
                                                <input type="number" name="week_number" id="week_number" min="1" max="60" class="form-control"
                                                       value="{{ old('week_number', $item->week_number ?? $suggestedWeek ?? '') }}">
                                                @include('backend.teacher-library.partials.error', ['field' => 'week_number'])
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="objective" class="form-label">Learning objective <small class="text-fade">(optional)</small></label>
                                                <textarea name="objective" id="objective" rows="2" maxlength="2000" class="form-control">{{ old('objective', $item->objective ?? '') }}</textarea>
                                                @include('backend.teacher-library.partials.error', ['field' => 'objective'])
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="summary" class="form-label">Summary <small class="text-fade">(optional)</small></label>
                                                <textarea name="summary" id="summary" rows="3" maxlength="2000" class="form-control">{{ old('summary', $item->summary ?? '') }}</textarea>
                                                @include('backend.teacher-library.partials.error', ['field' => 'summary'])
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            @include('backend.teacher-library.partials.status-field', ['value' => $item->status ?? 1])
                                        </div>
                                    </div>
                                    <p class="text-fade mb-0">
                                        <i class="fa fa-info-circle"></i>
                                        @if ($editing)
                                            Lesson {{ $item->lesson_number }}. The number and code change only through drag-and-drop and "Renumber codes".
                                        @else
                                            This will be lesson {{ $nextNumber }} with code <code>{{ $nextCode }}</code>. The week is a suggestion (2 lessons a week).
                                        @endif
                                    </p>
                                </div>
                                <div class="box-footer">
                                    <a href="{{ $editing ? route('admin.teacher-library.lessons.show', $item) : route('admin.teacher-library.units.show', $unit) }}" class="btn btn-danger">Cancel</a>
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
