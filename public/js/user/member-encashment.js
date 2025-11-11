$('#encashment_tbl').dataTable();
$('#ewallet').dataTable();
$(document).ready(function () {
    var minumum = 500;
    $('#branch-group').hide();
    $('#encashment_tbl_wrapper').removeClass('form-inline');
    $(".numbers").each(function () {
        var new_txt = $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        $(this).text(new_txt)
    });
    $('#amount_requested').change(function () {
        var val = $(this).val();
        if (val != "") {
            $(this).removeClass("border-red");
        }
    });
    $('#password_verification').change(function () {
        var val = $(this).val();
        if (val != "") {
            $(this).removeClass("border-red");
        }
    });
    $('#cash_option').change(function () {
        var val = $(this).val();
        if (val != "") {
            $(this).removeClass("border-red");
            if(val == 'otc'){
                $('#branch-group').show();
                $('#branch').attr('required');
            } else {
                $('#branch-group').hide();
                $('#branch').removeAttr('required');
            }
        }
    });
    $('#send-request').click(function () {

        var amount_requested = $('#amount_requested').val();
        var option = $('#cash_option').val();
        var branch = $('#branch').val();
        var password = $('#password_verification').val();

        if (option==null) {
            swal({
                title: "Warning",
                text: "Please select an option",
                type: "warning",
            });
            $('#cash_option').addClass("border-red");
        } else if (option && option=='otc' && branch==null) {
            swal({
                title: "Warning",
                text: "Please select a branch",
                type: "warning",
            });
            $('#branch').addClass("border-red");
        } else if(amount_requested == '' || amount_requested == null || amount_requested == 0) {
            swal({
                title: "Warning",
                text: "Please fill up amount requested",
                type: "warning",
            });
            $('#amount_requested').addClass("border-red");
        } else if (password == '' || password == null) {
            swal({
                title: "Warning",
                text: "Please fill up password.",
                type: "warning",
            });
            $('#password_verification').addClass("border-red");
        } else {
            if (isNaN(amount_requested)) {
                swal({
                    title: "Warning",
                    text: "Invalid amount requested.",
                    type: "warning",
                });
            } else {
                if (parseFloat(amount_requested) >= parseFloat(minumum)) {
                    if (parseInt(balance) >= parseInt(minumum)) {
                        if (parseInt(amount_requested) > parseInt(balance)) {
                            swal({
                                title: "Warning",
                                text: "Your requested amount is exceeded from your available balance.",
                                type: "warning",
                            });
                        } else {
                            sendEncashment(branch, amount_requested, password, balance,option);
                        }
                    } else {
                        swal({
                            title: "Warning",
                            text: "Your balance is not enough to withdraw money. Minimum is " + minumum,
                            type: "warning",
                        });
                    }

                } else {
                    swal({
                        title: "Warning",
                        text: "Minimum encashment is " + minumum,
                        type: "warning",
                    });
                    $('#amount_requested').addClass("border-red");
                }
            }
        }

    });
});

function sendEncashment(branch, amt, pw, bal,option) {
    var formData = new FormData();
    formData.append("option", option);
    formData.append("branch", branch);
    formData.append("amount", amt);
    formData.append("password", pw);
    formData.append("balance", bal);
    formData.append('_token', token);
    $.ajax({
        url: request_encashment_route,
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $('.preloader').css('display', '');
        },
        success: function (response) {
            //console.log('Request encashment submitting success...');
            $('.preloader').css('display', 'none');
            swal({
                title: "Success!",
                text: "Request encashment successfully submitted.",
                type: "success",
            });
            location.reload();

        },
        error: function (error) {
            //console.log('Request encashment error...');
            $('.preloader').css('display', 'none');
            console.log(error);
            console.log(error.responseJSON.message);
            $('.send-loading ').hide();
            swal({
                title: "Oops",
                text: error.responseJSON.message,
                type: "error",
            });
        }
    });

}
