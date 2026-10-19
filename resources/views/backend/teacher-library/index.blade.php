@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">Teacher Library</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}"><i class="mdi mdi-home-outline"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Teacher Library</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                @include('layouts.backend.notification')

                <div class="row">
                    @foreach ($cards as $card)
                        @continue(! $card['allowed'])
                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                            <div class="box">
                                <div class="box-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-fade mb-1">{{ $card['label'] }}</p>
                                        <h3 class="mb-0 fw-600">{{ number_format($card['count']) }}</h3>
                                    </div>
                                    @if ($card['url'])
                                        <a href="{{ $card['url'] }}" class="btn btn-sm btn-primary">Manage</a>
                                    @else
                                        <span class="badge badge-secondary-light">{{ $card['step'] }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
@endsection