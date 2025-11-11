@extends('layouts.default.admin.master')
@section('title',"Data Checker")
@section('page-title','Data Checker')

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
                                <label for="submit-btn" class="col-form-label">Action</label><br>
                                <button class="btn btn-primary" type="submit" id="submit-btn">Load Data</button>
                            </div>
                        </div>
                    </div>
                </form>


            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-center">Flush out Data</h6>
                <table id="flush_history" width="100%" class="table table-striped table-lightfont">
                    <thead>
                        <tr>
                            <th>Pv Point Flush Out</th>
                            <th>position</th>
                            <th>Sponsor</th>
                            <th>state</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Pv Point Flush Out</th>
                            <th>position</th>
                            <th>Sponsor</th>
                            <th>state</th>
                            <th>Date</th>

                        </tr>
                    </tfoot>
                    <tbody id="flush_data">
                    
                    </tbody>
                </table>
            </div>
        </div>


          <div class="card">
            <div class="card-body">
                <h6 class="card-title text-center">Pv History Data</h6>
                <table id="pv_points_table_history" width="100%" class="table table-striped table-lightfont">
                    <thead>
                        <tr>
                            <th>pv_point</th>
                            <th>position</th>
                            <th>sponsor</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>pv_point</th>
                            <th>position</th>
                            <th>sponsor</th>
                            <th>Date</th>

                        </tr>
                    </tfoot>
                    <tbody id="pv_data">
                   
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

        $('#flush_history').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

         $('#pv_points_table_history').DataTable({
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
            console.log('Data Checker');
            var username = $("#username").val();
            var formData = new FormData();
            formData.append("username", username);
            formData.append('_token', token);
            
            $.ajax({
                url: 'get-data-checker',
                type: 'POST',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    //  $('.send-loading').show();
                },
                success: function(response) {
                    $('#flush_history tbody').empty();
                    $( "#flush_data" ).append(response[1].Flushout_array);


                    $('#pv_points_table_history tbody').empty();
                    $( "#pv_data" ).append(response[0].PvPointsHistory);

                    
                    
                },
                error: function(error) {
                    console.log('Checker Data');
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
