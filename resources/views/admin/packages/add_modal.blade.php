<div id="add-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="add-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" action="" id="add_form" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="add-modal-title">Add Package</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> <!-- // END .modal-header -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group" data-toggle="tooltip" data-placement="top" title="Image is required">
                                <label for="name" class="col-form-label">Image: *</label>
                                <input type="file" name="image" id="image" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group" data-toggle="tooltip" data-placement="top" title="Description is not required">
                                <label for="description" class="col-form-label">Description:</label>
                                <textarea class="form-control" name="description" id="description" placeholder="Description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group" data-toggle="tooltip" data-placement="top" title="Type is required">
                                <label for="name" class="col-form-label">Type: *</label>
                                <input class="form-control" placeholder="Type" id="type" name="type" type="text" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" data-toggle="tooltip" data-placement="top" title="Referral Amount is required">
                                <label for="amount" class="col-form-label">Amount: *</label>
                                <input class="form-control" placeholder="Amount" id="amount" name="amount" type="text" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" data-toggle="tooltip" data-placement="top" title="Referral Amount is required">
                                <label for="referral_amount" class="col-form-label">Referral Amount: *</label>
                                <input class="form-control" placeholder="Referral Amount" id="referral_amount" name="referral_amount" type="text" autocomplete="off" required>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" data-toggle="tooltip" data-placement="top" title="PV Points is required">
                                <label for="pv_points" class="col-form-label">PV Points: *</label>
                                <input class="form-control" placeholder="PV Points" id="pv_points" name="pv_points" type="text" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" data-toggle="tooltip" data-placement="top" title="Account Discount is required">
                                <label for="account_discount" class="col-form-label">Account Discount: *</label>
                                <input class="form-control allownumericwithdecimal" placeholder="Account Discount" id="account_discount" name="account_discount" type="text" autocomplete="off" required>
                            </div>
                        </div>
                    </div>

                    <table class="table table-bordered table-hover" style="width:100%;">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <td>
                                    <button type="button" id="add-product" class="btn btn-primary btn-sm"><i class='feather icon-plus'></i> Product</button>
                                </td>
                            </tr>
                        </thead>
                        <tbody id="product-group">
                        </tbody>
                    </table>
                </div> <!-- // END .modal-body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="save-btn">Save changes</button>
                </div> <!-- // END .modal-footer -->
            </form>
        </div> <!-- // END .modal-content -->
    </div> <!-- // END .modal-dialog -->
</div> <!-- // END .modal -->
