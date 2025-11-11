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
            //member
            var ar_edit_member =$('#ar_edit_member').val();
            var ar_deactivate_member =$('#ar_deactivate_member').val();
            //Inventories
            var ar_transfer_stocks =$('#ar_transfer_stocks').val();
            //E-wallet purchases
            var ar_approve_ewallet =$('#ar_approve_ewallet').val();
            var ar_decline_ewallet =$('#ar_decline_ewallet').val();
            //Products
            var ar_add_product =$('#ar_add_product').val();
            var ar_edit_product =$('#ar_edit_product').val();
            var ar_delete_product =$('#ar_delete_product').val();
            //Packages
            var ar_add_packages =$('#ar_add_packages').val();
            var ar_edit_packages =$('#ar_edit_packages').val();
            var ar_delete_packages =$('#ar_delete_packages').val();
            //Announcement
            var ar_add_announcement =$('#ar_add_announcement').val();
            var ar_edit_announcement =$('#ar_edit_announcement').val();
            var ar_delete_announcement =$('#ar_delete_announcement').val();
            //Encashments
            var ar_approve_encash =$('#ar_approve_encash').val();
            var ar_process_encash =$('#ar_process_encash').val();
            var ar_decline_encash =$('#ar_decline_encash').val();
            var ar_hold_encash =$('#ar_hold_encash').val();
            //Branch
            var ar_add_branch =$('#ar_add_branch').val();
            var ar_edit_branch =$('#ar_edit_branch').val();
            var ar_delete_branch =$('#ar_delete_branch').val();
            //Supplier
            var ar_add_supplier =$('#ar_add_supplier').val();
            var ar_edit_supplier =$('#ar_edit_supplier').val();
            var ar_delete_supplier =$('#ar_delete_supplier').val();
            //User
            var ar_add_user =$('#ar_add_user').val();
            var ar_edit_user =$('#ar_edit_user').val();
            var ar_delete_user =$('#ar_delete_user').val();

            var access_rights=[
                {
                    "member":[
                        {
                            "edit_member":ar_edit_member,
                            "deactivate_member":ar_deactivate_member
                        }],
                    "inventories":[
                        {
                            "transfer_stocks":ar_transfer_stocks
                        }],
                    "ewallet_purches":[
                        {
                            "approve":ar_approve_ewallet,
                            "decline":ar_decline_ewallet
                        }], 
                    "product":[
                        {
                            "add":ar_add_product,
                            "edit":ar_edit_product,
                            "delete":ar_delete_product
                        }],
                    "package":[
                        {
                            "add":ar_add_packages,
                            "edit":ar_edit_packages,
                            "delete":ar_delete_packages
                        }],
                    "announcement":[
                        {
                            "add":ar_add_announcement,
                            "edit":ar_edit_announcement,
                            "delete":ar_delete_announcement
                        }],
                    "encashment":[
                        {
                            "approve":ar_approve_encash,
                            "process":ar_process_encash,
                            "decline":ar_decline_encash,
                            "hold":ar_hold_encash
                        }],
                    "branch":[
                        {
                            "add":ar_add_branch,
                            "edit":ar_edit_branch,
                            "delete":ar_delete_branch
                        }],
                    "supplier":[
                        {
                            "add":ar_add_supplier,
                            "edit":ar_edit_supplier,
                            "delete":ar_delete_supplier
                        }],
                    "user":[
                        {
                            "add":ar_add_user,
                            "edit":ar_edit_user,
                            "delete":ar_delete_user
                        }]           
                }
            ];
            access_rights=JSON.stringify(access_rights);
            form_data.append("access_rights",access_rights);
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
                    swal({
                        title: 'Success!',
                        text: 'Successfully Added',
                        type: "success",
                    }, function () {
                        window.location.href = 'users';
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
                var user_type = data.userType;
                console.log(user_type);
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
                    }, function () {
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
                }, function () {
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
        url: 'delete-user',
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



$('#add_role').change(function () {
    //var role = $(this).val();
    //var role = $(this).("option:selected").html();
    var role = $(this).children("option:selected").val();
    console.log(role);
    if (role == 'tellers') {
        $("#branch").show("slow");
        $("#add_branch").addClass("req_fields");
        $('#access-rights').hide("slow");
    } else {
        $("#branch").hide("slow");
        $('#access-rights').show("slow");
        $("#add_branch").removeClass("req_fields");
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
