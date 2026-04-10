@extends('layouts.default.instructor.master')
@section('title', 'My Courses')
@section('page-title', 'My Courses')

@section('content')
    <div class="content-body">
        <div class="content">
            <div class="page-header">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('instructor.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">My Courses</li>
                    </ol>
                </nav>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="card-title">All Courses</h4>
                                <a href="{{ route('instructor.courses.create') }}" class="btn btn-primary">
                                    <i class="mr-2" data-feather="plus"></i> Create New Course
                                </a>
                            </div>

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table id="courses-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Cover</th>
                                            <th>Title</th>
                                            <th>Price</th>
                                            <th>Admin Price</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($courses as $course)
                                            <tr>
                                                <td>
                                                    @if($course->cover_photo)
                                                        <img src="{{ asset($course->cover_photo) }}" alt="Cover" width="50"
                                                            class="img-thumbnail">
                                                    @else
                                                        <div class="text-muted"><small>No image</small></div>
                                                    @endif
                                                </td>
                                                <td>{{ $course->title }}</td>
                                                <td>₱{{ number_format($course->suggested_price, 2) }}</td>
                                                <td>
                                                    @if($course->price)
                                                        ₱{{ number_format($course->price, 2) }}
                                                    @else
                                                        <span class="text-muted">Not set</span>
                                                    @endif
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
                                                <td>{{ $course->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a href="#" class="btn btn-outline-light btn-sm" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            <i data-feather="more-horizontal"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a href="{{ route('instructor.courses.edit', $course->id) }}"
                                                                class="dropdown-item">Edit</a>
                                                            <form
                                                                action="{{ route('instructor.courses.destroy', $course->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Are you sure you want to delete this course?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="dropdown-item text-danger">Delete</button>
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
        $(document).ready(function () {
            $('#courses-table').DataTable();
        });
    </script>
@endsection