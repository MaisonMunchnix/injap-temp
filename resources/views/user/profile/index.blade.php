@extends('layouts.default.master')

@section('title', 'Profile')

@section('page-title', 'Profile')


@section('stylesheets')

    {{-- additional style here --}}
    <style>
        .input-valid {
            border-color: #28a745;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: center right calc(0.375em + 0.1875rem);
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        .input-invalid {
            border-color: #dc3545;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23dc3545' viewBox='-2 -2 7 7'%3e%3cpath stroke='%23dc3545' d='M0 0l3 3m0-3L0 3'/%3e%3ccircle r='.5'/%3e%3ccircle cx='3' r='.5'/%3e%3ccircle cy='3' r='.5'/%3e%3ccircle cx='3' cy='3' r='.5'/%3e%3c/svg%3E");
            background-repeat: no-repeat;
            background-position: center right calc(0.375em + 0.1875rem);
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        .valid-msg {
            display: none;
            color: red;
        }
    </style>

@endsection



@section('content')
    {{-- content here --}}
    <div class="content-body">
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-lg-3 col-md-12 mb-3">
                            <div class="nav flex-lg-column flex-sm-row nav-pills" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home"
                                    role="tab" aria-controls="v-pills-home" aria-selected="true">Account</a>
                                <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile"
                                    role="tab" aria-controls="v-pills-profile" aria-selected="false">Information</a>
                                <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages"
                                    role="tab" aria-controls="v-pills-messages" aria-selected="false">Security</a>

                            </div>
                        </div>
                        <div class="col-lg-9 col-md-12">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                    aria-labelledby="v-pills-home-tab">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">Account</h6>
                                            <form id="account_form" method="POST" action="">
                                                <div class="d-flex mb-3">
                                                    <figure class="mr-3">
                                                        <img @if (!empty($user_data->profile_picture)) src="/{{ $user_data->profile_picture }}" @else src="{{ asset('images/users/default_image.png') }}" @endif
                                                            width="100" class="rounded" alt="...">
                                                    </figure>
                                                    <div>
                                                        <p>
                                                            @if (!empty($user_data->first_name))
                                                                {{ $user_data->first_name }}
                                                                @endif @if (!empty($user_data->last_name))
                                                                    {{ $user_data->last_name }}
                                                                @endif
                                                               
                                                        </p>
                                                        <button class="btn btn-outline-primary mr-2" type="button"
                                                            data-toggle="modal" data-target="#change_picture_modal">Change
                                                            Avatar</button>
                                                        <!-- <button class="btn btn-outline-danger" type="button">Remove Avatar</button> -->
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Username</label>
                                                            <input type="text" class="form-control"
                                                                @if (!empty($user_data)) value="{{ $user_data->uname }}" @endif
                                                                disabled required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input type="text" class="form-control" name="email"
                                                                id="email"
                                                                @if (!empty($user_data)) value="{{ $user_data->email }}" @endif
                                                                required>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Team Name</label>
                                                            <input type="text" class="form-control" name="team_name"
                                                                id="team_name"
                                                                @if (!empty($user_data)) value="{{ $user_data->team_name }}" @endif
                                                                placeholder="Team Name">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Bank Name</label>
                                                            <select class="form-control" id="bank_name" name="bank_name">
                                                                <option value="">Select</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Account Number</label>
                                                            <input type="text" class="form-control" name="account_number"
                                                                id="account_number"
                                                                @if (!empty($user_data)) value="{{ $user_data->bank_account_number }}" @endif
                                                                placeholder="Account Number">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>TIN</label>
                                                            <input type="text" class="form-control" name="tin"
                                                                id="tin"
                                                                @if (!empty($user_data)) value="{{ $user_data->tin }}" @endif
                                                                placeholder="TAX Identification Number (TIN)">
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="old_user_name" id="old_user_name"
                                                    @if (!empty($user_data)) value="{{ $user_data->uname }}" @endif>
                                                <input type="hidden" name="old_email" id="old_email"
                                                    @if (!empty($user_data)) value="{{ $user_data->email }}" @endif>
                                                <button class="btn btn-primary">Save Changes</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                    aria-labelledby="v-pills-profile-tab">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">Information</h6>
                                            <form id="personal_info_form" action="" method="POST">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>First name</label>
                                                            <input type="text" class="form-control"
                                                                @if (!empty($user_data)) value="{{ $user_data->first_name }}" @endif
                                                                disabled required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Last name</label>
                                                            <input type="text" class="form-control"
                                                                @if (!empty($user_data)) value="{{ $user_data->last_name }}" @endif
                                                                disabled required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Middle name</label>
                                                            <input type="text" class="form-control"
                                                                @if (!empty($user_data)) value="{{ $user_data->middle_name }}" @endif
                                                                disabled required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Mobile No</label>
                                                            <input type="text" class="form-control" name="mobile_no"
                                                                id="mobile_no"
                                                                @if (!empty($user_data)) value="{{ $user_data->mobile_no }}" @endif
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Birth Date</label>
                                                            <input type="date" class="form-control" name="birth_date"
                                                                id="birth_date"
                                                                @if (!empty($user_data)) value="{{ $user_data->birthdate }}" @endif
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Gender</label>
                                                            <select class="form-control" name="gender" id="gender"
                                                                required>

                                                                @if (!empty($user_data->gender))
                                                                    @if ($user_data->gender == 'male')
                                                                        <option value="male" selected>Male</option>
                                                                        <option value="female">Female</option>
                                                                    @else
                                                                        <option value="female" selected>Female</option>
                                                                        <option value="male">Male</option>
                                                                    @endif
                                                                @else
                                                                    <option value="">Select</option>
                                                                    <option value="male">Male</option>
                                                                    <option value="female">Female</option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Province</label>
                                                            <select class="form-control" id="province_id"
                                                                name="province_id" required>
                                                                <option value="">Select</option>
                                                            </select>
                                                            <input type="hidden" name="province_hidden"
                                                                id="province_hidden"
                                                                @if (!empty($user_data)) value="{{ $user_data->province_id }}" @endif>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>City</label>
                                                            <select class="form-control" id="city_id" name="city_id"
                                                                required>
                                                                <option value="">Select</option>
                                                            </select>
                                                            <input type="hidden" name="city_hidden" id="city_hidden"
                                                                @if (!empty($user_data)) value="{{ $user_data->city_id }}" @endif>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Full Address</label>
                                                            <input type="text" id="address" name="address"
                                                                class="form-control"
                                                                @if (!empty($user_data)) value="{{ $user_data->address }}" @endif
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary" type="submit">Save Changes</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                                    aria-labelledby="v-pills-messages-tab">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">Security</h6>
                                            <form id="credential_form" action="" method="POST">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Old Password</label>
                                                            <input type="password" class="form-control"
                                                                id="current_password" name="current_password"
                                                                autocomplete="off" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>New Password</label>
                                                            <input type="password" class="form-control" id="new_password"
                                                                name="new_password" autocomplete="suggested" required>
                                                            <div class="valid-msg">
                                                                Minimum of 8 characters.
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>New Password Repeat</label>
                                                            <input type="password" class="form-control"
                                                                id="confirm_password" name="confirm_password"
                                                                autocomplete="suggested" required>
                                                            <div class="valid-msg">
                                                                Password not match.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary" type="submit">Save Changes</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>









            @include('user.profile.change_picture_modal')
        </div>
        <!-- begin::footer -->
        <footer class="content-footer">
            <div class="pull-right text-right">© {{ date('Y') }} {{ env('APP_NAME') }} - All Right Reserve - Innovation Japan</div>
        </footer>
        <!-- end::footer -->
    </div>

@endsection



@section('scripts')

    {{-- additional scripts here --}}

    <!-- <script src="{{ asset('js/user/member-profile.js') }}"></script> -->
    <script>
        var city_data = "";
        var pass_err = 1;
        $(document).ready(function() {
            $('.preloader').css('z-index', '9999');
            getProvinceData();
            getBanks();

            $("#province_id").change(function(event) {
                var dis_val = $(this).val();
                $('#city_id').empty();
                $('#city_id').append('<option value="">Select</option>');
                $.each(city_data, function(i, value) {
                    if (value.provCode == dis_val) {
                        $('#city_id').append('<option value="' + value.citymunCode + '">' + value
                            .citymunDesc + '</option>');
                    }
                });
            });

            $("#member-photo").change(function() {
                var fileExtension = ['jpeg', 'jpg', 'png'];
                if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                    //alert("Only formats are allowed : " + fileExtension.join(', '));
                    valid_image = false;
                    swal({
                        title: "Warning!",
                        text: "Invalid image type",
                        type: "warning",
                    });
                    $(this).closest('.form-group').find('.display-error').text('Invalid image type');
                    $(this).closest('.form-group').find('.display-error').removeClass('d-none');
                    //$(this).addClass("border-red");
                } else {
                    valid_image = true;
                    previewImage(this);
                    $(this).closest('.form-group').find('.display-error').text('');
                    $(this).closest('.form-group').find('.display-error').addClass('d-none');
                    //$(dis).removeClass("border-red");
                }
            });


            $("#new_password").change(function() {
                var pass_val = $('#new_password').val();
                var conf_pass_val = $('#confirm_password').val();
                var pass = $('#new_password');
                var conf_pass = $('#confirm_password');
                if (pass_val.length < 8) {
                    pass.addClass('input-invalid');
                    pass.removeClass('input-valid');
                    pass.closest('.form-group').find('.valid-msg').show();
                    pass_err = 1;
                } else {
                    pass.removeClass('input-invalid');
                    pass.addClass('input-valid');
                    pass.closest('.form-group').find('.valid-msg').hide();
                    pass_err = 0;
                }
                if (conf_pass_val == "" || conf_pass_val == null) {
                    pass_err = 1;
                } else {
                    if (pass_val == conf_pass_val) {
                        conf_pass.removeClass('input-invalid');
                        conf_pass.addClass('input-valid');
                        conf_pass.closest('.form-group').find('.valid-msg').hide();
                        pass_err = 0;
                    } else {
                        conf_pass.addClass('input-invalid');
                        conf_pass.removeClass('input-valid');
                        conf_pass.closest('.form-group').find('.valid-msg').show();
                        pass_err = 1;
                    }
                }
            });

            $("#confirm_password").change(function() {
                var pass_val = $('#new_password').val();
                var conf_pass_val = $('#confirm_password').val();
                var pass = $('#new_password');
                var conf_pass = $('#confirm_password');
                if (pass_val == "" || pass_val == null) {
                    pass_err = 1;
                } else {
                    if (pass_val == conf_pass_val) {
                        conf_pass.removeClass('input-invalid');
                        conf_pass.addClass('input-valid');
                        conf_pass.closest('.form-group').find('.valid-msg').hide();
                        pass_err = 0;
                    } else {
                        conf_pass.addClass('input-invalid');
                        conf_pass.removeClass('input-valid');
                        conf_pass.closest('.form-group').find('.valid-msg').show();
                        pass_err = 1;
                    }
                }
            });

            $("#form-upload-picture").submit(function(e) {
                e.preventDefault();
                if (valid_image == true) {
                    var formData = new FormData(this);
                    formData.append('_token', token);
                    $.ajax({
                        url: '../user/update-member-picture',
                        type: 'POST',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $('.preloader').css('display', '');
                        },
                        success: function(response) {
                            //console.log(response);
                            $('.preloader').css('display', 'none');
                            swal({
                                title: "Success!",
                                text: "Profile picture successfully changed",
                                type: "success",
                            });
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        },
                        error: function(error) {
                            //console.log('Updating submitting error...');
                            console.log(error);
                            console.log(error.responseJSON.message);
                            $('.preloader').css('display', '');
                            swal({
                                title: "Error!",
                                text: "Error message: " + error.responseJSON.message +
                                    "",
                                type: "error",
                            });
                        }
                    });
                } else {
                    swal({
                        title: "Warning!",
                        text: "Invalid image type",
                        type: "warning",
                    });
                }
            });

            $("#personal_info_form").submit(function(e) {
                e.preventDefault();
                var form_data = new FormData(this);
                form_data.append('_token', token);
                $.ajax({
                    url: '../user/update-member-profile',
                    type: 'POST',
                    data: form_data,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.preloader').css('display', '');
                    },
                    success: function(response) {
                        $('.preloader').css('display', 'none');
                        swal({
                            title: "Success!",
                            text: "Personal info updated successfully.",
                            type: "success",
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1500);

                    },
                    error: function(error) {
                        console.log(error);
                        $('.preloader').css('display', 'none');
                        swal({
                            title: "Oops",
                            text: 'Something went wrong, please try again later.',
                            type: "error",
                        });
                    }
                });
            });

            $("#account_form").submit(function(e) {
                e.preventDefault();
                var form_data = new FormData(this);
                form_data.append('_token', token);
                var user_name = $('#user_name').val();
                var old_user_name = $('#old_user_name').val();
                var email = $('#email').val();
                var old_email = $('#email').val();

                var team_name = $('#team_name').val();
                var bank_name = $('#bank_name').val();
                var account_number = $('#account_number').val();

                if (user_name == old_user_name && email == old_email) {

                } else {
                    $.ajax({
                        url: '../user/update-member-account',
                        type: 'POST',
                        data: form_data,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $('.preloader').css('display', '');
                        },
                        success: function(response) {
                            $('.preloader').css('display', 'none');
                            swal({
                                title: "Success!",
                                text: "Personal info updated successfully.",
                                type: "success",
                            });
                            setTimeout(function() {
                                location.reload();
                            }, 1500);

                        },
                        error: function(error) {
                            console.log(error);
                            $('.preloader').css('display', 'none');
                            swal({
                                title: "Oops",
                                text: 'Something went wrong, please try again later.',
                                type: "error",
                            });
                        }
                    });
                }
            });

            $("#credential_form").submit(function(e) {
                e.preventDefault();
                var form_data = new FormData(this);
                form_data.append('_token', token);
                if (pass_err == 0) {
                    $.ajax({
                        url: '../user/update-member-password',
                        type: 'POST',
                        data: form_data,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $('.preloader').css('display', '');
                        },
                        success: function(response) {
                            $('.preloader').css('display', 'none');
                            swal({
                                title: "Success!",
                                text: "Password successfully changed.",
                                type: "success",
                            });
                            setTimeout(function() {
                                location.reload();
                            }, 1500);

                        },
                        error: function(error) {
                            console.log(error);
                            var err_msg = error.responseJSON.message;
                            if (err_msg == "Please check empty or invalid input fields." ||
                                err_msg == "Wrong Password" || err_msg == "Password Not match"
                            ) {
                                err_msg = error.responseJSON.message;
                            } else {
                                err_msg = "Something went wrong, please try again later"
                            }
                            $('.preloader').css('display', 'none');
                            swal({
                                title: "Oops",
                                text: err_msg,
                                type: "error",
                            });
                        }
                    });
                }
            });

        });

        function getProvinceData() {
            var prov_id = $('#province_hidden').val();
            var city_id = $('#city_hidden').val();
            $.ajax({
                url: '../get-province',
                type: 'GET',
                beforeSend: function() {
                    //console.log('Getting data ...');
                },
                success: function(response) {
                    //console.log('Getting data success...');
                    //console.log(response);
                    city_data = response.city;
                    //setting province data
                    $('#province_id').empty();
                    $('#province_id').append('<option value="">Select</option>');
                    $.each(response.province, function(i, value) {
                        $('#province_id').append('<option value="' + value.provCode + '">' + value
                            .provDesc + '</option>');
                    });

                    $('#province_id').val(prov_id);

                    $('#city_id').empty();
                    $('#city_id').append('<option value="">Select</option>');
                    $.each(city_data, function(i, value) {
                        if (value.provCode == prov_id) {
                            $('#city_id').append('<option value="' + value.citymunCode + '">' + value
                                .citymunDesc + '</option>');
                        }
                    });
                    $('#city_id').val(city_id);

                    $(".pre-loading").fadeOut("slow");
                },
                error: function(error) {
                    console.log('Getting data error...');
                    console.log(error);
                }
            });
        }

        function getBanks() {

            $.ajax({
                url: '../get-banks',
                type: 'GET',
                beforeSend: function() {
                    //console.log('Getting data ...');
                },
                success: function(response) {
                    $('#bank_name').empty();
                    $('#bank_name').append('<option value="" selected disabled>Select Bank</option>');
                    $.each(response, function(i, value) {
                        $('#bank_name').append('<option value="' + value.id + '">' + value.name +
                            '</option>');
                    });

                    $('#bank_name').val(
                        @if (!empty($user_data))
                            {{ $user_data->bank_name }}
                        @endif );

                    $(".pre-loading").fadeOut("slow");
                },
                error: function(error) {
                    console.log('Getting data error...');
                    console.log(error);
                }
            });
        }

        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#image-preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

@endsection
