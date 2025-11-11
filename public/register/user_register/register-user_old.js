//var token = "{{csrf_token()}}";
var user_network_data; //global declaration
var city_data;
var user_extension_data;
var next_click = 0;
var act_code_err = 1,
    sec_pin_err = 1,
    user_extension_err = 1,
    pass_err = 1,
    username_err = 1; //zero means no error

/* $(window).on('load', function() {
    // Animate loader off screen
    $(".pre-loading").fadeOut("slow");
}); */

$(document).ready(function() {
    getData(); //getting user userinfos network and product data

    $('.register-validate').change(function(event) {
        var dis_val = $(this).val();
        var dis = $(this);
        if (dis_val != "") {
            hideError(dis);
        }
    });

    $("#activation_code").change(function(event) {
        var dis_val = $(this).val();
        var dis = $(this);
        var sec_pin = $('#sec_pin');
        var sec_pin_val = $('#sec_pin').val();

        var count_true = 0;

        $.each(user_network_data, function(i, value) {
            if (value.code == dis_val) {
                count_true++;
            }
        });

        if (count_true >= 1 || dis_val == "") {
            //if product code is correct
            hideError(dis);
            act_code_err = 0;
        } else {
            //if the product code is not existing
            showError(dis, 'Invalid Product Code.');
            act_code_err = 1;
        }

        if (sec_pin_val != '') {
            var get_sec_pin;
            var count_true = 0;
            $.each(user_network_data, function(i, value) {
                if (value.code == dis_val) {
                    get_sec_pin = value.security_pin;
                }
            });

            if (get_sec_pin == sec_pin_val) {
                count_true++;
            }

            if (count_true >= 1) {
                hideError(dis);
                sec_pin_err = 0;
            } else {
                showError(dis, 'Invalid Security Pin.');
                sec_pin_err = 1;
            }
        }

    });

    $("#sec_pin").change(function(event) {
        var dis_val = $(this).val();
        var pcode_val = $('#activation_code').val();
        var get_sec_pin;
        var dis = $(this);

        var count_true = 0;
        $.each(user_network_data, function(i, value) {
            if (value.code == pcode_val) {
                get_sec_pin = value.security_pin;
            }
        });

        if (get_sec_pin == dis_val) {
            count_true++;
        }

        if (count_true >= 1 || dis_val == "") {
            hideError(dis);
            sec_pin_err = 0;
        } else {
            showError(dis, 'Invalid Security Pin.');
            sec_pin_err = 1;
        }
    });

    $("#primary_acct_user").change(function(event) {
        var dis_val = $(this).val();
        var dis = $(this);

        var count_true = 0;
        $.each(user_extension_data, function(i, value) {
            if (value.username == dis_val) {
                count_true++;
            }
        });

        if (count_true >= 1 || dis_val == "") {
            dis.closest('.form-group').find('.display-error').text('');
            dis.closest('.form-group').find('.display-error').addClass('d-none');
            dis.removeClass('border-red');
            user_extension_err = 0;
        } else {
            dis.closest('.form-group').find('.display-error').text('Invalid Username.');
            dis.closest('.form-group').find('.display-error').removeClass('d-none');
            dis.addClass('border-red');
            user_extension_err = 1;
        }

    });

    $("#province").change(function(event) {
        var dis_val = $(this).val();
        $('#city').empty();
        $('#city').append('<option value="">Select</option>');
        $.each(city_data, function(i, value) {
            if (value.provCode == dis_val) {
                $('#city').append('<option value="' + value.citymunCode + '">' + value.citymunDesc + '</option>');
            }
        });
    });

    $("#password").change(function(event) {
        var dis = $(this);
        var dis_val = $(this).val();
        var re_pass = $('#re_password');
        var re_pass_val = $('#re_password').val();
        if (dis_val.length >= 6) {
            hideError(dis);
            if (re_pass_val != "") {
                if (dis_val == re_pass_val) {
                    hideError(re_pass);
                    pass_err = 0;
                } else {
                    showError(re_pass, 'Password does not match.');
                    pass_err = 1;
                }
            }
        } else {
            showError(dis, 'Minimum of 6 (six) characters.');
        }
    });

    $("#re_password").change(function(event) {
        var dis = $(this);
        var dis_val = $(this).val();
        var pass = $('#password');
        var pass_val = $('#password').val();
        if (pass_val != "") {
            if (dis_val == pass_val) {
                hideError(dis);
                pass_err = 0;
            } else {
                showError(dis, 'Password does not match.');
                pass_err = 1;
            }
        }

    });

    $("#username_member").change(function(event) {
        var dis = $(this);
        var dis_val = $(this).val();
        if (dis_val.length >= 6) {
            $.ajax({
                url: '/check-username/' + dis_val,
                type: 'GET',
                beforeSend: function() {
                    console.log('Checking username ...');
                },
                success: function(response) {
                    console.log('Checking username success...');
                    console.log(response);
                    if (response.valid_username == 1) {
                        showError(dis, 'Invalid username. Please try another username.');
                        username_err = 1;
                    } else {
                        hideError(dis);
                        username_err = 0;
                    }
                },
                error: function(error) {
                    console.log('Checking username error...');
                    console.log(error);
                }
            });
        } else {
            showError(dis, 'Minimum of 6 characters.');
            username_err = 1;
        }

    });

    $('.reg-next-button').click(function(event) {
        var panel_tab_id = $(".tab-pane:visible").attr("id");
        if (next_click == 0) {
            panel_tab_id = 'activation-code-tab'
        } else {
            panel_tab_id = $(".tab-pane:visible").attr("id");
        }
        console.log('Active id: ' + panel_tab_id);

        //set fields data based on activation code / product code
        if (panel_tab_id == 'activation-code-tab') {
            var act_code = $('#activation_code').val();
            var s_pin = $('#sec_pin').val();
            var account_extension = $('#account_extension').val();
            var primary_acct_user = $('#primary_acct_user').val();
            if (act_code_err == 0 && sec_pin_err == 0 && act_code != "" && s_pin != "") {
                $('.send-loading').show();
                if (account_extension == 'yes' && primary_acct_user != "") {
                    getExtensionUserDetails(primary_acct_user);
                } else {
                    getUserDetails(act_code, s_pin);
                }


            } else {
                clearUserFields()
            }

        }
        //process form
        if (panel_tab_id == 'account-tab') {
            $("#register-form").submit();
        }
        next_click++;
    });
    $('#account_extension').click(function(event) {
        if ($(this).prop('checked') == true) {
            $(this).val('yes');
            $('#primary_acct_user').removeAttr('readonly');
            $('#primary_acct_user').val('');
            $('#primary_acct_user').addClass('register-validate');
            $('#div_ext_username').removeClass('d-none');
        } else {
            $(this).val('no');
            $('#primary_acct_user').attr('readonly', true);
            $('#primary_acct_user').val('Readonly value');
            $('#primary_acct_user').removeClass('register-validate');
            $('#div_ext_username').addClass('d-none');
        }
    });

    $("#register-form").submit(function(event) {
        event.preventDefault();
        console.log('Register submitting...');
        var formData = new FormData();
        //activation
        formData.append("activation_code", $("#activation_code").val());
        formData.append("sec_pin", $("#sec_pin").val());
        formData.append("primary_acct_user", $("#primary_acct_user").val());
        //personal info
        formData.append("first_name", $("#first_name").val());
        formData.append("middle_name", $("#middle_name").val());
        formData.append("last_name", $("#last_name").val());
        formData.append("email_addr", $("#email_addr").val());
        formData.append("mobile_no", $("#mobile_no").val());
        formData.append("tel_no", $("#tel_no").val());
        formData.append("gender", $("#gender").val());
        formData.append("civil_status", $("#civil_status").val());
        formData.append("tin_no", $("#tin_no").val());
        formData.append("beneficiary", $("#beneficiary").val());
        formData.append("birth_date", $("#birth_date").val());
        //address
        formData.append("address", $("#address").val());
        formData.append("province_id", $("#province").val());
        formData.append("city_id", $("#city").val());
        formData.append("province_val", $("#province option:selected").text());
        formData.append("city_val", $("#city option:selected").text());
        formData.append("zip_code", $("#zip_code").val());
        //account info
        formData.append("sponsor", $("#sponsor").val());
        formData.append("upline_placement", $("#upline_placement").val());
        formData.append("username_member", $("#username_member").val());
        formData.append("placement_position", $("#placement_position").val());
        formData.append("password", $("#password").val());
        //account extension
        formData.append("account_extension", $("#account_extension").val());
        formData.append("primary_acct_user", $("#primary_acct_user").val());

        formData.append('_token', token);

        var count_err = act_code_err + sec_pin_err + user_extension_err + pass_err; // for counting the invalid fields

        var fields_require = $('.register-validate');
        var count_null_fields = 0; // for counting the empty fields
        for (var i = 0; i < fields_require.length; i++) {
            var data = $(fields_require[i]).val();
            if (data == "") {
                //showError(fields_require[i],'This field is required.');
                $(fields_require[i]).closest('.form-group').find('.display-error').text('This field is required.');
                $(fields_require[i]).closest('.form-group').find('.display-error').removeClass('d-none');
                $(fields_require[i]).addClass("border-red");
                count_null_fields++;
            } else {
                $(fields_require[i]).removeClass("border-red");
            }
        }
        if (count_null_fields == 0 && count_err == 0) {
            //error free
            $.ajax({
                url: 'member-activate',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('.send-loading').show();
                },
                success: function(response) {
                    console.log('Register submitting success...');
                    $('.send-loading ').hide();
                    swal({
                        title: "Success!",
                        text: "Activation success",
                        type: "success",
                    }, function() {
                        window.location.href = 'login';
                    });

                },
                error: function(error) {
                    console.log('Register submitting error...');
                    console.log(error);
                    console.log(error.responseJSON.message);
                    $('.send-loading ').hide();
                    swal({
                        title: "Error!",
                        text: "Error message: " + error.responseJSON.message + "",
                        type: "error",
                    });
                }
            });
        } else {
            swal({
                title: "Warning!",
                text: "Please check empty or invalid input fields.",
                type: "warning",
            });
        }

    })

})

function getData() {
    $.ajax({
        url: 'register-get-data',
        type: 'GET',
        beforeSend: function() {
            console.log('Getting data ...');
        },
        success: function(response) {
            console.log('Getting data success...');
            console.log(response);
            user_network_data = response.data;
            city_data = response.city;
            user_extension_data = response.user_data;
            //setting province data
            $('#province').empty();
            $('#province').append('<option value="">Select</option>');
            $.each(response.province, function(i, value) {
                $('#province').append('<option value="' + value.provCode + '">' + value.provDesc + '</option>');
            });
            //place the preloader here to finish first of getting data
            $(".pre-loading").fadeOut("slow");
        },
        error: function(error) {
            console.log('Getting data error...');
            console.log(error);
        }
    });
}

//get user details for extension
function getExtensionUserDetails(username) {
    $.each(user_extension_data, function(i, value) {
        if (value.username == username) {
            $('#first_name').val(value.first_name);
            $('#middle_name').val(value.middle_name);
            $('#last_name').val(value.last_name);
            $('#email_addr').val(value.email);
            $('#mobile_no').val(value.mobile_no);
            $('#tel_no').val(value.tel_no);
            $('#gender').val(value.gender);
            $('#civil_status').val(value.civil_status);
            $('#tin_no').val(value.tin_no);
            $('#beneficiary').val(value.beneficiary);
            $('#birth_date').val(value.birthdate);
            //address
            $('#address').val(value.address);
            $('#province').val(value.province_id);
            $('#zip_code').val(value.zip_code);
            $('#city').empty();
            $('#city').append('<option value="">Select</option>');
            $.each(city_data, function(i, value) {
                if (value.provCode == value.province_id) {
                    $('#city').append('<option value="' + value.citymunCode + '">' + value.citymunDesc + '</option>');
                }
            });
            $('#city').val(value.city_id);
            //account
            $('#sponsor').val(value.username);
            $('#upline_placement').val(value.username);
            $('#placement_position').val(value.placement_position);
        }
    });
    $('.send-loading').hide();
}

function getUserDetails(act_code, s_pin) {
    var sponsor_id = 0;
    var upline_placement_id = 0;
    $.each(user_network_data, function(i, value) {
        if (value.code == act_code && value.security_pin == s_pin) {
            $('#first_name').val(value.first_name);
            $('#middle_name').val('');
            $('#last_name').val(value.last_name);
            $('#email_addr').val(value.email);
            $('#mobile_no').val(value.mobile_no);
            $('#tel_no').val('');
            $('#gender').val('');
            $('#civil_status').val('');
            $('#tin_no').val('');
            $('#beneficiary').val('');
            $('#birth_date').val('');
            //address
            $('#address').val('');
            $('#province').val('');
            $('#city').val('');
            $('#zip_code').val('');
            //account
            $('#placement_position').val(value.placement_position);
            sponsor_id = value.sponsor_id;
            upline_placement_id = value.upline_placement_id;
        }
    });
    if (sponsor_id == 0) {
        $('#sponsor').val('');
        $('#upline_placement').val('');
    } else {
        $.each(user_extension_data, function(i, value) {
            if (value.user_id == sponsor_id) {
                $('#sponsor').val(value.username);
            }
        });
        $.each(user_extension_data, function(i, value) {
            if (value.user_id == upline_placement_id) {
                $('#upline_placement').val(value.username);
            }
        });
    }
    $('.send-loading').hide();
}

//clear fields
function clearUserFields() {
    $('#first_name').val('');
    $('#middle_name').val('');
    $('#last_name').val('');
    $('#email_addr').val('');
    $('#mobile_no').val('');
    $('#tel_no').val('');
    $('#gender').val('');
    $('#civil_status').val('');
    $('#tin_no').val('');
    $('#beneficiary').val('');
    $('#birth_date').val('');
    //address
    $('#address').val('');
    $('#province').val('');
    $('#city').val('');
    $('#zip_code').val('');
    //account
    $('#sponsor').val('');
    $('#upline_placement').val('');

}

function checkUsername(username) {
    $.ajax({
        url: 'register-get-data',
        type: 'GET',
        beforeSend: function() {
            console.log('Getting data ...');
        },
        success: function(response) {
            console.log('Getting data success...');
            console.log(response);
            user_network_data = response.data;
            city_data = response.city;
            user_extension_data = response.user_data;
            //setting province data
            $('#province').empty();
            $('#province').append('<option value="">Select</option>');
            $.each(response.province, function(i, value) {
                $('#province').append('<option value="' + value.provCode + '">' + value.provDesc + '</option>');
            });
            //place the preloader here to finish first of getting data
            $(".pre-loading").fadeOut("slow");
        },
        error: function(error) {
            console.log('Getting data error...');
            console.log(error);
        }
    });
}

function showError(dis, msg) {
    dis.closest('.form-group').find('.display-error').text(msg);
    dis.closest('.form-group').find('.display-error').removeClass('d-none');
    dis.addClass('border-red');
}

function hideError(dis) {
    dis.closest('.form-group').find('.display-error').text('');
    dis.closest('.form-group').find('.display-error').addClass('d-none');
    dis.removeClass('border-red');
}