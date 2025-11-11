$('#encashment_tbl').dataTable();
$('#ewallet').dataTable();
$(document).ready(function () {
    var minumum = 500;
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
    $('#send-request').click(function () {

        var amount_requested = $('#amount_requested').val();
        var password = $('#password_verification').val();
        if (amount_requested == '' || amount_requested == null || amount_requested == 0) {
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
                        if (parseFloat(amount_requested) > parseFloat(balance)) {
                            swal({
                                title: "Warning",
                                text: "Your requested amount is exceeded from your available balance.",
                                type: "warning",
                            });
                        } else {
                            sendEncashment(amount_requested, password, balance);
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

function sendEncashment(amt, pw, bal) {
    var formData = new FormData();
    formData.append("amount", amt);
    formData.append("password", pw);
    formData.append("balance", bal);
    formData.append('_token', token);
    $.ajax({
        url: ayuda_request_encashment,
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
