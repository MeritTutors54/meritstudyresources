@extends('layouts.backend')
@section('content')
    @php
        $r = 'admin.teacher-library.';
        $filesOn = Route::has($r . 'lessons.resources.store');           // Step 7
        $canUpload = $filesOn && Auth::user()->can('createLessonResource', Auth::user());
        $canReorder = Route::has($r . 'lessons.resources.reorder') && Auth::user()->can('updateLessonResource', Auth::user());
        $mb = fn ($bytes) => $bytes ? number_format($bytes / 1024 / 1024, 1) . ' MB' : '';
    @endphp
    <div class="content-wrapper">
        <div class="container-full">
            @include('backend.teacher-library.partials.page-header', [
                'title'  => $lesson->code . ' · ' . $lesson->title,
                'crumbs' => [
                    'Teacher Library' => route('admin.teacher-library.index'),
                    $course->title => route('admin.teacher-library.courses.show', $course) . '#units',
                    'Unit ' . $unit->unit_number => route('admin.teacher-library.units.show', $unit),
                    $lesson->code => null,
                ],
            ])
            <section class="content">
                @include('layouts.backend.notification')

                {{-- ===== Lesson details ===== --}}
                <div class="box">
                    <div class="box-header with-border d-flex align-items-center">
                        <h4 class="box-title mb-0">Lesson {{ $lesson->lesson_number }} · Week {{ $lesson->week_number }}</h4>
                        <div class="ms-auto d-flex gap-2">
                            
                                <a href="{{ route($r . 'lessons.edit', $lesson) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>
                       
                                @if ($lesson->resources->isEmpty())
                                    <button type="button" class="dltButton btn btn-sm btn-danger"
                                            data-route="{{ route($r . 'lessons.destroy', $lesson) }}" data-name="{{ $lesson->code }} {{ $lesson->title }}">
                                        <i class="fa fa-trash-o"></i> Delete
                                    </button>
                                @endif
                         
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6"><p class="text-fade mb-1">Learning objective</p><p>{{ $lesson->objective ?: '—' }}</p></div>
                            <div class="col-md-6"><p class="text-fade mb-1">Summary</p><p>{{ $lesson->summary ?: '—' }}</p></div>
                            <div class="col-md-3"><p class="text-fade mb-1">Status</p>@include('backend.teacher-library.partials.status-badge', ['status' => $lesson->status])</div>
                        </div>
                    </div>
                </div>

                {{-- ===== Files ===== --}}
                <div class="box" id="files">
                    <div class="box-header with-border d-flex align-items-center">
                        <h4 class="box-title mb-0">Files <small class="text-fade">what teachers download</small></h4>
                        @if ($canReorder && $lesson->resources->count() > 1)
                            <button type="button" id="saveFileOrder" class="ms-auto btn btn-sm btn-success d-none"><i class="fa fa-save"></i> Save order</button>
                        @endif
                    </div>
                    <div class="box-body">
                        @if (! $filesOn)
                            <p class="text-fade"><i class="fa fa-info-circle"></i> File uploads are switched on in Step 7.</p>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                <tr>
                                    @if ($canReorder)<th style="width: 36px"></th>@endif
                                    <th>Type</th>
                                    <th>Title</th>
                                    <th>File</th>
                                    <th>Access</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" style="width: 110px">Action</th>
                                </tr>
                                </thead>
                                <tbody id="fileList">
                                @forelse ($lesson->resources as $file)
                                    <tr data-id="{{ $file->id }}">
                                        @if ($canReorder)<td class="drag-handle text-fade" style="cursor: grab"><i class="fa fa-bars"></i></td>@endif
                                        <td>{{ $file->type?->name }}</td>
                                        <td>{{ $file->title }}</td>
                                        <td><span class="badge badge-info-light text-uppercase">{{ $file->file_ext }}</span> <small class="text-fade">{{ $mb($file->file_size) }}</small></td>
                                        <td>
                                            @if ($file->is_paid)<span class="badge badge-primary-light">Paid</span>@else<span class="badge badge-success-light">Free</span>@endif
                                            @if ($file->is_pro)<span class="badge badge-warning-light">Pro</span>@endif
                                        </td>
                                        <td class="text-center">@include('backend.teacher-library.partials.status-badge', ['status' => $file->status])</td>
                                        <td class="text-center">
                                            @if ($filesOn)
                                               
                                                    <a href="{{ route($r . 'resources.file', $file) }}" target="_blank" title="Open file"><i class="fa fa-eye"></i></a>
                                               
                                                    <a href="{{ route($r . 'resources.edit', $file) }}" class="ms-2" title="Edit"><i class="fa fa-edit"></i></a>
                                             
                                                    @include('backend.teacher-library.partials.delete-button', ['route' => route($r . 'resources.destroy', $file), 'name' => $file->title])
                                               
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="text-center text-fade py-4">No files yet.</td></tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- ===== Upload (Step 7) ===== --}}
       
                    <div class="box" id="upload">
                        <div class="box-header with-border"><h4 class="box-title">Upload files</h4></div>
                        <form action="{{ route($r . 'lessons.resources.store', $lesson) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="box-body">
                                <p class="text-fade">PDF, PPTX, DOCX or XLSX · up to 50 MB each · up to 10 files at once.</p>
                                @error('files')<div class="alert alert-danger">{{ $message }}</div>@enderror
                                <div id="uploadRows">
                                    @php $oldRows = old('files', [[]]); @endphp
                                    @foreach ($oldRows as $i => $row)
                                        @include('backend.teacher-library.resources._upload-row', ['i' => $i, 'row' => $row])
                                    @endforeach
                                </div>
                                <button type="button" id="addUploadRow" class="btn btn-sm btn-light"><i class="fa fa-plus"></i> Add another file</button>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-success"><i class="fa fa-upload"></i> Upload</button>
                            </div>
                        </form>
                        <template id="uploadRowTemplate">
                            @include('backend.teacher-library.resources._upload-row', ['i' => '__i__', 'row' => []])
                        </template>
                    </div>
            
                @include('layouts.backend.delete-modal')
            </section>
        </div>
    </div>
@endsection
@section('js')
    @include('backend.teacher-library.partials.delete-script')
    @if ($canReorder && $lesson->resources->count() > 1)
        @include('backend.teacher-library.partials.sortable', [
            'listId' => 'fileList', 'buttonId' => 'saveFileOrder',
            'saveUrl' => route('admin.teacher-library.lessons.resources.reorder', $lesson),
        ])
    @endif
 
        <script>
            (function () {
                const rows = document.getElementById('uploadRows');
                const template = document.getElementById('uploadRowTemplate').innerHTML;
                const lessonTitle = @json($lesson->title);
                let next = rows.children.length + 1;

                document.getElementById('addUploadRow').addEventListener('click', function () {
                    if (rows.children.length >= 10) return alert('Up to 10 files at once.');
                    rows.insertAdjacentHTML('beforeend', template.replace(/__i__/g, next++));
                });
                rows.addEventListener('click', function (e) {
                    const remove = e.target.closest('.remove-upload-row');
                    if (remove && rows.children.length > 1) remove.closest('.upload-row').remove();
                });
                // Picking a type fills an empty title: "Slides — Hundreds Tens and Ones"
                rows.addEventListener('change', function (e) {
                    if (!e.target.matches('.upload-type')) return;
                    const title = e.target.closest('.upload-row').querySelector('.upload-title');
                    const typeName = e.target.selectedOptions[0]?.dataset.name;
                    if (title && typeName && (!title.value || title.dataset.auto === '1')) {
                        title.value = typeName + ' — ' + lessonTitle;
                        title.dataset.auto = '1';
                    }
                });
                rows.addEventListener('input', function (e) {
                    if (e.target.matches('.upload-title')) e.target.dataset.auto = '0';
                });
            })();
        </script>
  
@endsection
