@extends('layouts.default.admin.master')

@section('title','Staff / Teller List')

@section('page-title','Add Users')



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

        <div class="card">

            <div class="card-body">

                <!-- <h6 class="element-header">Data Tables</h6> -->

                <div class="row">

                    <div class="col-md-12">

                        <h5 class="element-header text-center">Staff / Teller List</h5>

                    </div>

                    <div class="col-md-12">
                        @if(empty($access_data))
                        <a class="btn btn-primary" data-target="#add-modal" data-toggle="modal" href="#"><i class="os-icon os-icon-ui-22"></i><span> Add New Staff / Teller</span></a><br /><br />
                        @else
                        @if($access_data[0]->user[0]->add=='true')
                        <a class="btn btn-primary" data-target="#add-modal" data-toggle="modal" href="#"><i class="os-icon os-icon-ui-22"></i><span> Add New Staff / Teller</span></a><br /><br />
                        @else
                        <a class="btn btn-primary" href="#"><i class="os-icon os-icon-ui-22"></i><span> Add New Staff / Teller</span></a><br /><br />
                        @endif
                        @endif
                    </div>

                </div>

                <div class="table-responsive">

                    <table id="users_table" width="100%" class="table table-striped table-lightfont">

                        <thead>

                            <tr>

                                <th>Username</th>

                                <th>Email Address</th>

                                <th>First Name</th>

                                <th>Last Name</th>

                                <th>Type</th>

                                <th>Status</th>

                                <th>Date</th>

                                <th>Actions</th>

                            </tr>

                        </thead>

                        <tfoot>

                            <tr>

                                <th>Username</th>

                                <th>Email Address</th>

                                <th>First Name</th>

                                <th>Last Name</th>

                                <th>Type</th>

                                <th>Status</th>

                                <th>Date</th>

                                <th>Actions</th>

                            </tr>

                        </tfoot>

                    </table>

                </div>

            </div>

        </div>

        @include('admin.users.view-modal')

        @include('admin.users.edit-modal')

        @include('admin.users.add-modal')

        @include('admin.users.delete-modal')

    </div>

</div>

<!-- end content-i -->

@endsection



@section('scripts')

{{-- additional scripts here --}}

<!-- Sweetalert -->





<script src="{{asset('js/admin/users.js')}}"></script>

<script>
    $(document).ready(function() {

        $('#users_table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "processing": true,

            "serverSide": true,

            "ajax": {

                "url": "{{ route('all-users') }}",

                "dataType": "json",

                "type": "POST",

                "data": {

                    _token: token

                }

            },

            "columns": [{

                    "data": "username"

                },

                {

                    "data": "email"

                },

                {

                    "data": "first_name"

                },

                {

                    "data": "last_name"

                },

                {

                    "data": "type"

                },

                {

                    "data": "status"

                },

                {

                    "data": "created_at"

                },

                {

                    "data": "options",

                    "searchable": false,

                    "orderable": false

                }

            ]

        });





    });

</script>

@endsection
