@extends('layouts.default.teller.master')
@section('title','Orders Receipt')
@section('page-title','Orders Receipt')
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
<div class="content-body">
    <!-- start content- -->
    <div class="content">
        <div class="card">
            <div class="card-body p-50">
                <div class="invoice">
                    <div class="d-md-flex justify-content-between align-items-center">
                        <h2 class="font-weight-bold d-flex align-items-center">
                            <img src="{{ asset('images/logo.png') }}" width="200px" alt="logo">
                        </h2>
                        <h3 class="text-xs-left m-b-0">{{$sale->getInvoiceNumber()}}</h3>
                    </div>
                    <hr class="m-t-b-50">
                    <div class="row">
                        <div class="col-md-6">
                            <p>
                                <b>{{ env('APP_NAME') }}</b>
                            </p>
                            <p>Address:</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-right">
                                <b>Invoice to</b>
                            </p>
                            <p class="text-right">{{ $sale->getInvoiceName() }} @if($sale->getUsername())-{{ $sale->getUsername() }}@endif,<br> {{ $sale->getInvoiceAddress() }}.
                            </p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-4 mt-4">
                            <thead class="thead-light">
                                <tr>
                                    <th>Description</th>
                                    <th>Unit Price</th>
                                    <th>Qty</th>
                                    {{-- <th class="text-right">Discount</th> --}}
                                    <th class="text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sale->products as $order)
                                <tr>
                                    <td>{{ $order->name }}</td>
                                    <td>P{{ $order->pivot->price + $order->pivot->discount }}</td>
                                    <td>{{ $order->pivot->quantity }}</td>
                                    {{-- <td class="text-right">- P{{ number_format($order->pivot->discount, 2) }}</td> --}}
                                    <td class="text-right">P{{ number_format($order->pivot->price * $order->pivot->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                @if($sale->shipping > 0)
                                <tr>
                                    <td class="border-top-0" style="font-size: 1rem">Shipping Fee</td>
                                    <td class="border-top-0 text-right" style="font-size: 0.8rem" colspan="4">+ P{{ $sale->shipping }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td>Total</td>
                                    <td class="text-right" colspan="4">P{{ number_format($sale->total, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
                <div class="text-right d-print-none">
                    <hr class="mb-5 mt-5">
                    {{-- <a href="#" class="btn btn-primary email-invoice" >
                            <i data-feather="send" class="mr-2"></i> Send Invoice
                        </a> --}}
                    <a href="javascript:window.print()" class="btn btn-success m-l-5">
                        <i data-feather="printer" class="mr-2" onclick="window.print();"></i> Print
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script> -->
<script>
    var token = "{{csrf_token()}}";
    $('.email-invoice').on('click', function(e) {
        e.preventDefault();
        var url = "{{ route('order.email-receipt',$sale->id) }}";
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
                        $('.preloader').css('display', '');
                    },
                    success: function(data) {
                        console.log(data)
                        $('.preloader').css('display', 'none');
                        swal({
                            title: 'Success!',
                            text: data.message,
                            icon: "success",
                        })
                    },
                    error: function(error) {
                        $('.preloader').css('display', 'none');
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
