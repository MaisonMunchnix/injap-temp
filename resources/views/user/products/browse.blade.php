@extends('layouts.default.master')
@section('title','Browse Products')
@section('page-title','Browse Products')

@section('stylesheets')
<style>
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .product-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.15);
    }

    .product-image {
        width: 100%;
        height: 200px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-image.no-image {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-size: 48px;
    }

    .product-body {
        padding: 15px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .product-name {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        line-height: 1.4;
        flex-grow: 1;
    }

    .product-description {
        font-size: 13px;
        color: #666;
        margin-bottom: 10px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-price {
        font-size: 18px;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 12px;
    }

    .product-actions {
        display: flex;
        gap: 8px;
    }

    .btn-view {
        flex: 1;
        background-color: #667eea;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
        transition: background-color 0.3s ease;
    }

    .btn-view:hover {
        background-color: #5568d3;
        color: white;
        text-decoration: none;
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

    .filters-section {
        background: white;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 30px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .search-box {
        position: relative;
        margin-bottom: 15px;
    }

    .search-box input {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .search-box input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .loading-spinner {
        text-align: center;
        padding: 40px;
        color: #667eea;
    }

    .loading-spinner svg {
        animation: spin 1s linear infinite;
        width: 40px;
        height: 40px;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }

    .no-image-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
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
        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 15px;
        }

        .product-image {
            height: 150px;
        }

        .product-name {
            font-size: 14px;
        }

        .product-price {
            font-size: 16px;
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
                    <li class="breadcrumb-item active" aria-current="page">Browse Products</li>
                </ol>
            </nav>
        </div>

        <div class="page-header-section">
            <h2>Discover Our Products</h2>
            <p>Browse our exclusive collection of premium products</p>
            <div style="margin-top: 10px; display: flex; gap: 10px;">
                <a href="{{ route('my-orders') }}" class="btn btn-info" style="color: white;">
                    <i data-feather=""></i> My Orders
                </a>
                <button class="btn btn-primary" data-toggle="modal" data-target="#submitProductModal">
                    <i data-feather="plus"></i> Submit Product
                </button>
            </div>
        </div>

        <div class="filters-section">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Search products by name..." autocomplete="off">
            </div>
        </div>

        <div class="loading-spinner" id="loadingSpinner" style="display: none;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12 6m0 0l-12 6" />
            </svg>
            <p>Loading products...</p>
        </div>

        <div class="product-grid" id="productsContainer">
            <!-- Products will be loaded here -->
        </div>

        <div class="empty-state" id="emptyState" style="display: none;">
            <div class="empty-state-icon">📦</div>
            <h4>No products found</h4>
            <p>Try adjusting your search criteria</p>
        </div>
    </div>

    @include('layouts.default.footer')
</div>

<!-- Product Detail Modal -->
<div class="modal fade" id="productDetailModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalTitle">Product Details</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="productModalBody">
                <!-- Product details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Submit Product Modal -->
<div class="modal fade" id="submitProductModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Submit Product for Approval</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="submitProductForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="productName">Product Name <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="productName" name="product_name" required placeholder="Enter product name">
                        <small class="form-text text-muted">Maximum 255 characters</small>
                    </div>

                    <div class="form-group">
                        <label for="productPrice">Cost Price</label>
                        <input type="number" class="form-control" id="productPrice" name="price" step="0.01" min="0" placeholder="Enter price (e.g., 99.99)">
                        <small class="form-text text-muted">Leave empty if not applicable</small>
                    </div>

                    <div class="form-group">
                        <label for="productPicture">Product Picture</label>
                        <input type="file" class="form-control-file" id="productPicture" name="picture" accept="image/*">
                        <small class="form-text text-muted">Formats: JPEG, PNG, JPG, GIF</small>
                        <div id="imagePreview" style="margin-top: 10px;"></div>
                    </div>

                    <div class="form-group">
                        <label for="productDescription">Description</label>
                        <textarea class="form-control" id="productDescription" name="description" rows="4" placeholder="Describe your product..." maxlength="1000"></textarea>
                        <small class="form-text text-muted">Maximum 1000 characters</small>
                    </div>

                    <div class="form-group">
                        <label for="productCountry">Country <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="productCountry" name="country" required placeholder="Enter country">
                        <small class="form-text text-muted">Maximum 100 characters</small>
                    </div>

                    <div class="form-group">
                        <label for="productAddress">Address <span style="color: red;">*</span></label>
                        <textarea class="form-control" id="productAddress" name="address" rows="3" required placeholder="Enter your address" maxlength="500"></textarea>
                        <small class="form-text text-muted">Maximum 500 characters</small>
                    </div>

                    <div class="form-group">
                        <label for="productContactNumber">Contact Number <span style="color: red;">*</span></label>
                        <input type="tel" class="form-control" id="productContactNumber" name="contact_number" required placeholder="Enter contact number (e.g., +1234567890)">
                        <small class="form-text text-muted">Include country code if applicable</small>
                    </div>

                    <div class="alert alert-info" role="alert">
                        <i data-feather="info" style="width: 18px; height: 18px; vertical-align: text-bottom;"></i>
                        Your product will be reviewed by our admin team and will appear here once approved.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <span id="submitBtnText">Submit Product</span>
                        <span id="submitBtnSpinner" style="display: none;">
                            <i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i> Submitting...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Avail Product Modal -->
<div class="modal fade" id="availProductModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Avail Product</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="availProductForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" class="form-control" id="availProductName" readonly style="background: #f5f5f5;">
                    </div>

                    <div class="form-group">
                        <label>Unit Price</label>
                        <input type="text" class="form-control" id="availProductPrice" readonly style="background: #f5f5f5;">
                    </div>

                    <div class="form-group">
                        <label for="availQuantity">Quantity <span style="color: red;">*</span></label>
                        <input type="number" class="form-control" id="availQuantity" min="1" required placeholder="Enter quantity">
                    </div>

                    <div class="form-group">
                        <label>Total Price</label>
                        <div style="padding: 12px 15px; background: #f0f0f0; border-radius: 4px; border: 1px solid #ddd;">
                            <span style="font-size: 24px; font-weight: 700; color: #28a745;">¥ <span id="totalPriceDisplay">0.00</span></span>
                        </div>
                    </div>

                    <div class="alert alert-info" role="alert">
                        <i data-feather="info" style="width: 18px; height: 18px; vertical-align: text-bottom;"></i>
                        Your order will be pending admin approval. Admin will verify and process your request.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="availBtn">
                        <span id="availBtnText">Avail Product</span>
                        <span id="availBtnSpinner" style="display: none;">
                            <i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i> Processing...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    loadProducts();

    // Search functionality
    $('#searchInput').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();
        filterProducts(searchTerm);
    });

    // Image preview
    $('#productPicture').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                $('#imagePreview').html(`<img src="${event.target.result}" style="max-width: 200px; max-height: 200px; border-radius: 4px;">`);
            };
            reader.readAsDataURL(file);
        }
    });

    // Submit product form
    $('#submitProductForm').on('submit', function(e) {
        e.preventDefault();
        submitProduct();
    });

    // Avail product quantity change
    $('#availQuantity').on('input', function() {
        calculateTotal();
    });

    // Avail product form submit
    $('#availProductForm').on('submit', function(e) {
        e.preventDefault();
        submitAvailProduct();
    });
});

function loadProducts() {
    $('#loadingSpinner').show();
    $('#productsContainer').empty();
    $('#emptyState').hide();

    $.ajax({
        url: '{{ route('api.products.list') }}',
        type: 'GET',
        success: function(response) {
            $('#loadingSpinner').hide();
            
            if (response.products && response.products.length > 0) {
                displayProducts(response.products);
            } else {
                showEmptyState();
            }
        },
        error: function(error) {
            $('#loadingSpinner').hide();
            console.log('Error loading products:', error);
            showEmptyState();
        }
    });
}

function displayProducts(products) {
    let html = '';
    
    products.forEach(function(product) {
        const imageHtml = product.picture ? 
            `<img src="/${product.picture}" alt="${product.product_name}">` :
            `<div class="no-image-placeholder"><i data-feather="image" style="width: 60px; height: 60px; color: #999;"></i></div>`;

        const price = product.price ? `¥ ${parseFloat(product.price).toFixed(2)}` : '';
        const priceDisplay = price ? `<div class="product-price">${price}</div>` : '';
        
        html += `
            <div class="product-card">
                <div class="product-image">
                    ${imageHtml}
                </div>
                <div class="product-body">
                    <div class="product-name">${product.product_name || 'Untitled Product'}</div>
                    ${product.description ? `<div class="product-description">${product.description}</div>` : ''}
                    ${priceDisplay}
                    <div class="product-actions">
                        <button class="btn-view" onclick="viewProductDetail(${product.id})">
                            View Details
                        </button>
                        <button class="btn-view" style="background-color: #28a745;" onclick="showAvailModal(${product.id}, '${product.product_name}', ${product.price})">
                            Avail Product
                        </button>
                    </div>
                </div>
            </div>
        `;
    });

    $('#productsContainer').html(html);
    feather.replace();
}

function showEmptyState() {
    $('#productsContainer').empty();
    $('#emptyState').show();
}

function filterProducts(searchTerm) {
    const cards = document.querySelectorAll('.product-card');
    let visibleCount = 0;

    cards.forEach(function(card) {
        const productName = card.querySelector('.product-name').textContent.toLowerCase();
        const productDesc = card.querySelector('.product-description')?.textContent.toLowerCase() || '';

        if (productName.includes(searchTerm) || productDesc.includes(searchTerm)) {
            card.style.display = '';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    if (visibleCount === 0) {
        $('#emptyState').show();
    } else {
        $('#emptyState').hide();
    }
}

function viewProductDetail(productId) {
    $.ajax({
        url: '{{ route('api.products.detail', '') }}/' + productId,
        type: 'GET',
        success: function(response) {
            if (response.product) {
                const product = response.product;
                const imageHtml = product.picture ? 
                    `<img src="/${product.picture}" alt="${product.product_name}" style="width: 100%; max-height: 300px; object-fit: cover; border-radius: 4px; margin-bottom: 20px;">` :
                    `<div style="width: 100%; height: 300px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 4px; margin-bottom: 20px; display: flex; align-items: center; justify-content: center;"><i data-feather="image" style="width: 80px; height: 80px; color: white;"></i></div>`;

                let priceHtml = '';
                if (product.price) {
                    priceHtml = `<p style="font-size: 18px; color: #667eea; font-weight: 600; margin-bottom: 20px;">
                        Price: ¥ ${parseFloat(product.price).toFixed(2)}
                    </p>`;
                }

                let locationHtml = '';
                if (product.country || product.address) {
                    locationHtml = `
                        <div style="background: #f0f7ff; padding: 12px 15px; border-radius: 4px; margin-bottom: 15px; border-left: 4px solid #667eea;">
                            <h6 style="margin-bottom: 8px; color: #333;">Location</h6>
                            ${product.country ? `<p style="margin-bottom: 5px;"><strong>Country:</strong> ${product.country}</p>` : ''}
                            ${product.address ? `<p style="margin-bottom: 0;"><strong>Address:</strong> ${product.address}</p>` : ''}
                        </div>
                    `;
                }

                let html = `
                    <div class="row">
                        <div class="col-md-12">
                            ${imageHtml}
                            <h5 style="margin-bottom: 10px;">${product.product_name}</h5>
                            ${priceHtml}
                            ${locationHtml}
                            <div style="background: #f8f9fa; padding: 15px; border-radius: 4px;">
                                <h6>Description</h6>
                                <p>${product.description || 'No description available'}</p>
                            </div>
                        </div>
                    </div>
                `;

                $('#productModalTitle').text(product.product_name);
                $('#productModalBody').html(html);
                $('#productDetailModal').modal('show');
                feather.replace();
            }
        },
        error: function(error) {
            console.log('Error loading product:', error);
            alert('Error loading product details');
        }
    });
}

function submitProduct() {
    const formData = new FormData($('#submitProductForm')[0]);
    
    $('#submitBtn').prop('disabled', true);
    $('#submitBtnText').hide();
    $('#submitBtnSpinner').show();

    $.ajax({
        url: '{{ route('submit-product') }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                toastr.success(response.message, 'Success');
                $('#submitProductForm')[0].reset();
                $('#imagePreview').empty();
                $('#submitProductModal').modal('hide');
            } else {
                toastr.error(response.message, 'Error');
            }
        },
        error: function(error) {
            if (error.responseJSON && error.responseJSON.message) {
                toastr.error(error.responseJSON.message, 'Error');
            } else {
                toastr.error('Error submitting product', 'Error');
            }
        },
        complete: function() {
            $('#submitBtn').prop('disabled', false);
            $('#submitBtnText').show();
            $('#submitBtnSpinner').hide();
        }
    });
}

let currentAvailProduct = {
    productId: null,
    price: 0
};

function showAvailModal(productId, productName, price) {
    currentAvailProduct.productId = productId;
    currentAvailProduct.price = price;
    
    $('#availProductName').val(productName);
    $('#availProductPrice').val('¥ ' + parseFloat(price).toFixed(2));
    $('#availQuantity').val(1);
    calculateTotal();
    $('#availProductModal').modal('show');
}

function calculateTotal() {
    const quantity = parseInt($('#availQuantity').val()) || 0;
    const price = currentAvailProduct.price;
    const total = quantity * price;
    $('#totalPriceDisplay').text(parseFloat(total).toFixed(2));
}

function submitAvailProduct() {
    const quantity = $('#availQuantity').val();
    
    if (!quantity || parseInt(quantity) < 1) {
        toastr.error('Please enter a valid quantity', 'Error');
        return;
    }

    $('#availBtn').prop('disabled', true);
    $('#availBtnText').hide();
    $('#availBtnSpinner').show();

    $.ajax({
        url: '{{ route('avail-product') }}',
        type: 'POST',
        data: {
            product_id: currentAvailProduct.productId,
            quantity: quantity,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                toastr.success(response.message, 'Success');
                $('#availProductForm')[0].reset();
                $('#availProductModal').modal('hide');
            } else {
                toastr.error(response.message, 'Error');
            }
        },
        error: function(error) {
            if (error.responseJSON && error.responseJSON.message) {
                toastr.error(error.responseJSON.message, 'Error');
            } else {
                toastr.error('Error placing order', 'Error');
            }
        },
        complete: function() {
            $('#availBtn').prop('disabled', false);
            $('#availBtnText').show();
            $('#availBtnSpinner').hide();
        }
    });
}
</script>
@endsection
