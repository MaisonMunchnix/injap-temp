@extends('layouts.default.admin.master')
@section('title','Approved Availed Products')
@section('page-title','Approved Availed Products')

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
                        <a href="{{ route('admin-dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Approved Availed Products</li>
                </ol>
            </nav>
        </div>

        <div style="margin-bottom: 30px;">
            <h2 style="color: #333; font-weight: 600; margin-bottom: 10px;">Approved Availed Products</h2>
            <p style="color: #666; font-size: 14px;">View approved member product orders and payment attachments</p>
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
                                    <strong>Approved on:</strong> {{ $order->updated_at ? $order->updated_at->format('M d, Y H:i') : 'N/A' }}
                                </div>
                            </div>
                            <div>
                                <span class="badge-status badge-approved">{{ ucfirst($order->status) }}</span>
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
                                <div class="detail-label">📎 Payment Attachment</div>
                                <div class="detail-value">
                                    @if($order->attachment)
                                        <div class="attachment-section">
                                            <div class="attachment-item">
                                                <div>
                                                    <div class="attachment-name">
                                                        <i data-feather="file" style="width: 16px; height: 16px; vertical-align: middle; margin-right: 8px;"></i>
                                                        {{ basename($order->attachment) }}
                                                    </div>
                                                </div>
                                                <a href="/{{ $order->attachment }}" target="_blank" class="btn btn-sm btn-primary">
                                                    <i data-feather="download" style="width: 14px; height: 14px;"></i> Download
                                                </a>
                                            </div>
                                        </div>
                                    @else
                                        <span style="color: #dc3545;">
                                            <i data-feather="alert-circle" style="width: 16px; height: 16px; vertical-align: middle;"></i> No attachment available
                                        </span>
                                    @endif
                                </div>
                            </div>
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
                <h4>No approved orders yet</h4>
                <p>Approved orders will appear here</p>
            </div>
        @endif
    </div>

    @include('layouts.default.footer')
</div>
@endsection
