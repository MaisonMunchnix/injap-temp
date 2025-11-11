@extends('layouts.user.master')

@section('title', 'Members')

@section('stylesheets')

@endsection

@section('breadcrumbs')
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">@yield('title')</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/teller-admin">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                </ol>
            </div>
        </div>
        <!--<div class="col-md-4 col-lg-4">
      <div class="widgetbar">
       <button class="btn btn-primary">Add Widget</button>
      </div>
     </div>-->
    </div>
@endsection

@section('content')
    <div class="card-header">
        <h5 class="card-title">List of Existing Members</h5>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
            <li class="nav-item">
                <a href="#members-today" class="nav-link active" data-toggle="tab" role="tab" aria-controls="tab-21"
                    aria-selected="true">
                    <span class="nav-link__count">Registered Member/s Today</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#all-members" class="nav-link" data-toggle="tab" role="tab" aria-selected="false">
                    <span class="nav-link__count">All Members</span>
                </a>
            </li>
        </ul>

        <div class="card-body tab-content">
            <div class="tab-pane active show fade" id="members-today">
                <h3><strong class="headings-color float-left">Registered Member/s Today</strong></h3>
                <div class="table-responsive border-bottom">
                    <table class="table thead-border-top-0" id="members_table_today" style="width:100% !important">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email Address</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="all-members">
                <h3><strong class="headings-color float-left">All Members</strong></h3>
                <div class="table-responsive border-bottom">
                    <table class="table thead-border-top-0" id="members_table" style="width:100% !important">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email Address</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-center-title"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="" class="classFormUpdate" id="classForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-center-title">Update Member</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div> <!-- // END .modal-header -->
                    <div class="modal-body">
                        @csrf
                        <div class="form-group row required" data-toggle="tooltip" data-placement="top"
                            title="First Name is required">
                            <label for="first_name" class="col-form-label col-md-3">First Name: *</label>
                            <div class="col-md-9">
                                <input type="hidden" id="id" name="id" required>
                                <input class="form-control" placeholder="First Nam" id="first_name" name="first_name"
                                    type="text" required>
                                <span id="error-name" class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row" data-toggle="tooltip" data-placement="top"
                            title="Middle Name is not required">
                            <label for="middle_name" class="col-form-label col-md-3">Middle Name:</label>
                            <div class="col-md-9">
                                <input class="form-control" placeholder="Middle Name" id="middle_name" name="middle_name"
                                    type="text">
                                <span id="error-name" class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row required" data-toggle="tooltip" data-placement="top"
                            title="Last Name is required">
                            <label for="last_name" class="col-form-label col-md-3">Last Name: *</label>
                            <div class="col-md-9">
                                <input class="form-control" placeholder="Last Name" id="last_name" name="last_name"
                                    type="text" required>
                                <span id="error-name" class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row required" data-toggle="tooltip" data-placement="top"
                            title="Mobile Number is required">
                            <label for="mobile_no" class="col-form-label col-md-3">Mobile No.: *</label>
                            <div class="col-md-9">
                                <input class="form-control" placeholder="Mobile No." id="mobile_no" name="mobile_no"
                                    type="text" required>
                                <span id="error-name" class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row required" data-toggle="tooltip" data-placement="top"
                            title="Username is required">
                            <label for="username" class="col-form-label col-md-3">Username: *</label>
                            <div class="col-md-9">
                                <input class="form-control" placeholder="Username" id="username" name="username"
                                    type="text" required>
                                <span id="error-name" class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row required" data-toggle="tooltip" data-placement="top"
                            title="Email Address is required">
                            <label for="email" class="col-form-label col-md-3">Email Address: *</label>
                            <div class="col-md-9">
                                <input class="form-control" placeholder="Email" name="email" type="text"
                                    id="email" required>
                                <span id="error-email" class="invalid-feedback"></span>
                            </div>
                        </div>
                    </div> <!-- // END .modal-body -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="update-btn">Save changes</button>
                    </div> <!-- // END .modal-footer -->
                </form>
            </div> <!-- // END .modal-content -->
        </div> <!-- // END .modal-dialog -->
    </div> <!-- // END .modal -->

    <script>
        $(document).ready(function() {
            function IsEmail(email) {
                var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if (!regex.test(email)) {
                    return false;
                } else {
                    return true;
                }
            }

            /*		$('#editModalBtn').click(function(e) {
            			alert("The paragraph was clicked.");
            		});*/
            //$('.editModalBtn').click(function(e) {
            $('body').on('click', '.editModalBtn', function(event) {
                console.log('edit btn clicked');
                var id = $(this).data('id');
                var action = 'members/edit' + id;
                var url = 'members/edit';
                $.ajax({
                    type: 'get',
                    url: url,
                    data: {
                        'id': id
                    },
                    beforeSend: function() {
                        $('.send-loading').show();
                    },
                    success: function(data) {
                        $('.send-loading').hide();
                        $('#id').val(data.id);
                        $('#username').val(data.username);
                        $('#first_name').val(data.first_name);
                        $('#middle_name').val(data.middle_name);
                        $('#last_name').val(data.last_name);
                        $('#mobile_no').val(data.mobile_no);
                        $('#email').val(data.email);
                        $('.classFormUpdate').attr('action', action);
                        $('#editModal').modal('show');
                    }
                });
            });


            $('#update-btn').click(function() {
                event.preventDefault();
                console.log('Member update submitting...');
                var formData = new FormData();
                formData.append("id", $("#id").val());
                formData.append("username", $("#username").val());
                formData.append("email_address", $("#email").val());
                formData.append("first_name", $("#first_name").val());
                formData.append("middle_name", $("#middle_name").val());
                formData.append("last_name", $("#last_name").val());
                formData.append("mobile_no", $("#mobile_no").val());
                formData.append('_token', token);

                if (IsEmail($("#email").val()) == false) {
                    swal({
                        title: 'Error!',
                        text: 'Error Msg: Invalid Email',
                        timer: 1500,
                        type: "error",
                    }).then(
                        function() {},
                        function(dismiss) {
                            if (dismiss === 'timer') {

                            }
                        }
                    )
                } else {
                    $.ajax({
                        url: 'members/update',
                        //url: 'member-update',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $('.send-loading').show();
                        },
                        success: function(response) {
                            console.log('Member update submitting success...');
                            $('.send-loading').hide();
                            swal({
                                title: 'Success!',
                                text: 'Successfully Updated',
                                timer: 1500,
                                type: "success",
                            }).then(
                                function() {},
                                function(dismiss) {
                                    if (dismiss === 'timer') {
                                        window.location.href = 'members';
                                    }
                                }
                            )

                        },
                        error: function(error) {
                            console.log('Member update submitting error...');
                            console.log(error);
                            console.log(error.responseJSON.message);
                            $('.send-loading').hide();
                            swal({
                                title: 'Error!',
                                text: "Error Msg: " + error.responseJSON.message + "",
                                timer: 1500,
                                type: "error",
                            }).then(
                                function() {},
                                function(dismiss) {}
                            )

                        }
                    });
                }
            })


            $('body').on('click', '.modifyUser', function(event) {
                if (!confirm("Do you really want to do this?")) {
                    return false;
                }
                event.preventDefault();
                console.log('Member Modify submitting...');
                var formData = new FormData();
                formData.append("id", $(this).data('id'));
                formData.append('_token', token);

                $.ajax({
                    url: 'members/modify',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.send-loading').show();
                    },
                    success: function(response) {
                        console.log('Member Modify submitting success...');
                        $('.send-loading').hide();
                        swal({
                            title: 'Success!',
                            text: 'Successfully Modified',
                            timer: 1500,
                            type: "success",
                        }).then(
                            function() {},
                            function(dismiss) {
                                if (dismiss === 'timer') {
                                    window.location.href = 'members';
                                }
                            }
                        )

                    },
                    error: function(error) {
                        console.log('Member Modify submitting error...');
                        console.log(error);
                        console.log(error.responseJSON.message);
                        $('.send-loading').hide();
                        swal({
                            title: 'Error!',
                            text: "Error Msg: " + error.responseJSON.message + "",
                            timer: 1500,
                            type: "error",
                        }).then(
                            function() {},
                            function(dismiss) {
                                if (dismiss === 'timer') {

                                }
                            }
                        )
                    }
                });
            })
        });


        $(document).ready(function() {
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
