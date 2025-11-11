@extends('layouts.user.master')
@section('title', 'Packages Dev | Purple Life')
@section('page-title', 'Package Dev List')

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
    <div class="content-i">
        <!-- start content- -->
        <div class="content-box">
            <div class="element-wrapper">
                <!-- <h6 class="element-header">Data Tables</h6> -->
                <div class="element-box">
                    <h5 class="form-header text-center">@yield('page-title')</h5>
                    @if (empty($access_data))
                        <a class="add-task-btn pull-right" data-target="#add-modal" data-toggle="modal" href="#"><i
                                class="os-icon os-icon-ui-22"></i><span>Add Package</span></a>
                    @else
                        @if ($access_data[0]->package[0]->add == 'true')
                            <a class="add-task-btn pull-right" data-target="#add-modal" data-toggle="modal"
                                href="#"><i class="os-icon os-icon-ui-22"></i><span>Add Package</span></a>
                        @else
                            <a class="add-task-btn pull-right" data-target="" data-toggle="modal" href="#"><i
                                    class="os-icon os-icon-ui-22"></i><span>Add Package</span></a>
                        @endif
                    @endif

                    <div class="form-desc text-center"></div>
                    <div class="table-responsive">
                        <table id="products_table" width="100%" class="table table-striped table-lightfont">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Referral Amount</th>
                                    <th>Points</th>
                                    <th>Discount</th>
                                    <th>Date</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Referral Amount</th>
                                    <th>Points</th>
                                    <th>Discount</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if (!empty($packages))
                                    @foreach ($packages as $package)
                                        <tr class="text-capitalize">
                                            <td>{{ $package->type }}</td>
                                            <td>{{ $package->amount }}</td>
                                            <td>{{ $package->referral_amount }}</td>
                                            <td>{{ $package->pv_points }}</td>
                                            <td>{{ $package->account_discount * 100 }}%</td>
                                            <td>{{ $package->created_at }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                                        data-toggle="dropdown">Action </button>
                                                    <div class="dropdown-menu">
                                                        <a href="#" class="dropdown-item btn-view"
                                                            data-id="{{ $package->id }}">View</a>

                                                        @if (empty($access_data))
                                                            <a href="#" class="dropdown-item btn-edit"
                                                                data-id="{{ $package->id }}">Edit</a>
                                                        @else
                                                            @if ($access_data[0]->package[0]->edit == 'true')
                                                                <a href="#" class="dropdown-item btn-edit"
                                                                    data-id="{{ $package->id }}">Edit</a>
                                                            @else
                                                            @endif
                                                        @endif

                                                        @if (empty($access_data))
                                                            <a href="#" class="dropdown-item btn-delete"
                                                                data-id="{{ $package->id }}">Delete</a>
                                                        @else
                                                            @if ($access_data[0]->package[0]->delete == 'true')
                                                                <a href="#" class="dropdown-item btn-delete"
                                                                    data-id="{{ $package->id }}">Delete</a>
                                                            @else
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @include('user.customizer')
            @include('admin.packages-dev.view_modal')
            @include('admin.packages-dev.edit_modal')
            @include('admin.packages-dev.add_modal')
            @include('admin.packages-dev.add_product_modal')
            @include('admin.packages-dev.delete_modal')
        </div>
    </div>
    <!-- end content-i -->
@endsection

@section('scripts')
    {{-- additional scripts here --}}
    <!-- Sweetalert -->
    {{-- <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script> --}}

    <script src="{{ asset('js/admin/packages-dev.js') }}"></script>
    <script>
        $(document).ready(function() {
            var product_counter = 1;


            $("#edit_add-product").click(function() {
                if (product_counter > 20) {
                    alert("Only 20 Product/s allowed");
                    return false;
                }

                var newTextBoxDiv = $(document.createElement('tr')).attr("id", 'product_id' +
                    product_counter, "class", 'item').attr("class", 'item');
                newTextBoxDiv.after().html("<td>" +
                    "<select class='form-control capitalized select_product edit_req_fields' name='select_product[]'>" +
                    "<option value='' selected disabled>Please select</option>" +
                    " <optgroup label='Products'>" +
                    "@foreach ($products as $product)" +
                    "<option value='{{ $product->id }}'>{{ $product->name }}</option>" +
                    "@endforeach" +
                    "</optgroup>" +
                    "</select>" +
                    "</td>" +
                    "<td>" +
                    "<input type='number' class='form-control qnty amount edit_req_fields' name='product_qty[]' placeholder='Enter Quantity' requied>" +
                    "</td>" +
                    "<td><button type='button' class='btn btn-danger btn-xs remove-product' data-id='" +
                    product_counter + "'>x</button></td>" +
                    "</tr>");

                newTextBoxDiv.appendTo("#edit_product-group");


                product_counter++;
            });

            $("#add-product").click(function() {
                if (product_counter > 20) {
                    alert("Only 20 Product/s allowed");
                    return false;
                }

                var newTextBoxDiv = $(document.createElement('tr')).attr("id", 'product_id' +
                    product_counter, "class", 'item').attr("class", 'item');
                newTextBoxDiv.after().html("<td>" +
                    "<select class='form-control capitalized select_product req_fields' name='select_product[]'>" +
                    "<option value='' selected disabled>Please select</option>" +
                    " <optgroup label='Products'>" +
                    "@foreach ($products as $product)" +
                    "<option value='{{ $product->id }}'>{{ $product->name }}</option>" +
                    "@endforeach" +
                    "</optgroup>" +
                    "</select>" +
                    "</td>" +
                    "<td>" +
                    "<input type='number' class='form-control qnty amount req_fields' name='product_qty[]' placeholder='Enter Quantity' requied>" +
                    "</td>" +
                    "<td><button type='button' class='btn btn-danger btn-xs remove-product' data-id='" +
                    product_counter + "'>x</button></td>" +
                    "</tr>");

                newTextBoxDiv.appendTo("#product-group");


                product_counter++;
            });

            function addRows() {

            }

            $('body').on('click', '.btn-edit', function() {
                var id = $(this).data('id');
                $("#classFormUpdate").trigger('reset');
                $('#edit_product-img').val('');
                $("#edit_product-group").empty();
                $.ajax({
                    url: 'edit-package/' + id,
                    type: 'GET',
                    beforeSend: function() {
                        console.log('Getting data...');
                        $('.send-loading').show();
                        $('#product-group').empty()
                    },
                    success: function(data) {
                        console.log('Success...');
                        $('.send-loading').hide();

                        $('#edit_id').val(data.package.id);
                        $('#edit_type').val(data.package.type);
                        $('#edit_amount').val(data.package.amount);
                        $('#edit_referral_amount').val(data.package.referral_amount);
                        $('#edit_pv_points').val(data.package.pv_points);

                        $('#edit_account_discount').val(Math.floor((data.package
                            .account_discount * 100.00)));
                        $('#addModal-product').attr('data-id', data.package.id);
                        $.each(data.package_product, function(i, value) {
                            var row = $(this).closest(".item");
                            var tr_id = $(row).attr('id');

                            var product_counter2 = 0;

                            var newTextBoxDiv = $(document.createElement('tr')).attr(
                                "id", 'product_id' + [i + 1], "class", 'item').attr(
                                "class", 'item');
                            newTextBoxDiv.after().html("<td>" +
                                "<select class='form-control capitalized select_product edit_req_fields' id='pr" +
                                [i] + "' name='select_product[]' disabled>" +
                                "<option value=''>Please select</option>" +
                                "@foreach ($products as $product)" +
                                "<option value='{{ $product->id }}'>{{ $product->name }}</option>" +
                                "@endforeach" +
                                "</select>" +
                                "</td>" +
                                "<td>" +
                                "<input type='number' class='form-control qnty amount edit_req_fields' name='product_qty[]' value='" +
                                value.quantity +
                                "' placeholder='Enter Quantity' required readonly>" +
                                "</td>" +
                                "<td>" +
                                "<button type='button' class='btn btn-danger btn-xs removeModal-product' data-id='" +
                                [i + 1] + "'>x</button> " +
                                "<button type='button' class='btn btn-primary btn-xs addModal-product' data-id='" +
                                data.package.id + "'>+</button>" +
                                "</td>" +
                                "</tr>");
                            newTextBoxDiv.appendTo("#edit_product-group");
                            $('#pr' + [i]).find('option[value="' + value.product_id +
                                '"]').attr('selected', 'selected');

                        });
                        $('#edit-modal').modal('show');

                    },
                    error: function(error) {
                        console.log('Error...');
                        console.log(error);
                        console.log(error.responseJSON.message);
                        $('.send-loading').hide();
                        swal({
                            title: "Error!",
                            text: "Error message: " + error.responseJSON.message + "",
                            type: "error",
                        });
                    }
                });
            });

            $('body').on('click', '#addModal-product', function() {
                var id = $(this).data('id');
                $("#classFormUpdate").trigger('reset');
                $('#add_package_id').val(id);
                $('#add-product-modal').modal('show');
            });

            $('body').on('click', '.btn-view', function() {
                var id = $(this).data('id');
                $("#classFormUpdate").trigger('reset');
                $('#edit_product-img').val('');
                $.ajax({
                    url: 'edit-package/' + id,
                    type: 'GET',
                    beforeSend: function() {
                        console.log('Getting data...');
                        $('.send-loading').show();
                        $('#view-product-group').empty()
                    },
                    success: function(data) {
                        console.log('Success...');
                        $('.send-loading').hide();

                        $('#view_id').val(data.package.id);
                        $('#view_type').val(data.package.type);
                        $('#view_amount').val(data.package.amount);
                        $('#view_referral_amount').val(data.package.referral_amount);
                        $('#view_pv_points').val(data.package.pv_points);
                        $('#view_account_discount').val(data.package.account_discount);

                        $.each(data.package_product, function(i, value) {
                            var row = $(this).closest(".item");
                            var tr_id = $(row).attr('id');

                            var product_counter2 = 0;

                            var newTextBoxDiv = $(document.createElement('tr')).attr(
                                "id", 'product_id' + [i + 1], "class", 'item').attr(
                                "class", 'item');
                            newTextBoxDiv.after().html("<td>" +
                                "<select class='form-control capitalized select_product' id='pr" +
                                [i] + "' name='select_product[]' disabled>" +
                                "<option value=''>Please select</option>" +
                                "@foreach ($products as $product)" +
                                "<option value='{{ $product->id }}'>{{ $product->name }}</option>" +
                                "@endforeach" +
                                "</select>" +
                                "</td>" +
                                "<td>" +
                                "<input type='number' class='form-control qnty amount req_fields' name='product_qty[]' value='" +
                                value.quantity +
                                "' placeholder='Enter Quantity' disabled>" +
                                "</td>" +
                                "</tr>");
                            newTextBoxDiv.appendTo("#view-product-group");
                            $('#pr' + [i]).find('option[value="' + value.product_id +
                                '"]').attr('selected', 'selected');
                        });
                        $('#view-modal').modal('show');

                    },
                    error: function(error) {
                        console.log('Error...');
                        console.log(error);
                        console.log(error.responseJSON.message);
                        $('.send-loading').hide();
                        swal({
                            title: "Error!",
                            text: "Error message: " + error.responseJSON.message + "",
                            type: "error",
                        });
                    }
                });
            });


            $('body').on('click', '.remove-product', function(event) {
                var id = $(this).data('id');
                console.log('remove product clicked ' + id);
                /*if (product_counter > 0) {
                    alert("No more textbox to remove");
                    return false;
                }*/

                product_counter--;

                $("#product_id" + id).remove();

            });
        })
    </script>

@endsection
