@extends('layouts.backend')
@section('content')
<style>
label {
    
    margin-bottom: .5rem;
    font-size: 16px;
    font-weight: 600;
}
</style>
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display1 icon-gradient bg-premium-dark">
                    </i>
                </div>
                <div>Subscription</div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <a href="{{route('admin.subscription.index')}}">    <button type="button"  class="btn-shadow dropdown-toggle btn btn-info">
                            All Subscription
                        </button>
                        </a>
                    </div>
            </div>    
        </div>
    </div>      
    <div class="row">
        <div class="col-md-8">
            <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Subscription Update</h5>
                    <div>
                    <form action="{{url('/admin/subscription/update')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="position-relative form-group"><label for="exampleFile" class="">Title</label>
                            <input type="text" class="form-control" name="title"  placeholder="Enter Subscription Title" required value="{{ $edit->title }}">
                            <input type="hidden" name="id" value="{{ $edit->id }}">
                            
                        </div>
                        <br>
                        <div class="position-relative form-group"><label for="exampleFile" class="">Sub Title</label>
                            <input type="text" class="form-control" name="sub_title"  placeholder="Enter Subscription Sub Title" required value="{{ $edit->sub_title }}">
                        </div>
                        <br>
                        <div class="position-relative form-group">
                            <label for="exampleFile" class="">Subscription Type</label>
                            <select class="form-control" name="subscription_type" required>
                                <option disabled selected>Select</option>
                                <option value="1" @if($edit->subscription_type==1) selected @endif>Monthy</option>
                                <option value="2" @if($edit->subscription_type==2) selected @endif>Yearly</option>
                               
                            </select>
                        </div>
                        
                        <br>
                        <div class="position-relative form-group"><label for="exampleFile" class="">Price</label>
                            <input type="number" class="form-control" name="price" placeholder="Enter Subscription Price" required value="{{ $edit->price }}">
                        </div>
                        <br>
                        <br>
                        <div class="position-relative form-group">
                            <label for="exampleFile" class="">Type</label>
                            <select class="form-control" name="type" required>
                                <option disabled selected>Select</option>
                                @foreach ($allSubType as $type)
                                <option value="{{ $type->id }}" @if($edit->type==$type->id) selected @endif>{{ $type->type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <div class="position-relative form-group"><label for="exampleFile" class="">Stripe ID</label>
                            <input type="text" class="form-control" name="stripe_id"  placeholder="Enter Subscription stripe_id" required value="{{ $edit->stripe_id }}">
                        </div>
                        <br>
                        @foreach(json_decode($edit->access_details) as $mainaccess)
                        <div class="position-relative form-group asif"><label for="exampleFile" class="">Access Details</label>
                            <input type="text" class="form-control" name="access_details[]"  placeholder="Enter Access Details" required value="{{ $mainaccess }}"> 
                            <a onclick="deleterow(this)" style="color:red; cursor:pointer;">Delete</a>
                        </div>
                        @endforeach
                        <br>
                        <div class="position-relative form-group" id="main_access_section">
                         
                           
                        </div>
                        <div class="position-relative form-group text-right">
                           
                           <button class="btn-sm btn-warning" type="button" onclick="addmore()">Add More</button>
                        </div>

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

<script>
function addmore(){
    $("#main_access_section").append('<div class="position-relative form-group asif"><label for="exampleFile" class="">Access Details</label><input type="text" class="form-control" name="access_details[]"  placeholder="Enter Access Details" required><a onclick="deleterow(this)" style="color:red; cursor:pointer;">Delete</a></div>')
}
function deleterow(em) {
$(em).closest(".asif").remove();
}
</script>

@endsection