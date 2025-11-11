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
                        <li class="breadcrumb-item active" aria-current="page">All Members</li>
                    </ol>
                </nav>
            </div>
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title text-center">All Registered Members</h6>
                    <table id="members_table" class="table table-striped table-bordered" width="100%">
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
    @include('admin.members.edit-password-modal')
    @include('admin.members.change-sponsor-modal')
    <!-- end content-i -->
@endsection

@section('scripts')
    <!-- Sweetalert -->

    <script src="{{ asset('js/admin/members.js?v=1212121212346794') }}"></script>
    <script>
        $(document).ready(function() {
            /*$('#members_table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('all-members-hidden') }}",
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

            $('#members_table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('all-members-hidden') }}",
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
                ]

            });



            $('#change-sponsor-btn').click(function() {
                var new_sponsor = $("#new_sponsor").val();
                var user_id = $("#to_be_change_user_id").val();
                if (new_sponsor != "" && user_id != "") {
                    var formData = new FormData();
                    formData.append("username_sponsor", new_sponsor);
                    formData.append("user_id", user_id);

                    formData.append('_token', token);
                    $.ajax({
                        url: "{{ route('change-sponsor') }}",
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $('.preloader').show();
                        },
                        success: function(response) {
                            $('.preloader').hide();
                            swal({
                                title: 'Success!',
                                text: 'Sponsor changed successfully',
                                timer: 1500,
                                type: "success",
                            }, function() {
                                location.reload();
                            });

                        },
                        error: function(error) {
                            $('.preloader').hide();
                            var err = error.responseJSON.message;
                            var err_msg = "";
                            if (err == "err1") {
                                err_msg = "Invalid sponsor username";
                            } else {
                                err_msg = "Something went wrong, please try again later";
                            }
                            swal({
                                title: 'Error!',
                                text: err_msg,
                                type: "error",
                            });

                        }
                    });
                } else {
                    swal({
                        title: 'Warning',
                        text: 'Please check empty input fields',
                        type: "warning",
                    });
                }
            });
        });
    </script>
@endsection
