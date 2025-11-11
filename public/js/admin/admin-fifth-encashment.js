var tid = 0;

var amount_requested = 0;

var claim_tid = 0;

var hold_tid = 0;

var decline_tid = 0;

var view_tid = 0;



$(document).ready(function () {



    setEncashTable(filter_type);



    $('.filter-by').click(function () {
        var type = $(this).data('type');
        if ($(this).hasClass('active')) {

        } else {
            $('.filter-by').removeClass('active');
            setEncashTable(type);
            $(this).addClass('active');
            $('#title-encash').text(type + ' Encashments');
        }



    });



    $(".numbers").each(function () {

        var new_txt = $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

        $(this).text(new_txt)

    });



    $('body').on('click', '.encash-approved', function () {

        tid = $(this).data('id');

        amount_requested = $(this).data('amount');

    });

    $('body').on('click', '.encash-hold', function () {

        hold_tid = $(this).data('id');

    });

    $('#btn-hold').click(function () {

        var msg = $('#hold_reason').val();

        processEncashment(hold_tid, 'hold', 0, msg);

    });



    $('body').on('click', '.encash-decline', function () {

        decline_tid = $(this).data('id');

    });

    $('#btn-decline').click(function () {

        var msg = $('#decline_reason').val();

        processEncashment(decline_tid, 'decline', 0, msg);

    });

    $('#approve_modal').on('shown.bs.modal', function (e) {

        console.log('id:' + tid + ' amount:' + amount_requested);

        $('#amt_request').val(amount_requested);

        $('#amt_approve').val(amount_requested);

    });

    $('#btn-approve').click(function () {
        var get_amt_request = $('#amt_request').val();
        var amount_approved = $('#amt_approve').val();
        if (amount_requested == '' || amount_requested == 0 || amount_approved == '' || amount_approved == 0) {
            swal({
                title: "Warning!",
                text: "Please fill up required fields",
                type: "warning",
            });
        } else {
            if (get_amt_request == amount_requested) {
                if (parseFloat(amount_approved) > parseFloat(amount_requested)) {
                    swal({
                        title: "Warning!",
                        text: "Amount approved must be less than or equal to amount requested.",
                        type: "warning",
                    });
                } else {
                    if (tid != 0) {
                        processEncashment(tid, 'approved', amount_approved, "");
                    } else {
                        swal({
                            title: "Error!",
                            text: "Something went wrong please try again later.",
                            type: "error",
                        });
                    }
                }
            } else {
                swal({
                    title: "Error!",
                    text: "Something went wrong please try again later.",
                    type: "error",
                });
            }
        }
    });



    $('body').on('click', '.process-claim', function () {

        claim_tid = $(this).data('id');

        $('.preloader').css('display', '');

    });

    $('#claim_modal').on('shown.bs.modal', function (e) {

        $.ajax({

            url: '../../get-fifth-encashment-data/' + claim_tid,

            type: 'GET',

            beforeSend: function () {

                console.log('Getting data...');

            },

            success: function (data) {

                console.log('Success...');

                console.log(data);

                var data_amount_req = data.encashment_data.amount_requested;

                var data_amount_appr = data.encashment_data.amount_approved;

                var process_fee = data.encashment_data.process_fee;


                var tax = data.encashment_data.tax;

                var tax_percent = 0;

                if (tax > 0) {
                    tax_percent = data_amount_appr / tax;
                }


                var total_claim = parseFloat(data_amount_appr) - parseFloat(tax) - process_fee;

                $('#details_ar').text(addComma(data_amount_req) + 'PHP');

                $('#details_appr').text(addComma(data_amount_appr) + 'PHP');

                $('#details_tax').text(addComma(tax) + 'PHP');

                $('#details_total_claim').text(addComma(total_claim) + 'PHP');

                $('#details_tax_label').text(addComma(tax_percent)); //Tax Percentage
                $('#processing_fee_label').text(addComma(process_fee));

                $('.preloader').css('display', 'none');

            },

            error: function (error) {

                console.log('Error...');

                console.log(error);

                console.log(error.responseJSON.message);

                $('.preloader').css('display', 'none');

                swal({

                    title: "Error!",

                    text: "Error message: " + error.responseJSON.message + "",

                    type: "error",

                });

                $('#details_ar').text('0PHP');

                $('#details_appr').text('0PHP');

                $('#details_tax').text('0PHP');

                $('#details_total_claim').text('0PHP');

            }

        });

    });

    $('#btn-process-claim').click(function () {

        processEncashment(claim_tid, 'claimed', 0, "");

    });



    $('body').on('click', '.encash-view', function () {

        view_tid = $(this).data("id");

        $('.preloader').css('display', '');

    });

    $('#view_encashment_modal').on('shown.bs.modal', function (e) {

        $.ajax({

            url: '../../get-fifth-encashment-data/' + view_tid,

            type: 'GET',

            beforeSend: function () {

                console.log('Getting data...');



                $('#view-tid').text('Data');

                $('#view-dr').text('Data');

                $('#view-ar').text('Data');

                $('#view-aa').text('Data');

                $('#details_tax').text('Data');

                $('#view-ac').text('Data');



                $('#view-uname').text('Data');

                $('#view-fname').text('Data');

                $('.view-tax').text('Data');

                $('.view-pfee').text('Data');



                $('#view-dp').text('Data');

                $('#view-pb').text('Data');

                $('#view-stat').text('Data');

                $('#view-reasons').text('Data');

            },

            success: function (data) {

                console.log('Success...');

                console.log(data);

                var data_amount_req = data.encashment_data.amount_requested;
                var process_fee = data.encashment_data.process_fee;
                var tax = data.encashment_data.tax;

                var tax_percent = 0;
                if (tax > 0) {
                    tax_percent = data_amount_req / tax;
                }


                var transact_id;

                if (data.encashment_data.id.length > 10) {

                    transact_id = data.encashment_data.id;

                } else {

                    transact_id = pad(data.encashment_data.id, 10)

                }



                $('#view-tid').text(transact_id);

                $('#view-dr').text(data.encashment_data.created_at);

                $('#view-ar').text(addComma(data_amount_req) + 'PHP');







                $('#view-uname').text(data.user_data.username);

                $('#view-fname').text(data.user_data.first_name + ' ' + data.user_data.last_name);





                if (data.encashment_data.status == 'pending') {

                    $('#view-pb').text('Not processed yet');

                    $('#view-dp').text('Not processed yet');



                    var tax = data.encashment_data.tax;

                    var total_claim = parseFloat(data_amount_req) - parseFloat(tax) - process_fee;

                    $('#view-aa').text('Pending');

                    $('.view-tax').text(addComma(tax_percent));
                    $('#view-tax').text(addComma(tax) + 'PHP');

                    $('#view-ac').text(addComma(total_claim) + 'PHP');

                } else if (data.encashment_data.status == 'decline') {

                    //var tax = data.encashment_data.tax;

                    var total_claim = parseFloat(data_amount_req) - parseFloat(tax) - process_fee;

                    $('#view-aa').text('Decline');

                    $('.view-tax').text(addComma(tax_percent));
                    $('#view-tax').text(addComma(tax) + 'PHP');

                    $('#view-ac').text(addComma(total_claim) + 'PHP');



                    $('#view-pb').text(data.user_process_data.first_name + ' ' + data.user_process_data.last_name);

                    $('#view-dp').text(data.encashment_data.updated_at);

                } else {

                    var data_amount_appr = data.encashment_data.amount_approved;

                    //var tax = data.encashment_data.tax;

                    var total_claim = parseFloat(data_amount_appr) - parseFloat(tax) - process_fee;



                    $('#view-aa').text(addComma(data_amount_appr) + 'PHP');

                    $('.view-tax').text(addComma(tax_percent));
                    $('#view-tax').text(addComma(tax) + 'PHP');

                    $('#view-ac').text(addComma(total_claim) + 'PHP');



                    $('#view-pb').text(data.user_process_data.first_name + ' ' + data.user_process_data.last_name);

                    $('#view-dp').text(data.encashment_data.updated_at);

                }

                $('.view-pfee').text(process_fee);



                $('#view-stat').text(data.encashment_data.status);

                $('#view-stat').removeClass();

                if (data.encashment_data.status == 'approved') {

                    $('#view-stat').addClass('text-primary');

                } else if (data.encashment_data.status == 'claimed') {

                    $('#view-stat').addClass('text-success');

                } else if (data.encashment_data.status == 'pending') {

                    $('#view-stat').addClass('text-default');

                } else {

                    $('#view-stat').addClass('text-danger');

                }

                $('#view-stat').addClass('text-capitalize');

                if (data.encashment_data.status == 'hold' || data.encashment_data.status == 'decline') {

                    $('#view-reasons').text(data.encashment_data.reasons);

                } else {

                    $('#view-reasons').text('No data');

                }



                $('.preloader').css('display', 'none');

            },

            error: function (error) {

                console.log('Error...');

                console.log(error);

                console.log(error.responseJSON.message);

                $('.preloader').css('display', 'none');

                swal({

                    title: "Error!",

                    text: "Error message: " + error.responseJSON.message + "",

                    type: "error",

                });

            }

        });

    });

});



function processEncashment(id, status, amt, reason) {
    var formData = new FormData();
    formData.append("id", id);
    formData.append("status", status);
    formData.append("amount_approved", amt);
    formData.append("reasons", reason);
    formData.append('_token', token);

    $.ajax({
        url: '../../process-fifth-encashment',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $('.preloader').css('display', '');
        },
        success: function (response) {
            console.log('Process encashment submitting success...');
            $('.preloader').css('display', 'none');
            if (status == 'claimed' || status == 'claim') {
                swal({
                    title: "Success!",
                    text: "Encashment successfully processed.",
                    type: "success",
                });
                setTimeout(function () {
                    window.location.href = '../../fifth-encashment-voucher/' + id;
                }, 1500);

            } else {
                swal({
                    title: "Success!",
                    text: "Encashment successfully processed.",
                    type: "success",
                });
                setTimeout(function () {
                    location.reload();
                }, 1500);

            }
        },

        error: function (error) {

            console.log('Request encashment error...');

            console.log(error);

            console.log(error.responseJSON.message);

            $('.preloader').css('display', 'none');

            swal({

                title: "Error!",

                text: "Error message: " + error.responseJSON.message + "",

                type: "error",

            });

        }

    });

}



function pad(str, max) {
    str = str.toString();
    return str.length < max ? pad("0" + str, max) : str;
}



function addComma(num) {
    var text = num.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    return text;
}


$('body').on('submit', '#sales-form', function (event) {
    event.preventDefault();

    var type = $('.filter-by.active').data('type');
    //var filter_type = $('#title-encash').val();
    //filter_type.replace("Encashments", "");
    console.log(type);
    var date_start = $('#date_start').val();
    var date_end = $('#date_end').val();
    console.log("Date Start: " + date_start + " Date End: " + date_end);

    setEncashTable(type, date_start, date_end)

});

function setEncashTable(filter_type, date_start, date_end) {

    console.log(filter_type);
    console.log("Date Start: " + date_start + " Date End: " + date_end);

    //$('#encashment_table').destroy();

    $('#encashment_table').DataTable().clear().destroy();

    $('#encashment_table').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "order": [
            [0, "desc"]
        ],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "../all-fifth-encashment",
            "dataType": "json",
            "type": "POST",
            "data": {
                _token: token,
                filter_type: filter_type,
                date_start: date_start,
                date_end: date_end,
            }
        },
        "columns": [{
                "data": "encash_created"
            },
            {
                "data": "amt_req"
            },
            {
                "data": "amount_appr"
            },
            {
                "data": "username"
            },
            {
                "data": "member_lname"
            },
            {
                "data": "member_fname"
            },

            {
                "data": "encash_status"
            },
            {
                "data": "action"
            }
        ],

        columnDefs: [
            {
                orderable: false,
                "aTargets": [7]
            } //This part is ok now

        ]

    });

}
