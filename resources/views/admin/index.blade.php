@extends('layouts.user.master')
@section('title', 'Sales Reports')

@section('stylesheets')
    <style>
        .border-red {
            border: 1px solid red !important;
        }
    </style>
@endsection

@section('content')

    <div class="content-i">
        <!-- start content- -->
        <div class="content-box">
            <div class="element-wrapper">
                <!-- <h6 class="element-header">Data Tables</h6> -->
                <div class="element-box">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="element-header">@yield('title')</h6>
                        </div>
                        <!--<div class="col-md-6">
          <a class="btn btn-primary pull-right" data-target="#add-modal" data-toggle="modal" href="#"><i class="os-icon os-icon-ui-22"></i><span> User</span></a>
         </div>-->
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                            <li class="nav-item">
                                <a href="#date-tab" class="nav-link active" data-toggle="tab" role="tab"
                                    aria-controls="tab-21" aria-selected="true">
                                    <span class="nav-link__count">Date</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#branch-tab" class="nav-link" data-toggle="tab" role="tab"
                                    aria-selected="false">
                                    <span class="nav-link__count">Branch</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#teller-tab" class="nav-link" data-toggle="tab" role="tab"
                                    aria-selected="false">
                                    <span class="nav-link__count">Teller</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#member-tab" class="nav-link" data-toggle="tab" role="tab"
                                    aria-selected="false">
                                    <span class="nav-link__count">Member</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#transaction-type-tab" class="nav-link" data-toggle="tab" role="tab"
                                    aria-selected="false">
                                    <span class="nav-link__count">Transaction Type</span>
                                </a>
                            </li>
                        </ul>

                        <div class="card-body tab-content">
                            <div class="tab-pane show fade in active" id="date-tab">
                                <h3><strong class="headings-color">Date</strong></h3>
                                <form action="" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label>Start Date:</label>
                                        <input type="date" class="form-control" name="start_date"
                                            placeholder="Start Date" required>
                                    </div>
                                    <div class="form-group">
                                        <label>End Date:</label>
                                        <input type="date" class="form-control" name="end_date" placeholder="End Date"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label>Sort By:</label>
                                        <select name="sort_by" class="form-control" required>
                                            <option value="" selected disabled>--- Select ---</option>
                                            <option value="or">OR</option>
                                            <option value="dr">DR</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                </form>
                            </div>
                            <div class="tab-pane fade in" id="branch-tab">
                                <h3><strong class="headings-color">Branch</strong></h3>
                                <form action="" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label>Start Date:</label>
                                        <input type="date" class="form-control" name="start_date"
                                            placeholder="Start Date" required>
                                    </div>
                                    <div class="form-group">
                                        <label>End Date:</label>
                                        <input type="date" class="form-control" name="end_date" placeholder="End Date"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label>Branch:</label>
                                        <select name="branch" class="form-control" required>
                                            <option value="" selected disabled>--- Select ---</option>
                                            <option value="all">All Branch</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                </form>
                            </div>

                            <div class="tab-pane fade in" id="teller-tab">
                                <h3><strong class="headings-color">Teller</strong></h3>
                                <form action="" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label>Start Date:</label>
                                        <input type="date" class="form-control" name="start_date"
                                            placeholder="Start Date" required>
                                    </div>
                                    <div class="form-group">
                                        <label>End Date:</label>
                                        <input type="date" class="form-control" name="end_date"
                                            placeholder="End Date" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Teller:</label>
                                        <select name="teller" class="form-control" required>
                                            <option value="" selected disabled>--- Select ---</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                </form>
                            </div>

                            <div class="tab-pane fade in" id="member-tab">
                                <h3><strong class="headings-color">Member</strong></h3>
                                <form action="" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label>Start Date:</label>
                                        <input type="date" class="form-control" name="start_date"
                                            placeholder="Start Date" required>
                                    </div>
                                    <div class="form-group">
                                        <label>End Date:</label>
                                        <input type="date" class="form-control" name="end_date"
                                            placeholder="End Date" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Username:</label>
                                        <input type="text" class="form-control" name="username"
                                            placeholder="Username" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Sales Type:</label>
                                        <select name="sale-type" class="form-control" required>
                                            <option value="" selected disabled>--- Select ---</option>
                                            <option value="personal">Personal</option>
                                            <option value="group">Group</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                </form>
                            </div>

                            <div class="tab-pane fade in" id="transaction-type-tab">
                                <h3><strong class="headings-color">Transaction Type</strong></h3>
                                <form action="" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label>Start Date:</label>
                                        <input type="date" class="form-control" name="start_date"
                                            placeholder="Start Date" required>
                                    </div>
                                    <div class="form-group">
                                        <label>End Date:</label>
                                        <input type="date" class="form-control" name="end_date"
                                            placeholder="End Date" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Username:</label>
                                        <input type="text" class="form-control" name="username"
                                            placeholder="Username" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Transaction Type:</label>
                                        <select name="transaction-type" class="form-control" required>
                                            <option value="" selected disabled>--- Select ---</option>
                                            <option value="new-entry">New Entry</option>
                                            <option value="repeat-purchase">Repeat Purchase</option>
                                            <option value="online-portal">Online Portal</option>
                                            <option value="cancelled">Cancelled</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive border-bottom">
                            <table class="table thead-border-top-0" id="members_table_today"
                                style="width:100% !important">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>DTC</th>
                                        <th>T.R.A No.</th>
                                        <th>Invoice No.</th>
                                        <th>TranType</th>
                                        <th>Sold To</th>
                                        <th>Teller</th>
                                        <th>SRP</th>
                                        <th>Distributor Discount</th>
                                        <th>Promo Discount</th>
                                        <th>Unit Cost</th>
                                        <th>Net DP</th>
                                        <th>Net of Vat</th>
                                        <th>Vat Amount</th>
                                        <th>Cash</th>
                                        <th>Bank Deposit</th>
                                        <th>Check</th>
                                        <th>Credit Card</th>
                                        <th>Debit Card</th>
                                        <th>FERN Wallet</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>DTC</th>
                                        <th>T.R.A No.</th>
                                        <th>Invoice No.</th>
                                        <th>TranType</th>
                                        <th>Sold To</th>
                                        <th>Teller</th>
                                        <th>SRP</th>
                                        <th>Distributor Discount</th>
                                        <th>Promo Discount</th>
                                        <th>Unit Cost</th>
                                        <th>Net DP</th>
                                        <th>Net of Vat</th>
                                        <th>Vat Amount</th>
                                        <th>Cash</th>
                                        <th>Bank Deposit</th>
                                        <th>Check</th>
                                        <th>Credit Card</th>
                                        <th>Debit Card</th>
                                        <th>FERN Wallet</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end content-i -->
@endsection

@section('scripts')
    <!-- Sweetalert -->

    <script src="{{ asset('js/admin/members.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#members_table').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('all-members') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: token
                    }
                },
                "columns": [{
                        "data": "username"
                    },
                    {
                        "data": "first_name"
                    },
                    {
                        "data": "last_name"
                    },
                    {
                        "data": "email"
                    },
                    {
                        "data": "mobile_no"
                    },
                    {
                        "data": "package"
                    },
                    {
                        "data": "sponsor"
                    },
                    {
                        "data": "status"
                    },
                    {
                        "data": "created_at"
                    },
                    {
                        "data": "options",
                        "searchable": false,
                        "orderable": false
                    }
                ]
            });

            $('#members_table_today').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('all-members') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: token,
                        users_today: true
                    }
                },
                "columns": [{
                        "data": "username"
                    },
                    {
                        "data": "first_name"
                    },
                    {
                        "data": "last_name"
                    },
                    {
                        "data": "email"
                    },
                    {
                        "data": "mobile_no"
                    },
                    {
                        "data": "package"
                    },
                    {
                        "data": "sponsor"
                    },
                    {
                        "data": "status"
                    },
                    {
                        "data": "created_at"
                    },
                    {
                        "data": "options",
                        "searchable": false,
                        "orderable": false
                    }
                ]
            });
        });
    </script>
@endsection
