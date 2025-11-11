<div id="changeSponsorModal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="modal-center-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="" class="changeSponsorForm" id="changeSponsorForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-center-title">Change Sponsor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>Change sponsor for <b><span id="change_sponsor_for"></span></b></h5><br>
                    @csrf
                    <input type="hidden" name="to_be_change_user_id"  id="to_be_change_user_id">
                    <!-- <div class="form-group">
                        <label for="old_sponsor" class="col-form-label">Old Sponsor:</label>
                        <input class="form-control" placeholder="Old sponsor" name="old_sponsor" type="text" id="old_sponsor" readOnly>
                    </div> -->
                    <div class="form-group">
                        <label for="new_sponsor" class="col-form-label">New Sponsor:</label>
                        <input class="form-control" placeholder="Input new sponsor" name="new_sponsor" type="text" id="new_sponsor" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="change-sponsor-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
