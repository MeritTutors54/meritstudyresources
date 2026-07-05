<td class="text-center">
    @can('editPastPaper', Auth::user())
        <a href="{{ route('admin.past-papers.edit', [$data]) }}">
            <i class="fa fa-edit" aria-hidden="true"></i>
        </a>
    @endcan

    @can('deletePastPaper', Auth::user())
        <button type="button" data-route="{{ route('admin.past-papers.destroy', [$data]) }}" data-name="{{ $data->title }}"
            data-id="{{ $data->id }}" class="dltButtonCustom btn bg-transparent p-0 ms-2">
            <i class="fa fa-trash-o text-danger" aria-hidden="true"></i>
        </button>
    @endcan

</td>

<script>
    $('.dltButtonCustom').on('click', function() {
        
        let url = $(this).data('route');
        
        let rowElement = $(this).closest('tr');

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: "post", // Capitalizing HTTP methods is standard practice
                    data: {
                        _method: 'DELETE', // Laravel will read this and spoof a DELETE request
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        if (response.success) {
                            rowElement.fadeOut(500, function() {
                                $(this).remove();
                            });
                        } else {
                            alert(response.message || 'Could not delete item.');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr); // Log error for easier debugging
                        alert('Something went wrong. Please try again.');
                    }
                });
            }
        });
    });
</script>
