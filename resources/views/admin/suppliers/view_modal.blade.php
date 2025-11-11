<style>
    .text-field{
        background-color: #f2e6f7;
    }
</style>
<div aria-hidden="true" class="modal fade in" id="view-modal" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
				<div class="modal-header faded smaller">
					<div class="modal-title"><span>View Supplier</span></div>
					<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="view_supplier_name">Supplier Name</label>
								<div class="text-field form-control" id="view_supplier_name"></div>
								<!--<input class="form-control" id="" placeholder="Enter Supplier name" type="text" readonly>-->
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Supplier Code</label>
								<div class="text-field form-control" id="view_supplier_code"></div>
								<!--<input class="form-control" id="view_supplier_code" placeholder="Enter Supplier Code" type="text" readonly>-->
							</div>
						</div>
					</div>

					<fieldset class="form-group">
						<legend><span>Supplier's Information</span></legend>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for=""> First Name</label>
									<div class="text-field form-control" id="view_supplier_first_name"></div>
									<!--<input class="form-control" id="view_supplier_first_name" placeholder="First Name" type="text" readonly>-->
									
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="">Last Name</label>
									<div class="text-field form-control" id="view_supplier_last_name"></div>
									<!--<input class="form-control" id="view_supplier_last_name" placeholder="Last Name" type="text" readonly>-->
									
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for=""> Telephone Number</label>
									<div class="text-field form-control" id="view_supplier_tel_num"></div>
									<!--<input class="form-control" id="view_supplier_tel_num" placeholder="Telephone Number" type="text" readonly>-->
									
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="">Mobile Number</label>
									<div class="text-field form-control" id="view_supplier_mobile_num"></div>
									<!--<input class="form-control" id="view_supplier_mobile_num" placeholder="Mobile Number" type="number" readonly>-->
									
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for=""> Email Address</label>
							<div class="text-field form-control" id="view_supplier_email"></div>
							<!--<input class="form-control" id="view_supplier_email" placeholder="Enter email address" type="email" readonly>-->
							
						</div>

						<div class="form-group">
							<label> Complete Address</label>
							<div class="text-field form-control" id="view_supplier_addr"></div>
							<!--<textarea class="form-control" id="view_supplier_addr" placeholder="Complete Address" readonly></textarea>-->
						</div>
					</fieldset>
				</div>
				<div class="modal-footer buttons-on-left">
					<button class="btn float-right btn-link" data-dismiss="modal" type="button"> Close</button>
				</div>
		</div>
	</div>
</div>
