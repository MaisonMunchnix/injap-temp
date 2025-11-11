@extends('layouts.default.teller.master')
@section('title','New Transaction')
@section('page-title','New Transaction')

@section('stylesheets')
{{-- additional style here --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .border-red {
        border: 1px solid red !important;
    }

    .first {
        width: 5% !important;
    }

    .others {
        width: 19% !important;
    }

</style>
@endsection

@section('content')
<div class="content-body">
    <!-- start content- -->
    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="">
                    <h6 class="element-header">@yield('title')</h6>
                    <br><br>
                    <div class="col-sm-8 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="formValidate" action="" method="post">
                                    @csrf
                                    <div class="element-info">
                                        <div class="element-info-with-icon">
                                            <div class="element-info-icon">
                                                <div class="os-icon os-icon-user"></div>
                                            </div>
                                            <div class="element-info-text">
                                                <h5 class="element-inner-header">Walk In / Member</h5>
                                                <div class="element-inner-desc">Please fill out all information needed.<br /><br />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2">
                                            <label for="username">Select Username</label>
                                        </div>
                                        <div class="col-md-10">
                                            <select name="username" id="username" required>
                                                <option value="">Select Username</option>
                                            </select>
                                        </div>
                                    </div>

                                    <fieldset class="form-group">
                                        <legend><span>Package Information</span></legend>
                                        <table class="table" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="first">#</th>
                                                    <th class="others">Package</th>
                                                    <th class="others">Quantity</th>
                                                    <th class="others">Price</th>
                                                    <th class="others">Total</th>
                                                    <th class="others"><button type="button" id="add-package" class="btn btn-primary">+ Package</button></th>
                                                </tr>
                                            </thead>
                                            <tbody id="package-group">
                                                <tr id="package_id1" class="item">
                                                    <td>#1</td>
                                                    <td>
                                                        <select class="form-control capitalized select_package" name="select_package[]">
                                                            <option selected disabled>Select Package</option>
                                                            @foreach($packages as $package)
                                                            <option value="{{ $package->id }}">{{ $package->type }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>

                                                    <td>
                                                        <input type="number" class="qnty amount form-control package_qty" name="package_qty[]" placeholder="Enter Quantity">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="price package_price form-control" readonly name="package_price[]" placeholder="">
                                                    </td>
                                                    <td><input class="form-control total" type="text" readonly required></td>
                                                    <td><button type='button' class='btn btn-danger btn-xs remove-package' data-id='1'>x</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </fieldset>
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
                                                        <button type="button" id="add-product" class="btn btn-primary">+ Product</button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="product-group">
                                                <tr id="product_id1" class="item">
                                                    <td>#1</td>
                                                    <td>
                                                        <select class="form-control capitalized select_product" name="select_product[]">
                                                            <option disabled selected>Select Product</option>
                                                            @foreach($products as $product)
                                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <!-- <td><input type="number" class="stocks form-control" name="stocks" placeholder="Available Stocks" readonly></td> -->
                                                    <td>
                                                        <input type="number" class="qnty amount form-control product_qty" name="product_qty[]" placeholder="Enter Quantity">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="price product_price form-control" readonly name="product_price[]" placeholder="">
                                                    </td>
                                                    <td><input class="form-control total" type="text" readonly required></td>
                                                    <td><button type='button' class='btn btn-danger btn-xs remove-product' data-id='1'>x</button></td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                            <tr style="background:linear-gradient(-90deg, var(--theme) 0%, var(--theme) 100%) !important; color:white;">
                                                <th colspan="4">TOTAL</th>
                                                <th colspan="1"><input name="total_price" type="text" class="form-control total_price" readonly required></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                        </table>
                                    </fieldset>

                                    <div class="form-buttons-w">
                                        <button class="btn btn-primary pull-right" type="submit"> Proceed Shopping</button>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    var token = "{{csrf_token()}}";

</script>

<script>
    $(document).ready(function() {
        $('#username').select2({
            ajax: {
                url: "{{ route('select-member') }}",
                processResults: function(data) {
                    return {
                        results: data.results
                    };
                }
            }
        });



        $('body').on('change', '#username', function(event) {
            $('.select_product').val('Select Product').selectedIndex = 0;
            $('.select_package').val('Select Package').selectedIndex = 0;
        });

        $('body').on('submit', '#formValidate', function(event) {
            event.preventDefault();
            console.log('btn clicked');
            var username = $("#username").val();
            var product = $('input[name=select_product').val();
            var product_qty = $('input[name=product_qty').val();
            var product_price = $('input[name=product_price').val();

            var package = $('input[name=select_package').val();
            var package_qty = $('input[name=package_qty').val();
            var package_price = $('input[name=package_price').val();
            var total_price = $('input[name=total_price').val();

            var formData = {
                'username': username,
                'select_product': product,
                'product_qty': product_qty,
                'product_price': product_price,
                'total_price': total_price,

                'select_package': package,
                'package_qty': package_qty,
                'package_price': package_price,
                'token': token
            };
            var url = "../new-transaction/insert";

            if (!username) {
                icon = 'error';
                title = 'Username is required!';
                swal("Failed!", title, icon)
                $(".select2-container").css("border", "1px solid red");
            } else if (!$('.select_product').val() && !$('.select_package').val()) {
                swal({
                    title: 'Error!',
                    text: "No Product or Package Selected!",
                    timer: 2000,
                    type: "error",
                })
            } else {
                $.ajax({
                    url: url,
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
            var username = $("select#username").val() || "";
            if (username != "") {
                var id = $(this).val();

                var dis = $(this);
                var row = $(this).closest("tr");
                var tr_id = $(row).attr('id');
                $.ajax({
                    type: 'post',
                    url: "{{ route('product-transaction') }}",
                    data: {
                        id: id,
                        _token: token,
                    },
                    beforeSend: function() {
                        $('.preloader').show();
                    },
                    success: function(data) {
                        $('.preloader').hide();
                        $('#' + tr_id).find('.price').val(data.price);
                        calcAll();
                    }
                });
            } else {
                $(this).val('Select Product').selectedIndex = 0;
                swal({
                    title: 'Error!',
                    text: "Please Select Username first!",
                    timer: 1000,
                    type: "error",
                })

            }
        });


        //New Packages
        $('body').on('change', '.select_package', function(event) {
            var username = $("select#username").val() || "";

            if (username != "") {
                var id = $(this).val();
                var dis = $(this);
                var row = $(this).closest("tr");
                var tr_id = $(row).attr('id');
                $.ajax({
                    type: 'post',
                    url: "{{ route('package-transaction') }}",
                    data: {
                        id: id,
                        _token: token,
                    },
                    beforeSend: function() {
                        $('.preloader').show();
                    },
                    success: function(data) {
                        $('.preloader').hide();
                        $('#' + tr_id).find('.price').val(data.price)
                        calcAll();
                    }
                });
            } else {
                $(this).val('Select Package').selectedIndex = 0;
                swal({
                    title: 'Error!',
                    text: "Please Select Username first!",
                    timer: 1500,
                    type: "error",
                })

            }
        });


        $("#add-package").click(function() {
            if (package_counter > 20) {
                alert("Only 20 textboxes allow");
                return false;
            }

            var newTextBoxDiv = $(document.createElement('tr'))
                .attr("id", 'package_id' + package_counter, "class", 'item').attr("class", 'item');

            newTextBoxDiv.after().html("<td>#" + package_counter + "</td><td>" +
                "<select class='form-control capitalized select_package' name='select_package[]'>" +
                "<option selected disabled>Select Package</option>" +
                "@foreach($packages as $package)" +
                "<option value='{{ $package->id }}'>{{ $package->type }}</option>" +
                "@endforeach" +
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
        
        $("#add-product").click(function() {
            if (product_counter > 20) {
                alert("Only 20 textboxes allow");
                return false;
            }

            var newTextBoxDiv = $(document.createElement('tr'))
                .attr("id", 'product_id' + product_counter, "class", 'item').attr("class", 'item');

            newTextBoxDiv.after().html("<td>#" + product_counter + "</td><td>" +
                "<select class='form-control capitalized select_product' name='select_product[]'>" +
                "<option selected disabled>Select Product</option>" +
                "@foreach($products as $product)" +
                "<option value='{{ $product->id }}'>{{ $product->name }}</option>" +
                "@endforeach" +
                "</select>" +
                "</td>" +
                "<td>" +
                "<input type='number' class='qnty amount product_qty form-control' name='product_qty[]' placeholder='Enter Quantity'>" +
                "</td>" +
                "<td>" +
                "<input type='number' class='price product_price form-control' readonly name='product_price[]'>" +
                "</td>" +
                "<td><input class='form-control total' type='text' readonly required></td>" +
                "<td><button type='button' class='btn btn-danger btn-xs remove-product' data-id='" +
                product_counter + "'>x</button></td>" +
                "</tr>");
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
            calcAll();

        });

        $('body').on('click', '.remove-package', function(event) {
            var id = $(this).data('id');
            console.log('remove package clicked ' + id);
            if (package_counter == 0) {
                alert("No more textbox to remove");
                return false;
            }
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
        });

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

</script>
@endsection
