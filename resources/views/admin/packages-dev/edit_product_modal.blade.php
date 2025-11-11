<div id="add-product-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="add-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form method="POST" action="" id="add_product_form">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="add-modal-title">Add Package's Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> <!-- // END .modal-header -->
                <div class="modal-body">
                   <input type="hidden" id="edit_product_id"> 
                    <div class="form-group" data-toggle="tooltip" data-placement="top" title="Product is required">
                        <label for="name" class="col-form-label">Product: *</label>
                        <select class='form-control capitalized' id="product_name" name='product_name' required>
                            <option value=''>Please select</option>
                            @foreach($products as $product)
                            <option value='{{ $product->id }}'>{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" data-toggle="tooltip" data-placement="top" title="Quantity is required">
                        <label for="amount" class="col-form-label">Quantity: *</label>
                        <input class="form-control" placeholder="Quantity" id="product_quantity" name="product_quantity" type="number" autocomplete="off" required>
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
