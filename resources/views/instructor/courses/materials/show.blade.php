@extends('layouts.default.instructor.master')
@section('title', 'Manage Materials: ' . $course->title)

@section('content')
    <div class="content-body">
        <div class="content">
            <!-- begin::page-header -->
            <div class="page-header">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">Instructor</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('instructor.materials.index') }}">Materials</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $course->id }}</li>
                    </ol>
                </nav>
            </div>
            <!-- end::page-header -->

            <!-- begin::page content -->
            <div class="row">
                <!-- Upload Material Section -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title mb-4">Upload New Material</h6>
                            
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('instructor.materials.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                
                                <div class="form-group">
                                    <label for="title">Material Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required placeholder="e.g. Chapter 1: Introduction">
                                </div>

                                <div class="form-group">
                                    <label for="material">Upload PDF <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control-file" id="material" name="material" accept=".pdf" required>
                                    <small class="form-text text-muted">Please upload a valid PDF file (Max: 10MB).</small>
                                </div>

                                <div class="form-group text-right mb-0">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ti-upload mr-1"></i> Upload Material
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Existing Materials Section -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title mb-4">Uploaded Materials</h6>
                            
                            @if(session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session()->get('success') }}
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>Material Title</th>
                                            <th>File</th>
                                            <th>Status</th>
                                            <th>Date Uploaded</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($materials as $material)
                                            <tr>
                                                <td>{{ $material->title }}</td>
                                                <td>
                                                    <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                        <i class="ti-file"></i> View PDF
                                                    </a>
                                                </td>
                                                <td>
                                                    @if($material->status == 'pending')
                                                        <span class="badge badge-warning">Pending Approval</span>
                                                    @elseif($material->status == 'approved')
                                                        <span class="badge badge-success">Approved</span>
                                                    @elseif($material->status == 'rejected')
                                                        <span class="badge badge-danger" title="{{ $material->admin_note }}">Rejected</span>
                                                    @endif
                                                </td>
                                                <td>{{ $material->created_at->format('M d, Y h:i A') }}</td>
                                                <td>
                                                    <form action="{{ route('instructor.materials.destroy', $material->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this material?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm" data-toggle="tooltip" title="Delete">
                                                            <i class="ti-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No learning materials found for this course.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end::page content -->
        </div>
    </div>
@endsection
