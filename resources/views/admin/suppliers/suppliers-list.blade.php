@extends('layouts.user.master')
@section('title', 'Supplier List')
@section('page-title', 'Supplier List')

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
    <div class="content-i">
        <!-- start content- -->
        <div class="content-box">
            <div class="element-wrapper">
                <!-- <h6 class="element-header">Data Tables</h6> -->
                <div class="element-box">
                    <h5 class="form-header text-center">Supplier List</h5>
                    <div class="form-desc text-center"></div>
                    <div class="table-responsive">
                        <table id="branch_list_table" width="100%" class="table table-striped table-lightfont">
                            <thead>
                                <tr>
                                    <th>Supplier Name</th>
                                    <th>Code</th>
                                    <th>Address</th>
                                    <th>Owner</th>
                                    <th>Date Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Supplier Name</th>
                                    <th>Type</th>
                                    <th>Address</th>
                                    <th>Owner</th>
                                    <th>Date Created</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if (!empty($suppliers_data))
                                    @foreach ($suppliers_data as $data)
                                        <tr class="text-capitalize">
                                            <td>{{ $data->supplier_name }}</td>
                                            <td>{{ $data->supplier_code }}</td>
                                            <td>{{ $data->contact_address }}</td>
                                            <td>{{ $data->contact_first_name }} {{ $data->contact_last_name }}</td>
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
                                                            @if ($access_data[0]->supplier[0]->edit == 'true')
                                                                <a href="#" class="dropdown-item btn-edit"
                                                                    data-id="{{ $data->id }}">Edit</a>
                                                            @else
                                                            @endif
                                                        @endif

                                                        @if (empty($access_data))
                                                            <a href="#" class="dropdown-item btn-delete"
                                                                data-id="{{ $data->id }}">Delete</a>
                                                        @else
                                                            @if ($access_data[0]->supplier[0]->delete == 'true')
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
            @include('admin.suppliers.view_modal')
            @include('admin.suppliers.edit_supplier')
            @include('admin.suppliers.delete_modal')
        </div>
    </div>
    <!-- end content-i -->
@endsection

@section('scripts')
    {{-- additional scripts here --}}
    <!-- Sweetalert -->
    {{-- <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script> --}}

    <script src="{{ asset('js/admin/supplier.js') }}"></script>

@endsection
