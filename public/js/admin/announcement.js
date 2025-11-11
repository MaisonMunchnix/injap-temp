$('#branch_list_table').dataTable();
$(document).ready(function () {
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        uiLibrary: 'bootstrap4'
    });
    /* <script>
         $('#datepicker').datepicker({
             uiLibrary: 'bootstrap4'
         });
     </script>*/
    /*$("#date_end").daterangepicker({
    	singleDatePicker: true,
    	showDropdowns: true,
    	format: "YYYY-MM-DD"
    	locale: {
    		"format": "YYYY-MM-DD"
    	}
    });*/
    /*$('#date_end').on('apply.daterangepicker', function (ev, picker) {
    	picker.startDate.format('YYYY-MM-DD');
    	//console.log(picker.endDate.format('YYYY-MM-DD'));
    });*/

    $('#branch_list_table_wrapper').removeClass('form-inline');
    //$('#add_announcement').submit(function(event) {
    $('body').on('submit', '#add_announcement', function (event) {
        event.preventDefault();
        console.log('add_announcement');
        var count_null_fields = 0; // for counting the empty fields
        var fields_require = $('.add_req_fields');
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
            var files = $('input[type=file]')[0].files;
            console.log(files.length);

            for (var i = 0; i < files.length; i++) {
                formData.append("attachment[]", files[i]);

            }
            formData.append('_token', token);
            formData.append('add_title', $('#add_title').val());
            formData.append('add_subject', $('#add_subject').val());
            formData.append('add_message', $('#add_message').val());
            formData.append('add_attachment', $('#add_attachment').val());
            formData.append('date_end', $('#date_end').val());
            formData.append('priority', $('#priority').val());
            //formData.append('attachment', $('#add_attachment').val());
            $.ajax({
                url: 'insert-announcement',
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
                        text: "Announcement successfully added",
                        type: "success",
                    }, function () {
                        window.location.href = 'announcement';
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

    $('body').on('click', '.task-btn-edit', function () {
        var id = $(this).data('id');
        $.ajax({
            url: 'edit-announcement/' + id,
            type: 'GET',
            beforeSend: function () {
                console.log('Getting data...');
                $('.send-loading').show();
            },
            success: function (data) {
                console.log('Success...');
                console.log(data);
                $('.send-loading').hide();
                $('#edit_title').val(data.title);
                $('#edit_id').val(data.id);
                $('#edit_subject').val(data.subject);
                $('#edit_message').val(data.content);
                $('#edit_date_end').val(data.date_end);
                $('#edit_priority').find('option[value="' + data.priority + '"]').attr('selected', 'selected');
                $("#edit-announcement-modal").modal("show");
                console.log('Success Modal');
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

    $('body').on('submit', '#edit_announcement', function (event) {
        event.preventDefault();
        console.log('Edit announcement');
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
            var files = $('#edit_attachment')[0].files;
            console.log(files.length);

            for (var i = 0; i < files.length; i++) {
                formData.append("edit_attachment[]", files[i]);

            }
            formData.append('_token', token);
            formData.append('id', $('#edit_id').val());
            formData.append('title', $('#edit_title').val());
            formData.append('subject', $('#edit_subject').val());
            formData.append('message', $('#edit_message').val());
            formData.append('date_end', $('#edit_date_end').val());
            formData.append('priority', $('#edit_priority').val());
            //formData.append('attachment', $('#add_attachment').val());
            $.ajax({
                url: 'update-announcement',
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
                        text: "Announcement successfully added",
                        type: "success",
                    }, function () {
                        window.location.href = 'announcement';
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

    /* Delete Form*/
    $('body').on('click', '.task-btn-delete', function () {
        var id = $(this).data('id');
        $.ajax({
            url: 'edit-announcement/' + id,
            type: 'GET',
            beforeSend: function () {
                console.log('Getting data...');
                $('.send-loading').show();
            },
            success: function (data) {
                console.log('Success...');
                console.log(data);
                $('.send-loading').hide();
                $('#delete_title').text(data.title);
                $('#delete_id').val(data.id);
                $("#delete-modal").modal("show");
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

    /* Delete*/
    $('body').on('submit', '#delete_announcement', function (event) {
        event.preventDefault();
        console.log('Delete announcement');

        //error free
        console.log('test');
        var formData = new FormData();
        formData.append('_token', token);
        formData.append('id', $('#delete_id').val());

        $.ajax({
            url: 'delete-announcement',
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
                    text: "Announcement successfully Deleted",
                    type: "success",
                }, function () {
                    window.location.href = 'announcement';
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



    new Quill('.reply-email-quill-editor', {
        modules: {
            toolbar: ".reply-email-quill-toolbar"
        },
        placeholder: "Type something... ",
        theme: "snow"
    });

    $(function () {
        $(document).on('click', '.app-block .app-content .app-action .action-left input[type="checkbox"]', function () {
            $('.app-lists ul li input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            if ($(this).prop('checked')) {
                $('.app-lists ul li input[type="checkbox"]').closest('li').addClass('active');
            } else {
                $('.app-lists ul li input[type="checkbox"]').closest('li').removeClass('active');
            }
        });

        $(document).on('click', '.app-lists ul li input[type="checkbox"]', function () {
            if ($(this).prop('checked')) {
                $(this).closest('li').addClass('active');
            } else {
                $(this).closest('li').removeClass('active');
            }
        });

        $(document).on('click', '.app-block .app-content .app-content-body .app-lists ul.list-group li.list-group-item', function (e) {
            if (!$(e.target).is('.custom-control, .custom-control *, a, a *')) {
                $('.app-detail').addClass('show').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function () {
                    $('.app-block .app-content .app-content-body .app-detail .app-detail-article').niceScroll().resize();
                });
            }
        });

        $(document).on('click', 'a.app-detail-close-button', function () {
            $('.app-detail').removeClass('show');
            return false;
        });

        $(document).on('click', '.app-sidebar-menu-button', function () {
            $('.app-block .app-sidebar, .app-content-overlay').addClass('show');
            // $('.app-block .app-sidebar .app-sidebar-menu').niceScroll().resize();
            return false;
        });

        $(document).on('click', '.app-content-overlay', function () {
            $('.app-block .app-sidebar, .app-content-overlay').removeClass('show');
            return false;
        });

        $('.app-block .app-content .app-content-body .app-lists ul').sortable({
            axis: "y",
            cursor: "move",
            handle: '.app-sortable-handle'
        }).disableSelection();
    });



})
