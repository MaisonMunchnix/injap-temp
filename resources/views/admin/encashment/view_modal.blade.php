<div aria-hidden="true" aria-labelledby="myLargeModalLabel" class="modal fade bd-example-modal-lg" role="dialog" tabindex="-1" id="view_encashment_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header faded">
                <h5 class="modal-title" id="exampleModalLabel">View encashment Details</h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
            </div>
            <div class="modal-body">
                <div class="element-box">
                    <div class="table-responsive">
                        <table class="table table-lightborder">
                            <tr>
                                <td>Transaction ID</td>
                                <td><span id="view-tid">Data</span></td>
                            </tr>
                            <tr>
                                <td>Date requested</td>
                                <td><span id="view-dr">Data</span></td>
                            </tr>
                            <tr>
                                <td>Date procesed</td>
                                <td><span id="view-dp">Data</span></td>
                            </tr>
                            <tr>
                                <td>Process by</td>
                                <td><span id="view-pb">Data</span></td>
                            </tr>
                            <tr>
                                <td>Amount requested</td>
                                <td><span id="view-ar">Data</span></td>
                            </tr>
                            <tr>
                                <td>Amount approved</td>
                                <td><span id="view-aa">Data</span></td>
                            </tr>
                            <tr>
                                <td>Tax (<span class="view-tax"></span>%)</td>
                                <td><span id="view-tax" class="view-tax">Data</span></td>
                            </tr>
                            <tr>
                                <td>Processing fee (<span class="view-pfee"></span>php)</td>
                                <td><span id="view-pfee" class="view-pfee">Data</span></td>
                            </tr>
                            <tr>
                                <td>Total Amount claim</td>
                                <td><span id="view-ac">Data</span></td>
                            </tr>
                            <tr>
                                <td>Username</td>
                                <td><span id="view-uname">Data</span></td>
                            </tr>
                            <tr>
                                <td>Full name</td>
                                <td><span id="view-fname">Data</span></td>
                            </tr>
                            <tr>
                                <td>Encashment Status</td>
                                <td><span id="view-stat">Data</span></td>
                            </tr>
                            <tr>
                                <td>Decline/Hold Reasons</td>
                                <td><span id="view-reasons">Data</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-success m-l-5" id="print_url">
                    <i data-feather="printer" class="mr-2"></i> Print
                </a>
                <button class="btn btn-secondary" data-dismiss="modal" type="button"> Close</button>
            </div>
        </div>
    </div>
</div>
