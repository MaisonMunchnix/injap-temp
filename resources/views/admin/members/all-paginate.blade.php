@extends('layouts.default.admin.master')
@section('title', 'All Members')
@section('page-title', 'Add Users')

@section('stylesheets')
    <style>
        .border-red {
            border: 1px solid red !important;
        }
    </style>
@endsection

@section('content')
    <div class="content-body">
        <!-- start content- -->
        <div class="content">
            <div class="page-header">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">Distributor List</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                    </ol>
                </nav>
            </div>
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">@yield('title')</h6>
                    <form action="{{ route('members-all.post') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-3 offset-md-9 float-right">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="search" value="{{ old('search') }}"
                                        required>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="feather feather-search"></i> Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <table id="members_table" class="table table-striped table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Package</th>
                                <th>Sponsor</th>
                                <th>Password</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Username</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Package</th>
                                <th>Sponsor</th>
                                <th>Password</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($users as $user)
                                @php
                                    if ($user->status == 0) {
                                        $status = 'Inactive';
                                        $status_label = 'Activate';
                                        $color = 'danger';
                                        $icon = 'icon-check';
                                    } elseif ($user->status == 1) {
                                        $status = 'Active';
                                        $icon = 'icon-x';
                                        $color = 'success';
                                        $status_label = 'Deactivate';
                                    } elseif ($user->status == 2) {
                                        $status = 'Inactive';
                                        $status_label = 'Activate';
                                        $icon = 'icon-check';
                                        $color = 'success';
                                    } else {
                                        $status = 'Not Define';
                                        $status_label = 'Not Define';
                                        $icon = 'la-question';
                                        $color = 'default';
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->first_name }}</td>
                                    <td>{{ $user->last_name }}</td>
                                    <td>{{ $user->package }}</td>
                                    <td>{{ $user->sponsor }}</td>
                                    <td>{{ $user->plain_pass }}</td>
                                    <td><span class="text-{{ $color }}">{{ $status }}</span></td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button"
                                                data-toggle="dropdown">Action</button>
                                            <div class="dropdown-menu">
                                                <a href="#" class="dropdown-item editModalBtn" data-toggle="modal"
                                                    data-id="{{ $user->user_id }}" data-toggle="tooltip"
                                                    data-placement="top" title="Edit"><i class="feather icon-edit-2"></i>
                                                    Edit</a>
                                                <a href="#" class="dropdown-item edit-password" data-toggle="modal"
                                                    data-id="{{ $user->user_id }}" data-toggle="tooltip"
                                                    data-placement="top" title="Edit"><i class="feather icon-edit-2"></i>
                                                    Change Password</a>
                                                <a href="#" class="dropdown-item btn-view modifyUser"
                                                    data-id="{{ $user->user_id }}" data-toggle="tooltip"
                                                    data-placement="top" title="{{ $status_label }}"><i
                                                        class="feather {{ $icon }}"></i>{{ $status_label }}</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pull-right">{{ $users->links() }}</div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.members.edit-modal')
    @include('admin.members.edit-password-modal')
    <!-- end content-i -->
@endsection

@section('scripts')
    <!-- Sweetalert -->

    <script src="{{ asset('js/admin/members.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#members_table').DataTable({
                "paging": false,
                "bFilter": false
            });
        });
    </script>
@endsection
