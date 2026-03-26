@extends('layouts.default.admin.master')
@section('title','Products')
@section('page-title','Product Management')

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
                        <a href="{{ route('admin-dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Product Management</li>
                </ol>
            </nav>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 30px;">
            <!-- Member Submissions Card -->
            <div class="card" style="background: #e8f4f8; border-left: 4px solid #667eea;">
                <div class="card-body">
                    <h6 style="margin: 0; color: #667eea; font-weight: 600;">Member Submissions</h6>
                    <p style="margin: 5px 0 15px 0; color: #666; font-size: 13px;">Review and approve products submitted by members</p>
                    <a href="{{ route('admin.products.pending-submissions') }}" class="btn btn-sm" style="background: #667eea; color: white; border: none;">
                        <i data-feather="check-square" style="width: 16px; height: 16px; margin-right: 5px;"></i> View Pending Submissions
                    </a>
                </div>
            </div>

            <!-- Pending Orders Card -->
            <div class="card" style="background: #f0f8e8; border-left: 4px solid #28a745;">
                <div class="card-body">
                    <h6 style="margin: 0; color: #28a745; font-weight: 600;">Pending Orders</h6>
                    <p style="margin: 5px 0 15px 0; color: #666; font-size: 13px;">Manage product orders from members</p>
                    <a href="{{ route('admin.availed-products.pending') }}" class="btn btn-sm" style="background: #28a745; color: white; border: none;">
                        <i data-feather="shopping-cart" style="width: 16px; height: 16px; margin-right: 5px;"></i> View Pending Orders
                    </a>
                </div>
            </div>

            <!-- Approved Orders Card -->
            <div class="card" style="background: #f3e5f5; border-left: 4px solid #9c27b0;">
                <div class="card-body">
                    <h6 style="margin: 0; color: #9c27b0; font-weight: 600;">Approved Orders</h6>
                    <p style="margin: 5px 0 15px 0; color: #666; font-size: 13px;">View approved orders and payment attachments</p>
                    <a href="{{ route('admin.availed-products.approved') }}" class="btn btn-sm" style="background: #9c27b0; color: white; border: none;">
                        <i data-feather="check-circle" style="width: 16px; height: 16px; margin-right: 5px;"></i> View Approved Orders
                    </a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="card-title">Products</h6>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addProductModal">
                    <i data-feather="plus"></i> Add Product
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="products_table" class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Country</th>
                                <th>Address</th>
                                <th>Contact Number</th>
                                <th>Picture</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="products_table_body">
                            <tr>
                                <td colspan="5" class="text-center">Loading products...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.default.footer')
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addProductForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="product_name">Product Name</label>
                        <input type="text" class="form-control" id="product_name" name="product_name" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01">
                    </div>
                    <div class="form-group">
                        <label for="picture">Picture</label>
                        <input type="file" class="form-control" id="picture" name="picture" accept="image/*">
                        <small class="form-text text-muted">Accepted formats: JPEG, PNG, JPG, GIF. Max size: 2MB</small>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="country">Country</label>
                        <input type="text" class="form-control" id="country" name="country" placeholder="Enter country">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter address"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="contact_number">Contact Number</label>
                        <input type="tel" class="form-control" id="contact_number" name="contact_number" placeholder="Enter contact number">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveProductBtn">Save Product</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editProductForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="edit_product_id" name="product_id">
                    <div class="form-group">
                        <label for="edit_product_name">Product Name</label>
                        <input type="text" class="form-control" id="edit_product_name" name="product_name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_price">Price</label>
                        <input type="number" class="form-control" id="edit_price" name="price" step="0.01">
                    </div>
                    <div class="form-group">
                        <label for="edit_picture">Picture</label>
                        <input type="file" class="form-control" id="edit_picture" name="picture" accept="image/*">
                        <small class="form-text text-muted">Leave empty to keep current picture</small>
                    </div>
                    <div class="form-group">
                        <label for="edit_description">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_country">Country</label>
                        <input type="text" class="form-control" id="edit_country" name="country" placeholder="Enter country">
                    </div>
                    <div class="form-group">
                        <label for="edit_address">Address</label>
                        <textarea class="form-control" id="edit_address" name="address" rows="3" placeholder="Enter address"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_contact_number">Contact Number</label>
                        <input type="tel" class="form-control" id="edit_contact_number" name="contact_number" placeholder="Enter contact number">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updateProductBtn">Update Product</button>
            </div>
        </div>
    </div>
</div>

<!-- View Product Modal -->
<div class="modal fade" id="viewProductModal" tabindex="-1" role="dialog" aria-labelledby="viewProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewProductModalLabel">Product Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="viewProductContent">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    loadProducts();
});

function loadProducts() {
    $.ajax({
        url: '{{ route('admin.products.list') }}',
        type: 'GET',
        success: function(response) {
            let html = '';
            if (response.products && response.products.length > 0) {
                response.products.forEach(function(product) {
                    let pictureHtml = product.picture ? 
                        `<img src="/${product.picture}" alt="${product.product_name}" style="width: 50px; height: 50px; object-fit: cover;">` :
                        '<span class="text-muted">No image</span>';
                    
                    html += `
                        <tr>
                            <td>${product.product_name || 'N/A'}</td>
                            <td>¥ ${parseFloat(product.price || 0).toFixed(2)}</td>
                            <td>${product.country || 'N/A'}</td>
                            <td><small>${product.address ? product.address.substring(0, 30) + (product.address.length > 30 ? '...' : '') : 'N/A'}</small></td>
                            <td>${product.contact_number || 'N/A'}</td>
                            <td>${pictureHtml}</td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="viewProduct(${product.id})" title="View">
                                    <i data-feather="eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" onclick="editProduct(${product.id})" title="Edit">
                                    <i data-feather="edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteProduct(${product.id})" title="Delete">
                                    <i data-feather="trash-2"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
            } else {
                html = '<tr><td colspan="7" class="text-center text-muted">No products found</td></tr>';
            }
            $('#products_table_body').html(html);
            feather.replace();
        },
        error: function(error) {
            console.log('Error loading products:', error);
            $('#products_table_body').html('<tr><td colspan="7" class="text-center text-danger">Error loading products</td></tr>');
        }
    });
}

function viewProduct(id) {
    $.ajax({
        url: '/staff/admin/products/view/' + id,
        type: 'GET',
        success: function(response) {
            if (response.product) {
                let product = response.product;
                let pictureHtml = product.picture ? 
                    `<img src="/${product.picture}" alt="${product.product_name}" style="max-width: 100%; height: auto;">` :
                    '<p class="text-muted">No image available</p>';
                
                let content = `
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Product Name:</strong> ${product.product_name || 'N/A'}</p>
                            <p><strong>Price:</strong> ¥ ${parseFloat(product.price || 0).toFixed(2)}</p>
                            <p><strong>Country:</strong> ${product.country || 'N/A'}</p>
                            <p><strong>Contact Number:</strong> ${product.contact_number || 'N/A'}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Picture:</strong></p>
                            ${pictureHtml}
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <p><strong>Description:</strong></p>
                            <p>${product.description || 'No description available'}</p>
                            <p><strong>Address:</strong></p>
                            <p>${product.address || 'No address provided'}</p>
                        </div>
                    </div>
                `;
                $('#viewProductContent').html(content);
                $('#viewProductModal').modal('show');
            }
        },
        error: function(error) {
            console.log('Error viewing product:', error);
            alert('Error loading product details');
        }
    });
}

function editProduct(id) {
    $.ajax({
        url: '/staff/admin/products/edit/' + id,
        type: 'GET',
        success: function(response) {
            if (response.product) {
                let product = response.product;
                $('#edit_product_id').val(product.id);
                $('#edit_product_name').val(product.product_name);
                $('#edit_price').val(product.price);
                $('#edit_description').val(product.description);
                $('#edit_country').val(product.country);
                $('#edit_address').val(product.address);
                $('#edit_contact_number').val(product.contact_number);
                $('#editProductModal').modal('show');
            }
        },
        error: function(error) {
            console.log('Error loading product:', error);
            alert('Error loading product details');
        }
    });
}

function deleteProduct(id) {
    if (confirm('Are you sure you want to delete this product?')) {
        $.ajax({
            url: '/staff/admin/products/delete/' + id,
            type: 'POST',
            data: {_token: '{{ csrf_token() }}'},
            success: function(response) {
                if (response.success) {
                    alert('Product deleted successfully');
                    loadProducts();
                } else {
                    alert('Error deleting product');
                }
            },
            error: function(error) {
                console.log('Error deleting product:', error);
                alert('Error deleting product');
            }
        });
    }
}

$('#saveProductBtn').click(function() {
    if ($('#addProductForm')[0].checkValidity() === false) {
        event.preventDefault();
        event.stopPropagation();
        return;
    }
    
    let formData = new FormData($('#addProductForm')[0]);
    
    $.ajax({
        url: '{{ route('admin.products.store') }}',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            if (response.success) {
                $('#addProductModal').modal('hide');
                $('#addProductForm')[0].reset();
                loadProducts();
                alert('Product added successfully');
            } else {
                alert('Error adding product: ' + response.message);
            }
        },
        error: function(error) {
            console.log('Error:', error);
            if (error.responseJSON && error.responseJSON.message) {
                alert('Error adding product: ' + error.responseJSON.message);
            } else {
                alert('Error adding product');
            }
        }
    });
});

$('#updateProductBtn').click(function() {
    let formData = new FormData($('#editProductForm')[0]);
    
    $.ajax({
        url: '{{ route('admin.products.update') }}',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            if (response.success) {
                $('#editProductModal').modal('hide');
                loadProducts();
                alert('Product updated successfully');
            } else {
                alert('Error updating product: ' + response.message);
            }
        },
        error: function(error) {
            console.log('Error:', error);
            if (error.responseJSON && error.responseJSON.message) {
                alert('Error updating product: ' + error.responseJSON.message);
            } else {
                alert('Error updating product');
            }
        }
    });
});
</script>
@endsection
