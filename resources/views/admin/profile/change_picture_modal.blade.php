<div aria-hidden="true"  class="modal fade modal-md" role="dialog" tabindex="-1" id="change_picture_modal">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header faded">

                <h5 class="modal-title" id="exampleModalLabel">Change Profile Picture</h5>

                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>

            </div>

            <form method="" action="" id="form-upload-picture">

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-12">

                            <div class="form-group">

                                <div class="text-center">

                                <img  @if(!empty($user_data->profile_picture)) src="/{{$user_data->profile_picture}}" @else src="{{asset('images/users/default_image.png')}}" @endif class="img-thumbnail" id="image-preview"/>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="form-group">

                        <label for="">Select photo</label>

                        <div class="attached-media-w">

                            <input type="file" name="member-photo" id="member-photo" class="attach-media-btn" accept="image/*" required>

                            <span class="text-danger d-none display-error"></span>

                        </div>

                    </div>    

                </div>

                <div class="modal-footer">

                    <button class="btn btn-secondary" data-dismiss="modal" type="button"> Close</button>

                    <button class="btn btn-primary" type="submit" id="btn-change-picture"> Upload Photo</button>

                </div>

            </form>

        </div>

    </div>

</div>