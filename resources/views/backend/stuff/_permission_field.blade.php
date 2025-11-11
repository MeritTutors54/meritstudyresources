<div>
    <style>
        input[type="checkbox"].filled-in:checked:disabled.chk-col-primary + label:after {
            background-color: #63676e !important; /* ash */
            border-color: #63676e !important;
            cursor: not-allowed;
        }

    </style>

    <div class="box-body">
        <div class="row">
            @if(!empty($permissions))
                @foreach($permissions as $title => $subPermission)
                    <div class="col-md-3 mb-35">
                        <h5 class="text-decoration-underline">{{ ucfirst($title) }}</h5>
                        @foreach($subPermission as $k => $permission)
                            <div class="mt-3 permission-field">
                                @php
                                    $attribute = '';
                                    if (in_array($permission, $roleHasPermission)) {
                                        $attribute = 'checked disabled';
                                    } else {
                                        if (in_array($permission, $modelHasPermission)) {
                                            $attribute = 'checked';
                                        }
                                    }
                                @endphp


                                <input type="checkbox" id="md_checkbox_{{ $title }}_{{ $k }}"
                                       {{ $attribute }}
                                       name="permissions[]"
                                       value="{{ $permission }}"
                                       class="filled-in chk-col-primary">
                                <label
                                    for="md_checkbox_{{ $title }}_{{ $k }}"> {{ $permission }}</label>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <a href="{{ route('admin.stuffs.index') }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-success pull-right">Submit</button>
    </div>
</div>
