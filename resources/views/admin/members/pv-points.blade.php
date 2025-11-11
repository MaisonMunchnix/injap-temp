@extends('layouts.default.admin.master')
@section('title',"Binary Points Adjustment Facility")
@section('page-title','Binary Points Adjustment Facility')

@section('stylesheets')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css">

<link rel="stylesheet" href="https://raw.githack.com/ttskch/select2-bootstrap4-theme/master/dist/select2-bootstrap4.css">
<style>
    .border-red {
        border: 1px solid red !important;
    }

    .select2-container--default .select2-selection--single {
        height: calc(1.5em + .75rem + 3px) !important;
        border-radius: 0.5rem !important;
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
                <form action="" id="pv_updates_data" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="pvLeft" class="col-form-label">Username *</label>
                                <select class="form-control" name="username" id="username" required>
                                    <option value="">Select Username</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="pvLeft" class="col-form-label">PV Left *</label>
                                <input class="form-control" placeholder="0" id="pvLeft" name="pvLeft" type="number" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="pvRight" class="col-form-label">PV Right *</label>
                                <input class="form-control" placeholder="0" id="pvRight" name="pvRight" type="number" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="submit-btn" class="col-form-label">Action</label><br>
                                <button class="btn btn-primary" type="submit" id="submit-btn">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>


            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-center">@yield('title') History</h6>
                <table id="pv_points_table" width="100%" class="table table-striped table-lightfont">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Pv point old</th>
                            <th>Position Change</th>
                            <th>PV New Value</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Username</th>
                            <th>Pv point old</th>
                            <th>Position Change</th>
                            <th>PV New Value</th>
                            <th>Date</th>

                        </tr>
                    </tfoot>
                    <tbody>
                        @if(!empty($PvPointEdit))
                        @foreach($PvPointEdit as $PvPointEdit)
                        <tr class="text-capitalize">
                            <td>{{ $PvPointEdit->Username }}</td>
                            <td>{{ $PvPointEdit->pv_point_old }}</td>
                            <td>{{ $PvPointEdit->position }}</td>
                            <td>{{ $PvPointEdit->new_value }}</td>
                            <td>{{ $PvPointEdit->created_at }}</td>

                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('admin.members.edit-modal')
@include('admin.members.edit-password-modal')
<!-- end content-i -->
@endsection

@section('scripts')
<!-- Sweetalert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    $(document).ready(function() {

        $('#pv_points_table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

        $('#username').select2({
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

        $("#username").change(function() {
            var username = $("#username").val();

            var formData = new FormData();
            formData.append("username", username);
            formData.append('_token', token);

            $.ajax({
                url: 'get-pv-points',
                type: 'POST',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('.send-loading').show();
                },
                success: function(response) {
                    if (response.rightpart == 0) {
                        $('#pvLeft').prop('disabled', false);
                        $('#pvRight').prop('disabled', true);
                    } else {
                        $('#pvLeft').prop('disabled', true);
                        $('#pvRight').prop('disabled', false);
                    }
                    $("#pvLeft").val(response.leftpart);
                    $("#pvRight").val(response.rightpart);
                },
                error: function(error) {

                }
            });
        });



        $('body').on('submit', '#pv_updates_data', function(event) {
            event.preventDefault();
            console.log('Product update submitting...');
            $.ajax({
                url: 'update-pv-points',
                type: 'POST',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    //  $('.send-loading').show();
                },
                success: function(response) {
                    //$('.send-loading').hide();
                    swal({
                        title: 'Success!',
                        text: 'Successfully Updated',
                        timer: 1500,
                        type: "success",
                    }, function() {
                        window.location.reload();
                    });

                },
                error: function(error) {
                    console.log('Product update submitting error...');
                    console.log(error);
                    console.log(error.responseJSON.message);
                    $('.send-loading').hide();
                    swal({
                        title: 'Error!',
                        text: "Error Msg: " + error.responseJSON.message + "",
                        timer: 1500,
                        type: "error",
                    })
                }
            });
        });

    });

</script>
@endsection
