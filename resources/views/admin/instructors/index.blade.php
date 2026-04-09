@extends('layouts.default.admin.master')
@section('title', 'Instructors Management')
@section('page-title', 'Instructors Management')

@section('content')
<div class="content-body">
    <div class="content">
        <div class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin-dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Instructors Directory</li>
                </ol>
            </nav>
        </div>

        <div class="row app-block">
            <div class="col-md-3 app-sidebar">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('admin.instructors.create') }}" class="btn btn-primary btn-block">
                            New Instructor
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-9 app-content">
                <div class="app-content-overlay"></div>
                <div class="card card-body app-content-body">
                    <div class="app-lists">
                        
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <ul class="list-group list-group-flush">
                            @if(count($instructors) > 0)
                                @foreach($instructors as $instructor)
                                <li class="list-group-item task-list">
                                    <div class="flex-grow-1 min-width-0">
                                        <div class="mb-1 d-flex align-items-center justify-content-between">
                                            <div class="app-list-title text-truncate">
                                                <strong>{{ $instructor->username }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $instructor->email }}</small>
                                            </div>
                                            <div class="pl-3 d-flex align-items-center">
                                                <div class="mr-3 text-muted">
                                                    Joined: {{ $instructor->created_at ? $instructor->created_at->format('M d, Y') : 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            @else
                                <li class="list-group-item task-list">
                                    <div class="flex-grow-1 min-width-0 text-center text-muted">
                                        No instructors found.
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
