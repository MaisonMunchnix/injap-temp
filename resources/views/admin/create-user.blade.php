@extends('layouts.default.admin.master')
@section('title','Create User')
@section('page-title','Create User')

@section('content')
<div class="content-body">
    <div class="content">
        <div class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin-dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Create User</li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Create New User</h4>
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

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="first_name" class="form-label">First Name <span style="color: red;">*</span></label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                id="first_name" name="first_name" value="{{ old('first_name') }}"
                                placeholder="Enter first name" required>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="middle_name" class="form-label">Middle Name</label>
                            <input type="text" class="form-control @error('middle_name') is-invalid @enderror"
                                id="middle_name" name="middle_name" value="{{ old('middle_name') }}"
                                placeholder="Enter middle name">
                            @error('middle_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="last_name" class="form-label">Last Name <span style="color: red;">*</span></label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                id="last_name" name="last_name" value="{{ old('last_name') }}"
                                placeholder="Enter last name" required>
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="mobile_no" class="form-label">Mobile Number</label>
                        <input type="text" class="form-control @error('mobile_no') is-invalid @enderror"
                            id="mobile_no" name="mobile_no" value="{{ old('mobile_no') }}"
                            placeholder="Enter mobile number">
                        @error('mobile_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

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
                        <label for="userType" class="form-label">User Type <span style="color: red;">*</span></label>
                        <select class="form-control @error('userType') is-invalid @enderror" 
                            id="userType" name="userType" required>
                            <option value="">-- Select User Type --</option>
                            <option value="staff" {{ old('userType') === 'staff' ? 'selected' : '' }}>Staff (Super Admin)</option>
                            <option value="paymentApprover" {{ old('userType') === 'paymentApprover' ? 'selected' : '' }}>Payment Approver</option>
                            <option value="productApprover" {{ old('userType') === 'productApprover' ? 'selected' : '' }}>Product Approver</option>
                            <option value="applicationApprover" {{ old('userType') === 'applicationApprover' ? 'selected' : '' }}>Application Approver</option>
                        </select>
                        @error('userType')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="staffPermissions" style="display: none;">
                        <div class="form-group">
                            <label for="admin_scope" class="form-label">Staff Access Scope</label>
                            <select class="form-control @error('admin_scope') is-invalid @enderror"
                                id="admin_scope" name="admin_scope">
                                <option value="full" {{ old('admin_scope', 'full') === 'full' ? 'selected' : '' }}>Full Staff Access</option>
                                <option value="instructors_only" {{ old('admin_scope') === 'instructors_only' ? 'selected' : '' }}>Instructors Management Only</option>
                            </select>
                            @error('admin_scope')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input type="hidden" name="can_manage_instructors" value="0">
                                <input type="checkbox" class="form-check-input"
                                    id="can_manage_instructors" name="can_manage_instructors" value="1"
                                    {{ old('can_manage_instructors', 1) ? 'checked' : '' }}>
                                <label class="form-check-label" for="can_manage_instructors">
                                    Can manage instructors
                                </label>
                            </div>
                            <small class="text-muted">Required for accessing instructor routes and sidebar.</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Create User</button>
                        <a href="{{ route('admin-dashboard') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('layouts.default.footer')
</div>

@section('scripts')
<script>
    function toggleStaffPermissions() {
        var userType = document.getElementById('userType').value;
        var staffPermissions = document.getElementById('staffPermissions');
        staffPermissions.style.display = userType === 'staff' ? 'block' : 'none';
    }

    function enforceInstructorsScope() {
        var adminScope = document.getElementById('admin_scope');
        var canManageInstructors = document.getElementById('can_manage_instructors');

        if (!adminScope || !canManageInstructors) {
            return;
        }

        if (adminScope.value === 'instructors_only') {
            canManageInstructors.checked = true;
            canManageInstructors.disabled = true;
        } else {
            canManageInstructors.disabled = false;
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        var userTypeElement = document.getElementById('userType');
        var adminScopeElement = document.getElementById('admin_scope');

        toggleStaffPermissions();
        enforceInstructorsScope();

        if (userTypeElement) {
            userTypeElement.addEventListener('change', function () {
                toggleStaffPermissions();
                enforceInstructorsScope();
            });
        }

        if (adminScopeElement) {
            adminScopeElement.addEventListener('change', enforceInstructorsScope);
        }
    });
</script>
@endsection
@endsection
