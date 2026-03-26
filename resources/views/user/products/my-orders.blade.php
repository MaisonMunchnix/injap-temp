@extends('layouts.default.master')
@section('title','My Orders')
@section('page-title','My Orders')

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

    .badge-status {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-approved {
        background: #d4edda;
        color: #155724;
    }

    .badge-pending {
        background: #fff3cd;
        color: #856404;
    }

    .badge-rejected {
        background: #f8d7da;
        color: #721c24;
    }

    .attachment-section {
        background: #f0f8ff;
        border-left: 4px solid #007bff;
        padding: 15px;
        border-radius: 4px;
    }

    .attachment-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e0e0e0;
    }

    .attachment-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .attachment-name {
        font-size: 14px;
        color: #333;
        font-weight: 500;
        word-break: break-word;
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

    .filter-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 8px 16px;
        border: 1px solid #ddd;
        background: white;
        border-radius: 20px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .filter-btn:hover {
        border-color: #667eea;
        color: #667eea;
    }

    .filter-btn.active {
        background: #667eea;
        color: white;
        border-color: #667eea;
    }

    .page-header-section {
        margin-bottom: 30px;
    }

    .page-header-section h2 {
        color: #333;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .page-header-section p {
        color: #666;
        font-size: 14px;
    }

    @media (max-width: 768px) {
        .order-card-body {
            grid-template-columns: 1fr;
        }

        .order-card-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .attachment-item {
            flex-direction: column;
            align-items: flex-start;
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
                        <a href="{{ route('home') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">My Orders</li>
                </ol>
            </nav>
        </div>

        <div class="page-header-section">
            <h2>My Orders</h2>
            <p>View all your product orders and their status</p>
            <div style="margin-top: 10px;">
                <a href="{{ route('member.products') }}" class="btn btn-primary" style="color: white;">
                    <i data-feather="arrow-left"></i> Browse Products
                </a>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <button class="filter-btn active" onclick="filterOrders('all')">All Orders</button>
            <button class="filter-btn" onclick="filterOrders('pending')">Pending</button>
            <button class="filter-btn" onclick="filterOrders('approved')">Approved</button>
            <button class="filter-btn" onclick="filterOrders('rejected')">Rejected</button>
        </div>

        <div id="ordersContainer">
            <!-- Orders will be loaded here -->
        </div>

        <div class="empty-state" id="emptyState" style="display: none;">
            <div class="empty-state-icon">🛒</div>
            <h4>No orders yet</h4>
            <p>You haven't placed any orders yet. <a href="{{ route('member.products') }}" style="color: #667eea;">Browse products</a></p>
        </div>
    </div>

    @include('layouts.default.footer')
</div>
@endsection

@section('scripts')
<script>
let allOrders = [];
let currentFilter = 'all';

$(document).ready(function() {
    loadMyOrders();
});

function loadMyOrders() {
    $.ajax({
        url: '{{ route('api.my-orders') }}',
        type: 'GET',
        success: function(response) {
            if (response.orders && response.orders.length > 0) {
                allOrders = response.orders;
                displayOrders(allOrders);
            } else {
                showEmptyState();
            }
        },
        error: function(error) {
            console.log('Error loading orders:', error);
            showEmptyState();
        }
    });
}

function displayOrders(orders) {
    let html = '';
    
    if (orders.length === 0) {
        showEmptyState();
        return;
    }

    orders.forEach(function(order) {
        let statusBadgeClass = '';
        switch(order.status) {
            case 'approved':
                statusBadgeClass = 'badge-approved';
                break;
            case 'pending':
                statusBadgeClass = 'badge-pending';
                break;
            case 'rejected':
                statusBadgeClass = 'badge-rejected';
                break;
        }

        let attachmentHtml = '';
        if (order.status === 'approved') {
            if (order.attachment) {
                attachmentHtml = `
                    <div class="order-detail-item" style="grid-column: 1 / -1;">
                        <div class="detail-label">📎 Payment Attachment</div>
                        <div class="detail-value">
                            <div class="attachment-section">
                                <div class="attachment-item">
                                    <div>
                                        <div class="attachment-name">
                                            <i data-feather="file" style="width: 16px; height: 16px; vertical-align: middle; margin-right: 8px;"></i>
                                            ${order.attachment.split('/').pop()}
                                        </div>
                                    </div>
                                    <a href="/${order.attachment}" target="_blank" class="btn btn-sm btn-primary">
                                        <i data-feather="download" style="width: 14px; height: 14px;"></i> Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
        }

        const dateField = order.status === 'pending' ? 
            `<strong>Ordered on:</strong> ${new Date(order.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' })}` :
            `<strong>Processed on:</strong> ${new Date(order.updated_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' })}`;

        html += `
            <div class="order-card" data-order-id="${order.id}" data-status="${order.status}">
                <div class="order-card-header">
                    <div>
                        <h5>${order.product.product_name || 'Product'} - Order #${order.id}</h5>
                        <div class="order-info">
                            ${dateField}
                        </div>
                    </div>
                    <div>
                        <span class="badge-status ${statusBadgeClass}">${order.status.charAt(0).toUpperCase() + order.status.slice(1)}</span>
                    </div>
                </div>

                <div class="order-card-body">
                    <div class="order-detail-item">
                        <div class="detail-label">Product</div>
                        <div class="detail-value">${order.product.product_name || 'N/A'}</div>
                    </div>

                    <div class="order-detail-item">
                        <div class="detail-label">Quantity</div>
                        <div class="detail-value">${order.quantity}</div>
                    </div>

                    <div class="order-detail-item">
                        <div class="detail-label">Unit Price</div>
                        <div class="detail-value">¥ ${parseFloat(order.product.price || 0).toFixed(2)}</div>
                    </div>

                    <div class="order-detail-item">
                        <div class="detail-label">Total Price</div>
                        <div class="total-price">¥ ${parseFloat(order.total_price).toFixed(2)}</div>
                    </div>

                    ${order.status === 'rejected' ? `
                        <div class="order-detail-item" style="grid-column: 1 / -1;">
                            <div class="detail-label">Rejection Reason</div>
                            <div class="detail-value" style="color: #dc3545;">
                                ${order.rejection_reason || 'No reason provided'}
                            </div>
                        </div>
                    ` : ''}

                    ${attachmentHtml}
                </div>
            </div>
        `;
    });

    $('#ordersContainer').html(html);
    $('#emptyState').hide();
    feather.replace();
}

function showEmptyState() {
    $('#ordersContainer').empty();
    $('#emptyState').show();
}

function filterOrders(status) {
    currentFilter = status;

    // Update active button
    $('.filter-btn').removeClass('active');
    $(`button[onclick="filterOrders('${status}')"]`).addClass('active');

    // Filter orders
    const filtered = status === 'all' ? allOrders : allOrders.filter(o => o.status === status);
    
    if (filtered.length === 0) {
        showEmptyState();
    } else {
        displayOrders(filtered);
    }
}
</script>
@endsection
