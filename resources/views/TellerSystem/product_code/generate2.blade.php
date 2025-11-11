@extends('layouts.teller.master')
@section('title', 'Generate Product Code')


@section('stylesheets')
<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    .leader {
        background-color: #e74c3c;
        color: #ecf0f1;
    }

    .leader input[type="number"] {
        background-color: #ecf0f1;
        color: #c0392b;
    }

    .premium {
        background-color: #3498db;
        color: #ecf0f1;
    }

    .premium input[type="number"] {
        background-color: #ecf0f1;
        color: #2980b9;
    }


    .elite {
        background-color: #2ecc71;
        color: #ecf0f1;
    }

    .elite input[type="number"] {
        background-color: #ecf0f1;
        color: #27ae60;
    }

    .margin-bottom {
        margin-bottom: 20px;
    }

    .title {
        text-transform: capitalize;
    }

    tfoot {
        background-color: #123088;
        color: #ecf0f1;
    }

    .swal2-container.swal2-backdrop-show {
        background-color: #123088 !important;
    }

    .capitalized {
        text-transform: capitalize;
    }

</style>
@endsection

@section('breadcrumbs')
<div class="row align-items-center">
	<div class="col-md-8 col-lg-8">
		<h3 class="page-title">@yield('title')</h3>
		<div class="breadcrumb-list">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{!! url('teller-admin/'); !!}">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
			</ol>
		</div>
	</div>
	<!--<div class="col-md-4 col-lg-4">
		<div class="widgetbar">
			<button class="btn btn-primary" data-toggle="modal" data-target="#add-modal"><i class='feather icon-plus'></i> Inventory</button>
		</div>
	</div>-->
</div>
@endsection

@section('contents')
<div class="col-lg-12 card-body">
    <div class="row margin-bottom">
        <div class="col-md-12">
           <!-- <div class="row">
                <div class="col-md-12">
                    <h3>Generate Product Code</h3>
                </div>
            </div>-->
            <form method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <select class="form-control select2 select2-dropdown" name="username" id="username" required style="width:100% !important;">
                                <option value="" disabled selected> Select Username</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive border-bottom">
                    <table class="table order-list mb-0 thead-border-top-0">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th>Discount</th>
                                <th>Discounted Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="item">
                                <th class="title">
                                    <select class="form-control capitalized" name="package_name">
                                        <option value="" selected disabled>Select Package</option>
                                        @foreach($packages as $package)
                                        <option value="{{ $package->id }}" class="capitalized">{{ $package->type }}</option>
                                        @endforeach
                                    </select>
                                </th>
                                <td><input type="number" id="_qty" name="_qty" class="qnty amount form-control" autocomplete="off"></td>
                                <td><input type="number" id="_price" name="_price" class="price form-control" value="" readonly></td>
                                <td><input type="number" id="_total_price" name="_total_price" class="total form-control" readonly="readonly"></td>
                                <td><input type="number" id="_discount" name="_discount" class="discount form-control" readonly></td>
                                <td><input type="number" id="_discounted_total" name="_discounted_total" class="discounted_total form-control" readonly="readonly"></td>
                            </tr>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">TOTAL</th>
                                <th><input name="total_price" type="text" class="form-control" id="total_price" readonly required></th>
                                <th><input name="total_discount" type="text" class="form-control" id="total_discount" readonly required></th>
                                <th><input name="discounted_total" type="text" class="form-control" id="discounted_total" readonly required></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>

                    <button type="button" class="btn btn-primary float-right" name="print" id="generate_button" style="margin-top:20px;"><i class="material-icons">add</i> Submit</button>
                </div>
            </form>
            <input type="button" class="btn btn-lg btn-block " id="addrow" value="Add Row" />
            @if ($product_codes = Session::get('product_codes'))
            <h3>Generated Results</h3>
            <table class="table mb-0 thead-border-top-0" id="generated_codes_table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Code</th>
                        <th>Security Pin</th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach($product_codes AS $product_code)
                    <tr>
                        <td class="capitalized">{{ $product_code->type }}</td>
                        <td>{{ $product_code->code }}</td>
                        <td>{{ $product_code->security_pin }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>
@endsection


@section('scripts')

<script>
    //Search Username
    $(document).ready(function() {
        $('#username').select2({
            minimumInputLength: 3,
            ajax: {
                url: '{{ route("api.users.search") }}',
                dataType: 'json',
            },
        });

        $(document).ready(function() {
            $('#generated_codes_table').DataTable();
        });

        var counter = 0;

        //$("#addrow").on("click", function() {
        $("#addrow").click(function() {
            var newRow = $("<tr>");
            var cols = "";

            cols += '<th class="title"><select class="form-control capitalized" name="package_name"><option value="" selected disabled>Select Package</option>@foreach($packages as $package)<option value="{{ $package->id }}" class="capitalized">{{ $package->type }}</option>@endforeach</select></th>';
            cols += '<td><input type="number" id="_qty" name="_qty" class="qnty amount form-control" autocomplete="off"></td>';
            cols += '<td><input type="number" id="_price" name="_price" class="price form-control" value="10" readonly></td>';
            cols += '<td><input type="number" id="_total_price" name="_total_price" class="total form-control" readonly="readonly"></td>';
            cols += '<td><input type="number" id="_discount" name="_discount" class="discount form-control" readonly></td>';
            cols += '<td><input type="number" id="_discounted_total" name="}_discounted_total" class="discounted_total form-control" readonly="readonly"></td>';

            cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
            newRow.append(cols);
            $("table.order-list").append(newRow);
            counter++;
        });

        $("table.order-list").on("click", ".ibtnDel", function(event) {
            $(this).closest("tr").remove();
            counter -= 1
        });
    });

    var user_discount = .3;
    // main function when page is opened
    $(document).ready(function() {
        // calculate everything
        $(document).on("keyup", ".amount", calcAll);
    });

    // function for calculating everything
    function calcAll() {
        // calculate total for one row
        $(".item").each(function() {
            var qnty = 0;
            //var price = 0;
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
            discount = total * user_discount;
            discounted = total - discount;
            $(this).find(".total").val(total.toFixed(2));
            $(this).find(".discount").val(discount.toFixed(2));
            $(this).find(".discounted_total").val(discounted.toFixed(2));
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
        $("#total_discount").val(sum.toFixed(2) * parseFloat(user_discount));
        $("#discounted_total").val(sum.toFixed(2) - parseFloat($("#total_discount").val()));
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token
        }

    });

    //Submit Form
    $("#generate_button").click(function(e) {
        e.preventDefault();
        var username = $("#username").val();
        var icon = '';
        var title = '';

        var total_price = $("#total_price").val();
        var total_discount = $("#total_discount").val();
        var discounted_total = $("#discounted_total").val();


        //Sample
        var name = $("input[name=name]").val();
        var password = $("input[name=password]").val();
        var email = $("input[name=email]").val();

        if (!username) {
            icon = 'error';
            title = 'Username is required!';
            swal("Failed!", title, icon)
            $(".select2-container").css("border", "1px solid red");
        } else if (total_price == "") {
            $(".select2-container").css("border", "");
            $("#total_price").css("border", "1px solid red");
            icon = 'error';
            title = 'Total Price is required!';
            swal("Failed!", title, icon)
        } else if (total_discount == "") {
            $("#total_discount").css("border", "1px solid red");
            icon = 'error';
            title = 'Total Discount is required!';
            swal("Failed!", title, icon)
        } else if (discounted_total == "") {
            $("#discounted_total").css("border", "1px solid red");
            icon = 'error';
            title = 'Discounted Total is required!';
            swal("Failed!", title, icon)
        } else {
            $.ajax({
                type: 'POST',
                url: '{{ route("generate-insert-code") }}',

                data: {
                    username: username
                },
                success: function(data) {
                    icon = 'success';
                    swal("Success", data.success, icon)
                    setInterval('refreshPage()', 1000);
                }
            });
        }
    });

    function refreshPage() {
        location.reload(true);
    }

</script>
@endsection
