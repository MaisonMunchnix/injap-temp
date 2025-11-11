<div id="view-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="add-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-modal-title">View Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> <!-- // END .modal-header -->
            <div class="modal-body">
                <table class="table table-striped table-hover">
                    <tbody>
                        <tr>
                            <th class="w-25">Transaction Date</th>
                            <td id="view_transaction_date"></td>
                        </tr>
                        <tr>
                            <th>Transaction Number</th>
                            <td id="view_transaction_number"></td>
                        </tr>
                        <tr>
                            <th>Transaction Gateway Used</th>
                            <td id="view_transaction_driver"></td>
                        </tr>
                        <tr>
                            <th>Transaction Paid</th>
                            <td id="view_transaction_paid"></td>
                        </tr>
                        <tr>
                            <th>Transaction Gateway Status</th>
                            <td id="view_transaction_status"></td>
                        </tr>
                        <tr>
                            <th>Transaction Error Message</th>
                            <td id="view_transaction_error"></td>
                        </tr>
                        <tr>
                            <th>Member</th>
                            <td id="view_member"></td>
                        </tr>
                        <tr>
                            <th>Subtotal</th>
                            <td id="view_subtotal"></td>
                        </tr>
                        <tr>
                            <th>Discount</th>
                            <td id="view_discount"></td>
                        </tr>
                        <tr>
                            <th>Shipping</th>
                            <td id="view_shipping"></td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td id="view_total"></td>
                        </tr>
                        <!-- <tr>
							<th>Shipping to another address</th>
							<td id="view_should_ship"></td>
						</tr>
						<tr>
							<th>Shipping to another address details</th>
							<td id="view_shipping_details"></td>
						</tr>
						<tr>
							<th>Notes</th>
							<td id="view_notes"></td>
						</tr> -->
                    </tbody>
                </table>

            </div> <!-- // END .modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div> <!-- // END .modal-footer -->
        </div> <!-- // END .modal-content -->
    </div> <!-- // END .modal-dialog -->
</div> <!-- // END .modal -->
