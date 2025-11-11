o@extends('layouts.user.master')
@section('title', 'Members')
@section('page-title', 'Add Users')

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
                <!-- <h6 class="element-header">Data Tables</h6> -->
                <div class="element-box">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="element-header">@yield('title')</h6>
                        </div>
                        <!--<div class="col-md-6">
          <a class="btn btn-primary pull-right" data-target="#add-modal" data-toggle="modal" href="#"><i class="os-icon os-icon-ui-22"></i><span> User</span></a>
         </div>-->
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                            <li class="nav-item">
                                <a href="#members-today" id="today_id" class="nav-link active" data-toggle="tab"
                                    role="tab" aria-controls="tab-21" aria-selected="true">
                                    <span class="nav-link__count">Registered Member/s Today</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#all-members" id="all_id" class="nav-link" data-toggle="tab" role="tab"
                                    aria-selected="false">
                                    <!-- <span class="nav-link__count">All Members</span>-->
                                </a>
                            </li>
                        </ul>

                        <div class="card-body tab-content">
                            <div class="tab-pane active show fade in" id="members-today">
                                <br>
                                <h3><strong class="headings-color">Registered Member/s Today</strong></h3>
                                <div class="table-responsive border-bottom">
                                    <table class="table thead-border-top-0" id="members_table_today"
                                        style="width:100% !important">
                                        <thead>
                                            <tr>
                                                <th>Username</th>
                                                <th>Name</th>
                                                <th>Email Address</th>
                                                <th>Mobile #</th>
                                                <th>Package</th>
                                                <th>Sponsor</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Username</th>
                                                <th>Name</th>
                                                <th>Email Address</th>
                                                <th>Mobile #</th>
                                                <th>Package</th>
                                                <th>Sponsor</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade in" id="all-members">
                                <!--<h3><strong class="headings-color">All Members</strong></h3>-->
                                <div class="table-responsive border-bottom">
                                    <table class="table thead-border-top-0" id="members_table"
                                        style="width:100% !important">
                                        <thead>
                                            <tr>
                                                <th>Username</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email Address</th>
                                                <th>Mobile #</th>
                                                <th>Package</th>
                                                <th>Sponsor</th>
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
                                                <th>Email Address</th>
                                                <th>Mobile #</th>
                                                <th>Package</th>
                                                <th>Sponsor</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end content-i -->
@endsection

@section('scripts')
    <!-- Sweetalert -->

    <script src="{{ asset('js/admin/members.js') }}"></script>
    <script>
        $(document).ready(function() {
            if ($('#members-today').hasClass('active')) {
                console.log('today');
                member_today();
            }

            $("#today_id").click(function() {
                console.log('click today');
                member_today();
            });

            $("#all_id").click(function() {
                console.log('click all');
                member_all();
            });


            function member_all() {
                console.log('all function');
                $('#members_table').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ route('all-members') }}",
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
                            "data": "first_name"
                        },
                        {
                            "data": "last_name"
                        },
                        {
                            "data": "email"
                        },
                        {
                            "data": "mobile_no"
                        },
                        {
                            "data": "package"
                        },
                        {
                            "data": "sponsor"
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
            }

            function member_today() {
                //console.log('today function');
                $('#members_table_today').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ route('all-members') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": {
                            _token: token,
                            users_today: true
                        }
                    },
                    "columns": [{
                            "data": "username"
                        },
                        {
                            "data": "first_name"
                        },
                        {
                            "data": "last_name"
                        },
                        {
                            "data": "email"
                        },
                        {
                            "data": "mobile_no"
                        },
                        {
                            "data": "package"
                        },
                        {
                            "data": "sponsor"
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
            }
        });
    </script>
@endsection
