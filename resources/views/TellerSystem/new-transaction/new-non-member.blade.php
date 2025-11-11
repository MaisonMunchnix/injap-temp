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
                                                <h5 class="element-inner-header">Walk In / Non Member</h5>
                                                <div class="element-inner-desc">Please fill out all information needed.<br /><br />
                                                </div>
                                            </div>
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
                                                            <option value="" selected disabled>Select Package</option>
                                                            @foreach($packages as $package)
                                                            <option value="{{ $package->id }}">{{ $package->name }}</option>
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
                                            <tfoot>
                                                <tr style="background:linear-gradient(-90deg, var(--theme) 0%, var(--theme) 100%) !important; color:white;">
                                                    <th colspan="4">TOTAL</th>
                                                    <th><input name="total_price" type="text" class="form-control total_price" readonly required></th>
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
    $(document).ready(function() {
        var token = "{{csrf_token()}}";
        
        $('body').on('submit', '#formValidate', function(event) {
            event.preventDefault();
            console.log('btn clicked');
            var product = $('input[name=select_product').val();
            var product_qty = $('input[name=product_qty').val();
            var product_price = $('input[name=product_price').val();
            var package = $('input[name=select_package').val();
            var package_qty = $('input[name=package_qty').val();
            var package_price = $('input[name=package_price').val();
            var total_price = $('input[name=total_price').val();
            var url = "{{ route('new-transaction-insert') }}";

            var formData = {
                'select_product': product,
                'product_qty': product_qty,
                'product_price': product_price,
                'total_price': total_price,
                'select_package': package,
                'package_qty': package_qty,
                'package_price': package_price,
                'token': token
            };
            
            if (!$('.select_product').val() && !$('.select_package').val()) {
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
                        //window.location.href = '../view-receipt/' + transaction_id;
                        window.location.href = "{{route('teller-dashboard')}}";

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

        var package_counter = 2;

        //New Packages
        $('body').on('change', '.select_package', function(event) {

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
                        $('#' + tr_id).find('.price').val(data.price)
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


        $("#add-package").click(function() {
            if (package_counter > 20) {
                alert("Only 20 textboxes allow");
                return false;
            }
            var newTextBoxDiv = $(document.createElement('tr'))
                .attr("id", 'package_id' + package_counter, "class", 'item').attr("class", 'item');
            newTextBoxDiv.after().html("<td>#" + package_counter + "</td><td>" +
                "<select class='form-control capitalized select_package' name='select_package[]'>" +
                "<option value='' selected disabled>Select Package</option>" +
                "@foreach($packages as $package)" +
                "<option value='{{ $package->id }}'>{{ $package->name }}</option>" +
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

        $('body').on('keyup', '.amount', function() {
            calcAll();
            console.log('Calculate function');
        });

        function calcAll() {
            // calculate total for one row
            $(".item").each(function() {
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

</script>
@endsection
