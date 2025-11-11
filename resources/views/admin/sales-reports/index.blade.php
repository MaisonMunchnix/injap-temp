@extends('layouts.default.admin.master')
@section('title','Sales Reports')

@section('stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
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
        <div class="">

            <div class="card">
                <div class="row">
                    <div class="col-md-12">
                        <br />
                        <h5 class="element-header text-center">Sales Reports</h5><br />
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive border-bottom">
                        <form action="" method="post" id="sales-form">
                            @csrf
                            <div class="row">
                                <div class="offset-md-4 col-md-3">
                                    <div class="form-group">
                                        <label>From</label>
                                        <input type="date" class="form-control date-picker" name="date_start" placeholder="Date" aria-label="Date" aria-describedby="basic-addon2" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="To">To</label>
                                        <input type="date" class="form-control date-picker" name="date_end" placeholder="Date" aria-label="Date" aria-describedby="basic-addon2" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <br>
                                        <button class="btn btn-primary btn-block btn-lg" id="search-button" name="search-button" type="submit">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <table class="table thead-border-top-0" id="sales-table" style="width:100% !important">
                            <thead>
                                <tr>

                                    <th>Receipt #</th>
                                    <th>Type</th>
                                    <th>Name</th>
                                    <!--<th>Discount</th>-->
                                    <!-- <th>Fees</th> -->
                                    <th>Total</th>
                                    <!--<th>Order Status</th>-->
                                    <th>Transaction Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Receipt #</th>
                                    <th>Type</th>
                                    <th>Name</th>
                                    <!--<th>Discount</th>-->
                                    <!-- <th>Fees</th> -->
                                    <th>Total</th>
                                    <!--<th>Order Status</th>-->
                                    <th>Transaction Date</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody id="table-group">
                                @foreach($sales as $sale)
                                <tr>
                                   
                                   @php
                                   if($sale->user_id == ''){
                                       $name = $sale->full_name;
                                       $type = "Non Member";
                                   } else {
                                       $name = $sale->first_name . ' ' . $sale->last_name;
                                       $type = "Member";
                                   }
                                   
                                   
                                   if($sale->products_released == 0){
                                   $released = "Pending";
                                   } else {
                                   $released = "Released";
                                   }
                                   
                                   @endphp
                                    
                                    <td>{{ $sale->confirmation_number }}</td>
                                    <td>{{ $type }}</td>
                                    <td>{{ $name }}</td>
                                    <!--<td>P{{ number_format($sale->discount, 2) }}</td>-->
                                   <!--  <td>P{{ number_format($sale->fees, 2) }}</td> -->
                                    <td>P{{ number_format($sale->total, 2) }}</td>
                                    <!--<td>{{ $released }}</td>-->
                                    <td>{{ $sale->created_at }}</td>
                                    <td><a href="{{ route('admin.new-transaction.export', $sale->id) }}" class="btn btn-primary">Export</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('TellerSystem.order_management.view_modal')
</div>
<!-- end content-i -->
@endsection

@section('scripts')
<!-- Sweetalert -->

<script src="{{asset('js/admin/members.js')}}"></script>

<script>
    $(document).ready(function() {
        $('#sales-table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            columnDefs: [ { type: 'date', 'targets': [4] } ],
            "order": [[ 4, "desc" ]]
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
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
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
                    url: "{{ route('search-sales-report') }}",
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

                        if (data.sales == '') {
                            var newTextBoxDiv = $(document.createElement('tr'));
                            newTextBoxDiv.after().html("<td colspan='9' class='text-center'>No Data</td></tr>");
                            newTextBoxDiv.appendTo("#table-group");
                        } else {
                            $.each(data.sales, function(i, value) {
                                /*var total_referrals = value.total_referrals;
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

                                total = parseFloat(total_referrals) + parseFloat(total_unilevel_sales);*/
                                //if (total > 0) {
                                if (value.user_id==null) {
                                    var member_type = 'Non Member';
                                    //var name = value.first_name;
                                } else {
                                    var member_type = 'Member';
                                    //var name = value.full_name;
                                }
                                
                                if(value.full_name == null){
                                    if(value.first_name == null){
                                        var name = "N/A";
                                    } else {
                                        var name = value.first_name + ' ' + value.last_name;
                                    }
                                    
                                } else {
                                    var name = value.full_name;
                                }
                                
                                /*if (value.is_paid == 0) {
                                    var is_paid = 'No';
                                } else {
                                    var is_paid = 'Yes';
                                }*/
                                /*if (value.products_released > 0) {
                                    var released = 'Released';
                                } else {
                                    var released = 'Pending';
                                }*/
                                var newTextBoxDiv = $(document.createElement('tr')).attr("id", 'product_id' + [i + 1], "class", 'item').attr("class", 'item');
                                newTextBoxDiv.after().html("<td>" + value.confirmation_number + "</td>" +
                                    "<td>" + member_type + "</td>" +
                                    "<td>" + name + "</td>" +
                                    //"<td>" + value.discount + "</td>" +
                                    "<td>" + value.fees + "</td>" +
                                    "<td>" + value.total + "</td>" +
                                    /*"<td>" + is_paid + "</td>" +*/
                                    //"<td>" + released + "</td>" +
                                    "<td>" + value.updated_at + "</td>" +
                                    "</tr>");
                                newTextBoxDiv.appendTo("#table-group");
                                //}

                            });
                            /* if (total == 0) {
                                 var newTextBoxDiv = $(document.createElement('tr'));
                                 newTextBoxDiv.after().html("<td colspan='5' class='text-center'>No Data</td></tr>");
                                 newTextBoxDiv.appendTo("#table-group");
                             }*/


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

        });

    });

</script>
@endsection
