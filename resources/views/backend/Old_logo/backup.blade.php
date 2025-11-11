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
                                    <div>Logo Update
                                      
                                    </div>
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
                                    <div class="card-body"><h5 class="card-title">Input Groups</h5>
                                        <div>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text">@</span></div>
                                                <input placeholder="username" type="text" class="form-control"></div>
                                            <br>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><input aria-label="Checkbox for following text input" type="checkbox" class=""></span></div>
                                                <input placeholder="Check it out" type="text" class="form-control"></div>
                                            <br>
                                            <div class="input-group"><input placeholder="username" type="text" class="form-control">
                                                <div class="input-group-append"><span class="input-group-text">@example.com</span></div>
                                            </div>
                                            <br>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text">$</span><span class="input-group-text">$</span></div>
                                                <input placeholder="Dolla dolla billz yo!" type="text" class="form-control">
                                                <div class="input-group-append"><span class="input-group-text">$</span><span class="input-group-text">$</span></div>
                                            </div>
                                            <br>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                                <input placeholder="Amount" step="1" type="number" class="form-control">
                                                <div class="input-group-append"><span class="input-group-text">.00</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Input Group Button Dropdown</h5>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle btn btn-secondary">Button Dropdown</button>
                                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu"><h6 tabindex="-1" class="dropdown-header">Header</h6>
                                                    <button type="button" disabled="" tabindex="-1" class="disabled dropdown-item">Action</button>
                                                    <button type="button" tabindex="0" class="dropdown-item">Another Action</button>
                                                    <div tabindex="-1" class="dropdown-divider"></div>
                                                    <button type="button" tabindex="0" class="dropdown-item">Another Action</button>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control"></div>
                                    </div>
                                </div>
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Input Group Button Shorthand</h5>
                                        <div>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button class="btn btn-secondary">To the Left!</button>
                                                </div>
                                                <input type="text" class="form-control"></div>
                                            <br>
                                            <div class="input-group"><input type="text" class="form-control">
                                                <div class="input-group-append">
                                                    <button class="btn btn-secondary">To the Right!</button>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button class="btn btn-danger">To the Left!</button>
                                                </div>
                                                <input placeholder="and..." type="text" class="form-control">
                                                <div class="input-group-append">
                                                    <button class="btn btn-success">To the Right!</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Input Group Sizing</h5>
                                        <div>
                                            <div class="input-group input-group-lg">
                                                <div class="input-group-prepend"><span class="input-group-text">@lg</span></div>
                                                <input type="text" class="form-control"></div>
                                            <br>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text">@normal</span></div>
                                                <input type="text" class="form-control"></div>
                                            <br>
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend"><span class="input-group-text">@sm</span></div>
                                                <input type="text" class="form-control"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Input Group Addon</h5>
                                        <div>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text">To the Left!</span></div>
                                                <input type="text" class="form-control"></div>
                                            <br>
                                            <div class="input-group"><input type="text" class="form-control">
                                                <div class="input-group-append"><span class="input-group-text">To the Right!</span></div>
                                            </div>
                                            <br>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text">To the Left!</span></div>
                                                <input placeholder="and..." type="text" class="form-control">
                                                <div class="input-group-append"><span class="input-group-text">To the Right!</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Input Group Button</h5>
                                        <div>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button class="btn btn-secondary">I'm a button</button>
                                                </div>
                                                <input type="text" class="form-control"></div>
                                            <br>
                                            <div class="input-group"><input type="text" class="form-control">
                                                <div class="input-group-append">
                                                    <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle btn btn-secondary">Button Dropdown</button>
                                                    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu"><h6 tabindex="-1" class="dropdown-header">Header</h6>
                                                        <button type="button" disabled="" tabindex="-1" class="disabled dropdown-item">Action</button>
                                                        <button type="button" tabindex="0" class="dropdown-item">Another Action</button>
                                                        <div tabindex="-1" class="dropdown-divider"></div>
                                                        <button type="button" tabindex="0" class="dropdown-item">Another Action</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button class="btn btn-outline-secondary">Split Button</button>
                                                    <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle dropdown-toggle-split btn btn-outline-secondary"><span
                                                            class="sr-only">Toggle Dropdown</span></button>
                                                    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu"><h6 tabindex="-1" class="dropdown-header">Header</h6>
                                                        <button type="button" disabled="" tabindex="-1" class="disabled dropdown-item">Action</button>
                                                        <button type="button" tabindex="0" class="dropdown-item">Another Action</button>
                                                        <div tabindex="-1" class="dropdown-divider"></div>
                                                        <button type="button" tabindex="0" class="dropdown-item">Another Action</button>
                                                    </div>
                                                </div>
                                                <input placeholder="and..." type="text" class="form-control">
                                                <div class="input-group-append">
                                                    <button class="btn btn-secondary">I'm a button</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                          
                        
                    </div>
@endsection