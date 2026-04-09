@extends('layouts.default.admin.master')
@section('title', 'Create Instructor')
@section('page-title', 'Create Instructor')

@section('content')
<div class="content-body">
    <div class="content">
        <div class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin-dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.instructors.index') }}">Instructors Directory</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Create Instructor</li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Create New Instructor</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong>
                        <ul style="margin-bottom: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <form action="{{ route('admin.instructors.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="username" class="form-label">Username <span style="color: red;">*</span></label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" 
                            id="username" name="username" value="{{ old('username') }}" 
                            placeholder="Enter username" required>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email <span style="color: red;">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                            id="email" name="email" value="{{ old('email') }}" 
                            placeholder="Enter email address" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password <span style="color: red;">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                            id="password" name="password" placeholder="Enter password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirm Password <span style="color: red;">*</span></label>
                        <input type="password" class="form-control" 
                            id="password_confirmation" name="password_confirmation" 
                            placeholder="Confirm password" required>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Create Instructor</button>
                        <a href="{{ route('admin.instructors.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('layouts.default.footer')
</div>
@endsection
