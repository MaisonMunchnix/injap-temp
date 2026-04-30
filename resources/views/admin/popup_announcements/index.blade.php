@extends('layouts.default.admin.master')
@section('title', 'Popup Announcements')

@section('stylesheets')
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <style>
        .gallery-img-preview {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
            display: none;
        }
        .modal-body {
            max-height: 60vh;
            overflow-y: auto;
        }
    </style>
@endsection

@section('content')
    <div class="content-body">
        <div class="content">
            <div class="page-header">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Popup Announcements</li>
                    </ol>
                </nav>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h3>Popup Announcements</h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">
                                <i class="fa fa-plus"></i> Add New Popup
                            </button>
                        </div>
                    </div>
                    <table id="popup_table" width="100%" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="add_modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <form id="add_form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Popup Announcement</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Image (Recommended: 800x600)</label>
                            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this, '#add_preview')">
                            <img id="add_preview" class="gallery-img-preview mt-2">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control rich-text"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Link (Optional)</label>
                            <input type="url" name="link" class="form-control" placeholder="https://example.com">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active_add" name="is_active" checked>
                                <label class="custom-control-label" for="is_active_add">Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="edit_modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <form id="edit_form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="edit_id">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Popup Announcement</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" id="edit_title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this, '#edit_preview')">
                            <img id="edit_preview" class="gallery-img-preview mt-2">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" id="edit_description" class="form-control rich-text"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Link (Optional)</label>
                            <input type="url" name="link" id="edit_link" class="form-control">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active_edit" name="is_active">
                                <label class="custom-control-label" for="is_active_edit">Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#popup_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.popup-announcements.data') }}",
                columns: [
                    { data: 'image', name: 'image' },
                    { data: 'title', name: 'title' },
                    { data: 'description', name: 'description' },
                    { data: 'is_active', name: 'is_active' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            $('.rich-text').summernote({
                height: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']]
                ]
            });

            $('#add_form').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                
                $.ajax({
                    url: "{{ route('admin.popup-announcements.store') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#add_modal').modal('hide');
                        $('#add_form')[0].reset();
                        $('.rich-text').summernote('code', '');
                        $('#add_preview').hide();
                        table.ajax.reload();
                        swal("Success", "Popup announcement added successfully", "success");
                    },
                    error: function(xhr) {
                        swal("Error", "Something went wrong. Please check your inputs.", "error");
                    }
                });
            });

            $(document).on('click', '.btn-edit', function() {
                var id = $(this).data('id');
                $.get("popup-announcement-item/" + id, function(data) {
                    $('#edit_id').val(data.id);
                    $('#edit_title').val(data.title);
                    $('#edit_link').val(data.link);
                    $('#is_active_edit').prop('checked', data.is_active == 1);
                    if (data.image) {
                        $('#edit_preview').attr('src', "{{ asset('/') }}" + data.image).show();
                    } else {
                        $('#edit_preview').hide();
                    }
                    $('#edit_description').summernote('code', data.description || '');
                    $('#edit_modal').modal('show');
                });
            });

            $('#edit_form').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                
                $.ajax({
                    url: "{{ route('admin.popup-announcements.update') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#edit_modal').modal('hide');
                        table.ajax.reload();
                        swal("Success", "Popup announcement updated successfully", "success");
                    },
                    error: function(xhr) {
                        swal("Error", "Something went wrong. Please check your inputs.", "error");
                    }
                });
            });

            $(document).on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this item!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.post("{{ route('admin.popup-announcements.delete') }}", {id: id, _token: "{{ csrf_token() }}"}, function(data) {
                            table.ajax.reload();
                            swal("Deleted", "Popup announcement has been deleted", "success");
                        });
                    }
                });
            });
        });

        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $(previewId).attr('src', e.target.result).show();
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
