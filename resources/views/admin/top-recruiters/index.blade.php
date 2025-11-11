@extends('layouts.default.admin.master')
@section('title', 'Top Recruiters')
@section('stylesheets')
    <style>
        .border-red {
            border: 1px solid red !important;
        }

        #sales-group td {
            text-transform: capitalize !important;
        }
    </style>
@endsection

@section('content')
    <div class="content-body">
        <!-- start content- -->
        <div class="content">
            <div class="card">
                <!-- <h6 class="element-header">Data Tables</h6> -->
                <div class="">
                    <div class="row">
                        <div class="col-md-12">
                            <br>
                            <h5 class="text-center">@yield('title')</h5><br>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" id="form_id">
                            @csrf
                            <div class="row">
                                <div class="offset-md-4 col-md-3">
                                    <div class="form-group">
                                        <label>From</label>
                                        <input type="date" class="form-control date-picker" name="date_start"
                                            id="date_start" placeholder="Date" aria-label="Date"
                                            aria-describedby="basic-addon2" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="To">To</label>
                                        <input type="date" class="form-control date-picker" name="date_end"
                                            id="date_end" placeholder="Date" aria-label="Date"
                                            aria-describedby="basic-addon2" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <br>
                                    <button class="btn btn-primary btn-lg" id="search-button" name="search-button"
                                        type="submit">Search</button>
                                    <button type="button" class="btn btn-danger btn-lg" id="clearDates">Clear</button>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive border-bottom">
                            <table class="table thead-border-top-0" id="sales-table" style="width:100% !important">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>Username</th>
                                        <th>Name</th>
                                        <th>Recruits</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody id="recruits-group">
                                    @if (!empty($recuiters))
                                        @foreach ($recuiters as $key => $recuit)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $recuit->username }}</td>
                                                <td>{{ $recuit->full_name }}</td>
                                                <td>{{ $recuit->total }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-outline-info btn-view"
                                                        data-user_id="{{ $recuit->user_id }}">View</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.top-recruiters.view_modal')
    <!-- end content-i -->
@endsection

@section('scripts')
    <!-- Sweetalert -->

    <script src="{{ asset('js/admin/members.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#clearDates').on('click', function() {
                $('#date_start').val('');
                $('#date_end').val('');
                location.reload();
            });

            $('#sales-table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

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

            $('body').on('submit', '#form_id', function(event) {
                event.preventDefault();
                var formData = new FormData();
                formData.append("date_start", $('#date_start').val());
                formData.append("date_end", $('#date_end').val());
                formData.append('_token', token);
                $.ajax({
                    url: "{{ route('search-top-recuiters') }}",
                    type: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $('.preloader').show();
                        $("#recruits-group").empty();
                    },
                    success: function(data) {
                        console.log('Search submitting success...');
                        $('.preloader').hide();

                        if (data.recuiters == '') {
                            var newTextBoxDiv = $(document.createElement('tr'));
                            newTextBoxDiv.after().html(
                                "<td colspan='5' class='text-center'>No Data</td></tr>");
                            newTextBoxDiv.appendTo("#recruits-group");
                        } else {
                            $.each(data.recuiters, function(i, value) {
                                var newTextBoxDiv = $(document.createElement('tr'))
                                    .attr("id", 'product_id' + [i + 1], "class", 'item')
                                    .attr("class", 'item');
                                newTextBoxDiv.after().html("<td>#" + [i + 1] + "</td>" +
                                    "<td>" + value.username + "</td>" +
                                    "<td>" + value.full_name + "</td>" +
                                    "<td>" + value.total + "</td>" +
                                    "<td><button class='btn btn-primary btn-view' data-user_id='" +
                                    value.user_id + "'>View</button></td>" +
                                    "</tr>");
                                newTextBoxDiv.appendTo("#recruits-group");
                            });
                        }
                    },
                    error: function(error) {
                        console.log('Search submitting error...');
                        console.log(error);
                        console.log(error.responseJSON.message);
                        $('.preloader').hide();
                        swal({
                            title: 'Error!',
                            text: "Error Msg: " + error.responseJSON.message + "",
                            //timer: 1500,
                            type: "error",
                        })
                    }
                });
            });


            $('body').on('click', '.btn-view', function() {
                var user_id = $(this).data('user_id');
                var date_start = $('#date_start').val();
                var date_end = $('#date_end').val();

                var formData = new FormData();
                formData.append("user_id", user_id);
                formData.append("date_start", date_start);
                formData.append("date_end", date_end);
                formData.append('_token', token);

                $.ajax({
                    url: "{{ route('view-top-recruiter') }}",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $('.preloader').show();
                        $('#view-recruits-group').empty();
                    },
                    success: function(data) {
                        $('.preloader').hide();
                        $('.username').html(data.user.username);
                        $('#full_name').html(data.user.full_name);
                        $('#date_range').html(data.date_range ?? 'All');

                        if (data.recruits.length === 0) {
                            $('#view-recruits-group').html(
                                "<tr><td colspan='3' class='text-center'>No Data</td></tr>");
                        } else {
                            var recruitsHtml = '';
                            $.each(data.recruits, function(i, value) {
                                var createdDate = new Date(value.created_at);
                                var formattedDate = createdDate.toLocaleString();

                                recruitsHtml += "<tr>" +
                                    "<td>" + value.username + "</td>" +
                                    "<td>" + value.full_name + "</td>" +
                                    "<td>" + formattedDate + "</td>" +
                                    "</tr>";
                            });

                            $('#view-recruits-group').html(recruitsHtml);
                        }

                        $('#view-modal').modal('show');
                    },
                    error: function(error) {
                        console.log('Error...');
                        console.log(error);
                        console.log(error.responseJSON.message);
                        $('.preloader').hide();
                        swal({
                            title: "Error!",
                            text: "Error message: " + error.responseJSON.message + "",
                            type: "error",
                        });
                    }
                });
            });

        });
    </script>
@endsection
