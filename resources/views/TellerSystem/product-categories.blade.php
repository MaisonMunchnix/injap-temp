<!-- Stored in resources/views/child.blade.php -->

@extends('layouts.teller.master')

@section('title', 'Product Categories')

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
			<button class="btn btn-primary" data-toggle="modal" data-target="#add-modal"><i class='feather icon-plus'></i> Category</button>
		</div>
	</div>
</div>
@endsection

@section('contents')


	<div class="table-responsive border-bottom" data-toggle="lists" data-lists-values='["js-lists-values-employee-name"]'>
		<table class="table mb-0 thead-border-top-0" id="product_categories_table" style="width:100% !important">
			<thead>
				<tr>
					<th>Name</th>
					<th>Status</th>
					<th>Date</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody class="list">
				@foreach($product_categories as $product_category)
				<tr>
					<td>{{ $product_category->name }}</td>
					<td>{{ $product_category->status }}</td>
					<td>{{ $product_category->created_at }}</td>
					<td>
						<div class="btn-group" role="group" aria-label="Action Buttons">
							<button type="button" class="btn btn-warning btn-sm editRecord" data-toggle="modal" data-id="{{$product_category->id}}"><i class='feather icon-edit-2'></i></button>
							<button type="button" class="btn btn-danger btn-sm deleteProduct" data-toggle="modal" data-id="{{$product_category->id}}"><i class='feather icon-trash'></i></button>
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

@endsection

@section('scripts')
<script>
	$(document).ready(function() {
		$('#product_categories_table').DataTable();

		$('body').on('click', '.editRecord', function(event) {
			console.log('edit btn clicked');
			var id = $(this).data('id');
			var action = 'product-categories/edit/' + id;
			var url = 'product-categories/edit/';
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
					console.log('Edit Created form');
					$('.send-loading').hide();
					$('#id').val(data.id);
					$('#edit_name').val(data.name);
					$('.classFormUpdate').attr('action', action);
					$('#edit-record-modal').modal('show');
				}
			});
		});

		//Update Button
		$('body').on('submit', '#classFormUpdate', function(event) {
			event.preventDefault();
			console.log('Product Category update submitting...');
			$.ajax({
				url: 'product-categories/update',
				type: 'POST',
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					$('.send-loading').show();
				},
				success: function(response) {
					console.log('Product Category update submitting success...');
					$('.send-loading').hide();
					swal({
						title: 'Success!',
						text: 'Product Category Successfully Updated',
						timer: 1500,
						type: "success",
					}).then(
						function() {},
						function(dismiss) {
							if (dismiss === 'timer') {
								window.location.href = 'product-categories';
							}
						}
					)

				},
				error: function(error) {
					console.log('Product Category update submitting error...');
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
		$('body').on('click', '.deleteProduct', function(event) {
			if (!confirm("Do you really want to do this?")) {
				return false;
			}
			event.preventDefault();
			console.log('Product Delete submitting...');
			var formData = new FormData();
			formData.append("id", $(this).data('id'));
			formData.append('_token', token);

			$.ajax({
				url: 'products/delete',
				//url: 'member-update',
				type: 'POST',
				data: formData,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$('.send-loading').show();
				},
				success: function(response) {
					console.log('Product Delete submitting success...');
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
								window.location.href = 'product-categories';
							}
						}
					)
				},
				error: function(error) {
					console.log('Product Delete submitting error...');
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

	});

</script>

<div id="add-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="add-modal-title" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form method="POST" action="{{ route('product-categories-save') }}">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title" id="add-modal-title">Add Product Category</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div> <!-- // END .modal-header -->
				<div class="modal-body">

					<div class="form-group" data-toggle="tooltip" data-placement="top" title="Name is required">
						<label for="name" class="col-form-label">Name: *</label>
						<input class="form-control" placeholder="Name" id="name" name="name" type="text" required>
					</div>
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
					<h5 class="modal-title" id="modelHeading">Edit Product Category</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div> <!-- // END .modal-header -->
				<div class="modal-body">
					<div class="form-group" data-toggle="tooltip" data-placement="top" title="Name is required">
						<label for="name" class="col-form-label">Name: *</label>
						<input id="id" name="id" type="hidden" required>
						<input class="form-control" placeholder="Name" id="edit_name" name="name" type="text" required>
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
