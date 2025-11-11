@extends('layouts.default.admin.master')
@section('title', 'Add Stocks')
@section('page-title', 'Add Stocks')

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
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">

                        <div class="col-md-12">
                            <div class="card-body">
                                @if (empty($access_data))
                                    <form method="POST" action="" id="add_stock_form">
                                    @else
                                        @if ($access_data[0]->inventories[0]->transfer_stocks == 'true')
                                            <form method="POST" action="" id="add_stock_form">
                                            @else
                                                <form method="POST" action="">
                                        @endif
                                @endif
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="element-info">
                                            <div class="element-info-with-icon">
                                                <div class="element-info-icon">
                                                    <div class="os-icon os-icon-hierarchy-structure-2"></div>
                                                </div>
                                                <div class="element-info-text">
                                                    <h5 class="element-inner-header">@yield('title')</h5>
                                                    <div class="element-inner-desc">Please fill out all information
                                                        needed.<br><br></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""> Transfer To</label>
                                            <select class="form-control req_fields" name="branch_to" id="branch_to"
                                                required>
                                                <option value="">Select Branch</option>
                                                @if (!empty($branches))
                                                    @foreach ($branches as $branch)
                                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <div class="help-block form-text with-errors form-control-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" id="product-group_data" style="display: none;">
                                        <fieldset>
                                            <legend><span>Product Information</span></legend>
                                            <div class="row margin-bottom">
                                                <div class="d-none d-sm-none d-md-block col-md-4"><label>Product</label>
                                                </div>
                                                <div class="d-none d-sm-none d-md-block col-md-4"><label>Current
                                                        Stock/s</label></div>
                                                <div class="d-none d-sm-none d-md-block col-md-2"><label>Additional
                                                        Stock/s</label></div>
                                                <div class="col-md-2"><button type="button" id="add-product"
                                                        class="btn btn-primary btn-block">+ Product</button></div>

                                            </div>
                                            <br>
                                            <div id="product-group">
                                                <div id="product_id1" class="item row">
                                                    <div class="col-md-4 margin-bottom">
                                                        <div class="col-xs-4 d-block d-sm-none d-sm-block d-md-none">
                                                            <label>Product</label>
                                                        </div>
                                                        <div class="col-xs-4">
                                                            <div class="input-group">
                                                                <select
                                                                    class="form-control capitalized select_product_admin"
                                                                    name="select_product[]">
                                                                    <option value="" selected>Select Product</option>
                                                                    <optgroup label="Product">
                                                                        @foreach ($productsData as $product)
                                                                            <option value="{{ $product->id }}">
                                                                                {{ $product->name }}</option>
                                                                        @endforeach
                                                                    </optgroup>
                                                                    <optgroup label="Packages">
                                                                        @foreach ($packagesData as $package)
                                                                            <option value="{{ $package->id }}">
                                                                                {{ $package->name }}</option>
                                                                        @endforeach
                                                                    </optgroup>
                                                                </select>
                                                                <div
                                                                    class="input-group-append d-block d-sm-none d-none d-sm-block d-md-none">
                                                                    <button type='button'
                                                                        class='btn btn-danger btn-md remove-product'
                                                                        style="height:38px;" data-id='1'>x</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 margin-bottom">
                                                        <div class="col-xs-4 d-block d-sm-none d-sm-block d-md-none">
                                                            <label>Stocks</label>
                                                        </div>
                                                        <input type="number" class="stocks form-control" name="stocks"
                                                            placeholder="Available Stocks" readonly>
                                                    </div>
                                                    <div class="col-md-2 margin-bottom">
                                                        <div class="col-xs-4 d-block d-sm-none d-sm-block d-md-none">
                                                            <label>Quantity</label>
                                                        </div>
                                                        <input type="number" class="qnty amount form-control product_qty"
                                                            name="product_qty[]" placeholder="Enter Quantity">
                                                    </div>
                                                    <div class="col-md-2 margin-bottom d-sm-none d-md-block d-none">
                                                        <button type='button' class='btn btn-danger btn-xs remove-product'
                                                            data-id='1'>x</button>
                                                    </div>
                                                    <br><br><br>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="offset-md-10 col-md-2">
                                        <div class="form-buttons-w">
                                            @if (empty($access_data))
                                                <button class="btn btn-primary btn-block pull-right" type="submit">
                                                    Save</button>
                                            @else
                                                @if ($access_data[0]->inventories[0]->transfer_stocks == 'true')
                                                    <button class="btn btn-primary btn-block pull-right" type="submit">
                                                        Save</button>
                                                @else
                                                    <button class="btn btn-primary btn-block pull-right disabled"
                                                        type="button"> Save</button>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- end content-i -->
@endsection

@section('scripts')
    {{-- additional scripts here --}}
    <!-- Sweetalert -->

    <script src="{{ asset('js/admin/branch.js') }}"></script>
    <script>
        var product_counter = 0;
        console.log('CUrrent: ' + product_counter);

        $("#add-product").click(function() {
            if (product_counter > 20) {
                alert("Only 20 textboxes allowed");
                return false;
            }

            var productTemplate = `
        <div id='product_id${product_counter}' class='item row'>
            <div class='col-md-4 margin-bottom'>
                <div class='col-xs-4 d-block d-sm-none d-sm-block d-md-none'>
                    <label>Product</label>
                </div>
                <div class='col-xs-8'>
                    <div class='input-group'>
                        <select class='form-control capitalized select_product_admin' name='select_product[]'>
                            <option disabled selected>Select Product</option>
                            <optgroup label='Product'>
                                @foreach ($productsData as $product)
                                    <option value='{{ $product->id }}'>{{ $product->name }}</option>
                                @endforeach
                            </optgroup>
                            <optgroup label='Packages'>
                                @foreach ($packagesData as $package)
                                    <option value='{{ $package->id }}'>{{ $package->name }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                        <div class='input-group-append d-block d-sm-none d-none d-sm-block d-md-none'>
                            <button type='button' class='btn btn-danger btn-md remove-product' style='height:38px;' data-id='${product_counter}'>x</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-md-4 margin-bottom'>
                <div class='col-xs-4 d-block d-sm-none d-sm-block d-md-none'>
                    <label>Stocks</label>
                </div>
                <input type='number' class='stocks form-control' name='stocks' placeholder='Available Stocks' readonly>
            </div>
            <div class='col-md-2 margin-bottom'>
                <div class='col-xs-4 d-block d-sm-none d-sm-block d-md-none'>
                    <label>Quantity</label>
                </div>
                <input type='number' class='qnty amount form-control product_qty' name='product_qty[]' placeholder='Enter Quantity'>
            </div>
            <div class='col-md-2 margin-bottom d-sm-none d-md-block d-none'>
                <button type='button' class='btn btn-danger btn-xs remove-product' data-id='${product_counter}'>x</button>
            </div>
            <br><br><br>
        </div>
    `;

            $("#product-group").append(productTemplate);
            product_counter++;
            console.log('Added: ' + product_counter);
        });



        $('body').on('click', '.remove-product', function(event) {
            var id = $(this).data('id');
            console.log('Remove product clicked ' + id);

            if (product_counter > 1) {
                product_counter--;
                $(`#product_id${id}`).remove();
            } else {
                alert("At least one product is required.");
            }
        });



        /*ajax */
        $('body').on('change', '.select_product_admin', function(event) {
            var branchTo = $('#branch_to').val();
            var selectedProduct = $(this).val();
            var row = $(this).closest('.row');

            if (!branchTo) {
                alert('Please select the branches');
                $(this).val('');
            } else {
                $.ajax({
                    type: 'POST',
                    url: '/staff/edit-productData',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        productId: selectedProduct,
                        branchId: branchTo
                    },
                    beforeSend: function() {
                        $('.preloader').show();
                    },
                    success: function(data) {
                        $('.preloader').hide();
                        console.log(data);

                        var stocksInput = row.find('.stocks');
                        var qntyInput = row.find('.qnty');

                        stocksInput.val(data.products_data.quantity);
                        qntyInput.attr({
                            "min": 0,
                            "required": true
                        });
                    }
                });
            }
        });

        $("#branch_to").change(function() {
            $('.stocks').val('');
            $('.select_product_admin').prop('selectedIndex', 0);

            if ($('#branch_to').val() !== "") {
                // Remove existing product rows
                for (var x = product_counter; x >= 1; x--) {
                    if (x !== 1) {
                        $("#product_id" + x).remove();
                    }
                }

                if (product_counter === 0) {
                    product_counter = 1;
                }

                $('#product-group_data').show();
            } else if (product_counter > 0) {
                // Remove existing product rows
                for (var x = product_counter; x > 1; x--) {
                    $("#product_id" + x).remove();
                }
                product_counter = 1;

                $('#product-group_data').show();
            } else {
                $('#product-group_data').hide();
            }
        });

        $('body').on('submit', '#add_stock_form', function(event) {
            event.preventDefault();

            var branch_to = $('#branch_to').val();
            var product_id2 = [];
            var url = "{{ route('add-stocks-insert') }}";

            $('.product_qty').each(function() {
                var product_qty = $(this).val();
                var product_id = $(this).closest('.item').find('.select_product_admin').val();

                if (product_qty && product_id) {
                    product_id2.push({
                        id: product_id,
                        qty: product_qty
                    });
                }
            });

            if (!branch_to) {
                swal("Failed!", 'Branch is required!', 'error');
                $("#branch_to").css("border", "1px solid red");
            } else if (product_id2.length === 0) {
                swal("Failed!", 'At least one product with quantity is required', 'error');
            } else {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        data: product_id2,
                        branch_to: branch_to,
                    },
                    beforeSend: function() {
                        $('.preloader').show();
                    },
                    success: function(response) {
                        console.log(response);
                        $('.preloader').hide();
                        swal({
                            title: 'Success!',
                            text: 'Added Successfully',
                            timer: 2000,
                            type: "success"
                        });

                        setTimeout(function() {
                            window.location.href = 'add-stocks';
                        }, 2000);
                    },
                    error: function(error) {
                        $('.preloader').hide();
                        swal({
                            title: 'Error!',
                            text: "Error Msg: " + error.responseJSON.message,
                            timer: 1500,
                            type: "error",
                        });
                    }
                });
            }
        });
    </script>

@endsection
