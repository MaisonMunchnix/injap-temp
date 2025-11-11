@extends('layouts.default.teller.master')
@section('title', 'Transaction Receipt')
@section('page-title', 'Transaction Receipt')
@section('stylesheets')
    <style>
        @media print {

            .menu-w,
            .menu-mobile,
            .top-bar,
            .content-panel-toggler,
            .element-header,
            .element-print,
            .floated-colors-btn,
            .floated-customizer-btn {
                display: none;
            }

            body:before {
                background: none;
            }

            .invoice-w {
                max-width: 100% !important;
            }
        }
    </style>
@endsection
@section('content')
    <div class="card">
        <div class="card-body p-50">
            <div class="invoice">
                <div class="d-md-flex justify-content-between align-items-center">
                    <h2 class="font-weight-bold d-flex align-items-center">
                        <img src="../../assets/media/image/logo.png" width="200px" alt="logo">
                    </h2>
                    <h3 class="text-xs-left m-b-0">Invoice #INV-16</h3>
                </div>
                <hr class="m-t-b-50">
                <div class="row">
                    <div class="col-md-6">
                        <p>
                            <b>{{ env('APP_NAME') }}</b>
                        </p>
                        <p> 82 Vibo Place,<br>N. Escario Street,<br>Cebu City, Philippines.</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-right">
                            <b>Invoice to</b>
                        </p>
                        <p class="text-right">Gaala &amp; Sons,<br> C-201, Beykoz-34800,<br> Canada, K1A 0G9.
                        </p>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table mb-4 mt-4">
                        <thead class="thead-light">
                            <tr>
                                <th>Description</th>
                                <th class="text-right">Quantity</th>
                                <th class="text-right">Unit cost</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_price = $total = 0;
                            @endphp
                            @if (!empty($product_transactions))
                                @foreach ($product_transactions as $product_transaction)
                                    @php
                                        $total = $product_transaction->price * $product_transaction->quantity;
                                        $total_price = $total_price + $total;
                                    @endphp
                                    <tr>
                                        <td>{{ $product_transaction->name }}</td>
                                        <td>{{ $product_transaction->quantity }}</td>
                                        <td>P<span
                                                class="float-right">{{ number_format($product_transaction->price, 2) }}</span>
                                        </td>
                                        <td>P<span class="float-right">{{ number_format($total, 2) }}</span></td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="text-right">
                    <p>Sub - Total amount: 0</p>
                    <p>vat (10%) : 0</p>
                    <h4 class="font-weight-800">Total : P {{ number_format($total_price, 2) }}</h4>
                </div>

            </div>
            <div class="text-right d-print-none">
                <hr class="mb-5 mt-5">
                <a href="#" class="btn btn-primary email-invoice">
                    <i data-feather="send" class="mr-2"></i> Send Invoice
                </a>
                <a href="javascript:window.print()" class="btn btn-success m-l-5">
                    <i data-feather="printer" class="mr-2" onclick="window.print();"></i> Print
                </a>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var token = "{{ csrf_token() }}";
        $('.email-invoice').on('click', function(e) {
            e.preventDefault();
            var url = '{{ route(
                '
                    order.email - receipt ',
                $sale->id,
            ) }}';
            swal({
                title: "Email Invoice",
                text: 'Enter email address',
                content: {
                    element: "input",
                    attributes: {
                        type: "text",
                    },
                },
                buttons: {
                    cancel: true,
                    confirm: "Send"
                }
            }).then(function(value) {
                console.log(value)
                if (value) {
                    $.ajax({
                        type: 'post',
                        url: url,
                        data: {
                            "_token": token,
                            'email': value
                        },
                        beforeSend: function() {
                            $('.send-loading').show();
                        },
                        success: function(data) {
                            console.log(data)
                            $('.send-loading').hide();
                            swal({
                                title: 'Success!',
                                text: data.message,
                                icon: "success",
                            })
                        },
                        error: function(error) {
                            $('.send-loading').hide();
                            swal({
                                title: 'Error!',
                                text: error.responseJSON.message,
                                icon: "error",
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection
