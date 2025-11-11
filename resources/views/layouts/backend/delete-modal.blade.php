
<div id="dltModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    Are you want to delete <span id="element-name" class="font-weight-bold text-danger"></span>?</p>
                </div>
            </div>
            <div class="modal-footer d-flex pt-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <form method="POST" id="set-action" class="ms-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger d-inline" id="modalBtnDelete">
                        <i class="align-middle feather-fix" data-feather="trash"></i>
                        Delete
                    </button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
