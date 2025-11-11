<div aria-hidden="true" class="modal fade in" id="edit-modal" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<form action="" method="post" id="edit_supplier">
				<div class="modal-header faded smaller">
					<div class="modal-title"><span>Edit Supplier</span></div>
					<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
				</div>
				<div class="modal-body">
					@csrf
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="edit_supplier_name">Supplier Name</label>
								<input type="hidden" id="edit_id" required>
								<input class="form-control req_fields" id="edit_supplier_name" placeholder="Enter Supplier name" required="required" type="text">
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Supplier Code</label>
								<input class="form-control req_fields" id="edit_supplier_code" placeholder="Enter Supplier Code" required="required" type="text">
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>
						</div>
					</div>

					<fieldset class="form-group">
						<legend><span>Supplier's Information</span></legend>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for=""> First Name</label>
									<input class="form-control req_fields" id="edit_supplier_first_name" data-error="Please input your First Name" placeholder="First Name" required="required" type="text">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="">Last Name</label>
									<input class="form-control req_fields" id="edit_supplier_last_name" data-error="Please input your Last Name" placeholder="Last Name" required="required" type="text">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for=""> Telephone Number</label>
									<input class="form-control req_fields" id="edit_supplier_tel_num" data-error="Please input telephone number" placeholder="Telephone Number" type="text">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="">Mobile Number</label>
									<input class="form-control req_fields" id="edit_supplier_mobile_num" data-error="Please input mobile number" placeholder="Mobile Number" required="required" type="number" pattern="^\d{11}$">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for=""> Email Address</label>
							<input class="form-control req_fields" id="edit_supplier_email" placeholder="Enter email address" required="required" type="email">
							<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>

						<div class="form-group">
							<label> Complete Address</label>
							<textarea class="form-control req_fields" id="edit_supplier_addr" placeholder="Complete Address"></textarea>
						</div>
					</fieldset>
				</div>
				<div class="modal-footer buttons-on-left">
					<button class="btn btn-primary" type="submit"> Update Supplier</button>
					<button class="btn btn-link" data-dismiss="modal" type="button"> Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
