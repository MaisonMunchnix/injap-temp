@extends('layouts.default.teller.master')
@section('title', 'New Transaction')
@section('page-title', 'New Transaction')

@section('stylesheets')
    {{-- additional style here --}}
    <!-- swal -->

    <style>
        @media only screen and (max-width: 767px) {
            .item {
                margin: 0px !important;
                padding: 15px !important;
                border: 2px solid blueviolet;
                margin-bottom: 20px !important;
            }

            .item:hover {
                background-color: #f4f8f9 !important;
            }
        }

        .border-red {
            border: 1px solid red !important;
        }

        .first {
            width: 5% !important;
        }

        .others {
            width: 19% !important;
        }

        .margin-bottom {
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="content-body">
        <!-- start content- -->
        <!-- @include('user.dashboard.upgrade_modal') -->
        <div class="content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="">
                        <h6 class="element-header">@yield('title')</h6>
                        <br><br>
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <form class="form-validate" id="newTransactionForm" action="" method="post">
                                        @csrf
                                        <div class="element-info">
                                            <div class="element-info-with-icon">
                                                <div class="element-info-icon">
                                                    <div class="os-icon os-icon-user"></div>
                                                </div>
                                                <div class="element-info-text">
                                                    <h5 class="element-inner-header">Walk In / Non-Member</h5>
                                                    <div class="element-inner-desc">Please fill out all information
                                                        needed.<br /><br /></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for=""> Customer Full Name</label>
                                                    <input class="form-control" data-error="Please input Full Name"
                                                        placeholder="Full Name" name="full_name" required="required"
                                                        type="text">
                                                    <div class="help-block form-text with-errors form-control-feedback">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Email Address</label>
                                                    <input class="form-control" data-error="Please input Email Address"
                                                        name="email_address" placeholder="Email Address" required="required"
                                                        type="email">
                                                    <div class="help-block form-text with-errors form-control-feedback">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for=""> Telephone Number</label>
                                                    <input class="form-control" data-error="Please input Telephone Number"
                                                        name="telephone_number" placeholder="Telephone Number"
                                                        required="required" type="text">
                                                    <div class="help-block form-text with-errors form-control-feedback">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Mobile Number</label>
                                                    <input class="form-control" data-error="Please input Mobile Number"
                                                        name="mobile_number" placeholder="Mobile Number" required="required"
                                                        type="text">
                                                    <div class="help-block form-text with-errors form-control-feedback">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea class="form-control" rows="1" name="address" required></textarea>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="select_form_select">
                                                    <label for="province_id">Province</label>
                                                    <select class="form-control" name="province_id" id="province_id"
                                                        required>
                                                        <option value="">Select Province</option>
                                                        @foreach ($provinces as $province)
                                                            <option value="{{ $province->provCode }}">
                                                                {{ $province->provDesc }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="province" id="province_name">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="select_form_select">
                                                    <label for="city_id">Town/City</label>
                                                    <select class="form-control" name="city_id" id="city_id" required>
                                                        <option value="">Select City</option>
                                                    </select>
                                                    <input type="hidden" name="city" id="city_name">
                                                </div>
                                            </div>
                                        </div>

                                        <fieldset class="form-group">
                                            <legend><span>Product Information</span></legend>
                                            <table class="table" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="first">#</th>
                                                        <th class="others">Product</th>
                                                        <th class="others">Quantity</th>
                                                        <th class="others">Price</th>
                                                        <th class="others">Total</th>
                                                        <th class="others">
                                                            <button type="button" id="add-product"
                                                                class="btn btn-primary">+ Product</button>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="product-group">
                                                    <tr id="product_id1" class="item">
                                                        <td>#1</td>
                                                        <td>
                                                            <select class="form-control capitalized select_product"
                                                                name="select_product[]">
                                                                <option disabled selected>Select Product</option>
                                                                @foreach ($products as $product)
                                                                    @php
                                                                        if ($product->quantity == 0) {
                                                                            $disabled = 'true';
                                                                            $badge = 'badge badge-danger';
                                                                            $label = 'No Stock';
                                                                        } else {
                                                                            $disabled = 'false';
                                                                            $badge = '';
                                                                            $label = '';
                                                                        }
                                                                    @endphp
                                                                    <option value="{{ $product->id }}"
                                                                        disabled="{{ $disabled }}">{{ $product->name }}
                                                                        (<span
                                                                            class="{{ $badge }}">{{ $label }}</span>)
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="number"
                                                                class="qnty amount form-control product_qty"
                                                                name="product_qty[]" placeholder="Enter Quantity">
                                                        </td>
                                                        <td>
                                                            <input type="number" class="price product_price form-control"
                                                                readonly name="product_price[]" placeholder="">
                                                        </td>
                                                        <td><input class="form-control total" type="text" readonly
                                                                required></td>
                                                        <td><button type='button'
                                                                class='btn btn-danger btn-xs remove-product'
                                                                data-id='1'>x</button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </fieldset>

                                        <fieldset class="form-group">
                                            <legend><span><br />Package Information</span></legend>
                                            <div class="row margin-bottom">
                                                <div class="d-none d-sm-none d-md-block col-md-4"><label>Package</label>
                                                </div>
                                                <div class="d-none d-sm-none d-md-block col-md-2"><label>Quantity</label>
                                                </div>
                                                <div class="d-none d-sm-none d-md-block col-md-2"><label>Price</label>
                                                </div>
                                                <div class="d-none d-sm-none d-md-block col-md-2"><label>Total</label>
                                                </div>
                                                <div class="col-md-2"><button type="button" id="add-package"
                                                        class="btn btn-primary btn-block">+ Package</button></div>
                                            </div>
                                            <div id="package-group">
                                                <div id="package_id1" class="item row">
                                                    <div class="col-md-4 margin-bottom">
                                                        <div class="col-xs-4 d-block d-sm-none d-sm-block d-md-none">
                                                            <label>Package</label>
                                                        </div>
                                                        <div class="col-xs-8">
                                                            <div class="input-group">
                                                                <select class="form-control capitalized select_package"
                                                                    name="select_package[]">
                                                                    <option value="" selected disabled>Select Package
                                                                    </option>
                                                                    @foreach ($packages as $package)
                                                                        <optgroup label="{{ $package->name }}">
                                                                            <option value="{{ $package->id }}">
                                                                                {{ $package->name }} A</option>
                                                                            <option value="{{ $package->id }}">
                                                                                {{ $package->name }} B</option>
                                                                            <option value="{{ $package->id }}">
                                                                                {{ $package->name }} C</option>
                                                                            <option value="{{ $package->id }}">
                                                                                {{ $package->name }} D</option>
                                                                        </optgroup>
                                                                    @endforeach
                                                                    <optgroup label="Others">
                                                                        @foreach ($other_packages as $other_package)
                                                                            <option value="{{ $other_package->id }}">
                                                                                {{ $other_package->name }}</option>
                                                                        @endforeach
                                                                    </optgroup>
                                                                </select>
                                                                <div
                                                                    class="input-group-append d-block d-sm-none d-none d-sm-block d-md-none">
                                                                    <button type='button'
                                                                        class='btn btn-danger btn-md remove-package'
                                                                        style="height:38px;" data-id='1'>x</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 margin-bottom">
                                                        <div class="col-xs-4 d-block d-sm-none d-sm-block d-md-none">
                                                            <label>Quantity</label>
                                                        </div>
                                                        <input type="number" class="qnty amount form-control package_qty"
                                                            name="package_qty[]" placeholder="Enter Quantity">
                                                    </div>
                                                    <div class="col-md-2 margin-bottom">
                                                        <div class="col-xs-4 d-block d-sm-none d-sm-block d-md-none">
                                                            <label>Price</label>
                                                        </div>
                                                        <input type="number" class="price package_price form-control"
                                                            readonly name="package_price[]" placeholder="">
                                                    </div>
                                                    <div class="col-md-2 margin-bottom">
                                                        <div class="col-xs-4 d-block d-sm-none d-sm-block d-md-none">
                                                            <label>Total</label>
                                                        </div>
                                                        <input class="form-control total" type="text" readonly
                                                            required>
                                                    </div>
                                                    <div class="col-md-2 margin-bottom d-sm-none d-md-block d-none">
                                                        <button type='button'
                                                            class='btn btn-danger btn-xs remove-package'
                                                            data-id='1'>x</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row margin-bottom"
                                                style="background:linear-gradient(-90deg, #0832de 0%, #0832de 100%) !important; color:white !important; padding:10px !important;">
                                                <div class="col-xs-6 col-sm-6 col-md-2">
                                                    <h5 style="color:white !important;">TOTAL</h5>
                                                </div>
                                                <div class="col-xs-6 col-sm-6 offset-md-6 col-md-2 text-right float-right">
                                                    <input name="total_price" type="text"
                                                        class="form-control total_price" readonly required></div>
                                            </div>
                                        </fieldset>

                                        <div class="form-buttons-w">
                                            <button class="btn btn-primary" type="submit"> Proceed Shopping</button>
                                        </div>
                                    </form>
                                </div>
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
    <script>
        var token = "{{ csrf_token() }}";
    </script>

    <script>
        $(document).ready(function() {
            getCityData();

            $("#province_id").change(function(event) {
                var dis_val = $(this).val();
                $('#city_id').empty();
                $('#city_id').append('<option value="">Select City</option>');
                $.each(city_data, function(i, value) {
                    if (value.provCode == dis_val) {
                        $('#city_id').append('<option value="' + value.citymunCode + '">' + value
                            .citymunDesc + '</option>');
                    }
                });
                var dis_text = $("#province_id option:selected").text();
                $('#province_name').val(dis_text);

            });
            $("#city_id").change(function(event) {
                var dis_text = $("#city_id option:selected").text();
                $('#city_name').val(dis_text);
            });
            $('body').on('submit', '#newTransactionForm', function(event) {
                event.preventDefault();
                console.log('btn clicked');

                var full_name = $("#full_name").val();
                var email_address = $("#email_address").val();
                var mobile_number = $("#mobile_number").val();
                var telephone_number = $("#telephone_number").val();
                var address = $("#address").val();
                var province = $('#province_name').val();
                var city = $('#city_name').val();
                var product = $('input[name=select_product').val();
                var product_qty = $('input[name=product_qty').val();
                var product_price = $('input[name=product_price').val();
                var package = $('input[name=select_package').val();
                var package_qty = $('input[name=package_qty').val();
                var package_price = $('input[name=package_price').val();

                //if (isEmpty(product == "" && package == "")) {
                if (!$('.select_product').val() && !$('.select_package').val()) {
                    swal({
                        title: 'Error!',
                        text: "No Product or Package Selected!",
                        timer: 2000,
                        type: "error",
                    })
                } else if (!province) {
                    swal({
                        title: 'Error!',
                        text: "No Province Selected!",
                        timer: 2000,
                        type: "error",
                    })
                } else if (!city) {
                    swal({
                        title: 'Error!',
                        text: "No City Selected!",
                        timer: 2000,
                        type: "error",
                    })
                } else {
                    var formData = {
                        'full_name': full_name,
                        'email_address': email_address,
                        'mobile_number': mobile_number,
                        'telephone_number': telephone_number,
                        'address': address,
                        'city': city,
                        'province': province,

                        'select_product': product,
                        'product_qty': product_qty,
                        'product_price': product_price,


                        'select_package': package,
                        'package_qty': package_qty,
                        'package_price': package_price,
                        'token': token
                    };
                    //var action = 'new-transaction/insert';
                    var url = "../new-transaction/insert";
                    $.ajax({
                        url: "../new-transaction/insert",
                        type: 'POST',
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            $('.preloader').show();
                        },
                        success: function(response) {
                            var transaction_id = response.transaction_id;
                            console.log('Product submitting success...');
                            $('.preloader').hide();
                            swal({
                                title: 'Success!',
                                text: 'Transaction Successfully',
                                timer: 1500,
                                type: "success",
                            });
                            window.location.href = '../view-receipt/' + transaction_id;

                        },
                        error: function(error) {
                            console.log('Product submitting error...');
                            console.log(error);
                            console.log(error.responseJSON.message);
                            $('.preloader').hide();
                            swal({
                                title: 'Error!',
                                text: "Error Msg: " + error.responseJSON.message + "",
                                timer: 1500,
                                type: "error",
                            })

                        }
                    });
                }

            });

            var product_counter = 2;
            var package_counter = 2;

            $('body').on('change', '.select_product', function(event) {
                var id = $(this).val();

                var dis = $(this);
                var row = $(this).closest("tr");
                var tr_id = $(row).attr('id');
                $.ajax({
                    type: 'get',
                    url: '../edit-product/' + id,
                    beforeSend: function() {
                        $('.preloader').show();
                    },
                    success: function(data) {
                        $('.preloader').hide();
                        if (data.quantity == 0) {
                            swal({
                                title: 'Error!',
                                text: "No Stocks Available!",
                                timer: 1500,
                                icon: "error",
                            })
                            $('#' + tr_id).find('.select_product').selectedIndex = 0;
                            $('#' + tr_id).find('.select_product').val('');
                            $('#' + tr_id).find('.price').val(''); // New Discounted Price
                            $('#' + tr_id).find('.qnty').attr({
                                "max": 0, // substitute your own
                                "min": 0, // values (or variables) here
                                "required": false
                            });
                        } else {
                            $('#' + tr_id).find('.price').val(data
                            .price); // New Discounted Price
                            $('#' + tr_id).find('.stocks').val(data.quantity);
                            $('#' + tr_id).find('.qnty').attr({
                                "max": data.quantity, // substitute your own
                                "min": 1, // values (or variables) here
                                "required": true
                            });
                        }

                        calcAll();
                    }
                });

            });

            $(".select_package").change(function() {
                var id = $(this).val();
                var dis = $(this);
                var row = $(this).closest(".row");
                var tr_id = $(row).attr('id');
                if (!$('.select_package').val()) {
                    $('#' + tr_id).find('.total').val('');
                    $('#' + tr_id).find('.qnty').val('');
                    $('#' + tr_id).find('.price').val('');
                    $('#' + tr_id).find('.qnty').attr({
                        "min": 0, // values (or variables) here
                        "required": false, // values (or variables) here
                    });
                    calcAll();
                } else {
                    var action = 'edit-package/' + id;
                    var url = 'edit-package';
                    $.ajax({
                        type: 'get',
                        url: '../new-transaction/package/' + id,
                        beforeSend: function() {
                            $('.preloader').show();
                        },
                        success: function(data) {
                            $('.preloader').hide();
                            if (data.stocks == 0) {
                                swal({
                                    title: 'Error!',
                                    text: "No Stocks Available!",
                                    timer: 1500,
                                    icon: "error",
                                })
                                $('#' + tr_id).find('.select_package').selectedIndex = 0;
                                $('#' + tr_id).find('.select_package').val('');
                                $('#' + tr_id).find('.price').val(''); // New Discounted Price
                                $('#' + tr_id).find('.qnty').attr({
                                    "max": 0, // substitute your own
                                    "min": 0, // values (or variables) here
                                    "required": false
                                });
                            } else {
                                $('#' + tr_id).find('.qnty').attr({
                                    "min": 1, // values (or variables) here
                                    "required": true, // values (or variables) here
                                });
                                $('#' + tr_id).find('.price').val(data.price)
                            }

                            calcAll();
                        }
                    });
                }

            });

            $("#add-product").click(function() {

                if (product_counter > 20) {
                    alert("Only 20 textboxes allow");
                    return false;
                }

                var newTextBoxDiv = $(document.createElement('tr'))
                    .attr("id", 'product_id' + product_counter, "class", 'item').attr("class", 'item');
                newTextBoxDiv.after().html("<td>#" + product_counter + "</td><td>" +
                    "<select class='form-control capitalized select_product' name='select_product[]'>" +
                    "<option value=''>Please select</option>" +
                    "@foreach ($products as $product)" +
                    "<option value='{{ $product->id }}'>{{ $product->name }}</option>" +
                    "@endforeach" +
                    "</select>" +
                    "</td>" +
                    "<td>" +
                    "<input type='number' class='form-control qnty amount' name='product_qty[]' placeholder='Enter Quantity'>" +
                    "</td>" +
                    "<td>" +
                    "<input type='number' class='form-control price' readonly name='product_price[]'>" +
                    "</td>" +
                    "<td><input class='form-control total' type='text' readonly required></td>" +
                    "<td><button type='button' class='btn btn-danger btn-xs remove-product' data-id='" +
                    product_counter + "'>x</button></td>" +
                    "</tr>");

                newTextBoxDiv.appendTo("#product-group");


                product_counter++;
            });



            $("#add-package").click(function() {

                if (package_counter > 20) {
                    alert("Only 20 textboxes allow");
                    return false;
                }

                var newTextBoxDiv = $(document.createElement('div')).attr("id", 'package_id' +
                    package_counter).attr("class", 'item row');
                newTextBoxDiv.after().html(
                    "<div class='col-md-4 margin-bottom'><div class='col-xs-4 d-block d-sm-none d-sm-block d-md-none'><label>Package</label></div><div class='col-xs-8'><div class='input-group'><select class='form-control capitalized select_package' name='select_package[]'>" +
                    "<option value='' selected disabled>Select Package</option>" +
                    "@foreach ($packages as $package)" +
                    "<optgroup label='{{ $package->name }}'>" +
                    "<option value='{{ $package->id }}'>{{ $package->name }} A</option>" +
                    "<option value='{{ $package->id }}'>{{ $package->name }} B</option>" +
                    "<option value='{{ $package->id }}'>{{ $package->name }} C</option>" +
                    "<option value='{{ $package->id }}'>{{ $package->name }} D</option>" +
                    "</optgroup>" +
                    "@endforeach" +
                    "<optgroup label='Others'>" +
                    "@foreach ($other_packages as $other_package)" +
                    "<option value='{{ $other_package->id }}'>{{ $other_package->name }}</option>" +
                    "@endforeach" +
                    "</optgroup>" +
                    "</select><div class='input-group-append d-block d-sm-none d-none d-sm-block d-md-none'><button type='button' class='btn btn-danger btn-md remove-package' style='height:38px;' data-id='1'>x</button></div></div></div></div><div class='col-md-2 margin-bottom'><div class='col-xs-4 d-block d-sm-none d-sm-block d-md-none'><label>Quantity</label></div><input type='number' class='qnty amount form-control package_qty' name='package_qty[]' placeholder='Enter Quantity'></div><div class='col-md-2 margin-bottom'><div class='col-xs-4 d-block d-sm-none d-sm-block d-md-none'><label>Price</label></div><input type='number' class='price package_price form-control' readonly name='package_price[]' placeholder=''></div><div class='col-md-2 margin-bottom'><div class='col-xs-4 d-block d-sm-none d-sm-block d-md-none'><label>Total</label></div><input class='form-control total' type='text' readonly required></div><div class='col-md-2 margin-bottom d-sm-none d-md-block d-none'><button type='button' class='btn btn-danger btn-xs remove-package' data-id='" +
                    package_counter + "'>x</button></div>");

                newTextBoxDiv.appendTo("#package-group");


                package_counter++;
            });

            $('body').on('click', '.remove-product', function(event) {
                var id = $(this).data('id');
                product_counter--;
                $("#product_id" + id).remove();
                calcAll();

            });

            $('body').on('click', '.remove-package', function(event) {
                var id = $(this).data('id');
                package_counter--;
                $("#package_id" + id).remove();
                calcAll();
            });

            $("#getButtonValue").click(function() {

                var msg = '';
                for (i = 1; i < counter; i++) {
                    msg += "\n Textbox #" + i + " : " + $('#textbox' + i).val();
                }
                alert(msg);
            });


            // calculate everything
            $('body').on('keyup', '.amount', function() {
                calcAll();
                console.log('Calculate function');
            });

            function calcAll() {
                // calculate total for one row
                $(".item").each(function() {
                    console.log('Calculate item');
                    var qnty = 0;
                    var price = 0;
                    var total = 0;
                    if (!isNaN(parseFloat($(this).find(".qnty").val()))) {
                        qnty = parseFloat($(this).find(".qnty").val());
                    }
                    if (!isNaN(parseFloat($(this).find(".price").val()))) {
                        price = parseFloat($(this).find(".price").val());
                    }
                    total = qnty * price;
                    $(this).find(".total").val(total.toFixed(2));
                });

                // sum all totals
                var sum = 0;
                $(".total").each(function() {
                    if (!isNaN(this.value) && this.value.length != 0) {
                        sum += parseFloat(this.value);
                    }
                });

                $(".total_price").val(sum.toFixed(2));
            }

        });

        function getCityData() {
            $.ajax({
                url: '/get-province',
                type: 'GET',
                success: function(response) {
                    city_data = response.city;
                },
                error: function(error) {
                    console.log('Getting data error...');
                    console.log(error);
                }
            });
        }
    </script>
@endsection
