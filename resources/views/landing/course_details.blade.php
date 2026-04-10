@extends('layouts.landing.master')
@section('title', $course->title . ' - Course Details')
@section('page-title', $course->title)

@section('stylesheets')
    <style>
        .course-detail-header {
            padding: 100px 0 60px;
            background: #f8fafc;
        }

        .course-badge {
            display: inline-block;
            padding: 6px 16px;
            background: var(--accent-color);
            color: white;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }

        .course-main-title {
            font-size: 3rem;
            font-weight: 800;
            color: #1a202c;
            line-height: 1.2;
            margin-bottom: 24px;
        }

        .instructor-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 30px;
        }

        .instructor-avatar {
            width: 48px;
            height: 48px;
            background: #e2e8f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #718096;
            font-size: 1.25rem;
        }

        .course-featured-image {
            width: 100%;
            border-radius: 24px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
        }

        .info-card {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #f1f5f9;
            height: 100%;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 20px;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            background: #f1f5f9;
            color: var(--accent-color);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.1rem;
        }

        .info-label {
            display: block;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #94a3b8;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }

        .info-value {
            font-weight: 600;
            color: #334155;
            font-size: 1rem;
        }

        .enrollment-card {
            background: #ffffff;
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            border: 1px solid #e2e8f0;
            position: sticky;
            top: 100px;
        }

        .enroll-title {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .enroll-price {
            font-size: 2rem;
            font-weight: 800;
            color: var(--accent-color);
            margin-bottom: 24px;
        }

        .form-group label {
            font-weight: 600;
            color: #475569;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 16px;
            border: 1.5px solid #e2e8f0;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 4px rgba(var(--accent-rgb), 0.1);
        }

        .btn-enroll-submit {
            background: var(--accent-color);
            color: white;
            border: none;
            width: 100%;
            padding: 16px;
            border-radius: 50px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 20px;
            transition: all 0.3s;
        }

        .btn-enroll-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            opacity: 0.9;
        }

        .guardian-section {
            display: none;
            background: #f8fafc;
            padding: 20px;
            border-radius: 16px;
            margin-top: 20px;
            border: 1px solid #e2e8f0;
        }

        .description-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #475569;
        }

        @media (max-width: 991px) {
            .course-main-title {
                font-size: 2.25rem;
            }

            .enrollment-card {
                position: static;
                margin-top: 40px;
            }
        }
    </style>
@endsection

@section('content')
    <section class="course-detail-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="course-badge">{{ $course->category ?? 'Course' }}</span>
                    <h1 class="course-main-title">{{ $course->title }}</h1>
                    <div class="instructor-meta">
                        <div class="instructor-avatar">
                            <i class="fa fa-user"></i>
                        </div>
                        <div>
                            <span class="info-label">Instructor</span>
                            <span
                                class="info-value">{{ $course->instructor ? $course->instructor->username : 'Administrator' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <img src="{{ $course->cover_photo ? asset($course->cover_photo) : asset('new_landing/images/video-placeholder.jpg') }}"
                        alt="{{ $course->title }}" class="course-featured-image">

                    <div class="row mb-5">
                        <div class="col-md-4 mb-4">
                            <div class="info-card">
                                <div class="info-item">
                                    <div class="info-icon"><i class="fa fa-layer-group"></i></div>
                                    <div>
                                        <span class="info-label">Level</span>
                                        <span class="info-value">{{ ucfirst($course->level) }}</span>
                                    </div>
                                </div>
                                <div class="info-item mb-0">
                                    <div class="info-icon"><i class="fa fa-users"></i></div>
                                    <div>
                                        <span class="info-label">Capacity</span>
                                        <span class="info-value">{{ $course->max_slots ?? 'No Limit' }} Slots</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="info-card">
                                <div class="info-item">
                                    <div class="info-icon"><i class="fa fa-birthday-cake"></i></div>
                                    <div>
                                        <span class="info-label">Age Group</span>
                                        <span class="info-value">
                                            @if($course->min_age || $course->max_age)
                                                {{ $course->min_age ?? 'Any' }} - {{ $course->max_age ?? 'Above' }} yrs
                                            @else
                                                All Ages
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="info-item mb-0">
                                    <div class="info-icon"><i class="fa fa-clock"></i></div>
                                    <div>
                                        <span class="info-label">Duration</span>
                                        <span class="info-value">{{ $course->session_duration_mins }} Mins</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="info-card">
                                <div class="info-item">
                                    <div class="info-icon"><i class="fa fa-calendar-alt"></i></div>
                                    <div>
                                        <span class="info-label">Schedule</span>
                                        <span class="info-value">{{ ucfirst($course->recurrence) }}</span>
                                    </div>
                                </div>
                                <div class="info-item mb-0">
                                    <div class="info-icon"><i class="fa fa-video"></i></div>
                                    <div>
                                        <span class="info-label">Medium</span>
                                        <span class="info-value">{{ $course->meeting_link ? 'Online Class' : 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="description-section">
                        <h3 class="font-weight-bold mb-4">About this Course</h3>
                        <div class="description-content">
                            {!! $course->description !!}
                        </div>
                    </div>

                    @if($course->location)
                        <div class="mt-5 p-4 rounded-lg bg-light border">
                            <h5 class="font-weight-bold mb-3"><i class="fa fa-map-marker-alt text-primary mr-2"></i> Location
                            </h5>
                            <p class="mb-0 text-muted">{{ $course->location }}</p>
                        </div>
                    @endif
                </div>

                <div class="col-lg-4">
                    <div class="enrollment-card">
                        <div class="enroll-title">Join this class</div><br>
                        <div class="enroll-price">₱{{ number_format($course->price ?? $course->suggested_price, 2) }}</div>

                        @if(session('success'))
                            <div class="alert alert-success border-0 shadow-sm rounded-lg mb-4">
                                <i class="fa fa-check-circle mr-2"></i> {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger border-0 shadow-sm rounded-lg mb-4">
                                <ul class="mb-0 small pl-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('landing.education.enroll', $course->id) }}" method="POST">
                            @csrf
                            <div class="form-group py-2">
                                <label for="full_name">Student Full Name</label>
                                <input type="text" name="full_name" id="full_name" class="form-control"
                                    placeholder="Enter name" value="{{ old('full_name') }}" required>
                            </div>

                            <div class="form-group py-2">
                                <label for="email">Email Address</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter email"
                                    value="{{ old('email') }}" required>
                            </div>

                            <div class="form-group py-2">
                                <label for="phone">Phone Number</label>
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter phone"
                                    value="{{ old('phone') }}" required>
                            </div>

                            <div class="form-group py-2">
                                <label for="age">Student Age</label>
                                <input type="number" name="age" id="age" class="form-control" placeholder="Enter age"
                                    value="{{ old('age') }}" required min="1">
                                <small class="text-muted">Guardian info required if age < 18</small>
                            </div>

                            <div id="guardian-section" class="guardian-section">
                                <h6 class="font-weight-bold small text-uppercase mb-3">Guardian Information</h6>
                                <div class="form-group py-2">
                                    <label for="guardian_name">Guardian Name</label>
                                    <input type="text" name="guardian_name" id="guardian_name" class="form-control"
                                        placeholder="Parent/Guardian name" value="{{ old('guardian_name') }}">
                                </div>
                                <div class="form-group py-2 mb-0">
                                    <label for="guardian_contact">Guardian Contact #</label>
                                    <input type="text" name="guardian_contact" id="guardian_contact" class="form-control"
                                        placeholder="Contact number" value="{{ old('guardian_contact') }}">
                                </div>
                            </div>

                            <button type="submit" class="btn-enroll-submit mt-4">
                                Enroll Now <i class="fa fa-arrow-right ml-2"></i>
                            </button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            function toggleGuardianInputs() {
                const age = parseInt($('#age').val());
                if (age < 18) {
                    $('#guardian-section').slideDown();
                    $('#guardian_name, #guardian_contact').attr('required', true);
                } else {
                    $('#guardian-section').slideUp();
                    $('#guardian_name, #guardian_contact').removeAttr('required');
                }
            }

            $('#age').on('input change', toggleGuardianInputs);

            // Trigger on page load if old value exists
            if ($('#age').val()) {
                toggleGuardianInputs();
            }
        });
    </script>
@endsection