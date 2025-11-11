$(document).ready(function () {
    getTotalIncome();

    $('#transfer_amount').keyup(function () {
        var val = $(this).val();
        var receive = 0;
        if (val != '') {
            receive = val - 50;
        }
        $('#receive_lbl').text(receive.toFixed(2));
    });

    $('#transfers_tbl').DataTable({
        "order": [
                [4, "desc"]
            ],
        processing: true,
        serverSide: true,
        responsive: true,
        "ajax": {
            "url": histories_route,
            "dataType": "json",
            "type": "POST",
            "data": {
                _token: token
            }
        },
        "columns": [{
                "data": "type"
                },
            {
                "data": "amount"
                },
            {
                "data": "name"
                },
            {
                "data": "process_fee"
                },
            {
                "data": "created_at"
                }
            ]
    });



    $('#username').select2({
        minimumInputLength: 0, // only start searching when the user has input 3 or more characters
        ajax: {
            url: select_user_route,
            processResults: function (data) {
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: data.results
                };
            }
        }
    });


    $('#transfers_tbl_wrapper').removeClass('form-inline');
    $('#transfer_amount').change(function () {
        var val = $(this).val();
        if (val != "") {
            $(this).removeClass("border-red");
        }
    });
    $('#username').change(function () {
        var val = $(this).val();
        if (val != "") {
            $(this).removeClass("border-red");
        }
    });
    $('#password').change(function () {
        var val = $(this).val();
        if (val != "") {
            $(this).removeClass("border-red");
        }
    });

    $('#send-request').click(function () {
        var transfer_amount = $('#transfer_amount').val();
        var username = $('#username').val();
        var password = $('#password').val();


        if (transfer_amount == '' || transfer_amount == null || transfer_amount == 0) {
            swal({
                title: "Warning",
                text: "Please fill up amount transfer",
                type: "warning",
            });
            $('#transfer_amount').addClass("border-red");
        } else if (transfer_amount < 500) {
            swal({
                title: "Warning",
                text: "Minimum transfer is 500",
                type: "warning",
            });
            $('#transfer_amount').addClass("border-red");
        } else if (username == '' || username == null) {
            swal({
                title: "Warning",
                text: "Please select username",
                type: "warning",
            });
            $('#select2-username-container').addClass("border-red");
        } else if (password == '' || password == null) {
            swal({
                title: "Warning",
                text: "Please input your password",
                type: "warning",
            });
            $('#password').addClass("border-red");
        } else if (transfer_amount > total_income) {
            swal({
                title: "Warning",
                text: "Not Enough balance to transfer",
                type: "warning",
            });
            $('#select2-username-container').removeClass("border-red");
            $('#transfer_amount').addClass("border-red");
        } else {
            $('#select2-username-container').removeClass("border-red");
            if (isNaN(transfer_amount)) {
                swal({
                    title: "Warning",
                    text: "Invalid Income Amount.",
                    type: "warning",
                });
            } else {
                swal({
                        title: "Are you sure?",
                        text: "Once transfered, you will not be able to recover this money!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            sendIncome(transfer_amount, username, password);
                        }
                    });
            }
        }
    });
});

function sendIncome(transfer_amount, username, password) {
    var formData = new FormData();
    formData.append("user_id", username);
    formData.append("password", password);
    formData.append("transfer_amount", transfer_amount);
    formData.append('_token', token);
    $.ajax({
        url: transfer_route,
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
                text: "Income successfully submitted.",
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

function getTotalIncome() {
    $.ajax({
        url: get_total_income_route,
        type: 'GET',
        beforeSend: function () {
            var total_income = 0;
            $('.preloader').css('display', '');
        },
        success: function (response) {
            total_income = response.total_income;
            $('#total-income').text(addComma(total_income) + " PHP");
            $('#transfer_amount').attr({
                'max': total_income
            });
            if (total_income <= 0) {
                $('#send-request').attr('disabled', true);
                $('#username').attr('disabled', true);
                $('#transfer_amount').attr('disabled', true);
                $('#password').attr('disabled', true);

            }

            $('.preloader').css('display', 'none');
        },
        error: function (error) {
            console.log(error);
            $('.preloader').css('display', 'none');
        }
    });
}

function addComma(numStr) {
    numStr += '';
    var x = numStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
