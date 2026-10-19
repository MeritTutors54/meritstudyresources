@extends('layouts.backend')
@section('content')
    @php
        $r = 'admin.teacher-library.';
        $lessonsOn = Route::has($r . 'units.lessons.create');      // Step 6
        $canReorder = Route::has($r . 'units.lessons.reorder') && Auth::user()->can('updateCurriculumLesson', Auth::user()) && $q === '';
    @endphp
    <div class="content-wrapper">
        <div class="container-full">
            @include('backend.teacher-library.partials.page-header', [
                'title'  => 'Unit ' . $unit->unit_number . ': ' . $unit->title,
                'crumbs' => [
                    'Teacher Library' => route('admin.teacher-library.index'),
                    $course->title => route('admin.teacher-library.courses.show', $course) . '#units',
                    'Unit ' . $unit->unit_number => null,
                ],
            ])
            <section class="content">
                @include('layouts.backend.notification')
                <div class="box">
                    <div class="box-header with-border d-flex align-items-center flex-wrap gap-2">
                        <h4 class="box-title mb-0">Lessons</h4>
                        <form method="get" class="d-flex gap-2 ms-3">
                            <input type="search" name="q" value="{{ $q }}" class="form-control form-control-sm" placeholder="Search title or code, e.g. Y3-U01">
                            <button class="btn btn-sm btn-info" type="submit">Search</button>
                            @if ($q !== '')<a class="btn btn-sm btn-light" href="{{ route($r . 'units.show', $unit) }}">Clear</a>@endif
                        </form>
                        <div class="ms-auto d-flex gap-2">
                            @if ($canReorder && $lessons->count() > 1)
                                <button type="button" id="saveLessonOrder" class="btn btn-sm btn-success d-none"><i class="fa fa-save"></i> Save order</button>
                            @endif
                     
                                <a href="{{ route($r . 'units.edit', $unit) }}" class="btn btn-sm btn-light"><i class="fa fa-edit"></i> Edit unit</a>
                          
                                
                                    <a href="{{ route($r . 'units.lessons.create', $unit) }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add lesson</a>
                       
                        </div>
                    </div>
                    <div class="box-body">
                        @if (! $lessonsOn)
                            <p class="text-fade"><i class="fa fa-info-circle"></i> Lesson screens are switched on in Step 6.</p>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                <tr>
                                    @if ($canReorder)<th style="width: 36px"></th>@endif
                                    <th style="width: 50px">#</th>
                                    <th style="width: 120px">Code</th>
                                    <th>Title</th>
                                    <th class="text-center" style="width: 80px">Week</th>
                                    <th>Files</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" style="width: 110px">Action</th>
                                </tr>
                                </thead>
                                <tbody id="lessonList">
                                @forelse ($lessons as $lesson)
                                    <tr data-id="{{ $lesson->id }}">
                                        @if ($canReorder)<td class="drag-handle text-fade" style="cursor: grab" title="Drag to reorder"><i class="fa fa-bars"></i></td>@endif
                                        <td>{{ $lesson->lesson_number }}</td>
                                        <td><code>{{ $lesson->code }}</code></td>
                                        <td>
                                            @if ($lessonsOn)
                                                <a href="{{ route($r . 'lessons.show', $lesson) }}" class="fw-600">{{ $lesson->title }}</a>
                                            @else
                                                <span class="fw-600">{{ $lesson->title }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $lesson->week_number }}</td>
                                        <td>
                                            @forelse ($lesson->resources->pluck('type.name')->filter()->unique() as $typeName)
                                                <span class="badge badge-success-light me-1">{{ $typeName }}</span>
                                            @empty
                                                <span class="badge badge-warning-light">No files</span>
                                            @endforelse
                                        </td>
                                        <td class="text-center">@include('backend.teacher-library.partials.status-badge', ['status' => $lesson->status])</td>
                                        <td class="text-center">
                                            @if ($lessonsOn)
                                                <a href="{{ route($r . 'lessons.show', $lesson) }}" title="Open lesson"><i class="fa fa-folder-open-o"></i></a>
                                               
                                                    <a href="{{ route($r . 'lessons.edit', $lesson) }}" class="ms-2" title="Edit"><i class="fa fa-edit"></i></a>
                                      
                                                    @include('backend.teacher-library.partials.delete-button', ['route' => route($r . 'lessons.destroy', $lesson), 'name' => $lesson->code . ' ' . $lesson->title])
                                       
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="8" class="text-center text-fade py-4">{{ $q !== '' ? 'No lessons match "' . $q . '".' : 'No lessons yet.' }}</td></tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if ($unit->summary)<p class="text-fade mt-3 mb-0">{{ $unit->summary }}</p>@endif
                    </div>
                </div>
              
                    @if ($lessons->isEmpty() && $q === '')
                        <button type="button" class="dltButton btn btn-sm btn-outline-danger"
                                data-route="{{ route($r . 'units.destroy', $unit) }}" data-name="Unit {{ $unit->unit_number }}: {{ $unit->title }}">
                            <i class="fa fa-trash-o"></i> Delete this unit
                        </button>
                    @endif
            
                @include('layouts.backend.delete-modal')
            </section>
        </div>
    </div>
@endsection
@section('js')
    @include('backend.teacher-library.partials.delete-script')
    @if ($canReorder && $lessons->count() > 1)
        @include('backend.teacher-library.partials.sortable', [
            'listId' => 'lessonList', 'buttonId' => 'saveLessonOrder',
            'saveUrl' => route('admin.teacher-library.units.lessons.reorder', $unit),
        ])
    @endif
@endsection
