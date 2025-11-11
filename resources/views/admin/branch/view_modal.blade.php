<div aria-hidden="true" class="modal fade in" id="view-modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header faded smaller">
                <div class="modal-title"><span>View Branch</span></div>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
            </div>
            <div class="modal-body">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Branch</label>
                            <input class="form-control" id="view_branch_type" placeholder="Enter branch name" readonly type="text">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for=""> Branch Name</label>
                            <input class="form-control" id="view_branch_name" placeholder="Enter branch name" readonly type="text">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label> Branch Address</label>
                    <textarea class="form-control" id="view_branch_address" readonly></textarea>
                </div>

                <fieldset class="form-group">
                    <legend><span>Owner's Information</span></legend>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""> First Name</label>
                                <input class="form-control" id="view_owner_first_name" data-error="Please input your First Name" placeholder="First Name" readonly type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Last Name</label>
                                <input class="form-control" id="view_owner_last_name" data-error="Please input your Last Name" placeholder="Last Name" readonly type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""> Telephone Number</label>
                                <input class="form-control" id="view_owner_tel_num" data-error="Please input telephone number" placeholder="Telephone Number" readonly type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Mobile Number</label>
                                <input class="form-control" id="view_owner_mobile_num" data-error="Please input mobile number" placeholder="Last Name" readonly type="text">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for=""> Email Address</label>
                        <input class="form-control" id="view_owner_email" placeholder="Enter email address" readonly type="email">
                    </div>

                    <div class="form-group">
                        <label> Complete Address</label>
                        <textarea class="form-control" id="view_owner_addr" readonly></textarea>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>
