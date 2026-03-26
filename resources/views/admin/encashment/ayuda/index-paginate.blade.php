@extends('layouts.default.admin.master')

@section('title', 'Ayuda Reimbursement List')

@section('page-title', 'Ayuda Reimbursement List')

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
                    <!-- <h6 class="element-header text-center">Reimbursement List</h6><br> -->
                    <div class="">
                        <h5 class="form-header text-center text-capitalize" id="title-encash">
                            @if (!empty($type))
                                {{ $type }}
                            @endif Reimbursement
                        </h5><br><br>
                        <div class="row">
                            <div class="col-md-3">
                                <label>Reimbursement Filter</label><br>
                                <div class="btn-group mr-1 mb-1">
                                    <button aria-expanded="false" aria-haspopup="true"
                                        class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="view_by"
                                        type="button">View Reimbursement by</button>
                                    <div aria-labelledby="view_by" class="dropdown-menu">
                                        <a class="dropdown-item filter-by @if ($type == 'all') active @endif"
                                            href="{{ route('admin.ayuda.encashments', 'all') }}" data-type="all"> All
                                            Reimbursement</a>
                                        <a class="dropdown-item filter-by @if ($type == 'pending') active @endif"
                                            href="{{ route('admin.ayuda.encashments', 'pending') }}" data-type="pending">
                                            Pending</a>
                                        {{-- <a class="dropdown-item filter-by @if ($type == 'hold') active @endif" href="{{ route('admin.ayuda.encashments','hold') }}" data-type="hold"> Hold</a> --}}
                                        <a class="dropdown-item filter-by @if ($type == 'decline') active @endif"
                                            href="{{ route('admin.ayuda.encashments', 'decline') }}" data-type="decline">
                                            Declined</a>
                                        {{-- <a class="dropdown-item filter-by @if ($type == 'approved') active @endif" href="{{ route('admin.ayuda.encashments','approved') }}" data-type="approved"> Approved</a> --}}
                                        <a class="dropdown-item filter-by @if ($type == 'claimed') active @endif"
                                            href="{{ route('admin.ayuda.encashments', 'claimed') }}" data-type="claimed">
                                            Claimed</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <form action="{{ route('admin.ayuda.encashments', $type) }}" method="get"
                                    id="form-search">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <label>From</label>
                                                <input type="date" class="form-control date-picker" name="date_start"
                                                    id="date_start" placeholder="Date" aria-label="Date"
                                                    aria-describedby="basic-addon2"
                                                    value="{{ $request->input('date_start') ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <label for="To">To</label>
                                                <input type="date" class="form-control date-picker" name="date_end"
                                                    id="date_end" placeholder="Date" aria-label="Date"
                                                    aria-describedby="basic-addon2"
                                                    value="{{ $request->input('date_end') ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <label for="To">Username</label>
                                                <input type="search" class="form-control" name="search" id="search"
                                                    placeholder="Search Username" aria-label="Date"
                                                    aria-describedby="basic-addon2"
                                                    value="{{ $request->input('search') ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6">
                                            <label>Search/Export</label><br>
                                            <div class="btn-group">
                                                <button class="btn btn-primary" id="search-button" name="button"
                                                    type="submit" value="search"><i data-feather="search"></i>
                                                    Search</button>
                                                <button class="btn btn-primary" id="export_button" name="button"
                                                    value="export" type="submit"><i data-feather="download"></i>
                                                    Export</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="encashment" width="100%" class="table table-striped table-lightfont">
                                <thead>
                                    <tr>
                                        <th>Date Requested</th>
                                        <th>Amount Requested</th>
                                        <th>Amount Approved</th>
                                        <th>Username</th>
                                        <th>Last Name</th>
                                        <th>First Name</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($encashments as $encash)
                                        @php
                                            $action_data = "<button aria-expanded='false' aria-haspopup='true' class='btn btn-primary dropdown-toggle' data-toggle='dropdown' id='dd_action' type='button'>Select Action</button>
                                <div aria-labelledby='dd_action' class='dropdown-menu'>";
                                            if ($encash->encash_status == 'pending') {
                                                $action_data .= "<a class='dropdown-item encash-view' href='#' data-id='$encash->tid' data-target='#view_encashment_modal' data-toggle='modal'> View Details</a>";
                                            
                                                $action_data .= "<a class='dropdown-item process-claim' href='#' data-id='$encash->tid' data-target='#claim_modal' data-toggle='modal'> Process claim</a>";
                                            
                                                //$action_data.="<a class='dropdown-item encash-hold' href='#' data-id='$encash->tid' data-target='#hold_modal' data-toggle='modal'> Hold</a>";
                                            
                                                $action_data .= "<a class='dropdown-item encash-decline' href='#' data-id='$encash->tid' data-target='#decline_modal' data-toggle='modal'> Decline</a> ";
                                            } elseif ($encash->encash_status == 'hold') {
                                                $action_data .= "<a class='dropdown-item encash-view' href='#' data-id='$encash->tid' data-target='#view_encashment_modal' data-toggle='modal'> View Details</a>";
                                            
                                                $action_data .= "<a class='dropdown-item encash-approved' href='#' data-id='$encash->tid' data-amount='$encash->amt_req' data-target='#approve_modal' data-toggle='modal'> Approved</a>";
                                            
                                                $action_data .= "<a class='dropdown-item encash-decline' href='#' data-id='$encash->tid' data-target='#decline_modal' data-toggle='modal'> Decline</a> ";
                                            } elseif ($encash->encash_status == 'approved') {
                                                $action_data .= "<a class='dropdown-item encash-view' href='#' data-id='$encash->tid' data-target='#view_encashment_modal' data-toggle='modal'> View Details</a>";
                                            
                                                $action_data .= "<a class='dropdown-item process-claim' href='#' data-id='$encash->tid' data-target='#claim_modal' data-toggle='modal'> Process claim</a>";
                                            
                                                //$action_data.="<a class='dropdown-item' href='/staff/ayuda/encashment-voucher/$encash->tid'> View receipt</a>";
                                            } elseif ($encash->encash_status == 'decline') {
                                                $action_data .= "<a class='dropdown-item encash-view' href='#' data-id='$encash->tid' data-target='#view_encashment_modal' data-toggle='modal'> View Details</a>";
                                            } else {
                                                $action_data .= "<a class='dropdown-item encash-view' href='#' data-id='$encash->tid' data-target='#view_encashment_modal' data-toggle='modal'> View Details</a>";
                                                $action_data .= "<a class='dropdown-item' href='/staff/ayuda/encashment-voucher/$encash->tid'> View receipt</a>";
                                            }
                                            $action_data .= '</div>';
                                            
                                        @endphp
                                        <tr>
                                            <td>{{ $encash->encash_created }}</td>
                                            <td>{{ $encash->amt_req }}</td>
                                            <td>{{ $encash->amt_appr }}</td>
                                            <td>{{ $encash->username }}</td>
                                            <td>{{ $encash->member_lname }}</td>
                                            <td>{{ $encash->member_fname }}</td>
                                            <td>{{ $encash->encash_status }}</td>
                                            <td>{!! $action_data !!}</td>
                                        </tr>
                                    @empty
                                        <tr class="text-center">
                                            <td colspan="8">No Reimbursements</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="pull-right">{{ $encashments->appends(request()->query())->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.encashment.ayuda.modal.approve')
            @include('admin.encashment.ayuda.modal.claim')
            @include('admin.encashment.ayuda.modal.decline')
            @include('admin.encashment.ayuda.modal.hold')
            @include('admin.encashment.ayuda.modal.view')
        </div>
    </div>



@endsection



@section('scripts')

    {{-- additional scripts here --}}

    <script>
        var filter_type = "{{ $type }}";
        var encashment_tax = "{{ env('TAX') }}";
        var processing_fee = "{{ env('PROCESS_FEE') }}";
        var process_encashment = "{{ route('admin.ayuda.process-encashment') }}";
        var all_encashment = "{{ route('admin.ayuda.all-encashment') }}";
    </script>

    <script src="{{ asset('js/admin/ayuda-encashment.js?v=1.2') }}"></script>
    <script>
        var start = moment();
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));

        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                    'month')]
            }
        }, cb);
        cb(start, end);
    </script>
@endsection
