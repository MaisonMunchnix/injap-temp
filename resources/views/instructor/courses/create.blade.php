@extends('layouts.default.instructor.master')
@section('title', 'Create Course')
@section('page-title', 'Create New Course')

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
                    <li class="breadcrumb-item active" aria-current="page">Create New Course</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Course Details</h4>

                        <form action="{{ route('instructor.courses.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="form-group">
                                <label for="cover_photo">Cover Photo</label>
                                <input type="file" name="cover_photo" id="cover_photo" class="form-control @error('cover_photo') is-invalid @enderror">
                                <small class="text-muted">Upload a cover image for your course (Max 2MB, JPG/PNG/GIF).</small>
                                @error('cover_photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="title">Course Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Description <span class="text-danger">*</span></label>
                                <textarea name="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="suggested_price">Suggested Price (₱) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="suggested_price" id="suggested_price" class="form-control @error('suggested_price') is-invalid @enderror" value="{{ old('suggested_price', '0.00') }}" required>
                                <small class="text-muted">Enter the price you want for this course. Admin may override this.</small>
                                @error('suggested_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-right">
                                <a href="{{ route('instructor.courses.index') }}" class="btn btn-light mr-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">Create Course</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
