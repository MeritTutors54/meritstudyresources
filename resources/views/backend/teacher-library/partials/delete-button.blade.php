{{-- @include('backend.teacher-library.partials.delete-button', ['route' => ..., 'name' => ...]) — needs delete-script once per page --}}
<button type="button"
        data-route="{{ $route }}"
        data-name="{{ $name }}"
        class="dltButton btn bg-transparent p-0 ms-2" title="Delete">
    <i class="fa fa-trash-o text-danger" aria-hidden="true"></i>
</button>
