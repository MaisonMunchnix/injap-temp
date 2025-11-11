var code_err = 1,
    pin_err = 1;
var url_upgrade = '';
var url_check_pin = '';
var url_check_code = '';
$(document).ready(function() {
    var url = window.location.href;
    var split_url = url.split("/");
    console.log(split_url);
    if (split_url.length == 4) {
        url_upgrade = 'user/member-upgrade';
        url_check_pin = 'user/check-pin';
        url_check_code = 'user/check-act-code';
    } else if (split_url.length == 5) {
        url_upgrade = 'member-upgrade';
        url_check_pin = 'check-pin';
        url_check_code = 'check-act-code';
    } else {
        url_upgrade = '../member-upgrade';
        url_check_pin = '../check-pin';
        url_check_code = '../check-act-code';
    }
    $('#btn-upgrade').click(function() {
        var pcode = $('#upgrade_code').val();
        var pin = $('#upgrade_pin').val();
        var count_null_fields = 0; // for counting the empty fields
        var fields_require = $('.up-acc-input');
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
        if (code_err == 0 && pin_err == 0 && count_null_fields == 0) {
            $('#up-error').addClass('d-none');
            //error free
            var formData = new FormData();
            formData.append("activation_code", pcode);
            formData.append("sec_pin", pin);
            formData.append('_token', token);

            $.ajax({
                url: url_upgrade,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('.send-loading').show();
                },
                success: function(response) {
                    //console.log('Upgrade account submitting success...');
                    $('.send-loading ').hide();
                    swal({
                        title: "Success!",
                        text: "Upgrading account success, you may now enjoy more benefits.",
                        type: "success",
                    }, function() {
                        location.reload();
                    });

                },
                error: function(error) {
                    //console.log('Upgrade account submitting error...');
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
            $('#up-error').removeClass('d-none');
        }
    });
    $('#upgrade_code').change(function(event) {
        var dis_val = $(this).val();
        var dis = $(this);
        var pin = $('#upgrade_pin');
        var pin_val = $('#upgrade_pin').val();
        var chk = checkActivationCode(dis_val);
        if (chk == true) {
            hideError(dis);
            code_err = 0;
            if (pin_val != "") {
                var chk_pin = checkSecurityPin(dis_val, pin_val);
                if (chk_pin == true) {
                    hideError(pin);
                    pin_err = 0;
                } else {
                    $(pin).closest('.form-group').find('.display-error').text('Invalid security pin');
                    $(pin).closest('.form-group').find('.display-error').removeClass('d-none');
                    $(pin).addClass("border-red");
                    pin_err = 1;
                }
            }
        } else {
            $(dis).closest('.form-group').find('.display-error').text('Invalid product code');
            $(dis).closest('.form-group').find('.display-error').removeClass('d-none');
            $(dis).addClass("border-red");
            code_err = 1;
        }

    });
    $('#upgrade_pin').change(function(event) {
        var dis_val = $(this).val();
        var code = $('#upgrade_code').val();
        var dis = $(this);
        var chk = checkSecurityPin(code, dis_val);
        if (chk == true) {
            hideError(dis);
            pin_err = 0;
        } else {
            $(dis).closest('.form-group').find('.display-error').text('Invalid security pin');
            $(dis).closest('.form-group').find('.display-error').removeClass('d-none');
            $(dis).addClass("border-red");
            pin_err = 1;
        }
    });
})


function hideError(dis) {
    dis.closest('.form-group').find('.display-error').text('');
    dis.closest('.form-group').find('.display-error').addClass('d-none');
    dis.removeClass('border-red');
}

function checkActivationCode(code) {
    var bool = false;
    $.ajax({
        url: url_check_code + '/' + code,
        type: 'GET',
        async: false,
        beforeSend: function() {
            $(".send-loading").show();
        },
        success: function(response) {
            $(".send-loading").hide();
            //console.log(response);
            //console.log(response.valid_code);
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
        url: url_check_pin + '/' + code + '/' + pin,
        type: 'GET',
        async: false,
        beforeSend: function() {
            $(".send-loading").show();
        },
        success: function(response) {
            $(".send-loading").hide();
            //console.log(response);
            //console.log(response.valid_pin);
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