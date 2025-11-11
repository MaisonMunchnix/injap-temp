@extends('layouts.default.admin.master')
@section('title',"All Members")
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
                <table id="members_table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Package</th>
                            <th>Sponsor</th>
                            <th>Password</th>
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
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@include('admin.members.edit-modal')
<!-- end content-i -->
@endsection

@section('scripts')
<!-- Sweetalert -->

<script src="{{asset('js/admin/members.js?v=1')}}"></script>
<script>
    $(document).ready(function() {
        $('#members_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('all-members') }}",
                "type": "post",
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
                    "data": "package"
                },
                {
                    "data": "sponsor"
                },
                {
                    "data": "plain_pass"
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





        /*$('#members_table').DataTable({
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
                    "data": "package"
                },
                {
                    "data": "sponsor"
                },
                {
                    "data": "plain_pass"
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "options",
                    "searchable": false,
                    "orderable": false
                }
            ],
        });*/



        /*$('#members_table').DataTable({
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
                    "data": "package"
                },
                {
                    "data": "sponsor"
                },
                {
                    "data": "plain_pass"
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "options",
                    "searchable": false,
                    "orderable": false
                }
            ],
            initComplete: function() {
                var api = this.api();
                var searchWait = 0;
                var searchWaitInterval;
                $(".dataTables_filter input")
                    .unbind()
                    .bind("input", function(e) {
                        var item = $(this);
                        searchWait = 0;
                        if (!searchWaitInterval) searchWaitInterval = setInterval(function() {
                            searchTerm = $(item).val();
                            clearInterval(searchWaitInterval);
                            searchWaitInterval = '';
                            api.search(searchTerm).draw();
                            searchWait = 0;
                            searchWait++;
                        }, 2500);
                        return;
                    });
            }
        });*/
    });

</script>
@endsection
