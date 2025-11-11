@extends('layouts.backend')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">Profile</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">
                                            <i class="mdi mdi-home-outline"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Main content -->
            <section class="content">

                <div class="row">
                    <div class="col-12 col-lg-7 col-xl-8">

                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li><a class="active" href="#settings" data-bs-toggle="tab">Settings</a></li>
                            </ul>

                            <div class="tab-content">
                                <div>
                                    {{--                                <div class="tab-pane" id="usertimeline">--}}
                                    {{--                                    <div class="publisher publisher-multi bg-white b-1 mb-30">--}}
                                    {{--                                        <textarea class="publisher-input auto-expand" rows="4"--}}
                                    {{--                                                  placeholder="Write something"></textarea>--}}
                                    {{--                                        <div class="flexbox">--}}
                                    {{--                                            <div class="gap-items">--}}
                                    {{--                                                <span class="publisher-btn file-group">--}}
                                    {{--                                                    <i class="fa fa-image file-browser"></i>--}}
                                    {{--                                                    <input type="file">--}}
                                    {{--                                                </span>--}}
                                    {{--                                                <a class="publisher-btn" href="#"><i class="fa fa-map-marker"></i></a>--}}
                                    {{--                                                <a class="publisher-btn" href="#"><i class="fa fa-smile-o"></i></a>--}}
                                    {{--                                            </div>--}}

                                    {{--                                            <button class="btn btn-sm btn-bold btn-primary">Post</button>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}

                                    {{--                                    <div class="box b-1 no-shadow">--}}
                                    {{--                                        <div class="media bb-1 border-fade">--}}
                                    {{--                                            <img class="avatar avatar-lg"--}}
                                    {{--                                                 src="{{ asset('backend/assets/images/avatar/3.jpg') }}" alt="...">--}}
                                    {{--                                            <div class="media-body">--}}
                                    {{--                                                <p>--}}
                                    {{--                                                    <strong>Denial Webar</strong>--}}
                                    {{--                                                    <time class="float-end text-fade" datetime="2017">24 min ago</time>--}}
                                    {{--                                                </p>--}}
                                    {{--                                                <p><small>Designer</small></p>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}

                                    {{--                                        <div class="box-body bb-1 border-fade">--}}
                                    {{--                                            <p class="lead">Authoritatively syndicate goal-oriented leadership skills--}}
                                    {{--                                                for clicks-and-mortar outsourcing. Synergistically reconceptualize--}}
                                    {{--                                                enabled catalysts for change.</p>--}}

                                    {{--                                            <div class="gap-items-4 mt-10">--}}
                                    {{--                                                <a class="text-fade hover-light" href="#">--}}
                                    {{--                                                    <i class="fa fa-thumbs-up me-1"></i> 1254--}}
                                    {{--                                                </a>--}}
                                    {{--                                                <a class="text-fade hover-light" href="#">--}}
                                    {{--                                                    <i class="fa fa-comment me-1"></i> 25--}}
                                    {{--                                                </a>--}}
                                    {{--                                                <a class="text-fade hover-light" href="#">--}}
                                    {{--                                                    <i class="fa fa-share-alt me-1"></i> 12--}}
                                    {{--                                                </a>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}


                                    {{--                                        <div class="media-list media-list-divided bg-lighter">--}}
                                    {{--                                            <div class="media">--}}
                                    {{--                                                <a class="avatar" href="#">--}}
                                    {{--                                                    <img src="{{ asset('backend/assets/images/avatar/6.jpg') }}"--}}
                                    {{--                                                         alt="...">--}}
                                    {{--                                                </a>--}}
                                    {{--                                                <div class="media-body">--}}
                                    {{--                                                    <p>--}}
                                    {{--                                                        <a href="#"><strong>Rock Tele</strong></a>--}}
                                    {{--                                                        <time class="float-end text-fade" datetime="2017-07-14 20:00">--}}
                                    {{--                                                            Just now--}}
                                    {{--                                                        </time>--}}
                                    {{--                                                    </p>--}}
                                    {{--                                                    <p>Uniquely enhance world-class channels with just in time--}}
                                    {{--                                                        schemas.</p>--}}

                                    {{--                                                    <div class="media px-0 mt-20">--}}
                                    {{--                                                        <a class="avatar" href="#">--}}
                                    {{--                                                            <img src="{{ asset('backend/assets/images/avatar/8.jpg') }}"--}}
                                    {{--                                                                 alt="...">--}}
                                    {{--                                                        </a>--}}
                                    {{--                                                        <div class="media-body">--}}
                                    {{--                                                            <p>--}}
                                    {{--                                                                <a href="#"><strong>Brock Lensar</strong></a>--}}
                                    {{--                                                                <time class="float-end text-fade"--}}
                                    {{--                                                                      datetime="2017-07-14 20:00">26 mins ago--}}
                                    {{--                                                                </time>--}}
                                    {{--                                                            </p>--}}
                                    {{--                                                            <p>Thank you for your nice comment.</p>--}}
                                    {{--                                                        </div>--}}
                                    {{--                                                    </div>--}}

                                    {{--                                                </div>--}}
                                    {{--                                            </div>--}}

                                    {{--                                            <div class="media">--}}
                                    {{--                                                <a class="avatar" href="#">--}}
                                    {{--                                                    <img src="{{ asset('backend/assets/images/avatar/9.jpg') }}"--}}
                                    {{--                                                         alt="...">--}}
                                    {{--                                                </a>--}}
                                    {{--                                                <div class="media-body">--}}
                                    {{--                                                    <p>--}}
                                    {{--                                                        <a href="#"><strong>Tony Stark</strong></a>--}}
                                    {{--                                                        <time class="float-end text-fade" datetime="2017-07-14 20:00">2--}}
                                    {{--                                                            hours ago--}}
                                    {{--                                                        </time>--}}
                                    {{--                                                    </p>--}}
                                    {{--                                                    <p>Continually drive user friendly solutions through performance--}}
                                    {{--                                                        based infomediaries.</p>--}}
                                    {{--                                                </div>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}

                                    {{--                                        <form class="publisher bt-1 border-fade">--}}
                                    {{--                                            <img class="avatar avatar-sm"--}}
                                    {{--                                                 src="{{ asset('backend/assets/images/avatar/4.jpg') }}" alt="...">--}}
                                    {{--                                            <input class="publisher-input" type="text" placeholder="Add Your Comment">--}}
                                    {{--                                            <a class="publisher-btn" href="#"><i class="fa fa-smile-o"></i></a>--}}
                                    {{--                                            <span class="publisher-btn file-group">--}}
                                    {{--                                                <i class="fa fa-camera file-browser"></i>--}}
                                    {{--                                                <input type="file">--}}
                                    {{--                                            </span>--}}
                                    {{--                                        </form>--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <div class="box p-15">--}}
                                    {{--                                        <div class="timeline timeline-single-column timeline-single-full-column">--}}
                                    {{--                                            <span class="timeline-label">--}}
                                    {{--                                                <span class="badge badge-info badge-pill">Images</span>--}}
                                    {{--                                            </span>--}}

                                    {{--                                            <div class="timeline-item">--}}
                                    {{--                                                <div class="timeline-point timeline-point-success">--}}
                                    {{--                                                    <i class="fa fa-image"></i>--}}
                                    {{--                                                </div>--}}
                                    {{--                                                <div class="timeline-event">--}}
                                    {{--                                                    <div class="timeline-heading">--}}
                                    {{--                                                        <h4 class="timeline-title"><a href="#">Rakesh Kumar</a><small>--}}
                                    {{--                                                                uploaded new photos</small></h4>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                    <div class="timeline-body">--}}
                                    {{--                                                        <img src="{{ asset('backend/assets/images/150x100.png') }}"--}}
                                    {{--                                                             alt="..." class="m-10">--}}
                                    {{--                                                        <img src="{{ asset('backend/assets/images/150x100.png') }}"--}}
                                    {{--                                                             alt="..." class="m-10">--}}
                                    {{--                                                        <img src="{{ asset('backend/assets/images/150x100.png') }}"--}}
                                    {{--                                                             alt="..." class="m-10">--}}
                                    {{--                                                        <img src="{{ asset('backend/assets/images/150x100.png') }}"--}}
                                    {{--                                                             alt="..." class="m-10">--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                    <div class="timeline-footer">--}}
                                    {{--                                                        <p class="text-end"><i class="fa fa-clock-o"></i> 8 days ago</p>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                </div>--}}
                                    {{--                                            </div>--}}

                                    {{--                                            <div class="timeline-item">--}}
                                    {{--                                                <div class="timeline-point timeline-point-info">--}}
                                    {{--                                                    <i class="ion ion-chatbubble-working"></i>--}}
                                    {{--                                                </div>--}}
                                    {{--                                                <div class="timeline-event">--}}
                                    {{--                                                    <div class="timeline-heading">--}}
                                    {{--                                                        <h4 class="timeline-title"><a href="#">Jone Doe</a><small>--}}
                                    {{--                                                                commented on your post</small></h4>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                    <div class="timeline-body">--}}
                                    {{--                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.--}}
                                    {{--                                                            Repellendus numquam facilis enim eaque, tenetur nam id qui--}}
                                    {{--                                                            vel velit similique nihil iure molestias aliquam, voluptatem--}}
                                    {{--                                                            totam quaerat, magni commodi quisquam.</p>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                    <div class="timeline-footer">--}}
                                    {{--                                                        <a class="btn btn-success btn-sm" href="#">View comment</a>--}}
                                    {{--                                                        <p class="pull-right"><i class="fa fa-clock-o"></i> 8 days ago--}}
                                    {{--                                                        </p>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                </div>--}}
                                    {{--                                            </div>--}}

                                    {{--                                            <div class="timeline-item">--}}
                                    {{--                                                <div class="timeline-point timeline-point-danger">--}}
                                    {{--                                                    <i class="ion ion-ios-videocam"></i>--}}
                                    {{--                                                </div>--}}
                                    {{--                                                <div class="timeline-event">--}}
                                    {{--                                                    <div class="timeline-heading">--}}
                                    {{--                                                        <h4 class="timeline-title"><a href="#">Jone Doe</a><small>--}}
                                    {{--                                                                shared a video</small></h4>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                    <div class="timeline-body">--}}
                                    {{--                                                        <div class="ratio ratio-16x9">--}}
                                    {{--                                                            <iframe src="https://www.youtube.com/embed/k85mRPqvMbE"--}}
                                    {{--                                                                    frameborder="0" allowfullscreen></iframe>--}}
                                    {{--                                                        </div>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                    <div class="timeline-footer">--}}
                                    {{--                                                        <a class="btn btn-success btn-sm" href="#">View comment</a>--}}
                                    {{--                                                        <p class="pull-right"><i class="fa fa-clock-o"></i> 8 days ago--}}
                                    {{--                                                        </p>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                </div>--}}
                                    {{--                                            </div>--}}

                                    {{--                                            <span class="timeline-label">--}}
                                    {{--								                <button class="btn btn-danger"><i class="fa fa-clock-o"></i></button>--}}
                                    {{--							                </span>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}
                                    {{--                                </div>--}}
                                    <!-- /.tab-pane -->

                                    {{--                                <div class="active tab-pane" id="activity">--}}
                                    {{--                                    <div class="box no-shadow">--}}
                                    {{--                                        <!-- Post -->--}}
                                    {{--                                        <div class="post">--}}
                                    {{--                                            <div class="user-block">--}}
                                    {{--                                                <img class="img-bordered-sm rounded-circle"--}}
                                    {{--                                                     src="{{ asset("../images/user1-128x128.jpg") }}" alt="user image">--}}
                                    {{--                                                <span class="username">--}}
                                    {{--							                        <a href="#">Brayden</a>--}}
                                    {{--							                        <a href="#" class="pull-right btn-box-tool"><i--}}
                                    {{--                                                            class="fa fa-times"></i></a>--}}
                                    {{--							                    </span>--}}
                                    {{--                                                <span class="description">5 minutes ago</span>--}}
                                    {{--                                            </div>--}}
                                    {{--                                            <!-- /.user-block -->--}}
                                    {{--                                            <div class="activitytimeline">--}}
                                    {{--                                                <p>--}}
                                    {{--                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec--}}
                                    {{--                                                    odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla--}}
                                    {{--                                                    quis sem at nibh elementum imperdiet. Duis sagittis ipsum.--}}
                                    {{--                                                </p>--}}
                                    {{--                                                <ul class="list-inline">--}}
                                    {{--                                                    <li><a href="#" class="link-black text-sm"><i--}}
                                    {{--                                                                class="fa fa-share margin-r-5"></i> Share</a></li>--}}
                                    {{--                                                    <li><a href="#" class="link-black text-sm"><i--}}
                                    {{--                                                                class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>--}}
                                    {{--                                                    </li>--}}
                                    {{--                                                    <li class="pull-right">--}}
                                    {{--                                                        <a href="#" class="link-black text-sm"><i--}}
                                    {{--                                                                class="fa fa-comments-o margin-r-5"></i> Comments--}}
                                    {{--                                                            (5)</a></li>--}}
                                    {{--                                                </ul>--}}
                                    {{--                                                <form class="form-element">--}}
                                    {{--                                                    <input class="form-control input-sm" type="text"--}}
                                    {{--                                                           placeholder="Type a comment">--}}
                                    {{--                                                </form>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}
                                    {{--                                        <!-- /.post -->--}}

                                    {{--                                        <!-- Post -->--}}
                                    {{--                                        <div class="post">--}}
                                    {{--                                            <div class="user-block">--}}
                                    {{--                                                <img class="img-bordered-sm rounded-circle"--}}
                                    {{--                                                     src="{{ asset('backend/assets/images/user6-128x128.jpg') }}"--}}
                                    {{--                                                     alt="user image">--}}
                                    {{--                                                <span class="username">--}}
                                    {{--                                                    <a href="#">Evan</a>--}}
                                    {{--                                                    <a href="#" class="pull-right btn-box-tool"><i--}}
                                    {{--                                                            class="fa fa-times"></i></a>--}}
                                    {{--                                                </span>--}}
                                    {{--                                                <span class="description">5 minutes ago</span>--}}
                                    {{--                                            </div>--}}
                                    {{--                                            <!-- /.user-block -->--}}
                                    {{--                                            <div class="activitytimeline">--}}
                                    {{--                                                <div class="row mb-20">--}}
                                    {{--                                                    <div class="col-sm-6">--}}
                                    {{--                                                        <img class="img-fluid"--}}
                                    {{--                                                             src="{{ asset('backend/assets/images/photo1.png') }}"--}}
                                    {{--                                                             alt="Photo">--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                    <!-- /.col -->--}}
                                    {{--                                                    <div class="col-sm-6">--}}
                                    {{--                                                        <div class="row">--}}
                                    {{--                                                            <div class="col-sm-6">--}}
                                    {{--                                                                <img class="img-fluid"--}}
                                    {{--                                                                     src="{{ asset('backend/assets/images/photo2.png') }}"--}}
                                    {{--                                                                     alt="Photo">--}}
                                    {{--                                                                <br><br>--}}
                                    {{--                                                                <img class="img-fluid"--}}
                                    {{--                                                                     src="{{ asset('backend/assets/images/photo3.jpg') }}"--}}
                                    {{--                                                                     alt="Photo">--}}
                                    {{--                                                            </div>--}}
                                    {{--                                                            <!-- /.col -->--}}
                                    {{--                                                            <div class="col-sm-6">--}}
                                    {{--                                                                <img class="img-fluid"--}}
                                    {{--                                                                     src="{{ asset('backend/assets/images/photo4.jpg') }}"--}}
                                    {{--                                                                     alt="Photo">--}}
                                    {{--                                                                <br><br>--}}
                                    {{--                                                                <img class="img-fluid"--}}
                                    {{--                                                                     src="{{ asset('backend/assets/images/photo1.png') }}"--}}
                                    {{--                                                                     alt="Photo">--}}
                                    {{--                                                            </div>--}}
                                    {{--                                                            <!-- /.col -->--}}
                                    {{--                                                        </div>--}}
                                    {{--                                                        <!-- /.row -->--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                    <!-- /.col -->--}}
                                    {{--                                                </div>--}}
                                    {{--                                                <!-- /.row -->--}}

                                    {{--                                                <ul class="list-inline">--}}
                                    {{--                                                    <li><a href="#" class="link-black text-sm"><i--}}
                                    {{--                                                                class="fa fa-share margin-r-5"></i> Share</a></li>--}}
                                    {{--                                                    <li><a href="#" class="link-black text-sm"><i--}}
                                    {{--                                                                class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>--}}
                                    {{--                                                    </li>--}}
                                    {{--                                                    <li class="pull-right">--}}
                                    {{--                                                        <a href="#" class="link-black text-sm"><i--}}
                                    {{--                                                                class="fa fa-comments-o margin-r-5"></i> Comments--}}
                                    {{--                                                            (5)</a></li>--}}
                                    {{--                                                </ul>--}}

                                    {{--                                                <form class="form-element">--}}
                                    {{--                                                    <input class="form-control input-sm" type="text"--}}
                                    {{--                                                           placeholder="Type a comment">--}}
                                    {{--                                                </form>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}
                                    {{--                                        <!-- /.post -->--}}

                                    {{--                                        <!-- Post -->--}}
                                    {{--                                        <div class="post clearfix">--}}
                                    {{--                                            <div class="user-block">--}}
                                    {{--                                                <img class="img-bordered-sm rounded-circle"--}}
                                    {{--                                                     src="{{ asset('backend/assets/images/user7-128x128.jpg') }}"--}}
                                    {{--                                                     alt="user image">--}}
                                    {{--                                                <span class="username">--}}
                                    {{--                                                    <a href="#">Nicholas</a>--}}
                                    {{--                                                    <a href="#" class="pull-right btn-box-tool"><i--}}
                                    {{--                                                            class="fa fa-times"></i></a>--}}
                                    {{--                                                </span>--}}
                                    {{--                                                <span class="description">5 minutes ago</span>--}}
                                    {{--                                            </div>--}}
                                    {{--                                            <!-- /.user-block -->--}}
                                    {{--                                            <div class="activitytimeline">--}}
                                    {{--                                                <p>--}}
                                    {{--                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec--}}
                                    {{--                                                    odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla--}}
                                    {{--                                                    quis sem at nibh elementum imperdiet. Duis sagittis ipsum.--}}
                                    {{--                                                </p>--}}

                                    {{--                                                <form class="form-horizontal form-element">--}}
                                    {{--                                                    <div class="form-group row g-0">--}}
                                    {{--                                                        <div class="col-sm-9">--}}
                                    {{--                                                            <input class="form-control input-sm" placeholder="Response">--}}
                                    {{--                                                        </div>--}}
                                    {{--                                                        <div class="col-sm-3">--}}
                                    {{--                                                            <button type="submit"--}}
                                    {{--                                                                    class="btn btn-danger pull-right w-p100">Send--}}
                                    {{--                                                            </button>--}}
                                    {{--                                                        </div>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                </form>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}
                                    {{--                                        <!-- /.post -->--}}
                                    {{--                                    </div>--}}

                                    {{--                                </div>--}}
                                    {{--                                <!-- /.tab-pane -->--}}
                                </div>
                                <div class="active tab-pane" id="settings">
                                    @include('layouts.backend.notification')

                                    <div class="box no-shadow">
                                        <div class="d-flex mb-3">
                                            <div class="d-flex align-items-center">
                                                <div><strong>Username</strong></div>
                                                <div style="margin-left: 75%" class="admin-username">{{ $admin->username }}</div>
                                            </div>

                                            <div style="margin-left: 30%" class="d-flex align-items-center">
                                                <div><strong>Email</strong></div>
                                                <div style="margin-left: 10%" class="admin-username">{{ $admin->email }}</div>
                                            </div>
                                        </div>
                                        <form action="{{ route('admin.update') }}" method="post"
                                              enctype="multipart/form-data"
                                              class="form-horizontal form-element col-12">
                                            @csrf
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-2 form-label">Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="name"
                                                           value="{{ old('name', $admin->name ?? '') }}"
                                                           class="form-control {{ $errors->has('name') ? 'danger' : '' }}"
                                                           id="name"
                                                           placeholder="Please enter name here...">
                                                    @error('name')
                                                    <div class="form-control-feedback text-danger mt-1">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="phone" class="col-sm-2 form-label">Phone</label>

                                                <div class="col-sm-10">
                                                    <input type="tel"
                                                           class="form-control {{ $errors->has('phone') ? 'danger' : '' }}"
                                                           name="phone" id="phone"
                                                           value="{{ old('phone', $admin->phone) }}"
                                                           placeholder="Enter phone here...">
                                                    @error('phone')
                                                    <div class="form-control-feedback text-danger mt-1">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="address"
                                                       class="col-sm-2 form-label">Address</label>

                                                <div class="col-sm-10">
                                                    <textarea
                                                        class="form-control {{ $errors->has('address') ? 'danger' : '' }}"
                                                        name="address"
                                                        id="address"
                                                        placeholder="Enter address here...">{{ old('address', $admin->address ?? '') }}</textarea>
                                                    @error('address')
                                                    <div class="form-control-feedback text-danger mt-1">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row mb-30">
                                                <label for="photo" class="col-sm-2 form-label">Image</label>

                                                <div class="col-sm-10">
                                                    <input class="form-control"
                                                           accept="image/*"
                                                           type="file" id="photo" name="photo">
                                                </div>
                                                @error('image')
                                                <div class="form-control-feedback text-danger mt-1">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="form-group row">
                                                <div class="ms-auto col-sm-10">
                                                    <button type="submit" class="btn btn-success">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div>
                        <!-- /.nav-tabs-custom -->
                    </div>
                    <!-- /.col -->

                    <div class="col-12 col-lg-5 col-xl-4">
                        <div class="box box-widget widget-user">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="rounded p-15 h-200 bg-primary bg-temple-dark">
                                <h3 class="widget-user-username text-white">{{ $admin->name ?? "" }}</h3>
                                <h6 class="widget-user-desc text-white">
                                    Team - {{ $admin->currentTeam->name ?? "" }}
                                </h6>
                            </div>
                            <div class="widget-user-image">
                                @if(!empty($admin->image))
                                    <img class="rounded-circle"
                                         src="{{ asset(\Illuminate\Support\Facades\Storage::url('admins/' . $admin->image)) }}"
                                         alt="User Avatar">
                                @else
                                    <img class="rounded-circle"
                                         src="{{ asset('backend/assets/images/user3-128x128.jpg') }}"
                                         alt="User Avatar">
                                @endif
                            </div>
                        </div>
                        <div class="box">
                            <div class="box-body box-profile">
                                <div class="row">
                                    <div class="col-12">
                                        <div>

                                            <p>Email :<span class="text-gray ps-10">{{ $admin->email ?? '' }}</span></p>
                                            <p>
                                                Role :
                                                <span class="text-gray ps-10 badge badge-primary">
                                                    {{ $admin->roles->first()->name ?? 'No role assigned' }}
                                                </span>
                                            </p>
                                            <p>Phone :<span class="text-gray ps-10">{{ $admin->phone ?? "" }}</span></p>
                                            <p>
                                                Address :
                                                <span class="text-gray ps-10">
                                                    {{ $admin->address ?? "" }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>
    </div>
    <!-- /.content-wrapper -->
@endsection
