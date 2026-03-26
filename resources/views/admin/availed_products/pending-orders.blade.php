@extends('layouts.default.admin.master')
@section('title','Pending Availed Products')
@section('page-title','Pending Availed Products')

@section('stylesheets')
<style>
    .order-card {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        margin-bottom: 20px;
        overflow: hidden;
        transition: box-shadow 0.3s ease;
    }

    .order-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .order-card-header {
        padding: 20px;
        border-bottom: 1px solid #e0e0e0;
        background: #f8f9fa;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .order-card-header h5 {
        margin: 0;
        font-weight: 600;
    }

    .order-info {
        font-size: 13px;
        color: #666;
        margin-top: 5px;
    }

    .order-card-body {
        padding: 20px;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .order-detail-item {
        display: flex;
        flex-direction: column;
    }

    .detail-label {
        font-size: 12px;
        color: #999;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .detail-value {
        font-size: 15px;
        color: #333;
        font-weight: 500;
    }

    .total-price {
        font-size: 20px;
        color: #28a745;
        font-weight: 700;
    }

    .order-card-footer {
        padding: 15px 20px;
        background: #f8f9fa;
        border-top: 1px solid #e0e0e0;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    .badge-status {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-pending {
        background: #fff3cd;
        color: #856404;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #999;
    }

    .empty-state-icon {
        font-size: 64px;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    @media (max-width: 768px) {
        .order-card-body {
            grid-template-columns: 1fr;
        }

        .order-card-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .order-card-footer {
            flex-direction: column;
        }

        .order-card-footer button {
            width: 100%;
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
                    <li class="breadcrumb-item active" aria-current="page">Pending Availed Products</li>
                </ol>
            </nav>
        </div>

        <div style="margin-bottom: 30px;">
            <h2 style="color: #333; font-weight: 600; margin-bottom: 10px;">Pending Availed Products</h2>
            <p style="color: #666; font-size: 14px;">Review and approve member product orders</p>
            <a href="{{ route('admin.products') }}" class="btn btn-secondary" style="margin-top: 10px;">
                <i data-feather="arrow-left"></i> Back to Products
            </a>
        </div>

        @if($orders->count() > 0)
            <div id="ordersContainer">
                @foreach($orders as $order)
                    <div class="order-card" data-order-id="{{ $order->id }}">
                        <div class="order-card-header">
                            <div>
                                <h5>{{ $order->product->product_name ?? 'Product' }} - Order #{{ $order->id }}</h5>
                                <div class="order-info">
                                    <strong>Member:</strong> {{ $order->user ? ($order->user->username ?? $order->user->name ?? 'Unknown') : 'Unknown' }}
                                    <br>
                                    <strong>Ordered on:</strong> {{ $order->created_at ? $order->created_at->format('M d, Y H:i') : 'N/A' }}
                                </div>
                            </div>
                            <div>
                                <span class="badge-status badge-pending">{{ ucfirst($order->status) }}</span>
                            </div>
                        </div>

                        <div class="order-card-body">
                            <div class="order-detail-item">
                                <div class="detail-label">Product</div>
                                <div class="detail-value">{{ $order->product->product_name ?? 'N/A' }}</div>
                            </div>

                            <div class="order-detail-item">
                                <div class="detail-label">Quantity</div>
                                <div class="detail-value">{{ $order->quantity }}</div>
                            </div>

                            <div class="order-detail-item">
                                <div class="detail-label">Unit Price</div>
                                <div class="detail-value">¥ {{ number_format($order->product->price ?? 0, 2) }}</div>
                            </div>

                            <div class="order-detail-item">
                                <div class="detail-label">Total Price</div>
                                <div class="total-price">¥ {{ number_format($order->total_price, 2) }}</div>
                            </div>

                            <div class="order-detail-item" style="grid-column: 1 / -1;">
                                <div class="detail-label">Member Details</div>
                                <div class="detail-value">
                                    @if($order->user)
                                        {{ $order->user->username ?? $order->user->name ?? 'Unknown' }}
                                    @else
                                        Unknown (ID: {{ $order->user_id }})
                                    @endif
                                </div>
                            </div>

                            <div class="order-detail-item" style="grid-column: 1 / -1;">
                                <div class="detail-label">Attachment <span style="color: #dc3545;">*</span></div>
                                <div class="detail-value">
                                    @if($order->attachment)
                                        <a href="/{{ $order->attachment }}" target="_blank" class="btn btn-sm btn-info">
                                            <i data-feather="download" style="width: 14px; height: 14px;"></i> Download
                                        </a>
                                        <span style="color: #28a745; margin-left: 10px;">
                                            <i data-feather="check-circle" style="width: 16px; height: 16px; vertical-align: middle;"></i> Required
                                        </span>
                                    @else
                                        <span style="color: #dc3545;">
                                            <i data-feather="alert-circle" style="width: 16px; height: 16px; vertical-align: middle;"></i> Attachment required before approval
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="order-card-footer">
                            <button class="btn btn-secondary btn-sm" onclick="showAttachModal({{ $order->id }})">
                                <i data-feather="paperclip" style="width: 16px; height: 16px; margin-right: 5px;"></i> Attach Document
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="rejectOrder({{ $order->id }})">
                                <i data-feather="x-circle" style="width: 16px; height: 16px; margin-right: 5px;"></i> Reject
                            </button>
                            <button class="btn btn-success btn-sm" onclick="approveOrder({{ $order->id }})" {{ !$order->attachment ? 'disabled' : '' }} title="{{ !$order->attachment ? 'Attachment required' : '' }}">
                                <i data-feather="check-circle" style="width: 16px; height: 16px; margin-right: 5px;"></i> Approve
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div style="margin-top: 30px;">
                {{ $orders->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">✅</div>
                <h4>No pending orders</h4>
                <p>All product orders have been processed</p>
            </div>
        @endif
    </div>

    @include('layouts.default.footer')
</div>

<!-- Attach Document Modal -->
<div class="modal fade" id="attachModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Attach Document</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="attachForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="attachFile">Select File</label>
                        <input type="file" class="form-control-file" id="attachFile" name="attachment" required accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif">
                        <small class="form-text text-muted">Formats: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG, GIF. Max 10MB</small>
                    </div>

                    <div class="alert alert-info" role="alert">
                        <i data-feather="info" style="width: 18px; height: 18px; vertical-align: text-bottom;"></i>
                        Attach supporting documents for this order (e.g., invoice, proof of delivery, etc.)
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="attachBtn">
                        <span id="attachBtnText">Attach Document</span>
                        <span id="attachBtnSpinner" style="display: none;">
                            <i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i> Uploading...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Order Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Order</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" role="alert">
                    <i data-feather="alert-circle" style="width: 18px; height: 18px; vertical-align: text-bottom;"></i>
                    Are you sure you want to reject and delete this order? <strong>This action cannot be undone.</strong>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Keep It</button>
                <button type="button" class="btn btn-danger" id="confirmRejectBtn" onclick="confirmRejectOrder()">
                    <i data-feather="x-circle" style="width: 16px; height: 16px; margin-right: 5px;"></i> Yes, Delete Order
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let currentOrderId = null;

function showAttachModal(orderId) {
    currentOrderId = orderId;
    $('#attachFile').val('');
    $('#attachModal').modal('show');
}

$('#attachForm').on('submit', function(e) {
    e.preventDefault();
    attachDocument();
});

function attachDocument() {
    const formData = new FormData();
    formData.append('order_id', currentOrderId);
    formData.append('attachment', $('#attachFile')[0].files[0]);
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

    $('#attachBtn').prop('disabled', true);
    $('#attachBtnText').hide();
    $('#attachBtnSpinner').show();

    $.ajax({
        url: '{{ route('admin.availed-products.attach') }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                toastr.success(response.message, 'Success');
                $('#attachModal').modal('hide');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        },
        error: function(error) {
            if (error.responseJSON && error.responseJSON.message) {
                toastr.error(error.responseJSON.message, 'Error');
            } else {
                toastr.error('Error attaching document', 'Error');
            }
        },
        complete: function() {
            $('#attachBtn').prop('disabled', false);
            $('#attachBtnText').show();
            $('#attachBtnSpinner').hide();
        }
    });
}

function approveOrder(orderId) {
    const orderCard = $(`[data-order-id="${orderId}"]`);
    const hasAttachment = orderCard.find('.detail-label:contains("Attachment")').closest('.order-detail-item').find('a[href]').length > 0;
    
    if (!hasAttachment) {
        toastr.error('Please attach a document before approving this order', 'Attachment Required');
        return;
    }

    if (!confirm('Are you sure you want to approve this order?')) {
        return;
    }

    $.ajax({
        url: '{{ route('admin.availed-products.approve') }}',
        type: 'POST',
        data: {
            order_id: orderId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                toastr.success(response.message, 'Success');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        },
        error: function(error) {
            if (error.responseJSON && error.responseJSON.message) {
                toastr.error(error.responseJSON.message, 'Error');
            } else {
                toastr.error('Error approving order', 'Error');
            }
        }
    });
}

function rejectOrder(orderId) {
    currentOrderId = orderId;
    $('#rejectModal').modal('show');
}

function confirmRejectOrder() {
    $.ajax({
        url: '{{ route('admin.availed-products.reject') }}',
        type: 'POST',
        data: {
            order_id: currentOrderId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                toastr.success(response.message, 'Success');
                $('#rejectModal').modal('hide');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        },
        error: function(error) {
            if (error.responseJSON && error.responseJSON.message) {
                toastr.error(error.responseJSON.message, 'Error');
            } else {
                toastr.error('Error rejecting order', 'Error');
            }
        }
    });
}
</script>
@endsection
