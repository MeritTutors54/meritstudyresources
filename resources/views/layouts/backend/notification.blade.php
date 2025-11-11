

@if(Session::has('success'))
    <div class="alert alert-success">
        <strong>Success!</strong> {{ Session::get('success') }}
    </div>
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger">
            <strong>Error!</strong> {{ $error }}
        </div>
    @endforeach
@endif

@if(Session::has('error'))
    <div class="alert alert-danger">
        <strong>Error!</strong> {{ Session::get('error') }}
    </div>
@endif
