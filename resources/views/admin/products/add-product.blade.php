@extends('layouts.default.admin.master')
@section('title', 'Add Product')
@section('page-title', 'Add Product')

@section('stylesheets')
    {{-- additional style here --}}
    <!-- swal -->

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
                            <a href="#">Product management</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                    </ol>
                </nav>
            </div>
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Add New Product</h6>
                    <form method="POST" action="" id="add-form" enctype="multipart/form-data">
                        @csrf
                        <div class="element-info">
                            <div class="element-info-with-icon">
                                <div class="element-info-icon">
                                    <div class="os-icon os-icon-hierarchy-structure-2"></div>
                                </div>
                                <div class="element-info-text">
                                    <div class="element-inner-desc">Please fill out all information needed.</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" data-toggle="tooltip" data-placement="top"
                                    title="Image is required">
                                    <label for="name" class="col-form-label">Image:</label>
                                    <input type="file" name="image" id="image" class="form-control">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" data-toggle="tooltip" data-placement="top" title="Name is required">
                                    <label for="name" class="col-form-label">Name: *</label>
                                    <input class="form-control" placeholder="Name" id="name" name="name"
                                        type="text" required>
                                </div>
                            </div>

                            {{-- <div class="col-md-3">
                                <div class="form-group" data-toggle="tooltip" data-placement="top"
                                    title="Unilevel Pricel is required">
                                    <label for="unilevel_price" class="col-form-label">UniLevel PV: *</label>
                                    <input class="form-control" placeholder="Unilevel PV" id="unilevel_price"
                                        name="unilevel_price" type="number" required>
                                </div>
                            </div> --}}
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" data-toggle="tooltip" data-placement="top"
                                    title="Cost Price is required">
                                    <label for="price" class="col-form-label">Cost Price: *</label>
                                    <input class="form-control" placeholder="Cost Price" id="cost_price" name="cost_price"
                                        type="number" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" data-toggle="tooltip" data-placement="top"
                                    title="Price is required">
                                    <label for="price" class="col-form-label">Price: *</label>
                                    <input class="form-control" placeholder="Price" id="price" name="price"
                                        type="number" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group" data-toggle="tooltip" data-placement="top"
                                    title="Critical Level is required">
                                    <label for="critical_level" class="col-form-label">Critical Level: *</label>
                                    <input class="form-control" placeholder="Critical Level" id="critical_level"
                                        name="critical_level" type="number" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group" data-toggle="tooltip" data-placement="top"
                                    title="Begining Quantity is optional">
                                    <label for="quantity" class="col-form-label">Begining Quantity:</label>
                                    <input class="form-control" placeholder="Begining Quantity" id="quantity"
                                        name="quantity" type="number" value="0" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group" data-toggle="tooltip" data-placement="top"
                                    title="Product Reward Points is required">
                                    <label for="reward_points" class="col-form-label">Product Reward Points: *</label>
                                    <select class="form-control" name="reward_points" id="reward_points" required>
                                        <option value="" selected>Select Product Reward Points</option>
                                        <option value="5%">5%</option>
                                        <option value="10%">10%</option>
                                        <option value="15%">15%</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" data-toggle="tooltip" data-placement="top"
                                    title="Description is not required">
                                    <label for="description" class="col-form-label">Description:</label>
                                    <textarea class="form-control" name="description" id="description" placeholder="Description"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-buttons-w">
                            <button class="btn btn-primary" type="submit" id="add-product-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end content-i -->
@endsection

@section('scripts')
    {{-- additional scripts here --}}
    <script src="{{ asset('js/admin/products.js') }}"></script>
@endsection
