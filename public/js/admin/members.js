$(document).ready(function () {
    function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!regex.test(email)) {
            return false;
        } else {
            return true;
        }
    }

    $('body').on('click', '.editModalBtn', function (event) {
        var id = $(this).data('id');
        var action = '../members/edit' + id;
        var url = '../members/edit';
        $.ajax({
            type: 'get',
            url: url,
            data: {
                'id': id
            },
            beforeSend: function () {
                $('.preloader').show();
            },
            success: function (data) {
                $('.preloader').hide();
                $('#id').val(data.id);
                $('#username').val(data.username);
                $('#current_password').val(data.plain_password);
                $('#first_name').val(data.first_name);
                $('#mobile_no').val(data.mobile_no);
                $('#email').val(data.email);
                $('.classFormUpdate').attr('action', action);
                $('#editModal').modal('show');
            }
        });
    });

    $('body').on('click', '.btn-change-sponsor', function (event) {
        $('.preloader').show();
        var user_id = $(this).data('id');
        var username = $(this).data('username');
        $('#to_be_change_user_id').val(user_id);
        $('#change_sponsor_for').text(username);
        $('#changeSponsorModal').modal('show');
        $('.preloader').hide();
        
    });


    $('#update-btn').click(function () {
        event.preventDefault();
        var formData = new FormData();
        formData.append("id", $("#id").val());
        formData.append("username", $("#username").val());
        formData.append("email_address", $("#email").val());
        formData.append("first_name", $("#first_name").val());
        formData.append("mobile_no", $("#mobile_no").val());

        formData.append("new_password", $("#new_password").val());
        formData.append("confirm_password", $("#confirm_password").val());

        formData.append('_token', token);

        if (IsEmail($("#email").val()) == false) {
            swal({
                title: 'Error!',
                text: 'Error Msg: Invalid Email',
                timer: 1500,
                type: "error",
            });

        } else if ($("#new_password").val() != $("#confirm_password").val()) {
            swal({
                title: 'Error!',
                text: 'Error Msg: Password Not Match',
                timer: 1500,
                type: "error",
            });
        } else {
            $.ajax({
                url: '../members/update',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('.preloader').show();
                },
                success: function (response) {
                    $('.preloader').hide();
                    $('#editModal').modal('hide');
                    window.location.reload(true);
                },
                error: function (error) {
                    $('.preloader').hide();
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
    
    
    //Change Password Form
    $('body').on('click', '.edit-password', function (event) {
        var id = $(this).data('id');
        var action = '../members/edit' + id;
        var url = '../members/edit';
        $.ajax({
            type: 'get',
            url: url,
            data: {
                'id': id
            },
            beforeSend: function () {
                $('.preloader').show();
            },
            success: function (data) {
                $('.preloader').hide();
                $('#password_member_id').val(data.id);
                $('.classFormPasswordUpdate').attr('action', action);
                $('#edit-passwordModal').modal('show');
            }
        });
    });
    
    $('body').on('click', '.btn-delete-user', function (event) {
        var id = $(this).data('id');
        var username = $(this).data('username');
    
        swal({
            title: "Delete Member",
            text: "Are you sure you want to delete user: "+username+" ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes',
            cancelButtonText: "Cancel",
            closeOnConfirm: true,
            closeOnCancel: true
         },
         function(isConfirm){
            if (isConfirm){
                deleteMember(id);
            } else {
                console.log('cancel delete');
            }
         });
        
    });

    //Change Password Submit
    $('#update-password-btn').click(function () {
        event.preventDefault();
        var formData = new FormData();
        formData.append("id", $("#password_member_id").val());
        formData.append("new_password", $("#new_password").val());
        formData.append("confirm_password", $("#confirm_password").val());
        formData.append('_token', token);

        if (!$("#new_password").val() && $("#confirm_password").val()) {
            swal({
                title: 'Error!',
                text: 'Error Msg: Password Required!',
                timer: 1500,
                type: "error",
            });
        } else if ($("#new_password").val() != $("#confirm_password").val()) {
            swal({
                title: 'Error!',
                text: 'Error Msg: Password Not Match',
                timer: 1500,
                type: "error",
            });
        } else {
            $.ajax({
                url: '../members/password-update',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('.preloader').show();
                },
                success: function (response) {
                    $('.preloader').hide();
                    swal({
                        title: 'Success!',
                        text: 'Password Successfully Updated',
                        timer: 1500,
                        type: "success",
                    }, function () {
                        location.reload();
                    });
                },
                error: function (error) {
                    $('.preloader').hide();
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

        var formData = new FormData();
        formData.append("id", $(this).data('id'));
        formData.append('_token', token);

        $.ajax({
            url: '../members/modify',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('.preloader').show();
            },
            success: function (response) {
                $('.preloader').hide();
                swal({
                    title: 'Success!',
                    text: 'Successfully Modified',
                    timer: 1500,
                    type: "success",
                });
                location.reload();

            },
            error: function (error) {
                $('.preloader').hide();
                swal({
                    title: 'Error!',
                    text: "Error Msg: " + error.responseJSON.message + "",
                    timer: 1500,
                    type: "error",
                });
            }
        });
    })


});

function deleteMember(user_id){
    $.ajax({
        url: '../member-forcedelete/'+user_id,
        type: 'GET',
        beforeSend: function () {
            $('.preloader').show();
        },
        success: function (response) {
            $('.preloader').hide();
            swal({
                title: 'Success!',
                text: 'Member successfully deleted',
                type: "success",
            }, function () {
                location.reload();
            });

        },
        error: function (error) {
            $('.preloader').hide();
            var err=error.responseJSON.message;
            var err_msg="";
            if(err=="This member have downline."){
                err_msg="This member have downline.";
            }else{
                err_msg=error.responseJSON.message;
            }
            swal({
                title: 'Error',
                text: err_msg,
                type: "warning",
            });

        }
    });
}
