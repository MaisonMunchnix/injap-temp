@extends('layouts.default.master')
@section('title', 'Redeem')
@section('page-title', 'Income Listing')

@section('stylesheets')
    {{-- additional style here --}}
    <style>
        .border-red {
            border: 1px solid red !important;
        }

        .tab-pane {
            max-width: 100% !important;
            margin-left: 0px !important;
            margin-right: 0px !important;
        }
    </style>
@endsection

@section('content')
    {{-- content here --}}
    <div class="content-body">
        <div class="content">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Points Overview</h6>
                    <div class="row">
                        <div class="col-lg-4 col-md-12">
                            <div class="card bg-secondary-gradient">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="card-title">Total Points</h6>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <input type="hidden" id="points" value="{{ $total_points }}">
                                        <h2 class="font-weight-bold">
                                            @if (!empty($total_reward))
                                                {{ $total_reward }}
                                            @else
                                                0
                                            @endif
                                        </h2>
                                        <div class="avatar border-0">
                                            <span class="avatar-title rounded-circle bg-secondary">
                                                <i class="ti-back-right"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="card bg-success-gradient">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="card-title">Total Redeem</h6>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h2 class="font-weight-bold">
                                            @if (!empty($total_redeemed))
                                                {{ $total_redeemed }}
                                            @else
                                                0
                                            @endif
                                        </h2>
                                        <div class="avatar border-0">
                                            <span class="avatar-title rounded-circle bg-success">
                                                <i class="ti-arrow-top-right"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="card bg-warning-gradient">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="card-title">Remaining Points</h6>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h2 class="font-weight-bold">
                                            @if (!empty($total_balance))
                                                {{ $total_balance }}
                                            @else
                                                0
                                            @endif
                                        </h2>
                                        <div class="avatar border-0">
                                            <span class="avatar-title rounded-circle bg-warning">
                                                <i class="ti-arrow-down"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-pills pull-right">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#redeem">Redeem</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#transactions">Transactions</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane container active" id="redeem">
                            <div class="table-responsive">
                                <table id="redeem_table" style="width: 100% !important;"
                                    class="table table-striped table-lightfont">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Reward Points</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                                <br>
                            </div>
                        </div>
                        <div class="tab-pane container fade" id="transactions">
                            <div class="table-responsive">
                                <table id="transaction_table" width="100%" class="table table-striped table-lightfont">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Reward Points</th>
                                            <th>Status</th>
                                            <th>Transact Date</th>
                                        </tr>
                                    </thead>
                                </table>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('user.redeem.modal.view')

        </div>
    </div>

@endsection

@section('scripts')
    {{-- additional scripts here --}}
    <script>
        let balance = '{{ $total_balance }}';
        let redeem_item = "{{ route('redeem.request') }}";


        $(document).ready(function() {

            $('#redeem_table').DataTable({
                "order": [
                    [0, "asc"]
                ],
                processing: true,
                serverSide: true,
                responsive: true,
                "ajax": {
                    "url": "{{ route('redeem.get-products') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: token
                    }
                },
                "columns": [{
                        "data": "image"
                    },
                    {
                        "data": "name"
                    },
                    {
                        "data": "description"
                    },
                    {
                        "data": "price"
                    },
                    {
                        "data": "action",
                        "sortable": false,
                        "searcheable": false
                    }
                ]
            });

            $('#transaction_table').DataTable({
                "order": [
                    [3, "desc"]
                ],
                processing: true,
                serverSide: true,
                responsive: true,
                "ajax": {
                    "url": "{{ route('redeem.get-redeemed') }}",
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
                        "data": "status"
                    },
                    {
                        "data": "created_at"
                    }
                ]
            });

            $('body').on('click', '.btn-redeem', function() {
                var points = $('#points').val();
                var id = $(this).data('id');
                var point = $(this).data('point');
                var name = $(this).data('name');

                swal({
                    title: "Redeem Confirmation",
                    text: "Item: " + name + "\n Points: " + point,
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
                        confirmRedeem(id, point);
                    }
                });
            });

            $('body').on('click', '.btn-view-product', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $.ajax({
                    url: './redeem/' + id,
                    type: 'GET',
                    beforeSend: function() {
                        $('.send-loading').show();
                    },
                    success: function(response) {
                        var product_image = "";
                        console.log(response);
                        $('.send-loading').hide();
                        $('#view-pname').text(response.redeem_product.name);
                        $('#view-pdescription').html(response.redeem_product.description);
                        $('#view-preward_points').text(response.redeem_product.price);
                        if (response.redeem_product.image != null) {
                            product_image = response.redeem_product.image;
                        } else {
                            product_image = "assets/img/product/no-image.jpg";
                        }
                        $('#view-pimage').html(
                            $('<img/>', {
                                src: '../' + product_image,
                                alt: response.redeem_product.image,
                                class: 'img-fluid mx-auto d-block'
                            })
                        );
                        $('#view_product_modal').modal();
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
        });

        function confirmRedeem(id, point) {
            var form_data = new FormData();
            form_data.append('_token', token);
            form_data.append('id', id);
            form_data.append('point', point);
            $.ajax({
                url: redeem_item,
                type: 'POST',
                data: form_data,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('.send-loading').show();
                },
                success: function(response) {
                    $('.send-loading').hide();
                    swal({
                        title: "Success!",
                        text: "Redeem successfully requested.",
                        type: "success",
                    });
                    $('#transaction_table').DataTable().ajax.reload();
                },
                error: function(error) {
                    console.log(error);
                    $('.send-loading').hide();
                    swal({
                        title: "Warning!",
                        text: error.responseJSON.message,
                        type: "warning",
                    });
                }
            });
        }
    </script>
@endsection
