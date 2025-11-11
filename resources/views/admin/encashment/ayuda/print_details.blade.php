@extends('layouts.default.admin.master')
@section('title','Ayuda Encashment Details')
@section('page-title','Ayuda Encashment Details')
@section('stylesheets')
<style>
    @media print {

        @page {
            size: letter portrait;
            margin: 0 !important;
            padding: 0 !important
        }

        html,
        body {
            height: 99%;
        }

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

    .print:last-child {
        page-break-after: auto;
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
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <h2 class="font-weight-bold d-flex align-items-center">
                                <img src="{{ asset('images/logo.png') }}" width="200px" alt="logo">
                            </h2>
                        </div>
                        <div class="col-md-6 col-sm-6 text-right float-right">
                            <h5 class="text-right float-right">CUSTOMER'S COPY</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="text-center">@yield('title')</h3>
                            <br><br>
                        </div>
                    </div>
                    <div class="row m-b-0 m-t-10">
                        <div class="col-md-6 col-sm-6">
                            <b>Name:</b> <span class="m-l-10">@if(!empty($user_data)) {{$user_data->first_name}} {{$user_data->last_name}} @endif</span>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <b>Username:</b> <span class="m-l-10">@if(!empty($user_data)) {{$user_data->username}} @endif</span><br>
                        </div>
                    </div>
                    <div class="row m-t-0">
                        <div class="col-md-6 col-sm-6">
                            <b>Requested Date:</b> <span class="m-l-100">{{date('F d, Y',strtotime($encashment_data->created_at))}}</span><br>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <b>Transaction ID:</b> <span class="m-l-100">{{ str_pad($encashment_data->id,10,"0",STR_PAD_LEFT ) }}</span><br>
                        </div>
                    </div>
                    <hr class="m-t-b-10">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6">
                            <table style="width:100%">
                                @php
                                if(!empty($encashment_data)){
                                $total_net = $encashment_data->amount_approved - $encashment_data->tax - $encashment_data->process_fee;
                                }
                                @endphp
                                <tr>
                                    <td class="text-left">Amount requested</td>
                                    <td class="text-right">{{number_format($encashment_data->amount_requested,2)}}</td>
                                </tr>
                                <tr>
                                    <td class="text-left">Amount approved</td>
                                    <td class="text-right">{{number_format($encashment_data->amount_approved,2)}}</td>
                                </tr>
                                <tr>
                                    <td class="text-left">Witholding Tax 10%</td>
                                    <td class="text-right">{{number_format($encashment_data->tax,2)}}</td>
                                </tr>
                                <tr>
                                    <td class="text-left">Processing Fee</td>
                                    <td class="text-right">{{number_format($encashment_data->process_fee,2)}}</td>
                                </tr>
                                <tr class="text-bold">
                                    <td class="text-left">Total Amount claim</td>
                                    <td class="text-right">{{number_format($total_net,2)}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr class="m-t-b-10">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <p>Prepared By:</p><br>
                            <p></p>
                            <hr style="border:1px solid gray; width:75%;" align="left">
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <p>Approved By:</p><br>
                            <p></p>
                            <hr style="border:1px solid gray; width:75%;" align="left">
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <p>Received By:</p><br><br>
                            <hr style="border:1px solid gray; width:75%;" align="left">
                        </div>
                    </div>
                </div>
                <hr style="border-top: 1px dashed red;">
                <div class="invoice m-t-20">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <h2 class="font-weight-bold d-flex align-items-center">
                                <img src="{{ asset('images/logo.png') }}" width="200px" alt="logo">
                            </h2>
                        </div>
                        <div class="col-md-6 col-sm-6 text-right float-right">
                            <h5 class="text-right float-right">CUSTOMER'S COPY</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="text-center">@yield('title')</h3>
                            <br><br>
                        </div>
                    </div>

                    <div class="row m-b-0 m-t-10">
                        <div class="col-md-6 col-sm-6">
                            <b>Name:</b> <span class="m-l-10">@if(!empty($user_data)) {{$user_data->first_name}} {{$user_data->last_name}} @endif</span>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <b>Username:</b> <span class="m-l-10">@if(!empty($user_data)) {{$user_data->username}} @endif</span><br>
                        </div>
                    </div>
                    <div class="row m-t-0">
                        <div class="col-md-6 col-sm-6">
                            <b>Requested Date:</b> <span class="m-l-100">{{date('F d, Y',strtotime($encashment_data->created_at))}}</span><br>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <b>Transaction ID:</b> <span class="m-l-100">{{ str_pad($encashment_data->id,10,"0",STR_PAD_LEFT ) }}</span><br>
                        </div>
                    </div>
                    <hr class="m-t-b-10">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6">
                            <table style="width:100%">
                                @php
                                if(!empty($encashment_data)){
                                $total_net = $encashment_data->amount_approved - $encashment_data->tax - $encashment_data->process_fee;
                                }
                                @endphp
                                <tr>
                                    <td class="text-left">Amount requested</td>
                                    <td class="text-right">{{number_format($encashment_data->amount_requested,2)}}</td>
                                </tr>
                                <tr>
                                    <td class="text-left">Amount approved</td>
                                    <td class="text-right">{{number_format($encashment_data->amount_approved,2)}}</td>
                                </tr>
                                <tr>
                                    <td class="text-left">Witholding Tax 10%</td>
                                    <td class="text-right">{{number_format($encashment_data->tax,2)}}</td>
                                </tr>
                                <tr>
                                    <td class="text-left">Processing Fee</td>
                                    <td class="text-right">{{number_format($encashment_data->process_fee,2)}}</td>
                                </tr>
                                <tr class="text-bold">
                                    <td class="text-left">Total Amount claim</td>
                                    <td class="text-right">{{number_format($total_net,2)}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr class="m-t-b-10">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <p>Prepared By:</p><br>
                            <p></p>
                            <hr style="border:1px solid gray; width:75%;" align="left">
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <p>Approved By:</p><br>
                            <p></p>
                            <hr style="border:1px solid gray; width:75%;" align="left">
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <p>Received By:</p><br><br>
                            <hr style="border:1px solid gray; width:75%;" align="left">
                        </div>
                    </div>
                </div>
                
                <div class="text-right d-print-none">
                    <!-- <a href="#" class="btn btn-primary" >
                            <i data-feather="send" class="mr-2"></i> Send Invoice
                        </a> -->
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

@endsection
