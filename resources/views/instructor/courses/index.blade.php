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
                                                <td>{{ ($course->suggested_currency ?? 'PHP') == 'JPY' ? '¥' : '₱' }}{{ number_format($course->suggested_price, 2) }}</td>
                                                <td>
                                                    @if($course->price)
                                                        {{ ($course->currency ?? 'PHP') == 'JPY' ? '¥' : '₱' }}{{ number_format($course->price, 2) }}
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
                                                            <a href="#" class="dropdown-item text-danger"
                                                                data-toggle="modal"
                                                                data-target="#deleteCourseModal"
                                                                data-id="{{ $course->id }}"
                                                                data-title="{{ $course->title }}">
                                                                Delete
                                                            </a>
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

    {{-- Delete Course Confirmation Modal --}}
    <div class="modal fade" id="deleteCourseModal" tabindex="-1" role="dialog" aria-labelledby="deleteCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form id="deleteCourseForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteCourseModalLabel">Delete Course</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete:</p>
                        <p><strong id="deleteCourseTitle"></strong></p>
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
        $(document).ready(function () {
            $('#courses-table').DataTable();
        });

        // Populate Delete Course Modal
        $('#deleteCourseModal').on('show.bs.modal', function (event) {
            var link  = $(event.relatedTarget);
            var id    = link.data('id');
            var title = link.data('title');

            var modal = $(this);
            modal.find('#deleteCourseTitle').text(title);
            modal.find('#deleteCourseForm').attr('action', '/instructor/courses/' + id);
        });
    </script>
@endsection