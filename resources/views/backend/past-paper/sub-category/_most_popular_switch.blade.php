<td class="text-center">
    <label class="switch">
        <input type="checkbox" class="subjectSwitch"
               id="togProp-{{ $data->id }}"
               data-id="{{ $data->id }}"
            {{ $data->most_popular == 1 ? "checked" : "" }}>
        <div class="slider round"><!--ADDED HTML -->
            <span class="on">Yes</span>
            <span class="off">No</span><!--END-->
        </div>
    </label>
</td>
