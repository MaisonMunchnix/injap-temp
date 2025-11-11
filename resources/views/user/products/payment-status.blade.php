@extends('layouts.default.master')
@section('title', 'Cart')
@section('page-title', 'Cart')

@section('stylesheets')
    {{-- additional style here --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .border-red {
            border: 1px solid red !important;
        }

        .select2-selection {
            height: 35px !important;
        }

        .card .bg-info-gradient {
            min-height: 146px !important;
        }

        @media only screen and (max-width: 767px) {
            .input-group {
                margin-bottom: 20px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="content-body">
        <div class="card mt-5">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <div class="row">
                            <!-- cart -->
                            <div class="col-lg-12">
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <div class="about_thumb text-center">
                                            <img src="{{ asset('assets/img/about/about1.jpg') }}" alt=""
                                                class="center">
                                        </div>
                                        <div class="about_content">
                                            @if ($payment['status'] === 1 && $payment['driver'] === 'EWalletPaymentGateway')
                                                <h1 class="text-success text-center">Transaction has been completed!</h1>
                                                <div class="col-md-6 offset-md-3 text-left">
                                                    <div class="jumbotron p-3">
                                                        <h4 class="mb-3">Processing E-wallet payment</h4>
                                                        <p>The transaction amount is going to be deducted to your E-wallet
                                                            balance. Please wait for further instruction. Thank you.</p>
                                                        <div class="table-responsive">
                                                            <table class="table table-sm">
                                                                <tr>
                                                                    <th class="border-top-0">Transaction Number:</th>
                                                                    <td class="border-top-0 text-left">
                                                                        {{ $payment['confirmation_number'] }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="border-top-0">Amount:</th>
                                                                    <td class="border-top-0 text-left">
                                                                        P{{ number_format($payment['amount'], 2) }}</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if (
                                                $payment['status'] === 1 &&
                                                    in_array($payment['driver'], ['BankTransferPaymentGateway', 'OverTheCounterPaymentGateway']))
                                                <h1 class="text-success text-center">Transaction has been completed!</h1>
                                                <div class="col-md-6 offset-md-3 text-left">
                                                    <div class="jumbotron p-3">
                                                        <h4 class="mb-3">Instructions to complete purchase</h4>
                                                        <p>Please email your deposit slip for proof of payment to
                                                            {{ env('MAIL_PAYMENT_ADDRESS') }} to process your order and put
                                                            the
                                                            transaction
                                                            number below. Thank you.</p>
                                                        <div class="table-responsive">
                                                            <table class="table table-sm">
                                                                <tr>
                                                                    <th class="border-top-0">Transaction Number:</th>
                                                                    <td class="border-top-0 text-left">
                                                                        {{ $payment['confirmation_number'] }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="border-top-0">Amount:</th>
                                                                    <td class="border-top-0 text-left">
                                                                        P{{ number_format($payment['amount'], 2) }}</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($payment['status'] === 1 && in_array($payment['driver'], ['PaypalPaymentGateway', 'PaynamicsPaymentGateway']))
                                                <h1 class="text-success text-center">Transaction has been completed!</h1>
                                                <div class="col-md-6 offset-md-3 text-left">
                                                    <div class="jumbotron p-3">
                                                        <h4 class="mb-3">Purchase successful</h4>
                                                        <p>For shipping method please give us 2-3 days to process your
                                                            order. For pickup you can proceed to our office anytime to get
                                                            the products. Thank you.</p>
                                                        <div class="table-responsive">
                                                            <table class="table table-sm">
                                                                <tr>
                                                                    <th class="border-top-0">Transaction Number:</th>
                                                                    <td class="border-top-0 text-left">
                                                                        {{ $payment['confirmation_number'] }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="border-top-0">Amount:</th>
                                                                    <td class="border-top-0 text-left">
                                                                        P{{ number_format($payment['amount'], 2) }}</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($payment['status'] === 0)
                                                <h1 class="text-danger">Transaction is unsuccessful!</h1>
                                                <p>{{ $payment['error'] }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

@endsection
