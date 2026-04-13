<div id="edit-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="add-modal-title" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<form method="POST" action="" enctype="multipart/form-data">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title" id="add-modal-title">Edit Admin / Teller</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div> <!-- // END .modal-header -->
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group" data-toggle="tooltip" data-placement="top" title="First Name is required">
								<label for="name" class="col-form-label">First Name: *</label>
								<input type="hidden" id="edit_id" name="edit_id" required>
								<input class="form-control" placeholder="First Name" id="edit_first_name" name="edit_first_name" type="text" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group" data-toggle="tooltip" data-placement="top" title="Last Name is required">
								<label for="name" class="col-form-label">Last Name: *</label>
								<input class="form-control" placeholder="Last Name" id="edit_last_name" name="edit_last_name" type="text" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group" data-toggle="tooltip" data-placement="top" title="Email Address is required">
								<label for="edit_email_address" class="col-form-label">Email Address: *</label>
								<input class="form-control" placeholder="Email Address" id="edit_email_address" name="edit_email_address" type="email" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group" data-toggle="tooltip" data-placement="top" title="Username is required">
								<label for="edit_username" class="col-form-label">Username: *</label>
								<input class="form-control" placeholder="Username" id="edit_username" name="edit_username" type="text" required>
							</div>
						</div>
					</div>
					<div class="row">
					<div class="col-md-6">
							<div class="form-group" data-toggle="tooltip" data-placement="top" title="Mobile Number is required">
								<label for="critical_level" class="col-form-label">Mobile Number: *</label>
								<input class="form-control" placeholder="Mobile Number" id="edit_mobile_number" name="edit_mobile_number" type="number" required>
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group" data-toggle="tooltip" data-placement="top" title="Role is required">
								<label for="edit_role" class="col-form-label">Role:</label>
								<select name="edit_role" id="edit_role" class="form-control capitalized" required>
									<option value="">Select Role</option>
									@foreach($roles as $role)
									<option value="{{ $role->code }}">{{ $role->name }}</option>
									@endforeach
								</select>
								<span id="error-role" class="invalid-feedback"></span>
							</div>
						</div>
						<div id="branch_edit" class="col-md-6" style="display:none">
							<div class="form-group" data-toggle="tooltip" data-placement="top" title="Branch is required">
								<label for="add_branch" class="col-form-label">Branch:</label>
								<select name="edit_branch" id="edit_branch" class="form-control capitalized" required>
									<option value="">Select Branch</option>
									@foreach($branches as $branch)
									<option value="{{ $branch->id }}">{{ $branch->name }}</option>
									@endforeach
								</select>
								<span id="error-role" class="invalid-feedback"></span>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<hr>
							<h6>Staff Scope</h6>
							<div id="edit_scope_wrap" style="display:none;">
								<select name="edit_admin_scope" id="edit_admin_scope" class="form-control">
									<option value="full">Full Access</option>
									<option value="instructors_only">Instructors Only</option>
								</select>
								<small class="text-muted">Instructors Only limits this staff account to instructor-related admin pages.</small>
							</div>
						</div>
					</div>
				</div> <!-- // END .modal-body -->
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="update-btn">Update changes</button>
				</div> <!-- // END .modal-footer -->
			</form>
		</div> <!-- // END .modal-content -->
	</div> <!-- // END .modal-dialog -->
</div> <!-- // END .modal -->
