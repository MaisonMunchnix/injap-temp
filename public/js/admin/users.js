$(document).ready(function () {
    $('#addForm').submit(function (event) {
        event.preventDefault();
        var password = $("#add_password").val();
        var confirm_password = $("#add_confirm_password").val();

        if (password != confirm_password) {
            swal({
                title: "Error!",
                text: "Error Msg: Password not match!",
                type: "error",
            });
        } else if (IsEmail($("#add_email_address").val()) == false) {
            swal({
                title: "Error!",
                text: "Error Msg: Invalid Email",
                type: "error",
            });
        } else {        
            var form_data=new FormData(this);
            form_data.append('add_admin_scope', $('#add_admin_scope').val());
            $.ajax({
                url: 'insert-user',
                type: 'POST',
                data: form_data,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('.send-loading').show();
                },
                success: function (response) {
                    console.log('User add submitting success...');
                    $('.send-loading').hide();
                    $('#add-modal').one('hidden.bs.modal', function () {
                        $('#success-modal').modal('show');
                    });
                    $('#add-modal').modal('hide');

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
                    $('#add-btn').attr('disabled', false);
                }
            });
        }
    });

    $('body').on('click', '.btn-edit', function (event) {
        console.log('edit btn clicked');
        $("#branch_edit").hide();
        /*$('#myform')[0].reset();*/
        var id = $(this).data('id');
        var action = 'members/edit' + id;
        var url = 'members/edit';
        $.ajax({
            type: 'get',
            url: url,
            data: {
                'id': id
            },
            beforeSend: function () {
                $('.send-loading').show();
            },
            success: function (data) {
                $('.send-loading').hide();
                $('#edit_id').val(data.id);
                $('#edit_first_name').val(data.first_name);
                $('#edit_last_name').val(data.last_name);
                $('#edit_email_address').val(data.email);
                $('#edit_mobile_number').val(data.mobile_no);
                $('#edit_username').val(data.username);
                $('#edit_role').find('option[value="' + data.userType + '"]').attr('selected');
                $('#edit_admin_scope').val(data.admin_scope || 'full');
                var user_type = data.userType;
                console.log(user_type);
                if (user_type == 'staff' || user_type == 'Staff') {
                    $('#edit_scope_wrap').show();
                } else {
                    $('#edit_scope_wrap').hide();
                    $('#edit_admin_scope').val('full');
                }
                if (user_type == 'tellers') {
                    console.log('Show Branch');
                    $("#branch_edit").show();
                    $("#edit_branch").addClass("req_fields");
                } else {
                    console.log('Hide Branch');
                    $("#branch_edit").hide();
                    $("#edit_branch").removeClass("req_fields");
                }
                $('#edit_branch').find('option[value="' + data.branch_id + '"]').attr('selected', 'selected');
                $('.classFormUpdate').attr('action', action);
                $('#edit-modal').modal('show');
            }
        });
    });


    $('#update-btn').click(function () {
        event.preventDefault();
        console.log('User update submitting...');
        var formData = new FormData();
        formData.append("id", $("#edit_id").val());
        formData.append("username", $("#edit_username").val());
        formData.append("email_address", $("#edit_email_address").val());
        formData.append("first_name", $("#edit_first_name").val());
        formData.append("last_name", $("#edit_last_name").val());
        formData.append("role", $('#edit_role option:selected').val());
        formData.append("branch_id", $('#edit_branch option:selected').val());
        formData.append("mobile_no", $("#edit_mobile_number").val());

        if ($('#edit_role option:selected').val() == 'staff' || $('#edit_role option:selected').val() == 'Staff') {
            formData.append("admin_scope", $('#edit_admin_scope').val());
        }

        formData.append('_token', token);

        if (IsEmail($("#edit_email_address").val()) == false) {
            swal({
                title: "Error!",
                text: "Error Msg: Invalid Email",
                type: "error",
            });
        } else {
            $.ajax({
                url: 'members/update',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('.send-loading').show();
                },
                success: function (response) {
                    console.log('User update submitting success...');
                    $('.send-loading').hide();
                    swal({
                        title: 'Success!',
                        text: 'Successfully Updated',
                        timer: 1500,
                        type: "success",
                    }).then(function () {
                        window.location.href = 'users';
                    });

                },
                error: function (error) {
                    console.log('User update submitting error...');
                    console.log(error);
                    console.log(error.responseJSON.message);
                    $('.send-loading').hide();
                    swal({
                        title: 'Error!',
                        text: "Error Msg: " + error.responseJSON.message + "",
                        timer: 1500,
                        type: "error",
                    });
                }
            });
        }
    })


    $('body').on('click', '.modifyUser', function (event) {
        if (!confirm("Do you really want to do this?")) {
            return false;
        }
        event.preventDefault();
        console.log('User Modify submitting...');
        var formData = new FormData();
        formData.append("id", $(this).data('id'));
        formData.append('_token', token);

        $.ajax({
            url: 'members/modify',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('.send-loading').show();
            },
            success: function (response) {
                console.log('User Modify submitting success...');
                $('.send-loading').hide();
                swal({
                    title: 'Success!',
                    text: 'Successfully Modified',
                    timer: 1500,
                    type: "success",
                }).then(function () {
                    window.location.href = 'users';
                });

            },
            error: function (error) {
                console.log('User Modify submitting error...');
                console.log(error);
                console.log(error.responseJSON.message);
                $('.send-loading').hide();
                swal({
                    title: "Error!",
                    text: "Error Msg: " + error.responseJSON.message + "",
                    type: "error",
                });
            }
        });
    })
});

$('body').on('click', '.btn-view', function (event) {
    console.log('edit btn clicked');
    $("#branch_edit").hide();
    var id = $(this).data('id');
    var action = 'members/edit' + id;
    var url = 'members/edit';
    $.ajax({
        type: 'get',
        url: url,
        data: {
            'id': id
        },
        beforeSend: function () {
            $('.send-loading').show();
        },
        success: function (data) {
            $('.send-loading').hide();
            $('#view-modal-title').html('View ' + data.userType);
            $('#view_first_name').val(data.first_name);
            $('#view_last_name').val(data.last_name);
            $('#view_email_address').val(data.email);
            $('#view_mobile_number').val(data.mobile_no);
            $('#view_username').val(data.username);
            $('#view_role').find('option[value="' + data.userType + '"]').attr('selected', 'selected');
            if (data.userType == 'tellers') {
                $('#view_branch').find('option[value="' + data.branch_id + '"]').attr('selected', 'selected');
                $("#branch_edit").show();
                $("#view_branch").addClass("req_fields");
            } else {
                $("#view_edit").hide();
                $("#view_branch").removeClass("req_fields");
            }

            $('#view-modal').modal('show');
        }
    });
});

$('body').on('click', '.btn-delete', function (event) {
    console.log('delete btn clicked');
    $("#branch_edit").hide();
    var id = $(this).data('id');
    var action = 'members/edit' + id;
    var url = 'members/edit';
    $.ajax({
        type: 'get',
        url: url,
        data: {
            'id': id
        },
        beforeSend: function () {
            $('.send-loading').show();
        },
        success: function (data) {
            $('.send-loading').hide();
            $('#delete_id').val(data.id);
            $('#userType').val(data.userType);
            $('.name').html(data.username);
            $('#delete-modal').modal('show');
        }
    });
});

$('body').on('submit', '#form_delete', function (event) {
    event.preventDefault();
    console.log('Delete Package');
    var user_type = $('#userType').val();
    $.ajax({
        url: window.deleteUserUrl || '/delete-user',
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
                text: user_type + " successfully Deleted",
                type: "success",
            }).then(function () {
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



$('#add_role').change(function () {
    //var role = $(this).val();
    //var role = $(this).("option:selected").html();
    var role = $(this).children("option:selected").val();
    console.log(role);
    if (role == 'tellers') {
        $("#branch").show("slow");
        $("#add_branch").addClass("req_fields");
        $('#access-rights').hide("slow");
        $('#add_scope_wrap').hide("slow");
        $('#add_admin_scope').val('full');
    } else {
        $("#branch").hide("slow");
        $("#add_branch").removeClass("req_fields");
        if (role == 'staff' || role == 'Staff') {
            $('#access-rights').show("slow");
            $('#add_scope_wrap').show("slow");
        } else {
            $('#access-rights').hide("slow");
            $('#add_scope_wrap').hide("slow");
            $('#add_admin_scope').val('full');
        }
    }
});

$('#edit_role').change(function () {
    //var role = $(this).val();
    //var role = $(this).("option:selected").html();
    var role = $(this).children("option:selected").val();
    console.log(role);
    if (role == 'tellers') {
        $("#branch_edit").show("slow");
        $("#edit_branch").addClass("req_fields");
    } else {
        $("#branch_edit").hide("slow");
        $("#edit_branch").removeClass("req_fields");
    }

    if (role == 'staff' || role == 'Staff') {
        $('#edit_scope_wrap').show("slow");
    } else {
        $('#edit_scope_wrap').hide("slow");
        $('#edit_admin_scope').val('full');
    }
});

$('.check_access').change(function () {
    if($(this).val()=='false'){
        $(this).val('true');
    }else{
        $(this).val('false');
    }
});



function IsEmail(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!regex.test(email)) {
        return false;
    } else {
        return true;
    }
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#product-img-tag').attr('src', e.target.result);

        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#product-img").change(function () {
    readURL(this);
});
