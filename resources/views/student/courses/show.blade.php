@extends('layouts.student')

@section('content')
<div class="row mb-5">
    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-3">
                <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">{{ $course->title }}</li>
            </ol>
        </nav>
        <div class="d-flex align-items-center justify-content-between">
            <h2 class="font-weight-bold mb-0 text-dark-blue">{{ $course->title }}</h2>
        </div>
        <p class="text-muted mt-2">Instructor: <span class="font-weight-600 text-dark">{{ $course->instructor->username }}</span></p>
    </div>
</div>

<div class="row">
    <!-- Main Content Area -->
    <div class="col-lg-8">
        
        <!-- Announcements Section -->
        @if($announcements->count() > 0)
            <div class="section-header d-flex align-items-center mb-3">
                <i class="fas fa-bullhorn text-warning mr-2"></i>
                <h5 class="mb-0 font-weight-bold">Latest Announcements</h5>
            </div>
            @foreach($announcements as $announcement)
                <div class="card student-card announcement-card mb-4 border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="font-weight-bold mb-0 text-dark">{{ $announcement->title }}</h6>
                            <small class="text-muted">{{ $announcement->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="announcement-content text-dark-blue">
                            {!! nl2br(e($announcement->content)) !!}
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

        <!-- Materials & Links Section -->
        <div class="section-header d-flex align-items-center mt-5 mb-3">
            <i class="fas fa-folder-open text-primary mr-2"></i>
            <h5 class="mb-0 font-weight-bold">Course Materials & Session Links</h5>
        </div>

        <div class="table-rounded">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="border-top-0">Type</th>
                        <th class="border-top-0">Title</th>
                        <th class="border-top-0">Date Added</th>
                        <th class="border-top-0 text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($filesAndLinks as $material)
                        <tr>
                            <td class="align-middle">
                                @if($material->type == 'link')
                                    <span class="badge badge-pill badge-info"><i class="fas fa-link mr-1"></i> Link</span>
                                @else
                                    <span class="badge badge-pill badge-success"><i class="fas fa-file-alt mr-1"></i> File</span>
                                @endif
                            </td>
                            <td class="align-middle font-weight-500">{{ $material->title }}</td>
                            <td class="align-middle text-muted small">{{ $material->created_at->format('M d, Y') }}</td>
                            <td class="align-middle text-right">
                                @if($material->type == 'link')
                                    <a href="{{ $material->link_url }}" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-3">
                                        Open Link <i class="fas fa-external-link-alt ml-1"></i>
                                    </a>
                                @else
                                    <a href="{{ route('student.materials.download', $material->id) }}" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                        Download <i class="fas fa-download ml-1"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                                <i class="fas fa-ghost mr-2"></i> No materials or session links available yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Sidebar / Info Area -->
    <div class="col-lg-4 mt-lg-0 mt-5">
        <div class="card student-card border-0">
            <div class="card-body">
                <h6 class="font-weight-bold mb-3">Course Info</h6>
                <div class="d-flex mb-3">
                    <div class="mr-3 text-primary"><i class="fas fa-tag fa-fw"></i></div>
                    <div>
                        <div class="small text-muted">Category</div>
                        <div class="font-weight-500">{{ $course->category ?? 'General' }}</div>
                    </div>
                </div>
                <div class="d-flex mb-3">
                    <div class="mr-3 text-info"><i class="fas fa-users fa-fw"></i></div>
                    <div>
                        <div class="small text-muted">Level</div>
                        <div class="font-weight-500">{{ $course->level ?? 'Not specified' }}</div>
                    </div>
                </div>
                <hr>
                <div class="alert alert-info border-0 rounded-lg small">
                    <i class="fas fa-info-circle mr-1"></i> New sessions will be posted by the instructor here as they become available.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
