@extends('layouts.default.admin.master')
@section('title',"Delete Member")
@section('page-title','Delete Member')

@section('stylesheets')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
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
                <h6 class="card-title">@yield('title')</h6>
                <form method="POST" action="" class="delete-form" id="delete-form">
                    @csrf
                    <div class="form-group required">
                        <select class="username" name="username[]" id="username" multiple="multiple" required>
                            <option value="">Select Username</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger" id="delete-btn">Delete</button>
                    </div>
                </form>
                <div id="status">

                </div>
                <div class="row">
                    <div class="col-md-6" id="deleted"></div>
                    <div class="col-md-6" id="not_deleted"></div>
                </div>
                <table id="table-username" class="table table-bordered table-striped table-hover" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="member_body">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- end content-i -->
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.username').select2({
            minimumInputLength: 2, // only start searching when the user has input 3 or more characters
            ajax: {
                url: "{{ route('select-members') }}",
                processResults: function(data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data.results
                    };
                }
            }
        });
        
        $('#table-username').DataTable();


        $('body').on('submit', '#delete-form', function(e) {
            e.preventDefault();
            $('.sweetalert .text-muted').remove();
            var form_data = new FormData(this);
            console.log('Delete ID: ' + form_data);

            form_data.append('_token', token);
            $.ajax({
                url: "{{ route('multi-member-delete') }}",
                type: 'POST',
                data: form_data,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#global-loader').show();
                    $('#member_body').html('');
                },
                success: function(response) {
                    $('#global-loader').hide();
                    /*swal({
                            title: "Success!",
                            text: "Commented successfully.",
                            type: "success",
                        },
                        function() {
                            location.reload();
                        });*/
                    var markup = '';
                    var counter = 0;
                    var deleted = 0;
                    var not_deleted = 0;

                    $.each(response.data, function(key, value) {
                        counter++;
                        markup += "<tr>" +
                            "<td>" + counter + "</td>" +
                            "<td>" + value.user_id + "</td>" +
                            "<td>" + value.username + "</td>" +
                            "<td>" + value.status + "</td>" +
                            "</tr>";
                        if (value.status == 'Have Downline') {
                            not_deleted++;
                        } else {
                            deleted++;
                        }
                    });
                    $('#deleted').html('Deleted: ' + deleted);
                    $('#not_deleted').html("Can't Delete: " + not_deleted);
                    $('#member_body').html(markup);
                },
                error: function(error) {
                    $('#global-loader').hide();
                    var error_message = error.responseJSON.message;
                    if (error_message == 'duplicate') {
                        swal({
                            title: "Warning!",
                            text: "Comments already Exist!",
                            type: "warning",
                        });
                    } else if (error_message == 'empty_fields') {
                        swal({
                            title: "Warning!",
                            text: "Please check for required empty field/s!",
                            type: "warning",
                        });
                    } else {
                        swal({
                            title: "Warning!",
                            text: "Error Message: " + error_message,
                            type: "warning",
                        });
                    }

                }
            });
        });
    });

</script>
<script src="{{asset('js/admin/members.js')}}"></script>
@endsection
