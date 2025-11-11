<div id="add-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="add-modal-title" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<form method="POST" action="" id="addForm" enctype="multipart/form-data">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title" id="add-modal-title">Add Staff / Teller</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div> <!-- // END .modal-header -->
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group" data-toggle="tooltip" data-placement="top" title="First Name is required">
								<label for="name" class="col-form-label">First Name: *</label>
								<input class="form-control req_fields" placeholder="First Name" id="add_first_name" name="add_first_name" type="text" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group" data-toggle="tooltip" data-placement="top" title="Last Name is required">
								<label for="name" class="col-form-label">Last Name: *</label>
								<input class="form-control req_fields" placeholder="Last Name" id="add_last_name" name="add_last_name" type="text" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group" data-toggle="tooltip" data-placement="top" title="Email Address is required">
								<label for="critical_level" class="col-form-label">Email Address: *</label>
								<input class="form-control req_fields" placeholder="Email Address" id="add_email_address" name="add_email_address" type="email" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group" data-toggle="tooltip" data-placement="top" title="Username is required">
								<label for="add_username" class="col-form-label">Username: *</label>
								<input class="form-control req_fields" placeholder="Username" id="add_username" name="add_username" type="text" required>
							</div>
						</div>
					</div>
					<div class="row">
					<div class="col-md-6">
							<div class="form-group" data-toggle="tooltip" data-placement="top"> {{--  title="Mobile Number is not required" --}}
								<label for="critical_level" class="col-form-label">Mobile Number:</label>
								<input class="form-control" placeholder="Mobile Number" id="add_mobile_number" name="add_mobile_number" type="number">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group" data-toggle="tooltip" data-placement="top" title="Image is not required">
								<label for="name" class="col-form-label">Image:</label>
								<input type="file" name="add_image" id="add_image" class="form-control">
								<img src="" id="add_img_tag" class="img-fluid">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group" data-toggle="tooltip" data-placement="top" title="Password is required">
								<label for="password" class="col-form-label">Password: *</label>
								<input class="form-control req_fields" placeholder="Password" id="add_password" name="add_password" type="password" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group" data-toggle="tooltip" data-placement="top" title="Confirm-Password is required">
								<label for="confirm_password" class="col-form-label">Confirm-Password: *</label>
								<input class="form-control req_fields" placeholder="Confirm Password" id="add_confirm_password" name="add_confirm_password" type="password" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group" data-toggle="tooltip" data-placement="top" title="Role is required">
								<label for="add_role" class="col-form-label">Role:</label>
								<select name="add_role" id="add_role" class="form-control capitalized req_fields" required>
									<option value="">Select Role</option>
									@foreach($roles as $role)
									<option value="{{ $role->code }}">{{ $role->name }}</option>
									@endforeach
								</select>
								<span id="error-role" class="invalid-feedback"></span>
							</div>
						</div>
						
						<div id="branch" class="col-md-6" style="display:none">
							<div class="form-group" data-toggle="tooltip" data-placement="top" title="Branch is required">
								<label for="add_branch" class="col-form-label">Branch:</label>
								<select name="add_branch" id="add_branch" class="form-control capitalized">
									<option value="">Select Branch</option>
									@foreach($branches as $branch)
									<option value="{{ $branch->id }}">{{ $branch->name }}</option>
									@endforeach
								</select>
								<span id="error-role" class="invalid-feedback"></span>
							</div>
						</div>
					</div>
					<div class="row" id="access-rights" style="display:none">
						<div class="col-md-12">
							<h5 class="text-center">Check Access Rights</h5>
							<h6>Members</h6>
                            <div class="checkbox">
                                <label><input type="checkbox" value="true" id="ar_edit_member" class="check_access" checked> Edit Member</label>
                            </div>
							<div class="checkbox">
                                <label><input type="checkbox" value="false" id="ar_deactivate_member" class="check_access" > Deactivate Member</label>
                            </div>
							<br/>
							<h6>Inventories</h6>
                            <div class="checkbox">
                                <label><input type="checkbox" value="false" id="ar_transfer_stocks" class="check_access" > Transfer Stocks</label>
                            </div>
							<br/>
							<h6>E-wallet purchases</h6>
                            <div class="checkbox">
                                <label><input type="checkbox" value="false" id="ar_approve_ewallet" class="check_access" > Approve</label>
                            </div>
							<div class="checkbox">
                                <label><input type="checkbox" value="false" id="ar_decline_ewallet" class="check_access" > Decline</label>
                            </div>
							<br/>
							<h6>Products</h6>
                            <div class="checkbox">
                                <label><input type="checkbox" value="true" id="ar_add_product" class="check_access" checked> Add</label>
                            </div>
							<div class="checkbox">
                                <label><input type="checkbox" value="true" id="ar_edit_product" class="check_access" checked> Edit</label>
                            </div>
							<div class="checkbox">
                                <label><input type="checkbox" value="false" id="ar_delete_product" class="check_access" > Delete</label>
                            </div>
							<br/>
							<h6>Packages</h6>
                            <div class="checkbox">
                                <label><input type="checkbox" value="true" id="ar_add_packages" class="check_access" checked> Add</label>
                            </div>
							<div class="checkbox">
                                <label><input type="checkbox" value="true" id="ar_edit_packages" class="check_access" checked> Edit</label>
                            </div>
							<div class="checkbox">
                                <label><input type="checkbox" value="false" id="ar_delete_packages" class="check_access"> Delete</label>
                            </div>
							<br/>
							<h6>Announcement</h6>
                            <div class="checkbox">
                                <label><input type="checkbox" value="true" id="ar_add_announcement" class="check_access" checked> Add</label>
                            </div>
							<div class="checkbox">
                                <label><input type="checkbox" value="true" id="ar_edit_announcement" class="check_access" checked> Edit</label>
                            </div>
							<div class="checkbox">
                                <label><input type="checkbox" value="false" id="ar_delete_announcement" class="check_access" > Delete</label>
                            </div>
							<br/>
							<h6>Encashments</h6>
                            <div class="checkbox">
                                <label><input type="checkbox" value="true" id="ar_approve_encash" class="check_access" checked> Approve</label>
                            </div>
							<div class="checkbox">
                                <label><input type="checkbox" value="true" id="ar_process_encash" class="check_access" checked> Process</label>
                            </div>
							<div class="checkbox">
                                <label><input type="checkbox" value="false" id="ar_decline_encash" class="check_access" > Decline</label>
                            </div>
							<div class="checkbox">
                                <label><input type="checkbox" value="false" id="ar_hold_encash" class="check_access" > Hold</label>
                            </div>
							<br/>
							<h6>Branch</h6>
                            <div class="checkbox">
                                <label><input type="checkbox" value="true" id="ar_add_branch" class="check_access" checked> Add</label>
                            </div>
							<div class="checkbox">
                                <label><input type="checkbox" value="true" id="ar_edit_branch" class="check_access" checked> Edit</label>
                            </div>
							<div class="checkbox">
                                <label><input type="checkbox" value="false" id="ar_delete_branch" class="check_access"> Delete</label>
                            </div>
							<br/>
							<h6>Supplier</h6>
                            <div class="checkbox">
                                <label><input type="checkbox" value="true" id="ar_add_supplier" class="check_access" checked> Add</label>
                            </div>
							<div class="checkbox">
                                <label><input type="checkbox" value="true" id="ar_edit_supplier" class="check_access" checked> Edit</label>
                            </div>
							<div class="checkbox">
                                <label><input type="checkbox" value="false" id="ar_delete_supplier" class="check_access"> Delete</label>
                            </div>
							<br/>
							<h6>Users</h6>
                            <div class="checkbox">
                                <label><input type="checkbox" value="true" id="ar_add_user" class="check_access" checked> Add</label>
                            </div>
							<div class="checkbox">
                                <label><input type="checkbox" value="true" id="ar_edit_user" class="check_access" checked> Edit</label>
                            </div>
							<div class="checkbox">
                                <label><input type="checkbox" value="false" id="ar_delete_user" class="check_access"> Delete</label>
                            </div>
						</div>
					</div>


				</div> <!-- // END .modal-body -->
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="add-btn">Save changes</button>
				</div> <!-- // END .modal-footer -->
			</form>
		</div> <!-- // END .modal-content -->
	</div> <!-- // END .modal-dialog -->
</div> <!-- // END .modal -->
