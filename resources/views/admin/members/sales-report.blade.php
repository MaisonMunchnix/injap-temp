@extends('layouts.user.master')
@section('title', 'Sales Report')
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
                        <div class="col-md-12">
                            <h6 class="element-header">@yield('title')</h6>
                        </div>
                        <!--<div class="col-md-6">
          <a class="btn btn-primary pull-right" data-target="#add-modal" data-toggle="modal" href="#"><i class="os-icon os-icon-ui-22"></i><span> User</span></a>
         </div>-->
                    </div>
                    <div class="card-body">
                        <form action="" method="post" id="sales-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="reportrange">Date</label>
                                        <input type="text" id="reportrange" class="form-control" name="reportrange"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Performance Type:</label>
                                        <select class="form-control" name="type" id="type">
                                            <option value="" selected disabled>Select Performance Type</option>
                                            <option value="sales">Sales</option>
                                            <option value="recruit">Recruit</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Filter By:</label>
                                        <select class="form-control" name="filter_by" id="filter_by">
                                            <option value="" selected disabled>Select Filter</option>
                                            <option value="personal">Personal</option>
                                            <option value="group">Group</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <br>
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" id="search-button"
                                            name="search-button">Search</button>
                                    </div>
                                </div>
                            </div>

                            <!--
                                    <div id="" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                        <i class="fa fa-calendar"></i>&nbsp;
                                        <span></span> <i class="fa fa-caret-down"></i>
                                    </div>
    -->
                        </form>


                        <div class="table-responsive border-bottom">
                            <table class="table thead-border-top-0" id="sales-table" style="width:100% !important">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>Username</th>
                                        <th>Name</th>
                                        <th>Performance Value</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Rank</th>
                                        <th>Username</th>
                                        <th>Name</th>
                                        <th>Performance Value</th>
                                        <th>Details</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if (!empty($sales))
                                        @foreach ($sales as $key => $sale)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $sale->username }}</td>
                                                <td>{{ $sale->full_name }}</td>
                                                <td>{{ number_format($sale->total, 2, '.', ',') }}</td>
                                                <td>
                                                    <button class="btn btn-primary">View</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    <tr>

                                    </tr>
                                </tbody>
                            </table>
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
            var start = moment();
            var end = moment();


            function cb(start, end) {
                $('#reportrange span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));

            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                }
            }, cb);

            cb(start, end);

            $('body').on('submit', '#sales-form', function(event) {
                event.preventDefault();
                console.log('Search submitting...');

                console.log(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                var formData = new FormData();
                formData.append("reportrange", $('#reportrange').val(start.format('YYYY-MM-DD') + ' - ' +
                    end.format('YYYY-MM-DD')));
                formData.append("type", $('#type').val());
                formData.append("filter_by", $('#filter_by').val());
                formData.append('_token', token);
                $.ajax({
                    url: "{{ route('search-sales-report') }}",
                    type: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $('.send-loading').show();
                    },
                    success: function(response) {
                        console.log('Search submitting success...');
                        $('.send-loading').hide();
                        /* swal({
                             title: 'Success!',
                             text: 'Successfully Added',
                             timer: 1500,
                             type: "success",
                         }, function() {
                             window.location.href = 'sales-report';
                         });*/

                    },
                    error: function(error) {
                        console.log('Search submitting error...');
                        console.log(error);
                        console.log(error.responseJSON.message);
                        $('.send-loading').hide();
                        swal({
                            title: 'Error!',
                            text: "Error Msg: " + error.responseJSON.message + "",
                            //timer: 1500,
                            type: "error",
                        })
                    }
                });
            });

        });
    </script>
@endsection
