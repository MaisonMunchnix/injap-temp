@extends('layouts.user.master')
@section('title', 'Orders Detail')
@section('page-title', 'Add Branch')

@section('stylesheets')
    {{-- additional style here --}}
    <!-- swal -->
    <link rel="stylesheet" type="text/css" href="css/sweetalert.css">
    <style>
        .border-red {
            border: 1px solid red !important;
        }
    </style>
@endsection

@section('content')
    <div class="content-i">
        <!-- start content- -->
        <div class="content-box">
            <div class="row">
                <div class="col-sm-12">
                    <div class="element-wrapper">
                        <h6 class="element-header">@yield('title')</h6>
                        <br><br>
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="element-wrapper">
                                <div class="element-box">
                                    <table class="table table-borderless" style="width:100%" id="process-order">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Invoice</th>
                                                <th>Name</th>
                                                <th>Date</th>
                                                <th>Total</th>
                                                <th>Warehouse</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">#o2599</th>
                                                <td>11</td>
                                                <td>Amy Adams</td>
                                                <td>02/06/2019</td>
                                                <td>$1,95,000</td>
                                                <td>Boston</td>
                                                <td><span class="badge badge-primary-inverse">Processing</span></td>
                                                <td>
                                                    <div class="button-list">

                                                        <a href="order-detail.html" class="btn btn-success-rgba"><i
                                                                class="feather icon-edit-2"></i></a>
                                                        <a href="page-order-detail.html" class="btn btn-danger-rgba"><i
                                                                class="feather icon-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">#o2600</th>
                                                <td>12</td>
                                                <td>Shiva Radharaman</td>
                                                <td>01/06/2019</td>
                                                <td>$85,000</td>
                                                <td>Washington DC</td>
                                                <td><span class="badge badge-secondary-inverse">Shipped</span></td>
                                                <td>
                                                    <div class="button-list">

                                                        <a href="order-detail.html" class="btn btn-success-rgba"><i
                                                                class="feather icon-edit-2"></i></a>
                                                        <a href="page-order-detail.html" class="btn btn-danger-rgba"><i
                                                                class="feather icon-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">#o2601</th>
                                                <td>13</td>
                                                <td>Ryan Smith</td>
                                                <td>28/05/2019</td>
                                                <td>$70,000</td>
                                                <td>San Francisco</td>
                                                <td><span class="badge badge-success-inverse">Completed</span></td>
                                                <td>
                                                    <div class="button-list">

                                                        <a href="order-detail.html" class="btn btn-success-rgba"><i
                                                                class="feather icon-edit-2"></i></a>
                                                        <a href="page-order-detail.html" class="btn btn-danger-rgba"><i
                                                                class="feather icon-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">#o2602</th>
                                                <td>14</td>
                                                <td>James Witherspon</td>
                                                <td>21/05/2019</td>
                                                <td>$1,25,000</td>
                                                <td>Las Vegas</td>
                                                <td><span class="badge badge-warning-inverse">Refunded</span></td>
                                                <td>
                                                    <div class="button-list">

                                                        <a href="order-detail.html" class="btn btn-success-rgba"><i
                                                                class="feather icon-edit-2"></i></a>
                                                        <a href="page-order-detail.html" class="btn btn-danger-rgba"><i
                                                                class="feather icon-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">#o2603</th>
                                                <td>15</td>
                                                <td>Courney Berry</td>
                                                <td>17/05/2019</td>
                                                <td>$1,30,000</td>
                                                <td>Los Angeles</td>
                                                <td><span class="badge badge-danger-inverse">Cancelled</span></td>
                                                <td>
                                                    <div class="button-list">

                                                        <a href="order-detail.html" class="btn btn-success-rgba"><i
                                                                class="feather icon-edit-2"></i></a>
                                                        <a href="page-order-detail.html" class="btn btn-danger-rgba"><i
                                                                class="feather icon-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">#o2604</th>
                                                <td>16</td>
                                                <td>Lisa Perry</td>
                                                <td>12/05/2019</td>
                                                <td>$1,50,000</td>
                                                <td>Chicago</td>
                                                <td><span class="badge badge-info-inverse">Delivered</span></td>
                                                <td>
                                                    <div class="button-list">

                                                        <a href="page-order-detail.html" class="btn btn-success-rgba"><i
                                                                class="feather icon-edit-2"></i></a>
                                                        <a href="page-order-detail.html" class="btn btn-danger-rgba"><i
                                                                class="feather icon-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">#o2605</th>
                                                <td>17</td>
                                                <td>John Doe</td>
                                                <td>01/05/2019</td>
                                                <td>$5,000</td>
                                                <td>New York</td>
                                                <td><span class="badge badge-success-inverse">Completed</span></td>
                                                <td>
                                                    <div class="button-list">

                                                        <a href="order-detail.html" class="btn btn-success-rgba"><i
                                                                class="feather icon-edit-2"></i></a>
                                                        <a href="page-order-detail.html" class="btn btn-danger-rgba"><i
                                                                class="feather icon-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('user.customizer')
    </div>
    </div>
    <!-- end content-i -->
@endsection

@section('scripts')
    {{-- additional scripts here --}}
    <script>
        var token = "{{ csrf_token() }}";
        console.log('TOKEN:' + token);
    </script>
    <!-- Sweetalert -->
    <!--<script src="js/sweetalert.min.js"></script>-->
    <script>
        $(document).ready(function() {
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
                var url = "../new-transaction/insert";
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
                                    window.location.href = 'non-member';
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

                //console.log('edit btn clicked');

                var id = $(this).val();

                var dis = $(this);
                var row = $(this).closest("tr");
                var tr_id = $(row).attr('id');
                var action = '../products/edit/' + id;
                var url = '../products/edit';
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
                        /*  if(type){
                              $('#product-price').val(data.amount);
                          } else {*/
                        //$('.product_price').val(data.price);
                        $('#' + tr_id).find('.price').val(data.price)
                        calcAll();
                    }
                });
            });

            $('body').on('change', '.select_package', function(event) {

                //console.log('edit btn clicked');

                var id = $(this).val();

                var dis = $(this);
                var row = $(this).closest("tr");
                var tr_id = $(row).attr('id');
                var action = '../packages/edit/' + id;
                var url = '../packages/edit';
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
                        /*  if(type){
                              $('#product-price').val(data.amount);
                          } else {*/
                        //$('.product_price').val(data.price);
                        $('#' + tr_id).find('.price').val(data.amount)
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
                    .attr("id", 'package_id' + package_counter, "class", 'item').attr("class", 'item');

                newTextBoxDiv.after().html("<td>#" + package_counter + "</td><td>" +
                    "<select class='form-control capitalized select_package' name='select_package[]'>" +
                    "<option value=''>Please select</option>" +
                    "<optgroup label='Packages'>" +
                    "@foreach ($packages as $package)" +
                    "<option value='{{ $package->id }}'>{{ $package->type }}</option>" +
                    "@endforeach" +
                    "</optgroup>" +
                    "</select>" +
                    "</td>" +
                    "<td>" +
                    "<input type='number' class='qnty amount package_qty form-control' name='package_qty[]' placeholder='Enter Quantity'>" +
                    "</td>" +
                    "<td>" +
                    "<input type='number' class='price package_price form-control' readonly name='package_price[]'>" +
                    "</td>" +
                    "<td><input class='form-control total' type='text' readonly required></td>" +
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

                $(".total_price").val(sum.toFixed(2));
                //$("#total_discount").val(sum.toFixed(2) * parseFloat(user_discount));
                //$("#discounted_total").val(sum.toFixed(2) - parseFloat($("#total_discount").val()));
            }

        });
    </script>
@endsection
