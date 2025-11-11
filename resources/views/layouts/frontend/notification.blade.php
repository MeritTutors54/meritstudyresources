@if(Session::has('error'))
    <div class="alert alert-danger icons-alert">
        <p class="m-0"><strong>Error!</strong> {{ Session::get('error') }}</p>
    </div>
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger icons-alert">
            <p class="m-0"><strong>Error!</strong> {{ $error }}</p>
        </div>
    @endforeach
@endif

@if(Session::has('success'))
    <div class="alert alert-success background-success">
        <p class="m-0"><strong>Success!</strong> {{ Session::get('success') }}</p>
    </div>
@endif

@if(Session::has('status'))
    <div class="alert alert-success background-success">
        <p class="m-0">{{ Session::get('status') }}</p>
    </div>
@endif
