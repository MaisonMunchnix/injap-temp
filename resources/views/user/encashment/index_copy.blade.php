@extends('layouts.user.master')
@section('title', 'Encashment')
@section('page-title', 'Income Listing')

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


    <div class="content-w">
        <div class="content-i">
            <div class="content-box">
                <div class="element-wrapper compact pt-4">

                    <h6 class="element-header">Earnings Overview</h6>
                    <div class="element-box-tp">
                        <div class="row">
                            <div class="col-lg-7 col-xxl-6">
                                <!--START - BALANCES-->
                                <div class="element-balances">
                                    <div class="row">
                                        <div class="col-lg-12 col-xxl-12">
                                            <div class="balance">
                                                <div class="balance-title">Total Accumulated Earnings</div>
                                                <div class="balance-value">P<span class="numbers">
                                                        @if (!empty($total_earnings))
                                                            {{ $total_earnings }}
                                                        @else
                                                            0
                                                        @endif
                                                    </span>
                                                    <span class="trending trending-down-basic"></span>
                                                </div>
                                                <div class="balance-link"><a class="btn btn-link"
                                                        href="{{ route('total-income') }}"><span>View Details</span><i
                                                            class="os-icon os-icon-arrow-right4"></i></a></div>
                                            </div>
                                            <div class="balance">
                                                <div class="balance-title">Total Encashment</div>
                                                <div class="balance-value">P<span class="numbers">
                                                        @if (!empty($total_encashment))
                                                            {{ $total_encashment }}
                                                        @else
                                                            0
                                                        @endif
                                                    </span>
                                                </div>
                                                {{-- <div class="balance-link"><a class="btn btn-link" href="#"><span>View Details</span><i class="os-icon os-icon-arrow-right4"></i></a></div> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-xxl-12">
                                            <div class="balance">
                                                <div class="balance-title">Total Withdrawable Amount</div>
                                                <div class="balance-value">P<span class="numbers">
                                                        @if (!empty($total_withdrawable))
                                                            {{ $total_withdrawable }}
                                                        @else
                                                            0
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="balance-link"><a class="btn btn-link"
                                                        href="{{ route('income-listing', 'total-withdrawable-amount') }}"><span>View
                                                            Details</span><i class="os-icon os-icon-arrow-right4"></i></a>
                                                </div>
                                            </div>
                                            <div class="balance">
                                                <div class="balance-title">Total Balance</div>
                                                <div class="balance-value danger">P<span class="numbers">
                                                        @if (!empty($total_balance))
                                                            {{ $total_balance }}
                                                        @else
                                                            0
                                                        @endif
                                                    </span></div>
                                                <div class="balance-link"><a class="btn btn-link"
                                                        href="{{ route('available-balance') }}"><span>View Details</span><i
                                                            class="os-icon os-icon-arrow-right4"></i></a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--END - BALANCES-->
                            </div>
                            <div class="col-lg-5 col-xxl-6">
                                <!--START - Money Withdraw Form-->
                                <div class="element-wrapper">
                                    <div class="element-box">
                                        <form method="POST" action="">
                                            <h5 class="element-box-header">Withdraw Money</h5>
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <label class="lighter" for="">Input Amount</label>
                                                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                                            <input class="form-control" id="amount_requested"
                                                                placeholder="Enter Amount..." type="number" value="0"
                                                                min="500"
                                                                @if (!empty($total_balance)) max="{{ $total_balance }}" @endif
                                                                required>
                                                            <div class="input-group-append">
                                                                <div class="input-group-text">PHP</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-7">
                                                    <div class="form-group">
                                                        <label class="lighter" for="">Password Confirmation</label>
                                                        <input class="form-control" id="password_verification"
                                                            placeholder="Password" type="password" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <p>Note:<br />
                                                        Tax: 10%<br />
                                                        Processing Fee: 50php<br />
                                                        Mininum withdrawal: 500php
                                                    <p>
                                                </div>
                                            </div>
                                            <div class="form-buttons-w text-right compact"><button class="btn btn-primary"
                                                    id="send-request" type="button"><span>Send Request</span><i
                                                        class="os-icon os-icon-grid-18"></i></button></div>
                                        </form>
                                    </div>
                                </div>
                                <!--END - Money Withdraw Form-->
                            </div>
                        </div>
                    </div>
                </div>

                <!--START - Transactions Table-->
                <div class="element-wrapper">
                    <h6 class="element-header">Recent Transactions</h6>
                    <div class="element-box-tp">
                        <div class="table-responsive">
                            <table id="encashment_tbl" width="100%" class="table table-striped table-lightfont">
                                <thead>
                                    <tr>
                                        <th>Date Requested</th>
                                        <th>Transact ID</th>
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
                                        <th>Transact ID</th>
                                        <th>Amount Requested</th>
                                        <th>Amount Approved</th>
                                        <th>Amount Claimed</th>
                                        <th>Status</th>
                                        <th>Date Processed</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if (!empty($get_encashment))
                                        @foreach ($get_encashment as $data)
                                            <tr class="text-capitalize">
                                                <td>{{ $data->created_at }}</td>
                                                <td>
                                                    @if (strlen($data->id) > 10)
                                                        {{ $data->id }}
                                                    @else
                                                        {{ sprintf('%010d', $data->id) }}
                                                    @endif
                                                </td>
                                                <td class="numbers">{{ $data->amount_requested }}</td>
                                                <td>
                                                    @if ($data->status == 'pending')
                                                        Pending
                                                    @else
                                                        <span class="numbers">{{ $data->amount_approved }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($data->status == 'claimed')
                                                        @php
                                                            $temp = $data->amount_approved;
                                                            $tax = $temp * 0.1;
                                                            $amount_claimed = $temp - $tax - 50;
                                                        @endphp
                                                        <span class="numbers">{{ $amount_claimed }}</span>
                                                    @elseif($data->status == 'pending')
                                                        Pending
                                                    @elseif($data->status == 'approved')
                                                        Not yet claim
                                                    @else
                                                        0
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($data->status == 'pending')
                                                        Pending for approval
                                                        </span>
                                                    @elseif($data->status == 'approved')
                                                        <span class="text-primary">Ready to claim</span>
                                                    @elseif($data->status == 'claimed')
                                                        <span class="text-success">Claimed</span>
                                                    @else
                                                        <span class="text-danger">{{ $data->status }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($data->status == 'pending')
                                                        Pending
                                                    @else
                                                        {{ $data->updated_at }}
                                                    @endif
                                                </td>
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


                <!--START - Transactions Table-->
                <div class="element-wrapper">
                    <h6 class="element-header">E-Wallet Transactions</h6>
                    <div class="element-box-tp">
                        <div class="table-responsive">
                            <table id="ewallet" width="100%" class="table table-striped table-lightfont">
                                <thead>
                                    <tr>
                                        <th>Date Requested</th>
                                        <th>Transact ID</th>
                                        <th>Product</th>
                                        <th>Amount</th>

                                        <th>Status</th>
                                        <th>Date Processed</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Date Requested</th>
                                        <th>Transact ID</th>
                                        <th>Product</th>
                                        <th>Amount</th>

                                        <th>Status</th>
                                        <th>Date Processed</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if (!empty($EWalletPaymentGateway))
                                        @foreach ($EWalletPaymentGateway as $data)
                                            <tr class="text-capitalize">
                                                <td>{{ $data->created_at }}</td>
                                                <td>
                                                    @if (strlen($data->id) > 10)
                                                        {{ $data->id }}
                                                    @else
                                                        {{ sprintf('%010d', $data->id) }}
                                                    @endif
                                                </td>
                                                <td class="numbers">{{ $data->amount }}</td>
                                                <td>{{ $data->name }}</td>

                                                <td>
                                                    @if ($data->products_released == 1)
                                                        Released
                                                    @else
                                                        pending
                                                    @endif
                                                </td>
                                                <td>{{ $data->updated_at }}</td>
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
            @include('user.customizer')
        </div>
    </div>

@endsection

@section('scripts')
    {{-- additional scripts here --}}
    <script>
        var balance = '{{ $total_balance }}';
    </script>
    <script src="{{ asset('js/user/member-encashment.js') }}"></script>
@endsection
