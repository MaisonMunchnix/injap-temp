<!-- Stored in resources/views/child.blade.php -->

@extends('layouts.teller.master')

@section('title', 'Packages')

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
			<button class="btn btn-primary" data-toggle="modal" data-target="#add-modal"><i class='feather icon-plus'></i> Package</button>
		</div>
	</div>
</div>
@endsection

@section('contents')
<div class="card-header">
	<h5 class="card-title">@yield('title')</h5>
</div>
<div class="card-body">
	<div class="table-responsive border-bottom" data-toggle="lists" data-lists-values='["js-lists-values-employee-name"]'>
		<table class="table mb-0 thead-border-top-0" id="product_categories_table" style="width:100% !important">
			<thead>
				<tr>
					<th>Type</th>
					<th>Amount</th>
					<th>Referral Amount</th>
					<th>Points</th>
					<th>Discount</th>
					<th>Date</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody class="list">
				@foreach($packages as $package)
				<tr>
					<td>{{ $package->type }}</td>
					<td>{{ $package->amount }}</td>
					<td>{{ $package->referral_amount }}</td>
					<td>{{ $package->pv_points }}</td>
					<td>{{ $package->account_discount * 100 }}%</td>
					<td>{{ $package->created_at }}</td>
					<td>
						<div class="btn-group" role="group" aria-label="Action Buttons">
							<button type="button" class="btn btn-warning btn-sm editRecord" data-toggle="modal" data-id="{{$package->id}}"><i class='feather icon-edit-2'></i></button>
							<button type="button" class="btn btn-danger btn-sm deleteData" data-toggle="modal" data-id="{{$package->id}}"><i class='feather icon-trash'></i></button>
						</div>

					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		<div class="col-md-12">
			@if(Session::has('successMsg'))
			<div class="alert alert-success"> {{ Session::get('successMsg') }}</div>
			@endif
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script>
	$(document).ready(function() {
		$('#product_categories_table').DataTable();

		$('body').on('click', '.editRecord', function(event) {
			console.log('edit btn clicked');
			var id = $(this).data('id');
			var action = 'packages/edit/' + id;
			var url = 'packages/edit/';
			$.ajax({
				type: 'get',
				url: url,
				data: {
					'id': id
				},
				beforeSend: function() {
					$('#edit_id').val('');
					$('.send-loading').show();
				},
				success: function(data) {
					$('.send-loading').hide();
					$('#id').val(data.id);
					$('#edit_type').val(data.type);
					$('#edit_referral_amount').val(data.referral_amount);
					$('#edit_pv_points').val(data.pv_points);
					$('#edit_account_discount').val(data.account_discount * 100 + '%');
					$('.classFormUpdate').attr('action', action);
					$('#edit-record-modal').modal('show');
				}
			});
		});

		//Update Button
		$('body').on('submit', '#classFormUpdate', function(event) {
			event.preventDefault();
			console.log('Package update submitting...');
			$.ajax({
				url: 'packages/update',
				type: 'POST',
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					$('.send-loading').show();
				},
				success: function(response) {
					console.log('Package update submitting success...');
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
					console.log('Package update submitting error...');
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
		});

		//Delete
		$('body').on('click', '.deleteData', function(event) {
			if (!confirm("Do you really want to do this?")) {
				return false;
			}
			event.preventDefault();
			console.log('Package Delete submitting...');
			var formData = new FormData();
			formData.append("id", $(this).data('id'));
			formData.append('_token', token);

			$.ajax({
				url: 'packages/delete',
				//url: 'member-update',
				type: 'POST',
				data: formData,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$('.send-loading').show();
				},
				success: function(response) {
					console.log('Package Delete submitting success...');
					$('.send-loading').hide();
					swal({
						title: 'Success!',
						text: 'Successfully Deleted',
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
					console.log('Package Delete submitting error...');
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
		})

		$(".allownumericwithdecimal").on("keypress keyup blur", function(event) {
			//this.value = this.value.replace(/[^0-9\.]/g,'');
			$(this).val($(this).val().replace(/[^0-9%\.]/g, ''));
			if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
				event.preventDefault();
			}
		});

		var product_counter = 2;

		$("#add-product").click(function() {

			if (product_counter > {{$product_count}}) {
				alert("Only {{ $product_count }} Product/s allowed");
				return false;
			}

			var newTextBoxDiv = $(document.createElement('tr'))
				.attr("id", 'product_id' + product_counter, "class", 'item').attr("class", 'item');
			newTextBoxDiv.after().html("<td>#" + product_counter + "</td><td>" +
				"<select class='form-control capitalized select_product' name='select_product[]'>" +
				"<option value=''>Please select</option>" +
				" <optgroup label='Products'>" +
				"@foreach($products as $product)" +
				"<option value='{{ $product->id }}'>{{ $product->name }}</option>" +
				"@endforeach" +
				"</optgroup>" +
				"</select>" +
				"</td>" +
				"<td>" +
				"<input type='number' class='form-control qnty amount' name='product_qty[]' placeholder='Enter Quantity'>" +
				"</td>" +
				"<td><button type='button' class='btn btn-danger btn-xs remove-product' data-id='" + product_counter + "'>x</button></td>" +
				"</tr>");

			newTextBoxDiv.appendTo("#product-group");


			product_counter++;
		});

		$('body').on('click', '.remove-product', function(event) {
			var id = $(this).data('id');
			console.log('remove product clicked ' + id);
			if (product_counter == 1) {
				alert("No more textbox to remove");
				return false;
			}

			product_counter--;

			$("#product_id" + id).remove();

		});

	});

</script>

<div id="add-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="add-modal-title" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<form method="POST" action="{{ route('packages-save') }}">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title" id="add-modal-title">Add Package</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div> <!-- // END .modal-header -->
				<div class="modal-body">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group" data-toggle="tooltip" data-placement="top" title="Type is required">
								<label for="name" class="col-form-label">Type: *</label>
								<input class="form-control" placeholder="Type" id="type" name="type" type="text" autocomplete="off" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group" data-toggle="tooltip" data-placement="top" title="Referral Amount is required">
								<label for="amount" class="col-form-label">Amount: *</label>
								<input class="form-control" placeholder="Amount" id="amount" name="amount" type="text" autocomplete="off" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group" data-toggle="tooltip" data-placement="top" title="Referral Amount is required">
								<label for="referral_amount" class="col-form-label">Referral Amount: *</label>
								<input class="form-control" placeholder="Referral Amount" id="referral_amount" name="referral_amount" type="text" autocomplete="off" required>
							</div>
						</div>

					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group" data-toggle="tooltip" data-placement="top" title="PV Points is required">
								<label for="pv_points" class="col-form-label">PV Points: *</label>
								<input class="form-control" placeholder="PV Points" id="pv_points" name="pv_points" type="text" autocomplete="off" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group" data-toggle="tooltip" data-placement="top" title="Account Discount is required">
								<label for="account_discount" class="col-form-label">Account Discount: *</label>
								<input class="form-control allownumericwithdecimal" placeholder="Account Discount" id="account_discount" name="account_discount" type="text" autocomplete="off" required>
							</div>
						</div>
					</div>

					<table class="table">
						<thead>
							<tr>
								<th>#</th>
								<th>Product</th>
								<th>Quantity</th>
								<td>
									<button type="button" id="add-product" class="btn btn-primary btn-sm"><i class='feather icon-plus'></i> Product</button>
								</td>
							</tr>
						</thead>
						<tbody id="product-group">
							<tr id="product_id" class="item">
								<td>#1</td>
								<td>
									<select class="form-control capitalized select_product" name="select_product[]">
										<option value="" disabled selected>Select Product</option>
										<optgroup label="Products">
											@foreach($products as $product)
											<option value="{{ $product->id }}">{{ $product->name }}</option>
											@endforeach
										</optgroup>
									</select>
								</td>
								<td>
									<input type="number" class="qnty amount form-control product_qty" name="product_qty[]" placeholder="Enter Quantity">
								</td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div> <!-- // END .modal-body -->
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="add-product-btn">Save changes</button>
				</div> <!-- // END .modal-footer -->
			</form>
		</div> <!-- // END .modal-content -->
	</div> <!-- // END .modal-dialog -->
</div> <!-- // END .modal -->

<div id="edit-record-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="add-modal-title" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form method="POST" action="" class="classFormUpdate" id="classFormUpdate" enctype="multipart/form-data">
				@csrf
				<span id="form_output"></span>
				<div class="modal-header">
					<h5 class="modal-title" id="modelHeading">Edit Package</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div> <!-- // END .modal-header -->
				<div class="modal-body">
					<div class="form-group" data-toggle="tooltip" data-placement="top" title="Type is required">
						<label for="name" class="col-form-label">Type: *</label>
						<input id="id" name="id" type="hidden" required>
						<input class="form-control" placeholder="Type" id="edit_type" name="type" type="text" required>
					</div>

					<div class="form-group" data-toggle="tooltip" data-placement="top" title="Referral Amount is required">
						<label for="edit_referral_amount" class="col-form-label">Referral Amount: *</label>
						<input class="form-control" placeholder="Referral Amount" id="edit_referral_amount" name="referral_amount" type="text" required>
					</div>

					<div class="form-group" data-toggle="tooltip" data-placement="top" title="PV Points is required">
						<label for="edit_pv_points" class="col-form-label">PV Points: *</label>
						<input class="form-control" placeholder="PV Points" id="edit_pv_points" name="pv_points" type="text" required>
					</div>

					<div class="form-group" data-toggle="tooltip" data-placement="top" title="Account Discount is required">
						<label for="edit_account_discount" class="col-form-label">Account Discount: *</label>
						<input class="form-control allownumericwithdecimal" placeholder="Account Discount" id="edit_account_discount" name="account_discount" type="text" required>
					</div>
				</div> <!-- // END .modal-body -->
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="edit-product-btn">Save changes</button>
				</div> <!-- // END .modal-footer -->
			</form>
		</div> <!-- // END .modal-content -->
	</div> <!-- // END .modal-dialog -->
</div> <!-- // END .modal -->
@endsection
