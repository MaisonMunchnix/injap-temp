<div id="edit-passwordModal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="modal-center-title" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="" class="classFormPasswordUpdate" id="classForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-center-title">Update Member Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> <!-- // END .modal-header -->
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" id="password_member_id" name="id" required>
                        <label for="new_password" class="col-form-label">New Password:</label>
                        <input class="form-control" placeholder="New Password" name="new_password" type="password" id="new_password" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password" class="col-form-label">Confirm New Password:</label>
                        <input class="form-control" placeholder="Confirm New Password" name="confirm_password" type="password" id="confirm_password" autocomplete="off">
                    </div>
                </div> <!-- // END .modal-body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="update-password-btn">Change Password</button>
                </div> <!-- // END .modal-footer -->
            </form>
        </div> <!-- // END .modal-content -->
    </div> <!-- // END .modal-dialog -->
</div> <!-- // END .modal -->
