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
                <div>Terms & Condition Manage</div>
            </div>
            <div class="page-title-actions">
             
            </div>    
        </div>
    </div>      
    <div class="row">
        <div class="col-md-6">
            <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Terms & Condition  Manage</h5>
                    <div>
                    <form action="{{url('/admin/terms-condition/update')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="position-relative form-group"><label for="exampleFile" class="">Terms Condition</label>
                            <textarea type="text" class="form-control" name="privacy_policy"  placeholder="Enter Terms Condition">{{ $edit->value }}</textarea>
                            <input type="hidden" name="id" value="{{ $edit->id }}">
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