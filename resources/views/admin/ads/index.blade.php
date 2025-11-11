@extends('layouts.default.admin.master')
@section('title', 'Advertisements')

@section('stylesheets')
    {{-- additional style here --}}
    <!-- swal -->
    <script src="https://cdn.tiny.cloud/1/2dwxbbbzlzih0see4ch7mej3a342yy131hsfagakslt9ru8o/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <style>
        .border-red {
            border: 1px solid red !important;
        }
    </style>
@endsection

@section('content')
    <div class="content-body">
        <!-- start content- -->
        <div class="content">
            <div class="page-header">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin-dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                    </ol>
                </nav>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <h3>Advertisements</h3>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-info pull-right" data-toggle="modal"
                                data-target="#add_modal">Create Ads</button>
                        </div>
                    </div>
                    <table id="ads_table" width="100%" class="table table-striped table-lightfont">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Updated</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Username</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Updated</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('admin.ads.modal.add')
    @include('admin.ads.modal.view')
    @include('admin.ads.modal.edit')
    <!-- end content-i -->
@endsection

@section('scripts')
    {{-- additional scripts here --}}
    <!-- Sweetalert -->

    <script>
        let get_ads = "{{ route('admin.get-advertisements') }}";
        var save_ads = "{{ route('admin.save-ads') }}";
        var update_ads = "{{ route('admin.update-ads') }}";
        $('#ads_table').DataTable({
            "order": [
                [0, "asc"]
            ],
            processing: true,
            serverSide: true,
            responsive: true,
            "ajax": {
                "url": get_ads,
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: token
                }
            },
            "columns": [{
                    "data": "username"
                }, {
                    "data": "title"
                },
                {
                    "data": "status"
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "updated_at"
                },
                {
                    "data": "action"
                }
            ]
        });

        $('#create-ads-form').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var content = tinyMCE.get('content');
            formData.append('content', content.getContent());
            $.ajax({
                url: save_ads,
                type: 'POST',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('.send-loading').show();
                },
                success: function(response) {
                    $('.send-loading').hide();
                    $('#ads_table').DataTable().ajax.reload();
                    $('#add_modal').modal('hide');
                    $('#create-ads-form')[0].reset();
                    swal({
                        title: 'Success!',
                        text: 'Successfully Added',
                        type: "success",
                    });
                },
                error: function(xhr) {
                    $('.send-loading').hide();
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessages = [];
                        for (var key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                errorMessages.push(errors[key][0]);
                            }
                        }
                        swal({
                            title: 'Validation Error!',
                            text: errorMessages.join('\n'),
                            type: 'error',
                        });
                    } else {
                        swal({
                            title: 'Error!',
                            text: 'An error occurred. Please try again later.',
                            type: 'error',
                        });
                    }
                },
            });
        });


        $('body').on('click', '.btn-view', function() {
            var id = $(this).data('id');
            $.ajax({
                url: 'get-ads/' + id,
                type: 'GET',
                beforeSend: function() {
                    $('.send-loading').show();
                },
                success: function(data) {
                    $('.send-loading').hide();
                    $('#view-title').text(data.title);
                    $('#view-content').html(data.content);
                    $('#view_modal').modal('show');
                },
                error: function(error) {
                    $('.send-loading').hide();
                    swal({
                        title: "Error!",
                        text: "Error message: " + error.responseJSON.message + "",
                        type: "error",
                    });
                }
            });
        });

        $('body').on('click', '.btn-edit', function() {
            var id = $(this).data('id');
            $("#edit-ads-form").trigger('reset');
            $.ajax({
                url: 'get-ads/' + id,
                type: 'GET',
                beforeSend: function() {
                    $('.send-loading').show();
                },
                success: function(data) {
                    console.log('Success...');
                    $('.send-loading').hide();
                    $('#edit_id').val(data.id);
                    $('#edit_title').val(data.title);
                    $('#editeModalLabel').text('Edit: ' + data.title);
                    $('#edit_content').val(data.content);
                    tinymce.get('edit_content').setContent(data.content);
                    $('#edit_modal').modal('show');
                },
                error: function(error) {
                    $('.send-loading').hide();
                    swal({
                        title: "Error!",
                        text: "Error message: " + error.responseJSON.message + "",
                        type: "error",
                    });
                }
            });
        });

        //Update Button
        $('body').on('submit', '#edit-ads-form', function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            var content = tinyMCE.get('edit_content');
            formData.append('content', content.getContent());
            $.ajax({
                url: update_ads,
                type: 'POST',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('.send-loading').show();
                },
                success: function(response) {
                    $('.send-loading').hide();
                    $('#edit_modal').modal('hide');
                    $('#ads_table').DataTable().ajax.reload();
                    swal({
                        title: 'Success!',
                        text: 'Successfully Updated',
                        type: "success",
                    });
                },
                error: function(xhr) {
                    $('.send-loading').hide();
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessages = [];
                        for (var key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                errorMessages.push(errors[key][0]);
                            }
                        }
                        swal({
                            title: 'Validation Error!',
                            text: errorMessages.join('\n'),
                            type: 'error',
                        });
                    } else {
                        swal({
                            title: 'Error!',
                            text: 'An error occurred. Please try again later.',
                            type: 'error',
                        });
                    }
                },
            });
        });

        $('body').on('click', '.btn-delete', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this Ads!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('admin.delete-ads') }}",
                            data: {
                                id: id,
                                _token: token
                            },
                            cache: false,
                            success: function(data) {
                                $('#ads_table').DataTable().ajax.reload();
                                swal("Advertisement has been deleted!", {
                                    icon: "success",
                                });
                            }
                        });
                    }
                });
        });

        $('body').on('click', '.btn-swal', function(e) {
            var id = $(this).data('id');
            var action = $(this).data('action');
            var title = "";
            if (action == 'accept') {
                title = "Approve Confirmation";
            } else {
                title = "Reject Confirmation";
            }
            swal({
                    title: "Are you sure?",
                    text: title,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        console.log(action);
                        processAction(id, action)
                    }
                });
        });

        function processAction(id, action) {
            var form_data = new FormData();
            form_data.append('_token', token);
            form_data.append('id', id);
            form_data.append('action', action);
            var text = "";
            if (action == 'accept') {
                text = "Approved";
            } else if (action == 'delete') {
                text = "Deleted";
            } else {
                text = "cancelled";
            }
            $.ajax({
                url: "{{ route('admin.ads.action') }}",
                type: 'POST',
                data: form_data,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('.send-loading').show();

                },
                success: function(response) {
                    $('#view-remark-modal').modal('hide');
                    $('#remark').val('');
                    $('.send-loading').hide();
                    swal({
                        title: "Success!",
                        text: "successfully " + text + ".",
                        type: "success"
                    });
                    $('#ads_table').DataTable().ajax.reload();
                },
                error: function(error) {
                    console.log(error);
                    $('.send-loading').hide();
                    swal({
                        title: "Warning!",
                        text: "Something went wrong please try again later",
                        type: "warning",
                    });
                }
            });
        }

        tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>
@endsection
