@extends('layouts.default.admin.master')
@section('title','Payment Management')
@section('page-title','Payment Management')

@section('stylesheets')
<style>
    .payment-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .payment-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
        cursor: pointer;
    }

    .payment-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.15);
    }

    .payment-image {
        width: 100%;
        height: 200px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }

    .payment-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .payment-image.no-image {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-size: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .payment-body {
        padding: 15px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .payment-user {
        font-size: 14px;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }

    .payment-date {
        font-size: 12px;
        color: #999;
        margin-bottom: 10px;
    }

    .payment-notes {
        font-size: 13px;
        color: #666;
        margin-bottom: 10px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex-grow: 1;
    }

    .payment-status {
        margin-bottom: 12px;
    }

    .payment-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 10px;
        border-top: 1px solid #eee;
    }

    .payment-filename {
        font-size: 11px;
        color: #999;
        flex-grow: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #999;
    }

    .empty-state-icon {
        font-size: 48px;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    @media (max-width: 768px) {
        .payment-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
        }

        .payment-image {
            height: 150px;
        }
    }
</style>
@endsection

@section('content')
<div class="content-body">
    <div class="content">
        <div class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin-dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Payment Management</li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Payment Management</h4>
                <div style="display: flex; gap: 15px; margin-left: auto; align-items: center;">
                    <form method="GET" action="{{ route('admin.payments.index') }}" style="display: flex; gap: 10px;">
                        <input type="hidden" name="status" value="{{ $status }}">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search by name or filename..." value="{{ $search }}" style="width: 250px;">
                        <button type="submit" class="btn btn-sm btn-primary">Search</button>
                        @if($search)
                            <a href="{{ route('admin.payments.index', ['status' => $status]) }}" class="btn btn-sm btn-outline-secondary">Clear</a>
                        @endif
                    </form>
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.payments.index', ['status' => 'all', 'search' => $search]) }}" 
                            class="btn btn-sm {{ $status === 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                            All
                        </a>
                        <a href="{{ route('admin.payments.index', ['status' => 'pending', 'search' => $search]) }}" 
                            class="btn btn-sm {{ $status === 'pending' ? 'btn-warning' : 'btn-outline-warning' }}">
                            Pending
                        </a>
                        <a href="{{ route('admin.payments.index', ['status' => 'approved', 'search' => $search]) }}" 
                            class="btn btn-sm {{ $status === 'approved' ? 'btn-success' : 'btn-outline-success' }}">
                            Approved
                        </a>
                        <a href="{{ route('admin.payments.index', ['status' => 'rejected', 'search' => $search]) }}" 
                            class="btn btn-sm {{ $status === 'rejected' ? 'btn-danger' : 'btn-outline-danger' }}">
                            Rejected
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Alert Messages -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <!-- Payments Grid -->
                <div class="payment-grid" id="paymentsGrid">
                    @forelse ($payments as $payment)
                        <div class="payment-card" onclick="viewPaymentDetail({{ $payment->id }})">
                            <div class="payment-image">
                                @php
                                    $extension = strtolower(pathinfo($payment->original_filename, PATHINFO_EXTENSION));
                                    $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif']);
                                @endphp
                                @if ($isImage)
                                    <img src="/{{ $payment->file_path }}" alt="{{ $payment->original_filename }}">
                                @else
                                    <div class="no-image" style="flex-direction: column; gap: 10px;">
                                        <i data-feather="file-text" style="width: 60px; height: 60px; color: white;"></i>
                                        <span style="font-size: 12px;">{{ strtoupper($extension) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="payment-body">
                                <div class="payment-user">{{ $payment->user->first_name ?? $payment->user_name }}</div>
                                <div class="payment-date">{{ $payment->created_at->format('M d, Y h:i A') }}</div>
                                @if ($payment->notes)
                                    <div class="payment-notes">{{ $payment->notes }}</div>
                                @else
                                    <div class="payment-notes text-muted">-</div>
                                @endif
                                <div class="payment-status">
                                    @if ($payment->status === 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif ($payment->status === 'approved')
                                        <span class="badge badge-success">Approved</span>
                                    @elseif ($payment->status === 'rejected')
                                        <span class="badge badge-danger">Rejected</span>
                                    @endif
                                </div>
                                <div class="payment-footer">
                                    <div class="payment-filename" title="{{ $payment->original_filename }}">
                                        {{ $payment->original_filename }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div style="grid-column: 1 / -1;">
                            <div class="empty-state">
                                <div class="empty-state-icon">💳</div>
                                <h4>No payments found</h4>
                                <p>Try changing the status filter</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if ($payments->hasPages())
                    <nav aria-label="Page navigation" class="mt-4">
                        {{ $payments->links() }}
                    </nav>
                @endif
            </div>
        </div>
    </div>
    @include('layouts.default.footer')
</div>

<!-- Payment Detail Modal -->
<div class="modal fade" id="paymentDetailModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment Details</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="paymentModalBody">
                <!-- Payment details will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve Payment</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="approveForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="admin_notes" class="form-label">Admin Notes (Optional)</label>
                        <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3" 
                            placeholder="Add notes for the user..." maxlength="500"></textarea>
                        <small class="form-text text-muted">Maximum 500 characters</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i data-feather="check"></i> Approve
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Payment</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="rejection_reason" class="form-label">Reason for Rejection <span style="color: red;">*</span></label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" 
                            placeholder="Explain why this payment is being rejected..." maxlength="500" required></textarea>
                        <small class="form-text text-muted">Maximum 500 characters</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i data-feather="x"></i> Reject
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    let currentPaymentId = null;

    function viewPaymentDetail(paymentId) {
        $.ajax({
            url: '{{ route('admin.payments.show', '') }}/' + paymentId,
            type: 'GET',
            success: function(response) {
                // Payment data returned directly from controller
                const payment = response;
                
                if (payment) {
                    const extension = payment.original_filename.split('.').pop().toUpperCase();
                    const isImage = ['JPG', 'JPEG', 'PNG', 'GIF'].includes(extension.toUpperCase());
                    
                    let attachmentHtml = '';
                    if (isImage && payment.file_path) {
                        attachmentHtml = `<img src="${payment.file_path}" alt="${payment.original_filename}" style="width: 100%; max-height: 400px; object-fit: contain; border-radius: 4px; margin-bottom: 20px;">`;
                    } else {
                        attachmentHtml = `
                            <div style="width: 100%; height: 300px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 4px; margin-bottom: 20px; display: flex; align-items: center; justify-content: center; flex-direction: column; gap: 10px;">
                                <i data-feather="file-text" style="width: 80px; height: 80px; color: white;"></i>
                                <span style="color: white; font-size: 16px; font-weight: 600;">${extension}</span>
                            </div>
                        `;
                    }

                    const statusBadge = payment.status === 'pending' ? 
                        '<span class="badge badge-warning">Pending</span>' :
                        payment.status === 'approved' ? 
                        '<span class="badge badge-success">Approved</span>' :
                        '<span class="badge badge-danger">Rejected</span>';

                    let actionButtons = '';
                    if (payment.status === 'pending') {
                        actionButtons = `
                            <div style="margin-top: 20px; display: flex; gap: 10px;">
                                <button class="btn btn-success" data-dismiss="modal" onclick="showApproveModal(${paymentId})">
                                    <i data-feather="check"></i> Approve
                                </button>
                                <button class="btn btn-danger" data-dismiss="modal" onclick="showRejectModal(${paymentId})">
                                    <i data-feather="x"></i> Reject
                                </button>
                                <a href="${payment.file_path}" class="btn btn-info" download>
                                    <i data-feather="download"></i> Download
                                </a>
                            </div>
                        `;
                    } else {
                        actionButtons = `
                            <div style="margin-top: 20px;">
                                <a href="${payment.file_path}" class="btn btn-info" download>
                                    <i data-feather="download"></i> Download
                                </a>
                            </div>
                        `;
                    }

                    const html = `
                        <div>
                            ${attachmentHtml}
                            <div style="background: #f8f9fa; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
                                <p style="margin-bottom: 10px;"><strong>User Name:</strong> ${payment.user_name}</p>
                                <p style="margin-bottom: 10px;"><strong>Upload Date:</strong> ${new Date(payment.created_at).toLocaleString()}</p>
                                <p style="margin-bottom: 10px;"><strong>Filename:</strong> ${payment.original_filename}</p>
                                <p style="margin-bottom: 10px;"><strong>Status:</strong> ${statusBadge}</p>
                                ${payment.notes ? `<p style="margin-bottom: 0;"><strong>Notes:</strong> ${payment.notes}</p>` : ''}
                            </div>
                            ${actionButtons}
                        </div>
                    `;

                    $('#paymentModalBody').html(html);
                    $('#paymentDetailModal').modal('show');
                    feather.replace();
                }
            },
            error: function(error) {
                console.log('Error loading payment:', error);
                alert('Error loading payment details');
            }
        });
    }

    function showApproveModal(paymentId) {
        currentPaymentId = paymentId;
        $('#approveModal').modal('show');
    }

    function showRejectModal(paymentId) {
        currentPaymentId = paymentId;
        $('#rejectModal').modal('show');
    }

    function setPaymentId(paymentId) {
        currentPaymentId = paymentId;
    }

    // Approve form submission
    $('#approveForm').on('submit', function(e) {
        e.preventDefault();
        if (currentPaymentId) {
            this.action = '/staff/payments/' + currentPaymentId + '/approve';
            this.submit();
        }
    });

    // Reject form submission
    $('#rejectForm').on('submit', function(e) {
        e.preventDefault();
        if (currentPaymentId) {
            this.action = '/staff/payments/' + currentPaymentId + '/reject';
            this.submit();
        }
    });

    // Reset modals when hidden
    $('#approveModal').on('hidden.bs.modal', function() {
        $('#approveForm')[0].reset();
        currentPaymentId = null;
    });

    $('#rejectModal').on('hidden.bs.modal', function() {
        $('#rejectForm')[0].reset();
        currentPaymentId = null;
    });

    $('#paymentDetailModal').on('hidden.bs.modal', function() {
        $('#paymentModalBody').html('');
    });
</script>
@endsection
