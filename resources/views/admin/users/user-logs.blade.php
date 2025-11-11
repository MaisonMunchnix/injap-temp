@extends('layouts.user.master')
@section('title', 'User Logs')

@section('stylesheets')
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
                <div class="element-box">
                    <!-- <h6 class="element-header">Data Tables</h6> -->
                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="element-header">@yield('title')</h6>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="users_logs_table" width="100%" class="table table-striped table-lightfont table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Email Address</th>
                                    <th>Descriptions</th>
                                    <th>Status</th>
                                    <th>Error</th>
                                    <th>IP Address</th>
                                    <th>Date</th>

                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Email Address</th>
                                    <th>Descriptions</th>
                                    <th>Status</th>
                                    <th>Error</th>
                                    <th>IP Address</th>
                                    <th>Date</th>
                                </tr>
                            </tfoot>
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


    <script src="{{ asset('js/admin/users.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#users_logs_table').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('all-user-logs') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: token
                    }
                },
                "order": [
                    [7, "desc"]
                ],
                "columns": [{
                        "data": "id"
                    },
                    {
                        "data": "username"
                    },
                    {
                        "data": "email"
                    },
                    {
                        "data": "description"
                    },
                    {
                        "data": "status"
                    },
                    {
                        "data": "error"
                    },
                    {
                        "data": "ip_address"
                    },
                    {
                        "data": "created_at"
                    },
                ]
            });
        });
    </script>
@endsection
