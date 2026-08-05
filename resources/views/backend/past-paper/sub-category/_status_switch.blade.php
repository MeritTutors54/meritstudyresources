<td class="text-center">
    @can('updatePastPaperSubcategory', Auth::user())
        <label class="switch">
            <input type="checkbox" class="statusSwitch"
                   id="togProp-{{ $data->id }}"
                   data-id="{{ $data->id }}"
                {{ $data->is_active == 1 ? "checked" : "" }}>
            <div class="slider round"><!--ADDED HTML -->
                <span class="on">Active</span>
                <span class="off">Inactive</span><!--END-->
            </div>
        </label>
    @else
        @if($data->is_active == \App\Enums\Status::ACTIVE->value)
            <span class="badge badge-success font-weight-bold">Active</span>
        @else
            <span
                class="badge badge-danger text-white">Inactive</span>
        @endif
    @endcan
</td>
