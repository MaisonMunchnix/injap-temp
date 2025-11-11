@extends('layouts.default.admin.master')

@section('title','Redeem List')

@section('page-title','Redeem')

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
            <div class="card-body">
                <!-- <h6 class="element-header text-center">Encashment List</h6><br> -->
                <div class="">
                    <h5 class="form-header text-center text-capitalize" id="title-encash">Redeem Transaction</h5><br><br>
                    <div class="table-responsive">
                        <table id="encashment_table" width="100%" class="table table-striped table-lightfont">
                            <thead>
                                <tr>
                                    <th>Redeem Name</th>
                                    <th>Points</th>
                                    <th>Username</th>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>Remark</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.redeem.modal.view')
        @include('admin.redeem.modal.remark')
    </div>

</div>



@endsection



@section('scripts')

{{-- additional scripts here --}}

<script>
    var filter_type = "all";
    var encashment_tax = "{{env('ENCASHMENT_TAX')}}";
    var processing_fee = "{{env('PROCESSING_FEE')}}";

</script>

<script>
    var process_redeem = "{{route('redeem.process')}}";

    $(document).ready(function() {

        $('#encashment_table').DataTable({
            "order": [
                [7, "desc"]
            ],
            processing: true,
            serverSide: true,
            responsive: true,
            "ajax": {
                "url": "{{ route('redeem.get-data') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: token
                }
            },
            "columns": [{
                    "data": "name"
                },
                {
                    "data": "points"
                },
                {
                    "data": "username"
                },
                {
                    "data": "first_name"
                },
                {
                    "data": "last_name"
                },
                {
                    "data": "remark"
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "status"
                },
                {
                    "data": "action",
                    "sortable": false,
                    "searcheable": false
                }
            ]
        });

        $('body').on('click', '.btn-process', function() {
            var id = $(this).data('id');
            var point = $(this).data('point');
            var item = $(this).data('item');
            var user = $(this).data('user');
            var action = $(this).data('action');
            var title = "";
            if (action == 'approve') {
                title = "Approve Confirmation";
            } else {
                title = "Cancel Confirmation";
            }
                swal({
                title: title,
                text: "Item: " + item + "\n Points: " + point + "\n User: " + user,
                icon: "warning",
                buttons: true,
                dangerMode: true,
                showCancelButton: true,
                confirmButtonClass: "btn-primary",
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
                closeOnConfirm: true,
                closeOnCancel: true
            }).then((isConfirm) => {
                if (isConfirm) {
                    processRedeem(id, action);
                }
            });
        });

        $('body').on('click', '.btn-view', function() {
            var id = $(this).data('id');
            $.ajax({
                url: '/staff/redeem/' + id,
                type: 'GET',
                beforeSend: function() {
                    $('.send-loading').show();
                },
                success: function(response) {
                    console.log(response);
                    $('.send-loading').hide();
                    $('#view-redeem-fullname').text(response.redeem_transactions.first_name + ' ' + response.redeem_transactions.last_name);
                    $('#view-redeem-username').text(response.redeem_transactions.username);
                    $('#view-redeem-date').text(response.redeem_transactions.created_at);
                    var status = "";
                    if (response.redeem_transactions.status == '0') {
                        status = "<span class='badge badge-warning'>Pending</span>";
                    } else if (response.redeem_transactions.status == '1') {
                        status = "<span class='badge badge-success'>Approved</span>";
                    } else {
                        status = "<span class='badge badge-danger'>Rejected</span>";
                    }
                    var product_image = "";
                    if (response.redeem_transactions.image != null) {
                        product_image = response.redeem_transactions.image;
                    } else {
                        product_image = "assets/img/product/no-image.jpg";
                    }
                    $('#view-redeem-status').html(status);
                    $('#view-redeem-item').text(response.redeem_transactions.name);
                    $('#view-redeem-points').text(response.redeem_transactions.points);
                    $('#view-redeem-description').html(response.redeem_transactions.description);
                    $('#view-redeem-image').text(response.redeem_transactions.name);
                    
                    if (response.redeem_transactions.remark != null) {
                        $('#redeem-remark-group').show();
                        $('#view-redeem-remark').text(response.redeem_transactions.remark);
                    } else {
                        $('#redeem-remark-group').hide();
                    }


                    $('#view-redeem-image').html(
                        $('<img/>', {
                            src: '../../' + product_image,
                            alt: response.redeem_transactions.image,
                            class: 'img-fluid mx-auto d-block'
                        })
                    );
                    $('#view-redeem-modal').modal();
                },
                error: function(error) {
                    console.log(error);
                    $('.send-loading').hide();
                    swal({
                        title: "Warning!",
                        text: "Something went wrong please try again later",
                        type: "warning",
                    });
                }
            });
        });

        $('body').on('click', '.btn-remark', function() {
            $('.send-loading').show();
            var id = $(this).data('id');
            var item = $(this).data('item');
            var username = $(this).data('user');
            $('#remark_item_id').val(id);

            setTimeout(function() {
                $('.send-loading').hide();
                $('#view-remark-modal').modal();
            }, 1000);
        });

        $('body').on('submit', '#form_remark', function(event) {
            event.preventDefault();
            $('.send-loading').show();

            var id = $('#remark_item_id').val();
            var action = 'remark'
            var remark = $('#remark').val();
            processRedeem(id, action, remark);

        });
    });



    function processRedeem(id, action, remark) {
        var form_data = new FormData();
        form_data.append('_token', token);
        form_data.append('id', id);
        form_data.append('action', action);
        form_data.append('remark', remark);
        var text = "";
        if (action == 'approve') {
            text = "approved";
        } else if (action == 'remark') {
            text = "remarked";
        } else {
            text = "cancelled";
        }
        $.ajax({
            url: process_redeem,
            type: 'POST',
            data: form_data,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('.send-loading').show();

            },
            success: function(response) {
                $('#view-remark-modal').modal('hide');
                $('#remark').val('');
                $('.send-loading').hide();
                swal({
                        title: "Success!",
                        text: "Redeem successfully " + text + ".",
                        type: "success",
                });
                    $('#encashment_table').DataTable().ajax.reload();
            },
            error: function(error) {
                console.log(error);
                $('.send-loading').hide();
                swal({
                    title: "Warning!",
                    text: "Something went wrong please try again later",
                    type: "warning",
                });
            }
        });
    }

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

</script>
@endsection
