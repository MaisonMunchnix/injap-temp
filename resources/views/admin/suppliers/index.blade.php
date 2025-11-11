@extends('layouts.user.master')
@section('title', 'Add Supplier')
@section('page-title', 'Add Supplier')

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
            <div class="row">
                <div class="col-sm-12">
                    <div class="element-wrapper">
                        <h6 class="element-header">Add New Supplier</h6>
                        <br><br>
                        <div class="col-sm-8 col-md-8 col-lg-8 offset-md-2">
                            <div class="element-wrapper">
                                <div class="element-box">
                                    @if (empty($access_data))
                                        <form method="POST" action="" id="add_supplier">
                                        @else
                                            @if ($access_data[0]->supplier[0]->add == 'true')
                                                <form method="POST" action="" id="add_supplier">
                                                @else
                                                    <form method="POST" action="">
                                            @endif
                                    @endif
                                    <div class="element-info">
                                        <div class="element-info-with-icon">
                                            <div class="element-info-icon">
                                                <div class="os-icon os-icon-hierarchy-structure-2"></div>
                                            </div>
                                            <div class="element-info-text">
                                                <h5 class="element-inner-header">New Supplier</h5>
                                                <div class="element-inner-desc">Please fill out all information needed.
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="supplier_name">Supplier Name</label>
                                                <input class="form-control req_fields" id="supplier_name"
                                                    placeholder="Enter Supplier name" required="required" type="text">
                                                <div class="help-block form-text with-errors form-control-feedback"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Supplier Code</label>
                                                <input class="form-control req_fields" id="supplier_code"
                                                    placeholder="Enter Supplier Code" required="required" type="text">
                                                <div class="help-block form-text with-errors form-control-feedback"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <fieldset class="form-group">
                                        <legend><span>Supplier's Information</span></legend>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for=""> First Name</label>
                                                    <input class="form-control req_fields" id="supplier_first_name"
                                                        data-error="Please input your First Name" placeholder="First Name"
                                                        required="required" type="text">
                                                    <div class="help-block form-text with-errors form-control-feedback">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Last Name</label>
                                                    <input class="form-control req_fields" id="supplier_last_name"
                                                        data-error="Please input your Last Name" placeholder="Last Name"
                                                        required="required" type="text">
                                                    <div class="help-block form-text with-errors form-control-feedback">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for=""> Telephone Number</label>
                                                    <input class="form-control req_fields" id="supplier_tel_num"
                                                        data-error="Please input telephone number"
                                                        placeholder="Telephone Number" required="required" type="text">
                                                    <div class="help-block form-text with-errors form-control-feedback">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Mobile Number</label>
                                                    <input class="form-control req_fields" id="supplier_mobile_num"
                                                        data-error="Please input mobile number" placeholder="Mobile Number"
                                                        required="required" type="text">
                                                    <div class="help-block form-text with-errors form-control-feedback">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for=""> Email Address</label>
                                            <input class="form-control req_fields" id="supplier_email"
                                                placeholder="Enter email address" required="required" type="email">
                                            <div class="help-block form-text with-errors form-control-feedback"></div>
                                        </div>

                                        <div class="form-group">
                                            <label> Complete Address</label>
                                            <textarea class="form-control req_fields" id="supplier_addr" placeholder="Complete Address"></textarea>
                                        </div>
                                    </fieldset>

                                    <div class="form-buttons-w">
                                        @if (empty($access_data))
                                            <button class="btn btn-primary" type="submit"> Save</button>
                                        @else
                                            @if ($access_data[0]->supplier[0]->add == 'true')
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
    </div>
    <!-- end content-i -->
@endsection

@section('scripts')
    {{-- additional scripts here --}}
    <!-- Sweetalert -->

    <script src="{{ asset('js/admin/supplier.js') }}"></script>

@endsection
