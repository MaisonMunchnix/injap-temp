<div id="edit-discount-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="add-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" action="" id="classFormUpdateDiscount" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="add-modal-title">Edit Product Discount</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> <!-- // END .modal-header -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" data-toggle="tooltip" data-placement="top" title="Name is required">
                                <label for="name" class="col-form-label">ID From: *</label>
                                <input id="edit_id" name="id" type="hidden" required>
                                <input class="form-control" placeholder="ID From" id="id_from" name="id_from" type="number" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" data-toggle="tooltip" data-placement="top" title="Critical Level is required">
                                <label for="critical_level" class="col-form-label">ID From: *</label>
                                <input class="form-control" placeholder="ID From" id="id_to" name="id_to" type="number" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" data-toggle="tooltip" data-placement="top" title="Category is required">
                                <label for="category" class="col-form-label">Category:</label>
                                <select class="form-control" name="edit_category" id="edit_category" required>
                                    <option value="" selected>Select Category</option>
                                    <option value="">Member</option>
                                    <option value="stockist">Stockist</option>
                                    <option value="bo">BO</option>
                                </select>
                            </div>
                        </div>  
                        <div class="col-md-6">
                            <div class="form-group" data-toggle="tooltip" data-placement="top" title="Critical Level is required">
                                <label for="critical_level" class="col-form-label">Discounted Price: *</label>
                                <input class="form-control" placeholder="Discounted Price" id="discounted_price" name="discounted_price" type="number" required>
                            </div>
                        </div>

                    </div>

                </div> <!-- // END .modal-body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="edit-product-btn">Save changes</button>
                </div> <!-- // END .modal-footer -->
            </form>
        </div> <!-- // END .modal-content -->
    </div> <!-- // END .modal-dialog -->
</div> <!-- // END .modal -->
