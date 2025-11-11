<!-- Stored in resources/views/child.blade.php -->

@extends('layouts.teller.master')

@section('title', 'Register a member')

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
<!--	<div class="col-md-4 col-lg-4">
		<div class="widgetbar">
			<button class="btn btn-primary" data-toggle="modal" data-target="#add-modal"><i class='feather icon-plus'></i> User</button>
		</div>
	</div>-->
</div>
@endsection

@section('contents')
<div class="card-header">
	<h5 class="card-title">@yield('title')</h5>
</div>
<div class="card-body">
	<form action="" method="post" id="form_register_member"> {{-- /teller-admin/register/insert --}}
		@csrf
		<div class="row">
			<div class="col-lg-4">
				<div class="form-group" data-toggle="tooltip" data-placement="top" title="Leave blank if no sponsor">
					<label for="sponsor">Sponsor:</label>
					<input type="text" class="form-control" id="sponsor" placeholder="Enter Username" name="sponsor">
				</div>
			</div>
			<div class="col-lg-4">
				<div class="form-group" data-toggle="tooltip" data-placement="top" title="Leave blank if no sponsor">
					<label for="upline_placement">Upline Placement:</label>
					<input type="text" class="form-control" id="upline_placement" placeholder="Enter Username" name="upline_placement">
				</div>
			</div>
			<div class="col-lg-4">
				<div class="form-group" data-toggle="tooltip" data-placement="top" title="Leave blank if no sponsor">
					<label for="placement_position">Placement Position:</label>
					<select class="form-control" id="placement_position" name="placement_position">
						<option value="">Select</option>
						<option value="left">Left</option>
						<option value="right">Right</option>
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4">
				<div class="form-group">
					<label for="package_type">Package Type:</label>
					<select class="form-control" id="package_type" name="package_type" required>
						<option value="">Select</option>
					</select>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="form-group">
					<label for="product_num">No of Product:</label>
					<input type="number" class="form-control" id="product_num" name="product_num" required>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="form-group">
					<label for="email_address">Email Address:</label>
					<input type="email" class="form-control" id="email_address" placeholder="Enter Email Address" name="email_address" required>
				</div>
			</div>
		</div>
		<!--<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label for="product_codes">Product Codes:</label>
						<input type="text" class="form-control" id="product_codes" placeholder="Enter Product Codes" name="product_codes" required>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label for="sec_pin">Security Pin:</label>
						<input type="text" class="form-control" id="sec_pin" placeholder="Enter Security Pin" name="sec_pin" required readOnly>
					</div>
				</div>
			</div>-->
		<div class="row">
			<div class="col-lg-4">
				<div class="form-group">
					<label for="first_name">First Name:</label>
					<input type="text" class="form-control" id="first_name" placeholder="Enter First Name" name="first_name" required>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="form-group">
					<label for="last_name">Last Name:</label>
					<input type="text" class="form-control" id="last_name" placeholder="Enter Last Name" name="last_name" required>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="form-group">
					<label for="mobile_no">Mobile No.:</label>
					<input type="text" class="form-control" id="mobile_no" placeholder="Enter Mobile Number" name="mobile_no" required>
				</div>
			</div>
		</div>


		<button type="submit" class="btn btn-primary pull-right" name="register" id="register_member">Submit</button><br>
		<div class="form-group" id="member-reg-err">
			<br>
			<div class="alert alert-danger d-none" id="err-pcode"> Error: Invalid Product Codes. </div>
			<div class="alert alert-danger d-none" id="err-suser"> Error: Invalid Sponsor Username. </div>
			<div class="alert alert-danger d-none" id="err-uuser"> Error: Invalid Upline Username. </div>
			<div class="alert alert-danger d-none" id="err-email"> Error: Email is already taken. </div>
			<div class="alert alert-danger d-none" id="err-product_count"> Error: No of product is required </div>
		</div>

	</form>



	@if ($product_codes = Session::get('product_codes'))
	<h3>Generated Results</h3>
	@if ($username = Session::get('username'))
	<label><strong>Username: </strong>{{$username}}</label><br>
	@endif

	@if ($password = Session::get('password'))
	<label><strong>Password: </strong>{{$password}}</label>
	@endif
	<table class="table mb-0 thead-border-top-0" id="generated_codes_table">
		<thead>
			<tr>
				<th>Category</th>
				<th>Code</th>
				<th>Security Pin</th>
			</tr>
		</thead>
		<tbody class="list">
			@foreach($product_codes AS $product_code)
			<tr>
				<td class="capitalized">{{ $product_code->type }}</td>
				<td>{{ $product_code->code }}</td>
				<td>{{ $product_code->security_pin }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	@endif
</div>

@endsection

@section('scripts')
{{-- additional scripts here --}}
{{-- <script src="../js/jquery-3.3.1.min.js"></script> --}}
<script src="../js/teller/register-member.js"></script>
<script type="text/javascript">
	$('#generated_codes_table').DataTable();
	$(window).on('load', function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");
	});

</script>
@endsection
