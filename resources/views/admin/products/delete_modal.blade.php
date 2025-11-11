<div id="delete-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="add-modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form method="POST" action="" id="classFormDelete" enctype="multipart/form-data">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="add-modal-title">Delete Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> <!-- // END .modal-header -->
                <div class="modal-body">
                    <input type="hidden" id="delete_id" name="id">
                    Are you sure you want to delete the <span class="product_name" style="color:red;"></span>?
                </div> <!-- // END .modal-body -->
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <button type="button" class="btn btn-block btn-light" data-dismiss="modal">Cancel</button>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <button type="submit" class="btn btn-block btn-danger"
                                id="delete-product-btn">Delete</button>
                        </div>
                    </div>
                </div> <!-- // END .modal-footer -->
            </form>
        </div> <!-- // END .modal-content -->
    </div> <!-- // END .modal-dialog -->
</div> <!-- // END .modal -->
