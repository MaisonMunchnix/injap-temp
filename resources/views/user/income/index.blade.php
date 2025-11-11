@extends('layouts.default.master')
@section('title', 'Transfer Income')
@section('page-title', 'Transfer Income')

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
    {{-- content here --}}

    <div class="content-body">
        <div class="content">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Income Overview</h6>
                    <div class="row">
                        <div class="col-lg-8 col-md-8">
                            <div class="card bg-info-gradient">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="card-title">Transfer</h6>
                                        <span id="receive_lbl"></span>
                                    </div>
                                    <form>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <select name="username" id="username" required>
                                                        <option value="">Select Username</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">₱</span>
                                                    </div>
                                                    <input type="number" class="form-control" id="transfer_amount"
                                                        placeholder="Transfer Amount" value="0" autocomplete="off"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input type="password" class="form-control" id="password"
                                                        placeholder="Password" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="button" id="send-request"
                                                    class="btn btn-block btn-primary">Transfer</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="card bg-success-gradient">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="card-title">Total Income</h6>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h2 class="font-weight-bold" id="total-income">0</h2>
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
                    <h3>Transfer History</h3>
                    <div class="table-responsive">
                        <table id="transfers_tbl" width="100%" class="table table-striped table-lightfont">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Name</th>
                                    <th>Process Fee</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
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
        var select_user_route = "{{ route('user.select-members') }}";
        var get_total_income_route = "{{ route('user.get-total-income') }}";
        var transfer_route = "{{ route('user.income-transfer.store', $auth_id) }}";
        var histories_route = "{{ route('user.get-transfer-histories') }}";
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/user/transfer-income.js?v=1') }}"></script>

@endsection
