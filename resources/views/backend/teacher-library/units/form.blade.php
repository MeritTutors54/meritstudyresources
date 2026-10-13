@extends('layouts.backend')
@section('content')
    @php
        $editing = isset($item);
        $scope = $editing ? 'Update' : 'Add';
        $actionUrl = $editing
            ? route('admin.teacher-library.units.update', $item)
            : route('admin.teacher-library.courses.units.store', $course);
    @endphp
    <div class="content-wrapper">
        <div class="container-full">
            @include('backend.teacher-library.partials.page-header', [
                'title'  => $scope . ' unit',
                'crumbs' => [
                    'Teacher Library' => route('admin.teacher-library.index'),
                    $course->title => route('admin.teacher-library.courses.show', $course) . '#units',
                    $scope . ' unit' => null,
                ],
            ])
            <section class="content">
                <div class="row">
                    <div class="col-lg-8 col-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h4 class="box-title">
                                    {{ $scope }} unit — {{ $course->title }}
                                    <small class="text-fade ms-2">Unit {{ $editing ? $item->unit_number : $nextNumber }}</small>
                                </h4>
                            </div>
                            @include('layouts.backend.notification')
                            <form action="{{ $actionUrl }}" method="post">
                                @csrf
                                @if ($editing) @method('PATCH') @endif
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" name="title" id="title" maxlength="150" required class="form-control"
                                               value="{{ old('title', $item->title ?? '') }}" placeholder="e.g. Place Value">
                                        @include('backend.teacher-library.partials.error', ['field' => 'title'])
                                    </div>
                                    <div class="form-group">
                                        <label for="summary" class="form-label">Summary <small class="text-fade">(optional)</small></label>
                                        <textarea name="summary" id="summary" rows="3" maxlength="2000" class="form-control">{{ old('summary', $item->summary ?? '') }}</textarea>
                                        @include('backend.teacher-library.partials.error', ['field' => 'summary'])
                                    </div>
                                    <div class="row"><div class="col-md-4">
                                        @include('backend.teacher-library.partials.status-field', ['value' => $item->status ?? 1])
                                    </div></div>
                                    @unless ($editing)
                                        <p class="text-fade mb-0"><i class="fa fa-info-circle"></i> New units go to the end. Drag them into place on the course page.</p>
                                    @endunless
                                </div>
                                <div class="box-footer">
                                    <a href="{{ $editing ? route('admin.teacher-library.units.show', $item) : route('admin.teacher-library.courses.show', $course) . '#units' }}" class="btn btn-danger">Cancel</a>
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
