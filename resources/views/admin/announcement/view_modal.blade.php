<div aria-hidden="true" class="modal fade in" id="edit-announcement-modal" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header faded smaller">
                <div class="modal-title"><span>Edit Announcement</span></div>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="">Subject</label>
                        <input class="form-control" id="subject" placeholder="Enter task name" type="text">
                    </div>
                    <div class="form-group">
                        <label for="">Message</label>
                        <textarea class="form-control" id="message" name="" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Attachment</label>
                        <div class="attached-media-w"><a class="attach-media-btn" href="#"><i class="os-icon os-icon-ui-22"></i><span>Add Photos</span></a></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""> Post Date End</label>
                                <div class="date-input">
                                    <input class="single-daterange form-control" placeholder="Date of birth" type="text" value="04/12/1978">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Priority</label>
                                <select class="form-control">
                                    <option>High Priority</option>
                                    <option>Normal Priority</option>
                                    <option>Low Priority</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer buttons-on-left">
                <button class="btn btn-teal" type="button"> Update Announcement</button>
                <button class="btn btn-link" data-dismiss="modal" type="submit"> Cancel</button>
            </div>
        </div>
    </div>
</div>