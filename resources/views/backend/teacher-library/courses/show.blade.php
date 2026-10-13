@extends('layouts.backend')
@section('content')
    @php
        $r = 'admin.teacher-library.';
        $unitsOn = Route::has($r . 'courses.units.create');      // Step 5
        $unitOpenOn = Route::has($r . 'units.show');              // Step 5
        $reorderOn = Route::has($r . 'courses.units.reorder');    // Step 5
        $renumberOn = Route::has($r . 'courses.renumber');        // Step 6
        $canReorder = $reorderOn && Auth::user()->can('updateCurriculumUnit', Auth::user());
        $kb = fn ($bytes) => $bytes ? number_format($bytes / 1024 / 1024, 1) . ' MB' : '';
    @endphp
    <div class="content-wrapper">
        <div class="container-full">
            @include('backend.teacher-library.partials.page-header', [
                'title'  => $course->title,
                'crumbs' => [
                    'Teacher Library' => route('admin.teacher-library.index'),
                    'Courses' => route('admin.teacher-library.courses.index'),
                    $course->title => null,
                ],
            ])

            <section class="content">
                @include('layouts.backend.notification')

                {{-- ===== Course details ===== --}}
                <div class="box">
                    <div class="box-header with-border d-flex align-items-center">
                        <h4 class="box-title mb-0">Course details</h4>
                        <div class="ms-auto d-flex gap-2">
                       
                                    <form method="post" action="{{ route($r . 'courses.renumber', $course) }}"
                                          onsubmit="return confirm('Rebuild every lesson code in {{ $course->title }} from the current unit and lesson order? Teachers may know the old codes.');">
                                        @csrf
                                        <div class="d-flex align-items-center gap-2">
                                            <input type="checkbox" name="weeks" value="1" id="renumberWeeks" class="filled-in chk-col-warning">
                                            <label for="renumberWeeks" class="mb-0 small" title="Also reset every week to 2 lessons a week">and weeks</label>
                                            <button class="btn btn-sm btn-warning" type="submit"><i class="fa fa-sort-numeric-asc"></i> Renumber codes</button>
                                        </div>
                                    </form>
                             
                            
                                <a href="{{ route($r . 'courses.edit', $course) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>
                       
                                @if ($course->units->isEmpty())
                                    <button type="button" class="dltButton btn btn-sm btn-danger"
                                            data-route="{{ route($r . 'courses.destroy', $course) }}" data-name="{{ $course->title }}">
                                        <i class="fa fa-trash-o"></i> Delete
                                    </button>
                                @endif
                        
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-3 col-6"><p class="text-fade mb-1">Phase › Year</p><p class="fw-600">{{ $course->year?->phase?->name }} › {{ $course->year?->name }}</p></div>
                            <div class="col-md-3 col-6"><p class="text-fade mb-1">Subject</p><p class="fw-600">{{ $course->subject?->name }}</p></div>
                            <div class="col-md-2 col-6"><p class="text-fade mb-1">Units / lessons</p><p class="fw-600">{{ $course->units->count() }} / {{ $course->lessons_count }}</p></div>
                            <div class="col-md-2 col-6"><p class="text-fade mb-1">Planned weeks</p><p class="fw-600">{{ $course->planned_weeks }}{{ $course->has_weekly_homework ? ' · homework' : '' }}</p></div>
                            <div class="col-md-2 col-6"><p class="text-fade mb-1">Status</p>@include('backend.teacher-library.partials.status-badge', ['status' => $course->status])</div>
                            @if ($course->intro)
                                <div class="col-12"><p class="text-fade mb-1">{{ $course->curriculum_label }}</p><p class="mb-0">{{ $course->intro }}</p></div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- ===== Units ===== --}}
                <div class="box" id="units">
                    <div class="box-header with-border d-flex align-items-center">
                        <h4 class="box-title mb-0">Units <small class="text-fade">in teaching order</small></h4>
                        <div class="ms-auto d-flex gap-2">
                            @if ($canReorder && $course->units->count() > 1)
                                <button type="button" id="saveUnitOrder" class="btn btn-sm btn-success d-none"><i class="fa fa-save"></i> Save order</button>
                            @endif
                            @if ($unitsOn)
                                
                                    <a href="{{ route($r . 'courses.units.create', $course) }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add unit</a>
                               
                            @endif
                        </div>
                    </div>
                    <div class="box-body">
                        @if (! $unitsOn)
                            <p class="text-fade mb-2"><i class="fa fa-info-circle"></i> Unit screens are switched on in Step 5.</p>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                <tr>
                                    @if ($canReorder)<th style="width: 36px"></th>@endif
                                    <th style="width: 70px">Unit</th>
                                    <th>Title</th>
                                    <th class="text-center">Lessons</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" style="width: 110px">Action</th>
                                </tr>
                                </thead>
                                <tbody id="unitList">
                                @forelse ($course->units as $unit)
                                    <tr data-id="{{ $unit->id }}">
                                        @if ($canReorder)<td class="drag-handle text-fade" style="cursor: grab" title="Drag to reorder"><i class="fa fa-bars"></i></td>@endif
                                        <td>{{ $unit->unit_number }}</td>
                                        <td>
                                            @if ($unitOpenOn)
                                                <a href="{{ route($r . 'units.show', $unit) }}" class="fw-600">{{ $unit->title }}</a>
                                            @else
                                                <span class="fw-600">{{ $unit->title }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $unit->lessons_count }}</td>
                                        <td class="text-center">@include('backend.teacher-library.partials.status-badge', ['status' => $unit->status])</td>
                                        <td class="text-center">
                                            @if ($unitOpenOn)
                                                <a href="{{ route($r . 'units.show', $unit) }}" title="Open unit"><i class="fa fa-folder-open-o"></i></a>
                                               
                                                    <a href="{{ route($r . 'units.edit', $unit) }}" class="ms-2" title="Edit"><i class="fa fa-edit"></i></a>
                                           
                                                    @include('backend.teacher-library.partials.delete-button', ['route' => route($r . 'units.destroy', $unit), 'name' => $unit->title])
                                                
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center text-fade py-4">No units yet.</td></tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- ===== Documents ===== --}}
                <div class="box" id="documents">
                    <div class="box-header with-border d-flex align-items-center">
                        <h4 class="box-title mb-0">Documents <small class="text-fade">curriculum map, weekly planning, term assessments</small></h4>

                            <a href="{{ route($r . 'courses.documents.create', $course) }}" class="ms-auto btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add document</a>
                       
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Title</th>
                                    <th>File</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" style="width: 110px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($course->documents as $doc)
                                    <tr>
                                        <td>{{ $documentTypes[$doc->type] ?? $doc->type }}{{ $doc->term ? ' · ' . ($terms[$doc->term] ?? $doc->term) : '' }}</td>
                                        <td>{{ $doc->title }}</td>
                                        <td><span class="badge badge-info-light text-uppercase">{{ $doc->file_ext }}</span> <small class="text-fade">{{ $kb($doc->file_size) }}</small></td>
                                        <td class="text-center">@include('backend.teacher-library.partials.status-badge', ['status' => $doc->status])</td>
                                        <td class="text-center">
                                           
                                                <a href="{{ route($r . 'documents.file', $doc) }}" target="_blank" title="Open file"><i class="fa fa-eye"></i></a>
                                           
                                                <a href="{{ route($r . 'documents.edit', $doc) }}" class="ms-2" title="Edit"><i class="fa fa-edit"></i></a>
                                            
                                                @include('backend.teacher-library.partials.delete-button', ['route' => route($r . 'documents.destroy', $doc), 'name' => $doc->title])
                                         
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center text-fade py-4">No documents yet.</td></tr>
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
    @if ($canReorder && $course->units->count() > 1)
        @include('backend.teacher-library.partials.sortable', [
            'listId' => 'unitList',
            'buttonId' => 'saveUnitOrder',
            'saveUrl' => route('admin.teacher-library.courses.units.reorder', $course),
        ])
    @endif
@endsection
