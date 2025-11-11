@extends('layouts.default.admin.master')
@section('title', 'Transfer Stocks')
@section('page-title', 'Transfer Stocks')

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
                                <h6 class="element-header text-center">@yield('title')</h6><br />
                                <div class="element-info">
                                    <div class="element-info-with-icon">
                                        <div class="element-info-icon">
                                            <div class="os-icon os-icon-hierarchy-structure-2"></div>
                                        </div>
                                        <div class="element-info-text">
                                            <h5 class="element-inner-header">@yield('title')</h5>
                                            <div class="element-inner-desc">Please fill out all information needed.<br><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if (empty($access_data))
                                    <form method="POST" action="" id="transfer_stockForm">
                                    @else
                                        @if ($access_data[0]->inventories[0]->transfer_stocks == 'true')
                                            <form method="POST" action="" id="transfer_stockForm">
                                            @else
                                                <form method="POST" action="">
                                        @endif
                                @endif
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""> From Branch</label>
                                            <select class="form-control req_fields" name="branch_from" id="branch_from"
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
                                <div class="col-md-12" id="product-group_data" style="display: none;">
                                    <fieldset>
                                        <legend><span>Product Information</span></legend>
                                        <div class="row margin-bottom">
                                            <div class="d-none d-sm-none d-md-block col-md-4"><label>Product</label></div>
                                            <div class="d-none d-sm-none d-md-block col-md-4"><label>Stocks</label></div>
                                            <div class="d-none d-sm-none d-md-block col-md-2"><label>Quantity</label></div>
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
                                                            <select class="form-control capitalized select_product_admin"
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


                                <div class="form-buttons-w">
                                    @if (empty($access_data))
                                        <button class="btn btn-primary" type="submit"> Save</button>
                                    @else
                                        @if ($access_data[0]->inventories[0]->transfer_stocks == 'true')
                                            <button class="btn btn-primary" type="submit"> Save</button>
                                        @else
                                            <button class="btn btn-primary disabled" type="button"> Save</button>
                                        @endif
                                    @endif
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
        var product_counter = 2;
        $("#add-product").click(function() {

            if (product_counter > 20) {
                alert("Only 20 textboxes allow");
                return false;
            }

            var newTextBoxDiv = $(document.createElement('div')).attr("id", 'product_id' + product_counter).attr(
                "class", 'item row');
            newTextBoxDiv.after().html(
                "<div class='col-md-4 margin-bottom'><div class='col-xs-4 d-block d-sm-none d-sm-block d-md-none'><label>Product</label></div><div class='col-xs-8'><div class='input-group'><select class='form-control capitalized select_product_admin' name='select_product[]'><option disabled selected>Select Product</option><optgroup label='Product'>@foreach ($productsData as $product)<option value='{{ $product->id }}'>{{ $product->name }}</option>@endforeach</optgroup><optgroup label='Packages'>@foreach ($packagesData as $package)<option value='{{ $package->id }}'>{{ $package->name }}</option>@endforeach</optgroup></select><div class='input-group-append d-block d-sm-none d-none d-sm-block d-md-none'><button type='button' class='btn btn-danger btn-md remove-product' style='height:38px;' data-id='1'>x</button></div></div></div></div><div class='col-md-4 margin-bottom'><div class='col-xs-4 d-block d-sm-none d-sm-block d-md-none'><label>Stocks</label></div><input type='number' class='stocks form-control' name='stocks' placeholder='Available Stocks' readonly></div><div class='col-md-2 margin-bottom'><div class='col-xs-4 d-block d-sm-none d-sm-block d-md-none'><label>Quantity</label></div><input type='number' class='qnty amount form-control product_qty' name='product_qty[]' placeholder='Enter Quantity'></div><div class='col-md-2 margin-bottom d-sm-none d-md-block d-none'><button type='button' class='btn btn-danger btn-xs remove-product' data-id='" +
                product_counter + "'>x</button></div><br><br><br>");
            newTextBoxDiv.appendTo("#product-group");
            product_counter++;

        });


        $('body').on('click', '.remove-product', function(event) {
            var id = $(this).data('id');
            console.log('remove product clicked ' + id);
            if (product_counter == 0) {
                alert("No more textbox to remove");
                return false;
            }

            product_counter--;
            $("#product_id" + id).remove();


        });
        /*ajax */
        $('body').on('change', '.select_product_admin', function(event) {

            if ($('#branch_from').val() == "" || $('#branch_to').val() == "") {
                alert("Please select the branches");
                $(this).val("");
            } else {
                var id = $(this).val();
                var dis = $(this);
                var branch_id = $('#branch_from').val()
                //var row = $(this).closest("tr");
                var row = $(this).closest(".row");
                var tr_id = $(row).attr('id');
                if (!$('.select_product_admin').val()) {

                } else {
                    $.ajax({
                        type: 'POST',
                        url: '/staff/edit-productData',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            productId: id,
                            branchId: branch_id
                        },
                        beforeSend: function() {
                            $('.preloader').show();
                        },
                        success: function(data) {
                            $('.preloader').hide();
                            console.log(data);
                            $('#' + tr_id).find('.stocks').val(data.products_data.quantity);
                            $('#' + tr_id).find('.qnty').attr({
                                "max": data.products_data.quantity, // substitute your own
                                "min": 0, // values (or variables) here
                                "required": true, // values (or variables) here
                            });

                        }
                    });

                }
            }
        });

        $("#branch_to").change(function() {
            $('.preloader').show();
            $('.stocks').val('');
            $('.select_product_admin').prop('selectedIndex', 0);
            if (product_counter == 2 && $('#branch_from').val() != "" && $('#branch_to').val() != "") {

                $('#product-group_data').show();
                $('.preloader').hide();
            } else if (product_counter > 2) {
                if ($('#branch_from').val() != "" && $('#branch_to').val() != "") {

                    $('#product-group_data').show();
                    $('.preloader').hide();
                } else {


                    for (var x = 2; product_counter >= 1;) {
                        $("#product_id" + product_counter).remove();
                        product_counter--;
                    }
                    var newTextBoxDiv = $(document.createElement('div')).attr("id", 'product_id1').attr("class",
                        'item row');
                    newTextBoxDiv.after().html(
                        "<div class='col-md-4 margin-bottom'><div class='col-xs-4 d-block d-sm-none d-sm-block d-md-none'><label>Product</label></div><div class='col-xs-8'><div class='input-group'><select class='form-control capitalized select_product_admin' name='select_product[]'><option disabled selected>Select Product</option>@foreach ($productsData as $product)<option value='{{ $product->id }}'>{{ $product->name }}</option>@endforeach</select><div class='input-group-append d-block d-sm-none d-none d-sm-block d-md-none'><button type='button' class='btn btn-danger btn-md remove-product' style='height:38px;' data-id='1'>x</button></div></div></div></div><div class='col-md-4 margin-bottom'><div class='col-xs-4 d-block d-sm-none d-sm-block d-md-none'><label>Stocks</label></div><input type='number' class='stocks form-control' name='stocks' placeholder='Available Stocks' readonly></div><div class='col-md-2 margin-bottom'><div class='col-xs-4 d-block d-sm-none d-sm-block d-md-none'><label>Quantity</label></div><input type='number' class='qnty amount form-control product_qty' name='product_qty[]' placeholder='Enter Quantity'></div><div class='col-md-2 margin-bottom d-sm-none d-md-block d-none'><button type='button' class='btn btn-danger btn-xs remove-product' data-id='1'>x</button></div><br><br><br>"
                    );
                    newTextBoxDiv.appendTo("#product-group");


                    $('#product-group_data').hide();
                    $('.preloader').hide();
                    product_counter = 2;
                }

            } else {
                $('#product-group_data').hide();
                $('.preloader').hide();
            }


        });
        $("#branch_from").change(function() {
            var id = $(this).find(":selected").val();
            console.log(id);
            $('#branch_to').find('option[value="' + id + '"]').attr('disabled', 'disabled');
            $('#branch_to').find('option[value!="' + id + '"]').attr('disabled', false);
            $('#branch_to').val('').trigger('change');

            if (product_counter == 2 && $('#branch_from').val() != "" && $('#branch_to').val() != "") {
                $('#product-group_data').show();
            } else if (product_counter > 2) {



                if ($('#branch_from').val() != "" && $('#branch_to').val() != "") {
                    $('#product-group_data').show();
                } else {
                    for (var x = 2; product_counter >= 1;) {
                        $("#product_id" + product_counter).remove();
                        product_counter--;
                    }
                    var newTextBoxDiv = $(document.createElement('div')).attr("id", 'product_id1').attr("class",
                        'item row');
                    newTextBoxDiv.after().html(
                        "<div class='col-md-4 margin-bottom'><div class='col-xs-4 d-block d-sm-none d-sm-block d-md-none'><label>Product</label></div><div class='col-xs-8'><div class='input-group'><select class='form-control capitalized select_product_admin' name='select_product[]'><option disabled selected>Select Product</option>@foreach ($productsData as $product)<option value='{{ $product->id }}'>{{ $product->name }}</option>@endforeach</select><div class='input-group-append d-block d-sm-none d-none d-sm-block d-md-none'><button type='button' class='btn btn-danger btn-md remove-product' style='height:38px;' data-id='1'>x</button></div></div></div></div><div class='col-md-4 margin-bottom'><div class='col-xs-4 d-block d-sm-none d-sm-block d-md-none'><label>Stocks</label></div><input type='number' class='stocks form-control' name='stocks' placeholder='Available Stocks' readonly></div><div class='col-md-2 margin-bottom'><div class='col-xs-4 d-block d-sm-none d-sm-block d-md-none'><label>Quantity</label></div><input type='number' class='qnty amount form-control product_qty' name='product_qty[]' placeholder='Enter Quantity'></div><div class='col-md-2 margin-bottom d-sm-none d-md-block d-none'><button type='button' class='btn btn-danger btn-xs remove-product' data-id='1'>x</button></div><br><br><br>"
                    );
                    newTextBoxDiv.appendTo("#product-group");

                    $('#product-group_data').hide();
                    product_counter = 2;
                }
            } else {
                $('#product-group_data').hide();
            }


        });

        $('body').on('submit', '#transfer_stockForm', function(event) {
            event.preventDefault();
            var branch_from = $('#branch_from').val();
            var branch_to = $('#branch_to').val();
            var product_id2 = [];
            var url = "insert-stocks";

            $('.product_qty').each(function(x) {
                var product_id = new Object();
                var qtyData = $(this).val();
                var productData = $('.select_product_admin').eq(x).val();

                if (qtyData && productData) {
                    product_id.id = productData;
                    product_id.qty = qtyData;
                    product_id2.push(product_id);
                }
            });

            if (!branch_from || !branch_to) {
                swal("Failed!", 'Branches are required!', 'error');
                $("#branch_from, #branch_to").css("border", "1px solid red");
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
                        branch_from: branch_from
                    },
                    beforeSend: function() {
                        $('.preloader').show();
                    },
                    success: function(response) {
                        console.log(response);
                        $('.preloader').hide();
                        swal({
                            title: 'Success!',
                            text: 'Transferred Successfully',
                            timer: 2000,
                            type: "success"
                        });

                        setTimeout(function() {
                            window.location.href = 'transfer-stocks';
                        }, 2000);
                    },
                    error: function(error) {
                        $('.preloader').hide();
                        swal({
                            title: 'Error!',
                            text: "Error Msg: " + error.responseJSON.message,
                            timer: 1500,
                            type: "error"
                        });
                    }
                });
            }
        });



        $('body').on('click', '.remove-product', function(event) {
            var id = $(this).data('id');
            console.log('remove product clicked ' + id);
            if (product_counter == 1) {
                alert("No more textbox to remove");
                return false;
            }
            product_counter--;
            $("#product_id" + id).remove();

        });
    </script>

@endsection
