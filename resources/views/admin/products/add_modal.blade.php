<div id="add-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="add-modal-title" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<form method="POST" action="{{ route('insert-product') }}" enctype="multipart/form-data">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title" id="add-modal-title">Add Product</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div> <!-- // END .modal-header -->
				<div class="modal-body">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group" data-toggle="tooltip" data-placement="top" title="Image is not required">
								<label for="name" class="col-form-label">Image:</label>
								<input type="file" name="image" id="product-img" class="form-control">

							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group" data-toggle="tooltip" data-placement="top" title="Name is required">
								<label for="name" class="col-form-label">Name: *</label>
								<input class="form-control" placeholder="Name" id="name" name="name" type="text" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group" data-toggle="tooltip" data-placement="top" title="Critical Level is required">
								<label for="critical_level" class="col-form-label">Pricel: *</label>
								<input class="form-control" placeholder="Price" id="price" name="price" type="number" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group" data-toggle="tooltip" data-placement="top" title="Critical Level is required">
								<label for="critical_level" class="col-form-label">Critical Level: *</label>
								<input class="form-control" placeholder="Critical Level" id="critical_level" name="critical_level" type="number" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group" data-toggle="tooltip" data-placement="top" title="Begining Quantity is optional">
								<label for="qty" class="col-form-label">Begining Quantity:</label>
								<input class="form-control" placeholder="Begining Quantity" id="qty" name="qty" type="number" value="0" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group" data-toggle="tooltip" data-placement="top" title="Category is required">
								<label for="category" class="col-form-label">Category:</label>
								<select class="form-control" name="category" id="category" required>
									<option value="" selected>Select Category</option>
									@foreach($product_categories as $product_category)
									<option value="{{ $product_category->id }}">{{ $product_category->name }}</option>
									@endforeach
								</select>
							</div>

						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group" data-toggle="tooltip" data-placement="top" title="Description is not required">
								<label for="description" class="col-form-label">Description:</label>
								<textarea class="form-control" name="description" id="description" placeholder="Description"></textarea>
							</div>
						</div>
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