$(document).ready(function() {
    geGeneoData();
})


function geGeneoData() {
    var uid = $('#user_id').val();
    $.ajax({
        url: '../get-geneo-data/' + uid,
        type: 'GET',
        beforeSend: function() {
            //console.log('Getting data...');
            $('.preloader').css('display','');
        },
        success: function(response) {
            //console.log('success..');
            $('.genea-body').html(response.data);
            $('.preloader').css('display','none');
        },
        error: function(error) {
            console.log('error...');
            console.log(error);
            $('.preloader').css('display','none');
            swal({
                title: "Error!",
                text: "Something went wrong please try again later. Error: " + error.responseJSON.message,
                type: "error",
            }, function() {
                window.location.href = '/user';
            });


        }
    });
}