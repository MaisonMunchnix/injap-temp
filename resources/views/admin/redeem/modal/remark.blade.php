<div aria-hidden="true" aria-labelledby="myLargeModalLabel" class="modal fade bd-example-modal-lg" role="dialog" tabindex="-1" id="view-remark-modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="" method="post" id="form_remark">
                @csrf
                <div class="modal-header faded">
                    <h5 class="modal-title" id="exampleModalLabel">Add Remark</h5>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="element-box">
                        <div class="form-group">
                            <label for="">Remark: *</label>
                            <input type="hidden" id="remark_item_id" name="id" required>
                            <input type="text" class="form-control" name="remark" id="remark" required>
                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <button class="btn btn-secondary pull-left" data-dismiss="modal" type="button"> Close</button>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary pull-right" type="submit"> Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
