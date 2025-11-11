@extends('layouts.default.admin.master')
@section('title','Add Branch')
@section('page-title','Add Branch')

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
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="element-wrapper">
                            <h5 class="text-center">Add New Branch</h5>
                            <br><br>
                            <div class="col-sm-8 col-md-8 col-lg-8 offset-md-2">
                                <div class="element-wrapper">
                                    <div class="element-box">
                                        @if(empty($access_data))
                                        <form method="POST" action="" id="add_branch">
                                            @else
                                            @if($access_data[0]->branch[0]->add=='true')
                                            <form method="POST" action="" id="add_branch">
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
                                                                <!-- <h5 class="element-inner-header">New Branch </h5> -->
                                                                <div class="element-inner-desc">Please fill out all information needed.<br><br></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for=""> Select Branch Type</label>
                                                        <select class="form-control req_fields" id="branch_type" required>
                                                            <option value="">Select Type</option>
                                                            <option value="co">Company Owned</option>
                                                            <option value="bo">BO</option>
                                                            <option value="stockist">Stockist</option>
                                                        </select>
                                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for=""> Branch Name</label>
                                                        <input class="form-control req_fields" id="branch_name" placeholder="Enter branch name" required="required" type="text">
                                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label> Branch Address</label>
                                                        <textarea class="form-control req_fields" id="branch_address" required="required" rows="3"></textarea>
                                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                                    </div>

                                                    <fieldset class="form-group">
                                                        <legend><span>Owner's Information</span></legend>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for=""> First Name</label>
                                                                    <input class="form-control req_fields" id="owner_first_name" data-error="Please input your First Name" placeholder="First Name" required="required" type="text">
                                                                    <div class="help-block form-text with-errors form-control-feedback"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="">Last Name</label>
                                                                    <input class="form-control req_fields" id="owner_last_name" data-error="Please input your Last Name" placeholder="Last Name" required="required" type="text">
                                                                    <div class="help-block form-text with-errors form-control-feedback"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for=""> Telephone Number</label>
                                                                    <input class="form-control req_fields" id="owner_tel_num" data-error="Please input telephone number" placeholder="Telephone Number" required="required" type="text">
                                                                    <div class="help-block form-text with-errors form-control-feedback"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="">Mobile Number</label>
                                                                    <input class="form-control req_fields" id="owner_mobile_num" data-error="Please input mobile number" placeholder="Last Name" required="required" type="text">
                                                                    <div class="help-block form-text with-errors form-control-feedback"></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for=""> Email Address</label>
                                                            <input class="form-control req_fields" id="owner_email" placeholder="Enter email address" required="required" type="email">
                                                            <div class="help-block form-text with-errors form-control-feedback"></div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label> Complete Address</label>
                                                            <textarea class="form-control req_fields" id="owner_addr" rows="3"></textarea>
                                                        </div>
                                                    </fieldset>

                                                    <div class="form-buttons-w">
                                                        @if(empty($access_data))
                                                        <button class="btn btn-primary" type="submit"> Save</button>
                                                        @else
                                                        @if($access_data[0]->branch[0]->add=='true')
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

    </div>
</div>
<!-- end content-i -->
@endsection

@section('scripts')
{{-- additional scripts here --}}
<!-- Sweetalert -->

<script src="{{asset('js/admin/branch.js')}}"></script>

@endsection
