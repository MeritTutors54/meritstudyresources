@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            @include('backend.teacher-library.partials.page-header', [
                'title'  => 'Courses',
                'crumbs' => ['Teacher Library' => route('admin.teacher-library.index'), 'Courses' => null],
            ])

            <section class="content">
                <div class="box">
                    @include('layouts.backend.notification')
                    <div class="box-header with-border">
                        <form method="get" class="row g-2 align-items-end">
                            <div class="col-md-3 col-6">
                                <label class="form-label" for="f_phase">Phase</label>
                                <select name="phase_id" id="f_phase" class="form-select">
                                    <option value="">All phases</option>
                                    @foreach ($phases as $phase)
                                        <option value="{{ $phase->id }}" @selected(($filters['phase_id'] ?? '') == $phase->id)>{{ $phase->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-6">
                                <label class="form-label" for="f_year">Year</label>
                                <select name="year_id" id="f_year" class="form-select">
                                    <option value="">All years</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year->id }}" @selected(($filters['year_id'] ?? '') == $year->id)>{{ $year->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-6">
                                <label class="form-label" for="f_subject">Subject</label>
                                <select name="subject_id" id="f_subject" class="form-select">
                                    <option value="">All subjects</option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}" @selected(($filters['subject_id'] ?? '') == $subject->id)>{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-6 d-flex gap-2">
                                <button class="btn btn-info" type="submit">Filter</button>
                                <a class="btn btn-light" href="{{ route('admin.teacher-library.courses.index') }}">Reset</a>
                                
                                    <a href="{{ route('admin.teacher-library.courses.create') }}" class="ms-auto btn btn-primary">
                                        <i class="fa fa-plus-square-o" aria-hidden="true"></i><span class="ms-2">New course</span>
                                    </a>
                                
                            </div>
                        </form>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0">
                                <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Phase › Year</th>
                                    <th>Subject</th>
                                    <th class="text-center">Units</th>
                                    <th class="text-center">Lessons</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" style="width: 120px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($courses as $course)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.teacher-library.courses.show', $course) }}" class="fw-600">{{ $course->title }}</a>
                                            <small class="text-fade d-block">{{ $course->slug }}</small>
                                        </td>
                                        <td>{{ $course->year?->phase?->name }} › {{ $course->year?->name }}</td>
                                        <td>{{ $course->subject?->name }}</td>
                                        <td class="text-center">{{ $course->units_count }}</td>
                                        <td class="text-center">{{ $course->lessons_count }}</td>
                                        <td class="text-center">@include('backend.teacher-library.partials.status-badge', ['status' => $course->status])</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.teacher-library.courses.show', $course) }}" title="Open course"><i class="fa fa-folder-open-o"></i></a>
                                         
                                                <a href="{{ route('admin.teacher-library.courses.edit', $course) }}" class="ms-2" title="Edit"><i class="fa fa-edit"></i></a>
                                         
                                            
                                                @include('backend.teacher-library.partials.delete-button', [
                                                    'route' => route('admin.teacher-library.courses.destroy', $course),
                                                    'name'  => $course->title,
                                                ])
                                          
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="text-center text-fade py-4">No courses match these filters.</td></tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @include('layouts.backend.delete-modal')
            </section>
        </div>
    </div>
@endsection
@section('js')
    @include('backend.teacher-library.partials.delete-script')
@endsection
