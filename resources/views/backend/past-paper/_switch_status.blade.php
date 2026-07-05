<td class="text-center">
    @can('editPastPaper', Auth::user())
        <label class="switch">
            <input type="checkbox" class="statusSwitch" data-id="{{$data->id}}"
                id="togProp-{{$data->id}}" {{$checked}}>
            <div class="slider round">
                <span class="on">Active</span>
                <span class="off">Inactive</span>
            </div>
        </label>
    @else
        <span class="badge badge-{{ $data->is_active == 1 ? 'success' : 'danger' }}">
            {{ $data->is_active == 1 ? 'Active' : 'Inactive' }}
        </span>
    @endcan
</td>
