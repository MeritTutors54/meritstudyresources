@extends('layouts.backend')
@section('page-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection
@section('content')
    @php
        $editing = isset($item);
        $scope = $editing ? 'Update' : 'Create';
        $actionUrl = $editing
            ? route('admin.teacher-library.years.update', $item)
            : route('admin.teacher-library.years.store');
    @endphp
    <div class="content-wrapper">
        <div class="container-full">
            @include('backend.teacher-library.partials.page-header', [
                'title'  => $scope . ' year',
                'crumbs' => [
                    'Teacher Library' => route('admin.teacher-library.index'),
                    'Years' => route('admin.teacher-library.years.index'),
                    $scope => null,
                ],
            ])

            <section class="content">
                <div class="row">
                    <div class="col-lg-8 col-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h4 class="box-title">{{ $scope }} year</h4>
                            </div>
                            @include('layouts.backend.notification')
                            <form action="{{ $actionUrl }}" method="post">
                                @csrf
                                @if ($editing) @method('PATCH') @endif
                                <div class="box-body">
                                    <div class="row">
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label for="phase_id" class="form-label">Phase</label>
                    <select name="phase_id" id="phase_id" class="form-select">
                        <option value="">Select a phase…</option>
                        @foreach ($phases as $phase)
                            <option value="{{ $phase->id }}" @selected((string) old('phase_id', $item->phase_id ?? '') === (string) $phase->id)>{{ $phase->name }}</option>
                        @endforeach
                    </select>
                    @include('backend.teacher-library.partials.error', ['field' => 'phase_id'])
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" maxlength="100" required
                           value="{{ old('name', $item->name ?? '') }}"
                           class="form-control" placeholder="e.g. Year 3">
                    @include('backend.teacher-library.partials.error', ['field' => 'name'])
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="form-group">
                    <label for="sort_order" class="form-label">Order</label>
                    <input type="number" name="sort_order" id="sort_order" min="0" max="9999"
                           value="{{ old('sort_order', $item->sort_order ?? '') }}"
                           class="form-control" placeholder="Auto">
                    @include('backend.teacher-library.partials.error', ['field' => 'sort_order'])
                </div>
            </div>
            <div class="col-lg-3 col-6">
                @include('backend.teacher-library.partials.status-field', ['value' => $item->status ?? 1])
            </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <a href="{{ route('admin.teacher-library.years.index') }}" class="btn btn-danger">Cancel</a>
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
