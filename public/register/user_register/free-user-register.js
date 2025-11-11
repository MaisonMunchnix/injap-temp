//global declaration
var city_data;
var pass_err = 1,
    email_err = 1,
    username_err = 1; //zero means no error

$(document).ready(function() {
    getData(); //getting user userinfos network and product data


    $('.register-validate').change(function(event) {
        var dis_val = $(this).val();
        var dis = $(this);
        if (dis_val != "") {
            hideError(dis);
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

    $("#agree_terms").click(function(event) {
        if (this.checked) {
            $(this).val('yes');
        } else {
            $(this).val('no');
        }
    });

    $("#username_member").change(function(event) {
        var dis = $(this);
        var dis_val = $(this).val();
        username_err = 0;
        if (dis_val.length >= 6) {
            $.ajax({
                url: 'check-username/' + dis_val,
                type: 'GET',
                beforeSend: function() {
                    //.log('Checking username ...');
                },
                success: function(response) {
                    //console.log('Checking username success...');
                    //console.log(response);
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
            email_err = 0;
        }

    });

    $('.reg-next-button').click(function(event) {
        var active_tab = $(".tab-pane:visible").attr("id");
        if (active_tab == 'account-tab') {
            $("#register-form").submit();
        }
    });

    $("#register-form").submit(function(event) {
        event.preventDefault();
        //console.log('Register submitting...');
        var formData = new FormData();
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
        formData.append("username_member", $("#username_member").val());
        formData.append("password", $("#password").val());


        formData.append('_token', token);

        var count_err = pass_err + email_err + username_err; // for counting the invalid fields

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
                $(fields_require[i]).closest('.form-group').find('.display-error').text('');
                $(fields_require[i]).removeClass("border-red");
            }
        }
        var agree_terms = $("#agree_terms").val();
        if (parseInt(count_null_fields) > 0) {
            swal({
                title: "Warning!",
                text: "Please check empty or invalid input fields.",
                type: "warning",
            });
        } else if (parseInt(email_err) > 0) {
            swal({
                title: "Warning!",
                text: "Please check empty or invalid input fields.",
                type: "warning",
            });
            var email_add = $("#email_addr");
            showError(email_add, 'Email is not available.');
        } else if (parseInt(username_err) > 0) {
            swal({
                title: "Warning!",
                text: "Please check empty or invalid input fields.",
                type: "warning",
            });
            var un = $("#username_member");
            showError(un, 'Username is not available.');
        } else if (parseInt(pass_err) > 0) {
            swal({
                title: "Warning!",
                text: "Please check empty or invalid input fields.",
                type: "warning",
            });
            var repass = $("#re_password");
            showError(repass, 'Password does not match.');
        } else if (agree_terms == 'no') {
            swal({
                title: "Warning!",
                text: "Please check agree to the terms and condition",
                type: "warning",
            });
        } else {
            //error free
            $.ajax({
                url: 'insert-member-free-register',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('.send-loading').show();
                },
                success: function(response) {
                    //console.log('Register submitting success...');
                    $('.send-loading ').hide();
                    swal({
                        title: "Success!",
                        text: "Registered successfully, you may now login and start to income.",
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
        }

    })

})

function getData() {
    $.ajax({
        url: 'get-province',
        type: 'GET',
        beforeSend: function() {
            //console.log('Getting data ...');
        },
        success: function(response) {
            //console.log('Getting data success...');
            //console.log(response);
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


function checkEmail(email) {
    var bool = true;
    $.ajax({
        url: 'check-email/' + email,
        type: 'GET',
        async: false,
        beforeSend: function() {
            $(".send-loading").show();
        },
        success: function(response) {
            $(".send-loading").hide();
            //console.log(response);
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

function isEmailValid(email) {
    var regex = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    return regex.test(email);
}

function validURL(str) {
    var pattern = new RegExp('^(https?:\\/\\/)?' + // protocol
        '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
        '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
        '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
        '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
        '(\\#[-a-z\\d_]*)?$', 'i'); // fragment locator
    return !!pattern.test(str);
}