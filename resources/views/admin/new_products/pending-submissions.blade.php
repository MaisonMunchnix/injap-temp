@extends('layouts.default.admin.master')
@section('title','Pending Product Submissions')
@section('page-title','Pending Product Submissions')

@section('stylesheets')
<style>
    .submission-card {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        margin-bottom: 20px;
        overflow: hidden;
        transition: box-shadow 0.3s ease;
    }

    .submission-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .submission-card-header {
        padding: 20px;
        border-bottom: 1px solid #e0e0e0;
        background: #f8f9fa;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .submission-card-header h5 {
        margin: 0;
        font-weight: 600;
    }

    .submitter-info {
        font-size: 13px;
        color: #666;
        margin-top: 5px;
    }

    .submission-card-body {
        padding: 20px;
        display: grid;
        grid-template-columns: 150px 1fr;
        gap: 20px;
    }

    .product-image-container {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 150px;
        height: 150px;
        background: #f0f0f0;
        border-radius: 4px;
    }

    .product-image-container img {
        max-width: 100%;
        max-height: 100%;
        border-radius: 4px;
    }

    .product-image-container .no-image {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-size: 40px;
    }

    .product-details {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .detail-item {
        margin-bottom: 12px;
    }

    .detail-label {
        font-size: 12px;
        color: #999;
        text-transform: uppercase;
        font-weight: 600;
    }

    .detail-value {
        font-size: 15px;
        color: #333;
        margin-top: 4px;
    }

    .submission-card-footer {
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
        .submission-card-body {
            grid-template-columns: 1fr;
        }

        .product-image-container {
            width: 100%;
            height: 200px;
        }

        .submission-card-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .submission-card-footer {
            flex-direction: column;
        }

        .submission-card-footer button {
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
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.products') }}">Products</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Pending Submissions</li>
                </ol>
            </nav>
        </div>

        <div style="margin-bottom: 30px;">
            <h2 style="color: #333; font-weight: 600; margin-bottom: 10px;">Pending Product Submissions</h2>
            <p style="color: #666; font-size: 14px;">Review and approve member-submitted products</p>
             <a href="{{ route('admin.products') }}" class="btn btn-secondary" style="margin-top: 10px;">
                <i data-feather="arrow-left"></i> Back to Products
            </a>
        </div>

        @if($submissions->count() > 0)
            <div id="submissionsContainer">
                @foreach($submissions as $submission)
                    <div class="submission-card" data-submission-id="{{ $submission->id }}">
                        <div class="submission-card-header">
                            <div>
                                <h5>{{ $submission->product_name }}</h5>
                                <div class="submitter-info">
                                    <strong>Submitted by:</strong> {{ $submission->submitter ? ($submission->submitter->username ?? $submission->submitter->name ?? 'Unknown') : 'Unknown' }}
                                    <br>
                                    <strong>Submitted on:</strong> {{ $submission->submitted_at ? $submission->submitted_at->format('M d, Y H:i') : 'N/A' }}
                                </div>
                            </div>
                            <div>
                                <span class="badge-status badge-pending">{{ ucfirst($submission->status) }}</span>
                            </div>
                        </div>

                        <div class="submission-card-body">
                            <div class="product-image-container">
                                @if($submission->picture)
                                    <img src="/{{ $submission->picture }}" alt="{{ $submission->product_name }}">
                                @else
                                    <div class="no-image">📦</div>
                                @endif
                            </div>

                            <div class="product-details">
                                @if($submission->price)
                                    <div class="detail-item">
                                        <div class="detail-label">Cost Price</div>
                                        <div class="detail-value">¥ {{ number_format($submission->price, 2) }}</div>
                                    </div>
                                @endif

                                <div class="detail-item">
                                    <div class="detail-label">Description</div>
                                    <div class="detail-value">{{ $submission->description ?? 'No description provided' }}</div>
                                </div>

                                @if($submission->country)
                                    <div class="detail-item">
                                        <div class="detail-label">Country</div>
                                        <div class="detail-value">{{ $submission->country }}</div>
                                    </div>
                                @endif

                                @if($submission->address)
                                    <div class="detail-item">
                                        <div class="detail-label">Address</div>
                                        <div class="detail-value">{{ $submission->address }}</div>
                                    </div>
                                @endif

                                @if($submission->contact_number)
                                    <div class="detail-item">
                                        <div class="detail-label">Contact Number</div>
                                        <div class="detail-value">{{ $submission->contact_number }}</div>
                                    </div>
                                @endif

                                <div class="detail-item">
                                    <div class="detail-label">Submitted by</div>
                                    <div class="detail-value">{{ $submission->submitter ? ($submission->submitter->username ?? $submission->submitter->name ?? 'Unknown') : 'Unknown' }} (ID: {{ $submission->user_id }})</div>
                                </div>
                            </div>
                        </div>

                        <div class="submission-card-footer">
                            <button class="btn btn-danger btn-sm" onclick="showRejectModal({{ $submission->id }})">
                                <i data-feather="x-circle" style="width: 16px; height: 16px; margin-right: 5px;"></i> Reject
                            </button>
                            <button class="btn btn-success btn-sm" onclick="showApproveModal({{ $submission->id }}, '{{ $submission->product_name }}', {{ $submission->price ?? 0 }})">
                                <i data-feather="check-circle" style="width: 16px; height: 16px; margin-right: 5px;"></i> Approve
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div style="margin-top: 30px;">
                {{ $submissions->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">✅</div>
                <h4>No pending submissions</h4>
                <p>All product submissions have been reviewed</p>
            </div>
        @endif
    </div>

    @include('layouts.default.footer')
</div>

<!-- Approve Product Modal -->
<div class="modal fade" id="approveProductModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve Product Submission</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="approveProductForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="approveProductName">Product Name</label>
                        <input type="text" class="form-control" id="approveProductName" readonly style="background: #f5f5f5;">
                    </div>

                    <div class="form-group">
                        <label for="approveProductPrice">Set Price <span style="color: red;">*</span></label>
                        <input type="number" class="form-control" id="approveProductPrice" name="price" step="0.01" min="0" required placeholder="Enter the price">
                        <small class="form-text text-muted">Admin decides the selling price for this product</small>
                    </div>

                    <div class="alert alert-info" role="alert">
                        <i data-feather="info" style="width: 18px; height: 18px; vertical-align: text-bottom;"></i>
                        Once approved, this product will be visible to all members in the browse products section.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" onclick="submitApproval()">
                        <i data-feather="check" style="width: 16px; height: 16px; margin-right: 5px;"></i> Approve & Set Price
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Product Modal -->
<div class="modal fade" id="rejectProductModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Product Submission</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to reject and delete this product submission? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmReject()">
                    <i data-feather="x-circle" style="width: 16px; height: 16px; margin-right: 5px;"></i> Yes, Delete
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let currentSubmissionId = null;

function showApproveModal(submissionId, productName, currentPrice) {
    currentSubmissionId = submissionId;
    $('#approveProductName').val(productName);
    $('#approveProductPrice').val(currentPrice || '');
    $('#approveProductModal').modal('show');
}

function showRejectModal(submissionId) {
    currentSubmissionId = submissionId;
    $('#rejectProductModal').modal('show');
}

function confirmReject() {
    $.ajax({
        url: '{{ route('admin.products.reject-submission') }}',
        type: 'POST',
        data: {
            product_id: currentSubmissionId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                toastr.success(response.message, 'Success');
                $('#rejectProductModal').modal('hide');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        },
        error: function(error) {
            if (error.responseJSON && error.responseJSON.message) {
                toastr.error(error.responseJSON.message, 'Error');
            } else {
                toastr.error('Error rejecting submission', 'Error');
            }
        }
    });
}

function approveSubmission(submissionId) {
    if (!confirm('Are you sure you want to approve this product?')) {
        return;
    }

    $.ajax({
        url: '{{ route('admin.products.approve-submission') }}',
        type: 'POST',
        data: {
            product_id: submissionId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                toastr.success(response.message, 'Success');
                // Remove the card or reload
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        },
        error: function(error) {
            if (error.responseJSON && error.responseJSON.message) {
                toastr.error(error.responseJSON.message, 'Error');
            } else {
                toastr.error('Error approving submission', 'Error');
            }
        }
    });
}

function submitApproval() {
    const price = $('#approveProductPrice').val();
    
    if (!price || parseFloat(price) < 0) {
        toastr.error('Please enter a valid price', 'Error');
        return;
    }

    $.ajax({
        url: '{{ route('admin.products.approve-submission') }}',
        type: 'POST',
        data: {
            product_id: currentSubmissionId,
            price: price,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                toastr.success(response.message, 'Success');
                $('#approveProductModal').modal('hide');
                // Remove the card or reload
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        },
        error: function(error) {
            if (error.responseJSON && error.responseJSON.message) {
                toastr.error(error.responseJSON.message, 'Error');
            } else {
                toastr.error('Error approving submission', 'Error');
            }
        }
    });
}
</script>
@endsection
