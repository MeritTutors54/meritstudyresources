<footer class="main-footer">
    <div class="pull-right d-none d-sm-inline-block">
        <ul class="nav nav-primary nav-dotted nav-dot-separated justify-content-center justify-content-md-end">
            <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)">FAQ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"
                   href="https://themeforest.net/item/eduadmin-responsive-bootstrap-admin-template-dashboard/29365133"
                   target="_blank">Purchase Now</a>
            </li>
        </ul>
    </div>
    &copy; 2024 <a href="https://www.multipurposethemes.com/">Multipurpose Themes</a>. All Rights Reserved.
</footer>

<style>
    #updateTrackModal .modal-content{
        width: 35vw;
    }
    #updateTrackModal .modal-dialog {
        margin-left: 33%;
    }
</style>

<div id="updateTrackModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" style="display: none;"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" id="set-action" class="ms-3">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Update Tracking Information</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Status</label>

                        @if(!empty($orderStatuses))
                            <select
                                name="status"
                                class="form-select">
                                @foreach($orderStatuses as $status)
                                    @if($order->latest_tracking_status != $status->value)
                                        <option value="{{ $status->value }}">{{ ucfirst(strtolower($status->name)) }}</option>
                                    @endif
                                @endforeach
                            </select>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Remarks</label>
                        <textarea
                            name="remarks"
                            rows="5" class="form-control" placeholder="About Project"
                        ></textarea>
                    </div>
                </div>
                <div class="modal-footer d-flex pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success d-inline" id="modalBtnDelete">
                        Update
                    </button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
