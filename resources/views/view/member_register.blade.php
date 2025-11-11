<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration | {{ env('APP_NAME') }}</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicons/favicon.ico') }}" />
    <!-- Plugin styles -->
    <link rel="stylesheet" href="{{ asset('dashboard//vendors/bundle.css') }}" type="text/css">
    <!-- App styles -->
    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/app.min.css') }}" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css"
        integrity="sha512-kq3FES+RuuGoBW3a9R2ELYKRywUEQv0wvPTItv3DSGqjpbNtGWVdvT8qwdKkqvPzT93jp8tSF4+oN4IeTEIlQA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        .container {
            margin-top: 100px;
        }

        .form-group {
            text-transform: capitalize !important;
        }

        .content-footer {
            margin-left: 0px !important;
        }

        .logo {
            max-width: 200px !important;
        }
    </style>
</head>

<body>
    <!-- begin::preloader-->
    <div class="preloader">
        <div class="preloader-icon"></div>
    </div>
    <!-- end::preloader -->
    <!-- begin::main -->
    <div class="layout-wrapper">
        <!-- begin::header -->
        <div class="header d-print-none">
            <div class="header-left">
                <div class="header-logo">
                    <a href="{{ route('member-login') }}">
                        <img class="logo" src="{{ asset('images/logo.png') }}" alt="logo">
                    </a>
                </div>
            </div>

            <div class="header-body">
                <div class="header-body-left">
                    <div class="page-title">
                        <h4>{{ ENV('APP_NAME') }} Registration Form</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- end::header -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <!-- <h6 class="card-title"> Basic Form Wizard with Validation</h6> -->
                        <section class="card card-body border mb-0">



                            <div class="mbg-3 alert alert-success alert-dismissible fade show" role="alert">
                                Activation Code :
                            </div>


                            <form id="register_form" method="POST" action="">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Code</label>
                                            <input type="text" class="form-control" id="code" name="code"
                                                placeholder="Enter code" required>
                                            <div class="valid-msg">
                                                Invalid code!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Security Pin</label>
                                            <input type="text" class="form-control" id="pin" name="pin"
                                                placeholder="Enter pin" required>
                                            <div class="valid-msg">
                                                Invalid pin!
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="mbg-3 alert alert-success alert-dismissible fade show" role="alert">
                                    Account Extension (For those with existing account only.)
                                </div>



                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="chk_extension"
                                        name="chk_extension" value="false">
                                    <label class="form-check-label" for="exampleCheck1">Check if this account is an
                                        extension</label>
                                </div>
                                <div class="form-group">
                                    <label>Primary Account Username</label>
                                    <input type="text" class="form-control" id="primary_user" name="primary_user"
                                        placeholder="Enter primary username" readOnly>
                                    <div class="valid-msg">
                                        Invalid primary account username
                                    </div>
                                </div>
                                <br />



                                <div class="mbg-3 alert alert-success alert-dismissible fade show" role="alert">
                                    Personal Information :
                                </div>



                                <div id="personal_info">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>First name</label>
                                                <input type="text" class="form-control no-valid" id="first_name"
                                                    name="first_name" placeholder="Enter First name" required>
                                                <div class="valid-msg">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Middle name</label>
                                                <input type="text" class="form-control no-valid" id="middle_name"
                                                    name="middle_name" placeholder="Enter middle name" required>
                                                <div class="valid-msg">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Last name</label>
                                                <input type="text" class="form-control no-valid" id="last_name"
                                                    name="last_name" placeholder="Enter last name" required>
                                                <div class="valid-msg">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Mobile number</label>
                                                <input type="text" class="form-control" id="mobile_no"
                                                    name="mobile_no" placeholder="Enter mobile number">
                                                <div class="valid-msg">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Birth Date</label>
                                                <input type="date" class="form-control" id="birth_date"
                                                    name="birth_date" placeholder="Enter birth date">
                                                <div class="valid-msg">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br />


                                <div class="mbg-3 alert alert-success alert-dismissible fade show" role="alert">
                                    Address Information :
                                </div>


                                <div id="address_info">
                                    <div class="form-group">
                                        <label class="form-control-label">Full address: <span
                                                class="tx-danger">*</span></label>
                                        <textarea class="form-control" id="full_address" name="full_address" placeholder="Enter full address"></textarea>
                                        <div class="valid-msg">
                                            Looks good!
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Country: <span
                                                        class="tx-danger">*</span></label>
                                                <select class="form-control" id="country" name="country">
                                                    <option value="">Select Country</option>
                                                </select>
                                                <div class="valid-msg">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Province: <span
                                                        class="tx-danger">*</span></label>
                                                <select class="form-control" id="province" name="province">
                                                    <option value="">Select</option>
                                                </select>
                                                <input type="text" class="form-control" name="province_name"
                                                    id="province_name" placeholder="Province Name">
                                                <div class="valid-msg">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-control-label">City: <span
                                                        class="tx-danger">*</span></label>
                                                <select class="form-control" id="city" name="city">
                                                    <option value="">Select</option>
                                                </select>
                                                <input type="text" class="form-control" name="city_name"
                                                    id="city_name" placeholder="City Name">
                                                <div class="valid-msg">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="bank_info">


                                    <div class="mbg-3 alert alert-success alert-dismissible fade show" role="alert">
                                        Bank Information :
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Bank Name</label>
                                                <select class="form-control" id="bank_name" name="bank_name">
                                                    <option value="">Select</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Account Number</label>
                                                <input type="text" class="form-control" name="account_number"
                                                    id="account_number" placeholder="Account Number">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="other-info">



                                    <div class="mbg-3 alert alert-success alert-dismissible fade show" role="alert">
                                        Other Information :
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Team Name</label>
                                                <input type="text" class="form-control" name="team_name"
                                                    id="team_name" placeholder="Team Name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>TAX Identification Number (TIN)</label>
                                                <input type="text" class="form-control" name="tin"
                                                    id="tin" placeholder="TAX Identification Number (TIN)">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="account_details">
                                    <br />



                                    <div class="mbg-3 alert alert-success alert-dismissible fade show" role="alert">
                                        Account Details :
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email Address</label>
                                                <input type="email" class="form-control" id="email_address"
                                                    name="email_address" placeholder="Enter email address" required>
                                                <div class="valid-msg">
                                                    Email already taken.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input type="text" class="form-control" id="user_name"
                                                    name="user_name" placeholder="Enter user name" required>
                                                <div class="valid-msg">
                                                    Username already taken.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" class="form-control" id="password"
                                                    name="password" placeholder="Enter password" required>
                                                <div class="valid-msg">
                                                    Minimum of 6 characters.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <input type="password" class="form-control" id="conf_password"
                                                    name="conf_password" placeholder="Confirm password" required>
                                                <div class="valid-msg">
                                                    Password not match!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Sponsor</label>
                                                <input type="text" class="form-control" id="sponsor"
                                                    name="sponsor" placeholder="Enter sponsor username" required>
                                                <div class="valid-msg">
                                                    Invalid sponsor username!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Upline Placement</label>
                                                <input type="text" class="form-control" id="upline_placement"
                                                    name="upline_placement" placeholder="Enter placement username"
                                                    required>
                                                <div class="valid-msg">
                                                    <span id="msg_upline">Invalid upline placement username!</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group" id="position_group">
                                                <label>Position</label>
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
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="wrapper" style="height: 400px;">
                                            <object data="{{ asset('Terms-and-Conditions.pdf') }}" width="100%"
                                                height="100%">
                                                <p>Your web browser doesn't have a PDF Plugin. Instead you can <a
                                                        href="http://partners.adobe.com/public/developer/en/acrobat/PDFOpenParameters.pdf">
                                                        Click here to download the PDF</a></p>
                                            </object>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        Terms &amp; Conditions *Members Policy<br>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <span class="text-primary">
                                                    <input type="checkbox" class="form-check-input" name="agree"
                                                        id="agree" required>Please Check to agree
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary pull-right" type="submit"
                                        id="submit_button">Submit</button>
                                    <a href="{{ route('login') }}" class="btn btn-primary" type="button">Back to
                                        login</a>
                                </div>
                            </form>
                        </section>
                    </div>


                </div>
                <!-- begin::footer -->
                <div class="col-md-12">
                    <footer class="content-footer">
                        <div>{{ env('APP_NAME') }} © {{ date('Y') }} <a href="{{ env('APP_URL') }}"
                                target="_blank"></a></div>
                    </footer>
                </div>
                <!-- end::footer -->
            </div>



        </div>

    </div>
    <!-- end::main -->

    <!-- Plugin scripts -->
    <script src="{{ asset('dashboard/vendors/bundle.js') }}"></script>

    <!-- App scripts -->
    <script src="{{ asset('dashboard/assets/js/app.min.js') }}"></script>
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        var title = "{{ env('APP_NAME') }}";
        $('select').select2({
            theme: "bootstrap"
        });

        $('#submit_button').prop('disabled', true);
        $('input[type="checkbox"]').click(function() {
            if ($(this).prop("checked") == true) {
                $('#submit_button').prop('disabled', false);
            } else if ($(this).prop("checked") == false) {
                $('#submit_button').prop('disabled', true);
            }
        });
        $("#province").hide();
        $("#city").hide();
        $("#province_name").hide();
        $("#city_name").hide();

        var token = "{{ csrf_token() }}";
        var city_data;
        var err_code = 0,
            err_pin = 0,
            err_pass = 1,
            err_email = 0,
            err_username = 0,
            err_sponsor = 0,
            err_upline = 0,
            err_extension = 0;
        $(document).ready(function() {
            getAddressData();
            getBanks();
            getCountries();

            $('#chk_extension').click(function() {
                var val = $('#chk_extension').val();;
                if (val == 'false') {
                    $('#chk_extension').val('true');
                    $('#primary_user').removeAttr('readOnly');
                    $('#first_name').attr('readOnly', true);
                    $('#last_name').attr('readOnly', true);
                    $('#middle_name').attr('readOnly', true);
                    $('#mobile_no').attr('readOnly', true);
                    $('#birth_date').attr('readOnly', true);
                    $('#full_address').attr('readOnly', true);
                    //$('#email_address').attr('readOnly', false);

                    $('#bank_name').attr('disabled', 'disabled');
                    $('#account_number').attr('readOnly', true);
                    $('#team_name').attr('readOnly', true);
                    $('#tin').attr('readOnly', true);
                    console.log('Checked');
                    err_extension = 1;
                } else {
                    $('#chk_extension').val('false');
                    $('#primary_user').attr('readOnly', true).val('');

                    $('#first_name').removeAttr('readOnly').val('');
                    $('#last_name').removeAttr('readOnly').val('');
                    $('#middle_name').removeAttr('readOnly').val('');
                    $('#mobile_no').removeAttr('readOnly').val('');
                    $('#birth_date').removeAttr('readOnly').val('');
                    $('#full_address').removeAttr('readOnly').val('');
                    $("#province_name").val('').hide();
                    $("#city_name").val('').hide()
                    //$('#email_address').removeAttr('readOnly').val('');


                    $('#bank_name').removeAttr('disabled').val('');
                    $('#account_number').removeAttr('readOnly').val('');
                    $('#team_name').removeAttr('readOnly').val('');
                    $('#tin').removeAttr('readOnly').val('');
                    err_extension = 0;
                    getBanks();
                }
            });

            $('#primary_user').change(function() {
                var val = $(this).val();
                var dis = $(this);
                if (val) {
                    $.ajax({
                        url: './get-acc-ext-details/' + val,
                        type: 'GET',
                        beforeSend: function() {
                            $('.preloader').css('display', '');
                        },
                        success: function(response) {
                            if (response.result == false || response.result == 'false') {
                                err_extension = 1;
                                dis.addClass('input-invalid');
                                dis.removeClass('input-valid');
                                dis.closest('.form-group').find('.valid-msg').show();
                            } else {
                                err_extension = 0;
                                $('#first_name').val(response.result.first_name);
                                $('#last_name').val(response.result.last_name);
                                $('#middle_name').val(response.result.middle_name);
                                $('#mobile_no').val(response.result.mobile_no);
                                $('#birth_date').val(response.result.birthdate);

                                if (response.result.address) {
                                    $('#full_address').val(response.result.address);
                                } else {
                                    $('#full_address').removeAttr('readOnly');
                                }

                                if (response.result.province_id) {
                                    $('#province').val(response.result.province_id);
                                    $('#province_name').val(response.result.province_name);
                                    $('#province').trigger('change');
                                } else {
                                    $('#province').removeAttr('disabled');
                                }

                                if (response.result.country_id) {
                                    $('#country').val(response.result.country_id);
                                    $('#city_name').val(response.result.city_name);
                                    $('#country').trigger('change');
                                } else {
                                    $('#country').removeAttr('disabled');
                                }

                                if (response.result.city_id) {
                                    $('#city').empty();
                                    $('#city').append('<option value="">Select</option>');
                                    if (response.result.province_id != 0 || response.result
                                        .province_id != "") {
                                        $.each(city_data, function(i, value) {
                                            if (value.provCode == response.result
                                                .province_id) {
                                                $('#city').append('<option value="' +
                                                    value
                                                    .citymunCode + '">' + value
                                                    .citymunDesc + '</option>');
                                            }
                                        });
                                    }

                                    $('#city').val(response.result.city_id);
                                } else {
                                    $('#city').removeAttr('disabled');
                                }



                                $('#email_address').val(response.result.email);

                                if (response.result.bank_name) {
                                    $('#bank_name').val(response.result.bank_name);
                                } else {
                                    $('#bank_name').removeAttr('disabled');
                                }

                                if (response.result.bank_account_number) {
                                    $('#account_number').val(response.result
                                        .bank_account_number);
                                } else {
                                    $('#account_number').removeAttr('readOnly').val('');
                                }

                                if (response.result.team_name) {
                                    $('#team_name').val(response.result.team_name);
                                } else {
                                    $('#team_name').removeAttr('readOnly').val('').attr(
                                        'required',
                                        'required');
                                }

                                if (response.result.tin) {
                                    $('#tin').val(response.result.tin);
                                } else {
                                    $('#tin').removeAttr('readOnly').val('').attr('required',
                                        'required');
                                }

                                dis.removeClass('input-invalid');
                                dis.addClass('input-valid');
                                dis.closest('.form-group').find('.valid-msg').hide();
                            }
                            $('.preloader').css('display', 'none');
                        },
                        error: function(error) {
                            console.log(error);
                            $('.preloader').css('display', 'none');
                        }
                    });
                }
            });

            $("#province").change(function(event) {
                var dis_val = $(this).val();
                $('#city').empty();
                $('#city').append('<option value="">Select</option>');
                $.each(city_data, function(i, value) {
                    if (value.provCode == dis_val) {
                        $('#city').append('<option value="' + value.citymunCode + '">' + value
                            .citymunDesc + '</option>');
                    }
                });
            });

            $("#country").change(function(event) {
                var country_id = $(this).val();
                if (country_id != 169) {
                    $("#province").hide().prop('disabled', true);
                    $("#city").hide().prop('disabled', true);
                    $("#province_name").show();
                    $("#city_name").show();
                } else {
                    $("#province").show().prop('disabled', false);
                    $("#city").show().prop('disabled', false);
                    $("#province_name").hide();
                    $("#city_name").hide();
                }
            });

            $("#register_form").submit(function(e) {
                e.preventDefault();
                var form_data = new FormData(this);
                var form_control_count = 0;
                var count_err = 0;
                /* $('.form-control').each(function(i, obj) {
                    var val = $(this).val();
                    if(val=="" || val==null){
                        form_control_count++;
                    }
                }); */

                count_err = form_control_count + err_code + err_pin + err_email + err_username +
                    err_sponsor + err_upline + err_extension;

                if (count_err == 0) {
                    form_data.append('_token', token);
                    $.ajax({
                        url: './save-member-register',
                        type: 'POST',
                        data: form_data,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $('.preloader').css('display', '');
                            $('#province').removeAttr('disabled');
                            $('#city').removeAttr('disabled');
                            $('#bank_name').removeAttr('disabled');
                        },
                        success: function(response) {
                            $('.preloader').css('display', 'none');
                            swal({
                                title: "Success!",
                                text: "Registered successfully.",
                                icon: "success",
                            }).then(function() {
                                location.reload();
                            });
                        },
                        error: function(error) {
                            console.log(error);
                            var err_msg = error.responseJSON.message;
                            if (err_msg == "Invalid activation code" || err_msg ==
                                "Username is already taken" || err_msg == "Invalid sponsor" ||
                                err_msg == "Invalid upline placement" || err_msg ==
                                "Invalid account extension username" || err_msg ==
                                "Invalid placement position. Sponsor crosslining" || err_msg ==
                                "Maximum of seven accounts only.") {
                                err_msg = error.responseJSON.message;
                            } else if (err_msg == 'invalid_crosslining') {
                                err_msg =
                                    'Registration Failed. Crosslining is not allowed please input other upline.';
                            } else {
                                err_msg = "Something went wrong, please try again later.";
                            }
                            $('.preloader').css('display', 'none');
                            swal({
                                title: "Oops",
                                text: err_msg,
                                icon: "error",
                            });
                        }
                    });
                } else {
                    swal({
                        title: "Oops",
                        text: "Please check invalid or empty input fields.",
                        icon: "error",
                    });
                }
            });

            /*  $("#code").change(function () {
                 var val=$(this).val();
                 var dis=$(this);
                 checkCode(val,dis);
             }); */

            /* $("#pin").change(function () {
                var code=$('#code').val();
                var pin=$(this).val();
                var dis=$(this);
                checkPin(code,pin,dis)
            }); */

            $('.no-valid').change(function() {
                var val = $(this).val();
                var dis = $(this);
                if (val == "") {
                    dis.addClass('input-invalid');
                    dis.removeClass('input-valid');
                } else {
                    dis.addClass('input-valid');
                    dis.removeClass('input-invalid');
                }
            });

            $("#password").change(function() {
                var pass_val = $('#password').val();
                var conf_pass_val = $('#conf_password').val();
                var pass = $('#password');
                var conf_pass = $('#conf_password');
                if (pass_val.length < 6) {
                    pass.addClass('input-invalid');
                    pass.removeClass('input-valid');
                    pass.closest('.form-group').find('.valid-msg').show();
                    err_pass = 1;
                } else {
                    pass.removeClass('input-invalid');
                    pass.addClass('input-valid');
                    pass.closest('.form-group').find('.valid-msg').hide();
                }

                if (conf_pass_val == "" || conf_pass_val == null) {
                    err_pass = 1;
                } else {
                    if (pass_val == conf_pass_val) {
                        conf_pass.removeClass('input-invalid');
                        conf_pass.addClass('input-valid');
                        conf_pass.closest('.form-group').find('.valid-msg').hide();
                        err_pass = 0;
                    } else {
                        conf_pass.addClass('input-invalid');
                        conf_pass.removeClass('input-valid');
                        conf_pass.closest('.form-group').find('.valid-msg').show();
                        err_pass = 1;
                    }
                }
            });

            $("#conf_password").change(function() {
                var pass_val = $('#password').val();
                var conf_pass_val = $('#conf_password').val();
                var pass = $('#password');
                var conf_pass = $('#conf_password');
                if (pass_val == "" || pass_val == null) {
                    err_pass = 1;
                } else {
                    if (pass_val == conf_pass_val) {
                        conf_pass.removeClass('input-invalid');
                        conf_pass.addClass('input-valid');
                        conf_pass.closest('.form-group').find('.valid-msg').hide();
                        err_pass = 0;
                    } else {
                        conf_pass.addClass('input-invalid');
                        conf_pass.removeClass('input-valid');
                        conf_pass.closest('.form-group').find('.valid-msg').show();
                        err_pass = 1;
                    }
                }
            });

            /* $("#email_address").change(function () {
                var val=$(this).val();
                var dis=$(this);
                checkRegEmail(val,dis);
            }); */

            /* $("#user_name").change(function () {
                var val=$(this).val();
                var dis=$(this);
                checkRegUserName(val,dis);
            }); */

            /*  $("#sponsor").change(function () {
                 var val=$(this).val();
                 var dis=$(this);
                 checkSponsor(val,dis);
             }); */

            $("#upline_placement").change(function() {
                var val = $(this).val();
                var dis = $(this);
                checkUpline(val, dis);
            });
        });

        function getAddressData() {
            $.ajax({
                url: './get-province',
                type: 'GET',
                beforeSend: function() {
                    //console.log('Getting data ...');
                },
                success: function(response) {
                    city_data = response.city;
                    $('#province').empty();
                    $('#province').append('<option value="">Select</option>');
                    $.each(response.province, function(i, value) {
                        $('#province').append('<option value="' + value.provCode + '">' + value
                            .provDesc + '</option>');
                    });
                    //$(".pre-loading").fadeOut("slow");
                },
                error: function(error) {
                    console.log('Getting data error...');
                    console.log(error);
                }
            });
        }

        function checkCode(code, dis) {
            var data;
            $.ajax({
                url: './check-package-code/' + code,
                type: 'GET',
                beforeSend: function() {
                    $('.preloader').css('display', '');
                },
                success: function(response) {
                    if (response.valid_code == false || response.valid_code == 'false') {
                        dis.addClass('input-invalid');
                        dis.removeClass('input-valid');
                        dis.closest('.form-group').find('.valid-msg').show();
                        $('#pin').attr('readOnly');
                        err_code = 1;
                    } else {
                        dis.removeClass('input-invalid');
                        dis.addClass('input-valid');
                        dis.closest('.form-group').find('.valid-msg').hide();
                        $('#pin').removeAttr('readOnly');
                        err_code = 0;
                    }
                    $('.preloader').css('display', 'none');
                },
                error: function(error) {
                    console.log(error);
                    $('.preloader').css('display', 'none');
                }
            });
        }

        function checkPin(code, pin, dis) {
            var data;
            $.ajax({
                url: './check-package-code-pin/' + code + '/' + pin,
                type: 'GET',
                beforeSend: function() {
                    $('.preloader').css('display', '');
                },
                success: function(response) {
                    if (response.valid_code == false || response.valid_code == 'false') {
                        dis.addClass('input-invalid');
                        dis.removeClass('input-valid');
                        dis.closest('.form-group').find('.valid-msg').show();
                        err_pin = 1;
                    } else {
                        dis.removeClass('input-invalid');
                        dis.addClass('input-valid');
                        dis.closest('.form-group').find('.valid-msg').hide();
                        err_pin = 0;
                    }
                    $('.preloader').css('display', 'none');
                },
                error: function(error) {
                    console.log(error);
                    $('.preloader').css('display', 'none');
                }
            });
        }

        function checkRegEmail(email, dis) {
            var data;
            $.ajax({
                url: './check-registered-email/' + email,
                type: 'GET',
                beforeSend: function() {
                    $('.preloader').css('display', '');
                },
                success: function(response) {
                    if (response.valid_email == true || response.valid_email == 'true') {
                        dis.addClass('input-invalid');
                        dis.removeClass('input-valid');
                        dis.closest('.form-group').find('.valid-msg').show();
                        err_email = 1;
                    } else {
                        dis.removeClass('input-invalid');
                        dis.addClass('input-valid');
                        dis.closest('.form-group').find('.valid-msg').hide();
                        err_email = 0;
                    }
                    $('.preloader').css('display', 'none');
                },
                error: function(error) {
                    console.log(error);
                    $('.preloader').css('display', 'none');
                }
            });
        }

        function checkRegUserName(username, dis) {
            var data;
            $.ajax({
                url: './check-registered-username/' + username,
                type: 'GET',
                beforeSend: function() {
                    $('.preloader').css('display', '');
                },
                success: function(response) {
                    if (response.valid_username == true || response.valid_username == 'true') {
                        dis.addClass('input-invalid');
                        dis.removeClass('input-valid');
                        dis.closest('.form-group').find('.valid-msg').show();
                        err_username = 1;
                    } else {
                        dis.removeClass('input-invalid');
                        dis.addClass('input-valid');
                        dis.closest('.form-group').find('.valid-msg').hide();
                        err_username = 0;
                    }
                    $('.preloader').css('display', 'none');
                },
                error: function(error) {
                    console.log(error);
                    $('.preloader').css('display', 'none');
                }
            });
        }

        function checkSponsor(username, dis) {
            var data;
            $.ajax({
                url: './check-sponsor/' + username,
                type: 'GET',
                beforeSend: function() {
                    $('.preloader').css('display', '');
                },
                success: function(response) {
                    if (response.valid_username == false || response.valid_username == 'false') {
                        dis.addClass('input-invalid');
                        dis.removeClass('input-valid');
                        dis.closest('.form-group').find('.valid-msg').show();
                        err_sponsor = 1;
                    } else {
                        dis.removeClass('input-invalid');
                        dis.addClass('input-valid');
                        dis.closest('.form-group').find('.valid-msg').hide();
                        err_sponsor = 0;
                    }
                    $('.preloader').css('display', 'none');
                },
                error: function(error) {
                    console.log(error);
                    $('.preloader').css('display', 'none');
                }
            });
        }

        function checkUpline(username, dis) {
            console.log('check Upline');
            var data;
            $.ajax({
                url: './check-upline/' + username,
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
                            //$("#position option[value=left]").attr('selected', true);
                            $('#position').val('left').change();
                            dis.closest('.form-group').find('.valid-msg').show();
                            $('#msg_upline').text('Only Left Position is Available').css("color", "#e67e22");

                        } else if (response.upline_available == 'right') {
                            $("#position option[value=left]").attr('disabled', 'disabled');
                            //$("#position option[value=right]").attr('selected', true);
                            $('#position').val('right').change();
                            dis.closest('.form-group').find('.valid-msg').show();
                            $('#msg_upline').text('Only Right Position is Available').css("color", "#e67e22");

                        } else {
                            dis.closest('.form-group').find('.valid-msg').show();
                            $('#msg_upline').text('All Available Position').css("color", "#2ecc71");

                        }
                        $('#submit_button').attr('disabled', false);
                        err_upline = 0;
                    } else if (response.msg == 'upline_err') {
                        dis.addClass('input-invalid');
                        dis.removeClass('input-valid');
                        $('#position_group').hide();
                        $('#submit_button').attr('disabled', true);
                        dis.closest('.form-group').find('.valid-msg').show();
                        $('#msg_upline').text('Upline already full!').css("color", "#e74c3c");

                        err_upline = 1;
                    } else if (response.msg == 'username_invalid') {
                        $('#position_group').hide();
                        dis.addClass('input-invalid');
                        dis.removeClass('input-valid');
                        $('#submit_button').attr('disabled', true);
                        dis.closest('.form-group').find('.valid-msg').show();
                        $('#msg_upline').text('Invalid upline username!').css("color", "#e74c3c");
                        dis.closest('.form-group').find('.valid-msg').show();
                        err_upline = 1;
                    } else {
                        dis.addClass('input-invalid');
                        dis.removeClass('input-valid');
                        $('#submit_button').attr('disabled', true);
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

        function getBanks() {
            $.ajax({
                url: './get-banks',
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
                            $user_data - > bank_name
                        @endif );

                    $(".pre-loading").fadeOut("slow");
                },
                error: function(error) {
                    console.log('Getting data error...');
                    console.log(error);
                }
            });
        }

        function getCountries() {
            $.ajax({
                url: "{{ route('get-countries') }}",
                type: 'GET',
                beforeSend: function() {
                    //console.log('Getting data ...');
                },
                success: function(response) {
                    $.each(response, function(i, value) {
                        $('#country').append('<option value="' + value.id + '">' + value.nice_name +
                            '</option>');
                    });
                    $(".pre-loading").fadeOut("slow");
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    </script>

</body>


</html>
