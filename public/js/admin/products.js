$(document).ready(function () {
    $('#products_table').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    //$('#movements-table').DataTable();

    //Add Button
    $('body').on('submit', '#add-form', function (event) {
        event.preventDefault();
        console.log('Product Add submitting...');
        $.ajax({
            url: 'insert-product',
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('.send-loading').show();
            },
            success: function (response) {
                console.log('Product Add submitting success...');
                $('.send-loading').hide();
                swal({
                    title: 'Success!',
                    text: 'Successfully Added',
                    timer: 1500,
                    type: "success",
                }).then(() => {
                    window.location.href = 'products';
                });

            },
            error: function (error) {
                console.log('Product Add submitting error...');
                console.log(error);
                console.log(error.responseJSON.message);
                $('.send-loading').hide();
                swal({
                    title: 'Error!',
                    text: "Error Msg: " + error.responseJSON.message + "",
                    //timer: 1500,
                    type: "error",
                })
            }
        });
    });

    $('body').on('click', '.btn-edit', function () {
        var id = $(this).data('id');
        $("#classFormUpdate").trigger('reset');
        $('#edit_product-img').val('');
        $.ajax({
            url: 'edit-product/' + id,
            type: 'GET',
            beforeSend: function () {
                console.log('Getting data...');
                $('.send-loading').show();
            },
            success: function (data) {
                console.log('Success...');
                $('.send-loading').hide();
                $('#edit_id').val(data.id);
                $('#edit_name').val(data.name);
                $('#edit_price').val(data.price);
                $('#edit_cost_price').val(data.cost_price);
                $('#edit_critical_level').val(data.critical_level);
                $('#edit_description').val(data.description);
                $('#reward_points').val(data.reward_points).attr('selected', 'selected');
                //$('#view_image').attr('src', '../' + data.image);
                $('#edit-modal').modal('show');
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
 
    $('body').on('click', '.edit-discount-modal', function () {
        var id = $(this).data('id');
        $("#classFormUpdateDiscount").trigger('reset');
        $('#edit-discount-modal').modal('show');
    })
 
    //Update Button
    $('body').on('submit', '#classFormUpdateDiscount', function (event) {
        event.preventDefault();
        console.log('Product update submitting...');
        $.ajax({
            url: 'products/update-dev',
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('.send-loading').show();
            },
            success: function (response) {
                console.log('Product update submitting success...');
                $('.send-loading').hide();
                swal({
                    title: 'Success!',
                    text: 'Successfully Updated',
                    timer: 500,
                    type: "success",
                }).then(() => {
                    //window.location.href = 'products';
                });

            },
            error: function (error) {
                console.log('Product update submitting error...');
                console.log(error);
                console.log(error.responseJSON.message);
                $('.send-loading').hide();
                swal({
                    title: 'Error!',
                    text: "Error Msg: " + error.responseJSON.message + "",
                    timer: 1500,
                    type: "error",
                })
            }
        });
    });


    $('body').on('click', '.btn-view', function () {
        var id = $(this).data('id');
        
        // Reset the form and clear the DataTable
        $("#classFormUpdate").trigger('reset');
        $('#edit_product-img').val('');
        if ($.fn.DataTable.isDataTable('#movements-table')) {
            $('#movements-table').DataTable().clear().destroy();
        }
        
        // Send an AJAX request to retrieve product details
        $.ajax({
            url: 'view-product/' + id,
            type: 'GET',
            beforeSend: function () {
                $('.send-loading').show();
            },
            success: function (data) {
                $('.send-loading').hide();
                
                // Update product details in the view
                $('#view_id').html(data.id);
                $('#view_name').html(data.name);
                $('#view_price').html(data.price);
                $('#view_cost_price').html(data.cost_price);
                $('#view_quantity').html(data.quantity);
                $('#view_reward_points_percentage').html(data.reward_points * 100 + '%');
                
                $('#view_critical_level').html(data.critical_level);
                $('#view_description').html(data.description);
                $('#view_category').html(data.category_name);
                $('#product-view-image').attr('src', '../' + data.image);
                
                // Initialize or reinitialize the DataTable with updated data
                $('#movements-table').DataTable({
                    "ajax": 'view-product-movement/' + id,
                    "columns": [
                        {
                            "data": "entry_type"
                        },
                        {
                            "data": "quantity"
                        },
                        {
                            "data": "created_at"
                        }
                    ]
                });
                
                // Show the modal
                $('#view-modal').modal('show');
            },
            error: function (error) {
                console.log('Error...');
                console.log(error);
                console.log(error.responseJSON.message);
                $('.send-loading').hide();
                
                // Display an error message
                swal({
                    title: "Error!",
                    text: "Error message: " + error.responseJSON.message + "",
                    type: "error",
                });
            }
        });
    });
    

    //Button Delete
    $('body').on('click', '.btn-delete', function () {
        var id = $(this).data('id');
        $("#classFormUpdate").trigger('reset');
        $.ajax({
            url: 'view-product/' + id,
            type: 'GET',
            beforeSend: function () {
                $('.send-loading').show();
            },
            success: function (data) {
                $('.send-loading').hide();
                $('#delete_id').val(data.id);
                $('.product_name').html(data.name);
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

    //Delete Product
    $('body').on('submit', '#classFormDelete', function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        var deleteId = formData.get('id');
        
        // Get the CSRF token from the meta tag
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        
        $.ajax({
            url: './products/' + deleteId,
            type: 'DELETE',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            
            // Set the CSRF token in the headers
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            
            beforeSend: function() {
                $('.send-loading').show();
            },
            
            success: function(response) {
                $('.send-loading').hide();
                swal({
                    title: 'Success!',
                    text: 'Successfully Deleted!',
                    timer: 500,
                    type: "success",
                }).then(() => {
                    window.location.href = 'products';
                });
            },
            
            error: function(error) {
                $('.send-loading').hide();
                swal({
                    title: 'Error!',
                    text: "Error Msg: " + error.responseJSON.message + "",
                    timer: 1500,
                    type: "error",
                });
            }
        });
    });



    //Update Button
    $('body').on('submit', '#classFormUpdate', function (event) {
        event.preventDefault();
        console.log('Product update submitting...');
        $.ajax({
            url: 'products/update',
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('.send-loading').show();
            },
            success: function (response) {
                console.log('Product update submitting success...');
                $('.send-loading').hide();
                swal({
                    title: 'Success!',
                    text: 'Successfully Updated',
                    timer: 500,
                    type: "success",
                }).then(() => {
                    window.location.href = 'products';
                });

            },
            error: function (error) {
                console.log('Product update submitting error...');
                console.log(error);
                console.log(error.responseJSON.message);
                $('.send-loading').hide();
                swal({
                    title: 'Error!',
                    text: "Error Msg: " + error.responseJSON.message + "",
                    timer: 1500,
                    type: "error",
                })
            }
        });
    });

    //Delete
    $('body').on('click', '.deleteProduct', function(event) {
        if (!confirm("Do you really want to do this?")) {
            return false;
        }
        event.preventDefault();
        console.log('Product Delete submitting...');
        
        var productId = $(this).data('id');
        
        $.ajax({
            url: './products/' + productId, // Use the appropriate URL based on your route
            type: 'DELETE', // Use the DELETE method
            data: {
                _token: token,
            },
            beforeSend: function() {
                $('.send-loading').show();
            },
            success: function(response) {
                console.log('Product Delete submitting success...');
                $('.send-loading').hide();
                swal({
                    title: 'Success!',
                    text: 'Successfully Deleted',
                    timer: 500,
                    type: "success",
                }).then(() => {
                    window.location.href = 'products'; // Redirect to the product list page
                });
            },
            error: function(error) {
                console.log('Product Delete submitting error...');
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
    });
    

    $('body').on('click', '#view_pic', function () {
        console.log('view pic');
        $('#picture_preview-modal').modal('show');
    })

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#picture_preview-modal').modal('show');
                $('#product-img-tag').attr('src', e.target.result);

            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function readURLedit(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                //$('#edit_product-img-tag').attr('src', e.target.result);
                $('#picture_preview-modal').modal('show');
                $('#product-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#product-img").change(function () {
        readURL(this);
    });

    $("#edit_product-img").change(function () {
        readURLedit(this);
    });

})
