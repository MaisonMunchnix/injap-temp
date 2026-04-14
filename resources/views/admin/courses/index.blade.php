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
                                <table class="table table-striped table-bordered dt-responsive nowrap" id="admin-courses-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Cover</th>
                                            <th>Instructor</th>
                                            <th>Course Title</th>
                                            <th>Instructor Price</th>
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
                                                        <img src="{{ asset($course->cover_photo) }}" alt="Cover" width="50"
                                                            class="img-thumbnail rounded">
                                                    @else
                                                        <div class="text-muted"><small>No image</small></div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <strong>{{ $course->instructor->username }}</strong><br>
                                                    <small class="text-muted">{{ $course->instructor->email }}</small>
                                                </td>
                                                <td>
                                                    <strong>{{ $course->title }}</strong><br>
                                                    <small class="text-muted">{{ Str::limit(strip_tags($course->description), 50) }}</small>
                                                </td>
                                                <td data-order="{{ $course->suggested_price }}">
                                                    {{ ($course->currency ?? 'PHP') == 'JPY' ? '¥' : '₱' }}{{ number_format($course->suggested_price, 2) }}
                                                </td>
                                                <td data-order="{{ $course->price ?? $course->suggested_price }}">
                                                    <form action="{{ route('admin.courses.update-price', $course->id) }}"
                                                        method="POST" class="form-inline">
                                                        @csrf
                                                        <div class="input-group input-group-sm">
                                                            <div class="input-group-prepend">
                                                                <select name="currency" class="input-group-text py-0" style="padding: 0 5px; font-weight: bold; background: #e9ecef; cursor: pointer;">
                                                                    <option value="PHP" {{ ($course->currency ?? 'PHP') == 'PHP' ? 'selected' : '' }}>₱</option>
                                                                    <option value="JPY" {{ ($course->currency ?? 'PHP') == 'JPY' ? 'selected' : '' }}>¥</option>
                                                                </select>
                                                            </div>
                                                            <input type="number" step="0.01" name="price"
                                                                value="{{ $course->price ?? $course->suggested_price }}"
                                                                class="form-control" style="min-width: 80px;">
                                                            <div class="input-group-append">
                                                                <button type="submit" class="btn btn-primary btn-sm" {{ auth()->user()->can_override_price ? '' : 'disabled' }}>Set</button>
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
                                                    <span class="badge {{ $statusClass }} p-2">
                                                        {{ ucfirst($course->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-light btn-sm dropdown-toggle"
                                                            type="button" data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false" {{ auth()->user()->can_approve_courses ? '' : 'disabled' }}>
                                                            Manage
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right shadow border-0">
                                                            <button type="button" class="dropdown-item btn-view-course-details" data-id="{{ $course->id }}">
                                                                <i class="fa fa-eye text-info mr-2"></i>View Details
                                                            </button>
                                                            <div class="dropdown-divider"></div>
                                                            <form
                                                                action="{{ route('admin.courses.update-status', $course->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="status" value="published">
                                                                <button type="submit" class="dropdown-item">
                                                                    <i class="fa fa-check-circle text-success mr-2"></i>Publish
                                                                </button>
                                                            </form>
                                                            <form
                                                                action="{{ route('admin.courses.update-status', $course->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="status" value="pending">
                                                                <button type="submit" class="dropdown-item">
                                                                    <i class="fa fa-clock-o text-warning mr-2"></i>Mark Pending
                                                                </button>
                                                            </form>
                                                            <div class="dropdown-divider"></div>
                                                            <form
                                                                action="{{ route('admin.courses.update-status', $course->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="status" value="rejected">
                                                                <button type="submit"
                                                                    class="dropdown-item text-danger">
                                                                    <i class="fa fa-times-circle mr-2"></i>Reject
                                                                </button>
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

    <!-- Course Details Modal -->
    <div class="modal fade" id="viewCourseModal" tabindex="-1" role="dialog" aria-labelledby="viewCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="viewCourseModalLabel">Course Full Details</h5>
                    <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="course-details-loading" class="text-center p-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Fetching course details...</p>
                    </div>
                    <div id="course-details-content" style="display: none;">
                        <div class="row mb-4">
                            <div class="col-md-5">
                                <img id="detail-cover-photo" src="" alt="Course Cover" class="img-fluid rounded shadow-sm">
                            </div>
                            <div class="col-md-7">
                                <h3 id="detail-title" class="font-weight-bold mb-1"></h3>
                                <p id="detail-category-level" class="text-muted mb-3"></p>
                                <div class="badge badge-pill badge-primary mb-2 p-2 px-3" id="detail-status"></div>
                                <div class="mt-3">
                                    <h5 class="text-primary font-weight-bold mb-0">Pricing</h5>
                                    <div class="row">
                                        <div class="col-6">
                                            <small class="text-muted d-block">Instructor Suggested</small>
                                            <span class="font-weight-bold" id="detail-suggested-price"></span>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted d-block">Admin Final Price</small>
                                            <span class="font-weight-bold text-success" id="detail-final-price"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6 bordered-right">
                                <h6 class="font-weight-bold text-uppercase small text-muted mb-3">Audience & Capacity</h6>
                                <p class="mb-2"><strong>Target Ages:</strong> <span id="detail-age-range"></span></p>
                                <p class="mb-2"><strong>Min/Max Slots:</strong> <span id="detail-slots"></span></p>
                                <p class="mb-0"><strong>Instructor:</strong> <span id="detail-instructor"></span></p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="font-weight-bold text-uppercase small text-muted mb-3">Schedule & Sessions</h6>
                                <p class="mb-2"><strong>Timeline:</strong> <span id="detail-timeline"></span></p>
                                <p class="mb-2"><strong>Total Sessions:</strong> <span id="detail-sessions"></span></p>
                                <p class="mb-0"><strong>Recurrence:</strong> <span id="detail-recurrence"></span></p>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-12">
                                <h6 class="font-weight-bold text-uppercase small text-muted mb-2">Detailed Description</h6>
                                <div id="detail-description" class="p-3 bg-light rounded" style="max-height: 200px; overflow-y: auto;"></div>
                            </div>
                        </div>

                        <div class="row mt-4" id="delivery-info-section">
                            <div class="col-12">
                                <h6 class="font-weight-bold text-uppercase small text-muted mb-2">Location</h6>
                                <div class="p-3 border rounded border-primary bg-light">
                                    <div id="detail-meeting-link-wrapper" class="mb-2" style="display: none;">
                                        <strong>Meeting Link:</strong> <a href="" id="detail-meeting-link" target="_blank" class="text-break"></a>
                                    </div>
                                    <div id="detail-location-wrapper" style="display: none;">
                                        <strong>Location:</strong> <span id="detail-location"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row mt-4">
                            <div class="col-12">
                                <h6 class="font-weight-bold text-uppercase small text-muted mb-2">Learning Materials</h6>
                                <div id="detail-materials">
                                    <!-- Materials loaded via AJAX -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#admin-courses-table').DataTable({
                "order": [[2, "asc"]],
                "pageLength": 10,
                "language": {
                    "search": "Search Courses:",
                    "lengthMenu": "Show _MENU_ entries",
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        className: 'btn btn-sm btn-outline-success'
                    },
                    {
                        extend: 'csv',
                        className: 'btn btn-sm btn-outline-success'
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-sm btn-outline-success'
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-sm btn-outline-success'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-sm btn-outline-success'
                    }
                ]
            });

            // View Course Details AJAX
            $('.btn-view-course-details').on('click', function() {
                const courseId = $(this).data('id');
                const modal = $('#viewCourseModal');
                
                // Show modal & loading state
                modal.modal('show');
                $('#course-details-loading').show();
                $('#course-details-content').hide();

                $.ajax({
                    url: `{{ url('staff/courses') }}/${courseId}`,
                    type: 'GET',
                    success: function(course) {
                        $('#course-details-loading').hide();
                        $('#course-details-content').fadeIn();

                        // Basic Info
                        $('#detail-title').text(course.title);
                        $('#detail-category-level').text(`${course.category || 'Uncategorized'} | ${course.level.toUpperCase()}`);
                        $('#detail-status').text(course.status.toUpperCase());
                        const currencySymbol = (course.currency === 'JPY') ? '¥' : '₱';
                        $('#detail-suggested-price').text(`${currencySymbol}${parseFloat(course.suggested_price).toLocaleString(undefined, {minimumFractionDigits: 2})}`);
                        $('#detail-final-price').text(course.price ? `${currencySymbol}${parseFloat(course.price).toLocaleString(undefined, {minimumFractionDigits: 2})}` : 'Not Set');
                        
                        // Cover Photo
                        let coverUrl = `{{ asset('new_landing/images/video-placeholder.jpg') }}`;
                        if (course.cover_photo) {
                            // Trim leading slash from stored path to avoid double slashes or absolute path issues
                            const cleanPath = course.cover_photo.startsWith('/') ? course.cover_photo.substring(1) : course.cover_photo;
                            coverUrl = `{{ asset('') }}${cleanPath}`;
                        }
                        $('#detail-cover-photo').attr('src', coverUrl);

                        // Description
                        $('#detail-description').html(course.description || '<span class="text-muted">No description provided.</span>');

                        // Audience & Capacity
                        const ageRange = (course.min_age || course.max_age) 
                            ? `${course.min_age || 'Any'} - ${course.max_age || 'Above'}` 
                            : 'All Ages';
                        $('#detail-age-range').text(ageRange);
                        $('#detail-slots').text(`${course.min_slots || 1} Min / ${course.max_slots || 'No Limit'} Max`);
                        $('#detail-instructor').text(`${course.instructor.username} (${course.instructor.email})`);

                        // Schedule
                        const start = course.schedule_start ? new Date(course.schedule_start).toLocaleDateString() : 'N/A';
                        const end = course.schedule_end ? new Date(course.schedule_end).toLocaleDateString() : 'N/A';
                        $('#detail-timeline').text(`${start} to ${end}`);
                        $('#detail-sessions').text(`${course.session_count || 1} Sessions (${course.session_duration_mins || 60} mins each)`);
                        $('#detail-recurrence').text(course.recurrence.toUpperCase());

                        // Delivery
                        if (course.meeting_link) {
                            $('#detail-meeting-link-wrapper').show();
                            $('#detail-meeting-link').attr('href', course.meeting_link).text(course.meeting_link);
                        } else {
                            $('#detail-meeting-link-wrapper').hide();
                        }

                        if (course.location) {
                            $('#detail-location-wrapper').show();
                            $('#detail-location').text(course.location);
                        } else {
                            $('#detail-location-wrapper').hide();
                        }

                        // Learning Materials
                        let materialsHtml = '';
                        if (course.materials && course.materials.length > 0) {
                            materialsHtml = '<ul class="list-group list-group-flush border mt-2 rounded">';
                            course.materials.forEach(function(mat) {
                                let statusClasses = {
                                    'approved': 'badge-success',
                                    'rejected': 'badge-danger',
                                    'pending': 'badge-warning'
                                };
                                let badgeClass = statusClasses[mat.status] || 'badge-secondary';
                                
                                materialsHtml += `<li class="list-group-item bg-light p-2 d-flex justify-content-between align-items-center">
                                    <div class="text-truncate mr-3">
                                        <i class="ti-file text-primary mr-2"></i>
                                        <a href="{{ asset('storage') }}/${mat.file_path}" target="_blank" class="font-weight-bold text-dark">${mat.title}</a>
                                    </div>
                                    <span class="badge ${badgeClass} badge-pill p-2">${mat.status.toUpperCase()}</span>
                                </li>`;
                            });
                            materialsHtml += '</ul>';
                        } else {
                            materialsHtml = '<div class="alert alert-secondary mt-2 px-3 py-2 border-0"><small><i class="ti-info-alt mr-2"></i>No learning materials uploaded for this course yet.</small></div>';
                        }
                        $('#detail-materials').html(materialsHtml);
                    },
                    error: function() {
                        alert('Failed to fetch course details. Please try again.');
                        modal.modal('hide');
                    }
                });
            });
        });
    </script>
@endsection