<td>
    @can('updatePastPaperSubcategory', Auth::user())
        <a href="{{ route('admin.sub-categories.edit', [$data])}}">
            <i class="fa fa-edit" aria-hidden="true"></i>
        </a>
    @endcan

    @can('deletePastPaperSubcategory')
        <button type="button"
                data-route="{{ route('admin.sub-categories.destroy', [$data->id]) }}"
                data-name="{{ $data->subcategory_name }} of {{ $data->category->category_name }}"
                class="dltButton btn bg-transparent p-0 ms-2">
            <i class="fa fa-trash-o text-danger"
               aria-hidden="true"></i>
        </button>
    @endcan
</td>
