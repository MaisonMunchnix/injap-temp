@extends('layouts.default.admin.master')
@section('title', 'Top Pairing & Referral')
@section('stylesheets')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <style>
        .border-red {
            border: 1px solid red !important;
        }

        #pairing-referral-table td {
            text-transform: capitalize !important;
        }

        .rank-badge {
            display: inline-block;
            width: 30px;
            height: 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            font-weight: bold;
        }

        .rank-badge.top1 { background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%); }
        .rank-badge.top2 { background: linear-gradient(135deg, #C0C0C0 0%, #A9A9A9 100%); }
        .rank-badge.top3 { background: linear-gradient(135deg, #CD7F32 0%, #8B4513 100%); }

        .highlight-row {
            background-color: #f0f8ff;
        }

        .amount-cell {
            text-align: right;
            font-weight: 500;
        }
        .rank-flex{
            display:flex;
            align-items:center;
            gap:10px;
        }

        /* default */
       .downline-count{
            background:#f1f5f9;
            color:#334155;
            font-size:12px;
            padding:6px 14px;
            border-radius:50px; /* makes it fully rounded */
            font-weight:600;
            border:1px solid #e2e8f0;
            display:inline-flex;
            align-items:center;
            justify-content:center;
        }

        /* highlight when >=30 */
        .downline-green{
            background:#16a34a;
            color:#fff;
            border:1px solid #15803d;
        }



    </style>
@endsection

@section('content')
    <div class="content-body">
        <div class="content">
            <div class="card">
                <div class="">
                    <div class="row">
                        <div class="col-md-12">
                            <br>
                            <h5 class="text-center">Top Pairing & Referral Earners</h5>
                            <p class="text-center text-muted">Members ranked by combined Pairing Bonus and Referral Bonus</p>
                            <br>
                        </div>
                    </div>
                    
                    <!-- Search Form -->
                    <div class="card-body border-bottom pb-3">
                        <form method="POST" action="{{ route('search-top-pairing-referral') }}" class="form-inline">
                            @csrf
                            <div class="form-group mr-2">
                                <input type="text" name="search" class="form-control" placeholder="Search username or name..." value="{{ request('search') }}">
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Search</button>
                            <a href="{{ route('top-pairing-referral') }}" class="btn btn-secondary btn-sm ml-2">Reset</a>
                        </form>
                    </div>
                    
                    <div class="card-body">
                        <div class="table-responsive border-bottom">
                            <table class="table thead-border-top-0" id="pairing-referral-table" style="width:100% !important">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>Downline</th>
                                        <th>Username</th>
                                        <th>Full Name</th>
                                        <th>Package</th>
                                        <th>Total Pairing</th>
                                        <th>Total Referral Bonus</th>
                                        <th>Total of Both</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    @if (!empty($query))
                                        @foreach ($query as $key => $user)
                                            @php
                                                $total_combined = $user->total_pairing + $user->total_referral;
                                            @endphp
                                            @if ($total_combined >= 0)
                                                <tr class="@if($key < 3) highlight-row @endif">
                                                    <td class="rank-cell" data-order="{{ $loop->iteration }}">
                                                        <div class="rank-flex">
                                                            <span class="rank-badge 
                                                                @if($loop->iteration == 1) top1 
                                                                @elseif($loop->iteration == 2) top2 
                                                                @elseif($loop->iteration == 3) top3 
                                                                @endif">
                                                                {{ $loop->iteration }}
                                                            </span>
                                                        </div>
                                                    </td>
                                                   <td data-order="{{ $user->downline_count }}">
                                                        <div class="downline-count 
                                                            @if($user->downline_count >= 30) downline-green @endif">
                                                            {{ $user->downline_count }}
                                                        </div>
                                                    </td>
                                                    <td>{{ $user->username }}</td>
                                                    <td>{{ $user->full_name }}</td>
                                                    <td>{{ $user->rank_type ?? 'N/A' }}</td>
                                                    <td class="amount-cell">¥ {{ number_format($user->total_pairing, 2, '.', ',') }}</td>
                                                    <td class="amount-cell">¥ {{ number_format($user->total_referral, 2, '.', ',') }}</td>
                                                    <td class="amount-cell" style="font-weight: bold; color: #667eea;">¥ {{ number_format($total_combined, 2, '.', ',') }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">No data available</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script>
    $(document).ready(function () { 
        $('#pairing-referral-table').DataTable({
            paging: true,
            ordering: true,
            searching: false,
            info: true,
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            order: [[7, "desc"]],
            columnDefs: [
                { type: "num", targets: [0,1,5,6,7] }
            ],
            dom: 'lBfrtip',   // ← add "l" back here
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'Top Pairing & Referral Earners',
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function (data, row, column, node) {
                                return $(node).text().trim();
                            }
                        }
                    }
                }
            ]
        });
    });
</script>
@endsection
