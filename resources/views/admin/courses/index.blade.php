@extends('layouts.default.admin.master')
@section('title', 'Course Review')
@section('page-title', 'Course Review & Management')

@section('content')
<div class="content-body">
    <div class="content">
        <div class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin-dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Course Review</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="admin-courses-table">
                                <thead>
                                    <tr>
                                        <th>Cover</th>
                                        <th>Instructor</th>
                                        <th>Course Title</th>
                                        <th>Suggested Price</th>
                                        <th>Final Price</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($courses as $course)
                                    <tr>
                                        <td>
                                            @if($course->cover_photo)
                                                <img src="{{ asset($course->cover_photo) }}" alt="Cover" width="50" class="img-thumbnail">
                                            @else
                                                <div class="text-muted"><small>No image</small></div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $course->instructor->username }}</strong><br>
                                            <small>{{ $course->instructor->email }}</small>
                                        </td>
                                        <td>
                                            {{ $course->title }}<br>
                                            <small class="text-muted">{{ Str::limit($course->description, 50) }}</small>
                                        </td>
                                        <td>₱{{ number_format($course->suggested_price, 2) }}</td>
                                        <td>
                                            <form action="{{ route('admin.courses.update-price', $course->id) }}" method="POST" class="form-inline">
                                                @csrf
                                                <div class="input-group input-group-sm">
                                                    <input type="number" step="0.01" name="price" value="{{ $course->price ?? $course->suggested_price }}" class="form-control" style="width: 100px;">
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-primary" {{ auth()->user()->can_override_price ? '' : 'disabled' }}>Set</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            @php
                                                $statusClass = [
                                                    'draft' => 'badge-secondary',
                                                    'pending' => 'badge-warning',
                                                    'published' => 'badge-success',
                                                    'rejected' => 'badge-danger'
                                                ][$course->status] ?? 'badge-light';
                                            @endphp
                                            <span class="badge {{ $statusClass }}">
                                                {{ ucfirst($course->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-light btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" {{ auth()->user()->can_approve_courses ? '' : 'disabled' }}>
                                                    Status
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <form action="{{ route('admin.courses.update-status', $course->id) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="published">
                                                        <button type="submit" class="dropdown-item">Publish</button>
                                                    </form>
                                                    <form action="{{ route('admin.courses.update-status', $course->id) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="pending">
                                                        <button type="submit" class="dropdown-item">Mark Pending</button>
                                                    </form>
                                                    <form action="{{ route('admin.courses.update-status', $course->id) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit" class="dropdown-item text-danger">Reject</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#admin-courses-table').DataTable();
    });
</script>
@endsection
