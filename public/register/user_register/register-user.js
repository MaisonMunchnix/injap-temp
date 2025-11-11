//var token = "{{csrf_token()}}";
var user_network_data; //global declaration
var city_data;
var user_extension_data;
var active_tab = "code_tab";
var already_in_user;
var reg_user_id = 0;
var act_code_err = 1,
    sec_pin_err = 1,
    user_extension_err = 0,
    pass_err = 1,
    email_err = 1,
    username_err = 1,
    zipcode = 1,
    placement_err = 1,
    sponsor_err = 1;
//zero means no error

$(document).ready(function() {
    getData(); //getting user userinfos network and product data
    $('.next').unbind('click'); //remove the function of next button in form wizard
    $("#progressbarwizard").find(".bar").css("width", "25%");

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

        if (dis_val != "") {
            var check_code = checkActivationCode(dis_val);
            if (check_code == true) {
                count_true++;
            }
        }


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

            var check_pin = checkSecurityPin(dis_val, sec_pin_val);
            if (check_pin == true) {
                count_true++;
            }


            if (count_true >= 1) {
                hideError(sec_pin);
                sec_pin_err = 0;
            } else {
                showError(sec_pin, 'Invalid Security Pin.');
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
        if (dis_val != "" && pcode_val != "") {
            var check_pin = checkSecurityPin(pcode_val, dis_val);
            if (check_pin == true) {
                count_true++;
            }
        }


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

        if (count_true >= 1) {
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

    $("#email_addr").change(function(event) {
        var dis = $(this);
        var dis_val = $(this).val();
        if (!isEmailValid(dis_val)) {
            showError(dis, 'Invalid email.');
            email_err = 1;
        } else {
            var chk = checkEmail(dis_val);
            if (chk == true) {
                hideError(dis);
                email_err = 0;
            } else {
                showError(dis, 'Email is not available.'); // email already taken
                email_err = 1;
            }
        }

    });

    $("#zip_code").change(function(event) {
        var dis = $(this);
        var dis_val = $(this).val();
        if ($.isNumeric(dis_val)) {
            hideError(dis);
            zipcode = 0;
        } else {
            showError(dis, 'Invalid zip code.');
            zipcode = 1;
        }

    });

    $("#sponsor").change(function(event) {
        var dis = $(this);
        var dis_val = $(this).val();
        var chk = checkUsername(dis_val);
        if (chk == 0) {
            showError(dis, 'Invalid sponsor username.');
            sponsor_err = 1;
        } else {
            hideError(dis);
            sponsor_err = 0;
        }


    });

    $("#upline_placement").change(function(event) {
        var dis = $(this);
        var dis_val = $(this).val();
        $.ajax({
            url: 'check-placement/' + dis_val,
            type: 'GET',
            async: false,
            beforeSend: function() {
                $(".send-loading").show();
            },
            success: function(response) {
                $(".send-loading").hide();
                console.log(response);
                if (response.valid_username == 1 || response.valid_username == "1") {
                    hideError(dis);
                    placement_err = 0;
                    if (response.placement_position == 'left') {
                        $('#placement_position').empty();
                        $('#placement_position').append('<option value="left">Left</option>');
                    } else if (response.placement_position == 'right') {
                        $('#placement_position').empty();
                        $('#placement_position').append('<option value="right">Right</option>');
                    } else if (response.placement_position == 'empty') {
                        $('#placement_position').empty();
                        $('#placement_position').append('<option value="">Select</option>');
                        $('#placement_position').append('<option value="left">Left</option>');
                        $('#placement_position').append('<option value="right">Right</option>');
                    } else {
                        //placement positiong already filled
                        showError(dis, 'Invalid upline placement.');
                        placement_err = 1;
                        $('#placement_position').empty();
                        $('#placement_position').append('<option value="">Select</option>');
                        $('#placement_position').append('<option value="left">Left</option>');
                        $('#placement_position').append('<option value="right">Right</option>');
                    }
                } else {
                    placement_err = 1;
                    showError(dis, 'Invalid upline placement username.');
                }

            },
            error: function(error) {
                $(".send-loading").hide();
                console.log(error);
            }
        });

    });



    $('.reg-prev-button').click(function(event) {
        console.log(active_tab);
        if (active_tab == "code_tab") {
            //ativation code tab is active
        } else if (active_tab == "personal_tab") {
            //personal tab is current active
            gotoNextTab("activation-code-tab", "href-activation-code-tab", "25%", "code_tab");
        } else if (active_tab == "address_tab") {
            //address tab is current active         
            gotoNextTab("personal-tab", "href-personal-tab", "50%", "personal_tab");
        } else if (active_tab == "account_tab") {
            //account tab is current active
            gotoNextTab("address-tab", "href-address-tab", "75%", "address_tab");
        }
    });

    $('.reg-next-button').click(function(event) {
        if (active_tab == "code_tab") {
            /*  var act_code = $('#activation_code').val();
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
                 clearUserFields();
             } */
            var chck_empty = checkEmptyInputClass('a_code');
            if (chck_empty == 0 && sec_pin_err == 0 && act_code_err == 0 && user_extension_err == 0) {
                var act_code = $('#activation_code').val();
                var s_pin = $('#sec_pin').val();
                getUserDetails(act_code, s_pin);

            } else {
                swal({
                    title: "Warning!",
                    text: "Please check empty or invalid input fields.",
                    type: "warning",
                });
            }


        } else if (active_tab == "personal_tab") {
            if (checkEmptyInputClass('p_info') == 0 && email_err == 0) {
                gotoNextTab("address-tab", "href-address-tab", "75%", "address_tab");
            } else {
                swal({
                    title: "Warning!",
                    text: "Please check empty or invalid input fields.",
                    type: "warning",
                });
            }
        } else if (active_tab == "address_tab") {
            if (checkEmptyInputClass('p_addr') == 0 && zipcode == 0) {
                gotoNextTab("account-tab", "href-account-tab", "100%", "account_tab");
            } else {
                swal({
                    title: "Warning!",
                    text: "Please check empty or invalid input fields.",
                    type: "warning",
                });
            }

        } else if (active_tab == 'account_tab') {
            $("#register-form").submit();
        }
        console.log(active_tab);
    });
    $('#account_extension').click(function(event) {
        if ($(this).prop('checked') == true) {
            $(this).val('yes');
            $('#primary_acct_user').removeAttr('readonly');
            $('#primary_acct_user').val('');
            $('#primary_acct_user').addClass('register-validate');
            $('#div_ext_username').removeClass('d-none');
            user_extension_err = 1;
        } else {
            $(this).val('no');
            $('#primary_acct_user').attr('readonly', true);
            $('#primary_acct_user').val('Readonly value');
            $('#primary_acct_user').removeClass('register-validate');
            $('#div_ext_username').addClass('d-none');
            user_extension_err = 0;
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
        //other details
        formData.append("reg_user_id", reg_user_id);
        formData.append("already_in_user", already_in_user);

        formData.append('_token', token);

        var count_err = act_code_err + sec_pin_err + user_extension_err + pass_err + placement_err; // for counting the invalid fields

        var count_null_fields = checkEmptyInputClass('register-validate'); // for counting the empty fields
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
            city_data = response.city;
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
    $.ajax({
        url: 'register-get-user-by-pcode/' + act_code + '/' + s_pin,
        type: 'GET',
        beforeSend: function() {
            $(".send-loading").show();
        },
        success: function(response) {
            $(".send-loading").hide();
            console.log(response);
            if (response.already_in_user == true) {
                already_in_user = true;
                user_sponsor = response.user_data[0].u_user;
                $('#sponsor').attr('readOnly', true);
                $('#sponsor').val(response.user_data[0].u_user);
                $('#upline_placement').val(response.user_data[0].u_user);
                sponsor_err = 0;
                $('#first_name').val('');
                $('#last_name').val('');
                $('#email_addr').val('');
                $('#mobile_no').val('');
                $('#email_addr').removeAttr('readOnly');
            } else {
                already_in_user = false;
                user_sponsor = 0;
                reg_user_id = response.user_data[0].user_id;
                $('#first_name').val(response.user_data[0].f_name);
                $('#last_name').val(response.user_data[0].l_name);
                $('#email_addr').val(response.user_data[0].u_email);
                $('#mobile_no').val(response.user_data[0].mobile);
                $('#email_addr').attr('readOnly', true);
            }
            gotoNextTab("personal-tab", "href-personal-tab", "50%", "personal_tab");
            console.log('already_in_user: ' + already_in_user);
        },
        error: function(error) {
            $(".send-loading").hide();
            console.log(error);
        }
    });

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


function checkActivationCode(code) {
    var bool = false;
    $.ajax({
        url: 'register-check-act-code/' + code,
        type: 'GET',
        async: false,
        beforeSend: function() {
            $(".send-loading").show();
        },
        success: function(response) {
            $(".send-loading").hide();
            console.log(response);
            console.log(response.valid_code);
            if (response.valid_code == 1 || response.valid_code == "1") {
                bool = true;
            } else {
                bool = false;
            }
        },
        error: function(error) {
            $(".send-loading").hide();
            console.log(error);
            bool = false;
        }
    });
    return bool;
}

function checkSecurityPin(code, pin) {
    var bool = false;
    $.ajax({
        url: 'register-check-pin/' + code + '/' + pin,
        type: 'GET',
        async: false,
        beforeSend: function() {
            $(".send-loading").show();
        },
        success: function(response) {
            $(".send-loading").hide();
            console.log(response);
            console.log(response.valid_pin);
            if (response.valid_pin == 1 || response.valid_pin == "1") {
                bool = true;
            } else {
                bool = false;
            }
        },
        error: function(error) {
            $(".send-loading").hide();
            console.log(error);
            bool = false;
        }
    });
    return bool;
}

function checkUsername(username) {
    var bool = false;
    $.ajax({
        url: '/check-username/' + username,
        type: 'GET',
        async: false,
        beforeSend: function() {
            $(".send-loading").show();
        },
        success: function(response) {
            $(".send-loading").hide();
            console.log(response);
            if (response.valid_username == 1 || response.valid_username == "1") {
                bool = true;
            } else {
                bool = false;
            }
        },
        error: function(error) {
            $(".send-loading").hide();
            console.log(error);
            bool = false;
        }
    });
    return bool;
}

function checkEmail(email) {
    var bool = true;
    $.ajax({
        url: '/check-email/' + email,
        type: 'GET',
        async: false,
        beforeSend: function() {
            $(".send-loading").show();
        },
        success: function(response) {
            $(".send-loading").hide();
            console.log(response);
            if (response.valid_email == 1 || response.valid_email == "1") {
                bool = false;
            } else {
                bool = true;
            }
        },
        error: function(error) {
            $(".send-loading").hide();
            console.log(error);
            bool = true;
        }
    });
    return bool;
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

function gotoNextTab(tab_id, nav_id, bar_width, act_tab) {
    //remove active tab
    var nav_link = $('.nav-link');
    for (var i = 0; i < nav_link.length; i++) {
        $(nav_link[i]).removeClass("active");
    }
    var tab_pane = $('.tab-pane');
    for (var i = 0; i < tab_pane.length; i++) {
        $(tab_pane[i]).removeClass("active");
    }
    $('#' + tab_id).addClass("active"); //go to next tab
    $('#' + nav_id).addClass("active"); //go to next tab
    $("#progressbarwizard").find(".bar").css("width", bar_width);
    active_tab = act_tab;
}

function isEmailValid(email) {
    var regex = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    return regex.test(email);
}

function checkEmptyInputClass(cname) {
    var fields_require = $('.' + cname);
    var count_null_fields = 0; // for counting the empty fields
    for (var i = 0; i < fields_require.length; i++) {
        var data = $(fields_require[i]).val();
        if (data == "") {
            $(fields_require[i]).closest('.form-group').find('.display-error').text('This field is required.');
            $(fields_require[i]).closest('.form-group').find('.display-error').removeClass('d-none');
            $(fields_require[i]).addClass("border-red");
            count_null_fields++;
        } else {
            $(fields_require[i]).removeClass("border-red");
        }
    }
    return count_null_fields;
}