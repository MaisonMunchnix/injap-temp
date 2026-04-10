@extends('layouts.default.instructor.master')
@section('title', 'My Students')
@section('page-title', 'Student Roster')

@section('content')
    <div class="content-body">
        <div class="content">
            <div class="page-header">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('instructor.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Student Roster</li>
                    </ol>
                </nav>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="card-title">Enrolled Students</h4>
                                <div class="col-md-4">
                                    <select id="course-filter" class="form-control">
                                        <option value="">All Courses</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->title }}">{{ $course->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="enrollees-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Student</th>
                                            <th>Contact</th>
                                            <th>Course</th>
                                            <th>Minor Info</th>
                                            <th>Payment</th>
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
                                                    <a href="mailto:{{ $enrollment->email }}">{{ $enrollment->email }}</a><br>
                                                    <a href="tel:{{ $enrollment->phone }}">{{ $enrollment->phone }}</a>
                                                </td>
                                                <td>{{ $enrollment->course->title }}</td>
                                                <td>
                                                    @if($enrollment->age < 18)
                                                        <small>
                                                            <strong>G:</strong> {{ $enrollment->guardian_name }}<br>
                                                            <strong>C:</strong> {{ $enrollment->guardian_contact }}
                                                        </small>
                                                    @else
                                                        <span class="text-muted small">Adult</span>
                                                    @endif
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
            var table = $('#enrollees-table').DataTable({
                order: [[0, 'desc']],
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copy', className: 'btn btn-outline-success' },
                    { extend: 'csv', className: 'btn btn-outline-success' },
                    { extend: 'excel', className: 'btn btn-outline-success' },
                    { extend: 'pdf', className: 'btn btn-outline-success' },
                ]
            });

            // Course Filter Logic
            $('#course-filter').on('change', function () {
                var val = $(this).val();
                table.column(3).search(val ? '^' + val + '$' : '', true, false).draw();
            });
        });
    </script>
@endsection