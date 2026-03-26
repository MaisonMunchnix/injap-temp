<div class="modal" tabindex="-1" role="dialog" id="hold_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hold Reimbursement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="upgrade_code">Reasons for hold (not required)</label>
                                <input class="form-control" id="hold_reason" placeholder="Enter here" type="text" value="">
                                <span class="text-danger d-none display-error">Error</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-hold">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
