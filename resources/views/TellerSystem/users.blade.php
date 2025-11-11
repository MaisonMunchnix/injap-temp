<!-- Stored in resources/views/child.blade.php -->

@extends('layouts.teller.master')

@section('title', 'Users')

@section('stylesheets')

@endsection

@section('breadcrumbs')
<div class="row align-items-center">
	<div class="col-md-8 col-lg-8">
		<h3 class="page-title">@yield('title')</h3>
		<div class="breadcrumb-list">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{!! url('teller-admin/'); !!}">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
			</ol>
		</div>
	</div>
	<div class="col-md-4 col-lg-4">
		<div class="widgetbar">
			<button class="btn btn-primary" data-toggle="modal" data-target="#add-modal"><i class='feather icon-plus'></i> User</button>
		</div>
	</div>
</div>
@endsection

@section('contents')
<div class="card-header">
	<h5 class="card-title">@yield('title')</h5>
</div>
<div class="card-body">
	<div class="table-responsive border-bottom">
		<table class="table mb-0 thead-border-top-0" id="users_table" style="width:100% !important">
			<thead>
				<tr>
					<th>Username</th>
					<th>Email Address</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Type</th>
					<th>Status</th>
					<th>Date</th>
					<th>Actions</th>
				</tr>
			</thead>

		</table>
	</div>
</div>
@endsection

@section('scripts')

<div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-center-title" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<form method="POST" action="" class="classFormUpdate" id="classForm">
				<div class="modal-header">
					<h5 class="modal-title" id="modal-center-title">Update Users</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div> <!-- // END .modal-header -->
				<div class="modal-body">
					@csrf
					<div class="form-group row required" data-toggle="tooltip" data-placement="top" title="First Name is required">
						<label for="first_name" class="col-form-label col-md-3">First Name: *</label>
						<div class="col-md-9">
							<input type="hidden" id="id" name="id" required>
							<input class="form-control" placeholder="First Nam" id="first_name" name="first_name" type="text" required>
							<span id="error-name" class="invalid-feedback"></span>
						</div>
					</div>
					<div class="form-group row" data-toggle="tooltip" data-placement="top" title="Middle Name is not required">
						<label for="middle_name" class="col-form-label col-md-3">Middle Name:</label>
						<div class="col-md-9">
							<input class="form-control" placeholder="Middle Name" id="middle_name" name="middle_name" type="text">
							<span id="error-name" class="invalid-feedback"></span>
						</div>
					</div>
					<div class="form-group row required" data-toggle="tooltip" data-placement="top" title="Last Name is required">
						<label for="last_name" class="col-form-label col-md-3">Last Name: *</label>
						<div class="col-md-9">
							<input class="form-control" placeholder="Last Name" id="last_name" name="last_name" type="text" required>
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
					<div class="form-group row required" data-toggle="tooltip" data-placement="top" title="Username is required">
						<label for="username" class="col-form-label col-md-3">Username: *</label>
						<div class="col-md-9">
							<input class="form-control" placeholder="Username" id="username" name="username" type="text" required>
							<span id="error-name" class="invalid-feedback"></span>
						</div>
					</div>
					<div class="form-group row required" data-toggle="tooltip" data-placement="top" title="Role is required">
						<label for="role" class="col-form-label col-md-3">Role: *</label>
						<div class="col-md-9">
							<select name="role" id="role" class="form-control capitalized" required>
								<option value="">Select Role</option>
								@foreach($roles as $role)
								<option value="{{ $role->code }}">{{ $role->name }}</option>
								@endforeach
							</select>
							<!--<input class="form-control" placeholder="Role" name="role" type="text" id="role" required>-->
							<span id="error-role" class="invalid-feedback"></span>
						</div>
					</div>
					<div class="form-group row required" data-toggle="tooltip" data-placement="top" title="Email Address is required">
						<label for="email" class="col-form-label col-md-3">Email Address: *</label>
						<div class="col-md-9">
							<input class="form-control" placeholder="Email" name="email" type="email" id="email" required>
							<span id="error-email" class="invalid-feedback"></span>
						</div>
					</div>
				</div> <!-- // END .modal-body -->
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="update-btn">Save changes</button>
				</div> <!-- // END .modal-footer -->
			</form>
		</div> <!-- // END .modal-content -->
	</div> <!-- // END .modal-dialog -->
</div> <!-- // END .modal -->


<!--Add User Modal-->
<div id="add-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-center-title" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<form method="POST" action="" id="addForm" class="addForm" enctype="multipart/form-data">
				<div class="modal-header">
					<h5 class="modal-title" id="modal-center-title">Add User</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div> <!-- // END .modal-header -->
				<div class="modal-body">
					@csrf
					<div class="row">
						<div class="col-md-6">
							<div class="form-group required" data-toggle="tooltip" data-placement="top" title="First Name is required">
								<label for="add_first_name">First Name: *</label>
								<input class="form-control" placeholder="First Nam" id="add_first_name" name="add_first_name" type="text" autocomplete="off" autofocus required>
								<span id="error-name" class="invalid-feedback"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group required" data-toggle="tooltip" data-placement="top" title="Last Name is required">
								<label for="add_last_name">Last Name: *</label>
								<input class="form-control" placeholder="Last Name" id="add_last_name" name="add_last_name" type="text" autocomplete="off" required>
								<span id="error-name" class="invalid-feedback"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group required" data-toggle="tooltip" data-placement="top" title="Email Address is required">
								<label for="add_email">Email Address: *</label>
								<input class="form-control" placeholder="Email" name="add_email" type="email" id="add_email" autocomplete="off" required>
								<span id="error-email" class="invalid-feedback"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group required" data-toggle="tooltip" data-placement="top" title="Mobile Number is required">
								<label for="add_mobile_no">Mobile No.: *</label>
								<input class="form-control" placeholder="Mobile No." id="add_mobile_no" name="add_mobile_no" type="text" autocomplete="off" required>
								<span id="error-name" class="invalid-feedback"></span>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group required" data-toggle="tooltip" data-placement="top" title="Password is required">
								<label for="add_password">Password: *</label>
								<input class="form-control" placeholder="Password" name="add_password" type="password" id="add_password" autocomplete="off" required>
								<span id="error-email" class="invalid-feedback"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group required" data-toggle="tooltip" data-placement="top" title="Confirm-Password is required">
								<label for="confirm-password">Confirm-Password: *</label>
								<input class="form-control" placeholder="Confirm-Password" name="add_confirm-password" type="password" id="add_confirm-password" autocomplete="off" required>
								<span id="error-email" class="invalid-feedback"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group required" data-toggle="tooltip" data-placement="top" title="Role is required">
								<label for="role">Role: *</label>
								<select name="add_role" id="add_role" class="form-control capitalized" required>
									<option value="">Select Role</option>
									@foreach($roles as $role)
									<option value="{{ $role->code }}">{{ $role->name }}</option>
									@endforeach
								</select>
								<span id="error-role" class="invalid-feedback"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group" data-toggle="tooltip" data-placement="top" title="Image is not required">
								<label for="name" class="col-form-label">Image:</label>
								<input type="file" name="image" id="product-img" class="form-control">
								<img src="" id="product-img-tag" class="img-fluid">
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



<script>
	$(document).ready(function() {

		$('body').on('submit', '#addForm', function(event) {
			event.preventDefault();
			console.log('User add submitting...');

			var password = $("#add_password").val();
			var confirm_password = $("#add_confirm-password").val();



			if (password != confirm_password) {
				swal({
					title: "Error!",
					text: "Error Msg: Password not match!",
					type: "error",
				});
			} else if (IsEmail($("#add_email").val()) == false) {
				swal({
					title: "Error!",
					text: "Error Msg: Invalid Email",
					type: "error",
				});
			} else {
				$.ajax({
					url: 'users/add',
					type: 'POST',
					data: new FormData(this),
					contentType: false,
					processData: false,
					beforeSend: function() {
						$('.send-loading').show();
					},
					success: function(response) {
						console.log('User add submitting success...');
						$('.send-loading').hide();
						swal({
							title: 'Success!',
							text: 'Successfully Added',
							timer: 1500,
							type: "success",
						}).then(
							function() {},
							function(dismiss) {
								if (dismiss === 'timer') {
									window.location.href = "@yield('title')".toLowerCase();
								}
							}
						)

					},
					error: function(error) {
						console.log('User add submitting error...');
						console.log(error);
						console.log(error.responseJSON.message);
						$('.send-loading').hide();
						swal({
							title: 'Error!',
							text: "Error Msg: " + error.responseJSON.message + "",
							timer: 1500,
							type: "error",
						}).then(
							function() {},
							function(dismiss) {}
						)
					}
				});
			}
		});

		$('body').on('click', '.editModalBtn', function(event) {
			console.log('edit btn clicked');
			var id = $(this).data('id');
			var action = 'members/edit' + id;
			var url = 'members/edit';
			$.ajax({
				type: 'get',
				url: url,
				data: {
					'id': id
				},
				beforeSend: function() {
					$('.send-loading').show();
				},
				success: function(data) {
					$('.send-loading').hide();
					$('#id').val(data.id);
					$('#username').val(data.username);
					$('#first_name').val(data.first_name);
					$('#middle_name').val(data.middle_name);
					$('#last_name').val(data.last_name);
					$('#mobile_no').val(data.mobile_no);
					$('#role').find('option[value="' + data.userType + '"]').attr('selected', 'selected');
					$('#email').val(data.email);
					$('.classFormUpdate').attr('action', action);
					$('#editModal').modal('show');
				}
			});
		});


		$('#update-btn').click(function() {
			event.preventDefault();
			console.log('User update submitting...');
			var formData = new FormData();
			formData.append("id", $("#id").val());
			formData.append("username", $("#username").val());
			formData.append("email_address", $("#email").val());
			formData.append("first_name", $("#first_name").val());
			formData.append("middle_name", $("#middle_name").val());
			formData.append("last_name", $("#last_name").val());
			formData.append("role", $('#role option:selected').val());
			formData.append("mobile_no", $("#mobile_no").val());
			formData.append('_token', token);

			if (IsEmail($("#email").val()) == false) {
				swal({
					title: "Error!",
					text: "Error Msg: Invalid Email",
					type: "error",
				});
			} else {
				$.ajax({
					url: 'members/update',
					type: 'POST',
					data: formData,
					contentType: false,
					processData: false,
					beforeSend: function() {
						$('.send-loading').show();
					},
					success: function(response) {
						console.log('User update submitting success...');
						$('.send-loading').hide();
						swal({
							title: 'Success!',
							text: 'Successfully Updated',
							timer: 1500,
							type: "success",
						}).then(
							function() {},
							function(dismiss) {
								if (dismiss === 'timer') {
									window.location.href = "@yield('title')".toLowerCase();
								}
							}
						)

					},
					error: function(error) {
						console.log('User update submitting error...');
						console.log(error);
						console.log(error.responseJSON.message);
						$('.send-loading').hide();
						swal({
							title: 'Error!',
							text: "Error Msg: " + error.responseJSON.message + "",
							timer: 1500,
							type: "error",
						}).then(
							function() {},
							function(dismiss) {}
						)
					}
				});
			}
		})


		$('body').on('click', '.modifyUser', function(event) {
			if (!confirm("Do you really want to do this?")) {
				return false;
			}
			event.preventDefault();
			console.log('User Modify submitting...');
			var formData = new FormData();
			formData.append("id", $(this).data('id'));
			formData.append('_token', token);

			$.ajax({
				url: 'members/modify',
				type: 'POST',
				data: formData,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$('.send-loading').show();
				},
				success: function(response) {
					console.log('User Modify submitting success...');
					$('.send-loading').hide();
					swal({
						title: 'Success!',
						text: 'Successfully Modified',
						timer: 1500,
						type: "success",
					}).then(
						function() {},
						function(dismiss) {
							if (dismiss === 'timer') {
								window.location.href = "@yield('title')".toLowerCase();
							}
						}
					)

				},
				error: function(error) {
					console.log('User Modify submitting error...');
					console.log(error);
					console.log(error.responseJSON.message);
					$('.send-loading').hide();
					swal({
						title: "Error!",
						text: "Error Msg: " + error.responseJSON.message + "",
						type: "error",
					});
				}
			});
		})
	});


	$(document).ready(function() {
		$('#users_table').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": {
				"url": "{{ route('all-users') }}",
				"dataType": "json",
				"type": "POST",
				"data": {
					_token: token
				}
			},
			"columns": [{
					"data": "username"
				},
				{
					"data": "email"
				},
				{
					"data": "first_name"
				},
				{
					"data": "last_name"
				},
				{
					"data": "type"
				},
				{
					"data": "status"
				},
				{
					"data": "created_at"
				},
				{
					"data": "options",
					"searchable": false,
					"orderable": false
				}
			]
		});


	});

	function IsEmail(email) {
		var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (!regex.test(email)) {
			return false;
		} else {
			return true;
		}
	}

	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function(e) {
				$('#product-img-tag').attr('src', e.target.result);

			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	$("#product-img").change(function() {
		readURL(this);
	});

</script>
@endsection
