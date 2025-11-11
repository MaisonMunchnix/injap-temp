@extends('layouts.user.master')

@section('title', 'New Transaction')

@section('stylesheets')

@endsection


@section('content')
    <div class="card-header">
        <h5 class="card-title">@yield('title')</h5>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs nav-justified mb-3" id="defaultTabJustified" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab-justified" data-toggle="tab" href="#home-justified" role="tab"
                    aria-controls="home" aria-selected="true">Walk In / Non-Member</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab-justified" data-toggle="tab" href="#profile-justified" role="tab"
                    aria-controls="profile" aria-selected="false">Walk In / Member</a>
            </li>

        </ul>
        <div class="tab-content" id="defaultTabJustifiedContent">
            <div class="tab-pane fade show active" id="home-justified" role="tabpanel" aria-labelledby="home-tab-justified">
                <form class="form-validate" id="newTransactionForm" action="" method="post">
                    @csrf
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="val-email">Customer Full Name <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="full_name" placeholder="Enter Full Name"
                                required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="val-password">Email Address <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="email" class="form-control" name="email_address"
                                placeholder="Enter Email Address" required>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="val-password">Mobile Number <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="number" class="form-control" name="mobile_number"
                                placeholder="Enter Mobile Number" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="val-suggestions">Customer Address <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <textarea class="form-control" name="address" rows="5" placeholder="Enter Address" required></textarea>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th><button type="button" id="add-product" class="btn btn-primary">Add Product</button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="product-group">
                                <tr id="product_id" class="item">
                                    <td>#1</td>
                                    <td>
                                        <select class="form-control capitalized select_product" name="select_product[]">
                                            <option value="" disabled selected>Select Product</option>
                                            <optgroup label="Products">
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" class="qnty amount form-control product_qty"
                                            name="product_qty[]" placeholder="Enter Quantity">
                                    </td>
                                    <td>
                                        <input type="number" class="price product_price form-control" readonly
                                            name="product_price[]" placeholder="">
                                    </td>
                                    <td><input class="form-control total" type="text" readonly required></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4">TOTAL</th>
                                    <th><input name="total_price" type="text" class="form-control" id="total_price"
                                            readonly required></th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                    <hr>
                    <div class="col-md-9">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Package</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th><button type="button" id="add-package" class="btn btn-primary">Add
                                            Package</button></th>
                                </tr>
                            </thead>
                            <tbody id="package-group">
                                <tr id="package_id">
                                    <td>#1</td>
                                    <td>
                                        <select class="form-control capitalized select_package" name="select_package[]">
                                            <option value="" selected disabled>Select Package</option>
                                            <optgroup label="Packages">
                                                @foreach ($packages as $package)
                                                    <option value="{{ $package->id }}">{{ $package->type }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" id="package_qty" name="package_qty[]"
                                            placeholder="Enter Quantity">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" readonly id="package_price"
                                            name="package_price[]" placeholder="">
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>

                        </table>
                    </div>





                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"></label>
                        <div class="col-lg-8">
                            <button type="submit" class="btn btn-primary" id="btn-shop">Proceed Shopping</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="profile-justified" role="tabpanel" aria-labelledby="profile-tab-justified">
                <form class="form-validate" action="#" method="post">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="val-username">Username <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="val-username" name="val-username"
                                placeholder="Enter User ID">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="val-email">Customer Full Name <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="val-email" name="val-email"
                                placeholder="Enter Full Name">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="val-password">Product <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control capitalaized" id="val-skill" name="val-skill">
                                <option value="">Please select</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="val-password">Quantity <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="number" class="form-control" id="val-password" name="val-password"
                                placeholder="Enter Quantity">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="val-password">Price <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="number" class="form-control" readonly id="val-password" name="val-password"
                                placeholder="">
                        </div>
                    </div>


                    <button type="button" class="btn btn-primary">Add Product</button>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"></label>
                        <div class="col-lg-8">
                            <button type="submit" class="btn btn-primary">Proceed Shopping</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="contact-justified" role="tabpanel" aria-labelledby="contact-tab-justified">
                <form class="form-validate" action="#" method="post">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="val-username">Username <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="val-username" name="val-username"
                                placeholder="Enter User ID">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="val-email">Full Name <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="val-email" name="val-email"
                                placeholder="Enter Email ID">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="val-password">Customer Name <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="password" class="form-control" id="val-password" name="val-password"
                                placeholder="Enter Customer Name">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="val-password">Email Address <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="password" class="form-control" id="val-password" name="val-password"
                                placeholder="Enter Email Address">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="val-suggestions">Customer Address <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <textarea class="form-control" id="val-suggestions" name="val-suggestions" rows="5"
                                placeholder="Enter Address"></textarea>
                        </div>
                    </div>




                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="val-currency">S.I. No. <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="val-currency" name="val-currency"
                                placeholder="Enter S.I. No.">
                        </div>
                    </div>



                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Product Redemption <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-8">
                            <label class="css-control css-control-primary css-checkbox" for="val-terms">
                                <input type="checkbox" class="css-control-input" id="val-terms" name="val-terms"
                                    value="1">
                                <span class="css-control-indicator"></span> Check if for Product Redemption
                            </label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="val-currency">Redemption Ref No. <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="val-currency" name="val-currency"
                                placeholder="Enter Redemption No.">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"></label>
                        <div class="col-lg-8">
                            <button type="submit" class="btn btn-primary">Proceed Shopping</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            /*$("#with-referral").hide();
            $('#referral-check').click(function() {
                if ($(this).is(':checked')) {
                    $("#with-referral").show();
                } else {
                    $("#with-referral").hide();
                }
            });*/


            var user_discount = .3;
            //$('body').on('click', '#btn-shop', function(event) {
            $('body').on('submit', '#newTransactionForm', function(event) {
                event.preventDefault();
                console.log('btn clicked');
                var formData = {
                    'full_name': $('input[name=full_name').val(),
                    'email_address': $('input[name=email_address').val(),
                    'mobile_number': $('input[name=mobile_number').val(),
                    'address': $('input[name=address').val(),

                    'select_product': $('input[name=select_product').val(),
                    'product_qty': $('input[name=product_qty').val(),
                    'product_price': $('input[name=product_price').val(),


                    'select_package': $('input[name=select_package').val(),
                    'package_qty': $('input[name=package_qty').val(),
                    'package_price': $('input[name=package_price').val(),
                    'token': token
                };
                //var action = 'new-transaction/insert';
                var url = "new-transaction/insert";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $('.send-loading').show();
                    },
                    success: function(response) {
                        console.log('Product submitting success...');
                        $('.send-loading').hide();
                        swal({
                            title: 'Success!',
                            text: 'Transaction Successfully',
                            timer: 1500,
                            type: "success",
                        }).then(
                            function() {},
                            function(dismiss) {
                                if (dismiss === 'timer') {
                                    window.location.href = 'new-transaction';
                                }
                            }
                        )

                    },
                    error: function(error) {
                        console.log('Product submitting error...');
                        console.log(error);
                        console.log(error.responseJSON.message);
                        $('.send-loading').hide();
                        swal({
                            title: 'Error!',
                            text: "Error Msg: " + error.responseJSON.message + "",
                            timer: 1500,
                            type: "error",
                        }).then(
                            function() {},
                            function(dismiss) {}
                        )

                    }
                });
            });

            var product_counter = 2;
            var package_counter = 2;

            $('body').on('change', '.select_product', function(event) {
                console.log('edit btn clicked');
                var id = $(this).val();
                var action = 'products/edit/' + id;
                var url = 'products/edit';
                var row = $(this).closest("tr");
                var tr_id = $(row).attr('id');


                $.ajax({
                    type: 'get',
                    url: url,
                    data: {
                        'id': id
                    },
                    beforeSend: function() {
                        $('.send-loading').show();
                    },
                    success: function(data) {
                        $('.send-loading').hide();
                        var type = data.type;
                        /*  if(type){
                              $('#product-price').val(data.amount);
                          } else {*/
                        //$('.product_price').val(data.price);
                        $('#' + tr_id).find('.price').val(data.price);
                        calcAll();
                    }
                });
            });



            $("#add-product").click(function() {

                if (product_counter > 10) {
                    alert("Only 10 textboxes allow");
                    return false;
                }

                var newTextBoxDiv = $(document.createElement('tr'))
                    .attr("id", 'product_id' + product_counter, "class", 'item').attr("class", 'item');
                newTextBoxDiv.after().html("<td>#" + product_counter + "</td><td>" +
                    "<select class='form-control capitalized select_product' name='select_product[]'>" +
                    "<option value=''>Please select</option>" +
                    " <optgroup label='Products'>" +
                    "@foreach ($products as $product)" +
                    "<option value='{{ $product->id }}'>{{ $product->name }}</option>" +
                    "@endforeach" +
                    "</optgroup>" +
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

                if (package_counter > 10) {
                    alert("Only 10 textboxes allow");
                    return false;
                }

                var newTextBoxDiv = $(document.createElement('tr'))
                    .attr("id", 'package_id' + package_counter);

                newTextBoxDiv.after().html("<td>#" + package_counter + "</td><td>" +
                    "<select class='form-control capitalized' name='select_package[]'>" +
                    "<option value=''>Please select</option>" +
                    "<optgroup label='Packages'>" +
                    "@foreach ($packages as $package)" +
                    "<option value='{{ $package->id }}'>{{ $package->type }}</option>" +
                    "@endforeach" +
                    "</optgroup>" +
                    "</select>" +
                    "</td>" +
                    "<td>" +
                    "<input type='number' class='form-control' name='package_qty[]' placeholder='Enter Quantity'>" +
                    "</td>" +
                    "<td>" +
                    "<input type='number' class='form-control' readonly name='package_price[]'>" +
                    "</td>" +
                    "<td><button type='button' class='btn btn-danger btn-xs remove-package' data-id='" +
                    package_counter + "'>x</button></td>" +
                    "</tr>");

                newTextBoxDiv.appendTo("#package-group");


                package_counter++;
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

            $('body').on('click', '.remove-package', function(event) {
                var id = $(this).data('id');
                console.log('remove package clicked ' + id);
                if (package_counter == 1) {
                    alert("No more textbox to remove");
                    return false;
                }

                package_counter--;

                $("#package_id" + id).remove();

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
            //$(document).on("keyup", ".amount", calcAll());
            // function for calculating everything

            function calcAll() {
                // calculate total for one row
                $(".item").each(function() {
                    console.log('Calculate item');
                    var qnty = 0;
                    var price = 0;
                    //var hours = 1;
                    var total = 0;
                    if (!isNaN(parseFloat($(this).find(".qnty").val()))) {
                        qnty = parseFloat($(this).find(".qnty").val());
                    }
                    if (!isNaN(parseFloat($(this).find(".price").val()))) {
                        price = parseFloat($(this).find(".price").val());
                    }
                    /*if (!isNaN(parseFloat($(this).find(".hours").val()))) {
                    	hours = parseFloat($(this).find(".hours").val());
                    }*/
                    //total = qnty * price * hours;
                    total = qnty * price;
                    //discount = total * user_discount;
                    //discounted = total - discount;
                    $(this).find(".total").val(total.toFixed(2));
                    //$(this).find(".discount").val(discount.toFixed(2));
                    //$(this).find(".discounted_total").val(discounted.toFixed(2));
                    //$(".price").val(price.toFixed(2));
                });

                // sum all totals
                var sum = 0;
                $(".total").each(function() {
                    if (!isNaN(this.value) && this.value.length != 0) {
                        sum += parseFloat(this.value);
                    }
                });

                $("#total_price").val(sum.toFixed(2));
                //$("#total_discount").val(sum.toFixed(2) * parseFloat(user_discount));
                //$("#discounted_total").val(sum.toFixed(2) - parseFloat($("#total_discount").val()));
            }

        });
    </script>
@endsection
