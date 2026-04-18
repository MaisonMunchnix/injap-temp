@extends('layouts.student')

@section('content')
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="font-weight-bold mb-1">Welcome back, {{ Auth::user()->username }}! 👋</h2>
            <p class="text-muted">You are currently enrolled in {{ $enrollments->count() }} active
                course{{ $enrollments->count() != 1 ? 's' : '' }}.</p>
        </div>
    </div>

    <div class="row">
        @forelse($enrollments as $enrollment)
            <div class="col-md-4 mb-4">
                <div class="card student-card h-100">
                    @if ($enrollment->course->cover_photo)
                        <img src="{{ asset($enrollment->course->cover_photo) }}" class="card-img-top"
                            alt="{{ $enrollment->course->title }}" style="height: 180px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                            <i class="fas fa-book fa-3x text-muted"></i>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge badge-pill badge-primary-soft text-primary bg-primary-10"
                                style="background: #eef2ff;">{{ $enrollment->course->category ?? 'Course' }}</span>
                            <small class="text-muted"><i class="fas fa-calendar-alt mr-1"></i> Enrolled
                                {{ $enrollment->updated_at->format('M d, Y') }}</small>
                        </div>
                        <h5 class="card-title font-weight-bold mb-1">{{ $enrollment->course->title }}</h5>
                        <p class="text-muted small mb-3">By {{ $enrollment->course->instructor->username }}</p>

                        <div class="mt-auto">
                            <a href="{{ route('student.courses.show', $enrollment->course_id) }}"
                                class="btn btn-portal btn-block">
                                Go to Course <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12">
                <div class="text-center py-5">
                    <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-box-illustration-download-in-svg-png-gif-formats--state-pack-user-interface-illustrations-4523321.png"
                        alt="Empty" style="max-width: 200px;">
                    <h4 class="mt-4 font-weight-bold">No active enrollments found</h4>
                    <p class="text-muted">Once your payment is confirmed by an admin, your courses will appear here.</p>
                    <a href="{{ route('landing.education') }}" class="btn btn-portal mt-2">Browse Courses</a>
                </div>
            </div>
        @endforelse
    </div>
@endsection