@extends('layouts.user.master')
@section('title', 'Profile | Purple Life')
@section('page-title', 'Profile')

@section('stylesheets')
    {{-- additional style here --}}
    <style>
        .border-red {
            border: 1px solid red !important;
        }
    </style>
@endsection

@section('content')
    {{-- content here --}}
    <div class="content-i">
        <div class="content-box">
            <div class="row">
                <div class="col-sm-5">
                    <div class="user-profile compact">
                        <div class="up-head-w"
                            @if (!empty($user_data->profile_picture) && file_exists(public_path($user_data->profile_picture))) style="background-image:url({{ asset($user_data->profile_picture) }}" @else style="background-image:url({{ asset('img/default_image.png') }}" @endif>
                            <div class="up-social"></div>
                            <div class="up-main-info">
                                <h2 class="up-header">
                                    @if (!empty($user_data))
                                        {{ $user_data->first_name }} {{ $user_data->last_name }}
                                    @endif
                                </h2>
                                <h6 class="up-sub-header text-capitalize">
                                    @if (!empty($user_data))
                                        {{ $user_data->package_type }}
                                    @endif Account
                                </h6>
                            </div>
                            <svg class="decor" width="842px" height="219px" viewBox="0 0 842 219"
                                preserveAspectRatio="xMaxYMax meet" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g transform="translate(-381.000000, -362.000000)" fill="#FFFFFF">
                                    <path class="decor-path"
                                        d="M1223,362 L1223,581 L381,581 C868.912802,575.666667 1149.57947,502.666667 1223,362 Z">
                                    </path>
                                </g>
                            </svg>
                        </div>
                        <div class="up-controls">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="value-pair">
                                        <div class="label">Status:</div>
                                        <div class="value badge badge-pill bg-success">Online</div>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-right"><a class="btn btn-primary btn-sm" href="#"
                                        data-toggle="modal" data-target="#change_picture_modal" data-backdrop="static"
                                        data-keyboard="false"><i class="os-icon os-icon-link-3"></i><span>Change
                                            Picture</span></a></div>
                            </div>
                        </div>
                        <div class="up-contents">
                            <div class="m-b">
                                <div class="row m-b">
                                    <div class="col-sm-6 b-r b-b">
                                        <div class="el-tablo centered padded-v">
                                            <div class="value">
                                                @if (!empty($total_referral))
                                                    {{ $total_referral }}
                                                @else
                                                    0
                                                @endif
                                            </div>
                                            <div class="label">Direct Referral</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 b-b">
                                        <div class="el-tablo centered padded-v">
                                            <div class="value">
                                                @if (!empty($user_data))
                                                    {{ $ranking[$user_data->rank] }}
                                                @else
                                                    No rank
                                                @endif
                                            </div>
                                            <div class="label">Rank</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-b">
                                    <div class="col-sm-12 b-b">
                                        <div class="el-tablo centered padded-v">
                                            <div class="value numbers">
                                                @if (!empty($total_income))
                                                    {{ $total_income }}
                                                @else
                                                    0
                                                @endif
                                            </div>
                                            <div class="label">Total Income</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="padded">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="element-wrapper">
                        <div class="element-box">
                            {{-- <form id="formValidate"> --}}
                            <div class="element-info">
                                <div class="element-info-with-icon">
                                    <div class="element-info-icon">
                                        <div class="os-icon os-icon-wallet-loaded"></div>
                                    </div>
                                    <div class="element-info-text">
                                        <h5 class="element-inner-header">Profile Settings</h5>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for=""> Email address</label>
                                <input class="form-control" placeholder="Enter email" type="email"
                                    @if (!empty($user_data)) value="{{ $user_data->email }}" @endif readOnly>
                            </div>
                            <div class="form-group">
                                <label for=""> Username</label>
                                <input class="form-control" placeholder="Enter email" type="text"
                                    @if (!empty($user_data)) value="{{ $user_data->uname }}" @endif readOnly>
                            </div>

                            <div class="form-group">
                                <label for=""> Password</label>
                                <div class="input-group">
                                    <input class="form-control" placeholder="Enter email" type="password"
                                        value="************" readOnly>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" data-toggle="modal"
                                            data-target="#change_passwordModal">
                                            <i class="os-icon os-icon-lock"></i> Change Password
                                        </button>
                                    </div>
                                </div>


                                <fieldset>
                                    <legend><span>Personal Information</span></legend>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for=""> First Name</label>
                                                <input class="form-control" type="text"
                                                    @if (!empty($user_data)) value="{{ $user_data->first_name }}" @endif
                                                    readOnly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Last Name</label>
                                                <input class="form-control" type="text"
                                                    @if (!empty($user_data)) value="{{ $user_data->last_name }}" @endif
                                                    readOnly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for=""> Middle Name</label>
                                                <input class="form-control" type="text"
                                                    @if (!empty($user_data)) value="{{ $user_data->middle_name }}" @endif
                                                    readOnly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Mobile No</label>
                                                <input class="form-control" type="text"
                                                    @if (!empty($user_data)) value="{{ $user_data->mobile_no }}" @endif
                                                    readOnly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for=""> Tel No</label>
                                                <input class="form-control" type="text"
                                                    @if (!empty($user_data)) value="{{ $user_data->tel_no }}" @endif
                                                    readOnly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Gender</label>
                                                <input class="form-control" type="text"
                                                    @if (!empty($user_data)) value="{{ $user_data->gender }}" @endif
                                                    readOnly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for=""> Civil Status</label>
                                                <input class="form-control" type="text"
                                                    @if (!empty($user_data)) value="{{ $user_data->civil_status }}" @endif
                                                    readOnly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Tin No</label>
                                                <input class="form-control" type="text"
                                                    @if (!empty($user_data)) value="{{ $user_data->tin_no }}" @endif
                                                    readOnly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for=""> Beneficiary</label>
                                                <input class="form-control" type="text"
                                                    @if (!empty($user_data)) value="{{ $user_data->beneficiary }}" @endif
                                                    readOnly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for=""> Date of Birth</label>
                                                <input class="form-control" placeholder="Date of birth" type="text"
                                                    @if (!empty($user_data)) value="{{ $user_data->birthdate }}" @endif
                                                    readOnly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for=""> Province</label>
                                                <input class="form-control" type="text"
                                                    @if (!empty($province)) value="{{ $province }}" @endif
                                                    readOnly>

                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">City</label>
                                                <input class="form-control" type="text"
                                                    @if (!empty($city)) value="{{ $city }}" @endif
                                                    readOnly>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for=""> Zip Code</label>
                                                <input class="form-control" type="text"
                                                    @if (!empty($user_data)) value="{{ $user_data->zip_code }}" @endif
                                                    readOnly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label> Complete address</label>
                                        <textarea class="form-control" rows="3" readOnly> @if (!empty($user_data))
{{ $user_data->address }}
@endif
</textarea>
                                    </div>
                                </fieldset>
                                <div class="form-buttons-w">
                                    <button class="btn btn-primary" type="button" data-toggle="modal"
                                        data-target="#update_info_modal" id="btn-show-update-modal"
                                        data-backdrop="static" data-keyboard="false"> <i
                                            class="os-icon os-icon-pencil-2"></i> Update Infos</button>
                                </div>
                                <!--</form>-->

                            </div>
                        </div>

                    </div>

                    @include('user.customizer')
                    @include('user.profile.update_info_modal')
                    @include('user.profile.change_password_modal')

                    @include('user.profile.change_picture_modal')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- additional scripts here --}}
    <script src="{{ asset('js/user/member-profile.js') }}"></script>
@endsection
