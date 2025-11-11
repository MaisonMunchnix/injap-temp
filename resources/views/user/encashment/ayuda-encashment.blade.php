@extends('layouts.default.master')
@section('title','Ayuda Encashment')
@section('page-title','Income Listing')

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
                <h6 class="card-title">Earnings Overview</h6>
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="card bg-success-gradient">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h6 class="card-title">Total Ayuda Encashed Amount</h6>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 class="font-weight-bold">@if(!empty($get_total_encashment)) {{$get_total_encashment}} @else 0 @endif</h2>
                                    <div class="avatar border-0">
                                        <span class="avatar-title rounded-circle bg-success">
                                            <i class="ti-arrow-top-right"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="card bg-warning-gradient">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h6 class="card-title">Total Ayuda Available Balance</h6>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 class="font-weight-bold">@if(!empty($total_balance)) {{$total_balance}} @else 0 @endif</h2>
                                    <div class="avatar border-0">
                                        <span class="avatar-title rounded-circle bg-warning">
                                            <i class="ti-wallet"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h6 class="card-title">Withdraw Money</h6>
                <div class="row">
                    <div class="col-md-12">
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Input Amount</label>
                                        <input class="form-control" id="amount_requested" placeholder="Enter Amount..." type="number" value="0" min="500" @if(!empty($total_balance)) max="{{$total_balance}}" @endif required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Password Confirmation</label>
                                        <input class="form-control" id="password_verification" placeholder="Password Confirmation" type="password" required>
                                    </div>
                                </div>
                            </div>
                            <label for="formControlRange">Note:</label>
                            <br>
                            <label for="formControlRange">Tax: {{$ayuda_tax}}%</label>
                            <br>
                            <label for="formControlRange">Processing Fee: {{ $process_fee }} php</label>
                            <br>
                            <label for="formControlRange">Mininum withdrawal: 500.00 php</label>
                            <br>
                            <button type="button" id="send-request" class="btn btn-primary">Submit Request</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="encashment_tbl" width="100%" class="table table-striped table-lightfont">
                        <thead>
                            <tr>
                                <th>Date Requested</th>
                                <!-- <th>Transact ID</th> -->
                                <th>Amount Requested</th>
                                <th>Amount Approved</th>
                                <th>Amount Claimed</th>
                                <th>Status</th>
                                <th>Date Processed</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Date Requested</th>
                                <!-- <th>Transact ID</th> -->
                                <th>Amount Requested</th>
                                <th>Amount Approved</th>
                                <th>Amount Claimed</th>
                                <th>Status</th>
                                <th>Date Processed</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @if(!empty($get_encashments))
                            @foreach($get_encashments as $data)
                            <tr class="text-capitalize">
                                <td>{{$data->created_at}}</td>

                                <td class="numbers">{{$data->amount_requested}}</td>
                                <td>@if($data->status=='pending') Pending @else <span class="numbers">{{$data->amount_approved}}</span> @endif</td>
                                <td>
                                    @if($data->status=='claimed')
                                    @php
                                    $temp = $data->amount_approved;
                                    $tax = $temp * $ayuda_tax;
                                    $amount_claimed = $temp - $tax - $process_fee;
                                    @endphp
                                    <span class="numbers">{{$amount_claimed}}</span>
                                    @elseif($data->status=='pending')
                                    Pending
                                    @elseif($data->status=='approved')
                                    Not yet claim
                                    @else
                                    0
                                    @endif
                                </td>
                                <td>@if($data->status=='pending') <span>Pending for approval</span> @elseif($data->status=='approved') <span class="text-primary">Ready to claim</span> @elseif($data->status=='claimed') <span class="text-success">Claimed</span> @else <span class="text-danger">{{$data->status}}</span> @endif</td>
                                <td>@if($data->status=='pending') Pending @else {{$data->updated_at}} @endif</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
{{-- additional scripts here --}}
<script>
    var balance = '{{$total_balance}}';
    var ayuda_request_encashment = "{{route('ayuda-request-encashment')}}";

</script>
<script src="{{asset('js/user/ayuda-member-encashment.js')}}"></script>
@endsection
