<td class="text-center">
    @can('editPastPaper', Auth::user())
        <a href="{{ route('admin.past-papers.edit', [$data]) }}">
            <i class="fa fa-edit" aria-hidden="true"></i>
        </a>
    @endcan

    @can('deletePastPaper', Auth::user())
        <button type="button"
                data-route="{{ route('admin.past-papers.destroy', [$data]) }}"
                data-name="{{ $data->title }}"
                class="dltButton btn bg-transparent p-0 ms-2">
            <i class="fa fa-trash-o text-danger" aria-hidden="true"></i>
        </button>
    @endcan
</td>
