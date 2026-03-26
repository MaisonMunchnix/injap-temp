@extends('layouts.default.admin.master')
@section('title', 'Pending Applications')
@section('page-title', 'User Applications')

@section('stylesheets')
    <style>
        .application-card {
            border-left: 4px solid #007bff;
        }
        .member-type-badge {
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 3px;
        }
        .member-type-regular {
            background-color: #e7f3ff;
            color: #004085;
        }
        .member-type-mega {
            background-color: #fff3cd;
            color: #856404;
        }
        .member-type-ultra {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
@endsection

@section('content')
    <div class="content-body">
        <div class="content">
            <div class="page-header">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin-dashboard') }}">Admin</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                    </ol>
                </nav>
            </div>

            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">@yield('title')</h6>
                    
                    @if($applications->count() > 0)
                        <div class="row">
                            @foreach($applications as $app)
                                <div class="col-md-6 mb-4">
                                    <div class="card application-card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <h5 class="card-title">{{ $app->first_name }}</h5>
                                                    <p class="mb-2">
                                                        <strong>Username:</strong> {{ $app->username }}
                                                    </p>
                                                    <p class="mb-2">
                                                        <strong>Email:</strong> <a href="mailto:{{ $app->email }}">{{ $app->email }}</a>
                                                    </p>
                                                    <p class="mb-2">
                                                        <strong>Phone:</strong> {{ $app->mobile_no }}
                                                    </p>
                                                    <p class="mb-2">
                                                        <strong>Country:</strong> {{ $app->country_name }}
                                                    </p>
                                                    <p class="mb-2">
                                                        <strong>Birthday:</strong> {{ $app->birthdate }}
                                                    </p>
                                                    <p class="mb-2">
                                                        <strong>Sponsor ID:</strong> <code>{{ $app->sponsor_id }}</code>
                                                    </p>
                                                    <p class="mb-2">
                                                        <strong>Member Type:</strong>
                                                        <span class="member-type-badge member-type-{{ strtolower($app->member_type) }}">
                                                            {{ $app->member_type }}
                                                        </span>
                                                    </p>
                                                    <p class="mb-2">
                                                        <strong>Proof of Payment:</strong>
                                                        @if($app->file_path)
                                                            <a href="{{ asset($app->file_path) }}" class="btn btn-sm btn-info" target="_blank">
                                                                <i class="feather icon-download"></i> View File
                                                            </a>
                                                        @else
                                                            <span class="text-danger">No attachment found</span>
                                                        @endif
                                                    </p>
                                                    <p class="text-muted small">
                                                        Submitted: {{ \Carbon\Carbon::parse($app->created_at)->format('M d, Y H:i A') }}
                                                    </p>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="btn-group-vertical w-100" role="group">
                                                        <a href="{{ route('applications.show-approve-form', $app->user_id) }}" class="btn btn-success">
                                                            <i class="feather icon-check"></i> Approve
                                                        </a>
                                                        <button type="button" class="btn btn-danger reject-btn" 
                                                            data-user-id="{{ $app->user_id }}" 
                                                            data-username="{{ $app->username }}"
                                                            data-toggle="modal" 
                                                            data-target="#rejectModal">
                                                            <i class="feather icon-x"></i> Reject
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $applications->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            <strong>No pending applications</strong> - All applications have been reviewed.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Reject Application</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="rejectForm">
                    <div class="modal-body">
                        <p><strong>Username:</strong> <span id="rejectUsername"></span></p>
                        <div class="form-group">
                            <label for="rejectionReason">Reason for Rejection</label>
                            <textarea class="form-control" id="rejectionReason" rows="4" required placeholder="Enter reason for rejection..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Reject Application</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Handle Reject Modal
            $('.reject-btn').on('click', function() {
                var userId = $(this).data('user-id');
                var username = $(this).data('username');
                $('#rejectForm').data('user-id', userId);
                $('#rejectUsername').text(username);
            });

            // Handle Reject Form Submission
            $('#rejectForm').on('submit', function(e) {
                e.preventDefault();
                var userId = $(this).data('user-id');
                var reason = $('#rejectionReason').val();

                $.ajax({
                    url: '/staff/applications/reject/' + userId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        reason: reason
                    },
                    success: function(response) {
                        if(response.success) {
                            swal({
                                title: "Success!",
                                text: response.message,
                                type: "success"
                            });
                            $('#rejectModal').modal('hide');
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        } else {
                            swal("Error", response.message, "error");
                        }
                    },
                    error: function(error) {
                        swal("Error", "Something went wrong. Please try again.", "error");
                    }
                });
            });
        });
    </script>
@endsection
