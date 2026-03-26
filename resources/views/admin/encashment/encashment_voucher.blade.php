@extends('layouts.default.admin.master')
@section('title','Reimbursement Voucher')
@section('page-title','Reimbursement Voucher')
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
            height: 100%;
        }

        .menu-w,
        .menu-mobile,
        .top-bar,
        .content-panel-toggler,
        .element-header,
        .element-print,
        .floated-colors-btn,
        .floated-customizer-btn,
        .toast-top-center {
            display: none;
        }

        body:before {
            background: none;
        }

        .invoice-w {
            max-width: 100% !important;
        }

        .p-50 {
            margin: 10px !important;
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

                <?php
                      for($i = 0; $i < 2; $i++){
                  ?>
                <div class="invoice">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <h2 class="font-weight-bold d-flex align-items-center">
                                <img src="{{ asset('images/logo.png') }}" width="200px" alt="logo">
                            </h2>
                        </div>
                        <div class="col-md-6 col-sm-6 text-right float-right">
                            <h5 class="text-right float-right">ACCOUNTING'S COPY
                                <br>
                                @if(!empty($get_encash->tin))<b>TIN:</b> <span> {{$get_encash->tin}} @endif</span>
                            </h5>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="text-center">PAYOUT RECEIVING FORM</h1>
                            <br><br>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <p>
                                <b>Name:</b> <span>@if(!empty($get_encash)) {{$get_encash->member_fname}} {{$get_encash->member_lname}} @endif</span><br>
                                <b>Username:</b> <span>@if(!empty($get_encash)) {{$get_encash->username}} @if(!empty($get_encash->team_name))(<strong>Team {{$get_encash->team_name}}</strong>)@endif @endif</span><br>
                            </p>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <p class="text-left">
                                @php
                                $encash_date="";
                                $cut_off="";
                                if(!empty($get_encash->created_at)){
                                $encash_date = $get_encash->created_at;
                                }
                                $encash_add_days=date('Y-m-d', strtotime($encash_date. ' - 6 days'));

                                $encash_month = date('F',strtotime($encash_date));
                                $encash_day=date('d',strtotime($encash_date));
                                $encash_year=date('Y',strtotime($encash_date));

                                $cut_month=date('F',strtotime($encash_add_days));
                                $cut_day=date('d',strtotime($encash_add_days));
                                $cut_year=date('Y',strtotime($encash_add_days));

                                if($encash_month==$cut_month && $encash_year==$cut_year){
                                $cut_off = $cut_day.", ".$cut_year ." - ". $encash_month." ".$encash_day . ", " . $cut_year;
                                }else if($encash_month!=$cut_month && $encash_year==$cut_year){
                                $cut_off = $cut_month." ".$cut_day.", ".$cut_year ." - ". $encash_month." ".$encash_day . ", " . $cut_year;
                                }else{
                                $cut_off= date('F d, Y', strtotime($encash_add_days)) ." to " . date('F d, Y', strtotime($encash_date));
                                }


                                @endphp
                                <b>Reimbursement Date:</b> <span>{{date('F d, Y',strtotime($encash_date))}}</span><br>
                                <b>Cut off:</b> <span>{{$cut_off}}</span><br>
                            </p>
                        </div>
                        @if($get_encash->cashout_option == 'bank')
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <p>
                                <b>Bank Name:</b> <span>@if(!empty($get_encash)) {{$get_encash->bank_name}} @endif</span><br>
                                <b>Account Number:</b> <span>@if(!empty($get_encash)) {{$get_encash->bank_account_number}} @endif</span>
                            </p>
                        </div>
                        @endif
                    </div>
                    <hr class="m-t-b-10">

                    <div class="row">
                        <div class="col-md-6">
                            <table style="width:100%">
                                @php
                                $tax=0;
                                $amount_encash=0;
                                $service=0;
                                $total_net=0;
                                if(!empty($get_encash)){
                                $tax=$get_encash->tax;
                                $amount_encash=$get_encash->amount_approved;
                                if($amount_encash==0 || $amount_encash==""){
                                $amount_encash=$get_encash->amount_requested;
                                }
                                $service=$get_encash->process_fee;
                                $total_net=$amount_encash-$tax-$service;

                                }
                                @endphp
                                <tr>
                                    <td class="text-left">Total Reimbursement</td>
                                    <td class="text-right">{{number_format($amount_encash,2)}}</td>
                                </tr>
                                <tr>
                                    <td class="text-left">Witholding Tax 10%</td>
                                    <td class="text-right">{{number_format($tax,2)}}</td>
                                </tr>
                                <tr>
                                    <td class="text-left">Service Charge</td>
                                    <td class="text-right">{{number_format($service,2)}}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr class="text-bold">
                                    <td class="text-left"><b>Net</b></td>
                                    <td class="text-right"><b>{{number_format($total_net,2)}}</b></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr class="m-t-b-10">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <p>Prepared By:</p><br>
                            <p></p>
                            <hr style="border:1px solid gray; width:100%;" align="left">
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <p>Approved By:</p><br>
                            <p></p>
                            <hr style="border:1px solid gray; width:100%;" align="left">
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <p>Received By:</p><br>
                            <hr style="border:1px solid gray; width:100%;" align="left">
                        </div>
                    </div>
                </div>
                <hr style="border-top: 0.5px dashed red;">

                <?php
            }
            ?>


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
