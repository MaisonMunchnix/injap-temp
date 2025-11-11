$('#branch_list_table').dataTable();
$(document).ready(function () {
    $('#branch_list_table_wrapper').removeClass('form-inline');
    $('#add_form').submit(function (event) {
        event.preventDefault();
        var count_null_fields = 0; // for counting the empty fields
        var fields_require = $('.req_fields');
        for (var i = 0; i < fields_require.length; i++) {
            var data = $(fields_require[i]).val();
            if (data == "") {
                count_null_fields++;
            }
        }
        if (count_null_fields == 0) {
            $.ajax({
                url: 'insert-package',
                method: 'post',
                data: new FormData(this),
                cache:false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    console.log('Submitting...');
                    $('.send-loading').show();
                    $('#save-btn').attr('disabled', 'disabled');
                },
                success: function (response) {
                    console.log('Success...');
                    $('.send-loading').hide();

                    swal({
                        title: "Success!",
                        text: "Supplier successfully added",
                        icon: "success",
                        closeOnClickOutside: false, 
                    })
                    .then((value) => {
                        if (value) {
                            window.location.href = 'packages'; 
                        }
                    });
                },
                error: function (error) {
                    console.log('Error...');
                    console.log(error);
                    console.log(error.responseJSON.message);
                    $('.send-loading').hide();
                    swal({
                        title: "Error!",
                        text: "Error message: " + error.responseJSON.message + "",
                        type: "error",
                    });
                    $('#save-btn').attr('disabled', false);
                }
            });
        } else {
            $('.req_fields').css("border", "1px solid red");
            swal({
                title: "Warning",
                text: "Please check empty input fields.",
                type: "warning",
            });
        }
    });

    $('body').on('submit', '#update_form', function (event) {
        event.preventDefault();
        console.log('Edit Supplier');
        var count_null_fields = 0; // for counting the empty fields
        var count_qty_fields = 0; // for counting the empty fields
        var fields_require = $('.edit_req_fields');
        var qnty_require = $('.qnty');
        for (var i = 0; i < qnty_require.length; i++) {
            var qty_data = $(qnty_require[i]).val();
            if (qty_data == "") {
                count_qty_fields++;
            }
        }
        for (var i = 0; i < fields_require.length; i++) {
            var data = $(fields_require[i]).val();
            if (data == "") {
                count_null_fields++;
            }
        }
        
        if ($('.select_product').has('option').length > 0 && !$('.qnty').val()) {
            $('.qnty').attr("style", "border:1px solid red;")
            swal({
                title: "Warning",
                text: "Quantity is required! ",
                type: "warning",
            });
        } else if (qnty_require >= 1) {
            $('.qnty').attr("style", "border:1px solid red;")
            swal({
                title: "Warning",
                text: "Quantity is required! ",
                type: "warning",
            });
        } else if (count_null_fields >= 1) {
            //$('.edit_req_fields').attr("style", "border:1px solid red;")
            swal({
                title: "Warning",
                text: "Please check empty input fields. ",
                type: "warning",
            });
        } else {
            //error free
            console.log('test');
            $.ajax({
                url: 'update-package',
                type: 'POST',
                data: new FormData(this),
                cache:false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    console.log('Submitting...');
                    $('.send-loading').show();
                },
                success: function (response) {
                    console.log('Success...');
                    $('.send-loading').hide();
                    swal({
                        title: "Success!",
                        text: "Package successfully Updated",
                        type: "success",
                    }, function () {
                        window.location.href = 'packages';
                    });
                },
                error: function (error) {
                    console.log('Error...');
                    console.log(error);
                    console.log(error.responseJSON.message);
                    $('.send-loading').hide();
                    swal({
                        title: "Error!",
                        text: "Error message: " + error.responseJSON.message + "",
                        type: "error",
                    });
                }
            });
        }

    });

    $('body').on('click', '.btn-delete', function (event) {
        event.preventDefault();
        console.log('Delete Package');
        var id = $(this).data('id');

        $.ajax({
            url: 'edit-package/' + id,
            type: 'GET',
            data: {
                'id': id,
                '_token': token,
            },
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('.send-loading').show();
            },
            success: function (data) {
                $('.send-loading').hide();
                $('#delete_id').val(data.package.id);
                $('.package_name').html(data.package.type);
                $('#delete-modal').modal('show');
            },
            error: function (error) {
                console.log('Error...');
                console.log(error);
                console.log(error.responseJSON.message);
                $('.send-loading').hide();
                swal({
                    title: "Error!",
                    text: "Error message: " + error.responseJSON.message + "",
                    type: "error",
                });
            }
        });
    });

    $('body').on('submit', '#DeleteForm', function (event) {
        event.preventDefault();
        console.log('Delete Package');
        $.ajax({
            url: 'delete-package',
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('.send-loading').show();
            },
            success: function (data) {
                $('.send-loading').hide();
                swal({
                    title: "Success!",
                    text: "Package successfully Deleted",
                    type: "success",
                }, function () {
                    window.location.href = 'packages';
                });
            },
            error: function (error) {
                console.log('Error...');
                console.log(error);
                console.log(error.responseJSON.message);
                $('.send-loading').hide();
                swal({
                    title: "Error!",
                    text: "Error message: " + error.responseJSON.message + "",
                    type: "error",
                });
            }
        });
    });

})
