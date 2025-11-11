@extends('layouts.default.master')
@section('title', 'Advetisements')
@section('page-title', 'Advetisements')

@section('stylesheets')
    {{-- additional style here --}}
    <script src="https://cdn.tiny.cloud/1/2dwxbbbzlzih0see4ch7mej3a342yy131hsfagakslt9ru8o/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <style>
        <style>.border-red {
            border: 1px solid red !important;
        }

        .card .bg-info-gradient {
            height: 146px !important;
        }
    </style>
@endsection

@section('content')
    {{-- content here --}}

    <div class="content-body">
        <div class="content">
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
                    <div class="table-responsive">
                        <table id="advertisements_tbl" width="100%" class="table table-striped table-lightfont">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Updated</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Updated</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                        </table>
                        <br>
                        <br>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('user.advertisements.modal.add')
    @include('user.advertisements.modal.view')
    @include('user.advertisements.modal.edit')
@endsection

@section('scripts')
    {{-- additional scripts here --}}

    <script>
        var get_ads_route = "{{ route('user.get-advertisements') }}";
        var save_ads = "{{ route('user.save-ads') }}";
        var update_ads = "{{ route('user.update-ads') }}";

        tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });

        $('#advertisements_tbl').DataTable({
            "order": [
                [0, "asc"]
            ],
            processing: true,
            serverSide: true,
            responsive: true,
            "ajax": {
                "url": get_ads_route,
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: token
                }
            },
            "columns": [{
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
                    $('#advertisements_tbl').DataTable().ajax.reload();
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
                }
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
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('.send-loading').show();
                },
                success: function(response) {
                    $('.send-loading').hide();
                    $('#edit_modal').modal('hide');
                    $('#advertisements_tbl').DataTable().ajax.reload();
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
                }
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
                            url: "{{ route('user.delete-ads') }}",
                            data: {
                                id: id,
                                _token: token
                            },
                            cache: false,
                            success: function(data) {
                                $('#advertisements_tbl').DataTable().ajax.reload();
                                swal("Advertisement has been deleted!", {
                                    icon: "success",
                                });
                            }
                        });
                    }
                });
        });
    </script>
@endsection
