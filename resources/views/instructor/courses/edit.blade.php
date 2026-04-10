@extends('layouts.default.instructor.master')
@section('title', 'Edit Course: ' . $course->title)
@section('page-title', 'Edit Course')

@section('content')
    <div class="content-body">
        <div class="content">
            <div class="page-header">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('instructor.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('instructor.courses.index') }}">My Courses</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Course</li>
                    </ol>
                </nav>
            </div>

            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Course Details</h4>

                            <form action="{{ route('instructor.courses.update', $course->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="cover_photo">Cover Photo</label>
                                    @if($course->cover_photo)
                                        <div class="mb-2">
                                            <img src="{{ asset($course->cover_photo) }}" alt="Cover Photo" class="img-thumbnail"
                                                style="max-height: 150px;">
                                        </div>
                                    @endif
                                    <input type="file" name="cover_photo" id="cover_photo"
                                        class="form-control @error('cover_photo') is-invalid @enderror">
                                    <small class="text-muted">Upload a new cover image to replace the current one (Max 2MB,
                                        JPG/PNG/GIF).</small>
                                    @error('cover_photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="title">Course Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title', $course->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description">Description <span class="text-danger">*</span></label>
                                    <textarea name="description" id="description" rows="5"
                                        class="form-control @error('description') is-invalid @enderror"
                                        required>{{ old('description', $course->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category">Category</label>
                                            <input type="text" name="category" id="category"
                                                class="form-control @error('category') is-invalid @enderror"
                                                value="{{ old('category', $course->category) }}" placeholder="e.g. Music, Art, Coding">
                                            @error('category')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="level">Level <span class="text-danger">*</span></label>
                                            <select name="level" id="level" class="form-control @error('level') is-invalid @enderror" required>
                                                <option value="beginner" {{ old('level', $course->level) == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                                <option value="intermediate" {{ old('level', $course->level) == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                                <option value="advanced" {{ old('level', $course->level) == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                            </select>
                                            @error('level')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="min_age">Minimum Age</label>
                                            <input type="number" name="min_age" id="min_age"
                                                class="form-control @error('min_age') is-invalid @enderror"
                                                value="{{ old('min_age', $course->min_age) }}">
                                            @error('min_age')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="max_age">Maximum Age</label>
                                            <input type="number" name="max_age" id="max_age"
                                                class="form-control @error('max_age') is-invalid @enderror"
                                                value="{{ old('max_age', $course->max_age) }}">
                                            <small class="text-muted">Leave blank for no upper limit.</small>
                                            @error('max_age')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="min_slots">Minimum Slots</label>
                                            <input type="number" name="min_slots" id="min_slots"
                                                class="form-control @error('min_slots') is-invalid @enderror"
                                                value="{{ old('min_slots', $course->min_slots) }}">
                                            <small class="text-muted">Minimum enrollees to push through.</small>
                                            @error('min_slots')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="max_slots">Maximum Slots (Capacity)</label>
                                            <input type="number" name="max_slots" id="max_slots"
                                                class="form-control @error('max_slots') is-invalid @enderror"
                                                value="{{ old('max_slots', $course->max_slots) }}">
                                            @error('max_slots')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="schedule_start">Schedule Start <span class="text-danger">*</span></label>
                                            <input type="datetime-local" name="schedule_start" id="schedule_start"
                                                class="form-control @error('schedule_start') is-invalid @enderror"
                                                value="{{ old('schedule_start', $course->schedule_start ? date('Y-m-d\TH:i', strtotime($course->schedule_start)) : '') }}" required>
                                            @error('schedule_start')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="schedule_end">Schedule End <span class="text-danger">*</span></label>
                                            <input type="datetime-local" name="schedule_end" id="schedule_end"
                                                class="form-control @error('schedule_end') is-invalid @enderror"
                                                value="{{ old('schedule_end', $course->schedule_end ? date('Y-m-d\TH:i', strtotime($course->schedule_end)) : '') }}" required>
                                            @error('schedule_end')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="session_count">Session Count</label>
                                            <input type="number" name="session_count" id="session_count"
                                                class="form-control @error('session_count') is-invalid @enderror"
                                                value="{{ old('session_count', $course->session_count) }}">
                                            @error('session_count')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="session_duration_mins">Duration (Minutes)</label>
                                            <input type="number" name="session_duration_mins" id="session_duration_mins"
                                                class="form-control @error('session_duration_mins') is-invalid @enderror"
                                                value="{{ old('session_duration_mins', $course->session_duration_mins) }}">
                                            @error('session_duration_mins')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="recurrence">Recurrence <span class="text-danger">*</span></label>
                                            <select name="recurrence" id="recurrence" class="form-control @error('recurrence') is-invalid @enderror" required>
                                                <option value="once" {{ old('recurrence', $course->recurrence) == 'once' ? 'selected' : '' }}>Once</option>
                                                <option value="daily" {{ old('recurrence', $course->recurrence) == 'daily' ? 'selected' : '' }}>Daily</option>
                                                <option value="weekly" {{ old('recurrence', $course->recurrence) == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                                <option value="custom" {{ old('recurrence', $course->recurrence) == 'custom' ? 'selected' : '' }}>Custom</option>
                                            </select>
                                            @error('recurrence')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="meeting_link">Meeting Link (for Online)</label>
                                            <input type="url" name="meeting_link" id="meeting_link"
                                                class="form-control @error('meeting_link') is-invalid @enderror"
                                                value="{{ old('meeting_link', $course->meeting_link) }}" placeholder="https://zoom.us/j/...">
                                            @error('meeting_link')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="location">Location (for In-person)</label>
                                            <input type="text" name="location" id="location"
                                                class="form-control @error('location') is-invalid @enderror"
                                                value="{{ old('location', $course->location) }}" placeholder="Building name / Room no.">
                                            @error('location')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="suggested_price">Price (₱) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="suggested_price" id="suggested_price"
                                        class="form-control @error('suggested_price') is-invalid @enderror"
                                        value="{{ old('suggested_price', $course->suggested_price) }}" {{ $course->status === 'published' ? 'readonly' : '' }} required>
                                    <small class="text-muted">Enter the price you want for this course. Admin may override
                                        this.</small>
                                    @error('suggested_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Current Status</label>
                                    <div>
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
                                    </div>
                                </div>

                                @if($course->price)
                                    <div class="form-group">
                                        <label>Admin Set Price</label>
                                        <div class="form-control-plaintext font-weight-bold">
                                            ₱{{ number_format($course->price, 2) }}</div>
                                    </div>
                                @endif

                                <div class="text-right">
                                    <a href="{{ route('instructor.courses.index') }}" class="btn btn-light mr-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Update Course</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection