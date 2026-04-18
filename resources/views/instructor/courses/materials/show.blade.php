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
                                    <label for="type">Resource Type <span class="text-danger">*</span></label>
                                    <select class="form-control" id="type" name="type" required onchange="toggleFields()">
                                        <option value="file">File Upload (PDF, Doc, etc.)</option>
                                        <option value="link">Session Link (Zoom, Meet, etc.)</option>
                                        <option value="announcement">Announcement / Info</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="title">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required placeholder="e.g. Chapter 1: Introduction">
                                </div>

                                <div id="file-field" class="form-group material-fields">
                                    <label for="material">Upload File <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control-file" id="material" name="material" accept=".pdf,.docx">
                                    <small class="form-text text-muted">Please upload a valid PDF or DOCX document (Max: 10MB).</small>
                                </div>

                                <div id="link-field" class="form-group material-fields" style="display: none;">
                                    <label for="link_url">Link URL <span class="text-danger">*</span></label>
                                    <input type="url" class="form-control" id="link_url" name="link_url" value="{{ old('link_url') }}" placeholder="https://zoom.us/j/...">
                                </div>

                                <div id="announcement-field" class="form-group material-fields" style="display: none;">
                                    <label for="content">Content <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="content" name="content" rows="4">{{ old('content') }}</textarea>
                                </div>

                                <div class="form-group text-right mb-0">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ti-save mr-1"></i> Save Resource
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
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Resource</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($materials as $material)
                                            <tr>
                                                <td>{{ $material->title }}</td>
                                                <td>
                                                    <span class="badge badge-secondary">{{ ucfirst($material->type) }}</span>
                                                </td>
                                                <td>
                                                    @if($material->type == 'file')
                                                        <a href="{{ route('instructor.materials.download', $material->id) }}" class="btn btn-outline-info btn-sm">
                                                            <i class="ti-download"></i> Download
                                                        </a>
                                                    @elseif($material->type == 'link')
                                                        <a href="{{ $material->link_url }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                            <i class="ti-link"></i> Open Link
                                                        </a>
                                                    @else
                                                        <span class="text-muted">Announcement</span>
                                                    @endif
                                                </td>
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

@section('scripts')
<script>
    function toggleFields() {
        const type = document.getElementById('type').value;
        const fields = document.querySelectorAll('.material-fields');
        fields.forEach(f => f.style.display = 'none');

        if (type === 'file') {
            document.getElementById('file-field').style.display = 'block';
        } else if (type === 'link') {
            document.getElementById('link-field').style.display = 'block';
        } else if (type === 'announcement') {
            document.getElementById('announcement-field').style.display = 'block';
        }
    }

    document.getElementById('material').addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const size = this.files[0].size / 1024 / 1024; // in MB
            if (size > 10) {
                swal({
                    title: "File Too Large",
                    text: "The selected file is " + size.toFixed(2) + "MB. Please upload a file smaller than 10MB.",
                    icon: "error",
                    button: "OK",
                });
                this.value = ""; // Clear the input
            }
        }
    });
</script>
@endsection
