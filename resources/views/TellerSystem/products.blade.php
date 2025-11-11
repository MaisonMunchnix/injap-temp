@extends('layouts.teller.master')


@section('title', 'Products')

@section('stylesheets')

@endsection

@section('breadcrumbs')
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h3 class="page-title">@yield('title')</h3>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! url('teller-admin/') !!}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                </ol>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="widgetbar">
                <button class="btn btn-primary" data-toggle="modal" data-target="#add-modal"><i
                        class='feather icon-plus'></i> Product</button>
            </div>
        </div>
    </div>
@endsection

@section('contents')
    <!--<div class="card-header">
                                                         <h5 class="card-title">@yield('title') </h5>
                                                        </div>-->
    <div class="card-header">
        <h5 class="card-title">@yield('title')</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive border-bottom" data-toggle="lists"
            data-lists-values='["js-lists-values-employee-name"]'>
            <table class="table mb-0 thead-border-top-0" id="products_table" style="width:100% !important">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Image</th>
                        <th>Critical Level</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->code }}</td>
                            <td>{{ $product->description }}</td>
                            <td style="text-transform: capitalize;">{{ $product->category_name }}</td>
                            <td><img src="{{ asset('images/products/' . $product->id . '/' . $product->image) }}"
                                    height="30px"></td>
                            <td>{{ $product->critical_level }}</td>
                            <td>{{ $product->status }}</td>
                            <td>{{ $product->created_at }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Action Buttons">
                                    <button type="button" class="btn btn-warning btn-sm editRecord" data-toggle="modal"
                                        data-id="{{ $product->id }}"><i class='feather icon-edit-2'></i></button>
                                    <button type="button" class="btn btn-danger btn-sm deleteProduct" data-toggle="modal"
                                        data-id="{{ $product->id }}"><i class='feather icon-trash'></i></button>
                                </div>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col-md-12">
                @if (Session::has('successMsg'))
                    <div class="alert alert-success"> {{ Session::get('successMsg') }}</div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#products_table').DataTable();

            $('body').on('click', '.editRecord', function(event) {
                console.log('edit btn clicked');
                var id = $(this).data('id');
                var action = 'products/edit/' + id;
                var url = 'products/edit';
                $.ajax({
                    type: 'get',
                    url: url,
                    data: {
                        'id': id
                    },
                    beforeSend: function() {
                        $('.send-loading').show();
                    },
                    success: function(data) {
                        $('.send-loading').hide();
                        $('#edit_id').val(data.id);
                        $('#edit_name').val(data.name);
                        $('#edit_name').val(data.name);
                        $('#edit_critical_level').val(data.critical_level);
                        $('#edit_description').val(data.description);
                        /*$('#edit_category').val(data.category);*/
                        $('#edit_category').find('option[value="' + data.category + '"]').attr(
                            'selected', 'selected');
                        $('#edit_product-img-tag').attr('src', '../images/products/' + data.id +
                            '/' + data.image);
                        $('.classFormUpdate').attr('action', action);
                        $('#edit-record-modal').modal('show');
                    }
                });
            });

            //Update Button
            $('body').on('submit', '#classFormUpdate', function(event) {
                event.preventDefault();
                console.log('Product update submitting...');
                $.ajax({
                    url: 'products/update',
                    type: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $('.send-loading').show();
                    },
                    success: function(response) {
                        console.log('Product update submitting success...');
                        $('.send-loading').hide();
                        swal({
                            title: 'Success!',
                            text: 'Successfully Updated',
                            timer: 1500,
                            type: "success",
                        }).then(
                            function() {},
                            function(dismiss) {
                                if (dismiss === 'timer') {
                                    window.location.href = "@yield('title')"
                                        .toLowerCase();
                                }
                            }
                        )

                    },
                    error: function(error) {
                        console.log('Product update submitting error...');
                        console.log(error);
                        console.log(error.responseJSON.message);
                        $('.send-loading').hide();
                        swal({
                            title: 'Error!',
                            text: "Error Msg: " + error.responseJSON.message + "",
                            timer: 1500,
                            type: "error",
                        }).then(
                            function() {},
                            function(dismiss) {}
                        )
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
                    url: '/products/' + productId,
                    type: 'DELETE',
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
                            timer: 1500,
                            type: "success",
                        }).then(function() {
                            window.location.href = window.location
                                .href; // Reload the current page
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


            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#product-img-tag').attr('src', e.target.result);

                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function readURLedit(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#edit_product-img-tag').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#product-img").change(function() {
                readURL(this);
            });

            $("#edit_product-img").change(function() {
                readURLedit(this);
            });

        });
    </script>

    <div id="add-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="add-modal-title"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('insert-product') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="add-modal-title">Add Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div> <!-- // END .modal-header -->
                    <div class="modal-body">
                        <div class="form-group" data-toggle="tooltip" data-placement="top" title="Image is not required">
                            <label for="name" class="col-form-label">Image:</label>
                            <input type="file" name="image" id="product-img" class="form-control">
                            <img src="" id="product-img-tag" class="img-fluid">
                        </div>
                        <div class="form-group" data-toggle="tooltip" data-placement="top" title="Name is required">
                            <label for="name" class="col-form-label">Name: *</label>
                            <input class="form-control" placeholder="Name" id="name" name="name" type="text"
                                required>
                        </div>
                        <div class="form-group" data-toggle="tooltip" data-placement="top"
                            title="Critical Level is required">
                            <label for="critical_level" class="col-form-label">Critical Level: *</label>
                            <input class="form-control" placeholder="Critical Level" id="critical_level"
                                name="critical_level" type="number" required>
                        </div>
                        <div class="form-group" data-toggle="tooltip" data-placement="top"
                            title="Begining Quantity is optional">
                            <label for="qty" class="col-form-label">Begining Quantity:</label>
                            <input class="form-control" placeholder="Begining Quantity" id="qty" name="qty"
                                type="number" value="0" required>
                        </div>
                        <div class="form-group" data-toggle="tooltip" data-placement="top"
                            title="Description is not required">
                            <label for="description" class="col-form-label">Description:</label>
                            <textarea class="form-control" name="description" id="description" placeholder="Description"></textarea>
                        </div>
                        <div class="form-group" data-toggle="tooltip" data-placement="top" title="Category is required">
                            <label for="category" class="col-form-label">Category:</label>
                            <select class="form-control" name="category" id="category" required>
                                <option value="" selected>Select Category</option>
                                @foreach ($product_categories as $product_category)
                                    <option value="{{ $product_category->id }}">{{ $product_category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> <!-- // END .modal-body -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="add-product-btn">Save changes</button>
                    </div> <!-- // END .modal-footer -->
                </form>
            </div> <!-- // END .modal-content -->
        </div> <!-- // END .modal-dialog -->
    </div> <!-- // END .modal -->

    <div id="edit-record-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="add-modal-title"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="" class="classFormUpdate" id="classFormUpdate"
                    enctype="multipart/form-data">
                    @csrf
                    <span id="form_output"></span>
                    <div class="modal-header">
                        <h5 class="modal-title" id="modelHeading">Edit Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div> <!-- // END .modal-header -->
                    <div class="modal-body">
                        <div class="form-group" data-toggle="tooltip" data-placement="top"
                            title="Image is not required">
                            <label for="name" class="col-form-label">Image:</label>
                            <input type="file" name="image" id="edit_product-img" class="form-control">
                            <img src="" id="edit_product-img-tag" class="img-fluid">
                        </div>
                        <div class="form-group" data-toggle="tooltip" data-placement="top" title="Name is required">
                            <label for="name" class="col-form-label">Name: *</label>
                            <input id="edit_id" name="id" type="hidden" required>
                            <input class="form-control" placeholder="Name" id="edit_name" name="edit_name"
                                type="text" required>
                        </div>
                        <div class="form-group" data-toggle="tooltip" data-placement="top"
                            title="Critical Level is required">
                            <label for="critical_level" class="col-form-label">Critical Level: *</label>
                            <input class="form-control" placeholder="Critical Level" id="edit_critical_level"
                                name="edit_critical_level" type="number" required>
                        </div>
                        <div class="form-group" data-toggle="tooltip" data-placement="top"
                            title="Description is not required">
                            <label for="description" class="col-form-label">Description:</label>
                            <textarea class="form-control" name="edit_description" id="edit_description" placeholder="Description"></textarea>
                        </div>
                        <div class="form-group" data-toggle="tooltip" data-placement="top" title="Category is required">
                            <label for="category" class="col-form-label">Category:</label>
                            <!--<textarea class="form-control" name="edit_category" id="edit_category" placeholder="Category" required></textarea>-->

                            <select class="form-control" name="edit_category" id="edit_category" required>
                                <option value="" selected>Select Category</option>
                                @foreach ($product_categories as $product_category)
                                    <option value="{{ $product_category->id }}">{{ $product_category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> <!-- // END .modal-body -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="edit-product-btn">Save changes</button>
                    </div> <!-- // END .modal-footer -->
                </form>
            </div> <!-- // END .modal-content -->
        </div> <!-- // END .modal-dialog -->
    </div> <!-- // END .modal -->
@endsection
