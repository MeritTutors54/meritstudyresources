@extends('layouts.backend')
@section('content')
@php
date_default_timezone_set("asia/dhaka");
$current = date("m/d/Y");
@endphp
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-display1 icon-gradient bg-premium-dark">
                        </i>
                    </div>
                    <div>Profile Update Change</div>
                </div>
                <div class="page-title-actions">


                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <form action="{{route('admin.profileupdate.change')}}" method="POST" enctype='multipart/form-data'>
                @csrf

                        <div class="card shadow-sm shadow-showcase">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Profile Update Content</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 text-right">
                                        <div class="form-group">
                                            <label for="fname">User Name: <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="user_name" placeholder="Enter User Name" value="{{$edit->user_name ?? ''}}"/>
                                            @error('user_name')
                                                <div style="color:red">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-right">
                                        <div class="form-group">
                                            <label for="fname">Name: <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="name" placeholder="Enter Name" value="{{$edit->name ?? ''}}"/>
                                            @error('user_name')
                                                <div style="color:red">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-right">
                                        <div class="form-group">
                                            <label for="fname">Email: <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                      <div class="col-md-8">
                                          <div class="form-group">
                                              <input type="text" class="form-control" name="email" placeholder="Enter Email" value="{{$edit->email ?? ''}}"/>
                                              @error('email')
                                                  <div style="color:red">{{ $message }}</div>
                                              @enderror
                                          </div>
                                      </div>
                                      <div class="col-md-3 text-right">
                                          <div class="form-group">
                                              <label for="fname">Address:</label>
                                              <input type="hidden" name="id" value="{{ $edit->id}}">
                                          </div>
                                      </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <textarea type="text" class="form-control" name="address">{{ $edit->address}}</textarea>
                                            </div>
                                        </div>
                                          <div class="col-md-3 text-right">
                                              <div class="form-group">
                                                  <label for="fname">Photo: </label>
                                              </div>
                                          </div>
                                          <div class="col-md-8">
                                              <div class="form-group">
                                                  <input type="file" name="image"/>
                                              </div>
                                          </div>
                                          

                                        <div class="col-md-8 text-center">
                                                <img src="{{asset('uploads/'.$edit->image)}}" height="45px" alt="">
                                        </div>
                                        <div class="col-md-8"></div>
                                        <div class="col-md-8 text-center mt-3">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success" name="button">Update</button>
                                            </div>
                                        </div>
                                      </div>
                                  </div>
                                </div>
                            </form>
                          </div>
                       </div>
                    </div>
                  </div>
                </div>



@endsection
