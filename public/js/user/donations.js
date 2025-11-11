$('#donations_tbl').dataTable();
$(document).ready(function () {
    $('#donations_tbl_wrapper').removeClass('form-inline');
    $('#donate_amount').change(function () {
        var val = $(this).val();
        if (val != "") {
            $(this).removeClass("border-red");
        }
    });

    $('#send-request').click(function () {
        var donate_amount = $('#donate_amount').val();
        if (donate_amount == '' || donate_amount == null || donate_amount == 0) {
            swal({
                title: "Warning",
                text: "Please fill up Donate Amount",
                type: "warning",
            });
            $('#donate_amount').addClass("border-red");
        } else {
            if (isNaN(donate_amount)) {
                swal({
                    title: "Warning",
                    text: "Invalid Donate Amount.",
                    type: "warning",
                });
            } else {
                sendDonation(donate_amount);
            }
        }
    });
});

function sendDonation(donate_amount) {
    var formData = new FormData();
    formData.append("donate_amount", donate_amount);
    formData.append('_token', token);
    $.ajax({
        url: send_donation_route,
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $('.preloader').css('display', '');
        },
        success: function (response) {
            $('.preloader').css('display', 'none');
            swal({
                title: "Success!",
                text: "Donate successfully submitted.",
                type: "success",
            });
            location.reload();
        },
        error: function (error) {
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
