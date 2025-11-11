<div aria-hidden="true" class="modal fade in" id="add-announcement-modal" role="dialog" tabindex="-1">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="" method="post" id="add_announcement" enctype="multipart/form-data">
				<div class="modal-header faded smaller">
					<div class="modal-title"><span>Post New Announcement</span></div>
					<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
				</div>
				<div class="modal-body">
					@csrf
					<div class="form-group">
						<label for="">Title</label>
						<input class="form-control add_req_fields" id="add_title" name="add_title" placeholder="Enter title name" type="text">
					</div>
					<div class="form-group">
						<label for="">Subject</label>
						<input class="form-control add_req_fields" id="add_subject" name="add_subject" placeholder="Enter subject name" type="text">
					</div>
					<div class="form-group">
						<label for="">Message</label>
						<textarea class="form-control add_req_fields" id="add_message" name="add_message" rows="3"></textarea>
					</div>
					<div class="form-group">
						<label for="">Attachment</label>
						<div class="attached-media-w">
							<input type="file" name="attachment[]" id="add_attachment" class="attach-media-btn" multiple>

						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for=""> Post Date End</label>
								<div class="date-input">
									<input class="form-control" id="date_end" name="date_end" placeholder="Post Date End" type="date" autocomplete="off">
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="">Priority</label>
								<select class="form-control add_req_fields" name="priority" id="priority">
									<option value="" disabled selected>Select Priority</option>
									<option value="High">High Priority</option>
									<option value="Normal">Normal Priority</option>
									<option value="Low">Low Priority</option>
								</select>
							</div>
						</div>
					</div>

				</div>
				<div class="modal-footer buttons-on-left">
					<button class="btn btn-primary" type="submit"> Post Announcement</button>
					<button class="btn btn-link" data-dismiss="modal" type="button"> Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
