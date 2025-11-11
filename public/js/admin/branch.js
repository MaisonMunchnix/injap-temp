$('#branch_list_table').dataTable({
    dom: 'Bfrtip',
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ]
});
$(document).ready(function () {
    $('#branch_list_table_wrapper').removeClass('form-inline');


    $('body').on('click', '.btn-view', function () {
        var id = $(this).data('id');
        $.ajax({
            url: 'get-branch/' + id,
            type: 'GET',
            beforeSend: function () {
                console.log('Getting data...');
                $('.send-loading').show();
            },
            success: function (data) {
                console.log('Success...');
                //console.log(branch_data);
                $('.send-loading').hide();
                $('#view_branch_type').val(data.type);
                $('#view_branch_name').val(data.name);
                $('#view_branch_address').val(data.branch_address);
                $('#view_owner_first_name').val(data.owner_first_name);
                $('#view_owner_last_name').val(data.owner_last_name);
                $('#view_owner_tel_num').val(data.owner_tel_number);
                $('#view_owner_mobile_num').val(data.owner_mobile_number);
                $('#view_owner_email').val(data.owner_email_address);
                $('#view_owner_addr').val(data.owner_address);
                $('#view-modal').modal();

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

    })

    $('#add_branch').submit(function (event) {
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
            //error free
            console.log('test');
            var formData = new FormData();
            formData.append('_token', token);
            formData.append('branch_type', $('#branch_type').val());
            formData.append('branch_name', $('#branch_name').val());
            formData.append('branch_address', $('#branch_address').val());
            formData.append('owner_first_name', $('#owner_first_name').val());
            formData.append('owner_last_name', $('#owner_last_name').val());
            formData.append('owner_tel_num', $('#owner_tel_num').val());
            formData.append('owner_mobile_num', $('#owner_mobile_num').val());
            formData.append('owner_email', $('#owner_email').val());
            formData.append('owner_addr', $('#owner_addr').val());

            $.ajax({
                url: 'insert-branch',
                type: 'POST',
                data: formData,
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
                        text: "Branch successfully added",
                        type: "success",
                    }, function () {
                        window.location.href = 'branch-list';
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
        } else {
            swal({
                title: "Warning",
                text: "Please check empty input fields. ",
                type: "warning",
            });
        }
    });

    $('body').on('click', '.btn-edit', function () {
        var id = $(this).data('id');
        $.ajax({
            url: 'get-branch/' + id,
            type: 'GET',
            beforeSend: function () {
                console.log('Getting data...');
                $('.send-loading').show();
            },
            success: function (data) {
                console.log('Success...');
                //console.log(branch_data);
                $('.send-loading').hide();
                $('#edit_id').val(data.id);
                $('#edit_branch_type').find('option[value="' + data.type + '"]').attr('selected', 'selected');
                $('#edit_branch_name').val(data.name);
                $('#edit_branch_address').val(data.branch_address);
                $('#edit_owner_first_name').val(data.owner_first_name);
                $('#edit_owner_last_name').val(data.owner_last_name);
                $('#edit_owner_tel_num').val(data.owner_tel_number);
                $('#edit_owner_mobile_num').val(data.owner_mobile_number);
                $('#edit_owner_email').val(data.owner_email_address);
                $('#edit_owner_addr').val(data.owner_address);
                $('#edit-branch-modal').modal();

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

    })

    $('body').on('submit', '#edit_branch', function (event) {
        event.preventDefault();
        console.log('Edit Branch');
        var count_null_fields = 0; // for counting the empty fields
        var fields_require = $('.edit_req_fields');
        for (var i = 0; i < fields_require.length; i++) {
            var data = $(fields_require[i]).val();
            if (data == "") {
                count_null_fields++;
            }
        }
        if (count_null_fields == 0) {
            //error free
            console.log('test');
            var formData = new FormData();

            formData.append('_token', token);
            formData.append('id', $('#edit_id').val());
            formData.append('branch_type', $('#edit_branch_type').val());
            formData.append('branch_name', $('#edit_branch_name').val());
            formData.append('branch_address', $('#edit_branch_address').val());
            formData.append('owner_first_name', $('#edit_owner_first_name').val());
            formData.append('owner_last_name', $('#edit_owner_last_name').val());
            formData.append('owner_tel_num', $('#edit_owner_tel_num').val());
            formData.append('owner_mobile_num', $('#edit_owner_mobile_num').val());
            formData.append('owner_email', $('#edit_owner_email').val());
            formData.append('owner_addr', $('#edit_owner_addr').val());
            //formData.append('attachment', $('#add_attachment').val());
            $.ajax({
                url: 'update-branch',
                type: 'POST',
                data: formData,
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
                        text: "Branch successfully Updated",
                        type: "success",
                    }, function () {
                        window.location.href = 'branch-list';
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
        } else {
            $('.add_req_fields').attr("style", "border:1px solid red;")
            swal({
                title: "Warning",
                text: "Please check empty input fields. ",
                type: "warning",
            });
        }
    });

    $('body').on('click', '.btn-delete', function () {
        var id = $(this).data('id');
        $.ajax({
            url: 'get-branch/' + id,
            type: 'GET',
            beforeSend: function () {
                console.log('Getting data...');
                $('.send-loading').show();
            },
            success: function (data) {
                console.log('Success...');
                //console.log(branch_data);
                $('.send-loading').hide();
                $('#delete_id').val(data.id);
                $('.name').html(data.name);
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

    $('body').on('submit', '#form_delete', function (event) {
        event.preventDefault();
        console.log('Delete Branch');

        $.ajax({
            url: 'delete-branch',
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
                    text: "Branch successfully deleted",
                    type: "success",
                }, function () {
                    location.reload();
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
