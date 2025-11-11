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
                    <h5 class="form-header text-center">Users List</h5><br>
                    <div class="form-desc text-center"></div>
                    <div class="table-responsive">
                        <table id="users-table" width="100%" class="table table-striped table-lightfont">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Email</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end content-i -->
@endsection

@section('scripts')
    {{-- additional scripts here --}}
    <!-- Sweetalert -->
    <script>
        $(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('datatables.data') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    }
                ]
            });
        });
    </script>

@endsection
