<div aria-hidden="true" aria-labelledby="myLargeModalLabel" class="modal fade bd-example-modal-lg" role="dialog" tabindex="-1" id="update_info_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header faded">
                <h5 class="modal-title" id="exampleModalLabel">Update Personal Information</h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
            </div>
            <div class="modal-body">
                <form method="" action="" id="">
                    <fieldset class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="upd_fname"> First Name</label>
                                    <input class="form-control required-updated" type="text" @if(!empty($user_data)) value="{{$user_data->first_name}}" @endif readonly required>
                                    <span class="text-danger d-none display-error"></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="upd_lname">Last Name</label>
                                    <input class="form-control required-updated" type="text" @if(!empty($user_data)) value="{{$user_data->last_name}}" @endif readonly required>
                                    <span class="text-danger d-none display-error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="upd_mname"> Middle Name</label>
                                    <input class="form-control required-updated" type="text" @if(!empty($user_data)) value="{{$user_data->middle_name}}" @endif readonly required>
                                    <span class="text-danger d-none display-error"></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="upd_mobile">Mobile No</label>
                                    <input class="form-control required-updated" type="text" id="upd_mobile" @if(!empty($user_data)) value="{{$user_data->mobile_no}}" @endif required>
                                    <span class="text-danger d-none display-error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="upd_tel">Tel No</label>
                                    <input class="form-control"  type="text" id="upd_tel" @if(!empty($user_data)) value="{{$user_data->tel_no}}" @endif >
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Gender</label>
                                    <select class="form-control required-updated" id="upd_gender" required>
                                        <option value="">Select</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>                                                                               
                                    </select>
                                    <input type="hidden" id="hidden_gender" @if(!empty($user_data)) value="{{$user_data->gender}}" @endif>
                                    <span class="text-danger d-none display-error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="upd_civil"> Civil Status</label>
                                    <select class="form-control required-updated" id="upd_civil">
                                        <option value="">Select</option>
                                        <option value="single">Single</option>
                                        <option value="married">Married</option>
                                        <option value="widow">Widow</option>
                                        <option value="separated">Separated</option>
                                    </select>
                                    <span class="text-danger d-none display-error"></span>
                                    <input type="hidden" id="hidden_civil" @if(!empty($user_data)) value="{{$user_data->civil_status}}" @endif>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="upd_tin">Tin No</label>
                                    <input class="form-control" type="text" id="upd_tin" @if(!empty($user_data)) value="{{$user_data->tin_no}}" @endif >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="upd_beneficiary"> Beneficiary</label>
                                    <input class="form-control"  type="text" id="upd_beneficiary" @if(!empty($user_data)) value="{{$user_data->beneficiary}}" @endif >
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="upd_bdate"> Date of Birth</label>
                                    <input class="form-control required-updated" placeholder="Date of birth" type="date" id="upd_bdate" @if(!empty($user_data)) value="{{$user_data->birthdate}}" @endif required>
                                    <span class="text-danger d-none display-error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="upd_province">Province</label>
                                    <select class="form-control required-updated" id="upd_province">
                                        <option value="">Select</option>                                  
                                    </select>
                                    <span class="text-danger d-none display-error"></span>
                                    <input type="hidden" id="hidden_prov_id" @if(!empty($user_data)) value="{{$user_data->province_id}}" @endif>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="upd_city">City</label>
                                    <select class="form-control required-updated" id="upd_city">
                                        <option value="">Select</option>                                  
                                    </select>
                                    <span class="text-danger d-none display-error"></span>
                                    <input type="hidden" id="hidden_city_id" @if(!empty($user_data)) value="{{$user_data->city_id}}" @endif>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="upd_zip"> Zip Code</label>
                                    <input class="form-control required-updated"  type="text"  id="upd_zip" @if(!empty($user_data)) value="{{$user_data->zip_code}}" @endif required>
                                    <span class="text-danger d-none display-error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="upd_addr"> Complete address</label>
                            <textarea class="form-control required-updated" rows="3"  id="upd_addr"  required>@if(!empty($user_data)) {{$user_data->address}} @endif</textarea>
                            <span class="text-danger d-none display-error"></span>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button"> Close</button>
                <button class="btn btn-primary" type="button" id="btn-update-profile"> Save Changes</button>
            </div>
        </div>
    </div>
</div>