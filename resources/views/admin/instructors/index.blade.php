@extends('layouts.default.admin.master')
@section('title', 'Instructors Management')
@section('page-title', 'Instructors Management')

@section('content')
<div class="content-body">
    <div class="content">
        <div class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin-dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Instructors Directory</li>
                </ol>
            </nav>
        </div>

        <div class="row app-block">
            <div class="col-md-3 app-sidebar">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('admin.instructors.create') }}" class="btn btn-primary btn-block">
                            New Instructor
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-9 app-content">
                <div class="app-content-overlay"></div>
                <div class="card card-body app-content-body">
                    <div class="app-lists">

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <ul class="list-group list-group-flush">
                            @if(count($instructors) > 0)
                                @foreach($instructors as $instructor)
                                <li class="list-group-item task-list">
                                    <div class="flex-grow-1 min-width-0">
                                        <div class="mb-1 d-flex align-items-center justify-content-between">
                                            <div class="app-list-title text-truncate">
                                                <strong>{{ $instructor->username }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $instructor->email }}</small>
                                                <br>
                                                @if(!empty($instructor->plain_password))
                                                    <small class="text-muted d-inline-flex align-items-center">
                                                        Password:
                                                        <span class="ml-1 js-password" data-password="{{ $instructor->plain_password }}" data-hidden="true">********</span>
                                                        <button type="button" class="btn btn-link btn-sm p-0 ml-2 js-toggle-password text-danger">Show</button>
                                                    </small>
                                                @else
                                                    <small class="text-muted">Password: N/A</small>
                                                @endif
                                            </div>
                                            <div class="pl-3 d-flex align-items-center flex-shrink-0">
                                                <div class="mr-3 text-muted d-none d-md-block">
                                                    Joined: {{ $instructor->created_at ? $instructor->created_at->format('M d, Y') : 'N/A' }}
                                                </div>
                                                <button type="button" class="btn btn-sm btn-info mr-1"
                                                    data-toggle="modal" data-target="#editInstructorModal"
                                                    data-id="{{ $instructor->id }}"
                                                    data-username="{{ $instructor->username }}"
                                                    data-email="{{ $instructor->email }}">
                                                    <i class="fa fa-edit"></i> Edit
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    data-toggle="modal" data-target="#deleteInstructorModal"
                                                    data-id="{{ $instructor->id }}"
                                                    data-username="{{ $instructor->username }}">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            @else
                                <li class="list-group-item task-list">
                                    <div class="flex-grow-1 min-width-0 text-center text-muted">
                                        No instructors found.
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Edit Instructor Modal --}}
<div class="modal fade" id="editInstructorModal" tabindex="-1" role="dialog" aria-labelledby="editInstructorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editInstructorForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editInstructorModalLabel">Edit Instructor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_username">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                    <hr>
                    <p class="text-muted small mb-2">Leave password fields blank to keep the current password.</p>
                    <div class="form-group">
                        <label for="edit_password">New Password</label>
                        <input type="password" class="form-control" id="edit_password" name="password" placeholder="Leave blank to keep current">
                    </div>
                    <div class="form-group">
                        <label for="edit_password_confirmation">Confirm New Password</label>
                        <input type="password" class="form-control" id="edit_password_confirmation" name="password_confirmation" placeholder="Leave blank to keep current">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Delete Instructor Modal --}}
<div class="modal fade" id="deleteInstructorModal" tabindex="-1" role="dialog" aria-labelledby="deleteInstructorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form id="deleteInstructorForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteInstructorModalLabel">Delete Instructor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong id="deleteInstructorName"></strong>?</p>
                    <p class="text-danger small mb-0">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Populate Edit Modal
    $('#editInstructorModal').on('show.bs.modal', function (event) {
        var button   = $(event.relatedTarget);
        var id       = button.data('id');
        var username = button.data('username');
        var email    = button.data('email');

        var modal = $(this);
        modal.find('#edit_username').val(username);
        modal.find('#edit_email').val(email);
        modal.find('#edit_password').val('');
        modal.find('#edit_password_confirmation').val('');
        modal.find('#editInstructorForm').attr('action', '/staff/instructors/' + id);
    });

    // Populate Delete Modal
    $('#deleteInstructorModal').on('show.bs.modal', function (event) {
        var button   = $(event.relatedTarget);
        var id       = button.data('id');
        var username = button.data('username');

        var modal = $(this);
        modal.find('#deleteInstructorName').text(username);
        modal.find('#deleteInstructorForm').attr('action', '/staff/instructors/' + id);
    });

    // Toggle plain password visibility in instructor list
    $(document).on('click', '.js-toggle-password', function () {
        var button = $(this);
        var passwordElement = button.siblings('.js-password');
        var isHidden = passwordElement.attr('data-hidden') !== 'false';

        if (isHidden) {
            passwordElement.text(passwordElement.attr('data-password'));
            passwordElement.attr('data-hidden', 'false');
            button.text('Hide');
        } else {
            passwordElement.text('********');
            passwordElement.attr('data-hidden', 'true');
            button.text('Show');
        }
    });
</script>
@endsection
