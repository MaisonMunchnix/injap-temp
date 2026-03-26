@extends('layouts.default.admin.master')
@section('title', 'Approve Application')
@section('page-title', 'Approve User Application')
@section('stylesheets')
<style>
    .valid-msg {
        display: none;
        color: red;
    }
</style>
@endsection
@section('content')
    <div class="content-body">
        <div class="content">
            <div class="page-header">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin-dashboard') }}">Admin</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('applications.pending') }}">Pending Applications</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                    </ol>
                </nav>
            </div>

            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Application Details</h6>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Name:</strong></label>
                                <p>{{ $user->info->first_name }} {{ $user->info->last_name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Email:</strong></label>
                                <p>{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Username:</strong></label>
                                <p>{{ $user->username }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Phone:</strong></label>
                                <p>{{ $user->info->mobile_no }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Country:</strong></label>
                                <p>{{ $user->info->country_name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Birthday:</strong></label>
                                <p>{{ $user->info->birthdate }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Address:</strong></label>
                                <p>{{ $user->info->address }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Member Type:</strong></label>
                                <p>
                                    <span class="badge badge-{{ $application->member_type == 'Regular' ? 'info' : ($application->member_type == 'Mega' ? 'warning' : 'danger') }}">
                                        {{ $application->member_type }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Sponsor ID:</strong></label>
                                <p><code>{{ $application->sponsor_id }}</code></p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h6 class="card-title mt-4">Set Account Password and Sponsor</h6>
                    
                    <form id="approveForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password"><strong>Set Password *</strong></label>
                                    <input type="password" class="form-control" id="password" name="password" required placeholder="Enter password (min. 8 characters)">
                                    <small class="text-muted">Password must be at least 8 characters long</small>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirm"><strong>Confirm Password *</strong></label>
                                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" required placeholder="Confirm password">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><strong>Sponsor ID *</strong></label>
                                    <input type="text" class="form-control" id="sponsor"
                                        name="sponsor" placeholder="Enter sponsor id" value="{{ $application->sponsor_input }}" readonly>
                                    <div class="valid-msg">
                                        <span id="msg_sponsor">Invalid sponsorID!</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><strong>Upline Sponsor ID *</strong></label>
                                    <input type="text" class="form-control" id="upline_placement"
                                        name="upline_placement" placeholder="Enter Upline SponsorID"
                                        required>
                                    <div class="valid-msg">
                                        <span id="msg_upline">Invalid upline sponsorID!</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group" id="position_group">
                                    <label><strong>Position *</strong></label>
                                    <select class="form-control" name="position" id="position" required>
                                        <option value="" selected disabled>Select Position</option>
                                        <option value="left">Left Position</option>
                                        <option value="right">Right Position</option>
                                    </select>
                                    <div class="valid-msg">
                                        <span id="msg_position">Position is not available!</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-success" id="submitBtn">
                                <i class="feather icon-check"></i> Approve & Activate Account
                            </button>
                            <a href="{{ route('applications.pending') }}" class="btn btn-secondary">
                                <i class="feather icon-x"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const CHECK_UPLINE_URL = "{{ route('check-upline', ['username' => '__username__']) }}";
        $(document).ready(function() {
            $("#upline_placement").change(function() {
                var val = $(this).val();
                var dis = $(this);
                console.log(val)
                checkUpline(val, dis);
            });
            function checkUpline(username, dis) {
                let url = CHECK_UPLINE_URL.replace('__username__', username);
                var data;
                $.ajax({
                    url: url,
                    type: 'GET',
                    beforeSend: function() {
                        $('#msg_upline').text('');
                        $('#position_group').show();
                        $('#position').removeAttr('disabled').prop('selectedIndex', 0).prop("disabled", false);
                        $("#position option[value=right]").attr('disabled', false);
                        $("#position option[value=left]").attr('disabled', false);
                        $('.preloader').css('display', '');
                    },
                    success: function(response) {
                        if (response.msg == 'upline_ok') {

                            dis.removeClass('input-invalid');
                            dis.addClass('input-valid');
                            dis.closest('.form-group').find('.valid-msg').hide();

                            if (response.upline_available == 'left') {
                                $("#position option[value=right]").attr('disabled', 'disabled');
                                $('#position').val('left').change();
                                dis.closest('.form-group').find('.valid-msg').show();
                                $('#msg_upline').text('Only Left Position is Available').css("color", "#e67e22");

                            } else if (response.upline_available == 'right') {
                                $("#position option[value=left]").attr('disabled', 'disabled');
                                $('#position').val('right').change();
                                dis.closest('.form-group').find('.valid-msg').show();
                                $('#msg_upline').text('Only Right Position is Available').css("color", "#e67e22");

                            } else {
                                dis.closest('.form-group').find('.valid-msg').show();
                                $('#msg_upline').text('All Available Position').css("color", "#2ecc71");

                            }
                            $('#submitBtn').attr('disabled', false);
                            err_upline = 0;
                        } else if (response.msg == 'upline_err') {
                            dis.addClass('input-invalid');
                            dis.removeClass('input-valid');
                            $('#position_group').hide();
                            $('#submitBtn').attr('disabled', true);
                            dis.closest('.form-group').find('.valid-msg').show();
                            $('#msg_upline').text('Upline already full!').css("color", "#e74c3c");

                            err_upline = 1;
                        } else if (response.msg == 'username_invalid') {
                            $('#position_group').hide();
                            dis.addClass('input-invalid');
                            dis.removeClass('input-valid');
                            $('#submitBtn').attr('disabled', true);
                            dis.closest('.form-group').find('.valid-msg').show();
                            $('#msg_upline').text('Invalid upline sponsor ID!').css("color", "#e74c3c");
                            dis.closest('.form-group').find('.valid-msg').show();
                            err_upline = 1;
                        } else {
                            dis.addClass('input-invalid');
                            dis.removeClass('input-valid');
                            $('#submitBtn').attr('disabled', true);
                            dis.closest('.form-group').find('.valid-msg').show();
                            $('#msg_upline').text('Error!').css("color", "#e74c3c");
                            err_upline = 1;
                        }
                        $('.preloader').css('display', 'none');
                    },
                    error: function(error) {
                        console.log(error);
                        $('.preloader').css('display', 'none');
                    }
                });
            }
            //check sponsor
            $("#sponsor").change(function() {
                var val = $(this).val();
                var dis = $(this);
                console.log(val)
                checkSponsor(val, dis);
            });
            function checkSponsor(username, dis) {
                let url = CHECK_UPLINE_URL.replace('__username__', username);
                var data;
                $.ajax({
                    url: url,
                    type: 'GET',
                    beforeSend: function() {
                        $('#msg_sponsor').text('');
                        $('.preloader').css('display', '');
                    },
                    success: function(response) {
                        if (response.msg == 'upline_ok') {
                            dis.removeClass('input-invalid');
                            dis.addClass('input-valid');
                            dis.closest('.form-group').find('.valid-msg').hide();
                            $('#submitBtn').attr('disabled', false);
                            err_upline = 0;
                        } else if (response.msg == 'username_invalid') {
                            dis.addClass('input-invalid');
                            dis.removeClass('input-valid');
                            $('#submitBtn').attr('disabled', true);
                            dis.closest('.form-group').find('.valid-msg').show();
                            $('#msg_sponsor').text('Invalid sponsor ID!').css("color", "#e74c3c");
                            dis.closest('.form-group').find('.valid-msg').show();
                            err_upline = 1;
                        } else {
                            dis.addClass('input-invalid');
                            dis.removeClass('input-valid');
                            $('#submitBtn').attr('disabled', true);
                            dis.closest('.form-group').find('.valid-msg').show();
                            $('#msg_sponsor').text('Error!').css("color", "#e74c3c");
                            err_upline = 1;
                        }
                        $('.preloader').css('display', 'none');
                    },
                    error: function(error) {
                        console.log(error);
                        $('.preloader').css('display', 'none');
                    }
                });
            }
            $('#approveForm').on('submit', function(e) {
                e.preventDefault();

                var password = $('#password').val();
                var passwordConfirm = $('#password_confirm').val();
                var sponsor = $('#sponsor').val();
                var upline_placement = $('#upline_placement').val();
                var position = $('#position').val();

                // Validate passwords match
                if (password !== passwordConfirm) {
                    alert('Passwords do not match!');
                    return;
                }

                // Validate password length
                if (password.length < 8) {
                    alert('Password must be at least 8 characters long!');
                    return;
                }

                var formData = {
                    _token: '{{ csrf_token() }}',
                    password: password,
                    sponsor: sponsor,
                    upline_placement: upline_placement,
                    position: position
                };

                $('#submitBtn').prop('disabled', true).html('<i class="feather icon-loader"></i> Processing...');

                $.ajax({
                    url: '/staff/applications/approve/{{ $user->id }}',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            swal({
                                title: "Success!",
                                text: response.message,
                                type: "success",
                                confirmButtonText: "OK"
                            }).then(function() {
                                window.location.href = '{{ route('applications.pending') }}';
                            });
                        } else {
                            swal("Error", response.message, "error");
                            $('#submitBtn').prop('disabled', false).html('<i class="feather icon-check"></i> Approve & Activate Account');
                        }
                    },
                    error: function(error) {
                        var message = 'Something went wrong. Please try again.';
                        if (error.responseJSON && error.responseJSON.message) {
                            message = error.responseJSON.message;
                        }
                        swal("Error", message, "error");
                        $('#submitBtn').prop('disabled', false).html('<i class="feather icon-check"></i> Approve & Activate Account');
                    }
                });
            });
        });
    </script>
@endsection
