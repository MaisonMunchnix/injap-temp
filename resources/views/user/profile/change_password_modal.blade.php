<div aria-hidden="true" aria-labelledby="myLargeModalLabel" class="modal fade bd-example-modal-lg" role="dialog" tabindex="-1" id="change_passwordModal">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header faded">
				<h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
				<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
			</div>
			<div class="modal-body">
				<form method="" action="" id="change-password-form">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="current_password"> Current Password</label>
								<input class="form-control required-password" type="password" id="current_password" required>
								<span class="text-danger d-none display-error"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="new_password">New Password</label>
								<input class="form-control required-password" type="password" id="new_password" required>
								<span class="text-danger d-none display-error"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="confirm_password"> Confirm-Password</label>
								<input class="form-control required-password" type="password" id="confirm_password" required>
								<span class="text-danger d-none display-error"></span>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal" type="button">Close</button>
				<button class="btn btn-primary" type="button" id="btn-update-password">Change Password</button>
			</div>
		</div>
	</div>
</div>
