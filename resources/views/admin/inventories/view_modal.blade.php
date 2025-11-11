<div aria-hidden="true" class="modal fade in" id="view-modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header faded smaller">
                <div class="modal-title"><span>Stock Movement</span></div>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
            </div>
            <div class="modal-body">
                <h3 id="view_name"></h3>
                <div class="table-responsive">
                    <form action="">
                        <input type="hidden" id="search_id" required>
                        <input type="hidden" id="search_branch_id" required>
                        <div class="row input-daterange">
                            <div class="col-md-3">
                                <input type="date" name="from_date" id="from_date" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="to_date" id="to_date" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
                                <button type="button" name="refresh" id="refresh" class="btn btn-default">Refresh</button>
                            </div>
                            <div class="col-md-3 nav nav-tabs">
                                <a class="btn btn-primary active" data-toggle="tab" href="#in">IN</a>
                                <a class="btn btn-danger" data-toggle="tab" href="#out">OUT</a>

                            </div>
                        </div>
                    </form>
                    <br>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div id="in" class="tab-pane active">
                            <table id="table-movements-in" class="table table-hover" style="width:100%">
                               <h3>IN</h3>
                                <thead>
                                    <th>Quantity</th>
                                    <th>Date</th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div id="out" class="tab-pane">
                            <h3>OUT</h3>
                            <table id="table-movements-out" class="table table-hover" style="width:100%">
                                <thead>
                                    <th>Quantity</th>
                                    <th>Date</th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer buttons-on-left">
                <button class="btn btn-default pull-right" data-dismiss="modal" type="button"> Close</button>
            </div>
        </div>
    </div>
</div>
