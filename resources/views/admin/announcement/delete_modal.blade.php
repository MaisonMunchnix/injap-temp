<div aria-hidden="true" class="modal fade in" id="delete-modal" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<form action="" method="post" id="delete_announcement">
				<div class="modal-header faded smaller">
					<div class="modal-title"><span>Delete Announcement</span></div>
					<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
				</div>
				<div class="modal-body">
					@csrf
					<p>Are you sure you want to delete this <span id="delete_title"></span>?</p>
					<input class="form-control" id="delete_id" name="delete_id" type="hidden" required>
				</div>
				<div class="modal-footer">
					<div class="row">
						<div class="col-md-6">
							<button class="btn btn-danger" type="submit"> Delete</button>
						</div>
						<div class="col-md-6">
							<button class="btn btn-link" data-dismiss="modal" type="button"> Cancel</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
