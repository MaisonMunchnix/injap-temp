@extends('layouts.default.admin.master')
@section('title', 'Top Earners')
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
                            <h5 class="text-center">Top Earners</h5><br>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" id="sales-form">
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
                                    <div class="form-group">
                                        <br>
                                        <button class="btn btn-primary btn-lg" id="search-button" name="search-button"
                                            type="submit">Search</button>
                                        <button type="button" class="btn btn-danger btn-lg" id="clearDates">Clear</button>
                                    </div>
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
                                        <th>Package</th>
                                        <th>Performance Value</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody id="table-group">
                                    @if (!empty($users))
                                        @foreach ($users as $key => $user)
                                            @php
                                                $total = $user->total_referrals;
                                            @endphp
                                            @if ($total > 0)
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td>{{ $user->username }}</td>
                                                    <td>{{ $user->full_name }}</td>
                                                    <td>{{ $user->rank_type }}</td>
                                                    <td>{{ number_format($total, 2, '.', ',') }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-outline-info btn-view"
                                                            data-user_id="{{ $user->user_id }}">View</button>
                                                    </td>
                                                </tr>
                                            @endif
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
    @include('admin.top-earners.view_modal')
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
                "bPaginate": false,
                "dom": 'lrtip',
                "dom": 'Bfrtip',
                "buttons": [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                "columns": [{
                        "orderable": false
                    },
                    {
                        "orderable": false
                    },
                    {
                        "orderable": false
                    },
                    {
                        "orderable": false
                    },
                    {
                        "orderable": false
                    },
                    {
                        "orderable": false
                    },
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

            $('body').on('submit', '#sales-form', function(event) {
                event.preventDefault();
                var formData = new FormData();
                var date_start = $('#date_start').val();
                var date_end = $('#date_end').val();
                formData.append("date_start", date_start);
                formData.append("date_end", date_end);
                //formData.append("filter_by", $('#filter_by :selected').val());
                formData.append('_token', token);
                if (date_start > date_end) {
                    swal({
                        title: 'Error!',
                        text: "Ending Date cannot be earlier than Starting Date!",
                        timer: 1500,
                        type: "error",
                    })
                } else {
                    $.ajax({
                        url: "{{ route('search-top-earners') }}",
                        type: 'POST',
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            $('.preloader').show();
                            $("#table-group").empty();
                        },
                        success: function(data) {
                            console.log('Search submitting success...');
                            $('.preloader').hide();
                            var total = 0;
                            var count = 1;

                            if (data.users == '') {
                                var newTextBoxDiv = $(document.createElement('tr'));
                                newTextBoxDiv.after().html(
                                    "<td colspan='5' class='text-center'>No Data</td></tr>");
                                newTextBoxDiv.appendTo("#table-group");
                            } else {
                                $.each(data.users, function(i, value) {
                                    var total_referrals = value.total_referrals;
                                    var total_unilevel_sales = value
                                        .total_unilevel_sales;

                                    if (total_referrals == '' || total_referrals ==
                                        null) {
                                        total_referrals = 0;
                                    }

                                    if (isNaN(total_referrals)) {
                                        return 0;
                                    }

                                    total = parseFloat(total_referrals);

                                    if (total > 0) {
                                        var newTextBoxDiv = $(document.createElement(
                                            'tr')).attr("class", 'item');
                                        newTextBoxDiv.after().html("<td>#" + count +
                                            "</td>" +
                                            "<td>" + value.username + "</td>" +
                                            "<td>" + value.full_name + "</td>" +
                                            "<td>" + value.rank_type + "</td>" +
                                            "<td>" + parseFloat(total) + "</td>" +
                                            "<td><button class='btn btn-primary btn-view' data-user_id='" +
                                            value.user_id + "'>View</button></td>" +
                                            "</tr>");
                                        count++;
                                        newTextBoxDiv.appendTo("#table-group");
                                    }

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
                                timer: 1000,
                                type: "error",
                            })
                        }
                    });
                }

            });


            $('body').on('click', '.btn-view', function() {
                var user_id = $(this).data('user_id');
                var salesGroup = $('#sales-group');
                var preloader = $('.preloader');
                var date_start = $('#date_start').val();
                var date_end = $('#date_end').val();

                var formData = new FormData();
                formData.append("user_id", user_id);
                formData.append("date_start", date_start);
                formData.append("date_end", date_end);
                formData.append('_token', token);

                $.ajax({
                    url: "{{ route('view-top-earner') }}",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        preloader.show();
                        salesGroup.empty();
                    },
                    success: function(data) {
                        preloader.hide();
                        updateSalesData(data);
                    },
                    error: function(error) {
                        handleAjaxError(error);
                    }
                });

                function updateSalesData(data) {
                    var username = $('#username');
                    var fullName = $('#full_name');
                    var dateRange = $('#date_range');
                    var totalReferrals = 0;
                    var totalUniLevel = 0;

                    salesGroup.empty();

                    $.each(data.referrals, function(i, value) {
                        var createdDate = new Date(value.created_at);
                        var formattedDate = createdDate.toISOString().slice(0, 19).replace("T",
                            " ");
                        appendSalesRow(value.referral_type, value.amount, formattedDate);
                        totalReferrals += parseFloat(value.amount);
                    });

                    $.each(data.uni_levels, function(i, value) {
                        var createdDate = new Date(value.created_at);
                        var formattedDate = createdDate.toISOString().slice(0, 19).replace("T",
                            " ");
                        appendSalesRow('Unilevel Sales', value.total_price, formattedDate);
                        totalUniLevel += parseFloat(value.total_price);
                    });


                    var total = totalReferrals + totalUniLevel;
                    var formattedTotal = total.toLocaleString('en-PH', {
                        style: 'currency',
                        currency: 'PHP'
                    });

                    $('#total').html(formattedTotal);

                    username.html(data.user.username);
                    fullName.html(data.user.full_name);
                    dateRange.html(data.date_range ?? 'All');

                    $('#view-modal').modal('show');
                }

                function appendSalesRow(referralType, amount, created_at) {
                    var formattedAmount = amount.toLocaleString('en-PH', {
                        style: 'currency',
                        currency: 'PHP'
                    });

                    var newRow = $('<tr>').addClass('row');
                    newRow.html(
                        "<td class='col-md-4'>" + referralType.replace(/_/g, ' ') + "</td>" +
                        "<td class='col-md-4'>" + formattedAmount + "</td>" +
                        "<td class='col-md-4'>" + created_at + "</td>"
                    );
                    newRow.appendTo(salesGroup);
                }


                function handleAjaxError(error) {
                    console.log('Error...');
                    console.log(error);
                    console.log(error.responseJSON.message);
                    preloader.hide();
                    swal({
                        title: "Error!",
                        text: "Error message: " + error.responseJSON.message + "",
                        type: "error",
                    });
                }
            });
        });
    </script>
@endsection
