@extends('layouts.backend')
@section('content')
    @php
        $schoolName = fn ($user) => $user ? ($user->type === \App\Enums\UserType::SCHOOL->value ? $user->name : $user->school?->name) : null;
    @endphp
    <div class="content-wrapper">
        <div class="container-full">
            @include('backend.teacher-library.partials.page-header', [
                'title'  => 'Teacher Library downloads',
                'crumbs' => ['Teacher Library' => route('admin.teacher-library.index'), 'Downloads' => null],
            ])
            <section class="content">
                @include('layouts.backend.notification')

                {{-- Filters --}}
                <div class="box">
                    <div class="box-body">
                        <form method="get" class="row g-2 align-items-end">
                            <div class="col-md-2 col-6">
                                <label class="form-label" for="from">From</label>
                                <input type="date" name="from" id="from" class="form-control" value="{{ $filters['from']->toDateString() }}">
                            </div>
                            <div class="col-md-2 col-6">
                                <label class="form-label" for="to">To</label>
                                <input type="date" name="to" id="to" class="form-control" value="{{ $filters['to']->toDateString() }}">
                            </div>
                            <div class="col-md-3 col-6">
                                <label class="form-label" for="school_id">School</label>
                                <select name="school_id" id="school_id" class="form-select">
                                    <option value="">All schools</option>
                                    @foreach ($schools as $school)
                                        <option value="{{ $school->id }}" @selected($filters['school_id'] === $school->id)>{{ $school->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-6">
                                <label class="form-label" for="course_id">Course</label>
                                <select name="course_id" id="course_id" class="form-select">
                                    <option value="">All courses</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}" @selected($filters['course_id'] === $course->id)>{{ $course->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 d-flex gap-2">
                                <button type="submit" class="btn btn-info">Filter</button>
                                <a href="{{ route('admin.teacher-library.downloads.export', request()->query()) }}" class="btn btn-success" title="Download these rows as CSV">
                                    <i class="fa fa-download"></i> CSV
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Totals + top lessons --}}
                <div class="row">
                    <div class="col-md-2 col-4"><div class="box"><div class="box-body"><p class="text-fade mb-1">Downloads</p><h3 class="mb-0 fw-600">{{ number_format($totals['downloads']) }}</h3></div></div></div>
                    <div class="col-md-2 col-4"><div class="box"><div class="box-body"><p class="text-fade mb-1">Schools</p><h3 class="mb-0 fw-600">{{ number_format($totals['schools']) }}</h3></div></div></div>
                    <div class="col-md-2 col-4"><div class="box"><div class="box-body"><p class="text-fade mb-1">Teachers</p><h3 class="mb-0 fw-600">{{ number_format($totals['teachers']) }}</h3></div></div></div>
                    <div class="col-md-6 col-12">
                        <div class="box">
                            <div class="box-body">
                                <p class="text-fade mb-2">Most downloaded lessons</p>
                                @forelse ($topLessons as $top)
                                    <div class="d-flex justify-content-between">
                                        <span><code>{{ $top->code }}</code> {{ $top->title }}</span>
                                        <span class="fw-600">{{ number_format($top->downloads) }}</span>
                                    </div>
                                @empty
                                    <span class="text-fade">No downloads in this range.</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Rows --}}
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Teacher</th>
                                    <th>School</th>
                                    <th>Course</th>
                                    <th>Lesson</th>
                                    <th>File</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($downloads as $row)
                                    @php($file = $row->lessonResource)
                                    @php($lesson = $file?->lesson)
                                    <tr>
                                        <td class="text-nowrap">{{ $row->created_at?->format('d M Y H:i') }}</td>
                                        <td>{{ $row->user?->name }} <small class="text-fade d-block">{{ $row->user?->email }}</small></td>
                                        <td>{{ $schoolName($row->user) }}</td>
                                        <td>{{ $lesson?->unit?->course?->title }}</td>
                                        <td><code>{{ $lesson?->code }}</code> {{ $lesson?->title }}</td>
                                        <td>
                                            {{ $file?->title }}
                                            <small class="text-fade d-block">{{ $file?->type?->name }}@if ($file?->trashed()) · deleted since @endif</small>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center text-fade py-4">No downloads match these filters.</td></tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">{{ $downloads->links() }}</div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
