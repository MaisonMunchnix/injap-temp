@extends('layouts.default.master')
@section('title','Donations')
@section('page-title','Income Listing')

@section('stylesheets')
{{-- additional style here --}}
<style>
    .border-red {
        border: 1px solid red !important;
    }
    .card .bg-info-gradient {
        height: 146px !important;
    }

</style>
@endsection

@section('content')
{{-- content here --}}

<div class="content-body">
    <div class="content">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Donations Overview</h6>
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="card bg-info-gradient">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h6 class="card-title">Donate</h6>
                                </div>
                                <form>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                                    <span class="input-group-text">₱</span>
                                                </div>
                                                <input type="number" class="form-control" id="donate_amount" placeholder="Donation Amount" value="0" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" id="send-request"
                                                class="btn btn-block btn-primary">Donate</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="card bg-success-gradient">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h6 class="card-title">Total Donations Amount</h6>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 class="font-weight-bold">@if(!empty($total_donations)) {{$total_donations}}
                                        @else 0 @endif</h2>
                                    <div class="avatar border-0">
                                        <span class="avatar-title rounded-circle bg-success">
                                            <i class="ti-arrow-top-right"></i>
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
            <div class="card-body">
                <div class="table-responsive">
                    <table id="donations_tbl" width="100%" class="table table-striped table-lightfont">
                        <thead>
                            <tr>
                                <th>Donation Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Updated</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Donation Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Updated</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @if(!empty($get_donations))
                            @foreach($get_donations as $data)
                            <tr class="text-capitalize">
                                <td class="numbers">{{$data->amount}}</td>
                                <td>@if($data->status=='0') <span class="text-warning">Pending</span>
                                    @else <span class="text-primary">Approved</span>
                                    @endif</td>
                                <td>{{ $data->created_at }}</td>
                                <td>@if($data->status=='0') Pending @else {{$data->updated_at}} @endif</td>
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
    var send_donation_route = "{{ route('user.donations.store') }}";
</script>
<script src="{{asset('js/user/donations.js')}}"></script>
@endsection
