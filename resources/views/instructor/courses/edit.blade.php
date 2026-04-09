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

                        <form action="{{ route('instructor.courses.update', $course->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group">
                                <label for="title">Course Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $course->title) }}" {{ $course->status === 'published' ? 'readonly' : '' }} required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Description <span class="text-danger">*</span></label>
                                <textarea name="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $course->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="suggested_price">Suggested Price (₱) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="suggested_price" id="suggested_price" class="form-control @error('suggested_price') is-invalid @enderror" value="{{ old('suggested_price', $course->suggested_price) }}" required>
                                <small class="text-muted">Enter the price you want for this course. Admin may override this.</small>
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
                                <div class="form-control-plaintext font-weight-bold">₱{{ number_format($course->price, 2) }}</div>
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
