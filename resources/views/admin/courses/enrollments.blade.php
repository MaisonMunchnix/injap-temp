@extends('layouts.default.admin.master')
@section('title', 'Course Enrollments')
@section('page-title', 'Global Course Enrollments')

@section('content')
    <div class="content-body">
        <div class="content">
            <div class="page-header">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin-dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Course Enrollments</li>
                    </ol>
                </nav>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="card-title">Course Enrollments</h4>
                                <div class="d-flex align-items-center">
                                    <select id="courseFilter" class="form-control form-control-sm" style="min-width: 220px;">
                                        <option value="">All Courses</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->title }}">{{ $course->title }}</option>
                                        @endforeach
                                    </select>
                                    <button id="resetCourseFilter" class="btn btn-sm btn-outline-secondary">Reset</button>
                                </div>
                            </div>

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table id="enrollments-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Student</th>
                                            <th>Contact</th>
                                            <th>Course</th>
                                            <th>Instructor</th>
                                            <th>Payment Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($enrollments as $enrollment)
                                            <tr>
                                                <td>{{ $enrollment->enrolled_at ? $enrollment->enrolled_at->format('M d, Y') : $enrollment->created_at->format('M d, Y') }}
                                                </td>
                                                <td>
                                                    <strong>{{ $enrollment->full_name }}</strong><br>
                                                    <small class="text-muted">Age: {{ $enrollment->age }}</small>
                                                </td>
                                                <td>
                                                    {{ $enrollment->email }}<br>
                                                    {{ $enrollment->phone }}
                                                </td>
                                                <td>{{ $enrollment->course->title }}</td>
                                                <td>{{ $enrollment->course->instructor ? $enrollment->course->instructor->username : 'Admin' }}
                                                </td>
                                                <td>
                                                    @php
                                                        $badgeClass = [
                                                            'pending' => 'badge-warning',
                                                            'paid' => 'badge-success',
                                                            'refunded' => 'badge-danger',
                                                        ][$enrollment->payment_status];
                                                    @endphp
                                                    <span class="badge {{ $badgeClass }}">
                                                        {{ strtoupper($enrollment->payment_status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#statusModal{{ $enrollment->id }}">
                                                        Update Status
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#deleteModal{{ $enrollment->id }}">
                                                        Delete
                                                    </button>

                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="deleteModal{{ $enrollment->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <form action="{{ route('admin.courses.enrollment-destroy', $enrollment->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Delete Enrollment</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Are you sure you want to delete the enrollment for <strong>{{ $enrollment->full_name }}</strong> in <strong>{{ $enrollment->course->title }}</strong>?</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="statusModal{{ $enrollment->id }}"
                                                        tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <form
                                                                    action="{{ route('admin.courses.enrollment-status', $enrollment->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Update Payment Status
                                                                        </h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Student: <strong>{{ $enrollment->full_name }}</strong></p>
                                                                        <p>Course: <strong>{{ $enrollment->course->title }}</strong></p>
                                                                        <div class="form-group">
                                                                            <label>Select Status</label>
                                                                            <select name="status" class="form-control">
                                                                                <option value="pending"
                                                                                    {{ $enrollment->payment_status == 'pending' ? 'selected' : '' }}>
                                                                                    Pending</option>
                                                                                <option value="paid"
                                                                                    {{ $enrollment->payment_status == 'paid' ? 'selected' : '' }}>
                                                                                    Paid</option>
                                                                                <option value="refunded"
                                                                                    {{ $enrollment->payment_status == 'refunded' ? 'selected' : '' }}>
                                                                                    Refunded</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Payment Method</label>
                                                                            <select name="payment_method" class="form-control">
                                                                                <option value="Cash" {{ $enrollment->payment_method == 'Cash' ? 'selected' : '' }}>Cash</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Save Changes</button>
                                                                    </div>
                                                                </form>
                                                            </div>
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
            var table = $('#enrollments-table').DataTable({
                order: [
                    [0, 'desc']
                ],
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copy',  className: 'btn btn-outline-success' },
                    { extend: 'csv',   className: 'btn btn-outline-success' },
                    { extend: 'excel', className: 'btn btn-outline-success' },
                    { extend: 'pdf',   className: 'btn btn-outline-success' },
                ]
            });

            // Filter by Course (column index 3)
            $('#courseFilter').on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                table.column(3).search(val ? '^' + val + '$' : '', true, false).draw();
            });

            // Reset filter
            $('#resetCourseFilter').on('click', function () {
                $('#courseFilter').val('');
                table.column(3).search('').draw();
            });
        });
    </script>
@endsection
