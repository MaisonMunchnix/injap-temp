<div id="edit-sub-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="add-modal-title" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<form method="POST" action="" id="update_sub_form">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title">Edit Sub Package</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div> <!-- // END .modal-header -->
				<div class="modal-body">
					<div class="row">
						<table class="table table-bordered table-hover" style="width:100%;">
							<thead>
								<tr> 
									<th>Product</th>
									<th>Quantity</th>
									<td>
										<button type="button" id="edit_add-product" class="btn btn-primary btn-sm"><i class='feather icon-plus'></i> Product</button>
									</td>
								</tr>
							</thead>
							<tbody id="edit-sub-product-group"></tbody>
						</table>
					</div>
				</div> <!-- // END .modal-body -->
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div> <!-- // END .modal-footer -->
			</form>
		</div> <!-- // END .modal-content -->
	</div> <!-- // END .modal-dialog -->
</div> <!-- // END .modal -->
