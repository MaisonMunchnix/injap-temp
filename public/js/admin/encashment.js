$('#encash_form').on('submit', function (event) {
    event.preventDefault();
    encashment();
});

function encashment() {
    $.ajax({
        url: test_url,
        type: 'GET',
        beforeSend: function () {
            $('.send-loading').show();
        },
        success: function (response) {
            $('.send-loading').hide();
            swal({
                title: "Forece Ecashment",
                text: "Sucessful!",
                type: "sucess",
            });
        },
        error: function (error) {
            $('.send-loading').hide();
            console.log(error);
            swal({
                title: "Warning",
                text: "Something went wrong. Please try again later.",
                type: "warning",
            });
        }
    });
}
