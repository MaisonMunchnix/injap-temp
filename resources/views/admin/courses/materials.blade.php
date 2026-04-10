@extends('layouts.default.admin.master')

@section('content')
@section('content')
<div class="content-body">
    <div class="content">
        <!-- begin::page-header -->
        <div class="page-header">
            <div class="container-fluid d-sm-flex justify-content-between">
                <h4>Learning Materials Review</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">Instructor Management</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Materials</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- end::page-header -->

        <!-- begin::page content -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-4">
                            <h6 class="card-title mb-0">Submitted Learning Materials</h6>
                        </div>

                        @if(session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered text-center datatable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Instructor</th>
                                        <th>Course</th>
                                        <th>Material Title</th>
                                        <th>File Link</th>
                                        <th>Status</th>
                                        <th>Admin Note</th>
                                        <th>Date Submitted</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($materials as $material)
                                        <tr>
                                            <td>{{ $material->id }}</td>
                                            <td>
                                                <strong>{{ $material->instructor->username ?? 'N/A' }}</strong>
                                                @if($material->instructor)
                                                <br><small class="text-muted">{{ $material->instructor->email }}</small>
                                                @endif
                                            </td>
                                            <td>{{ $material->course->title ?? 'N/A' }}</td>
                                            <td>{{ $material->title }}</td>
                                            <td>
                                                <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                    <i class="ti-file"></i> View PDF
                                                </a>
                                            </td>
                                            <td>
                                                @if($material->status == 'pending')
                                                    <span class="badge badge-warning">Pending Approval</span>
                                                @elseif($material->status == 'approved')
                                                    <span class="badge badge-success">Approved</span>
                                                @elseif($material->status == 'rejected')
                                                    <span class="badge badge-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $material->admin_note ? Str::limit($material->admin_note, 30) : '-' }}
                                            </td>
                                            <td>{{ $material->created_at->format('M d, Y h:i A') }}</td>
                                            <td>
                                                <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#reviewModal{{ $material->id }}">
                                                    Review
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Review Modal -->
                                        <div class="modal fade text-left" id="reviewModal{{ $material->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Review Material: {{ $material->title }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('admin.courses.material-status', $material->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="form-group row">
                                                                <label class="col-sm-4 col-form-label">Current Status</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control" value="{{ ucfirst($material->status) }}" disabled>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="status" class="col-sm-4 col-form-label">Update Status</label>
                                                                <div class="col-sm-8">
                                                                    <select name="status" id="status" class="form-control" required>
                                                                        <option value="pending" {{ $material->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                                        <option value="approved" {{ $material->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                                                        <option value="rejected" {{ $material->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="admin_note" class="col-sm-4 col-form-label">Admin Reason/Note</label>
                                                                <div class="col-sm-8">
                                                                    <textarea class="form-control" name="admin_note" id="admin_note" rows="3" placeholder="Optional for approval, required if rejected (though not enforced by code).">{{ $material->admin_note }}</textarea>
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- end::page content -->
    </div>
</div>
@endsection
