<div id="view-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="add-modal-title" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="edit-modal-title">View Package</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div> <!-- // END .modal-header -->
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="">Type</label>
								<input class="form-control" placeholder="Type" id="view_type" name="view_type" type="text" readonly>
								
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Amount</label>
								<input class="form-control" placeholder="Referral Amount" id="view_amount" name="view_amount" type="text" readonly>
								
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Referral Amount</label>
								<input class="form-control" placeholder="Referral Amount" id="view_referral_amount" name="view_referral_amount" type="text" readonly>
								
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="">PV Points</label>
								<input class="form-control" placeholder="PV Points" id="view_pv_points" name="view_pv_points" type="text" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Account Discount</label>
								<input class="form-control" placeholder="Account Discount" id="view_account_discount" name="view_account_discount" type="text" readonly>
							</div>
						</div>
					</div>
					<div class="row">
						<table class="table">
							<thead>
								<tr>
									<th>Product</th>
									<th>Quantity</th>
								</tr>
							</thead>
							<tbody id="view-product-group">
							</tbody>
						</table>
					</div>
				</div> <!-- // END .modal-body -->
				<div class="modal-footer">
					<button type="button" class="btn btn-light float-right" data-dismiss="modal">Close</button>
				</div> <!-- // END .modal-footer -->
		</div> <!-- // END .modal-content -->
	</div> <!-- // END .modal-dialog -->
</div> <!-- // END .modal -->
