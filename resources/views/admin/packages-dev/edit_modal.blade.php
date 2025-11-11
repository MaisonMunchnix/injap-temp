<div id="edit-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="add-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" action="" id="update_form">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-modal-title">Edit Package</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> <!-- // END .modal-header -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Type</label>
                                <input type="hidden" id="edit_id" name="id" required>
                                <input class="form-control edit_req_fields" placeholder="Type" id="edit_type" name="type" type="text" required>
                                <div class="help-block form-text with-errors form-control-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Amount</label>
                                <input class="form-control edit_req_fields" placeholder="Referral Amount" id="edit_amount" name="amount" type="text" required>
                                <div class="help-block form-text with-errors form-control-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Referral Amount</label>
                                <input class="form-control edit_req_fields" placeholder="Referral Amount" id="edit_referral_amount" name="referral_amount" type="text" required>
                                <div class="help-block form-text with-errors form-control-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">PV Points</label>
                                <input class="form-control edit_req_fields" placeholder="PV Points" id="edit_pv_points" name="pv_points" type="text" required>
                                <div class="help-block form-text with-errors form-control-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Account Discount</label>
                                <input class="form-control edit_req_fields" placeholder="Account Discount" id="edit_account_discount" name="account_discount" type="text" required>
                                <div class="help-block form-text with-errors form-control-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-bordered table-hover" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <td>
                                        <button type="button" id="addModal-product" class="btn btn-primary btn-sm"><i class='feather icon-plus'></i>+ Product</button>
                                    </td>
                                </tr>
                            </thead>
                            <tbody id="edit_product-group"></tbody>
                        </table>
                    </div>
                </div> <!-- // END .modal-body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div> <!-- // END .modal-footer -->
            </form>
        </div> <!-- // END .modal-content -->
    </div> <!-- // END .modal-dialog -->
</div> <!-- // END .modal -->
