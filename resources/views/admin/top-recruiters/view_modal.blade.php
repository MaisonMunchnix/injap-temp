<!--View Top Earner-->
<div id="view-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="add-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-modal-title">Recruits</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> <!-- // END .modal-header -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <label for="username" style="font-weight:700;">Username:</label> <span id="username"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="full_name" style="font-weight:600;">Name:</label> <span id="full_name"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="date_range" style="font-weight:600;">Date:</label> <span id="date_range">All</span>
                    </div>
                </div>
                <table class="table table-hover" id="sales-table" width="100%" style="margin-top:10px;">
                    <thead style="font-weight:600;">
                        <tr>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody id="view-recruits-group"></tbody>
                </table>
            </div> <!-- // END .modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>

            </div> <!-- // END .modal-footer -->
        </div> <!-- // END .modal-content -->
    </div> <!-- // END .modal-dialog -->
</div> <!-- // END .modal -->
