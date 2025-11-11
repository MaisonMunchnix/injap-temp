$('body').on('click', '.btn-view', function () {
    let id = $(this).data('id');
    $.ajax({
        url: 'record-sales-admin/' + id,
        type: 'GET',
        beforeSend: function () {
            $('.send-loading').show();
        },
        success: function (data) {
            $('.send-loading').hide();
            let member = data.user?.info?.first_name + ' ' + data.user?.info?.last_name;
            let shipping_details = '-';
            if(member.startsWith('undefined') || data.ship_to_another_address === '1') {
                shipping_details = `Name: ${data.shipping_detail.first_name} ${data.shipping_detail.last_name}` +
                    `<br> Address: ${data.shipping_detail.street_address}, ${data.shipping_detail.city}, ${data.shipping_detail.province}` +
                    `<br> Contact Number: ${data.shipping_detail.mobile_number}`;
            }
            $('#view_transaction_date').html(data.created_at);
            $('#view_transaction_number').html(data.payment.confirmation_number);
            $('#view_transaction_driver').html(data.payment.driver);
            $('#view_transaction_paid').html(data.payment.is_paid === '1' ? 'Yes' : (data.payment.is_paid === '2' ? 'Refunded' : 'No'));
            $('#view_transaction_status').html(data.payment.status === '1' ? 'Processed' : (data.payment.status === '2' ? 'Declined' : 'Error'));
            $('#view_transaction_error').html(data.payment.error ? data.payment.error : '-');
            $('#view_member').html(member.startsWith('undefined')?'Non member' : member);
            $('#view_subtotal').html(data.subtotal);
            $('#view_discount').html(data.discount);
            $('#view_shipping').html(data.shipping);
            $('#view_total').html(data.total);
            $('#view_should_ship').html(data.ship_to_another_address === '0' ? 'No' : 'Yes');
            $('#view_shipping_details').html(shipping_details);
            $('#view_notes').html(data.note);
            $('#view-modal').modal('show');
        },
        error: function (error) {
            $('.send-loading').hide();
            swal({
                title: "Error!",
                text: "Error message: " + error.responseJSON.message + "",
                type: "error",
            });
        }
    });
})
$('.approve-purchase').on('click', function(e){
    e.preventDefault();
    let url = $(this).attr('href');
    let type = $(this).attr('data-action');
    swal({
        title: `${type}!`,
        text: `Are you sure you want to ${type} this e-wallet purchase?`,
        buttons: {
            cancel: {
                text: "Cancel",
                value: null,
                visible: true,
                closeModal: true
            },
            confirm: {
                text: type,
                value: true,
                className: "btn-primary",
                closeModal: true
            }
        }
    }).then(function (value){
        if(value) {
            window.location.href =  url;
        }
    });
});