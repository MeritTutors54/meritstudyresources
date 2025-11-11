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
                    <div>Password Change</div>
                </div>
                <div class="page-title-actions">


                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <form action="{{route('admin.password.change')}}" method="POST" enctype='multipart/form-data'>
                @csrf

                        <div class="card shadow-sm shadow-showcase">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Password Change Content</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-3 text-right">
                                        <div class="form-group">
                                            <label for="fname">Old Password: <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                      <div class="col-md-8">
                                          <div class="form-group">
                                              <input type="password" class="form-control" name="oldpass" placeholder="Old Password"/>
                                              @error('oldpass')
                                                  <div style="color:red">{{ $message }}</div>
                                              @enderror
                                          </div>
                                      </div>
                                      <div class="col-md-3 text-right">
                                          <div class="form-group">
                                              <label for="fname">New Password: <span style="color:red">*</span></label>
                                              <input type="hidden" name="id" value="{{Auth::user()->id}}">
                                          </div>
                                      </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <input type="password" class="form-control" name="password" placeholder="New Password"/>
                                                @error('password')
                                                    <div style="color:red">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-right">
                                            <div class="form-group">
                                                <label for="fname">Confirm Password: <span style="color:red">*</span></label>
                                            </div>
                                        </div>
                                          <div class="col-md-8">
                                              <div class="form-group">
                                                  <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password"/>
                                                  @error('password_confirmation')
                                                      <div style="color:red">{{ $message }}</div>
                                                  @enderror
                                              </div>
                                          </div>




                                        <div class="col-md-3">

                                        </div>
                                        <div class="col-md-8 text-center">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success" name="button">Change Password</button>
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
