@extends('layouts.default.admin.master')
@section('title', 'All Members')
@section('page-title', 'Add Users')

@section('stylesheets')
    <style>
        .border-red {
            border: 1px solid red !important;
        }
    </style>
@endsection

@section('content')
    <div class="content-body">
        <!-- start content- -->
        <div class="content">
            <div class="page-header">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">Distributor List</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                    </ol>
                </nav>
            </div>
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">@yield('title')</h6>
                    <div class="row">
                        <div class="col-md-3 offset-md-9">
                            <div class="mb-3">
                                <a href="{{ route('members.export', ['search' => request('search')]) }}" class="btn btn-success btn-block text-white">
                                    <i class="feather feather-download"></i> Export to Excel
                                </a>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('members-all.post') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-3 offset-md-9">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="search" value="{{ old('search') }}"
                                        required>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="feather feather-search"></i> Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <table id="members_table" class="table table-striped table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Country</th>
                                <th>Package</th>
                                <th>Sponsor ID</th>
                                <th>Upline Sponsor</th>
                                <th>Password</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Total Income</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Username</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Country</th>
                                <th>Package</th>
                                <th>Sponsor ID</th>
                                <th>Upline Sponsor</th>
                                <th>Password</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Total Income</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($users as $user)
                                @php
                                    if ($user->status == 0) {
                                        $status = 'Inactive';
                                        $status_label = 'Activate';
                                        $color = 'danger';
                                        $icon = 'icon-check';
                                    } elseif ($user->status == 1) {
                                        $status = 'Active';
                                        $icon = 'icon-x';
                                        $color = 'success';
                                        $status_label = 'Deactivate';
                                    } elseif ($user->status == 2) {
                                        $status = 'Inactive';
                                        $status_label = 'Activate';
                                        $icon = 'icon-check';
                                        $color = 'danger';
                                    } else {
                                        $status = 'Not Define';
                                        $status_label = 'Not Define';
                                        $icon = 'la-question';
                                        $color = 'default';
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->first_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->country_name ?? 'N/A' }}</td>
                                    <td>{{ $user->package }}</td>
                                    <td>{{ $user->sponsor_id }}</td>
                                    <td>{{ $user->sponsor ?? 'N/A' }}</td>
                                    <td>{{ $user->plain_pass }}</td>
                                    <td><span class="text-{{ $color }}">{{ $status }}</span></td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>
                                        {{ !empty($user->total_income) ? number_format($user->total_income, 2) : '0.00' }}
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button"
                                                data-toggle="dropdown">Action</button>
                                            <div class="dropdown-menu">
                                                <a href="#" class="dropdown-item editModalBtn" data-toggle="modal"
                                                    data-id="{{ $user->user_id }}" data-toggle="tooltip"
                                                    data-placement="top" title="Edit"><i class="feather icon-edit-2"></i>
                                                    Edit</a>
                                                {{-- View Geneology --}}
                                                @php
                                                    $auth_id_crypt = Crypt::encrypt($user->user_id);
                                                @endphp
                                                <a href="{{ route('view-member-geneology', $auth_id_crypt) }}"
                                                    class="dropdown-item"
                                                    target="_blank"
                                                    title="View Geneology">
                                                        <i class="feather icon-git-branch"></i> View Geneology
                                                </a>
                                                <a href="#" class="dropdown-item edit-password" data-toggle="modal"
                                                    data-id="{{ $user->user_id }}" data-toggle="tooltip"
                                                    data-placement="top" title="Edit"><i class="feather icon-edit-2"></i>
                                                    Change Password</a>
                                                <a href="#" class="dropdown-item btn-view modifyUser"
                                                    data-id="{{ $user->user_id }}" data-toggle="tooltip"
                                                    data-placement="top" title="{{ $status_label }}"><i
                                                        class="feather {{ $icon }}"></i>{{ $status_label }}</a>
                                                <div class="dropdown-divider"></div>
                                                <a href="#" class="dropdown-item view-income-btn" data-toggle="modal"
                                                    data-target="#viewIncomeModal" data-id="{{ $user->user_id }}"
                                                    data-username="{{ $user->username }}" title="View Added Incomes"><i
                                                        class="feather icon-eye"></i> View Added Incomes</a>
                                                <a href="#" class="dropdown-item add-income-btn" data-toggle="modal"
                                                    data-target="#addIncomeModal" data-id="{{ $user->user_id }}"
                                                    data-username="{{ $user->username }}" title="Add Income"><i
                                                        class="feather icon-plus"></i> Add Income</a>
                                                <a href="#" class="dropdown-item deduct-income-btn" data-toggle="modal"
                                                    data-target="#deductIncomeModal" data-id="{{ $user->user_id }}"
                                                    data-username="{{ $user->username }}" title="Deduct Income"><i
                                                        class="feather icon-minus"></i> Deduct Income</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pull-right">{{ $users->links() }}</div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.members.edit-modal')
    @include('admin.members.edit-password-modal')
    
    <!-- Add Income Modal -->
    <div class="modal fade" id="addIncomeModal" tabindex="-1" role="dialog" aria-labelledby="addIncomeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addIncomeModalLabel">Add Income</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addIncomeForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="addIncomeUsername">Username</label>
                            <input type="text" class="form-control" id="addIncomeUsername" readonly>
                        </div>
                        <div class="form-group">
                            <label for="addIncomeAmount">Amount to Add</label>
                            <input type="number" class="form-control" id="addIncomeAmount" placeholder="Enter amount" step="0.01" min="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="addIncomeType">Income Type</label>
                            <select class="form-control" id="addIncomeType" required>
                                <option value="">Select Type</option>
                                <!-- <option value="direct_referral_bonus">Referral Bonus</option> -->
                                <option value="manual_adjustment">Other Income</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="addIncomeReason">Reason/Notes</label>
                            <textarea class="form-control" id="addIncomeReason" rows="3" placeholder="Enter reason for adding income"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Income</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Deduct Income Modal -->
    <div class="modal fade" id="deductIncomeModal" tabindex="-1" role="dialog" aria-labelledby="deductIncomeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deductIncomeModalLabel">Deduct Income</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deductIncomeForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="deductIncomeUsername">Username</label>
                            <input type="text" class="form-control" id="deductIncomeUsername" readonly>
                        </div>
                        <div class="form-group">
                            <label for="deductIncomeAmount">Amount to Deduct</label>
                            <input type="number" class="form-control" id="deductIncomeAmount" placeholder="Enter amount" step="0.01" min="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="deductIncomeType">Income Type</label>
                            <select class="form-control" id="deductIncomeType" required>
                                <option value="">Select Type</option>
                                <option value="direct_referral_bonus">Referral Bonus</option>
                                <option value="manual_adjustment">Other Income</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="deductIncomeReason">Reason/Notes</label>
                            <textarea class="form-control" id="deductIncomeReason" rows="3" placeholder="Enter reason for deducting income"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Deduct Income</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Added Incomes Modal -->
    <div class="modal fade" id="viewIncomeModal" tabindex="-1" role="dialog" aria-labelledby="viewIncomeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewIncomeModalLabel">Added Incomes for <span id="incomeUsername"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="incomeListLoading" class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <table id="incomeListTable" class="table table-striped table-bordered table-sm" style="display: none;">
                        <thead>
                            <tr>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Remarks</th>
                                <th>Date Added</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="incomeListBody">
                        </tbody>
                    </table>
                    <div id="incomeListEmpty" class="alert alert-info" style="display: none;">
                        No manually added incomes found.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Income Modal -->
    <div class="modal fade" id="editIncomeModal" tabindex="-1" role="dialog" aria-labelledby="editIncomeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editIncomeModalLabel">Edit Income</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editIncomeForm">
                    <div class="modal-body">
                        <input type="hidden" id="editIncomeId">
                        <div class="form-group">
                            <label for="editIncomeAmount">Amount</label>
                            <input type="number" class="form-control" id="editIncomeAmount" placeholder="Enter amount" step="0.01" min="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="editIncomeRemarks">Remarks</label>
                            <textarea class="form-control" id="editIncomeRemarks" rows="3" placeholder="Enter remarks"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Income</button>
                    </div>
                </form>
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
                "paging": false,
                "bFilter": false
            });

            // View Added Incomes Modal
            $(document).on('click', '.view-income-btn', function(e) {
                e.preventDefault();
                var userId = $(this).data('id');
                var username = $(this).data('username');
                $('#incomeUsername').text(username);
                loadAddedIncomes(userId);
                $('#viewIncomeModal').data('user-id', userId);
            });

            // Add Income Modal
            $(document).on('click', '.add-income-btn', function(e) {
                e.preventDefault();
                var userId = $(this).data('id');
                var username = $(this).data('username');
                $('#addIncomeUsername').val(username);
                $('#addIncomeForm').data('user-id', userId);
            });

            // Deduct Income Modal
            $(document).on('click', '.deduct-income-btn', function(e) {
                e.preventDefault();
                var userId = $(this).data('id');
                var username = $(this).data('username');
                $('#deductIncomeUsername').val(username);
                $('#deductIncomeForm').data('user-id', userId);
            });

            function loadAddedIncomes(userId) {
                $('#incomeListLoading').show();
                $('#incomeListTable').hide();
                $('#incomeListEmpty').hide();
                
                $.ajax({
                    url: '{{ route("staff.income-list", ["user_id" => "USERID"]) }}'.replace('USERID', userId),
                    type: 'GET',
                    success: function(response) {
                        $('#incomeListLoading').hide();
                        
                        if (response.success && response.data.length > 0) {
                            var html = '';
                            response.data.forEach(function(income) {
                                html += '<tr>';
                                html += '<td>' + parseFloat(income.amount).toFixed(2) + '</td>';
                                html += '<td>' + income.type_label + '</td>';
                                html += '<td>' + (income.remarks || 'N/A') + '</td>';
                                html += '<td>' + income.created_at + '</td>';
                                html += '<td>';
                                html += '<button type="button" class="btn btn-sm btn-primary edit-income-button" data-id="' + income.id + '" data-amount="' + income.amount + '" data-remarks="' + (income.remarks || '') + '"><i class="feather icon-edit-2"></i> Edit</button> ';
                                html += '<button type="button" class="btn btn-sm btn-danger delete-income-button" data-id="' + income.id + '"><i class="feather icon-trash"></i> Delete</button>';
                                html += '</td>';
                                html += '</tr>';
                            });
                            $('#incomeListBody').html(html);
                            $('#incomeListTable').show();
                        } else {
                            $('#incomeListEmpty').show();
                        }
                    },
                    error: function(error) {
                        $('#incomeListLoading').hide();
                        $('#incomeListEmpty').show();
                        console.log(error);
                    }
                });
            }

            // Edit Income Button Click
            $(document).on('click', '.edit-income-button', function(e) {
                e.preventDefault();
                var incomeId = $(this).data('id');
                var amount = $(this).data('amount');
                var remarks = $(this).data('remarks');
                
                $('#editIncomeId').val(incomeId);
                $('#editIncomeAmount').val(amount);
                $('#editIncomeRemarks').val(remarks);
                
                $('#editIncomeModal').modal('show');
            });

            // Handle Edit Income Form Submission
            $('#editIncomeForm').on('submit', function(e) {
                e.preventDefault();
                var incomeId = $('#editIncomeId').val();
                var amount = $('#editIncomeAmount').val();
                var remarks = $('#editIncomeRemarks').val();

                $.ajax({
                    url: '{{ route("staff.income-update", ["id" => "INCOMEID"]) }}'.replace('INCOMEID', incomeId),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        amount: amount,
                        remarks: remarks
                    },
                    success: function(response) {
                        if(response.success) {
                            swal({
                                title: "Success!",
                                text: response.message,
                                type: "success"
                            });
                            $('#editIncomeModal').modal('hide');
                            var userId = $('#viewIncomeModal').data('user-id');
                            loadAddedIncomes(userId);
                            
                            // Reload page after 1.5 seconds to update total income
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        } else {
                            swal("Error", response.message, "error");
                        }
                    },
                    error: function(error) {
                        swal("Error", "Something went wrong. Please try again.", "error");
                        console.log(error);
                    }
                });
            });

            // Delete Income Button Click
            $(document).on('click', '.delete-income-button', function(e) {
                e.preventDefault();
                var incomeId = $(this).data('id');

                if (confirm("Are you sure you want to delete this income? This action cannot be undone!")) {
                    $.ajax({
                        url: '{{ route("staff.income-delete", ["id" => "INCOMEID"]) }}'.replace('INCOMEID', incomeId),
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if(response.success) {
                                swal({
                                    title: "Success!",
                                    text: response.message,
                                    type: "success"
                                });
                                var userId = $('#viewIncomeModal').data('user-id');
                                loadAddedIncomes(userId);
                                
                                // Reload page after 1.5 seconds to update total income
                                setTimeout(function() {
                                    location.reload();
                                }, 1500);
                            } else {
                                swal("Error", response.message, "error");
                            }
                        },
                        error: function(error) {
                            swal("Error", "Something went wrong. Please try again.", "error");
                            console.log(error);
                        }
                    });
                }
            });

            // Handle Add Income Form Submission
            $('#addIncomeForm').on('submit', function(e) {
                e.preventDefault();
                var userId = $(this).data('user-id');
                var amount = $('#addIncomeAmount').val();
                var type = $('#addIncomeType').val();
                var reason = $('#addIncomeReason').val();

                $.ajax({
                    url: '{{ route("staff.add-income") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        user_id: userId,
                        amount: amount,
                        referral_type: type,
                        reason: reason
                    },
                    success: function(response) {
                        if(response.success) {
                            swal({
                                title: "Success!",
                                text: response.message,
                                type: "success"
                            });
                            $('#addIncomeModal').modal('hide');
                            $('#addIncomeForm')[0].reset();
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        } else {
                            swal("Error", response.message, "error");
                        }
                    },
                    error: function(error) {
                        swal("Error", "Something went wrong. Please try again.", "error");
                        console.log(error);
                    }
                });
            });

            // Handle Deduct Income Form Submission
            $('#deductIncomeForm').on('submit', function(e) {
                e.preventDefault();
                var userId = $(this).data('user-id');
                var amount = $('#deductIncomeAmount').val();
                var type = $('#deductIncomeType').val();
                var reason = $('#deductIncomeReason').val();

                $.ajax({
                    url: '{{ route("staff.deduct-income") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        user_id: userId,
                        amount: amount,
                        referral_type: type,
                        reason: reason
                    },
                    success: function(response) {
                        if(response.success) {
                            swal({
                                title: "Success!",
                                text: response.message,
                                type: "success"
                            });
                            $('#deductIncomeModal').modal('hide');
                            $('#deductIncomeForm')[0].reset();
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        } else {
                            swal("Error", response.message, "error");
                        }
                    },
                    error: function(error) {
                        swal("Error", "Something went wrong. Please try again.", "error");
                        console.log(error);
                    }
                });
            });


        });
    </script>
@endsection
