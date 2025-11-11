<div id="edit-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="add-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" action="" id="classFormUpdate" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="add-modal-title">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> <!-- // END .modal-header -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group" data-toggle="tooltip" data-placement="top" title="Name is required">
                                <label for="name" class="col-form-label">Name: *</label>
                                <input id="edit_id" name="id" type="hidden" required>
                                <input class="form-control" placeholder="Name" id="edit_name" name="name"
                                    type="text" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" data-toggle="tooltip" data-placement="top"
                                title="Cost Price is required">
                                <label for="edit_cost_price" class="col-form-label">Cost Price: *</label>
                                <input class="form-control" placeholder="Price" id="edit_cost_price" name="cost_price"
                                    type="number" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" data-toggle="tooltip" data-placement="top"
                                title="Price is required">
                                <label for="edit_price" class="col-form-label">Price: *</label>
                                <input class="form-control" placeholder="Price" id="edit_price" name="price"
                                    type="number" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group" data-toggle="tooltip" data-placement="top"
                                title="Critical Level is required">
                                <label for="critical_level" class="col-form-label">Critical Level: *</label>
                                <input class="form-control" placeholder="Critical Level" id="edit_critical_level"
                                    name="critical_level" type="number" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" data-toggle="tooltip" data-placement="top"
                                title="Product Reward Points is required">
                                <label for="reward_points" class="col-form-label">Product Reward Points:</label>
                                <select class="form-control" name="reward_points" id="reward_points" required>
                                    <option value="" selected>Select Product Reward Points</option>
                                    <option value="0.05">5%</option>
                                    <option value="0.10">10%</option>
                                    <option value="0.15">15%</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4" data-toggle="tooltip" data-placement="top" title="Image is required">
                            <label for="name" class="col-form-label">Image:</label>
                            <div class="input-group">
                                <input type="file" name="image" id="edit_product-img" class="form-control">
                                <div class="input-group-append">
                                    <button class="btn btn-default" id="view_pic" type="button">
                                        <i class="os-icon os-icon-image"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group" data-toggle="tooltip" data-placement="top"
                                title="Description is not required">
                                <label for="description" class="col-form-label">Description:</label>
                                <textarea class="form-control" name="description" id="edit_description" placeholder="Description"></textarea>
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
