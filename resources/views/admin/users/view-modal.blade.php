<div id="view-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="add-modal-title" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title capitalized" id="view-modal-title"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div> <!-- // END .modal-header -->
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="name" class="col-form-label">First Name: *</label>
								<input class="form-control" placeholder="First Name" id="view_first_name" type="text" disabled>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="name" class="col-form-label">Last Name: *</label>
								<input class="form-control" placeholder="Last Name" id="view_last_name"  type="text" disabled>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="view_email_address" class="col-form-label">Email Address: *</label>
								<input class="form-control" placeholder="Email Address" id="view_email_address" type="email" disabled>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="view_username" class="col-form-label">Username: *</label>
								<input class="form-control" placeholder="Username" id="view_username" type="text" disabled>
							</div>
						</div>
					</div>
					<div class="row">
					<div class="col-md-6">
							<div class="form-group">
								<label for="critical_level" class="col-form-label">Mobile Number: *</label>
								<input class="form-control" placeholder="Mobile Number" id="view_mobile_number" type="number" disabled>
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group">
								<label for="view_role" class="col-form-label">Role:</label>
								<select name="view_role" id="view_role" class="form-control capitalized" disabled>
									<option value="">Select Role</option>
									@foreach($roles as $role)
									<option value="{{ $role->code }}">{{ $role->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div id="branch_edit" class="col-md-6" style="display:none">
							<div class="form-group">
								<label for="add_branch" class="col-form-label">Branch:</label>
								<select id="view_branch" class="form-control capitalized" disabled>
									<option value="">Select Branch</option>
									@foreach($branches as $branch)
									<option value="{{ $branch->id }}">{{ $branch->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
				</div> <!-- // END .modal-body -->
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
				</div> <!-- // END .modal-footer -->
		</div> <!-- // END .modal-content -->
	</div> <!-- // END .modal-dialog -->
</div> <!-- // END .modal -->
