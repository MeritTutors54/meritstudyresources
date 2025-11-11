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
                                    <div>Logo Update</div>
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
                           
                            <div class="col-md-6">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Update Logo</h5>
                                        <div>
                                        <form action="{{url('admin/logo/update')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                          <div class="position-relative form-group"><label for="exampleFile" class="">Logo</label>
                                                <input name="logo" id="" type="file" class="form-control-file">
                                                <input name="id"  type="hidden" value="{{$data->id}}">
                                               <small class="form-text text-muted">You Can Update This Logo Image</small>
                                          </div>
                                            <br>
                                            <div class="position-relative form-group"><label for="exampleFile" class="">Fav Icon</label>
                                                <input name="favicon" id="" type="file" class="form-control-file">
                                               <small class="form-text text-muted">You Can Update This Fav Icon</small>
                                          </div>
                                            <br>
                                            <div class="position-relative form-group"><label for="exampleFile" class="">LazyLoader</label>
                                               <input name="Lazy_loader" id="" type="file" class="form-control-file">
                                               <small class="form-text text-muted">You Can Update This Lazy Loader</small>
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
                           
                            <div class="col-lg-6">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">All Image</h5>
                                        <table class="mb-0 table table-sm">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Logo</th>
                                                <th>Fav Icon</th>
                                                <th>Lazy Loader</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <th scope="row">#</th>
                                                <td><img src="{{asset('uploads/logo/'.$data->logo)}}" alt="logo" height="35px"></td>
                                                <td><img src="{{asset('uploads/logo/'.$data->favicon)}}" alt="logo"  height="25px"></td>
                                                <td><img src="{{asset('uploads/logo/'.$data->lazyloader)}}" alt="logo"  height="35px"></td>
                                            </tr>
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                           

                        </div>
                          
                        
                    </div>
@endsection