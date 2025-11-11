$('#branch_list_table').dataTable();
$(document).ready(function () {
	$('#branch_list_table_wrapper').removeClass('form-inline');
	$('#add_supplier').submit(function (event) {
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
			formData.append('name', $('#supplier_name').val());
			formData.append('code', $('#supplier_code').val());
			formData.append('first_name', $('#supplier_first_name').val());
			formData.append('last_name', $('#supplier_last_name').val());
			formData.append('tel_num', $('#supplier_tel_num').val());
			formData.append('mobile_num', $('#supplier_mobile_num').val());
			formData.append('email', $('#supplier_email').val());
			formData.append('address', $('#supplier_addr').val());

			$.ajax({
				url: 'insert-supplier',
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
						text: "Supplier successfully added",
						type: "success",
					}, function () {
						window.location.href = 'supplier-list';
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
			url: 'get-supplier/' + id,
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
				$('#edit_supplier_name').val(data.supplier_name);
				$('#edit_supplier_code').val(data.supplier_code);
				$('#edit_supplier_first_name').val(data.contact_first_name);
				$('#edit_supplier_last_name').val(data.contact_last_name);
				$('#edit_supplier_tel_num').val(data.contact_tel_num);
				$('#edit_supplier_mobile_num').val(data.contact_mobile_num);
				$('#edit_supplier_email').val(data.contact_email);
				$('#edit_supplier_addr').val(data.contact_address);
				$('#edit-modal').modal();

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
	
	 $('body').on('submit', '#edit_supplier', function (event) {
        event.preventDefault();
        console.log('Edit Supplier');
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
            formData.append('name', $('#edit_supplier_name').val());
            formData.append('code', $('#edit_supplier_code').val());
            formData.append('first_name', $('#edit_supplier_first_name').val());
            formData.append('last_name', $('#edit_supplier_last_name').val());
            formData.append('tel_num', $('#edit_supplier_tel_num').val());
            formData.append('mobile_num', $('#edit_supplier_mobile_num').val());
            formData.append('email', $('#edit_supplier_email').val());
            formData.append('address', $('#edit_supplier_addr').val());
            //formData.append('attachment', $('#add_attachment').val());
            $.ajax({
                url: 'update-supplier',
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
                        text: "Supplier successfully Updated",
                        type: "success",
                    }, function () {
                        window.location.href = 'supplier-list';
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
    
    $('body').on('click', '.btn-view', function () {
		var id = $(this).data('id');
		$.ajax({
			url: 'get-supplier/' + id,
			type: 'GET',
			beforeSend: function () {
				$('.send-loading').show();
			},
			success: function (data) {
				$('.send-loading').hide();
				$('#view_supplier_name').html(data.supplier_name);
				$('#view_supplier_code').html(data.supplier_code);
				$('#view_supplier_first_name').html(data.contact_first_name);
				$('#view_supplier_last_name').html(data.contact_last_name);
				$('#view_supplier_tel_num').html(data.contact_tel_num);
				$('#view_supplier_mobile_num').html(data.contact_mobile_num);
				$('#view_supplier_email').html(data.contact_email);
				$('#view_supplier_addr').html(data.contact_address);
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
    
    $('body').on('click', '.btn-delete', function (event) {
        event.preventDefault();
        console.log('Delete Package');
        var id = $(this).data('id');

        $.ajax({
            url: 'get-supplier/' + id,
            type: 'GET',
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('.send-loading').show();
            },
            success: function (data) {
                $('.send-loading').hide();
                $('#delete_id').val(data.id);
                $('.name').html(data.supplier_name);
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
        console.log('Delete Package');
        $.ajax({
            url: 'delete-supplier',
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
                    text: "Supplier successfully Deleted",
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




