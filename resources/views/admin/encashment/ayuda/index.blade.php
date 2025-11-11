@extends('layouts.default.admin.master')

@section('title', 'Encashment List')

@section('page-title', 'Encashment List')



@section('stylesheets')

    {{-- additional style here --}}

    <style>
        .border-red {

            border: 1px solid red !important;

        }
    </style>

@endsection



@section('content')

    {{-- content here --}}





    <div class="content-body">

        <div class="content">

            <div class="card">

                <!--START - Transactions Table-->

                <div class="card-body">

                    <!-- <h6 class="element-header text-center">Encashment List</h6><br> -->

                    <div class="">



                        <h5 class="form-header text-center text-capitalize" id="title-encash">
                            @if (!empty($type))
                                {{ $type }}
                            @endif Encashment
                        </h5><br><br>

                        <div class="row">
                            <div class="col-md-6">
                                <label>Encashment Filter</label><br>
                                <div class="btn-group mr-1 mb-1">
                                    <button aria-expanded="false" aria-haspopup="true"
                                        class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="view_by"
                                        type="button">View encashment by</button>
                                    <div aria-labelledby="view_by" class="dropdown-menu">
                                        <a class="dropdown-item filter-by @if ($type == 'all') active @endif"
                                            href="#" data-type="all"> All Encashment</a>
                                        <a class="dropdown-item filter-by @if ($type == 'pending') active @endif"
                                            href="#" data-type="pending"> Pending</a>
                                        <a class="dropdown-item filter-by @if ($type == 'hold') active @endif"
                                            href="#" data-type="hold"> Hold</a>
                                        <a class="dropdown-item filter-by @if ($type == 'decline') active @endif"
                                            href="#" data-type="decline"> Declined</a>
                                        <a class="dropdown-item filter-by @if ($type == 'approved') active @endif"
                                            href="#" data-type="approved"> Approved</a>
                                        <a class="dropdown-item filter-by @if ($type == 'claimed') active @endif"
                                            href="#" data-type="claimed"> Claimed</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <form action="" method="post" id="sales-form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>From</label>
                                                <input type="date" class="form-control date-picker" name="date_start"
                                                    id="date_start" placeholder="Date" aria-label="Date"
                                                    aria-describedby="basic-addon2" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="To">To</label>
                                                <input type="date" class="form-control date-picker" name="date_end"
                                                    id="date_end" placeholder="Date" aria-label="Date"
                                                    aria-describedby="basic-addon2" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <br>
                                                <button class="btn btn-primary btn-block" id="search-button"
                                                    name="search-button" type="submit">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive">



                            <table id="encashment_table" width="100%" class="table table-striped table-lightfont">
                                <thead>
                                    <tr>
                                        <th>Date Requested</th>
                                        <th>Amount Requested</th>
                                        <th>Amount Approved</th>
                                        <th>Username</th>
                                        <th>Last Name</th>
                                        <th>First Name</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Date Requested</th>
                                        <th>Amount Requested</th>
                                        <th>Amount Approved</th>
                                        <th>Username</th>
                                        <th>Last Name</th>
                                        <th>First Name</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @include('user.customizer')
            @include('admin.encashment.approve_modal')
            @include('admin.encashment.claim_modal')
            @include('admin.encashment.decline_modal')
            @include('admin.encashment.hold_modal')
            @include('admin.encashment.view_modal')
        </div>
    </div>

@endsection



@section('scripts')

    {{-- additional scripts here --}}

    <script>
        var filter_type = "{{ $type }}";
    </script>

    <script src="{{ asset('js/admin/admin-encashment.js?v=2') }}"></script>
    <script>
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
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                    'month')]
            }
        }, cb);

        cb(start, end);

        /* $('body').on('submit', '#sales-form', function(event) {
             event.preventDefault();
             var type = $(this).data('type');
             var formData = new FormData();
             var date_start = $('#date_start').val();
             var date_end = $('#date_end').val();
             formData.append("date_start", date_start);
             formData.append("date_end", date_end);
             formData.append("type", type);
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
                     url: "../encashment-view/" + type,
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

                         if (data.users == '') {
                             var newTextBoxDiv = $(document.createElement('tr'));
                             newTextBoxDiv.after().html("<td colspan='5' class='text-center'>No Data</td></tr>");
                             newTextBoxDiv.appendTo("#table-group");
                         } else {
                             $.each(data.users, function(i, value) {
                                 var total_referrals = value.total_referrals;
                                 var total_unilevel_sales = value.total_unilevel_sales;

                                 if (total_referrals == '' || total_referrals == null) {
                                     total_referrals = 0;
                                 }
                                 if (total_unilevel_sales == '' || total_unilevel_sales == null) {
                                     total_unilevel_sales = 0;
                                 }

                                 if (isNaN(total_referrals)) {
                                     return 0;
                                 }
                                 if (isNaN(total_unilevel_sales)) {
                                     return 0;
                                 }

                                 total = parseFloat(total_referrals) + parseFloat(total_unilevel_sales);

                                 if (total > 0) {
                                     var newTextBoxDiv = $(document.createElement('tr')).attr("id", 'product_id' + [i + 1], "class", 'item').attr("class", 'item');
                                     newTextBoxDiv.after().html("<td>#" + [i + 1] + "</td>" +
                                         "<td>" + value.username + "</td>" +
                                         "<td>" + value.full_name + "</td>" +
                                         "<td>" + value.rank_type + "</td>" +
                                         "<td>" + parseFloat(total) + "</td>" +
                                         "<td><button class='btn btn-primary btn-view' data-id='" + value.user_id + "'>View</button></td>" +
                                         "</tr>");
                                     newTextBoxDiv.appendTo("#table-group");
                                 }

                             });
                             if (total == 0) {
                                 var newTextBoxDiv = $(document.createElement('tr'));
                                 newTextBoxDiv.after().html("<td colspan='5' class='text-center'>No Data</td></tr>");
                                 newTextBoxDiv.appendTo("#table-group");
                             }


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
             }

         });*/
    </script>
@endsection
