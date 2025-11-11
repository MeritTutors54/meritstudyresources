@extends('layouts.backend')
@section('content')
<div class="app-main__inner">
                        <div class="app-page-title">
                            <div class="page-title-wrapper">
                                <div class="page-title-heading">
                                    <div class="page-title-icon">
                                        <i class="pe-7s-display1 icon-gradient bg-premium-dark">
                                        </i>
                                    </div>
                                    <div>Social Update</div>
                                </div>
                                <div class="page-title-actions">
                                    <button type="button" data-toggle="tooltip" title="Example Tooltip" data-placement="bottom" class="btn-shadow mr-3 btn btn-dark">
                                        <i class="fa fa-star"></i>
                                    </button>
                                    <div class="d-inline-block dropdown">
                                        <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-info">
                                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                                <i class="fa fa-business-time fa-w-20"></i>
                                            </span>
                                            Buttons
                                        </button>
                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">
                                                        <i class="nav-link-icon lnr-inbox"></i>
                                                        <span>
                                                            Inbox
                                                        </span>
                                                        <div class="ml-auto badge badge-pill badge-secondary">86</div>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">
                                                        <i class="nav-link-icon lnr-book"></i>
                                                        <span>
                                                            Book
                                                        </span>
                                                        <div class="ml-auto badge badge-pill badge-danger">5</div>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">
                                                        <i class="nav-link-icon lnr-picture"></i>
                                                        <span>
                                                            Picture
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a disabled href="javascript:void(0);" class="nav-link disabled">
                                                        <i class="nav-link-icon lnr-file-empty"></i>
                                                        <span>
                                                            File Disabled
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>    
                                
                            </div>
                        </div>            
                     
                  
                      
                        <div class="row">
                            
                            <div class="col-md-10">
                                <div class="main-card mb-3 card">
                                        <div class="card-body">
                                            <h5 class="card-title">Update Social Link</h5>
                                        <div>
                                        <form action="{{route('admin.social.update')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                          <div class="position-relative form-group">
                                                <label for="fname">FaceBook :</label>
                                                <input type="text" class="form-control" name="facebook" id="fname" placeholder="FaceBook" value="{{$social->facebook}}">
                                                <input type="hidden" name="id" value="{{$social->id}}">
                                          </div>
                                            <br>
                                            <div class="position-relative form-group">
                                            <label for="lname">Twitter:</label>
                                            <input type="text" class="form-control" name="twitter" id="lname" placeholder="Twitter Number" value="{{$social->twitter}}">
                                          </div>
                                            <br>
                                            <div class="position-relative form-group">
                                            <label for="uname">Linkend:</label>
                                       <input type="text" class="form-control" name="linkend" id="uname" placeholder="Linkend" value="{{$social->linkend}}">
                                          </div>
                                          <br>
                                            <div class="position-relative form-group">
                                            <label for="uname">Youtube:</label>
                                       <input type="text" class="form-control" name="youtube" id="uname" placeholder="Youtube" value="{{$social->youtube}}">
                                            </div>
                                            <br>
                                            <div class="position-relative form-group">
                                            <label for="cname">Feed :</label>
                                        <input type="text" class="form-control" name="feed" id="uname" placeholder="Feed" value="{{$social->feed}}">
                                            </div>
                                            <br>
                                            <div class="position-relative form-group">
                                            <label for="dob">Google-Plus :</label>
                                       <input type="text" class="form-control" name="google_plus" id="uname" placeholder="Google-Plus" value="{{$social->google_plus}}">
                                            </div>
                                            <br>
                                            <div class="input-group">
                                                <button type="submit" class="mb-2 mr-2 btn btn-success">Update</button>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
@endsection