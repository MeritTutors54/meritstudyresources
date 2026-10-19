<script>
    $(document).on('click', '.dltButton', function () {
        $('#set-action').attr('action', $(this).data('route'));
        $('#element-name').text($(this).data('name'));
        $('#dltModal').modal('show');
    });
</script>
