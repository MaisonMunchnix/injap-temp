<div aria-hidden="true" aria-labelledby="myLargeModalLabel" class="modal fade bd-example-modal-lg" role="dialog"
    tabindex="-1" id="edit_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="edit-ads-form" action="" method="POST">
                @csrf()
                <div class="modal-header faded">
                    <h5 class="modal-title" id="editeModalLabel"></h5>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true"> &times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="element-box">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="hidden" id="edit_id" name="id" required>
                                    <input type="text" id="edit_title" name="title" class="form-control"
                                        placeholder="Title" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="img">Image</label>
                                <input type="file" name="image" id="image" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Content</label>
                            <textarea name="content" id="edit_content" cols="30" rows="10" class="form-control" placeholder="Contents"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal" type="button"> Close</button>
                    <button type="submit" class="btn btn-primary pull-right">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
