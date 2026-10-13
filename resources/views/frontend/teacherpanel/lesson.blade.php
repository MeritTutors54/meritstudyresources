@extends('layouts.frontend-3')
@section('title', $lesson->code . ' ' . $lesson->title . ' — ' . $course->title . ' | Merit Study Resources')
@section('meta_description', \Illuminate\Support\Str::limit($lesson->objective ?: $lesson->summary ?: $lesson->title . ' — ' . $course->title . ' teaching resources.', 155))
@section('body_class', 'page-teacher')

@push('css')
    <link href="{{ asset('frontend/new/css/teacherspanel.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/new/css/teacherspanel-extra.css') }}" rel="stylesheet">
@endpush

@section('content')
    @php
        $user = $access->user();
        $paidCount = $files->filter(fn ($f) => $f['file']->is_paid)->count();
        $size = function (?int $bytes) {
            if (! $bytes) return null;
            return $bytes >= 1048576 ? round($bytes / 1048576, 1) . ' MB' : max(1, round($bytes / 1024)) . ' KB';
        };
    @endphp

    <div class="tl-body">
        <div class="container-fluid px-lg-4">
            <div class="tl-layout">

                <!-- Lessons in this topic -->
                <aside class="tl-sidebar" aria-label="{{ $unit->title }} lessons">
                    <a class="tl-back" href="{{ $courseUrl }}#unit-{{ $unit->unit_number }}"><i class="bi bi-arrow-left"></i>All {{ $course->title }} topics</a>
                    <p class="tl-side-title"><i class="bi bi-caret-down-fill"></i>{{ $unit->title }}</p>
                    <p class="tl-side-sub">Teaching steps</p>
                    <nav>
                        <ul class="list-unstyled topic-nav">
                            @foreach ($unit->lessons as $item)
                                <li>
                                    <a class="topic-link {{ $item->id === $lesson->id ? 'is-active' : '' }}"
                                       href="{{ route('teacher-resources.lesson', [$course, $item->id, $item->slug]) }}"
                                       @if ($item->id === $lesson->id) aria-current="page" @endif>
                                        <span class="topic-num">{{ str_pad($item->lesson_number, 2, '0', STR_PAD_LEFT) }}</span>
                                        <span class="topic-name">{{ $item->title }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                </aside>

                <!-- Lesson -->
                <div class="tl-main">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb course-crumbs">
                            <li class="breadcrumb-item"><a href="{{ route('teacher-resources.index') }}">Teacher library</a></li>
                            <li class="breadcrumb-item"><a href="{{ $courseUrl }}">{{ $course->title }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ $courseUrl }}#unit-{{ $unit->unit_number }}">{{ $unit->title }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $lesson->code }}</li>
                        </ol>
                    </nav>

                    @if (session('error'))
                        <div class="tl-alert" role="alert"><i class="bi bi-exclamation-circle"></i><span>{{ session('error') }}</span></div>
                    @endif

                    <p class="tl-eyebrow">{{ $unit->title }} · Step {{ $lesson->lesson_number }}</p>
                    <h1 class="tl-title">{{ $lesson->title }}</h1>
                    <ul class="list-unstyled tl-stats">
                        @if ($lesson->week_number)
                            <li class="tl-stat"><i class="bi bi-calendar3"></i>Week {{ $lesson->week_number }}</li>
                        @endif
                        <li class="tl-stat"><i class="bi bi-hash"></i>{{ $lesson->code }}</li>
                        <li class="tl-stat"><i class="bi bi-files"></i>{{ $files->count() }} {{ \Illuminate\Support\Str::plural('file', $files->count()) }}</li>
                    </ul>

                    @if ($lesson->objective || $lesson->summary)
                        <div class="tl-objective">
                            @if ($lesson->objective)
                                <p class="tl-objective-label"><i class="bi bi-bullseye"></i>Learning objective</p>
                                <p class="tl-objective-text">{{ $lesson->objective }}</p>
                            @endif
                            @if ($lesson->summary)
                                <p class="tl-summary">{!! nl2br(e($lesson->summary)) !!}</p>
                            @endif
                        </div>
                    @endif

                    <section aria-labelledby="filesTitle" class="tl-files">
                        <div class="unit-head">
                            <div>
                                <h2 class="unit-title" id="filesTitle">Lesson files</h2>
                                <p class="unit-meta">Everything you need to teach this step.</p>
                            </div>
                        </div>

                        {{-- Account status: what this visitor can do --}}
                        @if ($paidCount > 0)
                            @if (! $user)
                                <div class="tl-access">
                                    <i class="bi bi-person-lock"></i>
                                    <p><strong>Log in to download.</strong> Lesson files are part of a school or teacher subscription.</p>
                                    <a class="btn btn-merit btn-sm" href="{{ route('login') }}">Log in</a>
                                </div>
                            @elseif (! $access->subscription())
                                <div class="tl-access">
                                    <i class="bi bi-stars"></i>
                                    @if ($access->isTeacher())
                                        <p><strong>No active subscription.</strong> Ask your school admin to renew the school plan.</p>
                                    @else
                                        <p><strong>Subscribe to download.</strong> One plan opens every lesson in the library.</p>
                                        <a class="btn btn-merit btn-sm" href="{{ route('pricing') }}">See plans</a>
                                    @endif
                                </div>
                            @else
                                <div class="tl-access is-ok">
                                    <i class="bi bi-check-circle"></i>
                                    <p><strong>{{ number_format($access->remainingDownloads()) }}</strong> {{ \Illuminate\Support\Str::plural('download', $access->remainingDownloads()) }} left in your plan. Downloading a file again is free.</p>
                                </div>
                            @endif
                        @endif

                        @if ($files->isEmpty())
                            <div class="lesson-list"><p class="tl-empty"><i class="bi bi-hourglass-split"></i>Files for this lesson are being added. Please check back soon.</p></div>
                        @else
                            <ul class="lesson-list tl-file-list">
                                @foreach ($files as ['file' => $file, 'state' => $state])
                                    <li class="tl-file">
                                        <span class="tl-file-icon"><i class="bi bi-{{ $file->type->icon ?: 'file-earmark' }}"></i></span>
                                        <div class="tl-file-body">
                                            <p class="tl-file-type">{{ $file->type->name }}</p>
                                            <h3 class="tl-file-title">{{ $file->title }}</h3>
                                            <p class="lesson-meta">
                                                <span class="lesson-code">{{ strtoupper($file->file_ext ?: pathinfo($file->file_path, PATHINFO_EXTENSION)) }}</span>
                                                @if ($size($file->file_size))
                                                    <span>{{ $size($file->file_size) }}</span>
                                                @endif
                                                @if (! $file->is_paid)
                                                    <span class="tl-badge is-free">Free</span>
                                                @elseif ($file->is_pro)
                                                    <span class="tl-badge is-pro"><i class="bi bi-star-fill"></i>Standard &amp; Premium</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="tl-file-action">
                                            @if ($state === \App\Services\TeacherLibraryAccess::OK)
                                                <form method="POST" action="{{ route('teacher-resources.download', $file) }}">
                                                    @csrf
                                                    <button class="btn btn-merit btn-open" type="submit">
                                                        <i class="bi bi-download"></i>Download<span class="visually-hidden">: {{ $file->title }}</span>
                                                    </button>
                                                </form>
                                            @elseif ($state === \App\Services\TeacherLibraryAccess::GUEST)
                                                <a class="btn btn-soft btn-open" href="{{ route('login') }}"><i class="bi bi-lock"></i>Log in to download</a>
                                            @elseif ($state === \App\Services\TeacherLibraryAccess::SUBSCRIBE)
                                                @if ($access->isTeacher())
                                                    <span class="tl-locked"><i class="bi bi-lock"></i>School plan needed</span>
                                                @else
                                                    <a class="btn btn-soft btn-open" href="{{ route('pricing') }}"><i class="bi bi-lock"></i>Subscribe</a>
                                                @endif
                                            @elseif ($state === \App\Services\TeacherLibraryAccess::UPGRADE)
                                                @if ($access->isTeacher())
                                                    <span class="tl-locked"><i class="bi bi-star"></i>Standard plan needed</span>
                                                @else
                                                    <a class="btn btn-soft btn-open" href="{{ route('pricing') }}"><i class="bi bi-star"></i>Upgrade</a>
                                                @endif
                                            @else
                                                <span class="tl-locked"><i class="bi bi-slash-circle"></i>No downloads left</span>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </section>

                    <nav class="tl-pager" aria-label="Previous and next lesson">
                        @if ($previous)
                            <a class="tl-pager-link" href="{{ route('teacher-resources.lesson', [$course, $previous->id, $previous->slug]) }}">
                                <span class="tl-pager-dir"><i class="bi bi-arrow-left"></i>Previous step</span>
                                <span class="tl-pager-title">{{ $previous->title }}</span>
                            </a>
                        @else
                            <span></span>
                        @endif
                        @if ($next)
                            <a class="tl-pager-link is-next" href="{{ route('teacher-resources.lesson', [$course, $next->id, $next->slug]) }}">
                                <span class="tl-pager-dir">Next step<i class="bi bi-arrow-right"></i></span>
                                <span class="tl-pager-title">{{ $next->title }}</span>
                            </a>
                        @endif
                    </nav>
                </div>

            </div>
        </div>
    </div>
@endsection
