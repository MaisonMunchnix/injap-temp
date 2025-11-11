<div aria-hidden="true" class="modal fade in" id="edit-branch-modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="" method="post" id="edit_branch">
                <div class="modal-header faded smaller">
                    <div class="modal-title"><span>Edit Branch</span></div>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for=""> Select Branch Type</label>
                                <input type="hidden" id="edit_id" required>
                                <select class="form-control edit_req_fields" id="edit_branch_type" required>
                                    <option value="">Select State</option>
                                    <option value="co">Company Owned</option>
                                    <option value="bo">BO</option>
                                    <option value="stockist">Stockist</option>
                                </select>
                                <div class="help-block form-text with-errors form-control-feedback"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for=""> Branch Name</label>
                                <input class="form-control edit_req_fields" id="edit_branch_name" placeholder="Enter branch name" required="required" type="text">
                                <div class="help-block form-text with-errors form-control-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label> Branch Address</label>
                        <textarea class="form-control edit_req_fields" id="edit_branch_address" required="required"></textarea>
                        <div class="help-block form-text with-errors form-control-feedback"></div>
                    </div>

                    <fieldset class="form-group">
                        <legend><span>Owner's Information</span></legend>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for=""> First Name</label>
                                    <input class="form-control edit_req_fields" id="edit_owner_first_name" data-error="Please input your First Name" placeholder="First Name" required="required" type="text">
                                    <div class="help-block form-text with-errors form-control-feedback"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Last Name</label>
                                    <input class="form-control edit_req_fields" id="edit_owner_last_name" data-error="Please input your Last Name" placeholder="Last Name" required="required" type="text">
                                    <div class="help-block form-text with-errors form-control-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for=""> Telephone Number</label>
                                    <input class="form-control edit_req_fields" id="edit_owner_tel_num" data-error="Please input telephone number" placeholder="Telephone Number" required="required" type="text">
                                    <div class="help-block form-text with-errors form-control-feedback"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Mobile Number</label>
                                    <input class="form-control edit_req_fields" id="edit_owner_mobile_num" data-error="Please input mobile number" placeholder="Last Name" required="required" type="text">
                                    <div class="help-block form-text with-errors form-control-feedback"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for=""> Email Address</label>
                            <input class="form-control edit_req_fields" id="edit_owner_email" placeholder="Enter email address" required="required" type="email">
                            <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>

                        <div class="form-group">
                            <label> Complete Address</label>
                            <textarea class="form-control edit_req_fields" id="edit_owner_addr"></textarea>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer buttons-on-left">
                    <button class="btn btn-primary" type="submit"> Update Branch</button>
                    <button class="btn btn-link" data-dismiss="modal" type="button"> Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
