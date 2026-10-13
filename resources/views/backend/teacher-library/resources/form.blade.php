@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            @include('backend.teacher-library.partials.page-header', [
                'title'  => 'Edit file',
                'crumbs' => [
                    'Teacher Library' => route('admin.teacher-library.index'),
                    $course->title => route('admin.teacher-library.courses.show', $course) . '#units',
                    'Unit ' . $unit->unit_number => route('admin.teacher-library.units.show', $unit),
                    $lesson->code => route('admin.teacher-library.lessons.show', $lesson) . '#files',
                    'Edit file' => null,
                ],
            ])
            <section class="content">
                <div class="row">
                    <div class="col-lg-8 col-12">
                        <div class="box">
                            <div class="box-header with-border"><h4 class="box-title">Edit file — {{ $lesson->code }} {{ $lesson->title }}</h4></div>
                            @include('layouts.backend.notification')
                            <form action="{{ route('admin.teacher-library.resources.update', $item) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="resource_type_id" class="form-label">File type</label>
                                                <select name="resource_type_id" id="resource_type_id" class="form-select" required>
                                                    @foreach ($types as $type)
                                                        <option value="{{ $type->id }}" @selected((string) old('resource_type_id', $item->resource_type_id) === (string) $type->id)>{{ $type->name }}</option>
                                                    @endforeach
                                                </select>
                                                @include('backend.teacher-library.partials.error', ['field' => 'resource_type_id'])
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="title" class="form-label">Title</label>
                                                <input type="text" name="title" id="title" maxlength="200" required class="form-control" value="{{ old('title', $item->title) }}">
                                                @include('backend.teacher-library.partials.error', ['field' => 'title'])
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="file" class="form-label">Replace file <small class="text-fade">(optional · PDF, PPTX, DOCX or XLSX · up to 50 MB)</small></label>
                                                <input type="file" name="file" id="file" class="form-control" accept=".pdf,.pptx,.docx,.xlsx">
                                                <small class="d-block mt-1">Current: <a href="{{ route('admin.teacher-library.resources.file', $item) }}" target="_blank">{{ $item->title }}.{{ $item->file_ext }}</a>
                                                    — replacing keeps its download history.</small>
                                                @include('backend.teacher-library.partials.error', ['field' => 'file'])
                                            </div>
                                        </div>
                                        <div class="col-md-4 d-flex align-items-center gap-4">
                                            <div>
                                                <input type="checkbox" name="is_paid" value="1" id="is_paid" class="filled-in chk-col-primary" @checked(old('is_paid', $item->is_paid))>
                                                <label for="is_paid">Paid</label>
                                            </div>
                                            <div>
                                                <input type="checkbox" name="is_pro" value="1" id="is_pro" class="filled-in chk-col-warning" @checked(old('is_pro', $item->is_pro))>
                                                <label for="is_pro">Pro only</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            @include('backend.teacher-library.partials.status-field', ['value' => $item->status])
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <a href="{{ route('admin.teacher-library.lessons.show', $lesson) }}#files" class="btn btn-danger">Cancel</a>
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
