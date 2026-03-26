@extends('layouts.default.master')
@section('title','Home')
@section('page-title','Home')

@section('stylesheets')
{{-- additional style here --}}
@endsection

@section('content')
<div class="content-body">
    <div class="content">
        <div class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="">My Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Registered Date</th>
                                <th scope="col">Sponsor</th>
                                <th scope="col">Member Type</th>
                                <th scope="col">Account Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td id="user_reg_date">User data</td>
                                <td id="user_sponsor">User data</td>
                                <td id="user_member_type">User data</td>
                                <td>Active</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="card-title mb-0">My Funds Wallet</h6>
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#transferFundsModal">
                        <i class="fas fa-exchange-alt"></i> Transfer Funds
                    </button>
                </div>
                <ul class="nav nav-tabs mb-3" role="tablist">
                <li class="nav-item">
                        <a class="nav-link active" id="referral-bonus-tab" data-toggle="tab" href="#referral-bonus"
                            role="tab" aria-controls="referral-bonus" aria-selected="false">Social Funds</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="charity-bonus-tab" data-toggle="tab" href="#charity-bonus"
                            role="tab" aria-controls="charity-bonus" aria-selected="false">Charity Funds</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" id="pairing-match-tab" data-toggle="tab" href="#pairing-match"
                            role="tab" aria-controls="pairing-match" aria-selected="false">Pairing Match Bonus</a>
                    </li> -->

                    <!-- <li class="nav-item">
                        <a class="nav-link" id="activation-cost-reward" data-toggle="tab" href="#pairing-reward"
                            role="tab" aria-controls="pairing-reward" aria-selected="false">Activation Cost Reward</a>
                    </li> -->
                    <!-- <li class="nav-item">
                        <a class="nav-link" id="income-stat-tab" data-toggle="tab" href="#income-stat" role="tab"
                            aria-controls="income-stat" aria-selected="false">Other Income</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" id="adjustments-tab" data-toggle="tab" href="#adjustments" role="tab"
                            aria-controls="adjustments" aria-selected="false">Other Funds </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="totals-tab" data-toggle="tab" href="#totals" role="tab"
                            aria-controls="totals" aria-selected="false">Summary</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-content">
                    <div class="tab-pane fade show active" id="referral-bonus" role="tabpanel"
                            aria-labelledby="referral-bonus-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card text-white bg-primary">
                                        <div class="card-header">Total Social Funds</div>
                                        <div class="card-body">
                                            <h5 class="card-title"><span id="Total_Direct_Referral">0 ¥</span></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="charity-bonus" role="tabpanel"
                            aria-labelledby="charity-bonus-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card text-white bg-primary">
                                        <div class="card-header">Total Charity Funds</div>
                                        <div class="card-body">
                                            <h5 class="card-title"><span id="Total_Charity_Bonus">0 ¥</span></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="pairing-match" role="tabpanel"
                            aria-labelledby="pairing-match-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card text-white bg-primary">
                                        <div class="card-header">Total Weekly Pairing Bonus</div>
                                        <div class="card-body">
                                            <h5 class="card-title"><span id="Total_Weekly_Pairing_Bonus">0 ¥</span>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{route('income-listing','sales-match-bonus')}}">
                                        <!--  -->
                                        <div class="card text-white bg-primary">
                                            <div class="card-header">Total Pairing Bonus</div>
                                            <div class="card-body">
                                                <h5 class="card-title"><span id="TPBunos">0 ¥</span></h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Pairing Reward Points -->
                        <!-- <div class="tab-pane fade show " id="pairing-reward" role="tabpanel"
                            aria-labelledby="activation-cost-reward">
                            <div class="row">

                                <div class="col-md-6">

                                    <div class="card text-white bg-primary">
                                        <div class="card-header">Total Weekly Activation Cost Reward</div>
                                        <div class="card-body">
                                            <h5 class="card-title"><span id="Total_Weekly_Pairing_Points">0
                                                    Points</span>
                                            </h5>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <a href="{{route('redeem.list')}}">

                                        <div class="card text-white bg-primary">
                                            <div class="card-header">Total Activation Cost Reward</div>
                                            <div class="card-body">
                                                <h5 class="card-title"><span id="TPRPoints">0 Points</span></h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div> -->

                        <div class="tab-pane fade show" id="Ayuda-Compensation-Bonus" role="tabpanel"
                            aria-labelledby="Ayuda-Compensation-Bonus-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{route('income-listing','Ayuda-Sales')}}">
                                        <div class="card text-white bg-primary">
                                            <div class="card-header">Total Ayuda Compensation Bonus</div>
                                            <div class="card-body">
                                                <h5 class="card-title"><span id="Total_Ayuda_Compensation_Bonus">0 ¥
                                                        </span></h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="income-stat" role="tabpanel" aria-labelledby="income-stat-tab">
                            <div class="row">
                                <!-- <div class="col-md-6">
                                    <div class="card text-white bg-primary">
                                        <div class="card-header">Total No. of Pairing Bonus</div>
                                        <div class="card-body">
                                            <h5 class="card-title"><span id="TPMatch">0</span></h5>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="col-md-6">
                                    <a href="{{route('total-income')}}">
                                        <div class="card text-white bg-primary">
                                            <div class="card-header">Total Other Funds</div>
                                            <div class="card-body">
                                                <h5 class="card-title"><span id="total_accumulated_income">0 ¥</span>
                                                </h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="adjustments" role="tabpanel" aria-labelledby="adjustments-tab">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="card text-white bg-success">
                                        <div class="card-header">Total Other Funds</div>
                                        <div class="card-body">
                                            <h5 class="card-title"><span id="total_added_income">0 ¥</span>
                                            </h5>
                                        </div>
                                    </div>
                                </div>


                              <!--  <div class="col-md-6">
                                    <div class="card text-white bg-danger">
                                        <div class="card-header">Total Deductions</div>
                                        <div class="card-body">
                                            <h5 class="card-title"><span id="total_deductions">0 ¥</span>
                                            </h5>
                                        </div>
                                    </div>
                                </div>-->


                            </div>
                        </div>
                        <div class="tab-pane fade" id="totals" role="tabpanel" aria-labelledby="totals-tab">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="card text-white bg-info">
                                        <div class="card-header">Total Social Funds</div>
                                        <div class="card-body">
                                            <h5 class="card-title"><span id="totals_referral_bonus">0 ¥</span></h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card text-white bg-success">
                                        <div class="card-header">Total Charity Funds</div>
                                        <div class="card-body">
                                            <h5 class="card-title"><span id="totals_charity_bonus">0 ¥</span></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="card text-white bg-warning">
                                        <div class="card-header">Total Other Funds</div>
                                        <div class="card-body">
                                            <h5 class="card-title"><span id="totals_added_income">0 ¥</span></h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card text-white bg-danger">
                                        <div class="card-header">Total Deductions</div>
                                        <div class="card-body">
                                            <h5 class="card-title"><span id="totals_deductions">0 ¥</span></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card text-white bg-primary">
                                        <div class="card-header">Available Funds</div>
                                        <div class="card-body">
                                            <h5 class="card-title"><span id="grand_total_income">0 ¥</span></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h6 class="card-title mb-3">Audit Trail History</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped table-hover">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Type</th>
                                                    <th>Amount</th>
                                                    <th>Recipient ID</th>
                                                    <th>Reason/Notes</th>
                                                </tr>
                                            </thead>
                                            <tbody id="adjustments_table_body">
                                                <tr>
                                                    <td colspan="5" class="text-center">Loading...</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>



            {{-- <div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-9">
                <div class="d-flex justify-content-between">
                    <h6 class="card-title">My Sponsor Downlines</h6>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="position">Position</label>
                    <select class="form-control" name="position" id="position">
                        <option value="" selected disabled>Select Position</option>
                        <option value="left">Left Position</option>
                        <option value="right">Right Position</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="table-responsive">
                    <table id="table_downline" class="table table-lg">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Username</th>
                                <th>Sponsor</th>
                                <th>Placement</th>
                                <th>Date of reg</th>
                                <th>Account Type</th>
                                <th>Geneology</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> --}}
            <!-- begin::footer -->

            <!-- end::footer -->
        </div>


        <!-- Transfer Funds Modal -->
        <div class="modal fade" id="transferFundsModal" tabindex="-1" role="dialog" aria-labelledby="transferFundsLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="transferFundsLabel">Transfer Other Funds</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="transferFundsForm">
                        <div class="modal-body">
                            <div class="alert alert-info" role="alert">
                                <strong>Available Balance:</strong> <span id="availableBalance">0 ¥</span>
                            </div>
                            
                            <div class="form-group">
                                <label for="fundSource">Deduct From *</label>
                                <select class="form-control" id="fundSource" name="fund_source" required>
                                    <option value="" selected disabled>Select fund source</option>
                                    <option value="social_funds">Social Funds</option>
                                    <option value="charity_funds">Charity Funds</option>
                                    <option value="other_funds">Other Funds</option>
                                </select>
                                <small class="form-text text-muted">Choose which fund to deduct the transfer amount from</small>
                                <div id="selectedFundBalance" style="margin-top: 10px; font-weight: 600; color: #28a745; display: none;"></div>
                            </div>

                            <div class="form-group">
                                <label for="recipientId">Recipient Sponsor ID *</label>
                                <input type="text" class="form-control" id="recipientId" name="recipient_id" placeholder="Enter recipient's sponsor ID (e.g., SIREG2025027)" required>
                                <small class="form-text text-muted">The member's sponsor ID you want to transfer funds to</small>
                                <div id="idValidationFeedback" style="margin-top: 10px; display: none;"></div>
                            </div>

                            <div class="form-group">
                                <label for="transferAmount">Amount to Transfer *</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="transferAmount" name="amount" placeholder="Enter amount" step="0.01" min="0" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">¥</span>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Minimum transfer amount: 1 ¥</small>
                            </div>

                            <div class="form-group">
                                <label for="transferReason">Reason for Transfer</label>
                                <textarea class="form-control" id="transferReason" name="reason" rows="3" placeholder="Optional: Enter reason for this transfer"></textarea>
                            </div>

                            <div id="transferError" class="alert alert-danger" role="alert" style="display: none;"></div>
                            <div id="transferSuccess" class="alert alert-success" role="alert" style="display: none;"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="submitTransferBtn">
                                <span class="spinner-border spinner-border-sm mr-2" id="transferSpinner" style="display: none;"></span>
                                Transfer Funds
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card">
            <!-- <div class="card-body">
                <h6 class="card-title">My Network Downlines</h6>
                <div class="table-responsive">
                    <div id="search-field" style="display:none;">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="ml-1">Filter</label>
                                <select class="form-control" name="filter-position" id="filter-position">
                                    <option value="">Select position</option>
                                    <option value="left">Left</option>
                                    <option value="right">Right</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="ml-1">Search</label>
                                <input type="text" class="form-control" placeholder="Search your network downline..."
                                    id="search_field">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="binary_table" width="100%" class="table table-striped table-lightfont border mt-3">
                            <thead>
                                <tr class="row_header">
                                    <th>Count</th> -->
                                    <!-- <th>Full Name</th>
                                    <th>Username</th>
                                    <th>Package</th>
                                    <th>Reg Date</th>
                                    <th>Sponsor</th>
                                    <th>Placement</th>
                                    <th>Position</th>
                                    <th>Top Position</th>
                                </tr>
                            </thead>
                            <tbody id="binary_table_body">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="showmore-container" class="text-center" style="display:none">
                    <button class="btn btn-primary" id="load-more">Load more data</button>
                    <button class="btn btn-primary" id="load-all">Show all</button>
                </div>
                <div id="loading-container">
                    <h5 class="text-center">Loading data...</h5>
                </div>
            </div> -->
        </div>


    </div>
    @include('layouts.default.footer')
    @endsection
    @section('scripts')
    {{-- additional scripts here --}}
    <script src="{{asset('js/user/home.js')}}"></script>
    <script>
        // Initialize available balance (Other Funds)
        function updateAvailableBalance() {
            var balance = $('#total_added_income').text().replace(/[^\d.]/g, '');
            $('#availableBalance').text(balance + ' ¥');
            return parseFloat(balance) || 0;
        }

        // Update all fund balances display
        function updateFundBalances() {
            var socialFunds = parseFloat($('#Total_Direct_Referral').text().replace(/[^\d.]/g, '')) || 0;
            var charityFunds = parseFloat($('#Total_Charity_Bonus').text().replace(/[^\d.]/g, '')) || 0;
            var otherFunds = parseFloat($('#total_added_income').text().replace(/[^\d.]/g, '')) || 0;
            
            // Update total available balance (for transfer modal)
            var totalAvailable = socialFunds + charityFunds + otherFunds;
            $('#availableBalance').text(totalAvailable.toFixed(2) + ' ¥');
            
            // Update summary totals
            $('#totals_referral_bonus').text(socialFunds.toFixed(2) + ' ¥');
            $('#totals_charity_bonus').text(charityFunds.toFixed(2) + ' ¥');
            $('#totals_added_income').text(otherFunds.toFixed(2) + ' ¥');
            
            // Calculate and update grand total (Available Funds = Sum of all current funds)
            var grandTotal = totalAvailable;
            $('#grand_total_income').text(grandTotal.toFixed(2) + ' ¥');
        }

        // Validate recipient ID
        $('#recipientId').on('blur', function() {
            var recipientId = $(this).val().trim();
            var feedbackDiv = $('#idValidationFeedback');
            
            if (!recipientId) {
                feedbackDiv.hide();
                return;
            }

            // Show loading state
            feedbackDiv.html('<small class="text-info"><i class="fas fa-spinner fa-spin"></i> Validating ID...</small>').show();

            $.ajax({
                url: '{{ route("validate-user-id", ":id") }}'.replace(':id', encodeURIComponent(recipientId)),
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success && response.exists) {
                        feedbackDiv.html('<small class="text-success"><i class="fas fa-check-circle"></i> ' + response.full_name + ' ✓</small>').show();
                    } else if (!response.success && response.message) {
                        feedbackDiv.html('<small class="text-danger"><i class="fas fa-times-circle"></i> ' + response.message + '</small>').show();
                    }
                },
                error: function(xhr) {
                    var message = 'Invalid ID';
                    try {
                        var response = xhr.responseJSON;
                        if (response && response.message) {
                            message = response.message;
                        }
                    } catch (e) {
                        console.log('Error parsing response:', e);
                    }
                    feedbackDiv.html('<small class="text-danger"><i class="fas fa-times-circle"></i> ' + message + '</small>').show();
                }
            });
        });

        // Transfer Funds Form Submission
        $('#transferFundsForm').on('submit', function(e) {
            e.preventDefault();
            
            var fundSource = $('#fundSource').val().trim();
            var recipientId = $('#recipientId').val().trim();
            var amount = parseFloat($('#transferAmount').val());
            var reason = $('#transferReason').val().trim();
            
            // Reset messages
            $('#transferError').hide();
            $('#transferSuccess').hide();
            
            // Validation
            if (!fundSource) {
                showTransferError('Please select a fund source');
                return false;
            }
            
            if (!recipientId) {
                showTransferError('Please enter recipient ID');
                return false;
            }
            
            if (!amount || amount <= 0) {
                showTransferError('Please enter a valid amount');
                return false;
            }
            
            // Get balance for selected fund source
            var fundBalances = {
                'social_funds': parseFloat($('#Total_Direct_Referral').text().replace(/[^\d.]/g, '')) || 0,
                'charity_funds': parseFloat($('#Total_Charity_Bonus').text().replace(/[^\d.]/g, '')) || 0,
                'other_funds': parseFloat($('#total_added_income').text().replace(/[^\d.]/g, '')) || 0
            };
            
            var selectedFundBalance = fundBalances[fundSource] || 0;
            
            if (amount > selectedFundBalance) {
                var fundNames = {
                    'social_funds': 'Social Funds',
                    'charity_funds': 'Charity Funds',
                    'other_funds': 'Other Funds'
                };
                showTransferError('Insufficient ' + fundNames[fundSource] + '. Available: ' + selectedFundBalance.toFixed(2) + ' ¥');
                return false;
            }
            
            // Submit transfer request
            submitTransfer(fundSource, recipientId, amount, reason);
        });

        function submitTransfer(fundSource, recipientId, amount, reason) {
            var submitBtn = $('#submitTransferBtn');
            var spinner = $('#transferSpinner');
            
            submitBtn.prop('disabled', true);
            spinner.show();
            
            $.ajax({
                url: '{{ route("transfer-funds") }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    fund_source: fundSource,
                    recipient_id: recipientId,
                    amount: amount,
                    reason: reason
                },
                success: function(response) {
                    showTransferSuccess('Funds transferred successfully! Transaction ID: ' + response.transaction_id);
                    $('#transferFundsForm')[0].reset();
                    $('#idValidationFeedback').hide();
                    $('#selectedFundBalance').hide();
                    updateFundBalances();
                    
                    // Reload audit trail data
                    loadAuditTrailHistory();
                    
                    // Close modal and reload dashboard data after successful transfer
                    setTimeout(function() {
                        $('#transferFundsModal').modal('hide');
                        location.reload();
                    }, 2000);
                },
                error: function(xhr) {
                    var errorMsg = 'Transfer failed. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    showTransferError(errorMsg);
                },
                complete: function() {
                    submitBtn.prop('disabled', false);
                    spinner.hide();
                }
            });
        }

        function showTransferError(message) {
            $('#transferError').text(message).show();
        }

        function showTransferSuccess(message) {
            $('#transferSuccess').text(message).show();
        }

        // Load audit trail history
        function loadAuditTrailHistory() {
            $.ajax({
                url: 'user/get-adjustment-history',
                type: 'GET',
                beforeSend: function() {
                    $('#adjustments_table_body').html('<tr><td colspan="5" class="text-center">Loading...</td></tr>');
                },
                success: function(response) {
                    if (response.success && response.data.length > 0) {
                        let html = '';
                        response.data.forEach(function(item) {
                            let rowClass = item.type === 'Added' ? 'table-success' : 'table-danger';
                            let amountClass = item.type === 'Added' ? 'text-success' : 'text-danger';

                            // Normalize and map certain note labels for display
                            let displayNotes = item.notes || '';
                            if (/Direct Referral Bonus/i.test(displayNotes)) {
                                displayNotes = 'Social Funds';
                            } else if (/Pairing Bonus/i.test(displayNotes)) {
                                displayNotes = 'Charity Funds';
                            } else if (/Fund transfer/i.test(displayNotes)) {
                                displayNotes = 'Fund Transfer - ' + displayNotes;
                            }

                            // Get recipient ID, display only if it's a fund transfer
                            let recipientId = item.recipient_id || '-';

                            html += '<tr class="' + rowClass + '">' +
                                '<td>' + item.date + '</td>' +
                                '<td><span class="badge ' + (item.type === 'Added' ? 'badge-success' : 'badge-danger') + '">' + item.type + '</span></td>' +
                                '<td class="' + amountClass + ' font-weight-bold">' + item.amount + '</td>' +
                                '<td>' + recipientId + '</td>' +
                                '<td>' + displayNotes + '</td>' +
                                '</tr>';
                        });
                        $('#adjustments_table_body').html(html);
                    } else {
                        $('#adjustments_table_body').html('<tr><td colspan="5" class="text-center text-muted">No adjustments found</td></tr>');
                    }
                },
                error: function(error) {
                    console.log('Error loading adjustment history:', error);
                    $('#adjustments_table_body').html('<tr><td colspan="5" class="text-center text-danger">Error loading data</td></tr>');
                }
            });
        }

        // Update balance when modal opens
        $('#transferFundsModal').on('show.bs.modal', function() {
            updateAvailableBalance();
            updateFundBalances();
        });

        // Update balance and calculations when Summary tab is clicked
        $('a[href="#totals"]').on('click', function() {
            setTimeout(function() {
                updateFundBalances();
            }, 100);
        });

        // Handle fund source change
        $('#fundSource').on('change', function() {
            var fundType = $(this).val();
            var balanceDiv = $('#selectedFundBalance');
            var balances = {
                'social_funds': {label: 'Social Funds', id: 'Total_Direct_Referral'},
                'charity_funds': {label: 'Charity Funds', id: 'Total_Charity_Bonus'},
                'other_funds': {label: 'Other Funds', id: 'total_added_income'}
            };
            
            if (fundType && balances[fundType]) {
                var balance = $('#' + balances[fundType].id).text().replace(/[^\d.]/g, '');
                balanceDiv.html('Available in ' + balances[fundType].label + ': <strong>¥ ' + balance + '</strong>').show();
            } else {
                balanceDiv.hide();
            }
        });

        var offset = 0;
        var cont_counter = 0; //continous counter
        var network_downline_data = [];
        var temp_data = [];
        $(document).ready(function () {
            loadMore(offset);

            $('#secret-table').DataTable();

            $('#load-more').click(function () {
                loadMore(offset);
            });
            $('#load-all').click(function () {
                //reset counter = 0
                cont_counter = 0;
                loadMore(0);
            });
            $('#search_field').on('keyup', function () {
                var value = $(this).val().toLowerCase().trim();
                var position_value = $('#filter-position').val().toLowerCase().trim();
                //live search
                if (position_value == '') {
                    $("#binary_table_body tr").each(function (index) {
                        if (index !== 0) {
                            $row = $(this);
                            $row.find("td").each(function () {
                                var id = $(this).text().toLowerCase().trim();
                                if (id.indexOf(value) < 0) {
                                    $row.hide();
                                } else {
                                    $row.show();
                                    return false;
                                }
                            });
                        }
                    });
                } else {
                    var table_name = '#binary_table_body .row_' + position_value;
                    $(table_name).each(function (index) {
                        if (index !== 0) {
                            $row = $(this);
                            $row.find("td").each(function () {
                                var id = $(this).text().toLowerCase().trim();
                                if (id.indexOf(value) < 0) {
                                    $row.hide();
                                } else {
                                    $row.show();
                                    return false;
                                }
                            });
                        }
                    });
                }
            });

            $('#filter-position').on('change', function () {
                var value = $(this).val().toLowerCase().trim();
                if (value != "" || value != null)
                    $("#binary_table_body tr").filter(function () {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
            });

        });

        function loadMore(count) {
            $.ajax({
                url: 'user/view-binary-list-data-top/' + count,
                type: 'GET',
                beforeSend: function () {
                    //console.log('Getting data...');
                    $('#loading-container').show();
                    $('#showmore-container').hide();
                },
                success: function (response) {
                    var counter = 0;
                    $.each(response.binary_left_data, function (i, value) {
                        counter++;
                        /* '<td>' + counter + '</td>' + */
                        $('#binary_table > tbody:last-child').append(
                            '<tr class="row_data text-capitalize row_' + value.position + '">' +
                            '<td>' + value.full_name + '</td>' +
                            '<td>' + value.user_name + '</td>' +
                            '<td>' + value.package + '</td>' +
                            '<td data-sort="' + value.reg_sort_format_date + '">' + value
                            .reg_date_time + '</td>' +
                            '<td>' + value.sponsor_username + '</td>' +
                            '<td>' + value.placement_username + '</td>' +
                            '<td class="position_class">' + value.position + '</td>' +
                            '<td>' + value.top_position + '</td>' +
                            '</tr>'
                        );
                    });

                    $.each(response.binary_right_data, function (i, value) {
                        counter++;
                        /* '<td>' + counter + '</td>' + */
                        $('#binary_table > tbody:last-child').append(
                            '<tr class="row_data text-capitalize row_' + value.position + '">' +
                            '<td>' + value.full_name + '</td>' +
                            '<td>' + value.user_name + '</td>' +
                            '<td>' + value.package + '</td>' +
                            '<td data-sort="' + value.reg_sort_format_date + '">' + value
                            .reg_date_time + '</td>' +
                            '<td>' + value.sponsor_username + '</td>' +
                            '<td>' + value.placement_username + '</td>' +
                            '<td class="position_class">' + value.position + '</td>' +
                            '<td>' + value.top_position + '</td>' +
                            '</tr>'
                        );
                    });

                    $('#binary_table').DataTable({
                        "order": [
                            [3, "desc"]
                        ]
                    });



                    offset = offset * 2;
                    if (offset === 0) {
                        offset = 30;
                    }

                    $('#showmore-container').show();
                    $('#loading-container').hide();

                    if (response.total.length == 0 || response.has_offset === false) {
                        $('#showmore-container').hide();
                        $('#loading-container').hide();
                    }
                },
                error: function (error) {
                    console.log('error...');
                    console.log(error);
                    $('#loading-container').hide();
                    $('#showmore-container').show();
                    swal({
                        title: "Warning",
                        text: "Something went wrong. Please try again later.",
                        type: "warning",
                    });
                }
            });
        }

        function loadMoreOld(count) {
            $.ajax({
                url: '/user/view-binary-list-data/' + count,
                type: 'GET',
                beforeSend: function () {
                    //console.log('Getting data...');
                    $('#loading-container').show();
                    $('#showmore-container').hide();
                },
                success: function (response) {
                    if (offset === 0)
                        var counter = 0;
                    else
                        var counter = parseInt($('#binary_table_body > tr:last-child td:nth-child(1)')
                        .text());
                    $.each(response.data, function (i, value) {
                        counter++;
                        /* '<td>' + counter + '</td>' + */
                        $('#binary_table > tbody:last-child').append(
                            '<tr class="row_data text-capitalize row_' + value.position + '">' +
                            '<td>' + value.full_name + '</td>' +
                            '<td>' + value.user_name + '</td>' +
                            '<td>' + value.package + '</td>' +
                            '<td data-sort="' + value.reg_sort_format_date + '">' + value
                            .reg_date_time + '</td>' +
                            '<td>' + value.sponsor_username + '</td>' +
                            '<td>' + value.placement_username + '</td>' +
                            '<td class="position_class">' + value.position + '</td>' +
                            '</tr>'
                        );
                    });

                    $('#binary_table').DataTable({
                        "order": [
                            [3, "desc"]
                        ]
                    });



                    offset = offset * 2;
                    if (offset === 0) {
                        offset = 30;
                    }

                    $('#showmore-container').show();
                    $('#loading-container').hide();

                    if (response.data.length == 0 || response.has_offset === false) {
                        $('#showmore-container').hide();
                        $('#loading-container').hide();
                    }
                },
                error: function (error) {
                    console.log('error...');
                    console.log(error);
                    $('#loading-container').hide();
                    $('#showmore-container').show();
                    swal({
                        title: "Warning",
                        text: "Something went wrong. Please try again later.",
                        type: "warning",
                    });
                }
            });
        }

    </script>
    @endsection
