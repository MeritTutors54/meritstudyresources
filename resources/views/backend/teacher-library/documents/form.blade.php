@extends('layouts.backend')
@section('content')
    @php
        $editing = isset($item);
        $scope = $editing ? 'Update' : 'Add';
        $actionUrl = $editing
            ? route('admin.teacher-library.documents.update', $item)
            : route('admin.teacher-library.courses.documents.store', $course);
        $type = old('type', $item->type ?? 'curriculum_map');
    @endphp
    <div class="content-wrapper">
        <div class="container-full">
            @include('backend.teacher-library.partials.page-header', [
                'title'  => $scope . ' document',
                'crumbs' => [
                    'Teacher Library' => route('admin.teacher-library.index'),
                    'Courses' => route('admin.teacher-library.courses.index'),
                    $course->title => route('admin.teacher-library.courses.show', $course) . '#documents',
                    $scope . ' document' => null,
                ],
            ])

            <section class="content">
                <div class="row">
                    <div class="col-lg-8 col-12">
                        <div class="box">
                            <div class="box-header with-border"><h4 class="box-title">{{ $scope }} document — {{ $course->title }}</h4></div>
                            @include('layouts.backend.notification')
                            <form action="{{ $actionUrl }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @if ($editing) @method('PATCH') @endif
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="type" class="form-label">Type</label>
                                                <select name="type" id="type" class="form-select" required>
                                                    @foreach ($types as $value => $label)
                                                        <option value="{{ $value }}" @selected($type === $value)>{{ $label }}</option>
                                                    @endforeach
                                                </select>
                                                @include('backend.teacher-library.partials.error', ['field' => 'type'])
                                            </div>
                                        </div>
                                        <div class="col-md-6" id="termWrap" @if ($type !== 'term_assessment') style="display: none" @endif>
                                            <div class="form-group">
                                                <label for="term" class="form-label">Term</label>
                                                <select name="term" id="term" class="form-select">
                                                    <option value="">Select a term…</option>
                                                    @foreach ($terms as $value => $label)
                                                        <option value="{{ $value }}" @selected(old('term', $item->term ?? '') === $value)>{{ $label }}</option>
                                                    @endforeach
                                                </select>
                                                @include('backend.teacher-library.partials.error', ['field' => 'term'])
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="title" class="form-label">Title</label>
                                                <input type="text" name="title" id="title" maxlength="200" required class="form-control"
                                                       value="{{ old('title', $item->title ?? '') }}" placeholder="e.g. Year 3 Maths curriculum map 2026–27">
                                                @include('backend.teacher-library.partials.error', ['field' => 'title'])
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="file" class="form-label">
                                                    File <small class="text-fade">PDF, DOCX, PPTX or XLSX · up to 20 MB{{ $editing ? ' · leave empty to keep the current file' : '' }}</small>
                                                </label>
                                                <input type="file" name="file" id="file" class="form-control" accept=".pdf,.docx,.pptx,.xlsx" @if (! $editing) required @endif>
                                                @if ($editing)
                                                    <small class="d-block mt-1">Current: <a href="{{ route('admin.teacher-library.documents.file', $item) }}" target="_blank">{{ $item->title }}.{{ $item->file_ext }}</a></small>
                                                @endif
                                                @include('backend.teacher-library.partials.error', ['field' => 'file'])
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="form-group">
                                                <label for="sort_order" class="form-label">Order</label>
                                                <input type="number" name="sort_order" id="sort_order" min="0" max="9999" class="form-control"
                                                       value="{{ old('sort_order', $item->sort_order ?? '') }}" placeholder="Auto">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            @include('backend.teacher-library.partials.status-field', ['value' => $item->status ?? 1])
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <a href="{{ route('admin.teacher-library.courses.show', $course) }}#documents" class="btn btn-danger">Cancel</a>
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
@section('js')
    <script>
        document.getElementById('type').addEventListener('change', function () {
            document.getElementById('termWrap').style.display = this.value === 'term_assessment' ? '' : 'none';
        });
    </script>
@endsection
