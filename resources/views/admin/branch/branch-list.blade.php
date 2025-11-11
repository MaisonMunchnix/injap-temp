@extends('layouts.default.admin.master')
@section('title', 'Branch List')
@section('page-title', 'Branch List')

@section('stylesheets')
    {{-- additional style here --}}
    <!-- swal -->

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
            <div class="card">
                <!-- <h6 class="element-header">Data Tables</h6> -->
                <div class="card-body">
                    <h5 class="form-header text-center">Branch List</h5><br>
                    <div class="form-desc text-center"></div>
                    <div class="table-responsive">
                        <table id="branch_list_table" width="100%" class="table table-striped table-lightfont">
                            <thead>
                                <tr>
                                    <th>Branch Name</th>
                                    <th>Type</th>
                                    <th>Address</th>
                                    <th>Owner</th>
                                    <th>Date Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Branch Name</th>
                                    <th>Type</th>
                                    <th>Address</th>
                                    <th>Owner</th>
                                    <th>Date Created</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if (!empty($branch_data))
                                    @foreach ($branch_data as $data)
                                        <tr class="text-capitalize">
                                            <td>{{ $data->name }}</td>
                                            <td>{{ $data->type }}</td>
                                            <td data-toggle="tooltip" data-placement="top"
                                                title="{{ $data->branch_address }}">
                                                {{ Str::limit($data->branch_address, 20) }}</td>
                                            <td>{{ $data->owner_first_name }} {{ $data->owner_last_name }}</td>
                                            <td>{{ $data->created_at }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                                        data-toggle="dropdown">Action </button>
                                                    <div class="dropdown-menu">
                                                        <a href="#" class="dropdown-item btn-view"
                                                            data-id="{{ $data->id }}">View</a>
                                                        @if (empty($access_data))
                                                            <a href="#" class="dropdown-item btn-edit"
                                                                data-id="{{ $data->id }}">Edit</a>
                                                        @else
                                                            @if ($access_data[0]->branch[0]->edit == 'true')
                                                                <a href="#" class="dropdown-item btn-edit"
                                                                    data-id="{{ $data->id }}">Edit</a>
                                                            @else
                                                            @endif
                                                        @endif

                                                        @if (empty($access_data))
                                                            <a href="#" class="dropdown-item btn-delete"
                                                                data-id="{{ $data->id }}">Delete</a>
                                                        @else
                                                            @if ($access_data[0]->branch[0]->delete == 'true')
                                                                <a href="#" class="dropdown-item btn-delete"
                                                                    data-id="{{ $data->id }}">Delete</a>
                                                            @else
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @include('user.customizer')
            @include('admin.branch.view_modal')
            @include('admin.branch.edit_branch')
            @include('admin.branch.delete_modal')
        </div>
    </div>
    <!-- end content-i -->
@endsection

@section('scripts')
    {{-- additional scripts here --}}
    <!-- Sweetalert -->
    {{-- <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script> --}}

    <script src="{{ asset('js/admin/branch.js?v=1') }}"></script>

@endsection
