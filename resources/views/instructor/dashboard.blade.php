@extends('layouts.default.instructor.master')
@section('title', 'Dashboard')
@section('page-title', 'Instructor Dashboard')

@section('content')
    <div class="content-body">
        <div class="content">
            <div class="page-header">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-3">Total Courses</h6>
                                    <h2 class="font-weight-bold">{{ $stats['total_courses'] }}</h2>
                                </div>
                                <div class="avatar avatar-lg bg-primary-bright text-primary">
                                    <i data-feather="book"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-3">Total Students</h6>
                                    <h2 class="font-weight-bold">{{ $stats['total_students'] }}</h2>
                                </div>
                                <div class="avatar avatar-lg bg-success-bright text-success">
                                    <i data-feather="users"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-3">Published</h6>
                                    <h2 class="font-weight-bold">{{ $stats['published_courses'] }}</h2>
                                </div>
                                <div class="avatar avatar-lg bg-info-bright text-info">
                                    <i data-feather="check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-3">Pending Review</h6>
                                    <h2 class="font-weight-bold">{{ $stats['pending_courses'] }}</h2>
                                </div>
                                <div class="avatar avatar-lg bg-warning-bright text-warning">
                                    <i data-feather="clock"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Welcome back!</h5>
                            <p class="text-muted">You can manage your courses and track student enrollments using the sidebar on the left. If you need help, please contact the administrator.</p>
                            <a href="{{ route('instructor.courses.index') }}" class="btn btn-primary mt-2">Manage My Courses</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
