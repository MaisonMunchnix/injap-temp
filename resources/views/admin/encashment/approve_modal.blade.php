<div class="modal" tabindex="-1" role="dialog" id="approve_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve request encashment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="upgrade_code">Amount requested</label>
                                <input class="form-control approve-input" id="amt_request" placeholder="Enter product code" type="number" value="" disabled>
                                <span class="text-danger d-none display-error">Error</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="upgrade_pin">Amount to be approve</label>
                                <input class="form-control approve-input" id="amt_approve" placeholder="Enter pin" type="number" value="">
                                <span class="text-danger d-none display-error"></span>
                            </div>
                        </div>
                        <div class="col-sm-12 d-none" id="up-error">
                            <div class="form-group">
                                <div class="alert alert-danger" role="alert"><strong>Warning! </strong>Please check empty or invalid fields.</div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary pull-right" id="btn-approve">Submit</button>
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-approve">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
