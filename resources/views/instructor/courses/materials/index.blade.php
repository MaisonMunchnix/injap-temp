@extends('layouts.default.instructor.master')
@section('title', 'Learning Materials Management')

@section('content')
    <!-- begin::page content -->
    <div class="content-body">
        <div class="content">
            <!-- begin::page-header -->
            <div class="page-header">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">Instructor</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Materials</li>
                    </ol>
                </nav>
            </div>
            <!-- end::page-header -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h6 class="card-title mb-0">Select Course to Manage Materials</h6>
                                <div class="d-flex align-items-center">
                                    <label class="mb-0 mr-2 text-nowrap"><strong>Filter by Category:</strong></label>
                                    <select id="categoryFilter" class="form-control form-control-sm"
                                        style="min-width: 180px;">
                                        <option value="">All Categories</option>
                                        @foreach($courses->pluck('category')->filter()->unique()->sort() as $cat)
                                            <option value="{{ $cat }}">{{ $cat }}</option>
                                        @endforeach
                                    </select>
                                    <button id="resetCategoryFilter"
                                        class="btn btn-sm btn-outline-secondary ml-2">Reset</button>
                                </div>
                            </div>

                            @if(session()->has('error'))
                                <div class="alert alert-danger mt-2">
                                    {{ session()->get('error') }}
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table id="materials-courses-table" class="table table-striped table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>Course ID</th>
                                            <th>Course Title</th>
                                            <th>Category</th>
                                            <th>Uploaded Materials</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($courses as $course)
                                            <tr>
                                                <td>{{ $course->id }}</td>
                                                <td>{{ $course->title }}</td>
                                                <td>{{ $course->category ?? 'General' }}</td>
                                                <td>
                                                    <span class="badge badge-primary">{{ $course->materials_count }}
                                                        Files</span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('instructor.materials.show', $course->id) }}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="ti-pencil-alt mr-1"></i> Manage Learning Materials
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">You have not created any courses yet.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end::page content -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            var table = $('#materials-courses-table').DataTable({
                order: [[1, 'asc']],
                columnDefs: [
                    { orderable: false, targets: 4 } // Action column not sortable
                ]
            });

            // Filter by Category (column index 2)
            $('#categoryFilter').on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                table.column(2).search(val ? '^' + val + '$' : '', true, false).draw();
            });

            // Reset filter
            $('#resetCategoryFilter').on('click', function () {
                $('#categoryFilter').val('');
                table.column(2).search('').draw();
            });
        });
    </script>
@endsection