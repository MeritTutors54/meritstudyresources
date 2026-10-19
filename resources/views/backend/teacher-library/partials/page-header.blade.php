{{--
    @include('backend.teacher-library.partials.page-header', [
        'title'  => 'Phases',
        'crumbs' => ['Teacher Library' => route('admin.teacher-library.index'), 'Phases' => null],
    ])
--}}
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h3 class="page-title">{{ $title }}</h3>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}"><i class="mdi mdi-home-outline"></i></a>
                        </li>
                        @foreach ($crumbs as $label => $url)
                            @if ($url)
                                <li class="breadcrumb-item"><a href="{{ $url }}">{{ $label }}</a></li>
                            @else
                                <li class="breadcrumb-item active" aria-current="page">{{ $label }}</li>
                            @endif
                        @endforeach
                    </ol>
                </nav>
            </div>
        </div>
        @isset($actions)
            <div class="ms-auto">{!! $actions !!}</div>
        @endisset
    </div>
</div>
