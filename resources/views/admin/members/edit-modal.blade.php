<div id="editModal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="modal-center-title" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<form method="POST" action="" class="classFormUpdate" id="classForm">
				<div class="modal-header">
					<h5 class="modal-title" id="modal-center-title">Update Member</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div> <!-- // END .modal-header -->
				<div class="modal-body">
					@csrf
					<div class="form-group row required" data-toggle="tooltip" data-placement="top" title="Full Name is required">
						<label for="first_name" class="col-form-label col-md-3">Full Name: *</label>
						<div class="col-md-9">
							<input type="hidden" id="id" name="id" required>
							<input class="form-control" placeholder="Full Name" id="first_name" name="first_name" type="text" required>
							<span id="error-name" class="invalid-feedback"></span>
						</div>
					</div>
					<div class="form-group row required" data-toggle="tooltip" data-placement="top" title="Mobile Number is required">
						<label for="mobile_no" class="col-form-label col-md-3">Mobile No.: *</label>
						<div class="col-md-9">
							<input class="form-control" placeholder="Mobile No." id="mobile_no" name="mobile_no" type="text" required>
							<span id="error-name" class="invalid-feedback"></span>
						</div>
					</div>
					<div class="form-group row">
						<label for="username" class="col-form-label col-md-3">Username:</label>
						<div class="col-md-9">
							<input class="form-control" placeholder="Username" id="username" name="username" type="text" required>
							<span id="error-username" class="invalid-feedback"></span>
						</div>
					</div>
					<div class="form-group row required" data-toggle="tooltip" data-placement="top" title="Email Address is required">
						<label for="email" class="col-form-label col-md-3">Email Address: *</label>
						<div class="col-md-9">
							<input class="form-control" placeholder="Email" name="email" type="text" id="email" required>
							<span id="error-email" class="invalid-feedback"></span>
						</div>
					</div>
					<!--<div class="form-group row">
						<label for="email" class="col-form-label col-md-3">Current Password:</label>
						<div class="col-md-9">
							<input class="form-control" placeholder="Password" type="text" id="current_password" readonly>
						</div>
					</div>-->
				</div> <!-- // END .modal-body -->
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="update-btn">Save changes</button>
				</div> <!-- // END .modal-footer -->
			</form>
		</div> <!-- // END .modal-content -->
	</div> <!-- // END .modal-dialog -->
</div> <!-- // END .modal -->
